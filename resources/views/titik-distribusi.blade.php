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

        function initMapDistribusi() {
            mapDistribusi = L.map('map-distribusi').setView([-5.135, 119.422], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(mapDistribusi);

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
                @endif
            @endforeach

            // Fit map bounds to show all markers
            var group = new L.featureGroup();
            @foreach ($schools as $sekolah)
                @if ($sekolah->lat && $sekolah->long)
                    group.addLayer(L.marker([{{ $sekolah->lat }}, {{ $sekolah->long }}]));
                @endif
            @endforeach

            if (group.getLayers().length > 0) {
                mapDistribusi.fitBounds(group.getBounds().pad(0.1));
            }
        }

        $(document).ready(function() {
            initMapDistribusi();
        });

        // Reinitialize map when tab is shown (if using tabs)
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            if (e.target.getAttribute('href') === '#map-tab') { // Adjust if using tabs
                setTimeout(function() {
                    mapDistribusi.invalidateSize();
                }, 300);
            }
        });
    </script>
@endpush
