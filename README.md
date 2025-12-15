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

<!-- Halaman Keuangan `Anggaran -> crud biasa skip!` -->

<!-- Formulir Rekening Koran VA -->
<!-- -> crud biasa + transaksi PO (nambah saldo) -->
<!-- debit & kredit radio button, isi salah satu -->
<!-- `cek & selisih = hapus input` -->
<!-- semua kategori kecuali penerimaan = debit -->
<!-- penerimaan = kredit -->
<!-- `PO/Order = debit` -->

<!-- Rekap BKU -> crud biasa + transaksi PO (ngurangi saldo) -->
<!-- PO = kredit -->

<!-- Revisi : -->
<!-- `1. Bahan baku & Bahan Operasional - kelompok = kategori` -->
<!-- `2. Bahan baku & Bahan Operasional - kategori tidak ada drop down` -->
<!-- `3. ⁠⁠Bahan baku & Bahan Operasional - jenis dihilangkan` -->
<!-- `4. ⁠Sekolah - Satuan jarak (KM)` -->
<!-- `5. ⁠Sekolah - Peta hanya bisa di akses di makassar (Buat akses penuh)` -->
<!-- `6. ⁠Perencanaan menu - Jumlah porsi menghitung otomatis dari jumlah porsi yg diinput disekolah` -->
<!-- `7. ⁠Perencanaan menu - (detail) kebutuhan per porsi diambil dari berat bersih dipaket menu satuan gram` -->
<!-- `8. ⁠Perencanaan menu - (detail) perporsi ambil dari paket menu berat bersih gram. Saat narik diperencanaan menu perporsi otomatis konversi ke Kg` -->
<!-- 9. ⁠Tambah menu PO - hasil dari penarikan perencanaan menu per porsi -->
<!-- `10. ⁠Purchase Order - ID PO perlu perbaikan P000 dimulai dari 1, ada format order_number terbaru` -->
<!-- `11. ⁠Purchase Order - tambahkan tombol Post` -->
<!-- `12. ⁠Purchase Order - subtotal per item` -->
<!-- `13. ⁠Purchase Order - Detail PO riwayat bukti transfer pindah ke pembayaran` -->
<!-- `14. ⁠Penerimaan barang - qty diterima, tidak diterima ubah jadi sesuai, tidak sesuai` -->
<!-- `15. ⁠Penerimaan barang - penambahan stok diambil dari barang diterima, (draft & confirm) tidak mempengaruhi apapun` -->
<!-- 16. `⁠Pembayaran - nominal tabel dibayar sesuai dengan yg sudah dibayar` menjumlahkan nominal partial. Apabila blm bayar maka nominal dibayar 0. -->
<!-- `17. ⁠Pembayaran - Detail Inputan kembali 0 ketika melakukan pembayaran partial.` -->
<!-- `18. ⁠Pembayaran - Detail pembayaran partial belum ter record history pembayaran sebelumnya masukkan di dalam edit juga (Seperti nomor 13)` -->
<!-- `19. ⁠Pembayaran - Bukti belum muncul (public)` -->
<!-- `20. ⁠Pembayaran- Filter (unpaid,paid, partial) belum berfungsi` -->
<!-- `21. ⁠Stok - Rumus avg cost diganti. Total harga pembelian produk semua(dari awal sampai akhir) dibagi qty produk semua(dari awal sampai terakhir)` -->
<!-- `22. ⁠Stok - Tambahkan History gov price (Pop Up Detail Pada Stock)` -->
<!-- `23. Rekening Koran VA - Edit Pada Rekening Koran Berikan Saldo Juga` -->
<!-- `24. Rekening Koran VA - Jika Menambahkan Data Rekon VA Di Waktu Sebelumnya Maka Saldo Tidak Sesuai` -->
<!-- `25. Rekap BKU - Transaksi Pembayaran PO harusnya auto masuk ke dalam BKU (Tanpa Add Manual)` -->
<!-- 26. Rekap BKU - Jenis Bahan Dibuat Dropdown isi (Penerimaan BGN, Bahan Pokok, Bahan Operasional, Pembayaran Sewa) -->
<!-- 27. Rekap BKU - Nama Bahan Ambil Dari Data Bahan Pokok & Data Bahan Operasional -->
<!-- 28. Rekap BKU - Supplier Ambil Dari Data Supplier -->
<!-- 29. Rekap BKU - Debit Kredit Isi Salah Satu Buat Seperti Pada Rekening Koran VA (Radio) -->
<!-- `30. Rekap BKU - Hapus Bulan & Minggu` -->
<!-- 31. Rekap BKU - Jika Menambahkan Data, Rekap BKU Di Waktu Sebelumnya Maka Saldo Tidak Sesuai -->

<!-- `32. Kartu Stock Dibuat Sekalian` -->
<!-- `33. Stock Opname Dibuat Sekalian` -->
<!-- lpdb -->
<!-- lra -->
<!-- import -->
<!-- - bahan baku -->
<!-- - bahan operasional -->
<!-- - database gizi -->
<!-- - sekolah -->
<!-- - supplier -->
<!-- - relawan/karyawan -->

<!-- tabel setting (informasi utama) -->
<!-- dashboard -->

export :
- rekap penerimaan dana
<!-- - rekap prosi -->
- rekonsiliasi
- bku
- lpdb
- lbbp
- lbo
- lbs
- lra
<!-- - sekolah -->
<!-- - supplier -->
<!-- - relawan -->
<!-- - absensi -->
<!-- - gaji -->
- rekap menu
- lembar po
- bast
- stock
- kartu stock
- stock opname