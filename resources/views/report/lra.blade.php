@extends('layouts.master')
@section('header')
    <style>
        .tampil-anggaran-value {
            display: inline-block;
            padding: 6px 12px;
        }

        .persen-cell {
            min-width: 80px;
        }

        .form-control-sm {
            height: calc(1.5em + 0.5rem + 2px);
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
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
                        <div class="col-auto text-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                                <i class="bi bi-printer"></i> Cetak LRA
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries">
                            <div class="row align-items-end mb-4 justify-content-between">
                                <div class="col d-flex flex-wrap align-items-end gap-2">
                                    <div class="col-auto">
                                        <label class="form-label mb-1">Dari Tanggal</label>
                                        <input type="date" id="startDate" class="form-control form-control-sm"
                                            value="{{ $startDate }}" />
                                    </div>
                                    <div class="col-auto">
                                        <label class="form-label mb-1">Sampai Tanggal</label>
                                        <input type="date" id="endDate" class="form-control form-control-sm"
                                            value="{{ $endDate }}" />
                                    </div>
                                    <div class="col-auto mt-4">
                                        <button id="filterDate" class="btn btn-sm btn-primary">
                                            <i class="bi bi-funnel"></i> Filter
                                        </button>
                                        <a href="{{ route('report.lra') }}" id="resetDate" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <table id="" class="table table-striped">
                                <thead class="align-middle">
                                    <tr>
                                        <th>Uraian</th>
                                        <th>Anggaran</th>
                                        <th>Realisasi</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-start">Penerimaan</td>
                                        <td style="color: transparent">1</td>
                                        <td style="color: transparent">2</td>
                                        <td style="color: transparent">3</td>
                                    </tr>
                                    @foreach ($penerimaanItems as $index => $item)
                                        <tr data-section="penerimaan">
                                            <td class="text-start">{{ $item['uraian'] }}</td>
                                            <td>
                                                @if ($index === 0)
                                                    <input type="number" min="0"
                                                        name="{{ $item['input_anggaran_name'] }}"
                                                        class="form-control form-control-sm anggaran-input"
                                                        value="{{ $item['anggaran'] }}"
                                                        style="width: 120px; display: inline;">
                                                @else
                                                    <span
                                                        class="tampil-anggaran-value">{{ number_format($item['anggaran'], 0, ',', '.') }}</span>
                                                    <input type="hidden" class="anggaran-value"
                                                        value="{{ $item['anggaran'] }}">
                                                @endif
                                            </td>
                                            <td>
                                                <input type="number" min="0"
                                                    name="{{ $item['input_realisasi_name'] }}"
                                                    class="form-control form-control-sm realisasi-input"
                                                    value="{{ $item['realisasi'] }}"
                                                    style="width: 120px; display: inline;">
                                            </td>
                                            <td class="persen-cell">
                                                {{ $item['anggaran'] > 0
                                                    ? number_format(($item['realisasi'] / $item['anggaran']) * 100, 2, ',', '.') . '%'
                                                    : '0,00%' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="fw-bold text-start">Belanja</td>
                                        <td style="color: transparent">1</td>
                                        <td style="color: transparent">2</td>
                                        <td style="color: transparent">3</td>
                                    </tr>
                                    @foreach ($belanjaItems as $item)
                                        <tr data-section="belanja">
                                            <td class="text-start">{{ $item['uraian'] }}</td>
                                            <td>
                                                <span
                                                    class="tampil-anggaran-value">{{ number_format($item['anggaran'], 0, ',', '.') }}</span>
                                                <input type="hidden" class="anggaran-value"
                                                    value="{{ $item['anggaran'] }}">
                                            </td>
                                            <td>
                                                <span
                                                    class="">{{ number_format($item['realisasi'], 0, ',', '.') }}</span>
                                                <input type="hidden" class="realisasi-input"
                                                    name="{{ $item['input_realisasi_name'] }}"
                                                    value="{{ $item['realisasi'] }}">

                                                {{-- <input type="number" min="0"
                                                    name="{{ $item['input_realisasi_name'] }}"
                                                    class="form-control form-control-sm realisasi-input"
                                                    value="{{ $item['realisasi'] }}"
                                                    style="width: 120px; display: inline;"> --}}
                                            </td>
                                            <td class="persen-cell">
                                                {{ $item['anggaran'] > 0
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
                    <hr />
                    <div id="printArea">
                        <div class="text-center mb-4">
                            <h5><strong>Laporan Realisasi Anggaran (LRA)</strong></h5>
                            <p class="mb-0">
                                Periode:
                                <span id="periodeCetakText">Semua Periode</span>
                            </p>
                        </div>
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
                    <button class="btn btn-danger" id="btnCetakNow">
                        <i class="bi bi-printer-fill"></i> Cetak PDF
                    </button>
                    <button class="btn btn-success" id="btnExportLRA">
                        <i class="bi bi-file-earmark-excel"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Add this inside $(document).ready function or at the end of existing script
        $('#btnExportLRA').on('click', function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            // if (!startDate || !endDate) {
            //     alert('Pilih periode terlebih dahulu!');
            //     return;
            // }

            // Collect all form data
            const formData = new URLSearchParams();
            formData.append('start_date', startDate);
            formData.append('end_date', endDate);

            // Collect user inputs
            $('.anggaran-input, .realisasi-input').each(function() {
                const name = $(this).attr('name');
                const value = $(this).val() || 0;
                if (name) {
                    formData.append(name, value);
                }
            });

            // Build export URL
            const exportUrl = '{{ route('export.lra') }}?' + formData.toString();

            // Open export in new window
            window.location.href = exportUrl;
        });
    </script>
    <script>
        $(document).ready(function() {
            function calculatePercentage(anggaran, realisasi) {
                if (parseFloat(anggaran) > 0) {
                    const percentage = (parseFloat(realisasi) / parseFloat(anggaran)) * 100;
                    return percentage.toFixed(2).replace('.', ',') + '%';
                }
                return '0,00%';
            }

            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID');
            }

            function parseFormattedNumber(str) {
                return parseFloat(str.replace(/\./g, '').replace(',', '.')) || 0;
            }

            $(document).on('input', '.anggaran-input, .realisasi-input', function() {
                updateRowPercentage($(this).closest('tr'));
            });

            function updateRowPercentage(row) {
                let anggaran;
                const anggaranInput = row.find('.anggaran-input');
                const hiddenAnggaranInput = row.find('.anggaran-value[type="hidden"]');

                if (anggaranInput.length > 0) {
                    anggaran = parseFloat(anggaranInput.val()) || 0;
                } else if (hiddenAnggaranInput.length > 0) {
                    anggaran = parseFloat(hiddenAnggaranInput.val()) || 0;
                } else {
                    const displayedValue = row.find('.tampil-anggaran-value').text();
                    anggaran = parseFormattedNumber(displayedValue);
                }

                const realisasiInput = row.find('.realisasi-input');
                const realisasi = parseFloat(realisasiInput.val()) || 0;

                const persen = calculatePercentage(anggaran, realisasi);
                row.find('.persen-cell').text(persen);
            }

            $('tbody tr').each(function() {
                if ($(this).find('.persen-cell').length) {
                    updateRowPercentage($(this));
                }
            });

            $('#filterDate').on('click', function(e) {
                e.preventDefault();
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();

                if (!startDate || !endDate) {
                    alert("Silakan pilih tanggal mulai dan tanggal akhir.");
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    alert("Tanggal mulai tidak boleh lebih besar dari tanggal akhir.");
                    return;
                }

                const formData = new URLSearchParams();
                formData.append('start_date', startDate);
                formData.append('end_date', endDate);

                // $('.anggaran-input, .realisasi-input').each(function() {
                //     const name = $(this).attr('name');
                //     const value = $(this).val();
                //     if (name) {
                //         formData.append(name, value);
                //     }
                // });

                window.location.href = `{{ route('report.lra') }}?${formData.toString()}`;
            });

            $('#resetDate').on('click', function(e) {
                e.preventDefault();
                $('#startDate').val('');
                $('#endDate').val('');
                window.location.href = "{{ route('report.lra') }}";
            });

            $("#modalCetakKartu").on("shown.bs.modal", function() {
                updatePrintModal();
                const today = new Date();
                $("#tanggalCetak").text(
                    `Tegal, ${today.toLocaleDateString("id-ID", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                    })}`
                );
            });

            function updatePrintModal() {
                const tbody = $("#tabelCetak tbody");
                tbody.empty();

                tbody.append(`
                    <tr>
                        <td class="text-start fw-bold">Penerimaan</td>
                        <td class="text-end"><span style="color: transparent">1</span></td>
                        <td class="text-end"><span style="color: transparent">2</span></td>
                        <td><span style="color: transparent">3</span></td>
                    </tr>
                `);

                $('tbody tr[data-section="penerimaan"]').each(function() {
                    const uraian = $(this).find('td:eq(0)').text().trim();

                    const anggaranText = $(this).find('.anggaran-input').length > 0 ?
                        parseFloat($(this).find('.anggaran-input').val()) || 0 :
                        parseFormattedNumber($(this).find('.tampil-anggaran-value').text());

                    const realisasi = parseFloat($(this).find('.realisasi-input').val()) || 0;
                    const persen = $(this).find('.persen-cell').text();

                    tbody.append(`
                        <tr>
                            <td class="text-start">${uraian}</td>
                            <td class="text-end">${formatNumber(anggaranText)}</td>
                            <td class="text-end">${formatNumber(realisasi)}</td>
                            <td>${persen}</td>
                        </tr>
                    `);
                });

                tbody.append(`
                    <tr>
                        <td class="text-start fw-bold">Belanja</td>
                        <td class="text-end"><span style="color: transparent">1</span></td>
                        <td class="text-end"><span style="color: transparent">2</span></td>
                        <td><span style="color: transparent">3</span></td>
                    </tr>
                `);

                $('tbody tr[data-section="belanja"]').each(function() {
                    const uraian = $(this).find('td:eq(0)').text().trim();
                    const anggaran = parseFormattedNumber($(this).find('.tampil-anggaran-value').text());
                    const realisasi = parseFloat($(this).find('.realisasi-input').val()) || 0;
                    const persen = $(this).find('.persen-cell').text();

                    tbody.append(`
                        <tr>
                            <td class="text-start">${uraian}</td>
                            <td class="text-end">${formatNumber(anggaran)}</td>
                            <td class="text-end">${formatNumber(realisasi)}</td>
                            <td>${persen}</td>
                        </tr>
                    `);
                });

                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                if (startDate && endDate) {
                    const start = new Date(startDate).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    const end = new Date(endDate).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    $('#periodeCetakText').text(`${start} s.d. ${end}`);
                } else {
                    $('#periodeCetakText').text('Semua Periode');
                }
            }

            $("#btnCetakNow").on("click", function() {
                const printContent = document.getElementById("printArea").outerHTML;
                const printWindow = window.open("", "_blank", "width=1000,height=800");
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Cetak Laporan Realisasi Anggaran (LRA)</title>
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
                                    size: A4 landscape;
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
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 800);
            });
        });
    </script>
@endpush
