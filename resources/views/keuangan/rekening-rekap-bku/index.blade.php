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
                        <div>
                            <a href="{{ route('rekening-rekap-bku.create') }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z"
                                        fill="currentColor"></path>
                                </svg>
                                Tambah Transaksi
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
                    @if ($selisihFound)
                        <div class="card-header">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading">⚠️ Ditemukan Selisih Saldo!</h4>
                                <p>Terdapat ketidaksesuaian dalam perhitungan saldo. Data mungkin perlu dikoreksi.</p>
                                @foreach ($selisihDetails as $detail)
                                    <small>
                                        Tanggal: {{ $detail['entry']->tanggal_transaksi->formatId('d/m/Y') }} -
                                        Selisih: Rp {{ number_format($detail['difference'], 0, ',', '.') }}
                                    </small><br>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="custom-datatable-entries">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>No Bukti</th>
                                        <th>Link Bukti</th>
                                        <th>Supplier</th>
                                        <th>Uraian</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                        {{-- <th>Bulan</th> --}}
                                        {{-- <th>Minggu</th> --}}
                                        <th>Link PO</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekeningBKU as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->tanggal_transaksi->formatId('d/M/Y H:i T') }}</td>
                                            <td>{{ $item->no_bukti ?? '-' }}</td>
                                            <td>
                                                @if ($item->link_bukti)
                                                <button class="btn btn-sm btn-primary lihat-bukti"
                                                    data-src="{{ Storage::url($item->link_bukti) }}" data-bs-toggle="modal"
                                                    data-bs-target="#modalPB2">
                                                    <i class="bi bi-eye"></i> Lihat Disini
                                                </button>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>{{ $item->supplier ?? '-' }}</td>
                                            <td>{{ $item->uraian }}</td>
                                            <td>{{ $item->debit > 0 ? 'Rp ' . number_format($item->debit, 0, ',', '.') : '-' }}
                                            </td>
                                            <td>{{ $item->kredit > 0 ? 'Rp ' . number_format($item->kredit, 0, ',', '.') : '-' }}
                                            </td>
                                            <td>Rp {{ number_format($item->saldo, 0, ',', '.') }}</td>
                                            {{-- <td>{{ $item->bulan ? date('F', mktime(0, 0, 0, $item->bulan, 1)) : '-' }}</td> --}}
                                            {{-- <td>{{ $item->minggu ? 'Minggu ' . $item->minggu : '-' }}</td> --}}
                                            <td>
                                                @if ($item->transaction)
                                                    <span class="badge bg-info">
                                                        {{ $item->transaction?->order?->order_number }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('rekening-rekap-bku.edit', $item->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->uraian }}">
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
    <script>
        // Handle Delete Button Click
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/rekening-rekap-bku/${id}`,
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
