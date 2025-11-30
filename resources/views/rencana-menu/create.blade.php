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
                            <a href="{{ route('rencanamenu.index') }}" class="btn btn-link btn-soft-light">
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
                    <div class="card-header">
                        <h4 class="card-title">Formulir Perencanaan Menu</h4>
                    </div>
                    <div class="card-body">
                        <form id="formRencanaMenu">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label class="form-label">Tanggal</label>
                                    <input type="text" id="start_date" class="form-control" name="start_date"
                                        placeholder="Pilih tanggal">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <hr class="hr-horizontal" />

                            <div id="itemContainer">
                                <div class="row itemRow d-flex align-items-center">
                                    <div class="form-group col-md-6 col-12">
                                        <label class="form-label">Paket Menu</label>
                                        <select class="form-select paket-select">
                                            <option value="">Pilih Paket Menu</option>
                                            @foreach ($paketmenus as $paket)
                                                <option value="{{ $paket->id }}">{{ $paket->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-8">
                                        <label class="form-label">Jumlah Porsi</label>
                                        {{-- //TODO ambil dari sum porsi 8k + prosi 10k semua sekolah --}}
                                        <input type="number" class="form-control porsi-input" min="1" value="{{ $porsiSekolah }}">
                                    </div>
                                    <div class="form-group col-md-2 col-4 d-flex align-items-end mt-5">
                                        <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button type="button" class="btn btn-primary" id="tambah-item">
                                    <i class="bi bi-plus-circle"></i> Tambah Item
                                </button>
                                <button type="submit" class="btn btn-success">Simpan</button>
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
            $('#tambah-item').on('click', function() {
                let clone = $('.itemRow:first').clone();
                clone.find('select').val('');
                clone.find('input').val({{ $porsiSekolah }});
                $('#itemContainer').append(clone);
            });

            $(document).on('click', '.removeRow', function() {
                if ($('.itemRow').length > 1) $(this).closest('.itemRow').remove();
            });

            // Update form submission
            $('#formRencanaMenu').on('submit', function(e) {
                e.preventDefault();
                const items = [];
                $('.itemRow').each(function() {
                    const paketId = $(this).find('.paket-select').val();
                    const porsi = $(this).find('.porsi-input').val();
                    if (paketId && porsi > 0) items.push({
                        paket_menu_id: paketId,
                        porsi: porsi
                    });
                });

                $.ajax({
                    url: "{{ route('rencanamenu.store') }}",
                    method: 'POST',
                    data: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                        start_date: $('#start_date').val(),
                        items: items
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: true
                            })
                            .then(() => window.location.href =
                                "{{ route('rencanamenu.index') }}");
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Replace the flatpickr initialization
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#start_date", {
                dateFormat: "d/m/Y",
                locale: "id",
                allowInput: true,
            });
        });
    </script>
@endpush
