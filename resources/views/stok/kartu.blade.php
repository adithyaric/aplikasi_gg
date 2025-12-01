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
    <!-- DATATABLE -->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">Kartu Stok</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5><strong>KARTU STOK</strong></h5>
                        </div>

                        <!-- 🔹 Input Identitas Bahan -->
                        <table class="table table-borderless mb-2" style="width: 60%">
                            <tr>
                                <td style="width: 30%">Nama Bahan</td>
                                <td>
                                    :
                                    <input type="text" id="namaBahan" class="form-control d-inline-block"
                                        style="width: 70%" value="Beras" placeholder="Masukkan nama bahan..." readonly />
                                </td>
                            </tr>
                            <tr>
                                <td>Kode Akun</td>
                                <td>
                                    :
                                    <input type="text" id="kodeAkun" class="form-control d-inline-block"
                                        style="width: 70%" value="BP001" placeholder="Masukkan kode akun..." readonly />
                                </td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>
                                    :
                                    <input type="text" id="satuan" class="form-control d-inline-block"
                                        style="width: 70%" value="Gram" placeholder="Masukkan kode akun..." readonly />
                                </td>
                            </tr>
                        </table>

                        <!-- 🔹 Tabel Transaksi -->
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>
                                            <span class="invisible">----</span>Stok Awal<span class="invisible">----</span>
                                        </th>
                                        <th>
                                            <span class="invisible">-----</span>Masuk<span class="invisible">-----</span>
                                        </th>
                                        <th>
                                            <span class="invisible">-----</span>Keluar<span class="invisible">-----</span>
                                        </th>
                                        <th>
                                            Stok Akhir<br /><small>(Awal + Masuk - Keluar)</small>
                                        </th>
                                        <th>Harga Satuan (Rp)</th>
                                        <th>
                                            Nilai Persediaan<br /><small>(Stok Akhir × Harga)</small>
                                        </th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <input type="date" class="form-control" value="2025-09-15" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-awal" value="3500" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control masuk" value="545000" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control keluar" value="542700" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-akhir" value="5800" disabled />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control harga" value="13" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control nilai" value="75400" disabled />
                                        </td>
                                        <td><input type="text" class="form-control" /></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <input type="date" class="form-control" value="2025-09-16" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-awal" value="5800" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control masuk" value="536900" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control keluar" value="542700" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-akhir" value="0" disabled />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control harga" value="13" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control nilai" value="0" disabled />
                                        </td>
                                        <td><input type="text" class="form-control" /></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <input type="date" class="form-control" value="2025-09-17" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-awal" value="0"
                                                readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control masuk" value="542700" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control keluar" value="542700" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-akhir" value="0"
                                                disabled />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control harga" value="13" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control nilai" value="0" disabled />
                                        </td>
                                        <td><input type="text" class="form-control" /></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            <input type="date" class="form-control" value="2025-09-18" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-awal" value="0"
                                                readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control masuk" value="550000" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control keluar" value="542700" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-akhir" value="7300"
                                                disabled />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control harga" value="13" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control nilai" value="0" disabled />
                                        </td>
                                        <td><input type="text" class="form-control" /></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            <input type="date" class="form-control" value="2025-09-19" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-awal" value="7300"
                                                readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control masuk" value="530000" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control keluar" value="" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control stok-akhir" value=""
                                                disabled />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control harga" value="" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control nilai" value="" disabled />
                                        </td>
                                        <td><input type="text" class="form-control" /></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-end">
                                            TOTAL NILAI PERSEDIAAN
                                        </th>
                                        <th id="totalPersediaan">0</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Tombol Tambah -->
                        <div class="mt-3 d-flex justify-content-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                                <i class="bi bi-printer"></i> Cetak Kartu Stok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🔶 Modal Cetak Kartu Stok -->
    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak Kartu Stok
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Filter Periode -->
                    <div class="row mb-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" id="cetakStart" class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" id="cetakEnd" class="form-control" />
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary" id="btnFilterCetak">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <button class="btn btn-secondary" id="btnResetCetak">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </button>
                        </div>
                    </div>

                    <hr />

                    <!-- Area Cetak -->
                    <div id="printArea">
                        <div class="text-center mb-4">
                            <h5><strong>KARTU STOK</strong></h5>
                            <p class="mb-0">
                                Periode:
                                <span id="periodeCetakText">Semua Periode</span>
                            </p>
                        </div>

                        <!-- Identitas Bahan -->
                        <table class="table table-borderless mb-2" style="width: 60%">
                            <tr>
                                <td style="width: 30%">Nama Bahan</td>
                                <td>: <span id="printNamaBahan">-</span></td>
                            </tr>
                            <tr>
                                <td>Kode Akun</td>
                                <td>: <span id="printKodeAkun">-</span></td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>: <span id="printSatuan">-</span></td>
                            </tr>
                        </table>

                        <!-- Tabel Format Cetak -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="tabelCetak">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Stok Awal</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Stok Akhir</th>
                                        <th>Harga Satuan (Rp)</th>
                                        <th>Nilai Persediaan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-end">
                                            TOTAL NILAI PERSEDIAAN
                                        </th>
                                        <th id="totalCetakNilai">0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Footer Tanda Tangan -->
                        <div class="row mt-5">
                            <div class="col-6 text-center">
                                <p>Mengetahui,</p>
                                <p class="mt-5 mb-0 fw-bold">______________________</p>
                                <small>Kepala Gudang</small>
                            </div>
                            <div class="col-6 text-center">
                                <p id="tanggalCetak"></p>
                                <p class="mt-5 mb-0 fw-bold">______________________</p>
                                <small>Petugas</small>
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
        function hitungPersediaan() {
            let total = 0;

            $("#datatable tbody tr").each(function() {
                const stokAwal = parseFloat($(this).find(".stok-awal").val()) || 0;
                const masuk = parseFloat($(this).find(".masuk").val()) || 0;
                const keluar = parseFloat($(this).find(".keluar").val()) || 0;
                const harga = parseFloat($(this).find(".harga").val()) || 0;

                const stokAkhir = stokAwal + masuk - keluar;
                const nilai = stokAkhir * harga;

                $(this).find(".stok-akhir").val(stokAkhir);
                $(this).find(".nilai").val(nilai);

                total += nilai;
            });

            $("#totalPersediaan").text(total.toLocaleString("id-ID"));
        }

        // Jalankan sekali saat halaman ready
        $(document).ready(function() {
            hitungPersediaan();

            // Opsional: jika ada input yang bisa diubah, update otomatis
            $("#datatable").on("input", ".keluar, .masuk, .harga", function() {
                hitungPersediaan();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ambil data dari tabel utama
            function getTabelUtamaData() {
                const rows = [];
                $("#datatable tbody tr").each(function() {
                    const row = {
                        tanggal: $(this).find("td:eq(1) input").val(),
                        stokAwal: parseFloat($(this).find(".stok-awal").val()) || 0,
                        masuk: parseFloat($(this).find(".masuk").val()) || 0,
                        keluar: parseFloat($(this).find(".keluar").val()) || 0,
                        stokAkhir: parseFloat($(this).find(".stok-akhir").val()) || 0,
                        harga: parseFloat($(this).find(".harga").val()) || 0,
                        nilai: parseFloat($(this).find(".nilai").val()) || 0,
                        ket: $(this).find("td:eq(8) input").val() || "",
                    };
                    if (row.tanggal) rows.push(row);
                });
                return rows;
            }

            // Render ke tabel cetak
            function renderCetakTable(data) {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();
                let total = 0;

                data.forEach((item, index) => {
                    total += item.nilai;
                    tbody.append(`
                <tr>
                  <td>${index + 1}</td>
                  <td>${item.tanggal}</td>
                  <td>${item.stokAwal}</td>
                  <td>${item.masuk}</td>
                  <td>${item.keluar}</td>
                  <td>${item.stokAkhir}</td>
                  <td>${item.harga.toLocaleString("id-ID")}</td>
                  <td>${item.nilai.toLocaleString("id-ID")}</td>
                  <td>${item.ket}</td>
                </tr>
              `);
                });
                $("#totalCetakNilai").text(total.toLocaleString("id-ID"));
            }

            // Saat modal dibuka
            $("#modalCetakKartu").on("shown.bs.modal", function() {
                $("#printNamaBahan").text($("#namaBahan").val() || "-");
                $("#printKodeAkun").text($("#kodeAkun").val() || "-");
                $("#printSatuan").text($("#satuan").val() || "-");
                renderCetakTable(getTabelUtamaData());
                const today = new Date();
                $("#tanggalCetak").text(
                    `Tegal, ${today.toLocaleDateString("id-ID", {
                      day: "numeric",
                      month: "long",
                      year: "numeric",
                    })}`
                );
            });

            // Filter periode
            $("#btnFilterCetak").on("click", function() {
                const start = new Date($("#cetakStart").val());
                const end = new Date($("#cetakEnd").val());
                const all = getTabelUtamaData();

                const filtered = all.filter((r) => {
                    const t = new Date(r.tanggal);
                    return t >= start && t <= end;
                });

                renderCetakTable(filtered);
                $("#periodeCetakText").text(
                    `${$("#cetakStart").val()} s.d. ${$("#cetakEnd").val()}`
                );
            });

            // Reset filter
            $("#btnResetCetak").on("click", function() {
                $("#cetakStart").val("");
                $("#cetakEnd").val("");
                $("#periodeCetakText").text("Semua Periode");
                renderCetakTable(getTabelUtamaData());
            });
        });
    </script>
    <script>
        document
            .getElementById("btnCetakNow")
            .addEventListener("click", function() {
                const printContent = document.getElementById("printArea").outerHTML;

                // buka jendela baru (tanpa scroll)
                const printWindow = window.open(
                    "",
                    "_blank",
                    "width=1000,height=800"
                );

                // isi halaman cetak
                printWindow.document.write(`
            <html>
              <head>
                <title>Cetak Kartu Stok</title>
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
                    display: table-header-group; /* header ikut di setiap halaman */
                  }
                  tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                  }
                  h5 {
                    margin-bottom: 15px;
                  }
                  @page {
                    size: A4 landscape; /* agar tabel lebar muat semua */
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

                printWindow.document.close();
                printWindow.focus();

                // jeda supaya render selesai baru print
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 800);
            });
    </script>
@endpush
