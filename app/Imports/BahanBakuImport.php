<?php

// app/Imports/BahanBakuImport.php
namespace App\Imports;

use App\Models\BahanBaku;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BahanBakuImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Convert kategori string → array
            // Example CSV: ["cat1","cat2"]
            $kategori = null;

            if (!empty($row['kategori'])) {
                // If kategori already looks like JSON
                if ($this->isJson($row['kategori'])) {
                    $kategori = json_decode($row['kategori'], true);
                } else {
                    // If kategori is comma-separated: cat1, cat2
                    $kategori = array_map('trim', explode(',', $row['kategori']));
                }

                // Ensure categories exist
                foreach ($kategori as $kat) {
                    Category::firstOrCreate(['name' => $kat]);
                }
            }

            BahanBaku::updateOrCreate(
                ['nama' => $row['nama']],
                [
                    'kelompok'   => $row['kelompok'] ?? null,
                    'jenis'      => $row['jenis'] ?? null,
                    'kategori'   => $kategori,
                    'satuan'     => $row['satuan'],
                    'merek'      => $row['merek'],
                    'gov_price'  => $row['gov_price'],
                    'ukuran'     => $row['ukuran'] ?? null,
                ]
            );
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
