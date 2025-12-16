@extends('layouts.master')
@section('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
                            <h4 class="card-title fw-bold">Rekonsiliasi</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries">
                            <div class="row align-items-end mb-4 justify-content-between">
                                <!-- 🔹 Bagian Kiri: Filter Tanggal -->
                                <div class="col d-flex flex-wrap align-items-end gap-2">
                                    <div class="col-auto">
                                        <label class="form-label mb-1">Rentang Periode</label>
                                        <input type="text" id="dateRange" class="form-control form-control-sm"
                                            placeholder="Pilih rentang tanggal" />
                                    </div>

                                    <div class="col-auto mt-4">
                                        <button id="filterDate" class="btn btn-sm btn-primary">
                                            <i class="bi bi-funnel"></i> Filter
                                        </button>
                                        <button id="resetDate" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                                        </button>
                                    </div>
                                </div>

                                <!-- 🔹 Bagian Kanan: Tombol Cetak -->
                                <div class="col-auto text-end">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalCetakKartu">
                                        <i class="bi bi-printer"></i> Cetak Rekonsiliasi
                                    </button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-striped" data-toggle="data-table" cellspacing="0"
                                cellpadding="5">
                                <thead class="text-center align-middle">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Tanggal</th>
                                        <th colspan="2">Rekening Koran</th>
                                        <th colspan="2">Detail BKU</th>
                                        <th rowspan="2">Selisih</th>
                                        <th rowspan="2">Status</th>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Transaksi</th>
                                        <th>Nilai Transaksi</th>
                                        <th>Jumlah Transaksi</th>
                                        <th>Nilai Transaksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($reconciliationData as $item)
                                        <tr>
                                            <td>{{ $item['no'] }}</td>
                                            <td>{{ $item['tanggal'] }}</td>
                                            <td>{{ $item['jml_rek'] }}</td>
                                            <td>{{ number_format($item['nilai_rek'], 0, ',', '.') }}</td>
                                            <td>{{ $item['jml_buku'] }}</td>
                                            <td>{{ number_format($item['nilai_buku'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($item['selisih'], 0, ',', '.') }}</td>
                                            <td>
                                                @if ($item['status'] === 'Match')
                                                    <span class="badge bg-success">Match</span>
                                                @else
                                                    <span class="badge bg-danger">No Match</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "d/m/Y",
            locale: "id", // biar pakai bahasa Indonesia
            altInput: true,
            altFormat: "j F Y", // contoh: 24 April 2025
            allowInput: true,
        });
    </script>
    <script>
        $(document).ready(function() {
            // 🔹 Cek apakah DataTable sudah ada
            let table;
            if ($.fn.DataTable.isDataTable("#datatable")) {
                table = $("#datatable").DataTable(); // gunakan instance yang sudah ada
            } else {
                table = $("#datatable").DataTable({
                    scrollX: true,
                    pageLength: 10,
                    autoWidth: false,
                });
            }

            // 🔹 Inisialisasi Flatpickr (Range)
            const fp = flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "id",
                altInput: true,
                altFormat: "j F Y",
                allowInput: true,
            });

            // 🔹 Fungsi bantu parse tanggal
            function parseDate(str) {
                if (!str) return null;
                // Format: "24 April 2025"
                const months = {
                    'Januari': 0,
                    'Februari': 1,
                    'Maret': 2,
                    'April': 3,
                    'Mei': 4,
                    'Juni': 5,
                    'Juli': 6,
                    'Agustus': 7,
                    'September': 8,
                    'Oktober': 9,
                    'November': 10,
                    'Desember': 11
                };

                const parts = str.split(' ');
                const day = parseInt(parts[0]);
                const month = months[parts[1]];
                const year = parseInt(parts[2]);

                return new Date(year, month, day);
            }

            // 🔹 Tombol Filter ditekan
            $("#filterDate").on("click", function() {
                const range = fp.selectedDates;
                if (range.length === 2) {
                    const min = range[0];
                    const max = range[1];

                    $.fn.dataTable.ext.search.push(function(settings, data) {
                        if (settings.nTable.id !== "datatable") return true;
                        const tanggalTabel = data[1]; // kolom tanggal
                        const date = parseDate(tanggalTabel);
                        if (!date) return false;
                        return date >= min && date <= max;
                    });

                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                } else {
                    alert("Silakan pilih rentang tanggal terlebih dahulu.");
                }
            });

            // 🔹 Tombol Reset ditekan
            $("#resetDate").on("click", function() {
                fp.clear();
                table.search("").draw();
            });
        });
    </script>

    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak Rekonsiliasi
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
                            <h5><strong>REKONSILIASI</strong></h5>
                            <p class="mb-0">
                                Periode:
                                <span id="periodeCetakText">Semua Periode</span>
                            </p>
                        </div>

                        <!-- Tabel Format Cetak -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="tabelCetak">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Transaksi (Rek. Koran)</th>
                                        <th>Nilai Transaksi (Rek. Koran)</th>
                                        <th>Jumlah Transaksi (Buku)</th>
                                        <th>Nilai Transaksi (Buku)</th>
                                        <th>Selisih</th>
                                        <th>Status</th>
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
                                <small>Kepala Bagian</small>
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
                    <button class="btn btn-danger" id="btnCetakNow">
                        <i class="bi bi-printer-fill"></i> Cetak PDF
                    </button>
                    <a href="{{ route('export.rekonsiliasi') }}" class="btn btn-success ms-2">
                        <i class="bi bi-file-earmark-excel"></i> Export
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // 🔹 Ambil data dari tabel utama
            function getTabelUtamaData() {
                const rows = [];
                $("#datatable tbody tr").each(function() {
                    const row = {
                        no: $(this).find("td:eq(0)").text().trim(),
                        tanggal: $(this).find("td:eq(1)").text().trim(),
                        jmlRek: $(this).find("td:eq(2)").text().trim(),
                        nilaiRek: parseFloat(
                            $(this)
                            .find("td:eq(3)")
                            .text()
                            .replace(/[^\d.-]/g, "")
                        ) || 0,
                        jmlBuku: $(this).find("td:eq(4)").text().trim(),
                        nilaiBuku: parseFloat(
                            $(this)
                            .find("td:eq(5)")
                            .text()
                            .replace(/[^\d.-]/g, "")
                        ) || 0,
                        selisih: parseFloat(
                            $(this)
                            .find("td:eq(6)")
                            .text()
                            .replace(/[^\d.-]/g, "")
                        ) || 0,
                        status: $(this).find("td:eq(7)").text().trim(),
                    };
                    if (row.tanggal) rows.push(row);
                });
                return rows;
            }

            // 🔹 Render ke tabel cetak
            function renderCetakTable(data) {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();

                let totalRek = 0,
                    totalBuku = 0,
                    totalSelisih = 0;

                data.forEach((item, i) => {
                    totalRek += item.nilaiRek;
                    totalBuku += item.nilaiBuku;
                    totalSelisih += item.selisih;

                    tbody.append(`
              <tr>
                <td>${i + 1}</td>
                <td>${item.tanggal}</td>
                <td>${item.jmlRek}</td>
                <td>${item.nilaiRek.toLocaleString("id-ID")}</td>
                <td>${item.jmlBuku}</td>
                <td>${item.nilaiBuku.toLocaleString("id-ID")}</td>
                <td>${item.selisih.toLocaleString("id-ID")}</td>
                <td>${item.status}</td>
              </tr>
            `);
                });
            }

            // 🔹 Saat modal dibuka
            $("#modalCetakKartu").on("shown.bs.modal", function() {
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

            // 🔹 Filter tanggal
            $("#btnFilterCetak").on("click", function() {
                const start = new Date($("#cetakStart").val());
                const end = new Date($("#cetakEnd").val());
                const all = getTabelUtamaData();

                const filtered = all.filter((r) => {
                    // Contoh format tanggal kamu: "24 April 2025"
                    const tgl = new Date(
                        r.tanggal.replace(/(\d+)\s(\w+)\s(\d+)/, "$1 $2 $3")
                    );
                    return tgl >= start && tgl <= end;
                });

                renderCetakTable(filtered);
                $("#periodeCetakText").text(
                    `${$("#cetakStart").val()} s.d. ${$("#cetakEnd").val()}`
                );
            });

            // 🔹 Reset filter
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
            <title>Cetak Rekonsiliasi</title>
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
