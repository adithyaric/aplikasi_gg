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
    <!-- CONTAIN DASHBOARD -->
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <!-- UP SECTOR LAYER -->
            <div class="col-md-12 col-lg-12">
                <!-- ðŸ”¹ ROW 1: TOTAL -->
                <div class="row mb-2">
                    <!-- Total Pemasukan -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="700">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-success-subtle rounded p-3 me-3">
                                    <svg class="icon-24" xmlns="http://www.w3.org/2000/svg" width="24"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 fw-semibold">Total Pemasukan</p>
                                    <h5 class="counter mb-0">Rp 560.000.000</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pengeluaran -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body d-flex align-items-center">
                                <div class="border rounded p-3 bg-warning-subtle me-3">
                                    <svg class="icon-24" width="24" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12.3 8.93L9.88 6.5H15.5V10H17V5H9.88L12.3 2.57L11.24 1.5L7 5.75L11.24 10L12.3 8.93M12 14A3 3 0 1 0 15 17A3 3 0 0 0 12 14M3 11V23H21V11M19 19A2 2 0 0 0 17 21H7A2 2 0 0 0 5 19V15A2 2 0 0 0 7 13H17A2 2 0 0 0 19 15Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 fw-semibold">Total Pengeluaran</p>
                                    <h5 class="counter mb-0">Rp 12.500.000</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Seluruh Porsi -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="900">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded p-3 bg-success-subtle me-3">
                                    <svg class="icon-24" width="24px" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12 3C7.58 3 4 4.79 4 7V17C4 19.21 7.59 21 12 21S20 19.21 20 17V7C20 4.79 16.42 3 12 3M18 17C18 17.5 15.87 19 12 19S6 17.5 6 17V14.77C7.61 15.55 9.72 16 12 16S16.39 15.55 18 14.77V17M18 12.45C16.7 13.4 14.42 14 12 14C9.58 14 7.3 13.4 6 12.45V9.64C7.47 10.47 9.61 11 12 11C14.39 11 16.53 10.47 18 9.64V12.45M12 9C8.13 9 6 7.5 6 7S8.13 5 12 5C15.87 5 18 6.5 18 7S15.87 9 12 9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 fw-semibold">Total Seluruh Porsi</p>
                                    <h5 class="counter mb-0">122.400</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ðŸ”¹ ROW 2: 2 MINGGUAN -->
                <div class="row mb-3">
                    <!-- Pemasukan 2 Mingguan -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="1000">
                            <div class="card-body d-flex align-items-center">
                                <div class="bg-primary-subtle rounded p-3 me-3">
                                    <svg class="icon-24" width="24px" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M13,2.05C18.05,2.55 22,6.82 22,12C22,13.45 21.68,14.83 21.12,16.07L18.5,14.54C18.82,13.75 19,12.9 19,12C19,8.47 16.39,5.57 13,5.08V2.05M12,19C14.21,19 16.17,18 17.45,16.38L20.05,17.91C18.23,20.39 15.3,22 12,22C6.47,22 2,17.5 2,12C2,6.81 5.94,2.55 11,2.05V5.08C7.61,5.57 5,8.47 5,12A7,7 0 0,0 12,19Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 fw-semibold">Pemasukan 2 Mingguan</p>
                                    <h5 class="counter mb-0">Rp 280.000.000</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengeluaran 2 Mingguan -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="1100">
                            <div class="card-body d-flex align-items-center">
                                <div class="border rounded p-3 bg-danger-subtle me-3">
                                    <svg class="icon-24" width="24" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M19.07,4.93L17.66,6.34C19.1,7.79 20,9.79 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12C4,7.92 7.05,4.56 11,4.07V6.09C8.16,6.57 6,9.03 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12C18,10.34 17.33,8.84 16.24,7.76L14.83,9.17C15.55,9.9 16,10.9 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12C8,10.14 9.28,8.59 11,8.14V10.28Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 fw-semibold">Pengeluaran 2 Mingguan</p>
                                    <h5 class="counter mb-0">Rp 92.500.000</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Porsi 2 Mingguan -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="1200">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded p-3 bg-warning-subtle me-3">
                                    <svg class="icon-24" xmlns="http://www.w3.org/2000/svg" width="24px"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-2 fw-semibold">Total Porsi 2 Mingguan</p>
                                    <h5 class="counter mb-0">11.200</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LEFT SECTOR LAYER -->
            <div class="col-md-12 col-lg-8">
                <div class="row">
                    <!-- FILTER GLOBAL TABS -->
                    <div class="d-flex justify-content-center mb-3" data-aos="fade-up" data-aos-delay="800">
                        <ul class="nav nav-pills" id="filterTabs">
                            <li class="nav-item">
                                <button class="nav-link active global-filter" data-value="week">
                                    This Week
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link global-filter" data-value="month">
                                    This Month
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link global-filter" data-value="year">
                                    This Year
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Pemasukan Pengeluaran -->
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="fw-bold mb-0">Rp 560.000.000</h4>
                                    <p class="mb-0">Pemasukan dan Pengeluaran</p>
                                </div>
                                <div class="d-flex align-items-center align-self-center">
                                    <div class="d-flex align-items-center text-primary">
                                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor">
                                                </circle>
                                            </g>
                                        </svg>
                                        <div class="ms-2">
                                            <span class="text-gray">Pemasukan</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-3 text-info">
                                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor">
                                                </circle>
                                            </g>
                                        </svg>
                                        <div class="ms-2">
                                            <span class="text-gray">Pengeluaran</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="d-main" class="d-main"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Anggaran Realisasi -->
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="1000">
                            <div class="flex-wrap card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h5 class="fw-bold mb-0">Anggaran & Realisasi</h5>
                                </div>
                                <div class="d-flex align-items-center align-self-center">
                                    <div class="d-flex align-items-center text-primary">
                                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor">
                                                </circle>
                                            </g>
                                        </svg>
                                        <div class="ms-2">
                                            <span class="text-gray">Anggaran</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-3 text-info">
                                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor">
                                                </circle>
                                            </g>
                                        </svg>
                                        <div class="ms-2">
                                            <span class="text-gray">Realisasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="d-activity" class="d-activity"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Kinerja Distribusi -->
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h5 class="fw-bold mb-0">Kinerja Distribusi</h5>
                                    <p class="mb-0">(14 Hari Terakhir)</p>
                                </div>
                                <div class="d-flex align-items-center align-self-center">
                                    <div class="d-flex align-items-center text-danger">
                                        <svg class="icon-12" xmlns="http://www.w3.org/2000/svg" width="12"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                                <circle cx="12" cy="12" r="8" fill="currentColor">
                                                </circle>
                                            </g>
                                        </svg>
                                        <div class="ms-2">
                                            <span class="text-gray">Porsi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="d-main2" class="d-main"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Rekonsiliasi -->
                    <div class="col-md-12">
                        <div class="overflow-hidden card" data-aos="fade-up" data-aos-delay="600">
                            <div class="flex-wrap card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h5 class="mb-2 fw-bold mb-0">Rekonsiliasi</h5>
                                    <p class="mb-0">
                                        <svg class="me-2 text-primary icon-24" width="24" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                        </svg>
                                        Rekap Status Rekonsiliasi Terbaru
                                    </p>
                                </div>
                            </div>

                            <div class="p-0 card-body">
                                <div class="mt-4 table-responsive">
                                    <table id="basic-table" class="table mb-0 table-striped text-center"
                                        role="grid">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jumlah Transaksi</th>
                                                <th>Selisih</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Contoh data (bisa nanti diambil dari DB) -->
                                            <tr>
                                                <td>24 April 2025</td>
                                                <td>2</td>
                                                <td>Rp 0</td>
                                                <td><span class="badge bg-success">Match</span></td>
                                            </tr>
                                            <tr>
                                                <td>8 Mei 2025</td>
                                                <td>1</td>
                                                <td>Rp 0</td>
                                                <td><span class="badge bg-success">Match</span></td>
                                            </tr>
                                            <tr>
                                                <td>19 Mei 2025</td>
                                                <td>77</td>
                                                <td>Rp -141.808.000</td>
                                                <td>
                                                    <span class="badge bg-danger">No Match</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>22 Mei 2025</td>
                                                <td>28</td>
                                                <td>Rp 315.099.500</td>
                                                <td>
                                                    <span class="badge bg-danger">No Match</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5 Juni 2025</td>
                                                <td>8</td>
                                                <td>Rp 401.955.000</td>
                                                <td>
                                                    <span class="badge bg-danger">No Match</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SECTOR LAYER -->
            <div class="col-md-12 col-lg-4">
                <div class="row">
                    <!-- Saldo -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card credit-card-widget" data-aos="fade-up" data-aos-delay="900">
                            <div class="card-body">
                                <div class="mb-2">
                                    <div class="flex-wrap d-flex justify-content-between">
                                        <h3 class="mb-2 fw-bold mb-0">Rp 1.685.000.000,00</h3>
                                    </div>
                                    <p class="text-info">Saldo Saat Ini</p>
                                </div>
                                <div class="grid-cols-2 d-grid gap-card">
                                    <button class="p-2 btn btn-primary text-uppercase"
                                        onclick="window.location.href='./finance/rekap.bku.html'">
                                        Rekap BKU
                                    </button>
                                    <button class="p-2 btn btn-secondary text-uppercase"
                                        onclick="window.location.href='./finance/rekonsiliasi.html'">
                                        Rekonsiliasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ringkasan Anggaran -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="600">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex align-items-center mb-3">
                                    <svg class="me-2 icon-20" width="20" height="20" viewBox="0 0 24 24">
                                        <path fill="#17904b"
                                            d="M3 3h18v2H3V3m0 4h18v2H3V7m0 4h18v10H3V11m2 2v6h14v-6H5z" />
                                    </svg>
                                    <h5 class="fw-bold mb-0">Ringkasan Anggaran</h5>
                                </div>

                                <!-- Nominal utama -->
                                <div class="d-flex justify-content-between align-items-end mb-2">
                                    <h4 class="fw-bold text-primary mb-0">
                                        Rp 28.745.650.000
                                    </h4>
                                    <span class="text-muted small">dari Rp 312.480.000.000</span>
                                </div>

                                <!-- Progress bar -->
                                <div class="progress mb-2"
                                    style="
                height: 6px;
                border-radius: 5px;
                background-color: #f0f0f0;
              ">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0.22%"
                                        aria-valuenow="0.22" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <!-- Info bawah -->
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">Terpakai: 9.19%</span>
                                    <span class="text-success small fw-semibold">Sisa: Rp 283.734.350.000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Porsi -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="900">
                            <div class="flex-wrap card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h5 class="fw-bold mb-0">Porsi</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="flex-wrap d-flex align-items-center justify-content-between">
                                    <div id="myChart" class="col-md-8 col-lg-8 myChart"></div>
                                    <div class="d-grid gap col-md-4 col-lg-4">
                                        <div class="d-flex align-items-start">
                                            <svg class="mt-2 icon-14" xmlns="http://www.w3.org/2000/svg"
                                                width="14" viewBox="0 0 24 24" fill="#3a57e8">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="#3a57e8">
                                                    </circle>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <span class="text-gray">Porsi 10K</span>
                                                <h6>16.836</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <svg class="mt-2 icon-14" xmlns="http://www.w3.org/2000/svg"
                                                width="14" viewBox="0 0 24 24" fill="#4bc7d2">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="#4bc7d2">
                                                    </circle>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <span class="text-gray">Porsi 8K</span>
                                                <h6>9.899</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat Transaksi BKU -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="600">
                            <div class="flex-wrap card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h5 class="mb-2 fw-bold mb-0">Riwayat Transaksi BKU</h5>
                                    <p class="mb-0">
                                        <svg class="me-2 icon-24" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="#17904b"
                                                d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z" />
                                        </svg>
                                        Transaksi terbaru dalam 7 hari terakhir
                                    </p>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="mb-2 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">
                                            Pengeluaran Rp 250.000 untuk Kacang Mede
                                        </h6>
                                        <span class="mb-0">31 Mei 2025 - 08:10 WIB</span>
                                    </div>
                                </div>

                                <div class="mb-2 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">Tambah Rekap BKU Mingguan</h6>
                                        <span class="mb-0">1 Juni 2025 - 09:45 WIB</span>
                                    </div>
                                </div>

                                <div class="mb-2 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">Revisi Data Transaksi (Rp 180.000)</h6>
                                        <span class="mb-0">2 Juni 2025 - 14:30 WIB</span>
                                    </div>
                                </div>

                                <div class="mb-2 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">Update Saldo Akhir Mingguan</h6>
                                        <span class="mb-0">3 Juni 2025 - 10:10 WIB</span>
                                    </div>
                                </div>

                                <div class="mb-1 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">Rekap Baru Ditambahkan</h6>
                                        <span class="mb-0">5 Juni 2025 - 07:50 WIB</span>
                                    </div>
                                </div>

                                <div class="mb-1 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">Rekap Baru Ditambahkan</h6>
                                        <span class="mb-0">5 Juni 2025 - 07:50 WIB</span>
                                    </div>
                                </div>

                                <div class="mb-1 d-flex profile-media align-items-top">
                                    <div class="mt-1 profile-dots-pills border-primary"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-1">Rekap Baru Ditambahkan</h6>
                                        <span class="mb-0">5 Juni 2025 - 07:50 WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- New Script Filter TAB -->
    <script>
        document.querySelectorAll(".global-filter").forEach((btn) => {
            btn.addEventListener("click", function() {
                // Hilangkan active di semua tab
                document
                    .querySelectorAll(".global-filter")
                    .forEach((x) => x.classList.remove("active"));

                // Tambah active ke tab yang dipilih
                this.classList.add("active");

                const selected = this.getAttribute("data-value");

                // Panggil fungsi refresh chart (sesuaikan dengan chart kamu)
                loadChartMain(selected);
                loadChartActivity(selected);
                loadChartDistribusi(selected);

                console.log("Filter global:", selected);
            });
        });
    </script>
@endpush
