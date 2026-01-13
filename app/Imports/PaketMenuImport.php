<?php

namespace App\Imports;

use App\Models\PaketMenu;
use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;

class PaketMenuImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $paketMenu = PaketMenu::updateOrCreate(
                    ['nama' => $row['nama_paket']]
                );

                if (!empty($row['menus'])) {
                    $menuNames = array_map('trim', explode(',', $row['menus']));
                    $menuIds = Menu::whereIn('nama', $menuNames)->pluck('id')->toArray();

                    // Check if all menus exist
                    $missingMenus = array_diff($menuNames, Menu::whereIn('nama', $menuNames)->pluck('nama')->toArray());

                    if (!empty($missingMenus)) {
                        $this->errors[] = "Row " . ($index + 2) . ": Menu tidak ditemukan: " . implode(', ', $missingMenus);
                        continue;
                    }

                    $paketMenu->menus()->sync($menuIds);

                    // Import bahan bakus with weight/energy if provided
                    if (!empty($row['bahan_baku_details'])) {
                        $this->importBahanBakuDetails($paketMenu, $row['bahan_baku_details'], $index);
                    }
                }
            } catch (\Exception $e) {
                $this->errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }
    }

    private function importBahanBakuDetails($paketMenu, $detailsJson, $rowIndex)
    {
        if (!$this->isJson($detailsJson)) {
            $this->errors[] = "Row " . ($rowIndex + 2) . ": Format bahan_baku_details tidak valid (harus JSON)";
            return;
        }

        $details = json_decode($detailsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->errors[] = "Row " . ($rowIndex + 2) . ": JSON bahan_baku_details tidak valid";
            return;
        }

        foreach ($details as $detailIndex => $detail) {
            if (!isset($detail['menu']) || !isset($detail['bahan_baku']) || !isset($detail['berat_bersih']) || !isset($detail['energi'])) {
                $this->errors[] = "Row " . ($rowIndex + 2) . ": Detail ke-" . ($detailIndex + 1) . " format salah (harus ada menu, bahan_baku, berat_bersih, energi)";
                continue;
            }

            $menu = Menu::where('nama', $detail['menu'])->first();
            if (!$menu) {
                $this->errors[] = "Row " . ($rowIndex + 2) . ": Menu '" . $detail['menu'] . "' tidak ditemukan di detail ke-" . ($detailIndex + 1);
                continue;
            }

            $bahanBaku = BahanBaku::where('nama', $detail['bahan_baku'])->first();
            if (!$bahanBaku) {
                $this->errors[] = "Row " . ($rowIndex + 2) . ": Bahan baku '" . $detail['bahan_baku'] . "' tidak ditemukan di detail ke-" . ($detailIndex + 1);
                continue;
            }

            // Check if menu belongs to this paket
            if (!$paketMenu->menus()->where('menu_id', $menu->id)->exists()) {
                $this->errors[] = "Row " . ($rowIndex + 2) . ": Menu '" . $detail['menu'] . "' tidak termasuk dalam paket ini";
                continue;
            }

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

    public function rules(): array
    {
        return [
            'nama_paket' => 'required|string|max:255',
            'menus' => 'required|string',
            'bahan_baku_details' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_paket.required' => 'Nama paket harus diisi',
            'nama_paket.max' => 'Nama paket maksimal 255 karakter',
            'menus.required' => 'Menu harus diisi',
        ];
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
