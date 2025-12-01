<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\RencanaMenu;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['supplier', 'items.bahanBaku', 'items.bahanOperasional', 'transaction.activities'])->latest()->get();
        $title = 'Purchase Order';
        // dd($orders?->toArray());
        return view('order.index', compact('orders', 'title'));
    }

    public function create()
    {
        $rencanaMenus = RencanaMenu::with(['paketMenu.menus.bahanBakus'])
            ->orderBy('start_date', 'desc')
            ->get();

        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'satuan']);
        $bahanoperasionals = BahanOperasional::orderBy('nama')->get(['id', 'nama', 'satuan']);

        // Combine both with type identifier
        $bahans = $bahanbakus->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'satuan' => $item->satuan,
                'type' => 'bahan_baku'
            ];
        })->merge($bahanoperasionals->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'satuan' => $item->satuan,
                'type' => 'bahan_operasional'
            ];
        }));

        $suppliers = Supplier::orderBy('nama')->get(['id', 'nama']);
        $title = 'Tambah Purchase Order';

        return view('order.create', [
            'bahans' => $bahans,
            'suppliers' => $suppliers,
            'rencanaMenus' => $rencanaMenus,
            'title' => $title,
        ]);
    }

    public function addMenuItems(Request $request)
    {
        $request->validate([
            'rencana_menu_id' => 'required|exists:rencana_menus,id',
        ]);

        $rencanaMenu = RencanaMenu::with(['paketMenu.menus.bahanBakus'])
            ->findOrFail($request->rencana_menu_id);

        $items = [];

        foreach ($rencanaMenu->paketMenu as $paket) {
            $porsi = $paket->pivot->porsi;

            foreach ($paket->menus as $menu) {
                // Get bahan bakus with their berat_bersih from bahan_baku_menu pivot table
                $bahanBakusWithWeight = DB::table('bahan_baku_menu')
                    ->where('paket_menu_id', $paket->id)
                    ->where('menu_id', $menu->id)
                    ->get();

                foreach ($bahanBakusWithWeight as $pivotData) {
                    $bahanBaku = BahanBaku::find($pivotData->bahan_baku_id);

                    if ($bahanBaku) {
                        $beratBersih = (float) $pivotData->berat_bersih ?? 0;
                        $totalQuantity = ($porsi * $beratBersih);

                        $items[] = [
                            'bahan_baku_id' => $bahanBaku->id,
                            'nama' => $bahanBaku->nama,
                            'quantity' => $totalQuantity,
                            'prosi' => $porsi,
                            'berat_bersih' => $beratBersih,
                            'satuan' => $bahanBaku->satuan,
                        ];
                    }
                }
            }
        }

        // Group by bahan_baku_id and sum quantities
        $groupedItems = [];
        foreach ($items as $item) {
            $id = $item['bahan_baku_id'];
            if (isset($groupedItems[$id])) {
                $groupedItems[$id]['quantity'] += $item['quantity'];
            } else {
                $groupedItems[$id] = $item;
            }
        }

        return response()->json([
            'success' => true,
            'items' => array_values($groupedItems)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_po' => 'required|date',
            'tanggal_penerimaan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.bahan_id' => 'required',
            'items.*.type' => 'required|in:bahan_baku,bahan_operasional',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $supplier = Supplier::find($request->supplier_id);

            $year = date('Y');
            $month = date('n');
            $romanMonth = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII'
            ][$month];

            $latestOrder = Order::where('order_number', 'like', "PO/{$year}/{$romanMonth}/%")
                ->latest()
                ->first();

            $number = $latestOrder ? (int)substr($latestOrder->order_number, -3) + 1 : 1;
            $orderNumber = 'PO/' . $year . '/' . $romanMonth . '/' . str_pad($number, 3, '0', STR_PAD_LEFT);

            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += $item['quantity'] * $item['unit_cost'];
            }

            $order = Order::create([
                'order_number' => $orderNumber,
                'supplier_id' => $request->supplier_id,
                'tanggal_po' => $request->tanggal_po,
                'tanggal_penerimaan' => $request->tanggal_penerimaan,
                'grand_total' => $grandTotal,
                'status' => 'draft',
            ]);

            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $order->items()->create([
                    'bahan_baku_id' => $item['type'] === 'bahan_baku' ? $item['bahan_id'] : null,
                    'bahan_operasional_id' => $item['type'] === 'bahan_operasional' ? $item['bahan_id'] : null,
                    'quantity' => $item['quantity'],
                    'satuan' => $item['satuan'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);
            }

            Transaction::create([
                'order_id' => $order->id,
                'payment_date' => null,
                'payment_method' => 'bank_transfer',
                'payment_reference' => $supplier->bank_no_rek . '-' . $supplier->bank_nama ?? 'TRX-' . now(),
                // 'amount' => $grandTotal,
                'amount' => 0,
                'status' => 'unpaid',
                'notes' => null,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order)
    {
        $transaction = $order->transaction;
        // dd([
        //     'bukti_transfer' => Activity::forSubject($transaction)->get()?->toArray(),
        //     'transaction' => $transaction->activities?->pluck('properties')->toArray()
        // ]);

        $order->load(['supplier', 'items.bahanBaku', 'items.bahanOperasional', 'transaction.activities']);
        return $order->toArray();
    }

    public function edit(Order $order)
    {
        $order->load(['items.bahanBaku', 'items.bahanOperasional', 'transaction']);
        $rencanaMenus = RencanaMenu::with(['paketMenu.menus.bahanBakus'])
            ->orderBy('start_date', 'desc')
            ->get();

        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'satuan']);
        $bahanoperasionals = BahanOperasional::orderBy('nama')->get(['id', 'nama', 'satuan']);

        // Combine both with type identifier
        $bahans = $bahanbakus->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'satuan' => $item->satuan,
                'type' => 'bahan_baku'
            ];
        })->merge($bahanoperasionals->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'satuan' => $item->satuan,
                'type' => 'bahan_operasional'
            ];
        }));

        $suppliers = Supplier::orderBy('nama')->get(['id', 'nama']);
        $title = 'Edit Purchase Order';
        return view('order.edit', [
            'order' => $order,
            'bahans' => $bahans,
            'suppliers' => $suppliers,
            'rencanaMenus' => $rencanaMenus,
            'title' => $title,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_po' => 'required|date',
            'tanggal_penerimaan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.bahan_id' => 'required',
            'items.*.type' => 'required|in:bahan_baku,bahan_operasional',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += $item['quantity'] * $item['unit_cost'];
            }

            $order->update([
                'supplier_id' => $request->supplier_id,
                'tanggal_po' => $request->tanggal_po,
                'tanggal_penerimaan' => $request->tanggal_penerimaan,
                'grand_total' => $grandTotal,
            ]);

            // Delete existing items
            $order->items()->delete();

            // Create new items
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $order->items()->create([
                    'bahan_baku_id' => $item['type'] === 'bahan_baku' ? $item['bahan_id'] : null,
                    'bahan_operasional_id' => $item['type'] === 'bahan_operasional' ? $item['bahan_id'] : null,
                    'quantity' => $item['quantity'],
                    'satuan' => $item['satuan'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);
            }

            // Update transaction amount if exists
            if ($order->transaction) {
                $order->transaction->update([
                    'amount' => $grandTotal,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function UpdateToPost(Order $order)
    {
        $order->update(['status' => 'posted']);

        return response()->json([
            'message' => 'Order berhasil diposting'
        ]);
    }


    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            if ($order->transaction->rekeningRekapBKU->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order tidak dapat dihapus karena sudah memiliki transaksi pembayaran'
                ], 422);
            }

            $order->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    //Penerimaan
    public function penerimaanIndex()
    {
        $orders = Order::with(['supplier', 'items.bahanBaku', 'items.bahanOperasional', 'transaction'])
            ->latest()
            ->get();

        $title = 'Penerimaan Barang';
        return view('order.penerimaan.index', compact('orders', 'title'));
    }

    public function editPenerimaan(Order $order)
    {
        $order->load(['supplier', 'items.bahanBaku', 'items.bahanOperasional',]);
        $title = 'Edit Penerimaan Barang';
        return view('order.penerimaan.edit', compact('order', 'title'));
    }

    public function updatePenerimaan(Request $request, Order $order)
    {
        $request->validate([
            'status_penerimaan' => 'required|in:draft,confirmed',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:order_items,id',
            'items.*.quantity_diterima' => 'required|boolean',
            'items.*.notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $order->update([
                'status_penerimaan' => $request->status_penerimaan,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $itemData) {
                $order->items()->where('id', $itemData['id'])->update([
                    'quantity_diterima' => $itemData['quantity_diterima'],
                    'notes' => $itemData['notes'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Penerimaan Barang berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    //Pembayaran
    public function pembayaranIndex()
    {
        $orders = Order::with(['supplier', 'items.bahanBaku', 'items.bahanOperasional', 'transaction'])
            ->latest()
            ->get();

        $title = 'Pembayaran';
        return view('order.pembayaran.index', compact('orders', 'title'));
    }

    public function editPembayaran(Order $order)
    {
        $order->load(['supplier', 'items.bahanBaku', 'items.bahanOperasional', 'transaction']);
        $title = 'Edit Pembayaran';

        $paymentHistory = $order->transaction?->payment_history ?? [];

        return view('order.pembayaran.edit', compact('order', 'title', 'paymentHistory'));
    }

    public function updatePembayaran(Request $request, Order $order)
    {
        $currentAmount = $order->transaction?->amount ?? 0;
        $maxAmount = $order->grand_total - $currentAmount;

        $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,giro_cek,lainnya',
            'payment_reference' => 'nullable|string',
            'amount' => 'required|numeric|min:0|max:' . $maxAmount,
            'notes' => 'nullable|string',
            'status' => 'required|in:unpaid,paid,partial',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $previousAmount = $order->transaction?->amount ?? 0;
            $newTotalAmount = $previousAmount + $request->amount;

            // Handle file upload
            $buktiPath = null;
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $filename = 'bukti_' . time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();
                $buktiPath = $file->storeAs('bukti_transfer', $filename, 'uploads');
            }

            if ($order->transaction) {
                // Update existing transaction
                $paymentHistory = $order->transaction->payment_history ?? [];

                // Add new payment to history if amount > 0 (record all payments)
                if ($request->amount > 0) {
                    $paymentHistory[] = [
                        'payment_date' => $request->payment_date,
                        'amount' => $request->amount,
                        'payment_method' => $request->payment_method,
                        'payment_reference' => $request->payment_reference,
                        'bukti_transfer' => $buktiPath ?? $order->transaction->bukti_transfer,
                        'notes' => $request->notes,
                        'created_at' => now()->toDateTimeString(),
                    ];
                }

                $transactionData = [
                    'payment_date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'payment_reference' => $request->payment_reference,
                    'amount' => $newTotalAmount,
                    'payment_history' => $paymentHistory,
                    'notes' => $request->notes,
                    'status' => $request->status,
                ];

                if ($buktiPath) {
                    $transactionData['bukti_transfer'] = $buktiPath;
                }

                $order->transaction->update($transactionData);
                $transaction = $order->transaction;
            } else {
                // Create new transaction
                $paymentHistory = [];
                if ($request->amount > 0) {
                    $paymentHistory[] = [
                        'payment_date' => $request->payment_date,
                        'amount' => $request->amount,
                        'payment_method' => $request->payment_method,
                        'payment_reference' => $request->payment_reference,
                        'bukti_transfer' => $buktiPath,
                        'notes' => $request->notes,
                        'created_at' => now()->toDateTimeString(),
                    ];
                }

                $transactionData = [
                    'payment_date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'payment_reference' => $request->payment_reference,
                    'amount' => $request->amount,
                    'payment_history' => $paymentHistory,
                    'notes' => $request->notes,
                    'status' => $request->status,
                ];

                if ($buktiPath) {
                    $transactionData['bukti_transfer'] = $buktiPath;
                }

                $transaction = $order->transaction()->create($transactionData);
            }

            $this->createOrUpdateRekeningRekapBKU($transaction, $order);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function createOrUpdateRekeningKoranVa($transaction, $order)
    {
        DB::beginTransaction();
        try {
            // Prepare common data
            $uraian = "Deposit PO {$order->order_number} - {$order->supplier->nama}";
            $tanggal = $transaction->payment_date;
            $debit = 0;
            $kredit = $transaction->amount;

            // If there's an existing linked RekeningKoranVa, lock it
            $existing = $transaction->rekeningKoranVa ? \App\Models\RekeningKoranVa::lockForUpdate()->find($transaction->rekeningKoranVa->id) : null;

            if ($existing) {
                // Find previous entry relative to the (possibly updated) tanggal and excluding current record
                $prevEntry = \App\Models\RekeningKoranVa::where(function ($q) use ($tanggal, $existing) {
                    $q->where('tanggal_transaksi', '<', $tanggal)
                        ->orWhere(function ($q2) use ($tanggal, $existing) {
                            $q2->where('tanggal_transaksi', '=', $tanggal)
                                ->where('id', '<', $existing->id);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'desc')
                    ->orderBy('id', 'desc')
                    ->lockForUpdate()
                    ->first();

                $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;

                // New saldo for this record (payment = kredit => saldo increases)
                $newSaldoForCurrent = $prevSaldo - $debit + $kredit;

                $rekeningData = [
                    'tanggal_transaksi' => $tanggal,
                    'ref' => 'PEMBAYARAN',
                    'uraian' => $uraian,
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'saldo' => $newSaldoForCurrent,
                    'kategori_transaksi' => 'Deposit PO',
                    'minggu' => null,
                ];

                // Update existing record
                $existing->update($rekeningData);

                // Recalculate subsequent entries (those after the current record in ordering)
                $nextEntries = \App\Models\RekeningKoranVa::where(function ($q) use ($existing) {
                    $q->where('tanggal_transaksi', '>', $existing->tanggal_transaksi)
                        ->orWhere(function ($q2) use ($existing) {
                            $q2->where('tanggal_transaksi', '=', $existing->tanggal_transaksi)
                                ->where('id', '>', $existing->id);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'asc')
                    ->orderBy('id', 'asc')
                    ->lockForUpdate()
                    ->get();

                $currentSaldo = $existing->saldo;
                foreach ($nextEntries as $entry) {
                    $currentSaldo = $currentSaldo - $entry->debit + $entry->kredit;
                    $entry->update(['saldo' => $currentSaldo]);
                }
            } else {
                // CREATE CASE
                // Find previous entry relative to new tanggal
                $prevEntry = \App\Models\RekeningKoranVa::where(function ($q) use ($tanggal) {
                    $q->where('tanggal_transaksi', '<', $tanggal)
                        ->orWhere(function ($q2) use ($tanggal) {
                            $q2->where('tanggal_transaksi', '=', $tanggal)
                                ->where('id', '<', PHP_INT_MAX); // no current id, so take any smaller id
                        });
                })
                    ->orderBy('tanggal_transaksi', 'desc')
                    ->orderBy('id', 'desc')
                    ->lockForUpdate()
                    ->first();

                $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;

                $newSaldo = $prevSaldo - $debit + $kredit;

                $rekeningData = [
                    'tanggal_transaksi' => $tanggal,
                    'ref' => 'DEPOSIT',
                    'uraian' => $uraian,
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'saldo' => $newSaldo,
                    'kategori_transaksi' => 'Deposit PO',
                    'minggu' => null,
                    'transaction_id' => $transaction->id,
                ];

                $created = \App\Models\RekeningKoranVa::create($rekeningData);

                // Recalculate subsequent entries (those after the newly created record)
                $nextEntries = \App\Models\RekeningKoranVa::where(function ($q) use ($created) {
                    $q->where('tanggal_transaksi', '>', $created->tanggal_transaksi)
                        ->orWhere(function ($q2) use ($created) {
                            $q2->where('tanggal_transaksi', '=', $created->tanggal_transaksi)
                                ->where('id', '>', $created->id);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'asc')
                    ->orderBy('id', 'asc')
                    ->lockForUpdate()
                    ->get();

                $currentSaldo = $created->saldo;
                foreach ($nextEntries as $entry) {
                    $currentSaldo = $currentSaldo - $entry->debit + $entry->kredit;
                    $entry->update(['saldo' => $currentSaldo]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createOrUpdateRekeningRekapBKU($transaction, $order)
    {
        DB::beginTransaction();
        try {
            // Prepare common data
            $uraian = "Pembayaran PO {$order->order_number} - {$order->supplier->nama}";
            $tanggal = $transaction->payment_date;
            $debit = 0;
            $kredit = $transaction->amount;

            // If there's an existing linked RekeningRekapBKU, lock it
            $existing = $transaction->rekeningRekapBKU ? \App\Models\RekeningRekapBKU::lockForUpdate()->find($transaction->rekeningRekapBKU->id) : null;

            if ($existing) {
                // Find previous entry relative to the (possibly updated) tanggal and excluding current record
                $prevEntry = \App\Models\RekeningRekapBKU::where(function ($q) use ($tanggal, $existing) {
                    $q->where('tanggal_transaksi', '<', $tanggal)
                        ->orWhere(function ($q2) use ($tanggal, $existing) {
                            $q2->where('tanggal_transaksi', '=', $tanggal)
                                ->where('id', '<', $existing->id);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'desc')
                    ->orderBy('id', 'desc')
                    ->lockForUpdate()
                    ->first();

                $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;

                // New saldo for this record (payment = kredit => saldo decreases)
                $newSaldoForCurrent = $prevSaldo + $debit - $kredit;

                $rekeningData = [
                    'tanggal_transaksi' => $tanggal,
                    'no_bukti' => $transaction->payment_reference,
                    'link_bukti' => $transaction->bukti_transfer,
                    'jenis_bahan' => null,
                    'nama_bahan' => null,
                    'kuantitas' => null,
                    'satuan' => null,
                    'supplier' => $order->supplier->nama,
                    'uraian' => $uraian,
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'saldo' => $newSaldoForCurrent,
                    'bulan' => date('n', strtotime($tanggal)),
                    'minggu' => null,
                ];

                // Update existing record
                $existing->update($rekeningData);

                // Recalculate subsequent entries (those after the current record in ordering)
                $nextEntries = \App\Models\RekeningRekapBKU::where(function ($q) use ($existing) {
                    $q->where('tanggal_transaksi', '>', $existing->tanggal_transaksi)
                        ->orWhere(function ($q2) use ($existing) {
                            $q2->where('tanggal_transaksi', '=', $existing->tanggal_transaksi)
                                ->where('id', '>', $existing->id);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'asc')
                    ->orderBy('id', 'asc')
                    ->lockForUpdate()
                    ->get();

                $currentSaldo = $existing->saldo;
                foreach ($nextEntries as $entry) {
                    $currentSaldo = $currentSaldo + $entry->debit - $entry->kredit;
                    $entry->update(['saldo' => $currentSaldo]);
                }
            } else {
                // CREATE CASE
                // Find previous entry relative to new tanggal
                $prevEntry = \App\Models\RekeningRekapBKU::where(function ($q) use ($tanggal) {
                    $q->where('tanggal_transaksi', '<', $tanggal)
                        ->orWhere(function ($q2) use ($tanggal) {
                            $q2->where('tanggal_transaksi', '=', $tanggal)
                                ->where('id', '<', PHP_INT_MAX);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'desc')
                    ->orderBy('id', 'desc')
                    ->lockForUpdate()
                    ->first();

                $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;

                $newSaldo = $prevSaldo + $debit - $kredit;

                $rekeningData = [
                    'tanggal_transaksi' => $tanggal,
                    'no_bukti' => $transaction->payment_reference,
                    'link_bukti' => $transaction->bukti_transfer,
                    'jenis_bahan' => null,
                    'nama_bahan' => null,
                    'kuantitas' => null,
                    'satuan' => null,
                    'supplier' => $order->supplier->nama,
                    'uraian' => $uraian,
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'saldo' => $newSaldo,
                    'bulan' => date('n', strtotime($tanggal)),
                    'minggu' => null,
                    'transaction_id' => $transaction->id,
                ];

                $created = \App\Models\RekeningRekapBKU::create($rekeningData);

                // Recalculate subsequent entries (those after the newly created record)
                $nextEntries = \App\Models\RekeningRekapBKU::where(function ($q) use ($created) {
                    $q->where('tanggal_transaksi', '>', $created->tanggal_transaksi)
                        ->orWhere(function ($q2) use ($created) {
                            $q2->where('tanggal_transaksi', '=', $created->tanggal_transaksi)
                                ->where('id', '>', $created->id);
                        });
                })
                    ->orderBy('tanggal_transaksi', 'asc')
                    ->orderBy('id', 'asc')
                    ->lockForUpdate()
                    ->get();

                $currentSaldo = $created->saldo;
                foreach ($nextEntries as $entry) {
                    $currentSaldo = $currentSaldo + $entry->debit - $entry->kredit;
                    $entry->update(['saldo' => $currentSaldo]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
