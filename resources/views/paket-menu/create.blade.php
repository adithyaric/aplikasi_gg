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
                            <h4 class="card-title">Formulir Paket Menu</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formPaketMenu">
                            @csrf
                            <div class="row">
                                <div class="form-group col-4">
                                    <label class="form-label">Paket Menu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                        placeholder="Masukkan nama paket menu">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <hr class="hr-horizontal" />

                            <!-- Container Menu -->
                            <div id="menu-container">
                                <div class="menu-item border p-3 mb-2">
                                    <!-- Bagian Pilih Menu -->
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <label>Pilih Menu <span class="text-danger">*</span></label>
                                            <select class="form-select menu-select">
                                                <option value="">-- Pilih Menu --</option>
                                                @foreach ($menus as $menu)
                                                    <option value="{{ $menu->id }}"
                                                        data-bahan="{{ json_encode($menu->bahanBakus) }}">
                                                        {{ $menu->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-9 d-flex align-items-end justify-content-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-menu">
                                                Hapus Menu
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Daftar Bahan (akan muncul setelah pilih menu) -->
                                    <div class="bahan-list" style="display: none;">
                                        <div class="alert alert-info mb-2">
                                            <strong>Bahan Baku:</strong> Silakan isi berat bersih untuk setiap bahan
                                        </div>
                                    </div>
                                </div>
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
                                    <button type="submit" class="btn btn-success">Simpan</button>
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
            @foreach ($menus as $menu)
                @foreach ($menu->bahanBakus as $bahan)
                    kaloriData[{{ $bahan->id }}] = {{ $bahan->gizi?->energi ?? 0 }};
                @endforeach
            @endforeach

            // Fungsi hitung kalori per baris
            function updateCalories(row) {
                const beratInput = row.find('.berat-input');
                const kaloriInput = row.find('.kalori-input');
                const bahanId = row.data('bahan-id');
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

            // Event: perubahan berat
            $(document).on('input', '.berat-input', function() {
                const row = $(this).closest('.bahan-item');
                updateCalories(row);
            });

            // Event: perubahan menu
            $(document).on('change', '.menu-select', function() {
                const menuItem = $(this).closest('.menu-item');
                const bahanList = menuItem.find('.bahan-list');
                const menuId = $(this).val();
                const bahanData = $(this).find(':selected').data('bahan');

                if (menuId && bahanData) {
                    bahanList.empty().show();
                    bahanList.append(`
                        <div class="alert alert-info mb-2">
                            <strong>Bahan Baku:</strong> Silakan isi berat bersih untuk setiap bahan
                        </div>
                    `);

                    bahanData.forEach((bahan, index) => {
                        const labelHtml = index === 0 ? `
                            <div class="col-md-3">
                                <label>Bahan Makanan</label>
                                <input type="text" class="form-control" value="${bahan.nama}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>Berat Bersih (gram)</label>
                                <input type="number" class="form-control berat-input" value="0" min="0" step="0.01">
                            </div>
                            <div class="col-md-2">
                                <label>Kalori</label>
                                <input type="number" class="form-control kalori-input" value="0" readonly>
                            </div>
                        ` : `
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="${bahan.nama}" readonly>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control berat-input" value="0" min="0" step="0.01">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control kalori-input" value="0" readonly>
                            </div>
                        `;

                        bahanList.append(`
                            <div class="row mb-2 align-items-end bahan-item" data-bahan-id="${bahan.id}">
                                ${labelHtml}
                            </div>
                        `);
                    });
                } else {
                    bahanList.hide().empty();
                }
                updateTotalKalori();
            });

            // Event: tambah menu
            $('#addMenu').on('click', function() {
                const menuContainer = $('#menu-container');
                const clone = `
                    <div class="menu-item border p-3 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <label>Pilih Menu <span class="text-danger">*</span></label>
                                <select class="form-select menu-select">
                                    <option value="">-- Pilih Menu --</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id }}"
                                            data-bahan='{{ json_encode($menu->bahanBakus) }}'>
                                            {{ $menu->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-9 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-menu">
                                    Hapus Menu
                                </button>
                            </div>
                        </div>
                        <div class="bahan-list" style="display: none;"></div>
                    </div>
                `;
                menuContainer.append(clone);
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
                    const menuId = $(this).find('.menu-select').val();
                    const bahanBakus = [];

                    $(this).find('.bahan-item').each(function() {
                        const bahanId = $(this).data('bahan-id');
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

                    if (menuId && bahanBakus.length > 0) {
                        menus.push({
                            menu_id: menuId,
                            bahan_bakus: bahanBakus
                        });
                    }
                });

                const formData = {
                    _token: "{{ csrf_token() }}",
                    nama_paket: namaPaket,
                    menus: menus
                };

                $.ajax({
                    url: "{{ route('paketmenu.store') }}",
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
                                    'Terjadi kesalahan saat menyimpan data'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
