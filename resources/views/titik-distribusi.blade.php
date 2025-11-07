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
                        <h4 class="card-title fw-bold">Titik Distribusi Sekolah</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-md-6 col-12">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="search-school"
                                        placeholder="Cari Alamat/Nama PIC/Nama sekolah...">
                                    <button class="btn btn-sm btn-primary" type="button" id="btn-search-school">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    <a href="{{ route('titik-distribusi') }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-reset"></i> reset
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="map-distribusi" style="height: 600px; border-radius: 8px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let mapDistribusi;
        let schoolMarkers = [];

        function initMapDistribusi() {
            mapDistribusi = L.map('map-distribusi').setView([-5.135, 119.422], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(mapDistribusi);

            // Clear existing markers
            schoolMarkers.forEach(marker => mapDistribusi.removeLayer(marker));
            schoolMarkers = [];

            @foreach ($schools as $sekolah)
                @if ($sekolah->lat && $sekolah->long)
                    var schoolMarker = L.marker([{{ $sekolah->lat }}, {{ $sekolah->long }}]).addTo(mapDistribusi);
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

                    // Store marker with school data for searching
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

            // Fit map bounds to show all markers
            if (schoolMarkers.length > 0) {
                var group = new L.featureGroup(schoolMarkers);
                mapDistribusi.fitBounds(group.getBounds().pad(0.1));
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
                mapDistribusi.setView([marker.schoolData.lat, marker.schoolData.long], 16);
                marker.openPopup();
            } else {
                // Multiple results - show bounds and list
                const group = new L.featureGroup(foundMarkers);
                mapDistribusi.fitBounds(group.getBounds().pad(0.1));

                // Show results count
                Swal.fire({
                    icon: 'info',
                    title: `${foundMarkers.length} sekolah ditemukan`,
                    text: `Menampilkan ${foundMarkers.length} sekolah dengan nama mengandung "${searchTerm}"`
                });
            }
        }

        $(document).ready(function() {
            initMapDistribusi();

            // Search button click event
            $('#btn-search-school').on('click', function() {
                const searchTerm = $('#search-school').val();
                searchAndZoomToSchool(searchTerm);
            });

            // Enter key press in search input
            $('#search-school').on('keypress', function(e) {
                if (e.which === 13) {
                    const searchTerm = $('#search-school').val();
                    searchAndZoomToSchool(searchTerm);
                }
            });
        });

        // Reinitialize map when tab is shown (if using tabs)
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            if (e.target.getAttribute('href') === '#map-tab') {
                setTimeout(function() {
                    mapDistribusi.invalidateSize();
                }, 300);
            }
        });
    </script>
@endpush
