@extends('layouts.master')

@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Perencanaan Menu</h3>
                            <p>Makan Sehat Bergizi</p>
                        </div>
                        <div>
                            <a href="{{ route('rencanamenu.create') }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z"
                                        fill="currentColor"></path>
                                </svg>
                                Tambah Rencana
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

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius: 15px; border: 1px solid #ddd; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="modalDetailLabel">Detail Perencanaan Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title" id="modalPeriode"></h4>
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

@section('container')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">Perencanaan Menu</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap custom-datatable-entries">
                            <div class="col d-flex flex-wrap align-items-end gap-2 mb-1">
                                <div class="col-auto">
                                    <label class="form-label ">Rentang Periode</label>
                                    <input type="text" id="dateRange" class="form-control form-control-sm"
                                        placeholder="Pilih rentang tanggal" readonly />
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

                            <table id="datatable" class="table table-bordered table-sm" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rencanaMenus as $rencana)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rencana->start_date)->translatedFormat('d M Y') }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info btn-detail" data-id="{{ $rencana->id }}"
                                                    data-start_date="{{ $rencana->start_date }}">
                                                    <i class="bi bi-eye"></i> Detail
                                                </button>
                                                <a href="{{ route('rencanamenu.edit', $rencana->id) }}"
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
                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $rencana->id }}">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M20.2871 5.24297C20.6761 5.24297 21 5.56596 21 5.97696V6.35696C21 6.75795 20.6761 7.09095 20.2871 7.09095H3.71385C3.32386 7.09095 3 6.75795 3 6.35696V5.97696C3 5.56596 3.32386 5.24297 3.71385 5.24297H6.62957C7.22185 5.24297 7.7373 4.82197 7.87054 4.22798L8.02323 3.54598C8.26054 2.61699 9.0415 2 9.93527 2H14.0647C14.9488 2 15.7385 2.61699 15.967 3.49699L16.1304 4.22698C16.2627 4.82197 16.7781 5.24297 17.3714 5.24297H20.2871ZM18.8058 19.134C19.1102 16.2971 19.6432 9.55712 19.6432 9.48913C19.6626 9.28313 19.5955 9.08813 19.4623 8.93113C19.3193 8.78413 19.1384 8.69713 18.9391 8.69713H5.06852C4.86818 8.69713 4.67756 8.78413 4.54529 8.93113C4.41108 9.08813 4.34494 9.28313 4.35467 9.48913C4.35646 9.50162 4.37558 9.73903 4.40755 10.1359C4.54958 11.8992 4.94517 16.8102 5.20079 19.134C5.38168 20.846 6.50498 21.922 8.13206 21.961C9.38763 21.99 10.6811 22 12.0038 22C13.2496 22 14.5149 21.99 15.8094 21.961C17.4929 21.932 18.6152 20.875 18.8058 19.134Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                    </span>
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
        document.addEventListener("DOMContentLoaded", function() {
            function parseDateDMY(str) {
                if (!str) return null;
                const parts = str.split("/");
                if (parts.length !== 3) return null;
                const [d, m, y] = parts.map((s) => parseInt(s, 10));
                return new Date(y, m - 1, d);
            }

            let table;
            if ($.fn.DataTable.isDataTable("#datatable")) {
                table = $("#datatable").DataTable();
            } else {
                table = $("#datatable").DataTable({
                    scrollX: true,
                    pageLength: 10,
                    autoWidth: false,
                });
            }

            const fp = flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "id",
                altInput: true,
                altFormat: "j F Y",
                allowInput: true,
            });

            let minDate = null;
            let maxDate = null;

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (settings.nTable.id !== "datatable") return true;
                const cell = data[1];
                if (!cell || !cell.includes("-")) return true;

                const [startStr, endStr] = cell.split(" - ").map((s) => s.trim());
                const startDate = parseDateDMY(startStr);
                const endDate = parseDateDMY(endStr);
                if (!startDate || !endDate) return true;

                if (!minDate && !maxDate) return true;
                if (minDate && endDate < minDate) return false;
                if (maxDate && startDate > maxDate) return false;
                return true;
            });

            $("#filterDate").on("click", function() {
                const sel = fp.selectedDates;
                if (sel.length === 2) {
                    const startDate = fp.formatDate(sel[0], 'Y-m-d');
                    const endDate = fp.formatDate(sel[1], 'Y-m-d');

                    window.location.href =
                        `${window.location.pathname}?start_date=${startDate}&end_date=${endDate}`;
                } else {
                    alert("Silakan pilih rentang tanggal terlebih dahulu.");
                }
            });

            $("#resetDate").on("click", function() {
                window.location.href = window.location.pathname;
            });

            // Handle Detail Button Click
            $(document).on('click', '.btn-detail', function() {
                const id = $(this).data('id');
                const start_date = $(this).data('start_date');

                $('#modalPeriode').text(start_date);
                $('#modalContent').html(`
                <div class="text-center py-1">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

                $('#modalDetail').modal('show');

                $.ajax({
                    url: `/rencanamenu/${id}`,
                    method: 'GET',
                    success: function(data) {
                        let html = '';
                        // Use paket_menu (singular) to match the relationship name
                        data.paket_menu.forEach((paket, index) => {
                            html += `
            <div class="paket-menu mb-1">
                <h5 class="text-primary mb-1">${paket.nama}</h5>
        `;
                            paket.menus.forEach((menu) => {
                                html += `
                <div class="menu-item mb-1">
                    <h6 class="text-secondary mb-1">${menu.nama}</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Bahan Pokok</th>
                                <th>Per Porsi</th>
                                <th>Jmlh Porsi</th>
                                <th>Ttl Kebutuhan</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

                                // Use bahanBakusWithPaketData (Laravel converts camelCase to snake_case)
                                (menu.bahanBakusWithPaketData || []).forEach((bahan) => {
                                    let beratBersih = bahan.berat_bersih;
                                    let satuan = bahan.satuan;

                                    // Convert gram to kilogram
                                    // if (satuan.toLowerCase() === 'gram' || satuan.toLowerCase() === 'gr' || satuan.toLowerCase() === 'g') {
                                        beratBersih = beratBersih / 1000;
                                        satuan = 'kg';
                                    // }

                                    const totalKebutuhan = beratBersih * paket.pivot.porsi;

                                    html += `
                                        <tr>
                                            <td>${bahan.nama}</td>
                                            <td>${beratBersih.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 3})} ${satuan}</td>
                                            <td>${paket.pivot.porsi.toLocaleString('id-ID')}</td>
                                            <td>${totalKebutuhan.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 3})} ${satuan}</td>
                                        </tr>
                                    `;
                                });

                                html += `
                        </tbody>
                    </table>
                </div>
            `;
                            });
                            html += `</div>`;
                            if (index < data.paket_menu.length - 1) {
                                html += `<hr class="my-3" />`;
                            }
                        });
                        $('#modalContent').html(html);
                    },
                    error: function() {
                        $('#modalContent').html(`
                        <div class="alert alert-danger">
                            Gagal memuat data. Silakan coba lagi.
                        </div>
                    `);
                    }
                });
            });
        });
    </script>
    <script>
        // Add this to the existing script section
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/rencanamenu/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: true
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
