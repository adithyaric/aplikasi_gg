@extends('layouts.master')

@section('header')
    <!-- Nav Header Component Start -->
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>DAPUR BERGIZI</h3>
                            <p>Makan Sehat Bergizi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="iq-header-img">
            <img src="{{ asset('assets/images/dashboard/top-header.png') }}" alt="header"
                class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div>
@endsection

@section('container')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">Stok Opname</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5><strong>STOK OPNAME</strong></h5>
                        </div>

                        <!-- 🔹 Input Identitas Bahan -->
                        <table class="table table-borderless mb-2" style="width: 40%">
                            <tr>
                                <td>Tanggal Stok Opname</td>
                                <td>
                                    :
                                    <input type="date" id="tglStockOpname" class="form-control d-inline-block"
                                        style="width: 70%" />
                                </td>
                            </tr>
                        </table>

                        <!-- 🔹 Tabel Stock Opname -->
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Kode</th>
                                        <th>Satuan</th>
                                        <th>Stok Fisik</th>
                                        <th>Stok di Kartu</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- Baris pertama kosong -->
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" /></td>
                                        <td>
                                            <input type="number" class="form-control kode" />
                                        </td>
                                        <td>
                                            <select class="form-select shadow-none">
                                                <option selected="">Pilih Satuan</option>
                                                <option value="1">kg</option>
                                                <option value="2">g</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stock_fisik" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stock_dikartu" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control selisih" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control keterangan" />
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm btnHapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Tombol Tambah -->
                        <div class="text-end mt-3 d-flex justify-content-between">
                            <button id="tambahBaris" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Baris
                            </button>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                                <i class="bi bi-printer"></i> Cetak Stok Opname
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔶 Modal Cetak Kartu Stok -->
    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak Stok Opname
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Area Cetak -->
                    <div id="printArea">
                        <div class="text-center mb-4">
                            <h5><strong>STOK OPNAME</strong></h5>
                        </div>

                        <!-- Identitas Stock Opname-->
                        <table class="table table-borderless mb-2" style="width: 60%">
                            <tr>
                                <td style="width: 30%">Nama SPG</td>
                                <td>: <span>03 Mandai</span></td>
                            </tr>
                            <tr>
                                <td>Kelurahan / Desa</td>
                                <td>: <span>Bontoa</span></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>: <span>Mandai</span></td>
                            </tr>
                            <tr>
                                <td>Kabupaten / Kota</td>
                                <td>: <span>Maros</span></td>
                            </tr>
                            <tr>
                                <td>Provinsi</td>
                                <td>: <span>Sulawesi Selatan</span></td>
                            </tr>
                            <tr>
                                <td>Tanggal Stok Opname</td>
                                <td>: <span id="printTglStockOpname">-</span></td>
                            </tr>
                        </table>

                        <!-- Tabel Format Cetak -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="tabelCetak">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Kode</th>
                                        <th>Satuan</th>
                                        <th>Stok Fisik</th>
                                        <th>Stok di Kartu</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Footer Tanda Tangan -->
                        <div class="row mt-5">
                            <div class="col-6 text-center">
                                <p>Mengetahui,</p>
                                <p class="mt-5 mb-0 fw-bold">______________________</p>
                                <small>Kepala SPPG</small>
                            </div>
                            <div class="col-6 text-center">
                                <p id="tanggalCetak"></p>
                                <p class="mt-5 mb-0 fw-bold">______________________</p>
                                <small>Akuntan SPPG</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                    <button class="btn btn-success" id="btnCetakNow">
                        <i class="bi bi-printer-fill"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tableBody = document.getElementById("tableBody");
            const tambahBarisBtn = document.getElementById("tambahBaris");
            const tabelCetakBody = document.querySelector("#tabelCetak tbody");
            const tanggalCetak = document.getElementById("tanggalCetak");

            // ================== BAGIAN EXISTING ==================
            function updateNomorUrut() {
                const rows = tableBody.querySelectorAll("tr");
                rows.forEach((row, index) => {
                    row.querySelector("td:first-child").textContent = index + 1;
                });
            }

            function buatBarisBaru() {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td></td>
                <td><input type="text" class="form-control" /></td>
                <td><input type="number" class="form-control kode" /></td>
                <td>
                    <select class="form-select shadow-none">
                        <option selected="">Pilih Satuan</option>
                        <option value="kg">kg</option>
                        <option value="g">g</option>
                    </select>
                </td>
                <td><input type="number" class="form-control stock_fisik" /></td>
                <td><input type="number" class="form-control stock_dikartu" /></td>
                <td><input type="number" class="form-control selisih" /></td>
                <td><input type="text" class="form-control keterangan" /></td>
                <td>
                    <button class="btn btn-danger btn-sm btnHapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
                tableBody.appendChild(newRow);
                updateNomorUrut();
            }

            tambahBarisBtn.addEventListener("click", function(e) {
                e.preventDefault();
                buatBarisBaru();
            });

            tableBody.addEventListener("click", function(e) {
                if (e.target.closest(".btnHapus")) {
                    e.preventDefault();
                    e.target.closest("tr").remove();
                    updateNomorUrut();
                }
            });

            // ================== BAGIAN BARU: CETAK DATA ==================
            const btnModalCetak = document.querySelector(
                '[data-bs-target="#modalCetakKartu"]'
            );

            btnModalCetak.addEventListener("click", function() {
                // 🔹 Ambil data identitas dari input utama
                const tglStockOpname =
                    document.getElementById("tglStockOpname").value || "-";

                // 🔹 Tampilkan ke dalam modal
                document.getElementById("printTglStockOpname").textContent =
                    tglStockOpname !== "-" ?
                    new Date(tglStockOpname).toLocaleDateString("id-ID", {
                        day: "2-digit",
                        month: "long",
                        year: "numeric",
                    }) :
                    "-";

                // 🔹 Bersihkan tabel cetak sebelumnya
                tabelCetakBody.innerHTML = "";

                // 🔹 Ambil data dari tabel utama
                const rows = tableBody.querySelectorAll("tr");
                let dataKosong = true;

                rows.forEach((row, index) => {
                    const namaBahan = row
                        .querySelector("td:nth-child(2) input")
                        .value.trim();
                    const kode = row
                        .querySelector("td:nth-child(3) input")
                        .value.trim();
                    const satuan = row.querySelector("td:nth-child(4) select").value;
                    const stockFisik = row
                        .querySelector("td:nth-child(5) input")
                        .value.trim();
                    const stockKartu = row
                        .querySelector("td:nth-child(6) input")
                        .value.trim();
                    const selisih = row
                        .querySelector("td:nth-child(7) input")
                        .value.trim();
                    const keterangan = row
                        .querySelector("td:nth-child(8) input")
                        .value.trim();

                    if (
                        namaBahan ||
                        kode ||
                        stockFisik ||
                        stockKartu ||
                        selisih ||
                        keterangan
                    ) {
                        dataKosong = false;
                        const cetakRow = document.createElement("tr");
                        cetakRow.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${namaBahan || "-"}</td>
                        <td>${kode || "-"}</td>
                        <td>${satuan || "-"}</td>
                        <td>${stockFisik || "-"}</td>
                        <td>${stockKartu || "-"}</td>
                        <td>${selisih || "-"}</td>
                        <td>${keterangan || "-"}</td>
                    `;
                        tabelCetakBody.appendChild(cetakRow);
                    }
                });

                // 🔹 Jika tidak ada data valid
                if (dataKosong) {
                    const noDataRow = document.createElement("tr");
                    noDataRow.innerHTML =
                        `<td colspan="8" class="text-center text-muted">Tidak ada data untuk dicetak</td>`;
                    tabelCetakBody.appendChild(noDataRow);
                }

                // 🔹 Tampilkan tanggal cetak otomatis
                const today = new Date();
                const formattedDate = today.toLocaleDateString("id-ID", {
                    day: "2-digit",
                    month: "long",
                    year: "numeric",
                });
                tanggalCetak.textContent = `Pacitan, ${formattedDate}`;
            });

            // ================== CETAK SEKARANG ==================
            // ================== CETAK SEKARANG (DIPERBAIKI) ==================
            document
                .getElementById("btnCetakNow")
                .addEventListener("click", function() {
                    const printContent = document.getElementById("printArea").outerHTML;

                    // buka jendela baru
                    const printWindow = window.open(
                        "",
                        "_blank",
                        "width=1000,height=800"
                    );

                    // tulis isi halaman cetak
                    printWindow.document.write(`
            <html>
                <head>
                    <title>Cetak Stok Opname</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body {
                            font-family: 'Segoe UI', sans-serif;
                            font-size: 13px;
                            margin: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            page-break-inside: auto;
                        }
                        th, td {
                            padding: 6px;
                            vertical-align: middle;
                            font-size: 12px;
                        }
                        thead {
                            display: table-header-group;
                        }
                        tr {
                            page-break-inside: avoid;
                            page-break-after: auto;
                        }
                        h5 {
                            margin-bottom: 15px;
                        }
                        @page {
                            size: A4 landscape; /* bisa ubah ke portrait jika tabel tidak lebar */
                            margin: 12mm;
                        }
                        @media print {
                            body { -webkit-print-color-adjust: exact; }
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
            </html>
        `);

                    // tutup dokumen dan fokus ke jendela cetak
                    printWindow.document.close();
                    printWindow.focus();

                    // beri jeda agar render selesai sebelum print
                    setTimeout(() => {
                        printWindow.print();
                        printWindow.close();
                    }, 800);
                });
        });
    </script>
@endpush
