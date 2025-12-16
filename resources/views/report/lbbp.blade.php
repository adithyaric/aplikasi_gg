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
                        <div class="custom-datatableLBBP-entries">
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

                            <table id="datatableLBBP" class="table table-striped align-middle" data-toggle="data-table"
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
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {

            /* =========================
               INIT DATATABLE
            ========================= */
            const table = $.fn.DataTable.isDataTable("#datatableLBBP") ?
                $("#datatableLBBP").DataTable() :
                $("#datatableLBBP").DataTable({
                    scrollX: true,
                    pageLength: 10,
                    autoWidth: false,
                });


            /* =========================
               DATE PARSER (d M Y)
               ex: 01 Dec 2025
            ========================= */
            function parseTanggal(str) {
                const months = {
                    Jan: 0,
                    Feb: 1,
                    Mar: 2,
                    Apr: 3,
                    May: 4,
                    Jun: 5,
                    Jul: 6,
                    Aug: 7,
                    Sep: 8,
                    Oct: 9,
                    Nov: 10,
                    Dec: 11
                };
                const p = str.split(" ");
                if (p.length !== 3) return null;
                return new Date(p[2], months[p[1]], p[0]);
            }

            /* =========================
               MAIN DATE RANGE FILTER
            ========================= */
            const fp = flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "id",
                altInput: true,
                altFormat: "j F Y"
            });

            $("#filterDate").on("click", function() {
                if (fp.selectedDates.length !== 2) return;

                const min = fp.selectedDates[0];
                const max = fp.selectedDates[1];

                $.fn.dataTable.ext.search.push(function(settings, data) {
                    if (settings.nTable.id !== "datatableLBBP") return true;

                    const tgl = parseTanggal(data[1]);
                    if (!tgl) return false;

                    tgl.setHours(0, 0, 0, 0);
                    min.setHours(0, 0, 0, 0);
                    max.setHours(23, 59, 59, 999);

                    return tgl >= min && tgl <= max;
                });

                table.draw();
                $.fn.dataTable.ext.search.pop();
            });

            $("#resetDate").on("click", function() {
                fp.clear();
                table.search("").draw();
            });

            /* =========================
               GET DATA FOR MODAL
            ========================= */
            function getTableData() {
                const rows = [];

                table.rows({
                    search: "applied"
                }).every(function() {
                    const d = this.data();
                    rows.push({
                        tanggal: d[1],
                        namaBahan: d[2],
                        kuantitas: d[3],
                        satuan: d[4],
                        hargaSatuan: d[5],
                        total: d[6],
                        supplier: d[7],
                        surveiHarga: d[8]
                    });
                });

                return rows;
            }

            /* =========================
               RENDER MODAL TABLE
            ========================= */
            function renderCetak(data) {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();

                data.forEach((r, i) => {
                    tbody.append(`
                <tr>
                    <td>${i + 1}</td>
                    <td>${r.tanggal}</td>
                    <td>${r.namaBahan}</td>
                    <td>${r.kuantitas}</td>
                    <td>${r.satuan}</td>
                    <td>${r.hargaSatuan}</td>
                    <td>${r.total}</td>
                    <td>${r.supplier}</td>
                    <td>${r.surveiHarga}</td>
                </tr>
            `);
                });
            }

            /* =========================
               MODAL OPEN
            ========================= */
            $("#modalCetakKartu").on("shown.bs.modal", function() {
                renderCetak(getTableData());
            });

            /* =========================
               MODAL DATE FILTER
            ========================= */
            $("#btnFilterCetak").on("click", function() {
                const start = new Date($("#cetakStart").val());
                const end = new Date($("#cetakEnd").val());

                const filtered = getTableData().filter(r => {
                    const tgl = parseTanggal(r.tanggal);
                    if (!tgl) return false;

                    start.setHours(0, 0, 0, 0);
                    end.setHours(23, 59, 59, 999);

                    return tgl >= start && tgl <= end;
                });

                renderCetak(filtered);
            });

            $("#btnResetCetak").on("click", function() {
                $("#cetakStart, #cetakEnd").val("");
                renderCetak(getTableData());
            });

        });
    </script>
@endpush
