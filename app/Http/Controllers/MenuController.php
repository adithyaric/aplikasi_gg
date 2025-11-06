<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('bahanBakus')->latest()->get();
        $title = 'Menu';
        return view('menu.index', compact('menus', 'title'));
    }

    public function create()
    {
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'kelompok']);
        $title = 'Tambah Menu';
        return view('menu.create', compact('bahanbakus', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bahan_bakus' => 'required|array|min:1',
            'bahan_bakus.*' => 'required|exists:bahan_bakus,id',
        ]);

        DB::beginTransaction();
        try {
            $menu = Menu::create([
                'nama' => $request->nama,
            ]);

            // Attach bahan bakus (template only, no weight/energy yet)
            $menu->bahanBakus()->attach($request->bahan_bakus);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Menu $menu)
    {
        $menu->load('bahanBakus');
        return $menu?->toArray();
        // $title = 'Detail Menu';
        // return view('menu.show', compact('menu', 'title'));
    }

    public function edit(Menu $menu)
    {
        $menu->load('bahanBakus');
        $bahanbakus = BahanBaku::orderBy('nama')->get(['id', 'nama', 'kelompok']);
        $title = 'Edit Menu';
        return view('menu.edit', compact('menu', 'bahanbakus', 'title'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bahan_bakus' => 'required|array|min:1',
            'bahan_bakus.*' => 'required|exists:bahan_bakus,id',
        ]);

        DB::beginTransaction();
        try {
            $menu->update([
                'nama' => $request->nama,
            ]);

            // Sync bahan bakus (template only)
            $menu->bahanBakus()->sync($request->bahan_bakus);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Menu $menu)
    {
        DB::beginTransaction();
        try {
            // Check if menu is used in any paket
            if ($menu->paketMenus()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak dapat dihapus karena masih digunakan dalam paket menu'
                ], 422);
            }

            $menu->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus'
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
