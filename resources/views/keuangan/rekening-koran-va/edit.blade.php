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
                            <h4 class="card-title">Edit Rekening Koran VA</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('rekening-koran-va.update', $rekeningKoran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6">
                                    <label class="form-label" for="tanggal_transaksi">Tanggal Transaksi</label>
                                    <input type="datetime-local"
                                        class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                        id="tanggal_transaksi" name="tanggal_transaksi"
                                        value="{{ old('tanggal_transaksi', $rekeningKoran->tanggal_transaksi->format('Y-m-d\TH:i')) }}"
                                        required>
                                    @error('tanggal_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label" for="minggu">Minggu</label>
                                    <select class="form-select shadow-none @error('minggu') is-invalid @enderror"
                                        id="minggu" name="minggu">
                                        <option selected disabled>Pilih Minggu</option>
                                        @for ($i = 1; $i <= 4; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('minggu', $rekeningKoran->minggu) == $i ? 'selected' : '' }}>
                                                Minggu {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('minggu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col-4">
                                    <label class="form-label" for="ref">Ref</label>
                                    <select class="form-select shadow-none @error('ref') is-invalid @enderror"
                                        id="ref" name="ref" required>
                                        <option selected disabled>Pilih Referensi</option>
                                        @foreach (['BRIVA', 'CMSX', 'KLIKBCA', 'TRANSFER', 'SKN', 'LLG', 'BI-RTGS', 'BIAYA', 'PAJAK', 'PEMBAYARAN'] as $ref)
                                            <option value="{{ $ref }}"
                                                {{ old('ref', $rekeningKoran->ref) == $ref ? 'selected' : '' }}>
                                                {{ $ref }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ref')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label class="form-label" for="kategori_transaksi">Kategori Transaksi</label>
                                    <select
                                        class="form-select shadow-none @error('kategori_transaksi') is-invalid @enderror"
                                        id="kategori_transaksi" name="kategori_transaksi" required>
                                        <option selected disabled>Pilih Kategori</option>
                                        @foreach (['Penerimaan dari BGN', 'Transfer Masuk', 'Transfer Keluar', 'Biaya Admin', 'Penerimaan Pelanggan', 'Pembayaran Vendor', 'Biaya Operasional', 'Biaya Bank', 'Transfer Internal', 'Pembayaran Pajak', 'Pembayaran Pinjaman', 'Pembayaran Hutang', 'Penerimaan Internal', 'Deposit PO'] as $kategori)
                                            <option value="{{ $kategori }}"
                                                {{ old('kategori_transaksi', $rekeningKoran->kategori_transaksi) == $kategori ? 'selected' : '' }}>
                                                {{ $kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label class="form-label">Jenis Transaksi</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi"
                                                id="jenis_debit" value="debit"
                                                {{ old('jenis_transaksi', $rekeningKoran->debit > 0 ? 'debit' : 'kredit') == 'debit' ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="jenis_debit">Debit</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi"
                                                id="jenis_kredit" value="kredit"
                                                {{ old('jenis_transaksi', $rekeningKoran->kredit > 0 ? 'kredit' : 'debit') == 'kredit' ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="jenis_kredit">Kredit</label>
                                        </div>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="debit" name="debit"
                                        value="{{ old('debit', $rekeningKoran->debit) }}" hidden>
                                    <input type="number" step="0.01" class="form-control" id="kredit" name="kredit"
                                        value="{{ old('kredit', $rekeningKoran->kredit) }}" hidden>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col-12">
                                    <label class="form-label" for="nominal">Nominal</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('nominal') is-invalid @enderror" id="nominal"
                                        name="nominal"
                                        value="{{ old('nominal', max($rekeningKoran->debit, $rekeningKoran->kredit)) }}"
                                        placeholder="0" required>
                                    @error('nominal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mt-1">
                                <label class="form-label" for="uraian">Uraian</label>
                                <textarea class="form-control @error('uraian') is-invalid @enderror" id="uraian" name="uraian" rows="2"
                                    placeholder="Masukkan uraian transaksi" required>{{ old('uraian', $rekeningKoran->uraian) }}</textarea>
                                @error('uraian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('rekening-koran-va.index') }}">
                                    <button type="button" class="btn btn-secondary me-2">Batal</button>
                                </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const jenisDebit = document.getElementById('jenis_debit');
            const jenisKredit = document.getElementById('jenis_kredit');
            const debitInput = document.getElementById('debit');
            const kreditInput = document.getElementById('kredit');
            const nominalInput = document.getElementById('nominal');

            function updateValues() {
                const nominal = parseFloat(nominalInput.value) || 0;

                if (jenisDebit.checked) {
                    debitInput.value = nominal;
                    kreditInput.value = 0;
                } else if (jenisKredit.checked) {
                    kreditInput.value = nominal;
                    debitInput.value = 0;
                }
            }

            jenisDebit.addEventListener('change', updateValues);
            jenisKredit.addEventListener('change', updateValues);
            nominalInput.addEventListener('input', updateValues);

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
                updateValues();
            });
        });
    </script>
@endpush
