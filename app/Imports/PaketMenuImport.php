<?php

namespace App\Imports;

use App\Models\PaketMenu;
use App\Models\Menu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class PaketMenuImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $paketMenu = PaketMenu::updateOrCreate(
                ['nama' => $row['nama_paket']]
            );

            if (!empty($row['menus'])) {
                $menuNames = array_map('trim', explode(',', $row['menus']));
                $menuIds = Menu::whereIn('nama', $menuNames)->pluck('id')->toArray();

                $paketMenu->menus()->sync($menuIds);

                // Import bahan bakus with weight/energy if provided
                if (!empty($row['bahan_baku_details'])) {
                    $this->importBahanBakuDetails($paketMenu, $row['bahan_baku_details']);
                }
            }
        }
    }

    private function importBahanBakuDetails($paketMenu, $detailsJson)
    {
        if (!$this->isJson($detailsJson)) {
            return;
        }

        $details = json_decode($detailsJson, true);

        foreach ($details as $detail) {
            if (isset($detail['menu']) && isset($detail['bahan_baku']) && isset($detail['berat_bersih']) && isset($detail['energi'])) {
                $menu = Menu::where('nama', $detail['menu'])->first();
                $bahanBaku = BahanBaku::where('nama', $detail['bahan_baku'])->first();

                if ($menu && $bahanBaku) {
                    DB::table('bahan_baku_menu')->updateOrInsert(
                        [
                            'paket_menu_id' => $paketMenu->id,
                            'menu_id' => $menu->id,
                            'bahan_baku_id' => $bahanBaku->id
                        ],
                        [
                            'berat_bersih' => $detail['berat_bersih'],
                            'energi' => $detail['energi'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
                }
            }
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
