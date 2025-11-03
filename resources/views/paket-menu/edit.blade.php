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
                            <a href="{{ route('paketmenu.index') }}" class="btn btn-link btn-soft-light">
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
                            <h4 class="card-title">Edit Paket Menu</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formPaketMenu">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-4">
                                    <label class="form-label">Paket Menu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                        placeholder="Masukkan nama paket menu" value="{{ $paketmenu->nama }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <hr class="hr-horizontal" />

                            <!-- Container Menu -->
                            <div id="menu-container">
                                @foreach ($paketmenu->menus as $menu)
                                    <div class="menu-item border p-3 mb-2">
                                        <!-- Bagian Nama Menu -->
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label>Nama Menu <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control nama-menu"
                                                    placeholder="Masukkan nama menu" value="{{ $menu->nama }}">
                                            </div>
                                            <div class="col-md-9 d-flex align-items-end justify-content-end">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-menu">
                                                    Hapus Menu
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Daftar Bahan -->
                                        <div class="bahan-list">
                                            @foreach ($menu->bahanBakus as $bahan)
                                                <div class="row mb-2 align-items-end bahan-item">
                                                    <div class="col-md-3 offset-md-3">
                                                        @if ($loop->first)
                                                            <label>Bahan Makanan</label>
                                                        @endif
                                                        <select class="form-select bahan-select">
                                                            <option value="">-- Pilih Bahan --</option>
                                                            @foreach ($bahanbakus as $bb)
                                                                <option value="{{ $bb->id }}"
                                                                    data-kalori="{{ $bb->gizi?->energi ?? 0 }}"
                                                                    {{ $bahan->id == $bb->id ? 'selected' : '' }}>
                                                                    {{ $bb->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if ($loop->first)
                                                            <label>Berat Bersih (gram)</label>
                                                        @endif
                                                        <input type="number" class="form-control berat-input"
                                                            value="{{ $bahan->pivot->berat_bersih }}" min="0"
                                                            step="0.01">
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if ($loop->first)
                                                            <label>Kalori</label>
                                                        @endif
                                                        <input type="number" class="form-control kalori-input"
                                                            value="{{ $bahan->pivot->energi }}" readonly>
                                                    </div>
                                                    <div class="col-md-2 d-flex gap-2">
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm add-bahan">
                                                            +
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm remove-bahan">
                                                            -
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total Kalori -->
                            <hr class="hr-horizontal" />
                            <div class="text-end">
                                <h5>
                                    Total Kalori:
                                    <span id="totalKalori" class="fw-bold text-primary">0</span>
                                    kkal
                                </h5>
                            </div>

                            <!-- Tombol Tambah Menu & Simpan -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button type="button" class="btn btn-primary" id="addMenu">
                                    <i class="bi bi-plus-circle"></i> Tambah Menu
                                </button>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('paketmenu.index') }}" class="btn btn-danger">Kembali</a>
                                </div>
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
            // Data kalori per bahan (dari database)
            const kaloriData = {};
            @foreach ($bahanbakus as $bahan)
                kaloriData[{{ $bahan->id }}] = {{ $bahan->gizi?->energi ?? 0 }};
            @endforeach

            // Fungsi hitung kalori per baris
            function updateCalories(row) {
                const select = row.find('.bahan-select');
                const beratInput = row.find('.berat-input');
                const kaloriInput = row.find('.kalori-input');

                const bahanId = select.val();
                const berat = parseFloat(beratInput.val()) || 0;
                const kaloriPer100 = kaloriData[bahanId] || 0;
                const totalKalori = (berat * kaloriPer100);

                kaloriInput.val(totalKalori.toFixed(2));
                updateTotalKalori();
            }

            // Fungsi update total seluruh kalori
            function updateTotalKalori() {
                let total = 0;
                $('.kalori-input').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#totalKalori').text(total.toFixed(2));
            }

            // Initial calculation
            updateTotalKalori();

            // Event: perubahan berat
            $(document).on('input', '.berat-input', function() {
                const row = $(this).closest('.bahan-item');
                updateCalories(row);
            });

            // Event: perubahan bahan
            $(document).on('change', '.bahan-select', function() {
                const row = $(this).closest('.bahan-item');
                updateCalories(row);
            });

            // Event: tambah bahan
            $(document).on('click', '.add-bahan', function() {
                const currentItem = $(this).closest('.bahan-item');
                const clone = currentItem.clone();

                clone.find('label').remove();
                clone.find('input').val(0);
                clone.find('.bahan-select').val('');

                currentItem.parent().append(clone);
            });

            // Event: hapus bahan
            $(document).on('click', '.remove-bahan', function() {
                const bahanList = $(this).closest('.bahan-list');
                const items = bahanList.find('.bahan-item');

                if (items.length > 1) {
                    $(this).closest('.bahan-item').remove();
                    updateTotalKalori();
                }
            });

            // Event: tambah menu
            $('#addMenu').on('click', function() {
                const menuContainer = $('#menu-container');
                const menuTemplate = `
                    <div class="menu-item border p-3 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label>Nama Menu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control nama-menu" placeholder="Masukkan nama menu">
                            </div>
                            <div class="col-md-9 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-menu">
                                    Hapus Menu
                                </button>
                            </div>
                        </div>
                        <div class="bahan-list">
                            <div class="row mb-2 align-items-end bahan-item">
                                <div class="col-md-3 offset-md-3">
                                    <label>Bahan Makanan</label>
                                    <select class="form-select bahan-select">
                                        <option value="">-- Pilih Bahan --</option>
                                        @foreach ($bahanbakus as $bahan)
                                            <option value="{{ $bahan->id }}" data-kalori="{{ $bahan->gizi?->energi ?? 0 }}">
                                                {{ $bahan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Berat Bersih (gram)</label>
                                    <input type="number" class="form-control berat-input" value="0" min="0" step="0.01">
                                </div>
                                <div class="col-md-2">
                                    <label>Kalori</label>
                                    <input type="number" class="form-control kalori-input" value="0" readonly>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm add-bahan">+</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-bahan">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                menuContainer.append(menuTemplate);
                updateTotalKalori();
            });

            // Event: hapus menu
            $(document).on('click', '.remove-menu', function() {
                const menuItems = $('.menu-item');
                if (menuItems.length > 1) {
                    $(this).closest('.menu-item').remove();
                    updateTotalKalori();
                }
            });

            // Submit form
            $('#formPaketMenu').on('submit', function(e) {
                e.preventDefault();

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                const namaPaket = $('#nama_paket').val();
                const menus = [];

                $('.menu-item').each(function() {
                    const namaMenu = $(this).find('.nama-menu').val();
                    const bahanBakus = [];

                    $(this).find('.bahan-item').each(function() {
                        const bahanId = $(this).find('.bahan-select').val();
                        const beratBersih = $(this).find('.berat-input').val();
                        const energiKalori = $(this).find('.kalori-input').val();

                        if (bahanId && beratBersih > 0) {
                            bahanBakus.push({
                                bahan_baku_id: bahanId,
                                berat_bersih: beratBersih,
                                energi: energiKalori
                            });
                        }
                    });

                    if (namaMenu && bahanBakus.length > 0) {
                        menus.push({
                            nama: namaMenu,
                            bahan_bakus: bahanBakus
                        });
                    }
                });

                const formData = {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    nama_paket: namaPaket,
                    menus: menus
                };

                $.ajax({
                    url: "{{ route('paketmenu.update', $paketmenu->id) }}",
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
                            window.location.href = "{{ route('paketmenu.index') }}";
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                if (key === 'nama_paket') {
                                    $('#nama_paket').addClass('is-invalid');
                                    $('#nama_paket').next('.invalid-feedback').text(
                                        value[0]);
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
                                    'Terjadi kesalahan saat mengupdate data'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
