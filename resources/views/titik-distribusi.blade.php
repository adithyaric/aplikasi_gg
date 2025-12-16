@extends('layouts.master')
@section('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bold">Titik Distribusi</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="distribusiTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="school-tab" data-bs-toggle="tab"
                                    data-bs-target="#school" type="button" role="tab">Sekolah</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="supplier-tab" data-bs-toggle="tab" data-bs-target="#supplier"
                                    type="button" role="tab">Supplier</button>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="school" role="tabpanel">
                                <div class="row mb-1">
                                    <div class="col-md-6 col-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="search-school"
                                                placeholder="Cari Alamat/Nama PIC/Nama sekolah...">
                                            <button class="btn btn-sm btn-primary" type="button" id="btn-search-school">
                                                <i class="bi bi-search"></i> Cari
                                            </button>
                                            <a href="{{ route('titik-distribusi') }}" class="btn btn-sm btn-secondary">
                                                reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="map-school" style="height: 600px; border-radius: 8px;"></div>
                            </div>

                            <div class="tab-pane fade" id="supplier" role="tabpanel">
                                <div class="row mb-1">
                                    <div class="col-md-6 col-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="search-supplier"
                                                placeholder="Cari Alamat/Nama Supplier...">
                                            <button class="btn btn-sm btn-primary" type="button" id="btn-search-supplier">
                                                <i class="bi bi-search"></i> Cari
                                            </button>
                                            <a href="{{ route('titik-distribusi') }}" class="btn btn-sm btn-secondary">
                                                reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="map-supplier" style="height: 600px; border-radius: 8px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let mapSchool, mapSupplier;
        let schoolMarkers = [];
        let supplierMarkers = [];

        function initMapSchool() {
            //titik Se Indonesia
            mapSchool = L.map('map-school').setView([-2.5489, 118.0149], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(mapSchool);

            schoolMarkers.forEach(marker => mapSchool.removeLayer(marker));
            schoolMarkers = [];

            @foreach ($schools as $sekolah)
                @if ($sekolah->lat && $sekolah->long)
                    var schoolMarker = L.marker([{{ $sekolah->lat }}, {{ $sekolah->long }}]).addTo(mapSchool);
                    schoolMarker.bindPopup(`
                <div class="text-center">
                    <h6 class="fw-bold">{{ $sekolah->nama }}</h6>
                    <hr class="my-1">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start pe-1"><strong>PIC</strong></td>
                                    <td class="text-start">{{ $sekolah->nama_pic }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start pe-1"><strong>Nomor</strong></td>
                                    <td class="text-start">{{ $sekolah->nomor }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start pe-1"><strong>Jarak</strong></td>
                                    <td class="text-start">{{ $sekolah->jarak }} km</td>
                                </tr>
                                @if ($sekolah->porsi_8k)
                                <tr>
                                    <td class="text-start pe-1"><strong>Porsi 8K</strong></td>
                                    <td class="text-start">{{ $sekolah->porsi_8k }}</td>
                                </tr>
                                @endif
                                @if ($sekolah->porsi_10k)
                                <tr>
                                    <td class="text-start pe-1"><strong>Porsi 10K</strong></td>
                                    <td class="text-start">{{ $sekolah->porsi_10k }}</td>
                                </tr>
                                @endif
                                @if ($sekolah->alamat)
                                <tr>
                                    <td class="text-start pe-1"><strong>Alamat</strong></td>
                                    <td class="text-start text-wrap" style="min-width: 225px; word-break: break-word;">{{ $sekolah->alamat }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            `);

                    schoolMarker.schoolData = {
                        id: {{ $sekolah->id }},
                        nama: `{{ $sekolah->nama }}`,
                        nama_pic: `{{ $sekolah->nama_pic }}`,
                        alamat: `{{ $sekolah->alamat ?? '' }}`,
                        lat: {{ $sekolah->lat }},
                        long: {{ $sekolah->long }}
                    };
                    schoolMarkers.push(schoolMarker);
                @endif
            @endforeach

            if (schoolMarkers.length > 0) {
                var group = new L.featureGroup(schoolMarkers);
                mapSchool.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function initMapSupplier() {
            //titik Se Indonesia
            mapSupplier = L.map('map-supplier').setView([-2.5489, 118.0149], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(mapSupplier);

            supplierMarkers.forEach(marker => mapSupplier.removeLayer(marker));
            supplierMarkers = [];

            @foreach ($suppliers as $supplier)
                @if ($supplier->lat && $supplier->long)
                    var supplierMarker = L.marker([{{ $supplier->lat }}, {{ $supplier->long }}]).addTo(mapSupplier);
                    supplierMarker.bindPopup(`
                <div class="text-center">
                    <h6 class="fw-bold">{{ $supplier->nama }}</h6>
                    <hr class="my-1">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start pe-1"><strong>No HP</strong></td>
                                    <td class="text-start">{{ $supplier->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start pe-1"><strong>Bank No Rek</strong></td>
                                    <td class="text-start">{{ $supplier->bank_no_rek }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start pe-1"><strong>Bank Nama</strong></td>
                                    <td class="text-start">{{ $supplier->bank_nama }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start pe-1"><strong>Products</strong></td>
                                    <td class="text-start">{{ $supplier->products }}</td>
                                </tr>
                                @if ($supplier->alamat)
                                <tr>
                                    <td class="text-start pe-1"><strong>Alamat</strong></td>
                                    <td class="text-start text-wrap" style="min-width: 225px; word-break: break-word;">{{ $supplier->alamat }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            `);

                    supplierMarker.supplierData = {
                        id: {{ $supplier->id }},
                        nama: `{{ $supplier->nama }}`,
                        alamat: `{{ $supplier->alamat ?? '' }}`,
                        lat: {{ $supplier->lat }},
                        long: {{ $supplier->long }}
                    };
                    supplierMarkers.push(supplierMarker);
                @endif
            @endforeach

            if (supplierMarkers.length > 0) {
                var group = new L.featureGroup(supplierMarkers);
                mapSupplier.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function searchAndZoomToSchool(searchTerm) {
            if (!searchTerm) return;

            const normalizedSearch = searchTerm.toLowerCase().trim();
            let foundMarkers = [];

            // Search through markers
            schoolMarkers.forEach(marker => {
                const schoolData = marker.schoolData;
                if (schoolData.nama.toLowerCase().includes(normalizedSearch) ||
                    schoolData.alamat.toLowerCase().includes(normalizedSearch) ||
                    schoolData.nama_pic.toLowerCase().includes(normalizedSearch)) {
                    foundMarkers.push(marker);
                }
            });

            if (foundMarkers.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ditemukan',
                    text: `Tidak ada sekolah dengan data "${searchTerm}"`
                });
                return;
            }

            if (foundMarkers.length === 1) {
                // Single result - zoom directly to it
                const marker = foundMarkers[0];
                mapSchool.setView([marker.schoolData.lat, marker.schoolData.long], 5);
                marker.openPopup();
            } else {
                // Multiple results - show bounds and list
                const group = new L.featureGroup(foundMarkers);
                mapSchool.fitBounds(group.getBounds().pad(0.1));

                // Show results count
                Swal.fire({
                    icon: 'info',
                    title: `${foundMarkers.length} sekolah ditemukan`,
                    text: `Menampilkan ${foundMarkers.length} sekolah dengan nama mengandung "${searchTerm}"`
                });
            }
        }

        function searchAndZoomToSupplier(searchTerm) {
            if (!searchTerm) return;

            const normalizedSearch = searchTerm.toLowerCase().trim();
            let foundMarkers = [];

            supplierMarkers.forEach(marker => {
                const supplierData = marker.supplierData;
                if (supplierData.nama.toLowerCase().includes(normalizedSearch) ||
                    supplierData.alamat.toLowerCase().includes(normalizedSearch)) {
                    foundMarkers.push(marker);
                }
            });

            if (foundMarkers.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ditemukan',
                    text: `Tidak ada supplier dengan data "${searchTerm}"`
                });
                return;
            }

            if (foundMarkers.length === 1) {
                const marker = foundMarkers[0];
                mapSupplier.setView([marker.supplierData.lat, marker.supplierData.long], 5);
                marker.openPopup();
            } else {
                const group = new L.featureGroup(foundMarkers);
                mapSupplier.fitBounds(group.getBounds().pad(0.1));

                Swal.fire({
                    icon: 'info',
                    title: `${foundMarkers.length} supplier ditemukan`,
                    text: `Menampilkan ${foundMarkers.length} supplier dengan data mengandung "${searchTerm}"`
                });
            }
        }

        $(document).ready(function() {
            initMapSchool();

            $('#btn-search-school').on('click', function() {
                const searchTerm = $('#search-school').val();
                searchAndZoomToSchool(searchTerm);
            });

            $('#search-school').on('keypress', function(e) {
                if (e.which === 13) {
                    const searchTerm = $('#search-school').val();
                    searchAndZoomToSchool(searchTerm);
                }
            });

            $('#btn-search-supplier').on('click', function() {
                const searchTerm = $('#search-supplier').val();
                searchAndZoomToSupplier(searchTerm);
            });

            $('#search-supplier').on('keypress', function(e) {
                if (e.which === 13) {
                    const searchTerm = $('#search-supplier').val();
                    searchAndZoomToSupplier(searchTerm);
                }
            });

            // Initialize supplier map when tab is shown
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                if (e.target.getAttribute('id') === 'supplier-tab') {
                    setTimeout(function() {
                        if (!mapSupplier) {
                            initMapSupplier();
                        } else {
                            mapSupplier.invalidateSize();
                        }
                    }, 300);
                } else if (e.target.getAttribute('id') === 'school-tab') {
                    setTimeout(function() {
                        mapSchool.invalidateSize();
                    }, 300);
                }
            });
        });
    </script>
@endpush
