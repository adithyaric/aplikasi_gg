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
                        <div>
                            <a href="{{ route('export.stok') }}" class="btn btn-warning ms-2">
                                <i class="fas fa-file-export me-2"></i> Export
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
                                            <td>{{ $item->qty }}</td>
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
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="showGovPriceHistory('{{ $item->id }}', '{{ $item->type }}')">
                                                    Rp {{ number_format($item->gov_price, 0, ',', '.') }}
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

    <!-- Modal History Gov Price -->
    <div class="modal fade" id="modalGovPriceHistory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">History Gov Price - <span id="history_bahan_name"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Perubahan</th>
                                </tr>
                            </thead>
                            <tbody id="gov_price_history"></tbody>
                        </table>
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

        function showGovPriceHistory(id, type) {
            $.ajax({
                url: "{{ route('stok.show', ['bahanId' => 'ID', 'type' => 'TYPE']) }}"
                    .replace('ID', id)
                    .replace('TYPE', type),
                success: function(response) {
                    $('#history_bahan_name').text(response.nama);
                    $('#gov_price_history').empty();

                    if (response.activities && response.activities.length > 0) {
                        response.activities.forEach(function(activity) {
                            const props = activity.properties;
                            const createdAt = activity.created_at ?
                                new Date(activity.created_at).toLocaleString('id-ID') :
                                '-';

                            let changes = [];

                            if (props.old && props.attributes) {
                                if (props.old.gov_price !== props.attributes.gov_price) {
                                    const oldValue = props.old.gov_price ?
                                        'Rp ' + new Intl.NumberFormat('id-ID').format(props.old
                                            .gov_price) :
                                        '-';
                                    const newValue = props.attributes.gov_price ?
                                        'Rp ' + new Intl.NumberFormat('id-ID').format(props.attributes
                                            .gov_price) :
                                        '-';

                                    changes.push(`Gov Price: ${oldValue} → ${newValue}`);
                                }
                            }

                            $('#gov_price_history').append(`
                        <tr>
                            <td>${createdAt}</td>
                            <td>${changes.length > 0 ? changes.join('<br>') : '-'}</td>
                        </tr>
                    `);
                        });
                    } else {
                        $('#gov_price_history').append(
                            '<tr><td colspan="2" class="text-center">Tidak ada data history</td></tr>'
                        );
                    }

                    $('#modalGovPriceHistory').modal('show');
                }
            });
        }
    </script>
@endpush
