@extends('layouts.master')
@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $title }}</h3>
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
                            <h4 class="card-title fw-bold">LRA</h4>
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
                                            placeholder="Pilih rentang tanggal"
                                            value="@if ($startDate && $endDate) {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }} @endif" />
                                        <form id="dateFilterForm" method="GET" style="display: none;">
                                            <input type="hidden" name="start_date" id="hiddenStartDate">
                                            <input type="hidden" name="end_date" id="hiddenEndDate">
                                        </form>
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
                                        <i class="bi bi-printer"></i> Cetak LRA
                                    </button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead class="align-middle">
                                    <tr>
                                        <th>Uraian</th>
                                        <th>Anggaran</th>
                                        <th>Realisasi</th>
                                        <th>%</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- 🔹 Bagian Penerimaan -->
                                    <tr>
                                        <td class="fw-bold text-start">Penerimaan</td>
                                        <td style="color: transparent">1</td>
                                        <td style="color: transparent">2</td>
                                        <td style="color: transparent">3</td>
                                    </tr>
                                    @foreach ($penerimaanItems as $item)
                                        <tr>
                                            <td class="text-start">{{ $item['uraian'] }}</td>
                                            <td>{{ number_format($item['anggaran'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($item['realisasi'], 0, ',', '.') }}</td>
                                            <td>{{ $item['anggaran'] > 0
                                                ? number_format(($item['realisasi'] / $item['anggaran']) * 100, 2, ',', '.') . '%'
                                                : '0,00%' }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- 🔹 Bagian Belanja -->
                                    <tr>
                                        <td class="fw-bold text-start">Belanja</td>
                                        <td style="color: transparent">1</td>
                                        <td style="color: transparent">2</td>
                                        <td style="color: transparent">3</td>
                                    </tr>
                                    @foreach ($belanjaItems as $item)
                                        <tr>
                                            <td class="text-start">{{ $item['uraian'] }}</td>
                                            <td>{{ number_format($item['anggaran'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($item['realisasi'], 0, ',', '.') }}</td>
                                            <td>{{ $item['anggaran'] > 0
                                                ? number_format(($item['realisasi'] / $item['anggaran']) * 100, 2, ',', '.') . '%'
                                                : '0,00%' }}
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
        flatpickr("#startDate", {
            inline: true,
            dateFormat: "d/m/Y",
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
                const [day, month, year] = str.split("/");
                return new Date(`${year}-${month}-${day}`);
            }

            // 🔹 Tombol Filter ditekan
            $("#filterDate").on("click", function() {
                const range = fp.selectedDates;
                if (range.length === 2) {
                    const startDate = range[0].toISOString().split('T')[0];
                    const endDate = range[1].toISOString().split('T')[0];

                    $("#hiddenStartDate").val(startDate);
                    $("#hiddenEndDate").val(endDate);
                    $("#dateFilterForm").submit();
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
                        <i class="bi bi-printer-fill"></i> Cetak Laporan Realisasi
                        Anggaran (LRA)
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
                            <h5><strong>Laporan Realisasi Anggaran (LRA)</strong></h5>
                            <p class="mb-0">
                                Periode:
                                <span id="periodeCetakText">Semua Periode</span>
                            </p>
                        </div>

                        <!-- Tabel Cetak -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="tabelCetak">
                                <thead class="table-light">
                                    <tr>
                                        <th>Uraian</th>
                                        <th>Anggaran</th>
                                        <th>Realisasi</th>
                                        <th>%</th>
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
                                <small>Petugas Keuangan</small>
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

    <script>
        $(document).ready(function() {
            // 🔹 Ambil data dari tabel utama (Uraian, Anggaran, Realisasi, Persentase)
            function getTabelUtamaData() {
                const rows = [];
                $("#datatable tbody tr").each(function() {
                    const row = {
                        uraian: $(this).find("td:eq(0)").text().trim(),
                        anggaran: parseFloat(
                            $(this)
                            .find("td:eq(1)")
                            .text()
                            .replace(/[^\d.-]/g, "")
                        ) || 0,
                        realisasi: parseFloat(
                            $(this)
                            .find("td:eq(2)")
                            .text()
                            .replace(/[^\d.-]/g, "")
                        ) || 0,
                        persen: $(this).find("td:eq(3)").text().trim(),
                    };

                    // Hanya tambahkan baris jika ada uraian
                    if (row.uraian) rows.push(row);
                });
                return rows;
            }

            // 🔹 Render data ke tabel cetak
            function renderCetakTable(data) {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();

                let totalAnggaran = 0;
                let totalRealisasi = 0;

                data.forEach((item) => {
                    const isHeader =
                        item.uraian.toLowerCase() === "penerimaan" ||
                        item.uraian.toLowerCase() === "belanja";

                    // Jika baris header (penerimaan/belanja), kosongkan nilai angka tapi tetap buat kolom
                    const anggaranText = isHeader ?
                        `<span style="color: transparent">1</span>` :
                        item.anggaran.toLocaleString("id-ID");
                    const realisasiText = isHeader ?
                        `<span style="color: transparent">2</span>` :
                        item.realisasi.toLocaleString("id-ID");
                    const persenText = isHeader ?
                        `<span style="color: transparent">3</span>` :
                        item.persen;

                    // Hitung total hanya untuk baris non-header
                    if (!isHeader) {
                        totalAnggaran += item.anggaran;
                        totalRealisasi += item.realisasi;
                    }

                    // Tambahkan baris ke tabel cetak
                    tbody.append(`
          <tr ${isHeader ? 'class="fw-bold"' : ""}>
            <td class="text-start">${item.uraian}</td>
            <td class="text-end">${anggaranText}</td>
            <td class="text-end">${realisasiText}</td>
            <td>${persenText}</td>
          </tr>
        `);
                });

                // 🔹 Hitung persentase total (hindari pembagian 0)
                const persenTotal =
                    totalAnggaran > 0 ?
                    ((totalRealisasi / totalAnggaran) * 100).toFixed(2) + "%" :
                    "0%";

                // Jika mau, tambahkan total di akhir:
                // tbody.append(`
            //   <tr class="fw-bold table-secondary">
            //     <td class="text-end">Total</td>
            //     <td class="text-end">${totalAnggaran.toLocaleString("id-ID")}</td>
            //     <td class="text-end">${totalRealisasi.toLocaleString("id-ID")}</td>
            //     <td>${persenTotal}</td>
            //   </tr>
            // `);
            }

            // 🔹 Saat modal dibuka
            $("#modalCetakKartu").on("shown.bs.modal", function() {
                renderCetakTable(getTabelUtamaData());

                // Set tanggal cetak otomatis
                const today = new Date();
                $("#tanggalCetak").text(
                    `Tegal, ${today.toLocaleDateString("id-ID", {
                  day: "numeric",
                  month: "long",
                  year: "numeric",
                })}`
                );
            });

            // 🔹 Filter tanggal (karena tabel LRA tidak ada tanggal, tombol ini hanya simbolik)
            $("#btnFilterCetak").on("click", function() {
                const start = $("#cetakStart").val();
                const end = $("#cetakEnd").val();

                if (!start || !end) {
                    alert("Silakan pilih rentang tanggal terlebih dahulu.");
                    return;
                }

                // Data tidak difilter karena tabel tidak memiliki kolom tanggal
                $("#periodeCetakText").text(`${start} s.d. ${end}`);
            });

            // 🔹 Reset filter
            $("#btnResetCetak").on("click", function() {
                $("#cetakStart").val("");
                $("#cetakEnd").val("");
                $("#periodeCetakText").text("Semua Periode");
                renderCetakTable(getTabelUtamaData());
            });

            // 🔹 Cetak
            $("#btnCetakNow").on("click", function() {
                const printContents = document.getElementById("printArea").innerHTML;
                const printWindow = window.open("", "", "height=800,width=1000");
                printWindow.document.write("<html><head><title>Cetak</title>");
                printWindow.document.write(
                    '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">'
                );
                printWindow.document.write("</head><body>");
                printWindow.document.write(printContents);
                printWindow.document.write("</body></html>");
                printWindow.document.close();
                printWindow.print();
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
            <title>Cetak Rekap BKU</title>
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
