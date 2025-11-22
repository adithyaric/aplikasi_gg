@extends('layouts.master')

@section('header')
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                        <h3>Pembayaran</h3>
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
                        <h4 class="card-title fw-bold">Pembayaran</h4>
                    </div>
                    <div id="statusButtons" role="group" aria-label="Tabs">
                        <button type="button" class="btn btn-primary rounded-pill active" data-status="all">All</button>
                        <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                            data-status="unpaid">Status Unpaid</button>
                        <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                            data-status="paid">Status Paid</button>
                        <button type="button" class="btn btn-white btn-outline-primary rounded-pill"
                            data-status="partial">Status Partial</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-datatable-entries table-responsive text-nowrap">
                        <table id="tablePayment" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No PO</th>
                                    <th>Pemasok</th>
                                    <th>Total Tagihan</th>
                                    <th>Dibayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr data-status="{{ $order->transaction?->status }}">
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->supplier->nama }}</td>
                                    <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($order->transaction?->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <h5>
                                            <span
                                                class="badge bg-{{ $order->transaction?->status == 'unpaid' ? 'danger' : ($order->transaction?->status == 'paid' ? 'success' : 'warning') }}">
                                                {{ ucfirst($order->transaction?->status) }}
                                            </span>
                                        </h5>
                                    </td>
                                    <td>
                                        @if ($order->transaction?->status == 'paid')
                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick="showPembayaranDetail({{ $order->id }})">
                                            Detail
                                        </button>
                                        @else
                                        <a href="{{ route('pembayaran.edit', $order->id) }}"
                                            class="btn btn-sm btn-success">
                                            Edit
                                        </a>
                                        @endif
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

<!-- Modal Detail Pembayaran -->
<div class="modal fade" id="modalPembayaranDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content"
            style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Data Pembayaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-2">
                    <div class="card-header d-flex justify-content-between border border-2 p-3 rounded-3">
                        <div class="d-flex flex-column">
                            <strong id="pembayaran_order_number"></strong>
                            <strong id="pembayaran_tanggal_terima"></strong>
                            <strong id="pembayaran_supplier"></strong>
                        </div>
                        <div class="ms-auto align-self-start">
                            <h5>
                                <span class="badge rounded" id="pembayaran_status_badge"></span>
                            </h5>
                        </div>
                    </div>
                    <div class="border border-2 p-3 rounded-3">
                        <div class="overflow-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bahan Baku</th>
                                        <th>Satuan</th>
                                        <th>Unit Cost</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="pembayaran_items"></tbody>
                            </table>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center py-2 px-3 border-bottom border-bottom-1">
                            <h5 class="fw-bold">Grand Total:</h5>
                            <h5 class="fw-bold" id="pembayaran_grand_total"></h5>
                        </div>
                        <div class="d-flex flex-column pt-2 pb-3 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Paid Amount:</strong>
                                <h5><span class="badge bg-success" id="pembayaran_paid_amount"></span></h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Outstanding Balance:</strong>
                                <h5><span class="badge bg-danger" id="pembayaran_outstanding"></span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="border border-2 d-flex flex-column gap-2 rounded-3 overflow-hidden"
                        id="pembayaran_transaction_section" style="display: none !important;">
                        <h4 class="fw-bold p-3 border-bottom border-bottom-1">Pembayaran</h4>
                        <div class="p-3">
                            <div class="form-group">
                                <label class="form-label">Tanggal Bayar</label>
                                <input type="text" class="form-control" id="pembayaran_payment_date" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Metode Pembayaran</label>
                                <input type="text" class="form-control" id="pembayaran_payment_method" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. Bukti / Referensi</label>
                                <input type="text" class="form-control" id="pembayaran_payment_reference" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bukti</label>
                                <a href="#" id="pembayaran_bukti_tarnsfer" target="_blank" rel="noopener noreferrer">-</a>
                                {{-- <input type="text" class="form-control" id="pembayaran_bukti_tarnsfer" disabled> --}}
                            </div>
                            <div class="form-group">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-control" id="pembayaran_notes" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jumlah Pembayaran</label>
                                <input type="text" class="form-control" id="pembayaran_amount" disabled>
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
    const table = $('#tablePayment').DataTable();

    $('#statusButtons button').on('click', function() {
        $('#statusButtons button').removeClass('active btn-primary').addClass('btn-white btn-outline-primary');
        $(this).removeClass('btn-white btn-outline-primary').addClass('active btn-primary');

        const status = $(this).data('status');
        if (status === 'all') {
            table.column(4).search('').draw();
        } else {
            table.column(4).search(status, false, false).draw();
        }
    });
});

function showPembayaranDetail(id) {
    $.ajax({
        url: "{{ route('orders.index') }}/" + id,
        method: 'GET',
        success: function(response) {
            $('#pembayaran_order_number').text(response.order_number);
            $('#pembayaran_tanggal_terima').text('Tanggal Terima: ' + (response.tanggal_penerimaan ? new Date(response.tanggal_penerimaan).toLocaleDateString('id-ID') : '-'));
            $('#pembayaran_supplier').text('Pemasok: ' + (response.supplier?.nama || '-'));

            const paymentStatus = response.transaction?.status;
            const badgeClass = paymentStatus == 'paid' ? 'bg-success' : 'bg-danger';
            $('#pembayaran_status_badge').removeClass().addClass('badge rounded ' + badgeClass).text(paymentStatus ? paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1) : 'Unpaid');

            $('#pembayaran_grand_total').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.grand_total || 0));
            $('#pembayaran_paid_amount').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.transaction?.amount || 0));
            $('#pembayaran_outstanding').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.grand_total - response.transaction?.amount  || 0));

            $('#pembayaran_items').empty();
            if (response.items && response.items.length > 0) {
                response.items.forEach(function(item) {
                    $('#pembayaran_items').append(
                        '<tr>' +
                        '<td>' + (item.bahan_baku?.nama || item.bahan_operasional?.nama) + '</td>' +
                        '<td>' + (item.satuan || '-') + '</td>' +
                        '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.unit_cost || 0) + '</td>' +
                        '<td>' + (item.quantity || 0) + '</td>' +
                        '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.subtotal || 0) + '</td>' +
                        '</tr>'
                    );
                });
            }

            if (response.transaction) {
                $('#pembayaran_transaction_section').show();
                $('#pembayaran_payment_date').val(response.transaction.payment_date ? new Date(response.transaction.payment_date).toLocaleDateString('id-ID') : '-');
                $('#pembayaran_payment_method').val(response.transaction.payment_method || '-');
                $('#pembayaran_payment_reference').val(response.transaction.payment_reference || '-');
                if (response.transaction.bukti_transfer) {
                    const url = "{{ Storage::url('') }}" + response.transaction.bukti_transfer;
                    $('#pembayaran_bukti_tarnsfer')
                        .attr('href', url)
                        .text('Lihat Bukti');
                } else {
                    $('#pembayaran_bukti_tarnsfer')
                        .attr('href', '#')
                        .text('-');
                }
                $('#pembayaran_notes').val(response.transaction.notes || 'Tidak ada catatan...');
                $('#pembayaran_amount').val('Rp ' + new Intl.NumberFormat('id-ID').format(response.transaction.amount || 0));
            } else {
                $('#pembayaran_transaction_section').hide();
            }

            $('#modalPembayaranDetail').modal('show');
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