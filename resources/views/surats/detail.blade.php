@extends('layouts.master')
@section('header')
<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $title }}</h3>
                        <p>SPKT POLRES PACITAN</p>
                    </div>
                    <div>
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <a href="{{ route('surats.index') }}" class="btn btn-link btn-soft-light">
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
                        <h4 class="card-title">Detail Laporan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Registrasi</label>
                                <input type="text" value="{{ $surat->noreg }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Surat</label>
                                <input type="text" value="{{ $no_surat }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" value="{{ $surat->name }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" value="{{ $surat->nik }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" value="{{ $surat->tempat_lahir }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse($surat->tgl_lahir)->translatedFormat('d M Y') }}"
                                    class="form-control" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <input type="text" value="{{ ucfirst($surat->jk) }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Agama</label>
                                <input type="text" value="{{ $surat->agama }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kewarganegaraan</label>
                                <input type="text" value="{{ $surat->warganegara }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" value="{{ $surat->pekerjaan }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" value="{{ $surat->no_telp }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" value="{{ $surat->alamat }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kehilangan</label>
                                <input type="text" value="{{ $surat->category->name ?? '-' }}" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Kejadian Perkara</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse($surat->tgl_kejadian)->translatedFormat('d M Y H:i') }}"
                                    class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Penandatangan</label>
                                <input type="text"
                                    value="{{ $surat->ttd->nrp ?? '-' }} - {{ $surat->ttd->pangkat ?? '-' }} - {{ $surat->ttd->name ?? '-' }} - {{ $surat->ttd->jabatan ?? '-' }}"
                                    class="form-control" readonly>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi Kejadian Perkara</label>
                                <textarea class="form-control" rows="5" readonly>{{ $surat->desc }}</textarea>
                            </div>

                            @if ($surat->ttd && $surat->ttd->ttd)
                            <div class="col-md-12 mb-3 text-center">
                                <label class="form-label">Tanda Tangan</label>
                                <div>
                                    <img src="{{ asset('storage/' . $surat->ttd->ttd) }}" alt="Tanda Tangan"
                                        class="img-fluid" style="max-height: 120px;">
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group text-end">
                            <a href="{{ route('surats.cetak', $surat->id) }}" class="btn btn-secondary">Cetak PDF</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
