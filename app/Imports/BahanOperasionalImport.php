<?php

// app/Imports/BahanOperasionalImport.php
namespace App\Imports;

use App\Models\BahanOperasional;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BahanOperasionalImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $kategori = null;

            if (!empty($row['kategori'])) {
                if ($this->isJson($row['kategori'])) {
                    $kategori = json_decode($row['kategori'], true);
                } else {
                    $kategori = array_map('trim', explode(',', $row['kategori']));
                }

                foreach ($kategori as $kat) {
                    Category::firstOrCreate(['name' => $kat]);
                }
            }

            BahanOperasional::updateOrCreate(
                ['nama' => $row['nama']],
                [
                    'satuan'    => $row['satuan'],
                    'kategori'  => $kategori,
                    'merek'     => $row['merek'],
                    'gov_price' => $row['gov_price'],
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
