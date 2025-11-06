<?php

namespace App\Http\Controllers;

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
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'kelompok']);
        $title = 'Formulir Paket Menu';
        return view('paket-menu.create', compact('bahanbakus', 'title'));
    }

    //TODO pindah Input Menu ke crud tersendiri,
    //di CRUD Menu pilih bahan baku
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'menus' => 'required|array|min:1',
            'menus.*.nama' => 'required|string|max:255',
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
                $menu = $paketMenu->menus()->create([
                    'nama' => $menuData['nama'],
                ]);

                foreach ($menuData['bahan_bakus'] as $bahanBaku) {
                    $menu->bahanBakus()->attach($bahanBaku['bahan_baku_id'], [
                        'berat_bersih' => $bahanBaku['berat_bersih'],
                        'energi' => $bahanBaku['energi'],
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
        $paketmenu->load(['menus.bahanBakus']);
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'kelompok']);
        $title = 'Detail Paket Menu';
        //TODO menunggu rumus
        return view('paket-menu.show', compact('paketmenu', 'bahanbakus', 'title'));
    }

    public function edit(PaketMenu $paketmenu)
    {
        $paketmenu->load(['menus.bahanBakus']);
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'kelompok']);
        $title = 'Edit Paket Menu';
        return view('paket-menu.edit', compact('paketmenu', 'bahanbakus', 'title'));
    }

    public function update(Request $request, PaketMenu $paketmenu)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'menus' => 'required|array|min:1',
            'menus.*.nama' => 'required|string|max:255',
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

            $paketmenu->menus()->delete();

            foreach ($request->menus as $menuData) {
                $menu = $paketmenu->menus()->create([
                    'nama' => $menuData['nama'],
                ]);

                foreach ($menuData['bahan_bakus'] as $bahanBaku) {
                    $menu->bahanBakus()->attach($bahanBaku['bahan_baku_id'], [
                        'berat_bersih' => $bahanBaku['berat_bersih'],
                        'energi' => $bahanBaku['energi'],
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
        $paketmenu->delete();
        return response()->json([
            'success' => true,
            'message' => 'Paket menu berhasil dihapus'
        ]);
    }
}
