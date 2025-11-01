<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Administrator',
                'nrp' => '1',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'pangkat' => 'admin',
                'jabatan' => 'admin',
            ],
            [
                'name' => 'M.K. FATHONY, SH',
                'nrp' => '81110736',
                'password' => Hash::make('password'),
                'role' => 'anggota',
                'pangkat' => 'AIPDA',
                'jabatan' => 'KANIT I',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $categories = [
            ['name' => 'SIM'],
            ['name' => 'STNK'],
            ['name' => 'BPKB'],
            ['name' => 'Buku Tabungan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
