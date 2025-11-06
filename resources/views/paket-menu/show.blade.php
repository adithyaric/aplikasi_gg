@extends('layouts.master')

@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>{{ $title }}</h3>
                            <p>{{ $paketmenu->nama }}</p>
                        </div>
                        <div>
                            <a href="{{ route('paketmenu.edit', $paketmenu->id) }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7476 20.4428H21.0002" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.78 3.79479C13.5557 2.86779 14.95 2.73186 15.8962 3.49173C15.9485 3.53296 17.6295 4.83879 17.6295 4.83879C18.669 5.46719 18.992 6.80311 18.3494 7.82259C18.3153 7.87718 8.81195 19.7645 8.81195 19.7645C8.49578 20.1589 8.01583 20.3918 7.50291 20.3973L3.86353 20.443L3.04353 16.9723C2.92866 16.4843 3.04353 15.9718 3.3597 15.5773L12.78 3.79479Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M11.021 6.00098L16.4732 10.1881" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                Edit Paket
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
                            <h4 class="card-title fw-bold">{{ $paketmenu->nama }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $totalKaloriPaket = 0;
                        @endphp

                        @foreach ($paketmenu->menus as $index => $menu)
                            <div class="menu-section mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-bookmark-fill"></i> {{ $menu->nama }}
                                </h5>

                                @if ($menu->bahanBakusWithPaketData->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Bahan Makanan</th>
                                                    <th>Kelompok</th>
                                                    <th>Berat Bersih (gram)</th>
                                                    <th>Kalori (kkal)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalKaloriMenu = 0;
                                                @endphp
                                                @foreach ($menu->bahanBakusWithPaketData as $bahan)
                                                    @php
                                                        $totalKaloriMenu += $bahan->energi;
                                                        $totalKaloriPaket += $bahan->energi;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $bahan->nama }}</td>
                                                        <td>
                                                            <span class="badge bg-info">{{ $bahan->kelompok }}</span>
                                                        </td>
                                                        <td>{{ number_format($bahan->berat_bersih, 2) }} gram</td>
                                                        <td>{{ number_format($bahan->energi, 2) }} kkal</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <th colspan="4" class="text-end">Total Kalori Menu:</th>
                                                    <th>
                                                        <span class="text-primary">
                                                            {{ number_format($totalKaloriMenu, 2) }} kkal
                                                        </span>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Menu ini belum memiliki data bahan baku
                                    </div>
                                @endif
                            </div>

                            @if (!$loop->last)
                                <hr class="my-4">
                            @endif
                        @endforeach

                        <!-- Total Kalori Paket -->
                        <div class="alert alert-success mt-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-0">
                                        <i class="bi bi-calculator"></i> Total Kalori Paket Menu
                                    </h5>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h4 class="mb-0 fw-bold">
                                        {{ number_format($totalKaloriPaket, 2) }} kkal
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('paketmenu.edit', $paketmenu->id) }}" class="btn btn-success">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('paketmenu.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
