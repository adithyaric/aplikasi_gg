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
                            <a href="{{ route('rekening-koran-va.index') }}" class="btn btn-link btn-soft-light">
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
                            <h4 class="card-title">Formulir Rekening Koran VA</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('rekening-koran-va.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="form-label" for="tanggal_transaksi">Tanggal Transaksi</label>
                                    <input type="datetime-local"
                                        class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                        id="tanggal_transaksi" name="tanggal_transaksi"
                                        value="{{ old('tanggal_transaksi') }}" required>
                                    @error('tanggal_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label" for="ref">Ref</label>
                                    <select class="form-select shadow-none @error('ref') is-invalid @enderror"
                                        id="ref" name="ref" required>
                                        <option selected disabled>Pilih Referensi</option>
                                        <option value="BRIVA" {{ old('ref') == 'BRIVA' ? 'selected' : '' }}>BRIVA</option>
                                        <option value="CMSX" {{ old('ref') == 'CMSX' ? 'selected' : '' }}>CMSX</option>
                                        <option value="KLIKBCA" {{ old('ref') == 'KLIKBCA' ? 'selected' : '' }}>KLIKBCA
                                        </option>
                                        <option value="TRANSFER" {{ old('ref') == 'TRANSFER' ? 'selected' : '' }}>TRANSFER
                                        </option>
                                        <option value="SKN" {{ old('ref') == 'SKN' ? 'selected' : '' }}>SKN</option>
                                        <option value="LLG" {{ old('ref') == 'LLG' ? 'selected' : '' }}>LLG</option>
                                        <option value="BI-RTGS" {{ old('ref') == 'BI-RTGS' ? 'selected' : '' }}>BI-RTGS
                                        </option>
                                        <option value="BIAYA" {{ old('ref') == 'BIAYA' ? 'selected' : '' }}>BIAYA</option>
                                        <option value="PAJAK" {{ old('ref') == 'PAJAK' ? 'selected' : '' }}>PAJAK</option>
                                        <option value="PEMBAYARAN" {{ old('ref') == 'PEMBAYARAN' ? 'selected' : '' }}>
                                            PEMBAYARAN</option>
                                    </select>
                                    @error('ref')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label" for="uraian">Uraian</label>
                                <textarea class="form-control @error('uraian') is-invalid @enderror" id="uraian" name="uraian" rows="2"
                                    placeholder="Masukkan uraian transaksi" required>{{ old('uraian') }}</textarea>
                                @error('uraian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Jenis Transaksi</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_transaksi"
                                            id="jenis_debit" value="debit"
                                            {{ old('jenis_transaksi') == 'debit' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="jenis_debit">Debit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_transaksi"
                                            id="jenis_kredit" value="kredit"
                                            {{ old('jenis_transaksi') == 'kredit' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="jenis_kredit">Kredit</label>
                                    </div>
                                </div>
                            </div>

                            <input type="number" step="0.01" class="form-control" id="debit" name="debit"
                                value="{{ old('debit', 0) }}" hidden>
                            <input type="number" step="0.01" class="form-control" id="kredit" name="kredit"
                                value="{{ old('kredit', 0) }}" hidden>

                            <div class="row mt-3">
                                <div class="form-group col-6">
                                    <label class="form-label" for="nominal">Nominal</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('nominal') is-invalid @enderror" id="nominal"
                                        name="nominal" value="{{ old('nominal', 0) }}" placeholder="0" required>
                                    @error('nominal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label" for="saldo">Saldo</label>
                                    <input type="text" class="form-control" id="saldo_display"
                                        value="Rp {{ number_format($lastSaldo, 0, ',', '.') }}" readonly>
                                    <input type="number" step="0.01" name="saldo" id="saldo"
                                        value="{{ $lastSaldo }}" hidden>
                                    <small class="text-muted">Saldo akhir setelah transaksi</small>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-6">
                                    <label class="form-label" for="kategori_transaksi">Kategori Transaksi</label>
                                    <select
                                        class="form-select shadow-none @error('kategori_transaksi') is-invalid @enderror"
                                        id="kategori_transaksi" name="kategori_transaksi" required>
                                        <option selected disabled>Pilih Kategori</option>
                                        <option value="Penerimaan dari BGN"
                                            {{ old('kategori_transaksi') == 'Penerimaan dari BGN' ? 'selected' : '' }}>
                                            Penerimaan
                                            dari BGN</option>
                                        <option value="Transfer Masuk"
                                            {{ old('kategori_transaksi') == 'Transfer Masuk' ? 'selected' : '' }}>
                                            Transfer Masuk</option>
                                        <option value="Transfer Keluar"
                                            {{ old('kategori_transaksi') == 'Transfer Keluar' ? 'selected' : '' }}>
                                            Transfer Keluar</option>
                                        <option value="Biaya Admin"
                                            {{ old('kategori_transaksi') == 'Biaya Admin' ? 'selected' : '' }}>
                                            Biaya Admin</option>
                                        <option value="Penerimaan Pelanggan"
                                            {{ old('kategori_transaksi') == 'Penerimaan Pelanggan' ? 'selected' : '' }}>
                                            Penerimaan Pelanggan</option>
                                        <option value="Pembayaran Vendor"
                                            {{ old('kategori_transaksi') == 'Pembayaran Vendor' ? 'selected' : '' }}>
                                            Pembayaran Vendor</option>
                                        <option value="Biaya Operasional"
                                            {{ old('kategori_transaksi') == 'Biaya Operasional' ? 'selected' : '' }}>
                                            Biaya Operasional</option>
                                        <option value="Biaya Bank"
                                            {{ old('kategori_transaksi') == 'Biaya Bank' ? 'selected' : '' }}>
                                            Biaya Bank</option>
                                        <option value="Transfer Internal"
                                            {{ old('kategori_transaksi') == 'Transfer Internal' ? 'selected' : '' }}>
                                            Transfer Internal</option>
                                        <option value="Pembayaran Pajak"
                                            {{ old('kategori_transaksi') == 'Pembayaran Pajak' ? 'selected' : '' }}>
                                            Pembayaran Pajak</option>
                                        <option value="Pembayaran Pinjaman"
                                            {{ old('kategori_transaksi') == 'Pembayaran Pinjaman' ? 'selected' : '' }}>
                                            Pembayaran
                                            Pinjaman</option>
                                        <option value="Pembayaran Hutang"
                                            {{ old('kategori_transaksi') == 'Pembayaran Hutang' ? 'selected' : '' }}>
                                            Pembayaran Hutang</option>
                                        <option value="Penerimaan Internal"
                                            {{ old('kategori_transaksi') == 'Penerimaan Internal' ? 'selected' : '' }}>
                                            Penerimaan
                                            Internal</option>
                                        <option value="Deposit PO"
                                            {{ old('kategori_transaksi') == 'Deposit PO' ? 'selected' : '' }}>
                                            Deposit PO</option>
                                    </select>
                                    @error('kategori_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label" for="minggu">Minggu</label>
                                    <select class="form-select shadow-none @error('minggu') is-invalid @enderror"
                                        id="minggu" name="minggu">
                                        <option selected disabled>Pilih Minggu</option>
                                        <option value="1" {{ old('minggu') == '1' ? 'selected' : '' }}>Minggu 1
                                        </option>
                                        <option value="2" {{ old('minggu') == '2' ? 'selected' : '' }}>Minggu 2
                                        </option>
                                        <option value="3" {{ old('minggu') == '3' ? 'selected' : '' }}>Minggu 3
                                        </option>
                                        <option value="4" {{ old('minggu') == '4' ? 'selected' : '' }}>Minggu 4
                                        </option>
                                    </select>
                                    @error('minggu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label" for="transaction_id">Link ke Transaksi PO (Optional)</label>
                                <select class="form-select shadow-none @error('transaction_id') is-invalid @enderror"
                                    id="transaction_id" name="transaction_id">
                                    <option value="">-- Tidak ada link --</option>
                                    @foreach ($transactions as $transaction)
                                        <option value="{{ $transaction->id }}"
                                            {{ old('transaction_id') == $transaction->id ? 'selected' : '' }}>
                                            {{ $transaction->order->order_number }} - Rp
                                            {{ number_format($transaction->amount, 0, ',', '.') }}
                                            ({{ $transaction->payment_date->format('d/m/Y') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('transaction_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('rekening-koran-va.index') }}">
                                    <button type="button" class="btn btn-secondary me-2">Batal</button>
                                </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const jenisDebit = document.getElementById('jenis_debit');
            const jenisKredit = document.getElementById('jenis_kredit');
            const debitInput = document.getElementById('debit');
            const kreditInput = document.getElementById('kredit');
            const nominalInput = document.getElementById('nominal');
            const saldoInput = document.getElementById('saldo');
            const saldoDisplay = document.getElementById('saldo_display');
            const lastSaldo = {{ $lastSaldo }};

            function formatRupiah(angka) {
                return 'Rp ' + angka.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function updateSaldo() {
                const nominal = parseFloat(nominalInput.value) || 0;
                let newSaldo = lastSaldo;

                if (jenisDebit.checked) {
                    debitInput.value = nominal;
                    kreditInput.value = 0;
                    newSaldo = lastSaldo - nominal;
                } else if (jenisKredit.checked) {
                    kreditInput.value = nominal;
                    debitInput.value = 0;
                    newSaldo = lastSaldo + nominal;
                }

                saldoInput.value = newSaldo.toFixed(2);
                saldoDisplay.value = formatRupiah(newSaldo);
            }

            jenisDebit.addEventListener('change', updateSaldo);
            jenisKredit.addEventListener('change', updateSaldo);
            nominalInput.addEventListener('input', updateSaldo);

            const kategoriSelect = document.getElementById('kategori_transaksi');
            kategoriSelect.addEventListener('change', function() {
                const kategori = this.value;
                const penerimaanCategories = [
                    'Penerimaan dari BGN',
                    'Transfer Masuk',
                    'Penerimaan Pelanggan',
                    'Penerimaan Internal',
                    'Deposit PO'
                ];

                if (penerimaanCategories.includes(kategori)) {
                    jenisKredit.checked = true;
                } else {
                    jenisDebit.checked = true;
                }
                updateSaldo();
            });

            @if (old('jenis_transaksi'))
                updateSaldo();
            @endif
        });
    </script>
@endpush
