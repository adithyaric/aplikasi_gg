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
                            <a href="{{ route('menu.index') }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.084 2L7.916 2C4.377 2 2 4.276 2 7.665L2 16.335C2 19.724 4.377 22 7.916 22L16.084 22C19.622 22 22 19.723 22 16.334L22 7.665C22 4.276 19.622 2 16.084 2Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M11.1445 7.72082L7.37954 11.4688C7.09654 11.7508 7.09654 12.2498 7.37954 12.5328L11.1445 16.2808C11.4385 16.5728 11.9135 16.5718 12.2055 16.2778C12.4975 15.9838 12.4975 15.5098 12.2035 15.2168L9.72654 12.7498H16.0815C16.4965 12.7498 16.8315 12.4138 16.8315 11.9998C16.8315 11.5858 16.4965 11.2498 16.0815 11.2498L9.72654 11.2498L12.2035 8.78382C12.3505 8.63682 12.4235 8.44482 12.4235 8.25182C12.4235 8.06082 12.3505 7.86882 12.2055 7.72282C11.9135 7.42982 11.4385 7.42882 11.1445 7.72082Z"
                                        fill="currentColor"></path>
                                </svg>
                                Kembali
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
                            <h4 class="card-title">{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formMenu">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan nama menu">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <hr class="hr-horizontal" />

                            <h5 class="mb-1">Bahan Baku</h5>
                            <div id="bahan-container">
                                <div class="row mb-1 align-items-end bahan-item">
                                    <div class="col-md-6">
                                        <label>Bahan Makanan <span class="text-danger">*</span></label>
                                        <select class="form-select bahan-select" name="bahan_bakus[]">
                                            <option value="">-- Pilih Bahan --</option>
                                            @foreach ($bahanbakus as $bahan)
                                                <option value="{{ $bahan->id }}">
                                                    {{ $bahan->nama }} ({{ $bahan->kelompok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm add-bahan">
                                            +
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-bahan">
                                            -
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                {{-- <a href="{{ route('menu.index') }}" class="btn btn-danger">Kembali</a> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Event: tambah bahan
            $(document).on('click', '.add-bahan', function() {
                const currentItem = $(this).closest('.bahan-item');
                const clone = currentItem.clone();
                clone.find('label').remove();
                clone.find('.bahan-select').val('');
                $('#bahan-container').append(clone);
            });

            // Event: hapus bahan
            $(document).on('click', '.remove-bahan', function() {
                const items = $('#bahan-container .bahan-item');
                if (items.length > 1) {
                    $(this).closest('.bahan-item').remove();
                }
            });

            // Submit form
            $('#formMenu').on('submit', function(e) {
                e.preventDefault();
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                const formData = {
                    _token: "{{ csrf_token() }}",
                    nama: $('#nama').val(),
                    bahan_bakus: []
                };

                $('.bahan-select').each(function() {
                    const val = $(this).val();
                    if (val) {
                        formData.bahan_bakus.push(val);
                    }
                });

                $.ajax({
                    url: "{{ route('menu.store') }}",
                    method: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('menu.index') }}";
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                if (key === 'nama') {
                                    $('#nama').addClass('is-invalid');
                                    $('#nama').next('.invalid-feedback').text(value[0]);
                                }
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal!',
                                text: 'Pastikan semua field terisi dengan benar'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menyimpan data'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
