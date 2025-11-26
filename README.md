<!-- Tambahkan menu sekolah (nama sekolah, jarak, nomor dan nama PIC). -->
<!-- Tampilkan pada menu titik sekolah -> `titik distribusi` -->
<!-- Berelasi dengan beban sewa (porsi) -->
<!-- Tambah master data beban sewa (inputan sekolah, porsi 8k, posi 10k) `(porsi 8k, posi 10k fix)` -->

<!-- Titik Distribusi : tampil sekolah -->
<!-- click peta -> dapat long lat, select sekolah -->

<!-- sebelum PO : -->
<!-- Tambahkan menu supplier (nama, no hp, products, no rekening dan bank) -->
<!-- Tambah menu titik supplier (tampilan seluruh supplier masing-masing dapur) -> mirip titik distribusi -->
<!-- Tambah supplier di formulir PO -->

<!-- PO : -->
<!-- Tambah Menu -> Pilih Periode dan Tambahkan Menu -->
<!-- ambil data dari rencana menu -> input bahan" & satuan ke Bahan Baku PO -->
<!-- Quantity ambil dari jumlah prosi (rencana menu) x Berat Bersih (paket menu) -->
<!--  -->
<!-- status order draft : halaman edit penerimaan & edit pembayaran -->

<!-- 'kategori' => tersimpan di Category model, bisa digunakan next input kategori -->
<!-- halaman penerimaan & pembayaran indexs, DataTable -->
<!-- tambah log-acrivity, simpan history bukti_transfer (storage) -->

<!-- Halaman Stok -->
<!-- `SKU = hapus!` -->
<!-- Qty = Akumulasi dr berbagai PO -->
<!-- L. Pembelian = harga bahan terakhir PO -->
<!-- Avg. Cost = rata" harga bahan -->
<!-- `Avg. FIFO = hapus!` -->
<!-- Gov. Price = di bahan baku & bahan operasional `(laravel-activitylog)` -->

Halaman Keuangan
`Anggaran -> crud biasa skip!`

Formulir Rekening Koran VA -> crud biasa + transaksi PO (nambah saldo)
debit & kredit radio button, isi salah satu
`cek & selisih = hapus`
semua kategori kecuali penerimaan = debit
penerimaan = kredit
`PO = debit`

Rekap BKU -> crud biasa + transaksi PO (ngurangi saldo)
PO = kredit