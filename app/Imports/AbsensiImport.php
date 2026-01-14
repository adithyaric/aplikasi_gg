<?php

namespace App\Imports;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensiImport implements ToCollection, WithHeadingRow
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
        $totalDays = $start->diffInDays($end) + 1;

        foreach ($rows as $row) {
            $karyawan = Karyawan::where('nama', $row['nama_karyawan'])->first();

            if ($karyawan) {
                $banyakHadir = (int) ($row['banyak_hadir'] ?? 0);
                $status = strtolower($row['status'] ?? 'hadir');

                // Calculate based on banyak_hadir for specified status
                if ($banyakHadir > 0) {
                    // Set the first X days to the specified status
                    for ($i = 0; $i < $banyakHadir; $i++) {
                        $currentDate = $start->copy()->addDays($i);
                        if ($currentDate->lte($end)) {
                            Absensi::updateOrCreate(
                                [
                                    'karyawan_id' => $karyawan->id,
                                    'tanggal' => $currentDate,
                                ],
                                [
                                    'status' => $status,
                                    'confirmed' => true,
                                ]
                            );
                        }
                    }

                    // Set remaining days to opposite status
                    $oppositeStatus = ($status == 'hadir') ? 'tidak_hadir' : 'hadir';
                    for ($i = $banyakHadir; $i < $totalDays; $i++) {
                        $currentDate = $start->copy()->addDays($i);
                        if ($currentDate->lte($end)) {
                            Absensi::updateOrCreate(
                                [
                                    'karyawan_id' => $karyawan->id,
                                    'tanggal' => $currentDate,
                                ],
                                [
                                    'status' => $oppositeStatus,
                                    'confirmed' => true,
                                ]
                            );
                        }
                    }
                } else {
                    // If banyak_hadir is 0, set all days to status
                    for ($i = 0; $i < $totalDays; $i++) {
                        $currentDate = $start->copy()->addDays($i);
                        Absensi::updateOrCreate(
                            [
                                'karyawan_id' => $karyawan->id,
                                'tanggal' => $currentDate,
                            ],
                            [
                                'status' => $status,
                                'confirmed' => true,
                            ]
                        );
                    }
                }
            }
        }
    }
}
