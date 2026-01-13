<?php

namespace App\Imports;

use App\Models\RencanaMenu;
use App\Models\PaketMenu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class RencanaMenuImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $rencanaMenu = RencanaMenu::updateOrCreate(
                [
                    'start_date' => Carbon::createFromFormat('Y-m-d', $row['start_date'])->toDateString(),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $row['end_date'])->toDateString()
                ],
                [
                    'periode' => $row['periode'] ?? null
                ]
            );

            if (!empty($row['paket_menus'])) {
                $paketData = [];
                $paketNames = array_map('trim', explode(',', $row['paket_menus']));
                $porsiValues = !empty($row['porsi']) ? array_map('trim', explode(',', $row['porsi'])) : [];

                foreach ($paketNames as $index => $paketName) {
                    $paketMenu = PaketMenu::where('nama', $paketName)->first();
                    if ($paketMenu) {
                        $porsi = isset($porsiValues[$index]) ? (int)$porsiValues[$index] : 0;
                        $paketData[$paketMenu->id] = ['porsi' => $porsi];
                    }
                }

                $rencanaMenu->paketMenu()->sync($paketData);
            }
        }
    }
}
