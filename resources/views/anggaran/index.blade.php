@extends('layouts.master')
@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>DAPUR BERGIZI</h3>
                            <p>Makan Sehat Bergizi</p>
                        </div>
                        <div>
                            <a href="{{ route('anggaran.create') }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z"
                                        fill="currentColor"></path>
                                </svg>
                                Tambah Proposal
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">Daftar Proposal</h4>
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
                            </div>
                        <div class="table-responsive text-nowrap custom-datatable-entries">
                            <table id="datatable" class="table table-bordered table-sm" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        {{-- <th>Nama Sekolah</th> --}}
                                        <th>Porsi 8k</th>
                                        <th>Porsi 10k</th>
                                        <th>Total Porsi</th>
                                        <th>Budget Porsi 8k</th>
                                        <th>Budget Porsi 10k</th>
                                        <th>Budget Operasional (3k)</th>
                                        <th>Budget Sewa (2k)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggarans as $anggaran)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $anggaran->start_date->formatId('d M Y') }}</td>
                                            <td>{{ $anggaran->end_date->formatId('d M Y') }}</td>
                                            {{-- <td>{{ $anggaran->sekolah?->nama }}</td> --}}
                                            <td>{{ number_format($anggaran->porsi_8k, 0, ',', '.') }}</td>
                                            <td>{{ number_format($anggaran->porsi_10k, 0, ',', '.') }}</td>
                                            <td>{{ number_format($anggaran->total_porsi, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($anggaran->budget_porsi_8k, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($anggaran->budget_porsi_10k, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($anggaran->budget_operasional, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($anggaran->budget_sewa, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('anggaran.edit', $anggaran->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $anggaran->id }}"
                                                    data-nama="{{ $anggaran->sekolah?->nama }}">
                                                    <i class="bi bi-trash"></i> Hapus
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
        flatpickr("#startDate", {
            inline: true,
            dateFormat: "d/m/Y",
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
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

                // Mapping bulan Indonesia ke nomor bulan
                const monthMap = {
                    'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04',
                    'Mei': '05', 'Jun': '06', 'Jul': '07', 'Agt': '08',
                    'Sep': '09', 'Okt': '10', 'Nov': '11', 'Des': '12'
                };

                // Check if format is "d M Y" (e.g., "10 Des 2025")
                const parts = str.trim().split(/\s+/);
                if (parts.length === 3) {
                    const [day, monthName, year] = parts;
                    const month = monthMap[monthName];
                    if (month) {
                        return new Date(`${year}-${month}-${day.padStart(2, '0')}`);
                    }
                }

                // Fallback: format "d/m/Y" (e.g., "10/12/2025")
                if (str.includes('/')) {
                    const [day, month, year] = str.split("/");
                    return new Date(`${year}-${month}-${day}`);
                }

                return null;
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
    <script>
        $(document).ready(function() {

            // Handle Delete Button Click
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus Anggaran "${nama}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/anggaran/${id}`,
                            method: 'DELETE',
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
                                        'Terjadi kesalahan saat menghapus data'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
