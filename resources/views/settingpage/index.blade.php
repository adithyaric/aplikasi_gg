@extends('layouts.master')
@section('header')
    <!-- Nav Header Component Start -->
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>DAPUR BERGIZI</h3>
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
    <div class="content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('settingpage.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">

                                <div class="col-12">
                                    <label class="form-label">Nama SPPG</label>
                                    <input type="text" name="nama_sppg" class="form-control"
                                        value="{{ $setting->nama_sppg ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control"
                                        value="{{ $setting->kelurahan ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control"
                                        value="{{ $setting->kecamatan ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Kabupaten/Kota</label>
                                    <input type="text" name="kabupaten_kota" class="form-control"
                                        value="{{ $setting->kabupaten_kota ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control"
                                        value="{{ $setting->provinsi ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Nama SPPI</label>
                                    <input type="text" name="nama_sppi" class="form-control"
                                        value="{{ $setting->nama_sppi ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Ahli Gizi</label>
                                    <input type="text" name="ahli_gizi" class="form-control"
                                        value="{{ $setting->ahli_gizi ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Akuntan SPPG</label>
                                    <input type="text" name="akuntan_sppg" class="form-control"
                                        value="{{ $setting->akuntan_sppg ?? '' }}">
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Asisten Lapangan</label>
                                    <input type="text" name="asisten_lapangan" class="form-control"
                                        value="{{ $setting->asisten_lapangan ?? '' }}">
                                </div>

                            </div>

                            <button class="btn btn-primary mt-4 px-4">Simpan</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
