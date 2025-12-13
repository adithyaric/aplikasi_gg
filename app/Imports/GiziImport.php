<?php

// app/Imports/GiziImport.php
namespace App\Imports;

use App\Models\BahanBaku;
use App\Models\Gizi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GiziImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $bahanBaku = BahanBaku::where('nama', $row['bahan_baku'])->first();

            if ($bahanBaku) {
                Gizi::updateOrCreate(
                    ['bahan_baku_id' => $bahanBaku->id],
                    [
                        'nomor_pangan' => $row['nomor_pangan'] ?? null,
                        'bdd' => $row['bdd'] ?? null,
                        'air' => $row['air'] ?? null,
                        'energi' => $row['energi'] ?? null,
                        'protein' => $row['protein'] ?? null,
                        'lemak' => $row['lemak'] ?? null,
                        'karbohidrat' => $row['karbohidrat'] ?? null,
                        'serat' => $row['serat'] ?? null,
                        'abu' => $row['abu'] ?? null,
                        'kalsium' => $row['kalsium'] ?? null,
                        'fosfor' => $row['fosfor'] ?? null,
                        'koles' => $row['koles'] ?? null,
                        'besi' => $row['besi'] ?? null,
                        'natrium' => $row['natrium'] ?? null,
                        'kalium' => $row['kalium'] ?? null,
                        'tembaga' => $row['tembaga'] ?? null,
                        'retinol' => $row['retinol'] ?? null,
                        'b_kar' => $row['b_kar'] ?? null,
                        'kar_total' => $row['kar_total'] ?? null,
                        'thiamin' => $row['thiamin'] ?? null,
                        'riboflavin' => $row['riboflavin'] ?? null,
                        'niasin' => $row['niasin'] ?? null,
                        'vitamin_c' => $row['vitamin_c'] ?? null,
                    ]
                );
            }
        }
    }
}