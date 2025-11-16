<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\BahanBaku;
use App\Models\RencanaMenu;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['supplier', 'items.bahanBaku', 'transaction'])->latest()->get();
        $title = 'Purchase Order';
        // dd($orders?->toArray());
        return view('order.index', compact('orders', 'title'));
    }

    public function create()
    {
        $rencanaMenus = RencanaMenu::with(['paketMenu.menus.bahanBakus'])->get(['start_date']);
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'satuan']);
        $suppliers = Supplier::orderBy('nama')->get(['id', 'nama']);
        $title = 'Tambah Purchase Order';
        return view('order.create', compact('bahanbakus', 'suppliers', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_po' => 'required|date',
            'tanggal_penerimaan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate order number
            $latestOrder = Order::latest()->first();
            $number = $latestOrder ? (int)substr($latestOrder->order_number, 2) + 1 : 1;
            $orderNumber = 'PO' . str_pad($number, 3, '0', STR_PAD_LEFT);

            // Calculate grand total
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

            // Create order items
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $order->items()->create([
                    'bahan_baku_id' => $item['bahan_baku_id'],
                    'quantity' => $item['quantity'],
                    'satuan' => $item['satuan'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);
            }

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
        $order->load(['supplier', 'items.bahanBaku', 'transaction']);
        return $order->toArray();
    }

    public function edit(Order $order)
    {
        $order->load(['items.bahanBaku']);
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'satuan']);
        $suppliers = Supplier::orderBy('nama')->get(['id', 'nama']);
        $title = 'Edit Purchase Order';
        return view('order.edit', compact('order', 'bahanbakus', 'suppliers', 'title'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_po' => 'required|date',
            'tanggal_penerimaan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate grand total
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

            // Delete old items and create new ones
            $order->items()->delete();
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $order->items()->create([
                    'bahan_baku_id' => $item['bahan_baku_id'],
                    'quantity' => $item['quantity'],
                    'satuan' => $item['satuan'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
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

    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            // if ($order->transaction->exists() > 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Order tidak dapat dihapus karena sudah memiliki transaksi pembayaran'
            //     ], 422);
            // }

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
        $orders = Order::with(['supplier', 'items.bahanBaku'])
            ->whereNotNull('tanggal_penerimaan')
            ->latest()
            ->get();

        $title = 'Penerimaan Barang';
        return view('order.penerimaan.index', compact('orders', 'title'));
    }

    public function editPenerimaan(Order $order)
    {
        $order->load(['supplier', 'items.bahanBaku']);
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
        $orders = Order::with(['supplier', 'items.bahanBaku', 'transaction'])
            ->latest()
            ->get();

        $title = 'Pembayaran';
        return view('order.pembayaran.index', compact('orders', 'title'));
    }

    public function editPembayaran(Order $order)
    {
        $order->load(['supplier', 'items.bahanBaku', 'transaction']);
        $title = 'Edit Pembayaran';
        return view('order.pembayaran.edit', compact('order', 'title'));
    }

    public function updatePembayaran(Request $request, Order $order)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,giro_cek,lainnya',
            'payment_reference' => 'nullable|string',
            'amount' => 'required|numeric|min:0|max:' . $order->grand_total,
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            if ($order->transaction) {
                $order->transaction->update([
                    'payment_date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'payment_reference' => $request->payment_reference,
                    'amount' => $request->amount,
                    'notes' => $request->notes,
                ]);
            } else {
                $order->transaction()->create([
                    'payment_date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'payment_reference' => $request->payment_reference,
                    'amount' => $request->amount,
                    'notes' => $request->notes,
                ]);
            }

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
}