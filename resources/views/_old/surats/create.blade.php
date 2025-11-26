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
                <form action="{{ route('surats.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="auth()->user()->id">
                        <div class="row">
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault01">Nama Lengkap</label>
                              <input type="text" name="name" placeholder="Nama Lengkap" class="form-control" id="validationDefault01" required>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault02">NIK</label>
                              <input type="text" name="nik" placeholder="NIK" class="form-control" id="validationDefault02" required>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault02">Tempat Lahir</label>
                              <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="form-control" id="validationDefault02" required>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault02">Tanggal Lahir</label>
                              <input type="date" name="tgl_lahir" placeholder="Tanggal Lahir" class="form-control" id="validationDefault02" required>
                           </div>
                           <div class="col-md-4 mb-3">
                              <label class="form-label" for="validationDefault04">Jenis Kelamin</label>
                              <select class="form-select" name="jk" id="validationDefault04" required>
                                 <option selected disabled value="">Pilih Jenis Kelamin</option>
                                 <option value="laki-laki">Laki - Laki</option>
                                 <option value="perempuan">Perempuan</option>
                              </select>
                           </div>
                           <div class="col-md-4 mb-3">
                              <label class="form-label" for="validationDefault04">Agama</label>
                              <select class="form-select" name="agama" id="validationDefault04" required>
                                 <option selected disabled value="">Pilih Agama</option>
                                 <option value="Islam">Islam</option>
                                 <option value="Kristen / Protestan">Kristen / Protestan</option>
                                 <option value="Katholik">Katholik</option>
                                 <option value="Hindu">Hindu</option>
                                 <option value="Buddha">Buddha</option>
                                 <option value="Konghucu">Konghucu</option>
                                 <option value="Kepercayaan">Kepercayaan</option>
                              </select>
                           </div>
                           <div class="col-md-4 mb-3">
                              <label class="form-label" for="validationDefault04">Kewarganegaraan</label>
                              <select class="form-select" name="warganegara" id="validationDefault04" required>
                                 <option selected disabled value="">Pilih Kewarganegaraan</option>
                                 <option value="WNI">WNI</option>
                                 <option value="WNA">WNA</option>
                              </select>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault05">Pekerjaan</label>
                              <input type="text" name="pekerjaan" placeholder="Pekerjaan" class="form-control" id="validationDefault05" required>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault05">No. Telepon</label>
                              <input type="text" name="no_telp" placeholder="No. Telepon" class="form-control" id="validationDefault05" required>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault05">Alamat</label>
                              <input type="text" name="alamat" placeholder="Alamat" class="form-control" id="validationDefault05" required>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault04">Jenis Kehilangan</label>
                              <select name="category_id" class="form-select select2-search--inline" id="validationDefault04" required>
                                 <option selected disabled value="">Pilih Jenis Kehilangan</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                              </select>
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label" for="validationDefault02">Tanggal Kejadian Perkara</label>
                              <input type="datetime-local" name="tgl_kejadian" class="form-control" id="validationDefault02" required>
                           </div>
                           <div class="col-md-6 mb-3">
                               <label class="form-label" for="validationDefault04">Penandatangan</label>
                               <select name="ttd_id" class="form-select select2-search--inline" id="validationDefault04" required>
                                   <option selected disabled value="">Pilih Penandatangan</option>
                                   @foreach ($users as $user)
                                   <option value="{{ $user->id }}">{{ $user->nrp }} - {{ $user->pangkat }} - {{ $user->name }} - {{ $user->jabatan }}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                               <label class="form-label" for="validationDefault02">Deskripsi Kejadian Perkara</label>
                               <textarea class="form-control" name="desc" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>

                        </div>
                        <div class="form-group">
                           <button class="btn btn-primary" type="submit">Terbitkan Laporan</button>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
