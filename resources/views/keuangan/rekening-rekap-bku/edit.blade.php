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
                            <a href="{{ route('rekening-rekap-bku.index') }}" class="btn btn-link btn-soft-light">
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
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('rekening-rekap-bku.update', $rekeningBKU->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="form-group col-4">
                                    <label class="form-label" for="tanggal_transaksi">Tanggal <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local"
                                        class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                        id="tanggal_transaksi" name="tanggal_transaksi"
                                        value="{{ old('tanggal_transaksi', $rekeningBKU->tanggal_transaksi->format('Y-m-d\TH:i')) }}"
                                        required>
                                    @error('tanggal_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label class="form-label" for="no_bukti">No Bukti</label>
                                    <input type="text" class="form-control @error('no_bukti') is-invalid @enderror"
                                        id="no_bukti" name="no_bukti"
                                        value="{{ old('no_bukti', $rekeningBKU->no_bukti) }}">
                                    @error('no_bukti')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label class="form-label" for="link_bukti">Link Bukti</label>
                                    <input type="file" class="form-control @error('link_bukti') is-invalid @enderror"
                                        id="link_bukti" name="link_bukti" accept=".jpg,.jpeg,.png,.pdf">

                                    @if ($rekeningBKU->link_bukti)
                                        <small class="text-success d-block mt-1">
                                            File saat ini:
                                            <a href="{{ Storage::disk('uploads')->url($rekeningBKU->link_bukti) }}" target="_blank">Lihat
                                                Bukti</a>
                                        </small>
                                    @endif

                                    <small class="text-muted">Max: 10MB (jpg, jpeg, png, pdf)</small>
                                    @error('link_bukti')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="form-group col-12">
                                    <label class="form-label" for="transaction_id">Transaksi PO (Opsional)</label>
                                    <select class="form-select @error('transaction_id') is-invalid @enderror"
                                        id="transaction_id" name="transaction_id">
                                        <option value="">-- Pilih Transaksi PO --</option>
                                        @foreach ($transactions as $trans)
                                            <option value="{{ $trans->id }}" data-amount="{{ $trans->amount }}"
                                                data-supplier="{{ $trans->order?->supplier->nama }}"
                                                data-order="{{ $trans->order?->order_number }}"
                                                {{ old('transaction_id', $rekeningBKU->transaction_id) == $trans->id ? 'selected' : '' }}>
                                                PO: {{ $trans->order?->order_number }} -
                                                {{ $trans->order?->supplier->nama }} -
                                                Rp {{ number_format($trans->amount, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="form-group col-4">
                                    <label class="form-label" for="jenis_bahan">Jenis Bahan</label>
                                    <select class="form-select @error('jenis_bahan') is-invalid @enderror" id="jenis_bahan"
                                        name="jenis_bahan">
                                        <option value="">-- Pilih Jenis Bahan --</option>
                                        @foreach ($jenisBahanOptions as $option)
                                            <option value="{{ $option }}"
                                                {{ old('jenis_bahan', $rekeningBKU->jenis_bahan) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_bahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label class="form-label" for="nama_bahan">Nama Bahan</label>
                                    <select class="form-select @error('nama_bahan') is-invalid @enderror" id="nama_bahan"
                                        name="nama_bahan">
                                        <option value="">-- Pilih Nama Bahan --</option>

                                        <optgroup label="Bahan Baku">
                                            @foreach ($bahanbakus as $bahan)
                                                <option value="{{ $bahan->nama }}" data-satuan="{{ $bahan->satuan }}"
                                                    data-type="bahan_baku"
                                                    {{ old('nama_bahan', $rekeningBKU->nama_bahan) == $bahan->nama ? 'selected' : '' }}>
                                                    {{ $bahan->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        <optgroup label="Bahan Operasional">
                                            @foreach ($bahanoperasionals as $bahan)
                                                <option value="{{ $bahan->nama }}" data-satuan="{{ $bahan->satuan }}"
                                                    data-type="bahan_operasional"
                                                    {{ old('nama_bahan', $rekeningBKU->nama_bahan) == $bahan->nama ? 'selected' : '' }}>
                                                    {{ $bahan->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    @error('nama_bahan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label class="form-label" for="satuan">Satuan</label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                        id="satuan" name="satuan" value="{{ old('satuan', $rekeningBKU->satuan) }}">
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="form-group col-6">
                                    <label class="form-label" for="kuantitas">Kuantitas</label>
                                    <input type="number" class="form-control @error('kuantitas') is-invalid @enderror"
                                        id="kuantitas" name="kuantitas"
                                        value="{{ old('kuantitas', $rekeningBKU->kuantitas) }}" min="1">
                                    @error('kuantitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label" for="supplier">Supplier</label>
                                    <select class="form-select @error('supplier') is-invalid @enderror" id="supplier"
                                        name="supplier">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $sup)
                                            <option value="{{ $sup->nama }}"
                                                {{ old('supplier', $rekeningBKU->supplier) == $sup->nama ? 'selected' : '' }}>
                                                {{ $sup->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="form-group col-6">
                                    <label class="form-label">Jenis Transaksi <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi"
                                                id="jenis_debit" value="debit"
                                                {{ old('jenis_transaksi', $rekeningBKU->kredit > 0 ? 'debit' : 'kredit') == 'debit' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_debit">
                                                Pengeluaran (Kredit)
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_transaksi"
                                                id="jenis_kredit" value="kredit"
                                                {{ old('jenis_transaksi', $rekeningBKU->debit > 0 ? 'kredit' : 'debit') == 'kredit' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_kredit">
                                                Pemasukan (Debit)
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label" for="uraian">Uraian <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('uraian') is-invalid @enderror"
                                        id="uraian" name="uraian" value="{{ old('uraian', $rekeningBKU->uraian) }}"
                                        required>
                                    @error('uraian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="form-group col-6">
                                    <label class="form-label" for="nominal">Nominal <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('nominal') is-invalid @enderror" id="nominal"
                                        name="nominal"
                                        value="{{ old('nominal', max($rekeningBKU->debit, $rekeningBKU->kredit)) }}"
                                        required>
                                    @error('nominal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-6">
                                    <label class="form-label">Saldo Setelah Transaksi</label>
                                    <input type="text" class="form-control bg-light" id="saldo_display"
                                        value="Rp {{ number_format($lastSaldo, 0, ',', '.') }}" readonly>
                                </div>
                            </div>

                            <input type="hidden" id="debit" name="debit"
                                value="{{ old('debit', $rekeningBKU->debit) }}">
                            <input type="hidden" id="kredit" name="kredit"
                                value="{{ old('kredit', $rekeningBKU->kredit) }}">

<div class="row mt-1">
    <div class="form-group col-6">
        <label class="form-label" for="jenis_buku_pembantu">Jenis Buku Pembantu</label>
        <select class="form-select @error('jenis_buku_pembantu') is-invalid @enderror"
                id="jenis_buku_pembantu" name="jenis_buku_pembantu">
            <option value="">-- Pilih Jenis Buku Pembantu --</option>
            @foreach ($jenisBukuPembantu as $option)
                <option value="{{ $option }}"
                    {{ old('jenis_buku_pembantu', $rekeningBKU->jenis_buku_pembantu) == $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
        @error('jenis_buku_pembantu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group col-6">
        <label class="form-label" for="sumber_dana">Sumber Dana</label>
        <select class="form-select @error('sumber_dana') is-invalid @enderror"
                id="sumber_dana" name="sumber_dana">
            <option value="">-- Pilih Sumber Dana --</option>
            @foreach ($sumberDana as $option)
                <option value="{{ $option }}"
                    {{ old('sumber_dana', $rekeningBKU->sumber_dana) == $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
        @error('sumber_dana')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('rekening-rekap-bku.index') }}"
                                    class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-success">Perbarui</button>
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

            const namaBahanSelect = document.getElementById('nama_bahan');
            const satuanInput = document.getElementById('satuan');
            const jenisDebit = document.getElementById('jenis_debit');
            const jenisKredit = document.getElementById('jenis_kredit');
            const nominalInput = document.getElementById('nominal');
            const debitInput = document.getElementById('debit');
            const kreditInput = document.getElementById('kredit');
            const saldoDisplay = document.getElementById('saldo_display');
            const lastSaldo = {{ $lastSaldo }};
            const transactionSelect = document.getElementById('transaction_id');
            const supplierInput = document.getElementById('supplier');
            const uraianInput = document.getElementById('uraian');

            namaBahanSelect.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                if (opt.dataset.satuan) satuanInput.value = opt.dataset.satuan;
            });

            function updateSaldo() {
                const nominal = parseFloat(nominalInput.value) || 0;
                let newSaldo = lastSaldo;

                if (jenisDebit.checked) {
                    kreditInput.value = nominal;
                    debitInput.value = 0;
                    newSaldo = lastSaldo - nominal;
                } else {
                    debitInput.value = nominal;
                    kreditInput.value = 0;
                    newSaldo = lastSaldo + nominal;
                }

                saldoDisplay.value = 'Rp ' + newSaldo.toLocaleString('id-ID');
                saldoDisplay.classList.toggle('text-danger', newSaldo < 0);
                saldoDisplay.classList.toggle('fw-bold', newSaldo < 0);
            }

            jenisDebit.addEventListener('change', updateSaldo);
            jenisKredit.addEventListener('change', updateSaldo);
            nominalInput.addEventListener('input', updateSaldo);

            transactionSelect.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];

                if (this.value) {
                    const amount = parseFloat(opt.dataset.amount);
                    const supplier = opt.dataset.supplier;
                    const order = opt.dataset.order;

                    kreditInput.value = amount;
                    debitInput.value = 0;

                    jenisDebit.checked = true;
                    jenisKredit.checked = false;

                    supplierInput.value = supplier;
                    uraianInput.value = `Pembayaran PO ${order} - ${supplier}`;

                    nominalInput.value = amount;
                    updateSaldo();
                }
            });

            updateSaldo();
        });
    </script>
@endpush
