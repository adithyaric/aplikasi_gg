<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\BahanBaku;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class MenuImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $menu = Menu::updateOrCreate(
                    ['nama' => $row['nama']]
                );

                if (!empty($row['bahan_baku'])) {
                    $bahanBakuNames = array_map('trim', explode(',', $row['bahan_baku']));
                    $bahanBakuIds = BahanBaku::whereIn('nama', $bahanBakuNames)->pluck('id')->toArray();

                    // Check if all bahan bakus exist
                    $missingBahan = array_diff($bahanBakuNames, BahanBaku::whereIn('nama', $bahanBakuNames)->pluck('nama')->toArray());

                    if (!empty($missingBahan)) {
                        $this->errors[] = "Row " . ($index + 2) . ": Bahan baku tidak ditemukan: " . implode(', ', $missingBahan);
                        continue;
                    }

                    if (!empty($bahanBakuIds)) {
                        $menu->bahanBakus()->sync($bahanBakuIds);
                    }
                }
            } catch (\Exception $e) {
                $this->errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'bahan_baku' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama menu harus diisi',
            'nama.max' => 'Nama menu maksimal 255 karakter',
        ];
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
