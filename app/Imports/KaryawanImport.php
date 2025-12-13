<?php

// app/Imports/KaryawanImport.php
namespace App\Imports;

use App\Models\Karyawan;
use App\Models\KategoriKaryawan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $kategori = null;
            if ($row['kategori_karyawan']) {
                $kategori = KategoriKaryawan::where('nama', $row['kategori_karyawan'])->first();
            }

            Karyawan::updateOrCreate(
                ['nama' => $row['nama'], 'no_hp' => $row['no_hp']],
                [
                    'kategori_karyawan_id' => $kategori->id ?? null,
                    'lahir_tempat' => $row['lahir_tempat'] ?? null,
                    'lahir_tanggal' => $row['lahir_tanggal'] ?? null,
                    'alamat' => $row['alamat'] ?? null,
                    'kelamin' => $row['kelamin'] ?? null,
                ]
            );
        }
    }
}