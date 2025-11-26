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
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">Stok</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Brand</th>
                                        {{-- <th>Satuan</th> --}}
                                        <th>Qty</th>
                                        <th>L. Pembelian</th>
                                        <th>Avg. Cost</th>
                                        <th>Gov. Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stok as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nama }} ({{ $item->satuan }})</td>
                                            <td>{{ $item->kategori }}</td>
                                            <td>{{ $item->merek }}</td>
                                            {{-- <td>{{ $item->satuan }}</td> --}}
                                            <td>{{ number_format($item->qty, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($item->qty > 0 && $item->last_purchase_price > 0)
                                                    Rp {{ number_format($item->last_purchase_price, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->qty > 0 && $item->avg_cost > 0)
                                                    Rp {{ number_format($item->avg_cost, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($item->gov_price, 0, ',', '.') }}</td>
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endpush
