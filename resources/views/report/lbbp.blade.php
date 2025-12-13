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
                            <h4 class="card-title fw-bold">LBBP</h4>
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
                                        <i class="bi bi-printer"></i> Cetak LBBP
                                    </button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-striped align-middle" data-toggle="data-table"
                                cellspacing="0" cellpadding="5">
                                <thead class="text-center align-middle">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Tanggal</th>
                                        <th rowspan="2">Nama Bahan</th>
                                        <th colspan="4">Total</th>
                                        <th rowspan="2">Supplier</th>
                                        <th rowspan="2">Survei Harga per kg/l (Rp)</th>
                                    </tr>
                                    <tr>
                                        <th>Kuantitas</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['tanggal']->format('d M Y') }}</td>
                                            <td>{{ $item['nama_bahan'] }}</td>
                                            <td>{{ number_format($item['kuantitas'], 0, ',', '.') }}</td>
                                            <td>{{ $item['satuan'] }}</td>
                                            <td>{{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($item['total'], 0, ',', '.') }}</td>
                                            <td>{{ $item['supplier'] }}</td>
                                            <td>{{ number_format($item['gov_price'], 0, ',', '.') }}</td>
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

    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakLBBPlabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak Laporan Buku Bahan Pokok
                        (LBBP)
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
                            <h5><strong>Laporan Buku Bahan Pokok (LBBP)</strong></h5>
                            <p class="mb-0">
                                Periode: <span id="periodeCetakText">Semua Periode</span>
                            </p>
                        </div>

                        <!-- Tabel Cetak -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="tabelCetak">
                                <thead class="table-light align-middle">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Bahan</th>
                                        <th>Kuantitas</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan (Rp)</th>
                                        <th>Total (Rp)</th>
                                        <th>Supplier</th>
                                        <th>Survei Harga per kg/l (Rp)</th>
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
                    // 🔹 Ambil data dari tabel utama LBBP
                    function getTabelUtamaData() {
                        const rows = [];
                        $("#datatable tbody tr").each(function() {
                            const tanggalTd = $(this).find("td:eq(1)");
                            const tanggalText = tanggalTd.text().trim();

                            const row = {
                                no: $(this).find("td:eq(0)").text().trim(),
                                tanggal: tanggalText,
                                namaBahan: $(this).find("td:eq(2)").text().trim(),
                                kuantitas: parseFloat(
                                    $(this).find("td:eq(3)").text().replace(/[^\d.-]/g, "")
                                ) || 0,
                                satuan: $(this).find("td:eq(4)").text().trim(),
                                hargaSatuan: parseFloat(
                                    $(this).find("td:eq(5)").text().replace(/[^\d.-]/g, "")
                                ) || 0,
                                total: parseFloat(
                                    $(this).find("td:eq(6)").text().replace(/[^\d.-]/g, "")
                                ) || 0,
                                supplier: $(this).find("td:eq(7)").text().trim(),
                                surveiHarga: $(this).find("td:eq(8)").text().trim(),
                                // Store original date for filtering
                                originalDate: tanggalText
                            };
                            if (row.tanggal) rows.push(row);
                        });
                        return rows;
                    }

                    // Update the filter function to use proper date format:
                    $("#filterDate").on("click", function() {
                                const range = fp.selectedDates;
                                if (range.length === 2) {
                                    const min = range[0];
                                    const max = range[1];

                                    $.fn.dataTable.ext.search.push(function(settings, data) {
                                        if (settings.nTable.id !== "datatable") return true;

                                        // Parse DD/MM/YYYY format from table
                                        const tanggalTabel = data[1];
                                        const [day, month, year] = tanggalTabel.split('/');
                                        const date = new Date(year, month - 1, day);

                                        if (!date || isNaN(date)) return false;
                                        return date >= min && date <= max;
                                    });
                                    table.draw();
                                    $.fn.dataTable.ext.search.pop();
                                } else {
                                    alert("Silakan pilih
                                        rentang tanggal terlebih dahulu.
                                        "); } });

                                        // 🔹 Render ke tabel cetak
                                        function renderCetakTable(data) {
                                            const tbody = $("#tabelCetak tbody");
                                            tbody.empty();
                                            let totalNilai = 0;

                                            data.forEach((item, i) => {
                                                totalNilai += item.total;
                                                tbody.append(`
        <tr>
          <td>${i + 1}</td>
          <td>${item.tanggal}</td>
          <td>${item.namaBahan}</td>
          <td>${item.kuantitas}</td>
          <td>${item.satuan}</td>
          <td>${item.hargaSatuan.toLocaleString("id-ID")}</td>
          <td>${item.total.toLocaleString("id-ID")}</td>
          <td>${item.supplier}</td>
          <td>${item.surveiHarga}</td>
        </tr>
      `);
                                            });

                                            // Tambahkan total di bawah tabel
                                            //       tbody.append(`
                                        //   <tr class="fw-bold table-light">
                                        //     <td colspan="6" class="text-end">TOTAL</td>
                                        //     <td>${totalNilai.toLocaleString("id-ID")}</td>
                                        //     <td colspan="2"></td>
                                        //   </tr>
                                        // `);
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
                                                const parts = r.tanggal.split(/[\/-]/);
                                                if (parts.length < 3) return false;
                                                const year = parts[0].length === 4 ? parts[0] : parts[2];
                                                const tgl = new Date(year, parts[1] - 1, parts[0]);
                                                return (
                                                    (!isNaN(start) ? tgl >= start : true) &&
                                                    (!isNaN(end) ? tgl <= end : true)
                                                );
                                            });

                                            renderCetakTable(filtered);
                                            $("#periodeCetakText").text(
                                                `${$("#cetakStart").val() || "?"} s.d. ${
              $("#cetakEnd").val() || "?"
            }`
                                            );
                                        });

                                        // 🔹 Reset filter
                                        $("#btnResetCetak").on("click", function() {
                                            $("#cetakStart").val("");
                                            $("#cetakEnd").val("");
                                            $("#periodeCetakText").text("Semua Periode");
                                            renderCetakTable(getTabelUtamaData());
                                        });

                                        // 🔹 Tombol Cetak ke Jendela Baru
                                        $(document).on("click", "#btnCetakNow", function() {
                                            const printContent = document.getElementById("printArea").outerHTML;
                                            const printWindow = window.open(
                                                "",
                                                "_blank",
                                                "width=1000,height=800"
                                            );
                                            printWindow.document.write(`
      <html>
        <head>
          <title>Cetak LBBP</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
          <style>
            body { font-family: 'Segoe UI', sans-serif; font-size: 13px; margin: 20px; }
            table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
            th, td { padding: 6px; vertical-align: middle; font-size: 12px; }
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            h5 { margin-bottom: 15px; }
            @page { size: A4 landscape; margin: 12mm; }
            @media print { body { -webkit-print-color-adjust: exact; } }
          </style>
        </head>
        <body>${printContent}</body>
      </html>
    `);
                                            printWindow.document.close();
                                            printWindow.focus();

                                            setTimeout(() => {
                                                printWindow.print();
                                                printWindow.close();
                                            }, 800);
                                        });
                                    });
    </script>
@endpush
