@extends('layouts.master')
@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $title }}</h3>
                            <p>Kelola Absensi</p>
                        </div>
                        <div>
                            <a href="{{ route('absensi.create') }}" class="btn btn-link btn-soft-light">
                                <span class="btn-inner">
                                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.3764 20.0279L18.1628 8.66544C18.6403 8.0527 18.8101 7.3443 18.6509 6.62299C18.513 5.96726 18.1097 5.34377 17.5049 4.87078L16.0299 3.69906C14.7459 2.67784 13.1541 2.78534 12.2415 3.95706L11.2546 5.23735C11.1273 5.39752 11.1591 5.63401 11.3183 5.76301C11.3183 5.76301 13.812 7.76246 13.8651 7.80546C14.0349 7.96671 14.1622 8.1817 14.1941 8.43969C14.2471 8.94493 13.8969 9.41792 13.377 9.48242C13.1329 9.51467 12.8994 9.43942 12.7297 9.29967L10.1086 7.21422C9.98126 7.11855 9.79025 7.13898 9.68413 7.26797L3.45514 15.3303C3.0519 15.8355 2.91395 16.4912 3.0519 17.1255L3.84777 20.5761C3.89021 20.7589 4.04939 20.8879 4.24039 20.8879L7.74222 20.8449C8.37891 20.8341 8.97316 20.5439 9.3764 20.0279ZM14.2797 18.9533H19.9898C20.5469 18.9533 21 19.4123 21 19.9766C21 20.5421 20.5469 21 19.9898 21H14.2797C13.7226 21 13.2695 20.5421 13.2695 19.9766C13.2695 19.4123 13.7226 18.9533 14.2797 18.9533Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                Kelola Absensi
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
                    <div class="card-body">
                        <div class="table-responsive text-nowrap custom-datatable-entries">
                            <table id="datatable" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>Total Karyawan</th>
                                        <th>Hadir</th>
                                        <th>Tidak Hadir</th>
                                        <th>Terkonfirmasi</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($absensis as $tanggal => $items)
                                        @php
                                            $hadir = collect($items)->where('status', 'hadir')->count();
                                            $tidakHadir = collect($items)->where('status', 'tidak_hadir')->count();
                                            $confirmed = collect($items)->where('confirmed', true)->count();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tanggal)->formatId('d/M/Y') }}</td>
                                            <td>{{ count($items) }}</td>
                                            <td><span class="badge bg-success">{{ $hadir }}</span></td>
                                            <td><span class="badge bg-danger">{{ $tidakHadir }}</span></td>
                                            <td><span class="badge bg-info">{{ $confirmed }}</span></td>
                                            <td>
                                                <a href="{{ route('absensi.create', ['tanggal' => $tanggal]) }}"
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
                                                <button type="button" class="btn btn-sm btn-info btn-detail"
                                                    data-tanggal="{{ $tanggal }}">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                button:confirmed bulk!
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data absensi</td>
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
                    <h5 class="modal-title text-white" id="modalDetailLabel">Detail Absensi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title" id="modalTanggal"></h4>
                            </div>
                            <div>
                                <span class="badge bg-success me-2">Hadir: <span id="modalHadir">0</span></span>
                                <span class="badge bg-danger">Tidak Hadir: <span id="modalTidakHadir">0</span></span>
                            </div>
                        </div>
                        <div class="card-body" id="modalContent">
                            <div class="text-center py-1">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.btn-detail', function() {
            const tanggal = $(this).data('tanggal');

            $('#modalDetail').modal('show');
            $('#modalContent').html(`
            <div class="text-center py-1">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

            $.ajax({
                url: '{{ route('absensi.index') }}/' + tanggal,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#modalTanggal').text('Tanggal: ' + response.tanggal);
                        $('#modalHadir').text(response.hadir);
                        $('#modalTidakHadir').text(response.tidak_hadir);

                        let html = `
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Kategori</th>
                                        <th>Nominal Gaji/Hari</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                        if (response.absensis.length > 0) {
                            response.absensis.forEach((item, index) => {
                                const statusBadge = item.status === 'hadir' ?
                                    '<span class="badge bg-success">Hadir</span>' :
                                    '<span class="badge bg-danger">Tidak Hadir</span>';

                                const nominalGaji = new Intl.NumberFormat('id-ID').format(item
                                    .karyawan.kategori.nominal_gaji);

                                html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.karyawan.nama}</td>
                                    <td>${item.karyawan.kategori.nama}</td>
                                    <td>Rp. ${nominalGaji}</td>
                                    <td>${statusBadge}</td>
                                </tr>
                            `;
                            });
                        } else {
                            html += `
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
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
@endpush
