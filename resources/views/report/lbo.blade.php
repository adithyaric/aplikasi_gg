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
        <!-- Modal Detail PO -->
        <div class="modal fade" id="modalOrderDetailBKU" tabindex="-1" aria-labelledby="modalOrderDetailBKULabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content"
                    style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="modalOrderDetailBKULabel">Detail Purchase Order</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">No PO</label>
                                        <p id="detail_order_number_bku" class="form-control-plaintext"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Supplier</label>
                                        <p id="detail_supplier_bku" class="form-control-plaintext"></p>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal PO</label>
                                        <p id="detail_tanggal_po_bku" class="form-control-plaintext"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal Penerimaan</label>
                                        <p id="detail_tanggal_penerimaan_bku" class="form-control-plaintext"></p>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Grand Total</label>
                                        <p id="detail_grand_total_bku" class="form-control-plaintext"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Status</label>
                                        <p id="detail_status_bku" class="form-control-plaintext"></p>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label fw-bold">Items</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Bahan Baku</th>
                                                    <th>Quantity</th>
                                                    <th>Harga</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_items_bku"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
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
                            <h4 class="card-title fw-bold">LBO</h4>
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
                                        <i class="bi bi-printer"></i> Cetak LBO
                                    </button>
                                </div>
                            </div>

                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>Nominal</th>
                                        <th>Link PO</th>
                                        {{-- <th>Keterangan</th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item['tanggal']->format('d M Y') }}</td>
                                            <td>{{ $item['uraian'] }}</td>
                                            <td>{{ number_format($item['nominal'], 0, ',', '.') }}</td>
                                            {{-- <td>{{ $item['keterangan'] }}</td> --}}
                                            <td>
                                                {{-- <span class="badge bg-info">{{ $item['link_po'] }}</span> --}}
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="showOrderDetailBKU({{ $item['link_po_id'] }})">
                                                    {{ $item['link_po'] }}
                                                </button>
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
<script>
    function showOrderDetailBKU(id) {
    $.ajax({
        url: "{{ route('orders.index') }}/" + id,
        method: 'GET',
        success: function(response) {
            $('#detail_order_number_bku').text(response.order_number);
            $('#detail_supplier_bku').text(response.supplier?.nama || '-');
            $('#detail_tanggal_po_bku').text(response.tanggal_po ? new Date(response.tanggal_po)
                .toLocaleDateString('id-ID') : '-');
            $('#detail_tanggal_penerimaan_bku').text(response.tanggal_penerimaan ? new Date(response
                .tanggal_penerimaan).toLocaleDateString('id-ID') : '-');
            $('#detail_grand_total_bku').text('Rp ' + new Intl.NumberFormat('id-ID').format(response
                .grand_total || 0));
            $('#detail_status_bku').text(response.status || '-');

            // Clear items table
            $('#detail_items_bku').empty();

            // Populate items
            if (response.items && response.items.length > 0) {
                response.items.forEach(function(item) {
                    $('#detail_items_bku').append(
                        '<tr>' +
                        '<td>' + (item.bahan_baku?.nama || item.bahan_operasional?.nama) +
                        '</td>' +
                        '<td>' + (item.quantity || 0) + '</td>' +
                        '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.unit_cost ||
                            0) + '</td>' +
                        '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.subtotal ||
                            0) + '</td>' +
                        '</tr>'
                    );
                });
            } else {
                $('#detail_items_bku').append(
                    '<tr><td colspan="4" class="text-center">Tidak ada items</td></tr>');
            }

            $('#modalOrderDetailBKU').modal('show');
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengambil data detail'
            });
        }
    });
}
</script>

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

    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak LBO
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
                            <h5><strong>Laporan Belanja Operasional (LBO)</strong></h5>
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
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>Nominal</th>
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
            // 🔹 Ambil data dari tabel utama
            function getTabelUtamaData() {
                const rows = [];
                $("#datatable tbody tr").each(function() {
                    const row = {
                        no: $(this).find("td:eq(0)").text().trim(),
                        tanggal: $(this).find("td:eq(1)").text().trim(),
                        uraian: $(this).find("td:eq(2)").text().trim(),
                        nominal: parseFloat(
                            $(this)
                            .find("td:eq(3)")
                            .text()
                            .replace(/\./g, "")
                            .replace(",", ".")
                        ) || 0,
                        keterangan: $(this).find("td:eq(4)").text().trim(),
                    };
                    if (row.tanggal) rows.push(row);
                });
                return rows;
            }

            // 🔹 Render ke tabel cetak
            function renderCetakTable(data) {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();

                let totalNominal = 0;

                data.forEach((item, i) => {
                    totalNominal += item.nominal;
                    tbody.append(`
              <tr>
                <td>${i + 1}</td>
                <td>${item.tanggal}</td>
                <td>${item.uraian}</td>
                <td>${item.nominal.toLocaleString("id-ID")}</td>
                <td>${item.keterangan}</td>
              </tr>
            `);
                });

                $("#totalNominal").text(totalNominal.toLocaleString("id-ID"));
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
                const startVal = $("#cetakStart").val();
                const endVal = $("#cetakEnd").val();

                if (!startVal || !endVal) {
                    alert("Silakan pilih rentang tanggal terlebih dahulu.");
                    return;
                }

                const start = new Date(startVal);
                const end = new Date(endVal);

                const all = getTabelUtamaData();

                const filtered = all.filter((r) => {
                    if (!r.tanggal) return false;

                    // Pecah berdasarkan "/"
                    const parts = r.tanggal.split(/[\/]/);

                    if (parts.length < 3) return false; // format tidak valid

                    let [day, month, year] = parts;

                    // Pastikan semuanya angka
                    day = parseInt(day);
                    month = parseInt(month);
                    year = parseInt(year);

                    // 🔹 Jika tahun hanya 2 digit, tambahkan 2000
                    if (year < 100) {
                        year = 2000 + year;
                    }

                    const tgl = new Date(year, month - 1, day);
                    return tgl >= start && tgl <= end;
                });

                renderCetakTable(filtered);

                // Update teks periode
                const formatDate = (val) => {
                    const d = new Date(val);
                    return d.toLocaleDateString("id-ID", {
                        day: "2-digit",
                        month: "2-digit",
                        year: "numeric",
                    });
                };

                $("#periodeCetakText").text(
                    `${formatDate(startVal)} s.d. ${formatDate(endVal)}`
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
