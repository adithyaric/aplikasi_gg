{{-- gaji/create.blade.php --}}
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
                        <form id="gajiForm">
                            @csrf
                            @if ($periode_bulan && $periode_tahun)
                                <input type="hidden" name="periode_bulan" value="{{ $periode_bulan }}">
                                <input type="hidden" name="periode_tahun" value="{{ $periode_tahun }}">
                            @endif
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ $tanggal_mulai }}" class="form-control" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" value="{{ $tanggal_akhir }}" class="form-control" required />
                                </div>
                            </div>
                            <hr class="hr-horizontal" />
                            <h5>Pilih Karyawan</h5>
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-primary" id="selectAll">Pilih Semua</button>
                                <button type="button" class="btn btn-sm btn-secondary" id="deselectAll">Batalkan
                                    Semua</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="checkAll" class="form-check-input">
                                            </th>
                                            <th>Nama Karyawan</th>
                                            <th>Kategori</th>
                                            <th>Nominal Gaji/Hari</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawans as $karyawan)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input karyawan-checkbox" type="checkbox"
                                                            name="karyawan_ids[]" value="{{ $karyawan->id }}"
                                                            id="karyawan_{{ $karyawan->id }}"
                                                            {{ $existingGajis->has($karyawan->id) ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>{{ $karyawan->nama }}</td>
                                                <td>{{ $karyawan->kategori->nama }}</td>
                                                <td>Rp. {{ number_format($karyawan->kategori->nominal_gaji, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr class="hr-horizontal" />
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('gaji.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">Proses Gaji</button>
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
        $('#checkAll').on('change', function() {
            $('.karyawan-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('#selectAll').on('click', function() {
            $('.karyawan-checkbox').prop('checked', true);
            $('#checkAll').prop('checked', true);
        });

        $('#deselectAll').on('click', function() {
            $('.karyawan-checkbox').prop('checked', false);
            $('#checkAll').prop('checked', false);
        });

        $('#gajiForm').submit(function(e) {
            e.preventDefault();

            if ($('.karyawan-checkbox:checked').length === 0) {
                alert('Pilih minimal 1 karyawan');
                return;
            }

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('gaji.store') }}',
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
                        window.location.href = '{{ route('gaji.index') }}';
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    alert(errors);
                }
            });
        });
    </script>
@endpush
