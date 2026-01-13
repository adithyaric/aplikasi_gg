<?php

namespace App\Imports;

use App\Models\KategoriKaryawan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KategoriKaryawanImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            KategoriKaryawan::updateOrCreate(
                ['nama' => $row['nama']],
                ['nominal_gaji' => $row['nominal_gaji'] ?? 0]
            );
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'nominal_gaji' => 'nullable|integer'
        ];
    }
}