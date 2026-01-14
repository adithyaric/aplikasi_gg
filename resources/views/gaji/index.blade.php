@extends('layouts.master')
@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $title }}</h3>
                            <p>Kelola Gaji</p>
                        </div>
                        <div>
                            <a href="{{ route('gaji.create') }}" class="btn btn-link btn-soft-light">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.3764 20.0279L18.1628 8.66544C18.6403 8.0527 18.8101 7.3443 18.6509 6.62299C18.513 5.96726 18.1097 5.34377 17.5049 4.87078L16.0299 3.69906C14.7459 2.67784 13.1541 2.78534 12.2415 3.95706L11.2546 5.23735C11.1273 5.39752 11.1591 5.63401 11.3183 5.76301C11.3183 5.76301 13.812 7.76246 13.8651 7.80546C14.0349 7.96671 14.1622 8.1817 14.1941 8.43969C14.2471 8.94493 13.8969 9.41792 13.377 9.48242C13.1329 9.51467 12.8994 9.43942 12.7297 9.29967L10.1086 7.21422C9.98126 7.11855 9.79025 7.13898 9.68413 7.26797L3.45514 15.3303C3.0519 15.8355 2.91395 16.4912 3.0519 17.1255L3.84777 20.5761C3.89021 20.7589 4.04939 20.8879 4.24039 20.8879L7.74222 20.8449C8.37891 20.8341 8.97316 20.5439 9.3764 20.0279ZM14.2797 18.9533H19.9898C20.5469 18.9533 21 19.4123 21 19.9766C21 20.5421 20.5469 21 19.9898 21H14.2797C13.7226 21 13.2695 20.5421 13.2695 19.9766C13.2695 19.4123 13.7226 18.9533 14.2797 18.9533Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                Kelola Gaji
                            </a>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('import.gaji') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-3">
                                <label for="file" class="form-label">Format: Excel/CSV</label>
                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-upload"></i> Import
                                </button>
                                <a href="{{ asset('templates/template-gaji.csv') }}" class="btn btn-sm btn-secondary ms-2">
                                    <i class="bi bi-file-earmark-spreadsheet"></i> Template
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-sm" @if (count($periods)>0) data-toggle="data-table" @endif>
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>Periode</th>
                                        <th>Total Karyawan</th>
                                        <th>Total Gaji Keseluruhan</th>
                                        {{-- <th>Status</th> --}}
                                        <th width="200">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($periods as $period)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($period['tanggal_mulai'])->formatId('d/m/Y') }} -
                                                {{ \Carbon\Carbon::parse($period['tanggal_akhir'])->formatId('d/m/Y') }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::create($period['periode_tahun'], $period['periode_bulan'])->formatId('F Y') }}
                                            </td>
                                            <td>{{ $period['total_karyawan'] }}</td>
                                            <td>Rp. {{ number_format($period['total_gaji'], 0, ',', '.') }}</td>
                                            {{-- <td> --}}
                                            {{-- @if ($period['status'] === 'hold') --}}
                                            {{-- <span class="badge bg-warning">Hold</span> --}}
                                            {{-- @else --}}
                                            {{-- <span class="badge bg-success">Confirmed</span> --}}
                                            {{-- @endif --}}
                                            {{-- </td> --}}
                                            <td>
                                                @if ($period['status'] === 'hold')
                                                    <button type="button" class="btn btn-sm btn-primary btn-bulk-confirm"
                                                        data-mulai="{{ $period['tanggal_mulai']->format('Y-m-d') }}"
                                                        data-akhir="{{ $period['tanggal_akhir']->format('Y-m-d') }}"
                                                        data-periode="{{ \Carbon\Carbon::create($period['periode_tahun'], $period['periode_bulan'])->format('F Y') }}">
                                                        Konfirmasi
                                                    </button>
                                                    {{-- @else --}}
                                                    <a href="{{ route('gaji.create', [
                                                        'tanggal_mulai' => $period['tanggal_mulai']->format('Y-m-d'),
                                                        'tanggal_akhir' => $period['tanggal_akhir']->format('Y-m-d'),
                                                    ]) }}"
                                                        class="btn btn-sm btn-success">
                                                        <span class="btn-inner">
                                                            <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M9.3764 20.0279L18.1628 8.66544C18.6403 8.0527 18.8101 7.3443 18.6509 6.62299C18.513 5.96726 18.1097 5.34377 17.5049 4.87078L16.0299 3.69906C14.7459 2.67784 13.1541 2.78534 12.2415 3.95706L11.2546 5.23735C11.1273 5.39752 11.1591 5.63401 11.3183 5.76301C11.3183 5.76301 13.812 7.76246 13.8651 7.80546C14.0349 7.96671 14.1622 8.1817 14.1941 8.43969C14.2471 8.94493 13.8969 9.41792 13.377 9.48242C13.1329 9.51467 12.8994 9.43942 12.7297 9.29967L10.1086 7.21422C9.98126 7.11855 9.79025 7.13898 9.68413 7.26797L3.45514 15.3303C3.0519 15.8355 2.91395 16.4912 3.0519 17.1255L3.84777 20.5761C3.89021 20.7589 4.04939 20.8879 4.24039 20.8879L7.74222 20.8449C8.37891 20.8341 8.97316 20.5439 9.3764 20.0279ZM14.2797 18.9533H19.9898C20.5469 18.9533 21 19.4123 21 19.9766C21 20.5421 20.5469 21 19.9898 21H14.2797C13.7226 21 13.2695 20.5421 13.2695 19.9766C13.2695 19.4123 13.7226 18.9533 14.2797 18.9533Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-info btn-period-detail"
                                                    data-mulai="{{ $period['tanggal_mulai']->format('Y-m-d') }}"
                                                    data-akhir="{{ $period['tanggal_akhir']->format('Y-m-d') }}">
                                                    <i class="bi bi-eye"></i> Detail
                                                </button>
                                                <a href="{{ route('export.gaji', [
                                                        'tanggal_mulai' => $period['tanggal_mulai']->format('Y-m-d'),
                                                        'tanggal_akhir' => $period['tanggal_akhir']->format('Y-m-d'),
                                                    ]) }}" class="btn btn-sm btn-success">
                                                    <i class="bi bi-file-earmark-excel "></i> Export
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data gaji</td>
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

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius: 15px; border: 1px solid #ddd; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="modalDetailLabel">Detail Gaji Periode</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 id="modalPeriode"></h5>
                                    <p class="mb-1"><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                                    <p class="mb-1"><strong>Total Karyawan:</strong> <span id="modalTotalKaryawan"></span>
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="mb-1"><strong>Jumlah Hadir:</strong> <span id="modalHadir"></span></p>
                                    <h4><strong>Total Gaji:</strong> <span class="text-success" id="modalTotalGaji"></span>
                                    </h4>
                                    <p class="mb-1"><strong>Status:</strong> <span id="modalStatus"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="modalContent">
                            <!-- Content will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.btn-period-detail', function() {
            const mulai = $(this).data('mulai');
            const akhir = $(this).data('akhir');

            $('#modalDetail').modal('show');
            $('#modalContent').html(`
        <div class="text-center py-1">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

            $.ajax({
                url: '{{ route('gaji.period-detail', ['tanggal_mulai' => '__mulai__', 'tanggal_akhir' => '__akhir__']) }}'
                    .replace('__mulai__', mulai)
                    .replace('__akhir__', akhir),
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#modalDetailLabel').text('Detail Gaji ' + response.periode);
                        $('#modalPeriode').text(response.periode);
                        $('#modalTanggal').text(response.tanggal_mulai + ' - ' + response
                            .tanggal_akhir);
                        $('#modalTotalKaryawan').text(response.total_karyawan);
                        $('#modalHadir').text(response.hadir + ' hari');
                        $('#modalTotalGaji').text('Rp. ' + new Intl.NumberFormat('id-ID').format(
                            response.total_gaji));

                        const statusBadge = response.status === 'hold' ?
                            '<span class="badge bg-warning">Hold</span>' :
                            '<span class="badge bg-success">Confirmed</span>';
                        $('#modalStatus').html(statusBadge);

                        let html = `
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Jumlah Hadir</th>
                                    <th>Total Gaji</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                        if (response.gajis.length > 0) {
                            response.gajis.forEach((item, index) => {
                                html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.karyawan.nama}</td>
                                <td>${item.karyawan.kategori.nama}</td>
                                <td>${item.jumlah_hadir} hari</td>
                                <td>Rp. ${new Intl.NumberFormat('id-ID').format(item.total_gaji)}</td>
                                <td>
                                    ${item.status === 'hold'
                                        ? '<span class="badge bg-warning">Hold</span>'
                                        : '<span class="badge bg-success">Confirmed</span>'}
                                </td>
                            </tr>
                        `;
                            });
                        } else {
                            html += `
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data gaji</td>
                        </tr>
                    `;
                        }

                        html += `
                            </tbody>
                        </table>
                    </div>
                `;

                        $('#modalContent').html(html);
                    }
                },
                error: function(xhr) {
                    $('#modalContent').html(`
                <div class="alert alert-danger">
                    Terjadi kesalahan saat mengambil data
                </div>
            `);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-confirm', function() {
            const gajiId = $(this).data('id');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Apakah Anda yakin ingin mengkonfirmasi pembayaran gaji "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Konfirmasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/gaji/${gajiId}/confirm`,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat konfirmasi'
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-bulk-confirm', function() {
            const mulai = $(this).data('mulai');
            const akhir = $(this).data('akhir');
            const periode = $(this).data('periode');

            Swal.fire({
                title: 'Konfirmasi Semua Gaji',
                text: `Apakah Anda yakin ingin mengkonfirmasi semua gaji pada periode ${periode}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Konfirmasi Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('gaji.bulk-confirm', ['tanggal_mulai' => '__mulai__', 'tanggal_akhir' => '__akhir__']) }}'
                            .replace('__mulai__', mulai)
                            .replace('__akhir__', akhir),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat konfirmasi'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
