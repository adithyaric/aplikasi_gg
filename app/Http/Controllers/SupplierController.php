<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get(['id', 'nama', 'no_hp', 'bank_no_rek', 'bank_nama', 'alamat', 'long', 'lat']);
        $title = 'Master Supplier';
        return view('supplier.index', compact('suppliers', 'title'));
    }

    public function create()
    {
        //using modal create on index.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'bank_no_rek' => 'nullable|string|max:255',
            'bank_nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'long' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
        ]);

        Supplier::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'bank_no_rek' => $request->bank_no_rek,
            'bank_nama' => $request->bank_nama,
            'alamat' => $request->alamat,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil ditambahkan',
        ]);
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    public function edit(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'bank_no_rek' => 'nullable|string|max:255',
            'bank_nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'long' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
        ]);

        $supplier->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'bank_no_rek' => $request->bank_no_rek,
            'bank_nama' => $request->bank_nama,
            'alamat' => $request->alamat,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil diupdate',
        ]);
    }

    public function destroy(Supplier $supplier)
    {
        DB::beginTransaction();
        try {
            $supplier->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
