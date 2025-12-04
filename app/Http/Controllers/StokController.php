<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\OrderItem;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index()
    {
        $bahanBakuStok = BahanBaku::select(
            'bahan_bakus.id',
            'bahan_bakus.nama',
            'bahan_bakus.kategori',
            'bahan_bakus.merek',
            'bahan_bakus.satuan',
            'bahan_bakus.gov_price',
            'bahan_bakus.kelompok',
            'bahan_bakus.jenis',
            'bahan_bakus.ukuran',
            'bahan_bakus.created_at',
            'bahan_bakus.updated_at',
            'bahan_bakus.deleted_at'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_bakus.id', '=', 'order_items.bahan_baku_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy(
                'bahan_bakus.id',
                'bahan_bakus.nama',
                'bahan_bakus.kategori',
                'bahan_bakus.merek',
                'bahan_bakus.satuan',
                'bahan_bakus.gov_price',
                'bahan_bakus.kelompok',
                'bahan_bakus.jenis',
                'bahan_bakus.ukuran',
                'bahan_bakus.created_at',
                'bahan_bakus.updated_at',
                'bahan_bakus.deleted_at'
            )
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_baku');
            });

        // Replace the BahanOperasional query
        $bahanOperasionalStok = BahanOperasional::select(
            'bahan_operasionals.id',
            'bahan_operasionals.nama',
            'bahan_operasionals.kategori',
            'bahan_operasionals.merek',
            'bahan_operasionals.satuan',
            'bahan_operasionals.gov_price',
            'bahan_operasionals.created_at',
            'bahan_operasionals.updated_at',
            'bahan_operasionals.deleted_at'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_operasionals.id', '=', 'order_items.bahan_operasional_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy(
                'bahan_operasionals.id',
                'bahan_operasionals.nama',
                'bahan_operasionals.kategori',
                'bahan_operasionals.merek',
                'bahan_operasionals.satuan',
                'bahan_operasionals.gov_price',
                'bahan_operasionals.created_at',
                'bahan_operasionals.updated_at',
                'bahan_operasionals.deleted_at'
            )
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_operasional');
            });

        // Merge both collections
        $stok = $bahanBakuStok->merge($bahanOperasionalStok);

        return view('stok.index', compact('stok'));
    }

    private function calculateStockData($item, $type)
    {
        $columnName = $type === 'bahan_baku' ? 'bahan_baku_id' : 'bahan_operasional_id';

        // Get all order items for this material
        $orderItems = OrderItem::whereHas('order', function ($query) {
            // $query->where('status', 'posted');
        })
            ->where($columnName, $item->id)
            ->where('quantity_diterima', true)
            ->get();

        // Calculate totals from order items
        $totalQty = $orderItems->sum('quantity');

        // Get stock adjustments
        $adjustments = StockAdjustment::where($columnName, $item->id)->sum('quantity');

        // Total quantity = order items + adjustments
        $totalQty += $adjustments;

        $lastPurchasePrice = $orderItems->sortByDesc('created_at')->first()?->unit_cost ?? 0;

        // Calculate average cost: total purchase value / total quantity from orders only
        $totalPurchaseValue = $orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_cost;
        });
        $avgCost = $orderItems->sum('quantity') > 0 ? $totalPurchaseValue / $orderItems->sum('quantity') : 0;

        // Get kategori value
        $kategori = '-';
        if ($type === 'bahan_baku') {
            $kategori = is_array($item->kategori) ? implode(', ', $item->kategori) : ($item->kategori ?? '-');
        } else {
            $kategori = is_array($item->kategori) ? implode(', ', $item->kategori) : ($item->kategori ?? '-');
        }

        return (object) [
            'id' => $item->id,
            // 'sku' => 'PRD-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
            'nama' => $item->nama,
            'kategori' => $kategori,
            'merek' => $item->merek ?? '-',
            'satuan' => $item->satuan ?? '-',
            'qty' => $totalQty,
            'last_purchase_price' => $lastPurchasePrice,
            'avg_cost' => $avgCost,
            'gov_price' => $item->gov_price ?? 0,
            'type' => $type,
        ];
    }

    public function show($bahanId, $type)
    {
        $bahan = $type === 'bahan_baku'
            ? BahanBaku::find($bahanId)
            : BahanOperasional::find($bahanId);

        if (!$bahan) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $bahan->load('activities');
        return response()->json($bahan);
    }

    public function kartu(Request $request)
    {
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

        //TODO untuk stok keluar harga satuan dari harga terakhir (sekarang default 0)
        return view('stok.kartu', [
            'bahans' => $bahans,
        ]);
    }

    public function getKartuData(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required',
            'type' => 'required|in:bahan_baku,bahan_operasional'
        ]);

        $bahanId = $request->bahan_id;
        $type = $request->type;
        $columnName = $type === 'bahan_baku' ? 'bahan_baku_id' : 'bahan_operasional_id';

        // Get bahan info
        $bahan = $type === 'bahan_baku'
            ? BahanBaku::find($bahanId)
            : BahanOperasional::find($bahanId);

        if (!$bahan) {
            return response()->json(['error' => 'Bahan tidak ditemukan'], 404);
        }

        // Get order items
        $orderItems = OrderItem::with('order')
            ->whereHas('order', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereNotNull('tanggal_penerimaan');
            })
            ->where($columnName, $bahanId)
            ->where('quantity_diterima', true)
            ->whereNull('deleted_at')
            ->get();

        // Get stock adjustments
        $adjustments = StockAdjustment::where($columnName, $bahanId)
            ->whereNull('deleted_at')
            ->get();

        // Combine and sort all transactions
        $allTransactions = collect();

        foreach ($orderItems as $item) {
            $allTransactions->push([
                'date' => $item->order->tanggal_penerimaan,
                'type' => 'order',
                'data' => $item
            ]);
        }

        foreach ($adjustments as $adj) {
            $allTransactions->push([
                'date' => $adj->adjustment_date,
                'type' => 'adjustment',
                'data' => $adj
            ]);
        }

        $allTransactions = $allTransactions->sortBy(function ($item) {
            return $item['date']->timestamp;
        });

        // Build result
        $result = [];
        $runningStock = 0;
        $lastKnownPrice = 0; // Track last purchase price

        foreach ($allTransactions as $transaction) {
            if ($transaction['type'] === 'order') {
                $item = $transaction['data'];
                $date = $item->order->tanggal_penerimaan->format('Y-m-d');
                $masuk = $item->quantity > 0 ? $item->quantity : 0;
                $keluar = $item->quantity < 0 ? abs($item->quantity) : 0;
                $stokAkhir = $runningStock + $masuk - $keluar;
                $nilai = $stokAkhir * $item->unit_cost;

                // Update last known price from orders
                $lastKnownPrice = $item->unit_cost;

                $result[] = [
                    'tanggal' => $date,
                    'stok_awal' => $runningStock,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'stok_akhir' => $stokAkhir,
                    'harga' => $item->unit_cost,
                    'nilai' => $nilai,
                    'keterangan' => $item->order->order_number ?? ''
                ];

                $runningStock = $stokAkhir;
            } else {
                $adj = $transaction['data'];
                $date = $adj->adjustment_date->format('Y-m-d');
                $masuk = $adj->quantity > 0 ? $adj->quantity : 0;
                $keluar = $adj->quantity < 0 ? abs($adj->quantity) : 0;
                $stokAkhir = $runningStock + $masuk - $keluar;

                // Use last known price for adjustment value
                $nilai = $stokAkhir * $lastKnownPrice;

                $result[] = [
                    'tanggal' => $date,
                    'stok_awal' => $runningStock,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'stok_akhir' => $stokAkhir,
                    'harga' => $lastKnownPrice, // Use last known price instead of 0
                    'nilai' => $nilai, // Calculate value based on last known price
                    'keterangan' => 'Penyesuaian Stok: ' . ($adj->keterangan ?? '-')
                ];

                $runningStock = $stokAkhir;
            }
        }

        return response()->json([
            'bahan' => [
                'id' => $bahan->id,
                'nama' => $bahan->nama,
                'satuan' => $bahan->satuan
            ],
            'transactions' => $result
        ]);
    }

    public function opname(Request $request)
    {
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'satuan']);
        $bahanoperasionals = BahanOperasional::orderBy('nama')->get(['id', 'nama', 'satuan']);

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

        return view('stok.opname', [
            'bahans' => $bahans,
        ]);
    }

    public function getOpnameData(Request $request)
    {
        $bahanBakuStok = BahanBaku::select(
            'bahan_bakus.id',
            'bahan_bakus.nama',
            'bahan_bakus.satuan'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_bakus.id', '=', 'order_items.bahan_baku_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy('bahan_bakus.id', 'bahan_bakus.nama', 'bahan_bakus.satuan')
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_baku');
            })
            ->filter(function ($item) {
                return $item->qty > 0;
            });

        $bahanOperasionalStok = BahanOperasional::select(
            'bahan_operasionals.id',
            'bahan_operasionals.nama',
            'bahan_operasionals.satuan'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_operasionals.id', '=', 'order_items.bahan_operasional_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy('bahan_operasionals.id', 'bahan_operasionals.nama', 'bahan_operasionals.satuan')
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_operasional');
            })
            ->filter(function ($item) {
                return $item->qty > 0;
            });

        $stok = $bahanBakuStok->merge($bahanOperasionalStok);

        return response()->json([
            'stok' => $stok->values()
        ]);
    }

    public function saveOpname(Request $request)
    {
        $request->validate([
            'adjustment_date' => 'required|date',
            'items' => 'required|array',
            'items.*.bahan_id' => 'required',
            'items.*.type' => 'required|in:bahan_baku,bahan_operasional',
            'items.*.selisih' => 'required|numeric',
            'items.*.keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->items as $item) {
                if ($item['selisih'] != 0) {
                    $columnName = $item['type'] === 'bahan_baku' ? 'bahan_baku_id' : 'bahan_operasional_id';

                    StockAdjustment::create([
                        'adjustment_date' => $request->adjustment_date,
                        $columnName => $item['bahan_id'],
                        'quantity' => $item['selisih'],
                        'keterangan' => $item['keterangan'],
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Stok opname berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }
}
