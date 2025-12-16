{{-- absensi/create.blade.php --}}
@extends('layouts.master')
@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Penerimaan Barang</h3>
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
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $title }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="absensiForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggalAbsensi" class="form-control"
                                        value="{{ $tanggal }}" required />
                                </div>
                            </div>
                            <hr class="hr-horizontal" />
                            <h5>Daftar Karyawan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Karyawan</th>
                                            <th>Kategori</th>
                                            <th>Nominal Gaji/Hari</th>
                                            <th>Status Kehadiran</th>
                                            <th style="display:none;">Confirmed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawans as $karyawan)
                                            <tr>
                                                <td>{{ $karyawan->nama }}</td>
                                                <td>{{ $karyawan->kategori->nama }}</td>
                                                <td>Rp. {{ number_format($karyawan->kategori->nominal_gaji, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="karyawan[{{ $loop->index }}][id]"
                                                        value="{{ $karyawan->id }}">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="karyawan[{{ $loop->index }}][status]"
                                                            id="hadir_{{ $karyawan->id }}" value="hadir"
                                                            {{ ($existingAbsensi[$karyawan->id]['status'] ?? 'hadir') == 'hadir' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label"
                                                            for="hadir_{{ $karyawan->id }}">Hadir</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="karyawan[{{ $loop->index }}][status]"
                                                            id="tidak_hadir_{{ $karyawan->id }}" value="tidak_hadir"
                                                            {{ ($existingAbsensi[$karyawan->id]['status'] ?? 'hadir') == 'tidak_hadir' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label"
                                                            for="tidak_hadir_{{ $karyawan->id }}">Tidak Hadir</label>
                                                    </div>
                                                </td>
                                                <td style="display:none;">
                                                    <input type="hidden" name="karyawan[{{ $loop->index }}][confirmed]"
                                                        value="{{ $existingAbsensi[$karyawan->id]['confirmed'] ?? 0 }}"
                                                        class="confirmed-input" id="confirmed_{{ $karyawan->id }}">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input confirmed-radio" type="radio"
                                                            name="temp_confirmed_{{ $karyawan->id }}"
                                                            data-target="#confirmed_{{ $karyawan->id }}" value="1"
                                                            {{ ($existingAbsensi[$karyawan->id]['confirmed'] ?? 0) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input confirmed-radio" type="radio"
                                                            name="temp_confirmed_{{ $karyawan->id }}"
                                                            data-target="#confirmed_{{ $karyawan->id }}" value="0"
                                                            {{ ($existingAbsensi[$karyawan->id]['confirmed'] ?? 0) == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr class="hr-horizontal" />
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize confirmed values on page load
            $('.confirmed-radio:checked').each(function() {
                const target = $(this).data('target');
                $(target).val($(this).val());
            });

            // Handle confirmed radio buttons
            $('.confirmed-radio').on('change', function() {
                const target = $(this).data('target');
                $(target).val($(this).val());
            });

            // Date change
            $('#tanggalAbsensi').on('change', function() {
                const tanggal = $(this).val();
                window.location.href = '{{ route('absensi.create') }}?tanggal=' + tanggal;
            });

            // Form submit
            $('#absensiForm').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('absensi.store') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = '{{ route('absensi.index') }}';
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.message || 'Terjadi kesalahan';
                        alert(errors);
                    }
                });
            });
        });
    </script>
@endpush
