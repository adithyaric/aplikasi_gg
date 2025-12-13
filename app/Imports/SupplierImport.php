<?php

// app/Imports/SupplierImport.php
namespace App\Imports;

use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Supplier::updateOrCreate(
                ['nama' => $row['nama']],
                [
                    'no_hp' => $row['no_hp'] ?? null,
                    'bank_no_rek' => $row['bank_no_rek'] ?? null,
                    'bank_nama' => $row['bank_nama'] ?? null,
                    'alamat' => $row['alamat'] ?? null,
                    'long' => $row['long'] ?? null,
                    'lat' => $row['lat'] ?? null,
                    'products' => $row['products'] ?? null,
                ]
            );
        }
    }
}