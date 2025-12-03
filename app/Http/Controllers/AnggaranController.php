<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggarans = Anggaran::latest()->get();
        $title = 'Halaman Proposal';

        return view('anggaran.index', compact('anggarans', 'title'));
    }

    public function create()
    {
        $sekolahs = Sekolah::get(['id', 'nama', 'porsi_8k', 'porsi_10k']);
        $title = 'Tambah Proposal';

        return view('anggaran.create', compact('sekolahs', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'porsi_8k' => 'required|integer|min:0',
            'porsi_10k' => 'required|integer|min:0',
            'aturan_sewa' => 'required|in:aturan_1,aturan_2'
        ]);

        // Calculate values
        $total_porsi = $request->porsi_8k + $request->porsi_10k;
        $budget_porsi_8k = $request->porsi_8k * 8000;
        $budget_porsi_10k = $request->porsi_10k * 10000;
        $budget_operasional = $total_porsi * 3000;

        // Calculate budget sewa based on rules
        if ($request->aturan_sewa === 'aturan_1') {
            $budget_sewa = 2000 * 3000; // Fixed: 2,000 × 3,000
        } else {
            $budget_sewa = 2000 * $total_porsi; // 2,000 × total_porsi
        }

        Anggaran::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'sekolah_id' => $request->sekolah_id,
            'porsi_8k' => $request->porsi_8k,
            'porsi_10k' => $request->porsi_10k,
            'total_porsi' => $total_porsi,
            'budget_porsi_8k' => $budget_porsi_8k,
            'budget_porsi_10k' => $budget_porsi_10k,
            'budget_operasional' => $budget_operasional,
            'budget_sewa' => $budget_sewa,
            'aturan_sewa' => $request->aturan_sewa
        ]);

        return redirect()->route('anggaran.index')
            ->with('success', 'Anggaran berhasil ditambahkan');
    }

    public function show(Anggaran $anggaran)
    {
        dd($anggaran?->toArray());
    }

    public function edit(Anggaran $anggaran)
    {
        $sekolahs = Sekolah::get(['id', 'nama', 'porsi_8k', 'porsi_10k']);
        $title = 'Edit Anggaran';

        return view('anggaran.edit', compact('anggaran', 'sekolahs', 'title'));
    }

    public function update(Request $request, Anggaran $anggaran)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            // 'sekolah_id' => 'required|exists:sekolahs,id',
            'porsi_8k' => 'required|integer|min:0',
            'porsi_10k' => 'required|integer|min:0',
            'aturan_sewa' => 'required|in:aturan_1,aturan_2'
        ]);

        // Calculate values (same as store)
        $total_porsi = $request->porsi_8k + $request->porsi_10k;
        $budget_porsi_8k = $request->porsi_8k * 8000;
        $budget_porsi_10k = $request->porsi_10k * 10000;
        $budget_operasional = $total_porsi * 3000;

        if ($request->aturan_sewa === 'aturan_1') {
            $budget_sewa = 2000 * 3000;
        } else {
            $budget_sewa = 2000 * $total_porsi;
        }

        $anggaran->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            // 'sekolah_id' => $request->sekolah_id,
            'porsi_8k' => $request->porsi_8k,
            'porsi_10k' => $request->porsi_10k,
            'total_porsi' => $total_porsi,
            'budget_porsi_8k' => $budget_porsi_8k,
            'budget_porsi_10k' => $budget_porsi_10k,
            'budget_operasional' => $budget_operasional,
            'budget_sewa' => $budget_sewa,
            'aturan_sewa' => $request->aturan_sewa
        ]);

        return redirect()->route('anggaran.index')
            ->with('success', 'Anggaran berhasil diupdate');
    }

    public function destroy(Anggaran $anggaran)
    {
        DB::beginTransaction();
        try {
            $anggaran->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
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
