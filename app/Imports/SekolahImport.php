<?php

// app/Imports/SekolahImport.php
namespace App\Imports;

use App\Models\Sekolah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SekolahImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Sekolah::updateOrCreate(
                ['nama' => $row['nama']],
                [
                    'nama_pic' => $row['nama_pic'] ?? null,
                    'nomor' => $row['nomor'] ?? null,
                    'jarak' => $row['jarak'] ?? null,
                    'alamat' => $row['alamat'] ?? null,
                    'long' => $row['long'] ?? null,
                    'lat' => $row['lat'] ?? null,
                    'porsi_8k' => $row['porsi_8k'] ?? null,
                    'porsi_10k' => $row['porsi_10k'] ?? null,
                ]
            );
        }
    }
}