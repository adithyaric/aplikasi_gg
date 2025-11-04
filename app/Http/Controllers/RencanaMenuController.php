<?php

namespace App\Http\Controllers;

use App\Models\RencanaMenu;
use App\Models\PaketMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencanaMenuController extends Controller
{
    public function index()
    {
        $rencanaMenus = RencanaMenu::with(['paketMenu'])->orderBy('created_at')->get(['id', 'periode']);
        return $rencanaMenus?->toArray();
    }

    public function create()
    {
        $paketmenus = PaketMenu::orderBy('nama')->get(['id', 'nama']);
        $title = 'Formulir Perencanaan Menu';
        return view('rencana-menu.create', compact('paketmenus', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.paket_menu_id' => 'required|exists:paket_menus,id',
            'items.*.porsi' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $rencana = RencanaMenu::create([
                'periode' => $request->periode,
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
}
