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
                            <a href="#" class="btn btn-link btn-soft-light" data-bs-toggle="modal"
                                data-bs-target="#modalTambahBahan">
                                Tambah Menu
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-link btn-soft-light">
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
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr class="fw-bold border-bottom">
                                            <th class="border-0">Tanggal</th>
                                            <th class="border-0">Menu</th>
                                            <th class="border-0 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rencanaMenus as $rencana)
                                            <tr>
                                                <td class="align-middle">
                                                    {{ \Carbon\Carbon::parse($rencana->start_date)->format('d/m/Y') }}
                                                </td>
                                                <td class="table-responsive text-nowrap">
                                                    <table class="table table-sm table-bordered mb-0">
                                                        @foreach ($rencana->paketMenu as $paket)
                                                            <tr class="border-bottom">
                                                                <td class="fw-bold ps-0">{{ $paket->nama }}</td>
                                                                <td class="text-end pe-0">
                                                                    <small class="fw-bold">{{ $paket->pivot->porsi }}
                                                                        porsi</small>
                                                                </td>
                                                            </tr>
                                                            @foreach ($paket->menus as $menu)
                                                                <tr>
                                                                    <td class="ps-3">{{ $menu->nama }}</td>
                                                                    <td></td>
                                                                </tr>
                                                                @foreach ($menu->bahanBakus as $bahan)
                                                                    @php
                                                                        $pivotData = DB::table('bahan_baku_menu')
                                                                            ->where('paket_menu_id', $paket->id)
                                                                            ->where('menu_id', $menu->id)
                                                                            ->where('bahan_baku_id', $bahan->id)
                                                                            ->first();
                                                                    @endphp
                                                                    <tr>
                                                                        <td class="ps-5 text-muted">{{ $bahan->nama }}</td>
                                                                        <td class="fw-bold text-end">
                                                                            <small>{{ $pivotData->berat_bersih ?? 0 }}
                                                                                {{ $bahan->satuan }}</small>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                    </table>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-sm btn-success add-menu-btn"
                                                        data-rencana-id="{{ $rencana->id }}" type="button">
                                                        Add Menu
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-3">
                                                    Tidak ada rencana menu tersedia
                                                </td>
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
    </div>
