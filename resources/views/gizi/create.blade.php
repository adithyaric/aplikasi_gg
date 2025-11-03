{{-- resources/views/gizi/create.blade.php --}}
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
                            <a href="{{ route('gizi.index') }}" class="btn btn-link btn-soft-light">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title fw-bold">Formulir Database Gizi</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gizi.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Basic Information Section -->
                                <div class="col-12 mb-0">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-primary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h6>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row g-1">
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold mb-0">Nomor Pangan <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="nomor_pangan"
                                                        class="form-control form-control-sm @error('nomor_pangan') is-invalid @enderror"
                                                        placeholder="P001" value="{{ old('nomor_pangan') }}" required>
                                                    @error('nomor_pangan')
                                                        <div class="invalid-feedback small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold mb-0">Bahan Baku <span class="text-danger">*</span></label>
                                                    <select name="bahan_baku_id" id="bahan_baku_id"
                                                        class="form-select form-select-sm @error('bahan_baku_id') is-invalid @enderror" required>
                                                        <option value="">-- Pilih Bahan Baku --</option>
                                                        @foreach ($bahanbakus as $bahan)
                                                            <option value="{{ $bahan->id }}" {{ old('bahan_baku_id') == $bahan->id ? 'selected' : '' }}>
                                                                {{ $bahan->nama }} ({{ $bahan->kelompok }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('bahan_baku_id')
                                                        <div class="invalid-feedback small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                {{-- <div class="col-md-4"> --}}
                                                    {{-- <label class="form-label small fw-semibold mb-0">Nama Bahan Makanan --}}
                                                        {{-- <span class="text-danger">*</span></label> --}}
                                                    {{-- <input type="text" name="rincian_bahan_makanan" --}}
                                                        {{-- class="form-control form-control-sm @error('rincian_bahan_makanan') is-invalid @enderror" --}}
                                                        {{-- placeholder="Beras Merah" value="{{ old('rincian_bahan_makanan') }}" --}}
                                                        {{-- required> --}}
                                                    {{-- @error('rincian_bahan_makanan') --}}
                                                        {{-- <div class="invalid-feedback small">{{ $message }}</div> --}}
                                                    {{-- @enderror --}}
                                                {{-- </div> --}}
                                                <div class="col-md-4">
                                                    <label class="form-label small fw-semibold mb-0">BDD (%) <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" name="bdd"
                                                        class="form-control form-control-sm @error('bdd') is-invalid @enderror"
                                                        placeholder="100" value="{{ old('bdd') }}" required>
                                                    <small class="form-text text-muted small">Bagian yang dapat
                                                        dimakan</small>
                                                    @error('bdd')
                                                        <div class="invalid-feedback small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Makronutrien Section -->
                                <div class="col-12 mb-0">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-success text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Makronutrien</h6>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row g-1">
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Air (g)</label>
                                                    <input type="number" step="0.01" name="air"
                                                        class="form-control form-control-sm" value="{{ old('air') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Energi (Kal)</label>
                                                    <input type="number" step="0.01" name="energi"
                                                        class="form-control form-control-sm" value="{{ old('energi') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Protein (g)</label>
                                                    <input type="number" step="0.01" name="protein"
                                                        class="form-control form-control-sm" value="{{ old('protein') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Lemak (g)</label>
                                                    <input type="number" step="0.01" name="lemak"
                                                        class="form-control form-control-sm" value="{{ old('lemak') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Karbohidrat
                                                        (g)</label>
                                                    <input type="number" step="0.01" name="karbohidrat"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('karbohidrat') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Serat (g)</label>
                                                    <input type="number" step="0.01" name="serat"
                                                        class="form-control form-control-sm" value="{{ old('serat') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mineral Section -->
                                <div class="col-12 mb-0">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-info text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-atom me-2"></i>Mineral</h6>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row g-1">
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Abu (g)</label>
                                                    <input type="number" step="0.01" name="abu"
                                                        class="form-control form-control-sm" value="{{ old('abu') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Kalsium (mg)</label>
                                                    <input type="number" step="0.01" name="kalsium"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('kalsium') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Fosfor (mg)</label>
                                                    <input type="number" step="0.01" name="fosfor"
                                                        class="form-control form-control-sm" value="{{ old('fosfor') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Kolesterol
                                                        (mg)</label>
                                                    <input type="number" step="0.01" name="koles"
                                                        class="form-control form-control-sm" value="{{ old('koles') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Besi (mg)</label>
                                                    <input type="number" step="0.01" name="besi"
                                                        class="form-control form-control-sm" value="{{ old('besi') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Natrium (mg)</label>
                                                    <input type="number" step="0.01" name="natrium"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('natrium') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Nutrients Section -->
                                <div class="col-12 mb-0">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-warning text-dark py-2">
                                            <h6 class="mb-0"><i class="fas fa-flask me-2"></i>Nutrien Tambahan</h6>
                                        </div>
                                        <div class="card-body p-1">
                                            <div class="row g-1 mb-2">
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Kalium (mg)</label>
                                                    <input type="number" step="0.01" name="kalium"
                                                        class="form-control form-control-sm" value="{{ old('kalium') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Tembaga (mg)</label>
                                                    <input type="number" step="0.01" name="tembaga"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('tembaga') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Retinol (mcg)</label>
                                                    <input type="number" step="0.01" name="retinol"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('retinol') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Beta-Karoten
                                                        (mcg)</label>
                                                    <input type="number" step="0.01" name="b_kar"
                                                        class="form-control form-control-sm" value="{{ old('b_kar') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Karoten Total
                                                        (mcg)</label>
                                                    <input type="number" step="0.01" name="kar_total"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('kar_total') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Thiamin (mg)</label>
                                                    <input type="number" step="0.01" name="thiamin"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('thiamin') }}">
                                                </div>
                                            </div>
                                            <div class="row g-1">
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Riboflavin
                                                        (mg)</label>
                                                    <input type="number" step="0.01" name="riboflavin"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('riboflavin') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Niasin (mg)</label>
                                                    <input type="number" step="0.01" name="niasin"
                                                        class="form-control form-control-sm" value="{{ old('niasin') }}">
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <label class="form-label small fw-semibold mb-0">Vitamin C (mg)</label>
                                                    <input type="number" step="0.01" name="vitamin_c"
                                                        class="form-control form-control-sm"
                                                        value="{{ old('vitamin_c') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('gizi.index') }}" class="btn btn-danger">Cancel</a>
                                    </div>
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
{{-- Add Select2 CSS in head or after styles --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

{{-- Add Select2 JS before closing body or in scripts section --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('#bahan_baku_id').select2({
        placeholder: '-- Pilih Bahan Baku --',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush