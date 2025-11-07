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
                        <div>
                            <a href="#" class="btn btn-link btn-soft-light" data-bs-toggle="modal"
                                data-bs-target="#modalSekolah" onclick="resetForm()">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z"
                                        fill="currentColor"></path>
                                </svg>
                                Tambah Sekolah
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bold">Sekolah</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tableSekolah">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nama PIC</th>
                                        <th>Nomor</th>
                                        <th>Jarak</th>
                                        <th>Porsi 8K</th>
                                        <th>Porsi 10K</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sekolahs as $index => $sekolah)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $sekolah->nama }}</td>
                                            <td>{{ $sekolah->nama_pic }}</td>
                                            <td>{{ $sekolah->nomor }}</td>
                                            <td>{{ $sekolah->jarak }}</td>
                                            <td>{{ $sekolah->porsi_8k }}</td>
                                            <td>{{ $sekolah->porsi_10k }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="editSekolah({{ $sekolah->id }})">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M9.3764 20.0279L18.1628 8.66544C18.6403 8.0527 18.8101 7.3443 18.6509 6.62299C18.513 5.96726 18.1097 5.34377 17.5049 4.87078L16.0299 3.69906C14.7459 2.67784 13.1541 2.78534 12.2415 3.95706L11.2546 5.23735C11.1273 5.39752 11.1591 5.63401 11.3183 5.76301C11.3183 5.76301 13.812 7.76246 13.8651 7.80546C14.0349 7.96671 14.1622 8.1817 14.1941 8.43969C14.2471 8.94493 13.8969 9.41792 13.377 9.48242C13.1329 9.51467 12.8994 9.43942 12.7297 9.29967L10.1086 7.21422C9.98126 7.11855 9.79025 7.13898 9.68413 7.26797L3.45514 15.3303C3.0519 15.8355 2.91395 16.4912 3.0519 17.1255L3.84777 20.5761C3.89021 20.7589 4.04939 20.8879 4.24039 20.8879L7.74222 20.8449C8.37891 20.8341 8.97316 20.5439 9.3764 20.0279ZM14.2797 18.9533H19.9898C20.5469 18.9533 21 19.4123 21 19.9766C21 20.5421 20.5469 21 19.9898 21H14.2797C13.7226 21 13.2695 20.5421 13.2695 19.9766C13.2695 19.4123 13.7226 18.9533 14.2797 18.9533Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="deleteSekolah({{ $sekolah->id }})">
                                                    <span class="btn-inner">
                                                        <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M20.2871 5.24297C20.6761 5.24297 21 5.56596 21 5.97696V6.35696C21 6.75795 20.6761 7.09095 20.2871 7.09095H3.71385C3.32386 7.09095 3 6.75795 3 6.35696V5.97696C3 5.56596 3.32386 5.24297 3.71385 5.24297H6.62957C7.22185 5.24297 7.7373 4.82197 7.87054 4.22798L8.02323 3.54598C8.26054 2.61699 9.0415 2 9.93527 2H14.0647C14.9488 2 15.7385 2.61699 15.967 3.49699L16.1304 4.22698C16.2627 4.82197 16.7781 5.24297 17.3714 5.24297H20.2871ZM18.8058 19.134C19.1102 16.2971 19.6432 9.55712 19.6432 9.48913C19.6626 9.28313 19.5955 9.08813 19.4623 8.93113C19.3193 8.78413 19.1384 8.69713 18.9391 8.69713H5.06852C4.86818 8.69713 4.67756 8.78413 4.54529 8.93113C4.41108 9.08813 4.34494 9.28313 4.35467 9.48913C4.35646 9.50162 4.37558 9.73903 4.40755 10.1359C4.54958 11.8992 4.94517 16.8102 5.20079 19.134C5.38168 20.846 6.50498 21.922 8.13206 21.961C9.38763 21.99 10.6811 22 12.0038 22C13.2496 22 14.5149 21.99 15.8094 21.961C17.4929 21.932 18.6152 20.875 18.8058 19.134Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalSekolah" tabindex="-1" aria-labelledby="modalSekolahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalSekolahLabel">Tambah Sekolah</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form id="formSekolah">
                                @csrf
                                <input type="hidden" id="sekolah_id" name="sekolah_id">
                                <input type="hidden" id="form_method" name="_method" value="POST">
                                <input type="hidden" id="long" name="long">
                                <input type="hidden" id="lat" name="lat">
                                <div class="form-group mb-1">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan nama sekolah">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Nama PIC <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_pic" name="nama_pic"
                                        placeholder="Masukkan nama PIC">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Nomor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nomor" name="nomor"
                                        placeholder="Masukkan nomor">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Jarak <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="jarak" name="jarak"
                                        placeholder="Masukkan jarak">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Porsi 8K <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="porsi_8k" name="porsi_8k"
                                        placeholder="Masukkan Porsi 8K">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Porsi 10K <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="porsi_10k" name="porsi_10k"
                                        placeholder="Masukkan Porsi 10K">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="2"
                                        placeholder="Alamat akan terisi otomatis dari peta"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Cari Lokasi Sekolah</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search-location"
                                            placeholder="Cari nama sekolah atau alamat...">
                                        <a href="#" class="btn btn-outline-primary" id="btn-search">Cari</a>
                                    </div>
                                    <div id="search-results" style="display: none;">
                                        <div class="card">
                                            <div class="card-header py-2">
                                                <small class="fw-bold">Hasil Pencarian:</small>
                                            </div>
                                            <div class="card-body p-0">
                                                <div id="results-list" style="max-height: 200px; overflow-y: auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label">Pilih Lokasi di Peta <span
                                            class="text-danger">*</span></label>
                                    <div id="map-sekolah" style="height: 300px; border-radius: 8px;"></div>
                                    <small class="text-muted">Klik pada peta untuk memilih lokasi</small>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#tableSekolah').DataTable();
        });

        function resetForm() {
            $('#formSekolah')[0].reset();
            $('#sekolah_id').val('');
            $('#form_method').val('POST');
            $('#modalSekolahLabel').text('Tambah Sekolah');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }

        $('#formSekolah').on('submit', function(e) {
            e.preventDefault();

            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            let id = $('#sekolah_id').val();
            let url = id ? "{{ route('sekolah.index') }}/" + id : "{{ route('sekolah.store') }}";
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalSekolah').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data'
                        });
                    }
                }
            });
        });

        function editSekolah(id) {
            $.ajax({
                url: "{{ route('sekolah.index') }}/" + id + "/edit",
                method: 'GET',
                success: function(response) {
                    $('#sekolah_id').val(response.id);
                    $('#nama').val(response.nama);
                    $('#nama_pic').val(response.nama_pic);
                    $('#nomor').val(response.nomor);
                    $('#jarak').val(response.jarak);
                    $('#porsi_8k').val(response.porsi_8k);
                    $('#porsi_10k').val(response.porsi_10k);
                    $('#form_method').val('PUT');
                    $('#modalSekolahLabel').text('Edit Sekolah');
                    $('#modalSekolah').modal('show');
                }
            });
        }

        function deleteSekolah(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('sekolah.index') }}/" + id,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menghapus data'
                            });
                        }
                    });
                }
            });
        }
    </script>
    <script>
        let mapSekolah, markerSekolah, searchMarkers = [];

        const makassarBounds = {
            north: -5.0556,
            south: -5.2096,
            east: 119.5377,
            west: 119.3737
        };

        function initMapSekolah() {
            if (!document.getElementById('map-sekolah') || $('#map-sekolah').is(':hidden')) {
                return;
            }

            mapSekolah = L.map('map-sekolah').setView([-5.135, 119.422], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(mapSekolah);

            mapSekolah.setMaxBounds([
                [makassarBounds.south, makassarBounds.west],
                [makassarBounds.north, makassarBounds.east]
            ]);

            mapSekolah.on('click', async function(e) {
                let lat = e.latlng.lat;
                let lng = e.latlng.lng;

                if (lat < makassarBounds.south || lat > makassarBounds.north ||
                    lng < makassarBounds.west || lng > makassarBounds.east) {
                    Swal.fire('Peringatan', 'Silakan pilih lokasi dalam area Makassar', 'warning');
                    return;
                }

                $('#lat').val(lat);
                $('#long').val(lng);

                if (markerSekolah) {
                    mapSekolah.removeLayer(markerSekolah);
                }

                var redIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                markerSekolah = L.marker([lat, lng], {
                        icon: redIcon
                    }).addTo(mapSekolah)
                    .bindPopup('Lokasi Sekolah Terpilih')
                    .openPopup();

                await getAddressFromCoordinates(lat, lng);
            });
        }

        function clearSearchMarkers() {
            searchMarkers.forEach(marker => {
                mapSekolah.removeLayer(marker);
            });
            searchMarkers = [];
        }

        async function searchLocation(query) {
            try {
                let searchQuery = query;
                const schoolKeywords = ['sekolah', 'school', 'sd', 'smp', 'sma', 'smk', 'madrasah', 'mi', 'mts', 'man'];
                const hasSchoolKeyword = schoolKeywords.some(keyword => query.toLowerCase().includes(keyword));

                if (!hasSchoolKeyword) {
                    searchQuery = `${query} sekolah Makassar`;
                } else {
                    searchQuery = `${query} Makassar`;
                }

                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?` +
                    `format=json&` +
                    `q=${encodeURIComponent(searchQuery)}&` +
                    `countrycodes=id&` +
                    `viewbox=${makassarBounds.west},${makassarBounds.north},${makassarBounds.east},${makassarBounds.south}&` +
                    `bounded=1&` +
                    `limit=10`
                );

                const data = await response.json();

                if (data.length > 0) {
                    clearSearchMarkers();
                    $('#search-results').show();
                    $('#results-list').empty();

                    var blueIcon = L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    const makassarResults = data.filter(result => {
                        const lat = parseFloat(result.lat);
                        const lon = parseFloat(result.lon);
                        return lat >= makassarBounds.south && lat <= makassarBounds.north &&
                            lon >= makassarBounds.west && lon <= makassarBounds.east;
                    });

                    if (makassarResults.length === 0) {
                        $('#search-results').hide();
                        Swal.fire('Peringatan', 'Tidak ditemukan sekolah di area Makassar', 'warning');
                        return;
                    }

                    makassarResults.forEach((result, index) => {
                        const lat = parseFloat(result.lat);
                        const lng = parseFloat(result.lon);

                        let displayName = result.display_name;
                        let schoolName = result.display_name.split(',')[0];
                        if (result.name && result.name !== '') {
                            schoolName = result.name;
                        }

                        const resultId = `result-${index}`;

                        const marker = L.marker([lat, lng], {
                                icon: blueIcon
                            }).addTo(mapSekolah)
                            .bindPopup(`
                            <div class="text-center">
                                <strong>${schoolName}</strong><br>
                                <small>${displayName}</small><br>
                                <a href="javascript:void(0)" class="btn btn-sm btn-success mt-1 select-location"
                                   data-lat="${lat}" 
                                   data-lng="${lng}" 
                                   data-address="${displayName.replace(/"/g, '&quot;')}" 
                                   data-school="${schoolName.replace(/"/g, '&quot;')}">
                                    Pilih
                                </a>
                            </div>
                        `);

                        searchMarkers.push(marker);

                        $('#results-list').append(`
                        <div class="p-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">${schoolName}</h6>
                                    <small class="text-muted">${displayName}</small>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary ms-2 select-location"
                                   data-lat="${lat}" 
                                   data-lng="${lng}" 
                                   data-address="${displayName.replace(/"/g, '&quot;')}" 
                                   data-school="${schoolName.replace(/"/g, '&quot;')}">
                                    Pilih
                                </a>
                            </div>
                        </div>
                    `);
                    });

                    const group = new L.featureGroup(searchMarkers);
                    mapSekolah.fitBounds(group.getBounds().pad(0.1));
                } else {
                    $('#search-results').hide();
                    Swal.fire('Peringatan', 'Tidak ditemukan sekolah dengan kata kunci tersebut di Makassar',
                        'warning');
                }
            } catch (error) {
                console.error('Search error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat mencari lokasi', 'error');
            }
        }

        $(document).on('click', '.select-location', function(e) {
            e.preventDefault();
            const lat = $(this).data('lat');
            const lng = $(this).data('lng');
            const address = $(this).data('address');
            const schoolName = $(this).data('school');
            selectLocation(lat, lng, address, schoolName);
        });

        function selectLocation(lat, lng, address, schoolName = '') {
            clearSearchMarkers();
            $('#search-results').hide();
            $('#search-location').val('');

            $('#lat').val(lat);
            $('#long').val(lng);
            $('#alamat').val(address);

            if (schoolName && !$('#nama').val()) {
                $('#nama').val(schoolName);
            }

            if (markerSekolah) {
                mapSekolah.removeLayer(markerSekolah);
            }

            var redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            markerSekolah = L.marker([lat, lng], {
                    icon: redIcon
                }).addTo(mapSekolah)
                .bindPopup('<strong>Lokasi Sekolah Terpilih</strong><br>' + address)
                .openPopup();

            mapSekolah.setView([lat, lng], 15);
        }

        async function getAddressFromCoordinates(lat, lng) {
            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                const data = await response.json();
                if (data && data.display_name) {
                    $('#alamat').val(data.display_name);
                }
            } catch (error) {
                console.error('Reverse geocoding error:', error);
            }
        }

        $(document).on('click', '#btn-search', function(e) {
            e.preventDefault();
            const query = $('#search-location').val().trim();
            if (query) {
                searchLocation(query);
            } else {
                Swal.fire('Peringatan', 'Masukkan kata kunci pencarian', 'warning');
            }
        });

        $('#search-location').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btn-search').click();
            }
        });

        function resetForm() {
            $('#formSekolah')[0].reset();
            $('#sekolah_id').val('');
            $('#form_method').val('POST');
            $('#modalSekolahLabel').text('Tambah Sekolah');
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#lat').val('');
            $('#long').val('');
            $('#alamat').val('');
            $('#search-location').val('');
            $('#search-results').hide();
            $('#results-list').empty();

            clearSearchMarkers();
            if (markerSekolah) {
                mapSekolah.removeLayer(markerSekolah);
                markerSekolah = null;
            }

            if (mapSekolah) {
                mapSekolah.setView([-5.135, 119.422], 13);
            }
        }

        $('#modalSekolah').on('shown.bs.modal', function() {
            setTimeout(function() {
                if (!mapSekolah) {
                    initMapSekolah();
                } else {
                    mapSekolah.invalidateSize();
                }
            }, 300);
        });

        function editSekolah(id) {
            $.ajax({
                url: "{{ route('sekolah.index') }}/" + id + "/edit",
                method: 'GET',
                success: function(response) {
                    $('#sekolah_id').val(response.id);
                    $('#nama').val(response.nama);
                    $('#nama_pic').val(response.nama_pic);
                    $('#nomor').val(response.nomor);
                    $('#jarak').val(response.jarak);
                    $('#porsi_8k').val(response.porsi_8k);
                    $('#porsi_10k').val(response.porsi_10k);
                    $('#lat').val(response.lat);
                    $('#long').val(response.long);
                    $('#alamat').val(response.alamat);
                    $('#form_method').val('PUT');
                    $('#modalSekolahLabel').text('Edit Sekolah');

                    $('#modalSekolah').modal('show');

                    setTimeout(function() {
                        if (response.lat && response.long) {
                            clearSearchMarkers();
                            if (markerSekolah) {
                                mapSekolah.removeLayer(markerSekolah);
                            }

                            var redIcon = L.icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });

                            markerSekolah = L.marker([response.lat, response.long], {
                                    icon: redIcon
                                }).addTo(mapSekolah)
                                .bindPopup(response.nama)
                                .openPopup();
                            mapSekolah.setView([response.lat, response.long], 15);
                        }
                    }, 400);
                }
            });
        }
    </script>
@endpush
