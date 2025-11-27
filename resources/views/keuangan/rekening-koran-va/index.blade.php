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
                            <h4 class="card-title fw-bold">Rekening Koran VA</h4>
                        </div>
                        <a href="{{ route('rekening-koran-va.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Tambah Transaksi
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="custom-datatable-entries">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>Ref</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                        <th>Kategori Transaksi</th>
                                        <th>Minggu</th>
                                        <th>Link PO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekeningKoran as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->tanggal_transaksi->format('d/m/y H.i.s') }}</td>
                                            <td>{{ $item->uraian }}</td>
                                            <td>{{ $item->ref }}</td>
                                            <td>{{ $item->debit > 0 ? number_format($item->debit, 0, ',', '.') : '-' }}</td>
                                            <td>{{ $item->kredit > 0 ? number_format($item->kredit, 0, ',', '.') : '-' }}
                                            </td>
                                            <td>{{ number_format($item->saldo, 0, ',', '.') }}</td>
                                            <td>{{ $item->kategori_transaksi }}</td>
                                            <td>{{ $item->minggu ? 'Minggu ' . $item->minggu : '-' }}</td>
                                            <td>
                                                @if ($item->transaction)
                                                    <span class="badge bg-info">
                                                        {{ $item->transaction->order->order_number }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>Ref</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                        <th>Kategori Transaksi</th>
                                        <th>Minggu</th>
                                        <th>Link PO</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
