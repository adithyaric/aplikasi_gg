@extends('layouts.master')

@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Penerimaan Barang</h3>
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
                        <form id="penerimaanForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control" value="{{ $order->supplier->nama }}"
                                        disabled />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Tanggal Terima</label>
                                    <input type="text" class="form-control"
                                        value="{{ $order->tanggal_penerimaan->format('d/m/Y') }}" disabled />
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label">Status</label>
                                    <select name="status_penerimaan" class="select2-input form-select shadow-none" id="paymentMethod" required>
                                        <option value="">Pilih Status Penerimaan</option>
                                        <option value="confirmed"
                                            {{ $order->status_penerimaan == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="draft"
                                            {{ $order->status_penerimaan == 'draft' ? 'selected' : '' }}>
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
                                            <th>Qty Diterima</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $item->bahanBaku?->nama ?? $item->bahanOperasional?->nama}}</td>
                                                <td>{{ $item->satuan }}</td>
                                                <td>{{ $item->bahanBaku?->merek ?? $item->bahanOperasional?->merek }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                                                <td>
                                                    <input type="hidden" name="items[{{ $loop->index }}][id]"
                                                        value="{{ $item->id }}">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="items[{{ $loop->index }}][quantity_diterima]"
                                                            id="diterima_{{ $item->id }}" value="1"
                                                            {{ $item->quantity_diterima ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="diterima_{{ $item->id }}">
                                                            Sesuai
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="items[{{ $loop->index }}][quantity_diterima]"
                                                            id="tidak_diterima_{{ $item->id }}" value="0"
                                                            {{ !$item->quantity_diterima ? 'checked' : '' }} required>
                                                        <label class="form-check-label"
                                                            for="tidak_diterima_{{ $item->id }}">
                                                            Tidak Sesuai
                                                        </label>
                                                    </div>
                                                    <textarea name="items[{{ $loop->index }}][notes]" class="form-control mt-2" placeholder="Berikan catatan disini..."
                                                        rows="2">{{ $item->notes }}</textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr class="hr-horizontal" />

                            <div class="d-flex justify-content-end align-items-center mb-3">
                                <p class="h4">Subtotal: <span class="badge bg-success" id="penerimaan_grand_total">Rp.{{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
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
        $('#penerimaanForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            // formData.append('status_penerimaan', 'confirmed');

            $.ajax({
                url: '{{ route('penerimaan.update', $order) }}',
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
                        window.location.href = '{{ route('penerimaan.index') }}';
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
