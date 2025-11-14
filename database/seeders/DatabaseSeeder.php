<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\Category;
use App\Models\Gizi;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaketMenu;
use App\Models\RencanaMenu;
use App\Models\Sekolah;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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
                'name' => 'Anggota',
                'nrp' => '2',
                'password' => Hash::make('password'),
                'role' => 'anggota',
                'pangkat' => 'anggota',
                'jabatan' => 'anggota',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $categories = [
            ['name' => 'cat1'],
            ['name' => 'cat2'],
            ['name' => 'cat3'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Bahan Baku
        $bahanBakus = [
            [
                'nama' => 'Beras Merah',
                'kelompok' => 'Serealia',
                'jenis' => 'Beras',
                'kategori' => 'Pokok',
                'satuan' => 'kg',
                'merek' => 'Beras Sehat',
                'ukuran' => '1kg',
            ],
            [
                'nama' => 'Daging Ayam',
                'kelompok' => 'Protein Hewani',
                'jenis' => 'Daging Unggas',
                'kategori' => 'Lauk',
                'satuan' => 'kg',
                'merek' => 'Ayam Segar',
                'ukuran' => '1kg',
            ],
            [
                'nama' => 'Wortel',
                'kelompok' => 'Sayuran',
                'jenis' => 'Umbi',
                'kategori' => 'Sayur',
                'satuan' => 'kg',
                'merek' => 'Sayur Organik',
                'ukuran' => '1kg',
            ],
        ];

        $bahanBakuIds = [];
        foreach ($bahanBakus as $bahan) {
            $bahanBaku = BahanBaku::create($bahan);
            $bahanBakuIds[] = $bahanBaku->id;
        }

        // Gizi
        $gizis = [
            [
                'bahan_baku_id' => $bahanBakuIds[0],
                'nomor_pangan' => '001',
                'bdd' => 85,
                'air' => 12.5,
                'energi' => 352,
                'protein' => 7.5,
                'lemak' => 1.2,
                'karbohidrat' => 77.2,
                'serat' => 2.3,
                'abu' => 1.2,
                'kalsium' => 20,
                'fosfor' => 150,
                'besi' => 1.5,
                'natrium' => 5,
                'kalium' => 250,
            ],
            [
                'bahan_baku_id' => $bahanBakuIds[1],
                'nomor_pangan' => '002',
                'bdd' => 75,
                'air' => 68,
                'energi' => 167,
                'protein' => 18.2,
                'lemak' => 9.8,
                'karbohidrat' => 0,
                'serat' => 0,
                'abu' => 1.0,
                'kalsium' => 12,
                'fosfor' => 180,
                'besi' => 1.2,
                'natrium' => 70,
                'kalium' => 290,
            ],
        ];

        foreach ($gizis as $gizi) {
            Gizi::create($gizi);
        }

        // Bahan Operasional
        $bahanOperasionals = [
            ['nama' => 'Gas LPG', 'satuan' => 'tabung'],
            ['nama' => 'Sabun Cuci Piring', 'satuan' => 'botol'],
            ['nama' => 'Plastik Kemasan', 'satuan' => 'roll'],
        ];

        foreach ($bahanOperasionals as $bahan) {
            BahanOperasional::create($bahan);
        }

        // Sekolah
        $sekolahs = [
            [
                'nama' => 'SD Negeri 1 Jakarta',
                'nama_pic' => 'Budi Santoso',
                'nomor' => 812345678,
                'jarak' => 5.2,
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'long' => 106.8227,
                'lat' => -6.2088,
                'porsi_8k' => 150,
                'porsi_10k' => 200,
            ],
            [
                'nama' => 'SMP Negeri 2 Bandung',
                'nama_pic' => 'Siti Rahayu',
                'nomor' => 813456789,
                'jarak' => 3.8,
                'alamat' => 'Jl. Asia Afrika No. 2, Bandung',
                'long' => 107.6191,
                'lat' => -6.9175,
                'porsi_8k' => 180,
                'porsi_10k' => 220,
            ],
        ];

        foreach ($sekolahs as $sekolah) {
            Sekolah::create($sekolah);
        }

        // Supplier
        $suppliers = [
            [
                'nama' => 'Toko Beras Sejahtera',
                'no_hp' => '08123456789',
                'bank_no_rek' => '1234567890',
                'bank_nama' => 'BCA',
                'alamat' => 'Jl. Pasar Baru No. 1, Jakarta',
                'long' => 106.8269,
                'lat' => -6.1754,
                'products' => 'Beras, Terigu, Minyak',
            ],
            [
                'nama' => 'Supplier Ayam Segar',
                'no_hp' => '08134567890',
                'bank_no_rek' => '0987654321',
                'bank_nama' => 'BRI',
                'alamat' => 'Jl. Raya Bogor No. 2, Jakarta',
                'long' => 106.8503,
                'lat' => -6.4025,
                'products' => 'Daging Ayam, Telur',
            ],
        ];

        $supplierIds = [];
        foreach ($suppliers as $supplier) {
            $sup = Supplier::create($supplier);
            $supplierIds[] = $sup->id;
        }

        // Menu
        $menus = [
            ['nama' => 'Nasi Goreng Ayam'],
            ['nama' => 'Sayur Sop'],
            ['nama' => 'Ayam Goreng'],
            ['nama' => 'Capcay'],
        ];

        $menuIds = [];
        foreach ($menus as $menu) {
            $m = Menu::create($menu);
            $menuIds[] = $m->id;
        }

        // Paket Menu
        $paketMenus = [
            ['nama' => 'Paket Makan Siang A'],
            ['nama' => 'Paket Makan Siang B'],
            ['nama' => 'Paket Sarapan'],
        ];

        $paketMenuIds = [];
        foreach ($paketMenus as $paket) {
            $pm = PaketMenu::create($paket);
            $paketMenuIds[] = $pm->id;
        }

        // Attach menus to paket menus
        PaketMenu::find($paketMenuIds[0])->menus()->attach([$menuIds[0], $menuIds[1]]);
        PaketMenu::find($paketMenuIds[1])->menus()->attach([$menuIds[2], $menuIds[3]]);
        PaketMenu::find($paketMenuIds[2])->menus()->attach([$menuIds[0]]);

        // Attach bahan bakus to menus
        Menu::find($menuIds[0])->bahanBakus()->attach([$bahanBakuIds[0], $bahanBakuIds[1]]);
        Menu::find($menuIds[1])->bahanBakus()->attach([$bahanBakuIds[2]]);
        Menu::find($menuIds[2])->bahanBakus()->attach([$bahanBakuIds[1]]);

        // Rencana Menu
        $rencanaMenus = [
            [
                'periode' => 'Januari 2024',
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-31',
            ],
            [
                'periode' => 'Februari 2024',
                'start_date' => '2024-02-01',
                'end_date' => '2024-02-29',
            ],
        ];

        $rencanaMenuIds = [];
        foreach ($rencanaMenus as $rencana) {
            $rm = RencanaMenu::create($rencana);
            $rencanaMenuIds[] = $rm->id;
        }

        // Attach paket menus to rencana menus with porsi
        RencanaMenu::find($rencanaMenuIds[0])->paketMenu()->attach([
            $paketMenuIds[0] => ['porsi' => 100],
            $paketMenuIds[1] => ['porsi' => 150],
        ]);

        // Orders
        $orders = [
            [
                'order_number' => 'PO-001-2024',
                'supplier_id' => $supplierIds[0],
                'tanggal_po' => '2024-01-15',
                'tanggal_penerimaan' => '2024-01-17',
                'grand_total' => 2500000,
                'status' => 'posted',
                'status_penerimaan' => 'confirmed',
                'notes' => 'Pesanan bahan baku untuk bulan Januari',
            ],
            [
                'order_number' => 'PO-002-2024',
                'supplier_id' => $supplierIds[1],
                'tanggal_po' => '2024-01-16',
                'tanggal_penerimaan' => '2024-01-18',
                'grand_total' => 1800000,
                'status' => 'draft',
                'status_penerimaan' => 'draft',
                'notes' => 'Pesanan daging ayam',
            ],
        ];

        $orderIds = [];
        foreach ($orders as $order) {
            $o = Order::create($order);
            $orderIds[] = $o->id;
        }

        // Order Items
        $orderItems = [
            [
                'order_id' => $orderIds[0],
                'bahan_baku_id' => $bahanBakuIds[0],
                'quantity' => 100,
                'quantity_diterima' => 100,
                'satuan' => 'kg',
                'unit_cost' => 15000,
                'subtotal' => 1500000,
                'notes' => 'Beras merah kualitas premium',
            ],
            [
                'order_id' => $orderIds[0],
                'bahan_baku_id' => $bahanBakuIds[2],
                'quantity' => 50,
                'quantity_diterima' => 50,
                'satuan' => 'kg',
                'unit_cost' => 20000,
                'subtotal' => 1000000,
                'notes' => 'Wortel segar',
            ],
            [
                'order_id' => $orderIds[1],
                'bahan_baku_id' => $bahanBakuIds[1],
                'quantity' => 80,
                'quantity_diterima' => 0,
                'satuan' => 'kg',
                'unit_cost' => 22500,
                'subtotal' => 1800000,
                'notes' => 'Daging ayam potong',
            ],
        ];

        foreach ($orderItems as $item) {
            OrderItem::create($item);
        }

        // Transactions
        $transactions = [
            [
                'order_id' => $orderIds[0],
                'payment_date' => '2024-01-20',
                'payment_method' => 'transfer',
                'payment_reference' => 'TRX-001',
                'amount' => 2500000,
                'notes' => 'Pembayaran lunas untuk PO-001-2024',
            ],
            [
                'order_id' => $orderIds[1],
                'payment_date' => '2024-01-18',
                'payment_method' => 'transfer',
                'payment_reference' => 'TRX-002',
                'amount' => 900000,
                'notes' => 'DP 50% untuk PO-002-2024',
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }
    }
}