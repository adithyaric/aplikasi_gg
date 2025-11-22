@extends('layouts.master')

@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Pembayaran</h3>
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body d-flex gap-2 align-items-start">
                        <div class="row">
                        <div class="col-md-8 col-sm-12">
                        <div class="border border-2 d-flex flex-column gap-2 rounded-3 overflow-hidden">
                            <div class="d-flex p-3 border-bottom border-bottom-1">
                                <div class="d-flex flex-column">
                                    <strong>{{ $order->order_number }}</strong>
                                    <h4 class="fw-bold">{{ $order->order_number }}</h4>
                                    <strong>Tanggal Terima : {{ $order->tanggal_penerimaan->format('d/m/Y') }}</strong>
                                    <strong>Pemasok : {{ $order->supplier?->nama }}</strong>
                                    <small>Bank & No Rek : {{ $order->supplier?->bank_nama }}
                                        {{ $order->supplier?->bank_no_rek }}</small>
                                </div>
                                <div class="ms-auto align-self-start">
                                    <h5>
                                        @if ($order->transaction?->status == 'unpaid')
                                            <span class="badge rounded bg-danger">Unpaid</span>
                                        @elseif($order->transaction?->status == 'partial')
                                            <span class="badge rounded bg-warning">Partial</span>
                                        @else
                                            <span class="badge rounded bg-success">Paid</span>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                            <div class="p-3 border-bottom border-bottom-1">
                                <div class="overflow-auto">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Bahan Pokok</th>
                                                <th>Satuan</th>
                                                <th>Brand</th>
                                                <th>Unit Cost</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->bahanBaku?->nama ?? $item->bahanOperasional?->nama}}</td>
                                                    <td>{{ $item->satuan }}</td>
                                                    <td>{{ $item->bahanBaku?->merek ?? $item->bahanOperasional?->merek }}</td>
                                                    <td>Rp.{{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center py-2 px-3 border-bottom border-bottom-1">
                                <h5 class="fw-bold">Grand Total:</h5>
                                <h5 class="fw-bold">Rp.{{ number_format($order->grand_total, 0, ',', '.') }}</h5>
                            </div>
                            <div class="d-flex flex-column pt-2 pb-3 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Paid Amount: </strong>
                                    <h5>
                                        <span class="badge bg-success">Rp.
                                            {{ number_format($order->transaction?->amount, 0, ',', '.') }}</span>
                                    </h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Outstanding Balance: </strong>
                                    <h5>
                                        <span
                                            class="badge bg-danger">Rp.{{ number_format($order->grand_total - $order->transaction?->amount, 0, ',', '.') }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                        <div class="border border-2 d-flex flex-column gap-2 rounded-3 overflow-hidden">
                            <h4 class="fw-bold p-3 border-bottom border-bottom-1">
                                Pembayaran
                            </h4>
                            <form id="pembayaranForm" class="p-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="form-label">Tanggal Bayar</label>
                                    <input type="date" name="payment_date" class="form-control"
                                        value="{{ $order->transaction?->payment_date?->format('Y-m-d') }}" required />
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select name="payment_method" class="select2-input form-select shadow-none" id="paymentMethod"
                                        required>
                                        <option value="">Pilih Metode Pembayaran</option>
                                        <option value="cash"
                                            {{ $order->transaction?->payment_method == 'cash' ? 'selected' : '' }}>
                                            Cash</option>
                                        <option value="bank_transfer"
                                            {{ $order->transaction?->payment_method == 'bank_transfer' ? 'selected' : '' }}>
                                            Bank Transfer</option>
                                        <option value="giro_cek"
                                            {{ $order->transaction?->payment_method == 'giro_cek' ? 'selected' : '' }}>
                                            Giro/Cek</option>
                                        <option value="lainnya"
                                            {{ $order->transaction?->payment_method == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">No. Bukti / Referensi</label>
                                    <input type="text" name="payment_reference" class="form-control"
                                        id="paymentReference" value="{{ $order->transaction?->payment_reference }}"
                                        placeholder="Mis. TRF-0925-00123" />
                                    @if ($order->supplier->bank_nama && $order->supplier->bank_no_rek)
                                        <small class="text-muted">
                                            Rekening: {{ $order->supplier->bank_nama }} -
                                            {{ $order->supplier->bank_no_rek }}
                                        </small>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Jumlah Pembayaran</label>
                                    <input type="number" name="amount" class="form-control" id="amountInput"
                                        value="{{ $order->transaction?->amount }}" step="0.01" min="0"
                                        max="{{ $order->grand_total }}" placeholder="Masukkan jumlah yang dibayar"
                                        required />
                                    <small class="text-muted">
                                        Max: Rp.{{ number_format($order->grand_total, 0, ',', '.') }}
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Bukti Transfer</label>
                                    <input type="file" name="bukti_transfer" class="form-control"
                                        accept="image/*,.pdf" />
                                    @if ($order->transaction?->bukti_transfer)
                                        <small class="text-muted">
                                            <a href="{{ Storage::url($order->transaction->bukti_transfer) }}"
                                                target="_blank">Lihat bukti saat ini</a>
                                        </small>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="select2-input form-select shadow-none" id="paymentStatus"
                                        required>
                                        <option value="">Pilih Status Pembayaran</option>
                                        <option value="unpaid"
                                            {{ $order->transaction?->status == 'unpaid' ? 'selected' : '' }}>
                                            Unpaid</option>
                                        <option value="paid"
                                            {{ $order->transaction?->status == 'paid' ? 'selected' : '' }}>
                                            Paid</option>
                                        <option value="partial"
                                            {{ $order->transaction?->status == 'partial' ? 'selected' : '' }}>
                                            Partial</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)">{{ $order->transaction?->notes }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
                                </div>
                            </form>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Auto-fill payment reference based on payment method
        $('#paymentMethod').change(function() {
            const method = $(this).val();
            if (method === 'bank_transfer' && '{{ $order->supplier->bank_no_rek }}') {
                const date = new Date();
                const ref = 'TRF-' + date.getFullYear().toString().substr(-2) +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    Math.floor(Math.random() * 100000).toString().padStart(5, '0');
                $('#paymentReference').val(ref);
            }
        });

        // Format amount input
        $('#amountInput').on('input', function() {
            let value = $(this).val().replace(/[^0-9]/g, '');
            if (value) {
                const max = {{ $order->grand_total }};
                if (parseFloat(value) > max) {
                    $(this).val(max);
                }
            }
        });

        $('#pembayaranForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('pembayaran.update', $order) }}',
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
                        window.location.href = '{{ route('pembayaran.index') }}';
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
