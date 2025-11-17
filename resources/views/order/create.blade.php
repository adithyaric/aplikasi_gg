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
                            <a href="#" class="btn btn-link btn-soft-light" data-bs-toggle="modal" data-bs-target="#modalTambahBahan">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z"
                                        fill="currentColor"></path>
                                </svg>
                                Tambah Menu
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-link btn-soft-light">
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
    <!-- Modal Tambah Menu -->
    <div class="modal fade" id="modalTambahBahan" tabindex="-1" aria-labelledby="modalTambahBahanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius: 15px; border: 1px solid #ddd; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="modalTambahBahanLabel">Tambah Menu PO</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Pilih Periode dan Tambahkan Menu</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid px-5">
                                <div class="row fw-bold border-bottom pb-2 mb-2">
                                    <div class="col-6">Tanggal</div>
                                    <div class="col-6 text-center">Aksi</div>
                                </div>
                                @forelse($rencanaMenus as $rencana)
                                <div class="row align-items-center py-3 border-bottom">
                                    <div class="col-6">
                                        {{ \Carbon\Carbon::parse($rencana->start_date)->format('d/m/Y') }}
                                    </div>
                                    <div class="col-6 text-center">
                                        <button class="btn btn-sm btn-success add-menu-btn"
                                            data-rencana-id="{{ $rencana->id }}" type="button">
                                            Add Menu
                                        </button>
                                    </div>
                                </div>
                                @empty
                                <div class="row align-items-center py-3">
                                    <div class="col-12 text-center text-muted">
                                        Tidak ada rencana menu tersedia
                                    </div>
                                </div>
                                @endforelse
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
            <div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
        </div>
        <div class="card-body">
            <form id="orderForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Pemasok *</label>
                        <select name="supplier_id" class="form-select shadow-none" required>
                            <option value="">-- Pilih Pemasok --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label class="form-label">Tanggal PO *</label>
                        <input type="date" name="tanggal_po" class="form-control" required />
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label">Tanggal Penerimaan *</label>
                        <input type="date" name="tanggal_penerimaan" class="form-control" required />
                    </div>
                </div>

                <hr class="hr-horizontal" />
                <h5>Bahan Baku</h5>

                <div id="itemContainer">
                    <div class="row itemRow align-items-end mb-3">
                        <div class="form-group col-4">
                            <label class="form-label">Jenis Bahan Pokok *</label>
                            <select name="items[0][bahan_baku_id]" class="form-select shadow-none bahan-select" required>
                                <option value="">Pilih Bahan Pokok</option>
                                @foreach ($bahanbakus as $bahan)
                                    <option value="{{ $bahan->id }}" data-satuan="{{ $bahan->satuan }}">
                                        {{ $bahan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label class="form-label">Quantity *</label>
                            <input type="number" name="items[0][quantity]" class="form-control quantity-input"
                                step="0.01" min="0.01" required />
                        </div>
                        <div class="form-group col-2">
                            <label class="form-label">Satuan *</label>
                            <input type="text" name="items[0][satuan]" class="form-control satuan-input" readonly
                                required />
                        </div>
                        <div class="form-group col-3">
                            <label class="form-label">Harga *</label>
                            <input type="number" name="items[0][unit_cost]" class="form-control price-input" step="0.01"
                                min="0" required />
                        </div>
                        <div class="form-group col-1">
                            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                        </div>
                    </div>
                </div>

                <hr class="hr-horizontal mb-4" />

                <div class="row mb-3">
                    <div class="col-md-9 text-end">
                        <h6 class="fw-bold">Total Harga:</h6>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="totalHarga" class="form-control text-end fw-bold" value="Rp 0"
                            disabled />
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
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
        let itemIndex = 1;
        const bahanbakus = @json($bahanbakus);

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        function calculateTotal() {
            let total = 0;
            $('.itemRow').each(function() {
                const qty = parseFloat($(this).find('.quantity-input').val()) || 0;
                const price = parseFloat($(this).find('.price-input').val()) || 0;
                total += qty * price;
            });
            $('#totalHarga').val(formatRupiah(total));
        }

        function createItemRow(index) {
            let options = '<option value="">Pilih Bahan Pokok</option>';
            bahanbakus.forEach(bahan => {
                options += `<option value="${bahan.id}" data-satuan="${bahan.satuan}">${bahan.nama}</option>`;
            });

            return `
            <div class="row itemRow align-items-end mb-3">
                <div class="form-group col-4">
                    <label class="form-label">Jenis Bahan Pokok *</label>
                    <select name="items[${index}][bahan_baku_id]" class="form-select shadow-none bahan-select" required>
                        ${options}
                    </select>
                </div>
                <div class="form-group col-2">
                    <label class="form-label">Quantity *</label>
                    <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" step="0.01" min="0.01" required />
                </div>
                <div class="form-group col-2">
                    <label class="form-label">Satuan *</label>
                    <input type="text" name="items[${index}][satuan]" class="form-control satuan-input" readonly required />
                </div>
                <div class="form-group col-3">
                    <label class="form-label">Harga *</label>
                    <input type="number" name="items[${index}][unit_cost]" class="form-control price-input" step="0.01" min="0" required />
                </div>
                <div class="form-group col-1">
                    <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                </div>
            </div>
        `;
        }

        $('#tambah-item').click(function() {
            $('#itemContainer').append(createItemRow(itemIndex));
            itemIndex++;
        });

        $(document).on('click', '.removeRow', function() {
            if ($('.itemRow').length > 1) {
                $(this).closest('.itemRow').remove();
                calculateTotal();
            } else {
                alert('Minimal harus ada 1 item');
            }
        });

        $(document).on('change', '.bahan-select', function() {
            const satuan = $(this).find(':selected').data('satuan');
            $(this).closest('.itemRow').find('.satuan-input').val(satuan || '');
        });

        $(document).on('input', '.quantity-input, .price-input', function() {
            calculateTotal();
        });

        $('#orderForm').submit(function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '{{ route('orders.store') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = '{{ route('orders.index') }}';
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    alert(errors);
                }
            });
        });
    </script>
    <script>
        // Handle Add Menu button click
        $(document).on('click', '.add-menu-btn', function() {
            const rencanaId = $(this).data('rencana-id');

            $.ajax({
                url: '{{ route("orders.addMenuItems") }}',
                method: 'GET',
                data: {
                    rencana_menu_id: rencanaId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Clear existing items
                        $('#itemContainer').empty();
                        itemIndex = 0;

                        // Add new items from menu
                        response.items.forEach(function(item) {
                            const newRow = createItemRow(itemIndex);
                            $('#itemContainer').append(newRow);

                            const $row = $('#itemContainer .itemRow').last();
                            $row.find('.bahan-select').val(item.bahan_baku_id).trigger('change');
                            $row.find('.quantity-input').val(item.quantity.toFixed(2));
                            $row.find('.satuan-input').val(item.satuan);

                            itemIndex++;
                        });

                        calculateTotal();

                        // Close modal
                        $('#modalTambahBahan').modal('hide');

                        alert('Menu berhasil ditambahkan ke PO');
                    }
                },
                error: function(xhr) {
                    alert('Gagal menambahkan menu: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
                }
            });
        });
    </script>
@endpush
