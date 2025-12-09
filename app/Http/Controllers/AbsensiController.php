<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with('karyawan.kategori')
            ->latest('tanggal')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal->toDateString();
            })
            ->map(function ($group) {
                return $group->toArray();
            });

        // dd($absensis?->toArray());

        $title = 'Absensi Karyawan';
        return view('absensi.index', compact('absensis', 'title'));
    }

    public function show($tanggal)
    {
        $absensis = Absensi::with('karyawan.kategori')
            ->whereDate('tanggal', $tanggal)
            ->get();

        $hadir = $absensis->where('status', 'hadir')->count();
        $tidakHadir = $absensis->where('status', 'tidak_hadir')->count();

        return response()->json([
            'success' => true,
            'tanggal' => \Carbon\Carbon::parse($tanggal)->format('d/m/Y'),
            'hadir' => $hadir,
            'tidak_hadir' => $tidakHadir,
            'absensis' => $absensis
        ]);
    }

    public function create(Request $request)
    {
        $karyawans = Karyawan::with('kategori')->get();
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));

        // Change pluck to get multiple fields
        $existingAbsensi = Absensi::whereDate('tanggal', $tanggal)
            ->get(['karyawan_id', 'status', 'confirmed'])
            ->keyBy('karyawan_id')
            ->toArray();

        $title = 'Tambah Absensi';
        return view('absensi.create', compact('karyawans', 'tanggal', 'existingAbsensi', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'karyawan' => 'required|array|min:1',
            'karyawan.*.id' => 'required|exists:karyawans,id',
            'karyawan.*.status' => 'required|in:hadir,tidak_hadir',
            'karyawan.*.confirmed' => 'required',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->karyawan as $data) {
                Absensi::updateOrCreate(
                    [
                        'karyawan_id' => $data['id'],
                        'tanggal' => $request->tanggal,
                    ],
                    [
                        'status' => $data['status'],
                        'confirmed' => $data['confirmed'] ?? false,
                    ]
                );
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil disimpan'
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
