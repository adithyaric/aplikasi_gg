@extends('layouts.master')

@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Penggunaan Barang</h3>
                            <p>Makan Sehat Bergizi</p>
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
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="penggunaanForm">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control" value="{{ $order->supplier->nama }}"
                                        disabled />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Tanggal Penggunaan <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_penggunaan" class="form-control"
                                        value="{{ $order->tanggal_penggunaan?->format('Y-m-d') }}" required />
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label">Status</label>
                                    <select name="status_penggunaan" class="select2-input form-select shadow-none" required>
                                        <option value="">Pilih Status Penggunaan</option>
                                        <option value="confirmed"
                                            {{ $order->status_penggunaan == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="draft" {{ $order->status_penggunaan == 'draft' ? 'selected' : '' }}>
                                            Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ $order->notes }}</textarea>
                                </div>
                            </div>
                            <hr class="hr-horizontal" />
                            <h5>Bahan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Bahan</th>
                                            <th>Satuan</th>
                                            <th>Brand</th>
                                            <th>Qty PO</th>
                                            <th>Unit Cost</th>
                                            <th>Input Penggunaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->bahanBaku?->nama ?? $item->bahanOperasional?->nama }}</td>
                                                <td>{{ $item->satuan }}</td>
                                                <td>{{ $item->bahanBaku?->merek ?? $item->bahanOperasional?->merek }}</td>
                                                <td class="qty-po">{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                                                <td>
                                                    <input type="hidden" name="items[{{ $loop->index }}][id]"
                                                        value="{{ $item->id }}">

                                                    <div class="mb-2">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input input-type-radio" type="radio"
                                                                name="items[{{ $loop->index }}][input_type]"
                                                                id="habis_{{ $item->id }}" value="habis"
                                                                data-index="{{ $loop->index }}"
                                                                {{ $item->penggunaan_input_type == 'habis' ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label"
                                                                for="habis_{{ $item->id }}">
                                                                Habis
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input input-type-radio" type="radio"
                                                                name="items[{{ $loop->index }}][input_type]"
                                                                id="sisa_{{ $item->id }}" value="sisa"
                                                                data-index="{{ $loop->index }}"
                                                                {{ $item->penggunaan_input_type == 'sisa' ? 'checked' : '' }}
                                                                required>
                                                            <label class="form-check-label" for="sisa_{{ $item->id }}">
                                                                Sisa
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="input-group mb-2 quantity-input-group"
                                                        data-index="{{ $loop->index }}"
                                                        style="{{ $item->penggunaan_input_type == 'habis' ? 'display:none;' : '' }}">
                                                        <span class="input-group-text">Sisa Stok</span>
                                                        <input type="number"
                                                            name="items[{{ $loop->index }}][quantity_value]"
                                                            class="form-control quantity-input"
                                                            data-index="{{ $loop->index }}"
                                                            data-max="{{ $item->quantity }}" step="0.01" min="0"
                                                            max="{{ $item->quantity }}"
                                                            value="{{ $item->quantity_penggunaan ? $item->quantity - $item->quantity_penggunaan : '' }}"
                                                            {{ $item->penggunaan_input_type == 'sisa' ? 'required' : '' }}>
                                                    </div>

                                                    <div class="alert alert-info py-2 mb-2 usage-info"
                                                        data-index="{{ $loop->index }}" style="display:none;">
                                                        <small>Qty Penggunaan: <strong class="usage-qty">0</strong></small>
                                                    </div>

                                                    <textarea name="items[{{ $loop->index }}][notes]" class="form-control" placeholder="Catatan penggunaan..."
                                                        rows="2">{{ $item->notes }}</textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr class="hr-horizontal" />
                            <div class="d-flex justify-content-end align-items-center mb-3">
                                <p class="h4">Subtotal: <span
                                        class="badge bg-success">Rp.{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                </p>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary">Kembali</a>
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
        // Handle input type change
        $('.input-type-radio').on('change', function() {
            const index = $(this).data('index');
            const inputType = $(this).val();
            const quantityGroup = $(`.quantity-input-group[data-index="${index}"]`);
            const quantityInput = $(`.quantity-input[data-index="${index}"]`);
            const usageInfo = $(`.usage-info[data-index="${index}"]`);

            if (inputType === 'habis') {
                quantityGroup.hide();
                quantityInput.prop('required', false).val('');
                usageInfo.hide();
            } else {
                quantityGroup.show();
                quantityInput.prop('required', true);
                calculateUsage(index);
            }
        });

        // Calculate usage quantity when sisa input changes
        $('.quantity-input').on('input', function() {
            const index = $(this).data('index');
            calculateUsage(index);
        });

        function calculateUsage(index) {
            const qtyPo = parseFloat($('tbody tr').eq(index).find('.qty-po').text());
            const sisaStok = parseFloat($(`.quantity-input[data-index="${index}"]`).val()) || 0;
            const qtyPenggunaan = qtyPo - sisaStok;

            $(`.usage-info[data-index="${index}"]`).show();
            $(`.usage-info[data-index="${index}"] .usage-qty`).text(qtyPenggunaan.toFixed(2));
        }

        // Initialize on page load
        $('.input-type-radio:checked').each(function() {
            const index = $(this).data('index');
            if ($(this).val() === 'sisa') {
                calculateUsage(index);
            }
        });

        $('#penggunaanForm').submit(function(e) {
            e.preventDefault();

            // Validate sisa inputs
            let isValid = true;
            $('.input-type-radio:checked').each(function() {
                if ($(this).val() === 'sisa') {
                    const index = $(this).data('index');
                    const qtyInput = $(`.quantity-input[data-index="${index}"]`);
                    const qtyPo = parseFloat($('tbody tr').eq(index).find('.qty-po').text());
                    const sisaStok = parseFloat(qtyInput.val()) || 0;

                    if (sisaStok > qtyPo) {
                        alert('Sisa stok tidak boleh lebih besar dari Qty PO');
                        isValid = false;
                        return false;
                    }
                }
            });

            if (!isValid) return;

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('penggunaan.update', $order) }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = '{{ route('penggunaan.index') }}';
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    alert(errors);
                }
            });
        });
    </script>
@endpush
