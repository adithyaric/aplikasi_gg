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
        $bahanBakuStok = BahanBaku::whereHas('orderItems', function ($query) {
            $query->where('quantity_diterima', true);
        })
            ->select(
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
        $bahanOperasionalStok = BahanOperasional::whereHas('orderItems', function ($query) {
            $query->where('quantity_diterima', true);
        })
            ->select(
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

        // Calculate totals
        $totalQty = $orderItems->sum('quantity');
        $lastPurchasePrice = $orderItems->sortByDesc('created_at')->first()?->unit_cost ?? 0;

        // Calculate average cost: total purchase value / total quantity
        $totalPurchaseValue = $orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_cost;
        });
        $avgCost = $totalQty > 0 ? $totalPurchaseValue / $totalQty : 0;

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

        // Get all order items with orders
        $orderItems = OrderItem::with('order')
            ->whereHas('order', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where($columnName, $bahanId)
            ->where('quantity_diterima', true)
            ->whereNull('deleted_at')
            ->orderBy('created_at')
            ->get();

        // Group by date and calculate daily transactions
        $transactions = [];
        $runningStock = 0;

        foreach ($orderItems as $item) {
            $date = $item->created_at->format('Y-m-d');

            if (!isset($transactions[$date])) {
                $transactions[$date] = [
                    'tanggal' => $date,
                    'stok_awal' => $runningStock,
                    'masuk' => 0,
                    'keluar' => 0,
                    'harga' => $item->unit_cost,
                    'keterangan' => ''
                ];
            }

            // Assuming positive quantity is "masuk" (purchase)
            // If you have a field to distinguish masuk/keluar, adjust here
            if ($item->quantity > 0) {
                $transactions[$date]['masuk'] += $item->quantity;
            } else {
                $transactions[$date]['keluar'] += abs($item->quantity);
            }

            $transactions[$date]['harga'] = $item->unit_cost; // Last price for that date
        }

        // Calculate stok_akhir and nilai for each transaction
        $result = [];
        foreach ($transactions as $trans) {
            $stokAkhir = $trans['stok_awal'] + $trans['masuk'] - $trans['keluar'];
            $nilai = $stokAkhir * $trans['harga'];

            $result[] = [
                'tanggal' => $trans['tanggal'],
                'stok_awal' => $trans['stok_awal'],
                'masuk' => $trans['masuk'],
                'keluar' => $trans['keluar'],
                'stok_akhir' => $stokAkhir,
                'harga' => $trans['harga'],
                'nilai' => $nilai,
                'keterangan' => $trans['keterangan']
            ];

            $runningStock = $stokAkhir;
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
        return view('stok.opname', []);
    }
}
