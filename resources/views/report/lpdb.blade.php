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
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">LPDB</h4>
                        </div>
                        <div class="col-auto text-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCetakLPDB">
                                <i class="bi bi-printer"></i> Cetak LPDB
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries">
                            <div class="row align-items-end mb-4 justify-content-between">
                                <div class="col d-flex flex-wrap align-items-end gap-2">
                                    <div class="col-auto">
                                        <label class="form-label mb-1">Dari Bulan</label>
                                        <input type="month" id="startMonth" class="form-control form-control-sm"
                                            value="{{ $startMonth }}" />
                                    </div>
                                    <div class="col-auto">
                                        <label class="form-label mb-1">Sampai Bulan</label>
                                        <input type="month" id="endMonth" class="form-control form-control-sm"
                                            value="{{ $endMonth }}" />
                                    </div>
                                    <div class="col-auto mt-4">
                                        <button id="filterMonth" class="btn btn-sm btn-primary">
                                            <i class="bi bi-funnel"></i> Filter
                                        </button>
                                        <a href="{{ route('report.lpdb') }}" id="resetMonth"
                                            class="btn btn-sm btn-secondary">
                                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="align-middle text-center">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Bulan</th>
                                            <th rowspan="2">Saldo Awal</th>
                                            <th rowspan="2">Penerimaan Dana</th>
                                            <th colspan="3">Pengeluaran Dana</th>
                                            <th rowspan="2">Total</th>
                                            <th rowspan="2">Saldo Akhir</th>
                                        </tr>
                                        <tr>
                                            <th>Bahan Pangan</th>
                                            <th>Operasional</th>
                                            <th>Sewa</th>
                                        </tr>
                                        <tr>
                                            <th>(1)</th>
                                            <th></th>
                                            <th>(2)</th>
                                            <th>(3)</th>
                                            <th>(4)</th>
                                            <th>(5)</th>
                                            <th>(6)</th>
                                            <th>(7)=(4)+(5)+(6)</th>
                                            <th>(8)=(3)-(7)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $item)
                                            <tr>
                                                <td class="text-center">{{ $item['no'] }}</td>
                                                <td>{{ $item['bulan'] }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($item['saldo_awal'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-end">Rp
                                                    {{ number_format($item['penerimaan_dana'], 0, ',', '.') }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($item['bahan_pangan'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-end">Rp
                                                    {{ number_format($item['operasional'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-end">Rp {{ number_format($item['sewa'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-end">Rp {{ number_format($item['total'], 0, ',', '.') }}
                                                </td>
                                                <td class="text-end">Rp
                                                    {{ number_format($item['saldo_akhir'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Silakan pilih periode bulan untuk
                                                    menampilkan data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCetakLPDB" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak Laporan Penggunaan Dana Bulanan (LPDB)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="printAreaLPDB">
                        <div class="text-center mb-4">
                            <h5><strong>Laporan Penggunaan Dana Bulanan (LPDB)</strong></h5>
                            <p class="mb-0">Periode: <span id="periodeLPDB"></span></p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center" id="tabelCetakLPDB">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Bulan</th>
                                        <th rowspan="2">Saldo Awal</th>
                                        <th rowspan="2">Penerimaan Dana</th>
                                        <th colspan="3">Pengeluaran Dana</th>
                                        <th rowspan="2">Total</th>
                                        <th rowspan="2">Saldo Akhir</th>
                                    </tr>
                                    <tr>
                                        <th>Bahan Pangan</th>
                                        <th>Operasional</th>
                                        <th>Sewa</th>
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
                                <p id="tanggalCetakLPDB"></p>
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
                    <button class="btn btn-success" id="btnCetakLPDB">
                        <i class="bi bi-printer-fill"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#filterMonth').on('click', function(e) {
                e.preventDefault();
                const startMonth = $('#startMonth').val();
                const endMonth = $('#endMonth').val();

                if (!startMonth || !endMonth) {
                    alert("Silakan pilih bulan mulai dan bulan akhir.");
                    return;
                }

                if (startMonth > endMonth) {
                    alert("Bulan mulai tidak boleh lebih besar dari bulan akhir.");
                    return;
                }

                window.location.href =
                    `{{ route('report.lpdb') }}?start_month=${startMonth}&end_month=${endMonth}`;
            });

            $('#resetMonth').on('click', function(e) {
                e.preventDefault();
                $('#startMonth').val('');
                $('#endMonth').val('');
                window.location.href = "{{ route('report.lpdb') }}";
            });

            $("#modalCetakLPDB").on("shown.bs.modal", function() {
                const tbody = $("#tabelCetakLPDB tbody");
                tbody.empty();

                $('tbody tr').each(function() {
                    const row = $(this);
                    if (row.find('td').length > 1) {
                        tbody.append(row.clone());
                    }
                });

                const startMonth = $('#startMonth').val();
                const endMonth = $('#endMonth').val();
                if (startMonth && endMonth) {
                    const start = new Date(startMonth + '-01').toLocaleDateString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });
                    const end = new Date(endMonth + '-01').toLocaleDateString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });
                    $('#periodeLPDB').text(`${start} s.d. ${end}`);
                } else {
                    $('#periodeLPDB').text('Semua Periode');
                }

                const today = new Date();
                $("#tanggalCetakLPDB").text(
                    `Tegal, ${today.toLocaleDateString("id-ID", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                    })}`
                );
            });

            $("#btnCetakLPDB").on("click", function() {
                const printContent = document.getElementById("printAreaLPDB").outerHTML;
                const printWindow = window.open("", "_blank", "width=1200,height=800");
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Cetak LPDB</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { font-family: 'Segoe UI', sans-serif; font-size: 12px; margin: 20px; }
                                table { width: 100%; border-collapse: collapse; }
                                th, td { padding: 6px; font-size: 11px; }
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
