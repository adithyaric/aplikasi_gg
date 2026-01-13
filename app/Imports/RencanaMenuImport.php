<?php

namespace App\Imports;

use App\Models\RencanaMenu;
use App\Models\PaketMenu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Carbon\Carbon;

class RencanaMenuImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Validate dates
                $startDate = Carbon::createFromFormat('Y-m-d', $row['start_date']);
                $endDate = Carbon::createFromFormat('Y-m-d', $row['end_date']);

                if (!$startDate || !$endDate) {
                    $this->errors[] = "Row " . ($index + 2) . ": Format tanggal tidak valid (harus Y-m-d)";
                    continue;
                }

                if ($startDate->gt($endDate)) {
                    $this->errors[] = "Row " . ($index + 2) . ": Start date tidak boleh lebih besar dari end date";
                    continue;
                }

                $rencanaMenu = RencanaMenu::updateOrCreate(
                    [
                        'start_date' => $startDate->toDateString(),
                        'end_date' => $endDate->toDateString()
                    ],
                    [
                        'periode' => $row['periode'] ?? null
                    ]
                );

                if (!empty($row['paket_menus'])) {
                    $paketData = [];
                    $paketNames = array_map('trim', explode(',', $row['paket_menus']));

                    // Handle porsi - convert to string if it's numeric
                    $porsiString = isset($row['porsi']) ? (string)$row['porsi'] : '';

                    // If porsi doesn't contain comma but we have multiple paket menus, assume same porsi for all
                    if (count($paketNames) > 1 && strpos($porsiString, ',') === false && !empty($porsiString)) {
                        $porsiValues = array_fill(0, count($paketNames), trim($porsiString));
                    } else {
                        $porsiValues = !empty($porsiString) ? array_map('trim', explode(',', $porsiString)) : [];
                    }

                    // Check if all paket menus exist
                    $missingPaket = array_diff($paketNames, PaketMenu::whereIn('nama', $paketNames)->pluck('nama')->toArray());

                    if (!empty($missingPaket)) {
                        $this->errors[] = "Row " . ($index + 2) . ": Paket menu tidak ditemukan: " . implode(', ', $missingPaket);
                        continue;
                    }

                    // Validate porsi count matches
                    if (count($porsiValues) > 0 && count($paketNames) !== count($porsiValues)) {
                        $this->errors[] = "Row " . ($index + 2) . ": Jumlah porsi (" . count($porsiValues) . ") tidak sesuai dengan jumlah paket menu (" . count($paketNames) . ")";
                        continue;
                    }

                    foreach ($paketNames as $paketIndex => $paketName) {
                        $paketMenu = PaketMenu::where('nama', $paketName)->first();
                        if ($paketMenu) {
                            $porsi = isset($porsiValues[$paketIndex]) ? (int)$porsiValues[$paketIndex] : 0;

                            if ($porsi <= 0) {
                                $this->errors[] = "Row " . ($index + 2) . ": Porsi untuk paket '{$paketName}' harus lebih dari 0";
                                continue;
                            }

                            $paketData[$paketMenu->id] = ['porsi' => $porsi];
                        }
                    }

                    if (!empty($paketData)) {
                        $rencanaMenu->paketMenu()->sync($paketData);
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
            'periode' => 'nullable|string|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'paket_menus' => 'required|string',
            'porsi' => 'nullable',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'start_date.required' => 'Start date harus diisi',
            'start_date.date_format' => 'Format start date harus Y-m-d (contoh: 2024-01-01)',
            'end_date.required' => 'End date harus diisi',
            'end_date.date_format' => 'Format end date harus Y-m-d (contoh: 2024-01-31)',
            'end_date.after_or_equal' => 'End date harus sama atau setelah start date',
            'paket_menus.required' => 'Paket menus harus diisi',
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
