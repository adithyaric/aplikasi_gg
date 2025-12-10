@extends('layouts.master')

@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Penggunaan Barang</h3>
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
                    <div class="card-header d-flex justify-content-between flex-column gap-2">
                        <div class="header-title">
                            <h4 class="card-title fw-bold">Penggunaan Barang</h4>
                        </div>
                        <div id="statusButtons" role="group" aria-label="Tabs">
                            <button type="button" class="btn btn-primary rounded-pill active"
                                data-status="all">All</button>
                            <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                                data-status="draft">Status Draft</button>
                            <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                                data-status="confirmed">Status Confirmed</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries table-responsive text-nowrap">
                            <table id="tablePenggunaanBarang" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No PO</th>
                                        <th>Tanggal</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr data-status="{{ $order->status_penggunaan }}">
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->tanggal_penggunaan?->formatId('d/m/Y') }}</td>
                                            <td>{{ $order->supplier->nama }}</td>
                                            <td>
                                                <h5>
                                                    <span
                                                        class="badge bg-{{ $order->status_penggunaan == 'draft' ? 'gray' : 'success' }}">
                                                        {{ ucfirst($order->status_penggunaan) }}
                                                    </span>
                                                </h5>
                                            </td>
                                            <td>
                                                {{-- @if ($order->status_penggunaan == 'draft') --}}
                                                <a href="{{ route('penggunaan.edit', $order->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    Edit
                                                </a>
                                                {{-- @else --}}
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="showPenggunaanDetail({{ $order->id }})">
                                                    Detail
                                                </button>
                                                {{-- @endif --}}
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

    <!-- Modal Detail Penggunaan -->
    <div class="modal fade" id="modalPenggunaanDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">Data Penggunaan Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title" id="penggunaan_order_number"></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Diterima</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M16.442 13.3097H16.4512" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M12.0045 13.3097H12.0137" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M7.55818 13.3097H7.56744" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M16.442 17.1962H16.4512" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M12.0045 17.1962H12.0137" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M7.55818 17.1962H7.56744" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M16.0433 2V5.29078" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M7.96515 2V5.29078" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M16.2383 3.5791H7.77096C4.83427 3.5791 3 5.21504 3 8.22213V17.2718C3 20.3261 4.83427 21.9999 7.77096 21.9999H16.229C19.175 21.9999 21 20.3545 21 17.3474V8.22213C21.0092 5.21504 19.1842 3.5791 16.2383 3.5791Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" id="penggunaan_tanggal" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Supplier</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M9.59151 15.2068C13.2805 15.2068 16.4335 15.7658 16.4335 17.9988C16.4335 20.2318 13.3015 20.8068 9.59151 20.8068C5.90151 20.8068 2.74951 20.2528 2.74951 18.0188C2.74951 15.7848 5.88051 15.2068 9.59151 15.2068Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M9.59157 12.0198C7.16957 12.0198 5.20557 10.0568 5.20557 7.63476C5.20557 5.21276 7.16957 3.24976 9.59157 3.24976C12.0126 3.24976 13.9766 5.21276 13.9766 7.63476C13.9856 10.0478 12.0356 12.0108 9.62257 12.0198H9.59157Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M16.4829 10.8815C18.0839 10.6565 19.3169 9.28253 19.3199 7.61953C19.3199 5.98053 18.1249 4.62053 16.5579 4.36353"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M18.5952 14.7322C20.1462 14.9632 21.2292 15.5072 21.2292 16.6272C21.2292 17.3982 20.7192 17.8982 19.8952 18.2112"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" id="penggunaan_supplier" disabled>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-horizontal" />
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">Catatan</label>
                                    <textarea class="form-control" id="penggunaan_catatan" disabled>Tidak ada catatan...</textarea>
                                </div>
                            </div>
                            <hr class="hr-horizontal" />
                            <div class="overflow-auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Bahan Baku</th>
                                            <th>Satuan</th>
                                            <th>Qty</th>
                                            <th>Unit Cost</th>
                                            {{-- <th>Subtotal</th> --}}
                                            {{-- <th>Diterima</th> --}}
                                            <th>Digunakan (habis/sisa)</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="penggunaan_items"></tbody>
                                </table>
                                {{-- <div class="d-flex justify-content-end align-items-center mb-3"> --}}
                                    {{-- <p class="h4">Subtotal: <span class="badge bg-success" id="penggunaan_grand_total"></span></p> --}}
                                {{-- </div> --}}
                            </div>
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
            const table = $('#tablePenggunaanBarang').DataTable();

            $('#statusButtons button').on('click', function() {
                $('#statusButtons button').removeClass('active btn-primary').addClass(
                    'btn-white btn-outline-primary');
                $(this).removeClass('btn-white btn-outline-primary').addClass('active btn-primary');

                const status = $(this).data('status');
                if (status === 'all') {
                    table.column(3).search('').draw();
                } else {
                    table.column(3).search(status, false, false).draw();
                }
            });
        });

        function showPenggunaanDetail(id) {
            $.ajax({
                url: "{{ route('orders.index') }}/" + id,
                method: 'GET',
                success: function(response) {
                    $('#penggunaan_order_number').text(response.order_number);
                    $('#penggunaan_tanggal').val(response.tanggal_penggunaan ? new Date(response.tanggal_penggunaan).toLocaleDateString('id-ID') : '-');
                    $('#penggunaan_supplier').val(response.supplier?.nama || '-');
                    $('#penggunaan_catatan').val(response.notes || '-');
                    $('#penggunaan_status').val(response.status_penggunaan || '-');
                    $('#penggunaan_grand_total').text('Rp ' + new Intl.NumberFormat('id-ID').format(response
                        .grand_total || 0));

                    $('#penggunaan_items').empty();
                    if (response.items && response.items.length > 0) {
                        response.items.forEach(function(item) {
                            let penggunaanText = '-';
                            if (item.penggunaan_input_type === 'habis') {
                                penggunaanText = item.quantity_penggunaan + ' (habis)';
                            } else if (item.penggunaan_input_type === 'sisa') {
                                const sisa = item.quantity - item.quantity_penggunaan;
                                penggunaanText = item.quantity_penggunaan + ' (sisa ' + sisa.toFixed(2) + ')';
                            }

                            $('#penggunaan_items').append(
                                '<tr>' +
                                '<td>' + (item.bahan_baku?.nama || item.bahan_operasional?.nama) + '</td>' +
                                '<td>' + (item.satuan || '-') + '</td>' +
                                '<td>' + (item.quantity || 0) + '</td>' +
                                '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.unit_cost || 0) + '</td>' +
                                '<td>' + penggunaanText + '</td>' + // Added the Digunakan column
                                '<td>' + (item.notes_penggunaan || '-') + '</td>' + // Changed from item.notes to item.notes_penggunaan
                                '</tr>'
                            );
                        });
                    } else {
                        $('#penggunaan_items').append(
                            '<tr><td colspan="5" class="text-center">Tidak ada items</td></tr>');
                    }

                    $('#modalPenggunaanDetail').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengambil data'
                    });
                }
            });
        }
    </script>
@endpush
