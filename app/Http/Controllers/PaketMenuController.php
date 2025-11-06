<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PaketMenu;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketMenuController extends Controller
{
    public function index()
    {
        $paketmenus = PaketMenu::with(['menus.bahanBakus'])->latest()->get();
        $title = 'Paket Menu';
        // dd($paketmenus?->toArray());
        return view('paket-menu.index', compact('paketmenus', 'title'));
    }

    public function create()
    {
        $menus = Menu::with('bahanBakus')->orderBy('nama')->get();
        $title = 'Formulir Paket Menu';
        return view('paket-menu.create', compact('menus', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'menus' => 'required|array|min:1',
            'menus.*.menu_id' => 'required|exists:menus,id',
            'menus.*.bahan_bakus' => 'required|array|min:1',
            'menus.*.bahan_bakus.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'menus.*.bahan_bakus.*.berat_bersih' => 'required|numeric|min:0',
            'menus.*.bahan_bakus.*.energi' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $paketMenu = PaketMenu::create([
                'nama' => $request->nama_paket,
            ]);

            foreach ($request->menus as $menuData) {
                $paketMenu->menus()->attach($menuData['menu_id']);
                foreach ($menuData['bahan_bakus'] as $bahanBaku) {
                    DB::table('bahan_baku_menu')->insert([
                        'paket_menu_id' => $paketMenu->id,
                        'menu_id' => $menuData['menu_id'],
                        'bahan_baku_id' => $bahanBaku['bahan_baku_id'],
                        'berat_bersih' => $bahanBaku['berat_bersih'],
                        'energi' => $bahanBaku['energi'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Paket menu berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(PaketMenu $paketmenu)
    {
        $paketmenu->load('menus');

        // Get bahan bakus with paket-specific data
        foreach ($paketmenu->menus as $menu) {
            $menu->bahanBakusWithPaketData = DB::table('bahan_baku_menu')
                ->join('bahan_bakus', 'bahan_baku_menu.bahan_baku_id', '=', 'bahan_bakus.id')
                ->where('bahan_baku_menu.paket_menu_id', $paketmenu->id)
                ->where('bahan_baku_menu.menu_id', $menu->id)
                ->select('bahan_bakus.*', 'bahan_baku_menu.berat_bersih', 'bahan_baku_menu.energi')
                ->get();
        }

        $title = 'Detail Paket Menu';
        return view('paket-menu.show', compact('paketmenu', 'title'));
    }

    public function edit(PaketMenu $paketmenu)
    {
        $paketmenu->load('menus');
        $menus = Menu::with('bahanBakus')->orderBy('nama')->get();

        // Get bahan bakus with paket-specific data
        foreach ($paketmenu->menus as $menu) {
            $menu->bahanBakusWithPaketData = DB::table('bahan_baku_menu')
                ->join('bahan_bakus', 'bahan_baku_menu.bahan_baku_id', '=', 'bahan_bakus.id')
                ->where('bahan_baku_menu.paket_menu_id', $paketmenu->id)
                ->where('bahan_baku_menu.menu_id', $menu->id)
                ->select('bahan_bakus.*', 'bahan_baku_menu.berat_bersih', 'bahan_baku_menu.energi')
                ->get();
        }

        $title = 'Edit Paket Menu';
        return view('paket-menu.edit', compact('paketmenu', 'menus', 'title'));
    }

    public function update(Request $request, PaketMenu $paketmenu)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'menus' => 'required|array|min:1',
            'menus.*.menu_id' => 'required|exists:menus,id',
            'menus.*.bahan_bakus' => 'required|array|min:1',
            'menus.*.bahan_bakus.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'menus.*.bahan_bakus.*.berat_bersih' => 'required|numeric|min:0',
            'menus.*.bahan_bakus.*.energi' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $paketmenu->update([
                'nama' => $request->nama_paket,
            ]);

            // Delete old relationships
            $paketmenu->menus()->detach();
            DB::table('bahan_baku_menu')->where('paket_menu_id', $paketmenu->id)->delete();

            foreach ($request->menus as $menuData) {
                $paketmenu->menus()->attach($menuData['menu_id']);
                foreach ($menuData['bahan_bakus'] as $bahanBaku) {
                    DB::table('bahan_baku_menu')->insert([
                        'paket_menu_id' => $paketmenu->id,
                        'menu_id' => $menuData['menu_id'],
                        'bahan_baku_id' => $bahanBaku['bahan_baku_id'],
                        'berat_bersih' => $bahanBaku['berat_bersih'],
                        'energi' => $bahanBaku['energi'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Paket menu berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(PaketMenu $paketmenu)
    {
        DB::beginTransaction();
        try {
            if ($paketmenu->rencanaMenu()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paket Menu tidak dapat dihapus karena masih digunakan dalam Rencana Menu'
                ], 422);
            }

            $paketmenu->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Paket Menu berhasil dihapus'
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
