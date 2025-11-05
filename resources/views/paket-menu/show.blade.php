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
                            <a href="{{ route('paketmenu.index') }}" class="btn btn-link btn-soft-light">
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
                            <h4 class="card-title">Detail Paket Menu</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label fw-bold">Paket Menu</label>
                                <p class="form-control-plaintext">{{ $paketmenu->nama }}</p>
                            </div>
                        </div>
                        <hr class="hr-horizontal" />

                        <!-- Container Menu -->
                        <div id="menu-container">
                            @foreach ($paketmenu->menus as $menu)
                                <div class="menu-item border p-3 mb-2">
                                    <!-- Bagian Nama Menu -->
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <label class="fw-bold">Nama Menu</label>
                                            <p class="form-control-plaintext">{{ $menu->nama }}</p>
                                        </div>
                                    </div>

                                    <!-- Daftar Bahan -->
                                    <div class="bahan-list">
                                        <div class="row mb-2">
                                            <div class="col-md-3 offset-md-3">
                                                <label class="fw-bold">Bahan Makanan</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="fw-bold">Berat Bersih (gram)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="fw-bold">Kalori</label>
                                            </div>
                                        </div>

                                        @foreach ($menu->bahanBakus as $bahan)
                                            <div class="row mb-2 align-items-center bahan-item">
                                                <div class="col-md-3 offset-md-3">
                                                    <p class="form-control-plaintext">{{ $bahan->nama }}</p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p class="form-control-plaintext">{{ $bahan->pivot->berat_bersih }}</p>
                                                </div>
                                                <div class="col-md-2">
                                                    <p class="form-control-plaintext">{{ $bahan->pivot->energi }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total Kalori -->
                        <hr class="hr-horizontal" />
                        <div class="text-end">
                            @php
                                $totalKalori = 0;
                                foreach ($paketmenu->menus as $menu) {
                                    foreach ($menu->bahanBakus as $bahan) {
                                        $totalKalori += $bahan->pivot->energi;
                                    }
                                }
                            @endphp
                            <h5>
                                Total Kalori:
                                <span id="totalKalori"
                                    class="fw-bold text-primary">{{ number_format($totalKalori, 2) }}</span>
                                kkal
                            </h5>
                        </div>

                        <!-- Tombol Kembali -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('paketmenu.index') }}" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
