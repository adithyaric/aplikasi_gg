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

        <!-- Modal Template -->
        <div class="modal fade" id="modalPB2" tabindex="-1" aria-labelledby="modalPOLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content"
                    style="
                border-radius: 15px;
                border: 1px solid #ddd;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
              ">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="modalTambahBahanLabel">
                            Data Bukti
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-center">
                        <!-- Gambar Dinamis -->
                        <img id="modalGambarPB2" src="" alt="Bukti Gambar" class="img-fluid"
                            style="max-height: 500px; border-radius: 10px" />
                    </div>
                </div>
            </div>
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
                            <h4 class="card-title fw-bold">BKU</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries">
                            <div class="row align-items-end mb-4 justify-content-between">
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
                                <div class="col-auto text-end">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalCetakKartu">
                                        <i class="bi bi-printer"></i> Cetak BKU
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive text-nowrap custom-datatable-entries">
                                <table id="datatableBKU" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No Bukti</th>
                                            <th>Link Bukti</th>
                                            <th>Uraian</th>
                                            <th>Pemasukkan (Debit)</th>
                                            <th>Pengeluaran (Kredit)</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rekeningBKU as $index => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->tanggal_transaksi->format('d M Y') }}</td>
                                                <td>{{ $item->no_bukti }}</td>
                                                <td>
                                                    @if ($item->link_bukti)
                                                    <button class="btn btn-sm btn-primary lihat-bukti"
                                                        data-src="{{ Storage::disk('uploads')->url($item->link_bukti) }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalPB2">
                                                        <i class="bi bi-eye"></i> Lihat Disini
                                                    </button>
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>{{ $item->uraian }}</td>
                                                <td>{{ $item->debit ? number_format($item->debit, 0, ',', '.') : '' }}</td>
                                                <td>{{ $item->kredit ? number_format($item->kredit, 0, ',', '.') : '' }}
                                                </td>
                                                <td>{{ number_format($item->saldo, 0, ',', '.') }}</td>
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
    </div>

    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakBKUlabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-printer-fill"></i> Cetak Buku Kas Umum (BKU)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <button class="btn btn-primary" id="btnFilterCetak"><i class="bi bi-funnel"></i> Filter</button>
                            <button class="btn btn-secondary" id="btnResetCetak"><i
                                    class="bi bi-arrow-counterclockwise"></i> Reset</button>
                        </div>
                    </div>
                    <hr />
                    <div id="printArea">
                        <div class="text-center mb-4">
                            <h5><strong>BUKU KAS UMUM (BKU)</strong></h5>
                            <p class="mb-0">Periode: <span id="periodeCetakText">Semua Periode</span></p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle" id="tabelCetak">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>No Bukti</th>
                                        <th>Uraian</th>
                                        <th>Pemasukkan (Debit)</th>
                                        <th>Pengeluaran (Kredit)</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>
                        Tutup</button>
                    <button class="btn btn-success" id="btnCetakNow"><i class="bi bi-printer-fill"></i> Cetak</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            let table = $('#datatableBKU').DataTable({
                scrollX: true,
                pageLength: 10,
                autoWidth: false,
            });

            const fp = flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "id",
                altInput: true,
                altFormat: "j F Y",
                allowInput: true,
            });

            function parseDate(str) {
                if (!str) return null;
                const [day, month, year] = str.split("/");
                return new Date(`${year}-${month}-${day}`);
            }

            $("#filterDate").on("click", function() {
                const range = fp.selectedDates;
                if (range.length === 2) {
                    const min = range[0];
                    const max = range[1];

                    $.fn.dataTable.ext.search.push(function(settings, data) {
                        if (settings.nTable.id !== "datatableBKU") return true;
                        const tanggalTabel = data[1];
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

            $("#resetDate").on("click", function() {
                fp.clear();
                table.search("").draw();
            });

            function getTabelUtamaData() {
                const rows = [];
                $("#datatableBKU tbody tr").each(function() {
                    const row = {
                        no: $(this).find("td:eq(0)").text().trim(),
                        tanggal: $(this).find("td:eq(1)").text().trim(),
                        noBukti: $(this).find("td:eq(2)").text().trim(),
                        uraian: $(this).find("td:eq(4)").text().trim(),
                        debit: $(this).find("td:eq(5)").text().trim() || 0,
                        kredit: $(this).find("td:eq(6)").text().trim() ||0,
                        saldo: $(this).find("td:eq(7)").text().trim(),
                    };
                    if (row.tanggal) rows.push(row);
                });
                return rows;
            }

            function renderCetakTable(data) {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();
                data.forEach((item, i) => {
                    tbody.append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.noBukti}</td>
                        <td>${item.uraian}</td>
                        <td>${item.debit}</td>
                        <td>${item.kredit}</td>
                        <td>${item.saldo}</td>
                    </tr>
                `);
                });
            }

            $("#modalCetakKartu").on("shown.bs.modal", function() {
                renderCetakTable(getTabelUtamaData());
                const today = new Date();
                $("#tanggalCetak").text(
                    `Tegal, ${today.toLocaleDateString("id-ID", { day: "numeric", month: "long", year: "numeric" })}`
                );
            });

            $("#btnFilterCetak").on("click", function() {
                const start = new Date($("#cetakStart").val());
                const end = new Date($("#cetakEnd").val());
                const all = getTabelUtamaData();

                const filtered = all.filter((r) => {
                    const parts = r.tanggal.split(/[\/ ]/);
                    if (parts.length < 3) return false;
                    const year = parts[2].length === 2 ? "20" + parts[2] : parts[2];
                    const tgl = new Date(year, parts[1] - 1, parts[0]);
                    return tgl >= start && tgl <= end;
                });

                renderCetakTable(filtered);
                $("#periodeCetakText").text(`${$("#cetakStart").val()} s.d. ${$("#cetakEnd").val()}`);
            });

            $("#btnResetCetak").on("click", function() {
                $("#cetakStart").val("");
                $("#cetakEnd").val("");
                $("#periodeCetakText").text("Semua Periode");
                renderCetakTable(getTabelUtamaData());
            });

            $(document).on("click", "#btnCetakNow", function() {
                const printContent = document.getElementById("printArea").outerHTML;
                const printWindow = window.open("", "_blank", "width=1000,height=800");
                printWindow.document.write(`
                <html>
                    <head>
                        <title>Cetak Rekap BKU</title>
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
    <!-- Script untuk mengisi gambar saat tombol diklik -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalImg = document.getElementById("modalGambarPB2");

            document.querySelectorAll(".lihat-bukti").forEach((button) => {
                button.addEventListener("click", function() {
                    const src = this.getAttribute("data-src"); // ambil src dari tombol
                    modalImg.src = src;
                });
            });

            // Optional: reset gambar saat modal ditutup
            const modal = document.getElementById("modalPB2");
            modal.addEventListener("hidden.bs.modal", function() {
                modalImg.src = "";
            });
        });
    </script>
@endpush
