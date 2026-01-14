<?php

namespace App\Imports;

use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToCollection, WithHeadingRow
{
    protected $tanggal_mulai;
    protected $tanggal_akhir;

    public function __construct($tanggal_mulai, $tanggal_akhir)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function collection(Collection $rows)
    {
        $start = Carbon::parse($this->tanggal_mulai);
        $end = Carbon::parse($this->tanggal_akhir);

        foreach ($rows as $row) {
            $karyawan = Karyawan::with('kategori')->where('nama', $row['nama'])->first();

            if ($karyawan) {
                // Calculate jumlah_hadir from system if not provided in CSV
                if (!isset($row['jumlah_hadir']) || $row['jumlah_hadir'] === '') {
                    $jumlahHadir = Absensi::where('karyawan_id', $karyawan->id)
                        ->where('confirmed', true)
                        ->whereBetween('tanggal', [$start, $end])
                        ->where('status', 'hadir')
                        ->count();
                } else {
                    $jumlahHadir = (int) $row['jumlah_hadir'];
                }

                $nominalPerHari = $karyawan->kategori->nominal_gaji ?? 0;

                // Calculate total_gaji from system if not provided in CSV
                if (!isset($row['total_gaji']) || $row['total_gaji'] === '') {
                    $totalGaji = $jumlahHadir * $nominalPerHari;
                } else {
                    $totalGaji = is_numeric($row['total_gaji'])
                        ? $row['total_gaji']
                        : (float) preg_replace('/[^0-9]/', '', $row['total_gaji']);
                }

                Gaji::updateOrCreate(
                    [
                        'karyawan_id' => $karyawan->id,
                        'tanggal_mulai' => $start,
                        'tanggal_akhir' => $end,
                    ],
                    [
                        'periode' => $start->format('Y-m-d') . ' s/d ' . $end->format('Y-m-d'),
                        'periode_minggu' => $start->weekOfMonth,
                        'periode_bulan' => $start->month,
                        'periode_tahun' => $start->year,
                        'jumlah_hadir' => $jumlahHadir,
                        'nominal_per_hari' => $nominalPerHari,
                        'total_gaji' => $totalGaji,
                        'status' => 'hold',
                    ]
                );
            }
        }
    }
}