@endsection
@section('container')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $title }} - {{ $order->order_number }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="orderForm">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Pemasok *</label>
                                    <select name="supplier_id" class="select2-input form-select shadow-none" required>
                                        <option value="">-- Pilih Pemasok --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ $order->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="form-label">Tanggal PO *</label>
                                    <input type="date" name="tanggal_po" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($order->tanggal_po)->format('Y-m-d') }}"
                                        required />
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">Tanggal Penerimaan *</label>
                                    <input type="date" name="tanggal_penerimaan" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($order->tanggal_penerimaan)->format('Y-m-d') }}"
                                        required />
                                </div>
                            </div>
                            <hr class="hr-horizontal" />
                            <h5>Bahan Baku & Operasional</h5>
                            <div id="itemContainer">
                                @foreach ($order->items as $index => $item)
                                    <div class="row itemRow align-items-end mb-3">
                                        <div class="form-group col-3">
                                            <label class="form-label">Jenis Bahan *</label>
                                            <select name="items[{{ $index }}][bahan_id]"
                                                class="form-select shadow-none bahan-select" required>
                                                <option value="">Pilih Bahan</option>
                                                <optgroup label="Bahan Baku">
                                                    @foreach ($bahans->where('type', 'bahan_baku') as $bahan)
                                                        <option value="{{ $bahan['id'] }}"
                                                            data-satuan="{{ $bahan['satuan'] }}" data-type="bahan_baku"
                                                            {{ $item->bahan_baku_id == $bahan['id'] ? 'selected' : '' }}>
                                                            {{ $bahan['nama'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Bahan Operasional">
                                                    @foreach ($bahans->where('type', 'bahan_operasional') as $bahan)
                                                        <option value="{{ $bahan['id'] }}"
                                                            data-satuan="{{ $bahan['satuan'] }}"
                                                            data-type="bahan_operasional"
                                                            {{ $item->bahan_operasional_id == $bahan['id'] ? 'selected' : '' }}>
                                                            {{ $bahan['nama'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="form-label">Quantity *</label>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                class="form-control quantity-input" step="0.01" min="0.01"
                                                value="{{ $item->quantity }}" required />
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="form-label">Satuan *</label>
                                            <input type="text" name="items[{{ $index }}][satuan]"
                                                class="form-control satuan-input" value="{{ $item->satuan }}" readonly
                                                required />
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="form-label">Harga *</label>
                                            <input type="number" name="items[{{ $index }}][unit_cost]"
                                                class="form-control price-input" step="0.01" min="0"
                                                value="{{ $item->unit_cost }}" required />
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="form-label">Subtotal</label>
                                            <input type="text" class="form-control subtotal-input" disabled />
                                        </div>
                                        <div class="form-group col-1">
                                            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                                        </div>
                                        <input type="hidden" name="items[{{ $index }}][type]" class="type-input"
                                            value="{{ $item->bahan_baku_id ? 'bahan_baku' : 'bahan_operasional' }}" />
                                    </div>
                                @endforeach
                            </div>
                            <hr class="hr-horizontal mb-4" />
                            <div class="row mb-3">
                                <div class="col-md-9 text-end">
                                    <h6 class="fw-bold">Total Harga:</h6>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="totalHarga" class="form-control text-end fw-bold"
                                        value="Rp 0" disabled />
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary" id="tambah-item" style="display:none;">
                                    <i class="bi bi-plus-circle"></i> Tambah Item
                                </button>
                                <button type="submit" class="btn btn-success">Update</button>
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
        let itemIndex = {{ count($order->items) }};
        const bahans = @json($bahans);

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
                const subtotal = qty * price;

                $(this).find('.subtotal-input').val(formatRupiah(subtotal));
                total += subtotal;
            });
            $('#totalHarga').val(formatRupiah(total));
        }

        function createItemRow(index) {
            let optionsBahanBaku = '';
            let optionsBahanOperasional = '';
            bahans.forEach(bahan => {
                const option =
                    `<option value="${bahan.id}" data-satuan="${bahan.satuan}" data-type="${bahan.type}">${bahan.nama}</option>`;
                if (bahan.type === 'bahan_baku') {
                    optionsBahanBaku += option;
                } else {
                    optionsBahanOperasional += option;
                }
            });
            return `
            <div class="row itemRow align-items-end mb-3">
                <div class="form-group col-3">
                    <label class="form-label">Jenis Bahan *</label>
                    <select name="items[${index}][bahan_id]" class="form-select shadow-none bahan-select" data-type="" required>
                        <option value="">Pilih Bahan</option>
                        <optgroup label="Bahan Baku">
                            ${optionsBahanBaku}
                        </optgroup>
                        <optgroup label="Bahan Operasional">
                            ${optionsBahanOperasional}
                        </optgroup>
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
                <div class="form-group col-2">
                    <label class="form-label">Harga *</label>
                    <input type="number" name="items[${index}][unit_cost]" class="form-control price-input" step="0.01" min="0" required />
                </div>
                <div class="form-group col-2">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control subtotal-input" disabled />
                </div>
                <div class="form-group col-1">
                    <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                </div>
                <input type="hidden" name="items[${index}][type]" class="type-input" value="" />
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
            const $selected = $(this).find(':selected');
            const satuan = $selected.data('satuan');
            const type = $selected.data('type');
            const $row = $(this).closest('.itemRow');
            $row.find('.satuan-input').val(satuan || '');
            $row.find('.type-input').val(type || '');
            $(this).attr('data-type', type);
        });
        $(document).on('input', '.quantity-input, .price-input', function() {
            calculateTotal();
        });
        $('#orderForm').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '{{ route('orders.update', $order) }}',
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
        // Handle Add Menu button click
        $(document).on('click', '.add-menu-btn', function() {
            const rencanaId = $(this).data('rencana-id');
            $.ajax({
                url: '{{ route('orders.addMenuItems') }}',
                method: 'GET',
                data: {
                    rencana_menu_id: rencanaId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#itemContainer').empty();
                        itemIndex = 0;
                        response.items.forEach(function(item) {
                            const newRow = createItemRow(itemIndex);
                            $('#itemContainer').append(newRow);
                            const $row = $('#itemContainer .itemRow').last();
                            $row.find('.bahan-select').val(item.bahan_baku_id).trigger(
                                'change');
                            $row.find('.quantity-input').val(item.quantity.toFixed(2));
                            $row.find('.satuan-input').val(item.satuan);
                            itemIndex++;
                        });
                        calculateTotal();
                        $('#modalTambahBahan').modal('hide');
                        alert('Menu berhasil ditambahkan ke PO');
                    }
                },
                error: function(xhr) {
                    alert('Gagal menambahkan menu: ' + (xhr.responseJSON?.message ||
                        'Terjadi kesalahan'));
                }
            });
        });
        // Calculate initial total
        $(document).ready(function() {
            calculateTotal();
        });
    </script>
@endpush
