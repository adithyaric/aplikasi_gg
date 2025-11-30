<?php

namespace App\Http\Controllers;

use App\Models\RencanaMenu;
use App\Models\PaketMenu;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencanaMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = RencanaMenu::with(['paketMenu.menus.bahanBakus'])
            ->orderBy('created_at', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        $rencanaMenus = $query->get();

        return view('rencana-menu.index', compact('rencanaMenus'));
    }

    public function show($id)
    {
        $rencana = RencanaMenu::with(['paketMenu'])->findOrFail($id);

        // Load menus and their paket-specific bahan bakus
        foreach ($rencana->paketMenu as $paket) {
            $paket->load('menus');

            foreach ($paket->menus as $menu) {
                // Get bahan bakus with paket-specific data
                $menu->bahanBakusWithPaketData = DB::table('bahan_baku_menu')
                    ->join('bahan_bakus', 'bahan_baku_menu.bahan_baku_id', '=', 'bahan_bakus.id')
                    ->where('bahan_baku_menu.paket_menu_id', $paket->id)
                    ->where('bahan_baku_menu.menu_id', $menu->id)
                    ->select(
                        'bahan_bakus.id',
                        'bahan_bakus.nama',
                        'bahan_bakus.satuan',
                        'bahan_baku_menu.berat_bersih',
                        'bahan_baku_menu.energi'
                    )
                    ->get();
            }
        }

        return $rencana->toArray();
    }

    public function create()
    {
        $paketmenus = PaketMenu::orderBy('nama')->get(['id', 'nama']);
        $porsiSekolah = (int) Sekolah::sum(\DB::raw('porsi_8k + porsi_10k'));;

        $title = 'Formulir Perencanaan Menu';
        return view('rencana-menu.create', compact('paketmenus', 'porsiSekolah', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'items' => 'required|array|min:1',
            'items.*.paket_menu_id' => 'required|exists:paket_menus,id',
            'items.*.porsi' => 'required|numeric|min:1',
        ]);

        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($request->start_date))->format('Y-m-d');

        DB::beginTransaction();
        try {
            $rencana = RencanaMenu::create([
                // 'periode' => $request->periode,
                'start_date' => $startDate,
                // 'end_date' => $endDate,
            ]);

            foreach ($request->items as $item) {
                $rencana->paketMenu()->attach($item['paket_menu_id'], [
                    'porsi' => $item['porsi'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Rencana menu berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $rencana = RencanaMenu::with(['paketMenu'])->findOrFail($id);
        $paketmenus = PaketMenu::orderBy('nama')->get(['id', 'nama']);
        $title = 'Edit Perencanaan Menu';

        return view('rencana-menu.edit', compact('rencana', 'paketmenus', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required',
            'items' => 'required|array|min:1',
            'items.*.paket_menu_id' => 'required|exists:paket_menus,id',
            'items.*.porsi' => 'required|numeric|min:1',
        ]);

        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($request->start_date))->format('Y-m-d');

        DB::beginTransaction();
        try {
            $rencana = RencanaMenu::findOrFail($id);
            $rencana->update([
                'start_date' => $startDate,
            ]);

            // Remove existing items and attach new ones
            $rencana->paketMenu()->detach();
            foreach ($request->items as $item) {
                $rencana->paketMenu()->attach($item['paket_menu_id'], [
                    'porsi' => $item['porsi'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Rencana menu berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $rencana = RencanaMenu::findOrFail($id);
            $rencana->paketMenu()->detach();
            $rencana->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Rencana menu berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
