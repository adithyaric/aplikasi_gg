<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index()
    {
        // Get Bahan Baku with stock calculations
        $bahanBakuStok = BahanBaku::whereHas('orderItems')->select('bahan_bakus.*')
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_bakus.id', '=', 'order_items.bahan_baku_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    // ->where('orders.status', 'posted')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy('bahan_bakus.id')
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_baku');
            });

        // Get Bahan Operasional with stock calculations
        $bahanOperasionalStok = BahanOperasional::whereHas('orderItems')->select('bahan_operasionals.*')
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_operasionals.id', '=', 'order_items.bahan_operasional_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    // ->where('orders.status', 'posted')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy('bahan_operasionals.id')
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
            ->get();

        // Calculate totals
        $totalQty = $orderItems->sum('quantity');
        $lastPurchasePrice = $orderItems->sortByDesc('created_at')->first()?->unit_cost ?? 0;
        $avgCost = $orderItems->avg('unit_cost') ?? 0;

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
}
