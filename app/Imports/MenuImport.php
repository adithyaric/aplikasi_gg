<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $menu = Menu::updateOrCreate(
                ['nama' => $row['nama']]
            );

            if (!empty($row['bahan_baku'])) {
                $bahanBakuNames = array_map('trim', explode(',', $row['bahan_baku']));
                $bahanBakuIds = BahanBaku::whereIn('nama', $bahanBakuNames)->pluck('id')->toArray();

                if (!empty($bahanBakuIds)) {
                    $menu->bahanBakus()->sync($bahanBakuIds);
                }
            }
        }
    }
}
