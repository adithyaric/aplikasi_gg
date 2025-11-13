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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between flex-column gap-2">
                    <div class="header-title">
                        <h4 class="card-title fw-bold">Penerimaan Barang</h4>
                    </div>
                    <div id="statusButtons" role="group" aria-label="Tabs">
                        <button type="button" class="btn btn-primary rounded-pill active" data-status="all">All</button>
                        <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                            data-status="draft">Status Draft</button>
                        <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                            data-status="confirmed">Status Confirmed</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-datatable-entries">
                        <table id="tablePenerimaanBarang" class="table table-striped">
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
                                @foreach($orders as $order)
                                <tr data-status="{{ $order->status }}">
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->tanggal_penerimaan->format('d/m/Y') }}</td>
                                    <td>{{ $order->supplier->nama }}</td>
                                    <td>
                                        <h5>
                                            <span class="badge bg-{{ $order->status == 'draft' ? 'gray' : 'success' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </h5>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="showPenerimaanDetail({{ $order->id }})">
                                            Detail
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

<!-- Modal Detail Penerimaan -->
<div class="modal fade" id="modalPenerimaanDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"
            style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Data Penerimaan Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title" id="penerimaan_order_number"></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Diterima</label>
                                <div class="form-group input-group">
                                    <span class="input-group-text">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none">
                                            <path d="M3.09277 9.40421H20.9167" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="penerimaan_tanggal" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supplier</label>
                                <div class="form-group input-group">
                                    <span class="input-group-text">
                                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.59151 15.2068C13.2805 15.2068 16.4335 15.7658 16.4335 17.9988C16.4335 20.2318 13.3015 20.8068 9.59151 20.8068C5.90151 20.8068 2.74951 20.2528 2.74951 18.0188C2.74951 15.7848 5.88051 15.2068 9.59151 15.2068Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="penerimaan_supplier" disabled>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-horizontal" />
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-control" id="penerimaan_catatan"
                                    disabled>Tidak ada catatan...</textarea>
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
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="penerimaan_items"></tbody>
                            </table>
                            <div class="d-flex justify-content-end align-items-center mb-3">
                                <p class="h4">Subtotal: <span class="badge bg-success"
                                        id="penerimaan_grand_total"></span></p>
                            </div>
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
    const table = $('#tablePenerimaanBarang').DataTable();

    $('#statusButtons button').on('click', function() {
        $('#statusButtons button').removeClass('active btn-primary').addClass('btn-white btn-outline-primary');
        $(this).removeClass('btn-white btn-outline-primary').addClass('active btn-primary');

        const status = $(this).data('status');
        if (status === 'all') {
            table.column(3).search('').draw();
        } else {
            table.column(3).search(status, false, false).draw();
        }
    });
});

function showPenerimaanDetail(id) {
    $.ajax({
        url: "{{ route('orders.index') }}/" + id,
        method: 'GET',
        success: function(response) {
            $('#penerimaan_order_number').text(response.order_number);
            $('#penerimaan_tanggal').val(response.tanggal_penerimaan ? new Date(response.tanggal_penerimaan).toLocaleDateString('id-ID') : '-');
            $('#penerimaan_supplier').val(response.supplier?.nama || '-');
            $('#penerimaan_grand_total').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.grand_total || 0));

            $('#penerimaan_items').empty();
            if (response.items && response.items.length > 0) {
                response.items.forEach(function(item) {
                    $('#penerimaan_items').append(
                        '<tr>' +
                        '<td>' + (item.bahan_baku?.nama || '-') + '</td>' +
                        '<td>' + (item.satuan || '-') + '</td>' +
                        '<td>' + (item.quantity || 0) + '</td>' +
                        '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.unit_cost || 0) + '</td>' +
                        '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.subtotal || 0) + '</td>' +
                        '</tr>'
                    );
                });
            } else {
                $('#penerimaan_items').append('<tr><td colspan="5" class="text-center">Tidak ada items</td></tr>');
            }

            $('#modalPenerimaanDetail').modal('show');
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