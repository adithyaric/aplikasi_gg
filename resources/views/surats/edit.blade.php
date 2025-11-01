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

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        <a href="javascript:history.back()" class="btn btn-link btn-soft-light">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="iq-header-img">
        <img src="{{ asset('assets/images/dashboard/top-header.png') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
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
                        <h4 class="card-title">Data Laporan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('surats.update', $surat->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationDefault01">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $surat->name) }}" class="form-control" id="validationDefault01" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationDefault02">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik', $surat->nik) }}" class="form-control" id="validationDefault02" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $surat->tempat_lahir) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', $surat->tgl_lahir) }}" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jk" required>
                                    <option disabled value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki" {{ old('jk', $surat->jk) == 'laki-laki' ? 'selected' : '' }}>Laki - Laki</option>
                                    <option value="perempuan" {{ old('jk', $surat->jk) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Agama</label>
                                <select class="form-select" name="agama" required>
                                    <option disabled value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama', $surat->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen / Protestan" {{ old('agama', $surat->agama) == 'Kristen / Protestan' ? 'selected' : '' }}>Kristen / Protestan</option>
                                    <option value="Katholik" {{ old('agama', $surat->agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                    <option value="Hindu" {{ old('agama', $surat->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama', $surat->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama', $surat->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    <option value="Kepercayaan" {{ old('agama', $surat->agama) == 'Kepercayaan' ? 'selected' : '' }}>Kepercayaan</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kewarganegaraan</label>
                                <select class="form-select" name="warganegara" required>
                                    <option disabled value="">Pilih Kewarganegaraan</option>
                                    <option value="WNI" {{ old('warganegara', $surat->warganegara) == 'WNI' ? 'selected' : '' }}>WNI</option>
                                    <option value="WNA" {{ old('warganegara', $surat->warganegara) == 'WNA' ? 'selected' : '' }}>WNA</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $surat->pekerjaan) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp', $surat->no_telp) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat', $surat->alamat) }}" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kehilangan</label>
                                <select name="category_id" class="form-select select2-search--inline" required>
                                    <option disabled value="">Pilih Jenis Kehilangan</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $surat->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Kejadian Perkara</label>
                                <input type="datetime-local" name="tgl_kejadian"
                                    value="{{ old('tgl_kejadian', \Carbon\Carbon::parse($surat->tgl_kejadian)->format('Y-m-d\TH:i')) }}"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Penandatangan</label>
                                <select name="ttd_id" class="form-select select2-search--inline" required>
                                    <option disabled value="">Pilih Penandatangan</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('ttd_id', $surat->ttd_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->nrp }} - {{ $user->pangkat }} - {{ $user->name }} - {{ $user->jabatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi Kejadian Perkara</label>
                                <textarea class="form-control" name="desc" rows="5" required>{{ old('desc', $surat->desc) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-warning" type="submit">Perbarui Laporan</button>
                            <a href="{{ route('surats.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
