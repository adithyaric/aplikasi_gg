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
                                        <a href="{{ route('pembayaran.edit', $order->id) }}"
                                            class="btn btn-sm btn-success">
                                            <span class="btn-inner">
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.3764 20.0279L18.1628 8.66544C18.6403 8.0527 18.8101 7.3443 18.6509 6.62299C18.513 5.96726 18.1097 5.34377 17.5049 4.87078L16.0299 3.69906C14.7459 2.67784 13.1541 2.78534 12.2415 3.95706L11.2546 5.23735C11.1273 5.39752 11.1591 5.63401 11.3183 5.76301C11.3183 5.76301 13.812 7.76246 13.8651 7.80546C14.0349 7.96671 14.1622 8.1817 14.1941 8.43969C14.2471 8.94493 13.8969 9.41792 13.377 9.48242C13.1329 9.51467 12.8994 9.43942 12.7297 9.29967L10.1086 7.21422C9.98126 7.11855 9.79025 7.13898 9.68413 7.26797L3.45514 15.3303C3.0519 15.8355 2.91395 16.4912 3.0519 17.1255L3.84777 20.5761C3.89021 20.7589 4.04939 20.8879 4.24039 20.8879L7.74222 20.8449C8.37891 20.8341 8.97316 20.5439 9.3764 20.0279ZM14.2797 18.9533H19.9898C20.5469 18.9533 21 19.4123 21 19.9766C21 20.5421 20.5469 21 19.9898 21H14.2797C13.7226 21 13.2695 20.5421 13.2695 19.9766C13.2695 19.4123 13.7226 18.9533 14.2797 18.9533Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick="showPembayaranDetail({{ $order->id }})">
                                            <i class="bi bi-eye"></i> Detail
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

                    <div class="mb-1" id="payment_history_section" style="display:none;">
                        <label class="form-label fw-bold">Riwayat Perubahan</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody id="payment_history"></tbody>
                            </table>
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
                    const url = "{{ Storage::disk('uploads')->url('') }}" + response.transaction.bukti_transfer;
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

                // Populate payment history
                $('#payment_history').empty();
                if (response.transaction?.activities && response.transaction.activities.length > 0) {
                    $('#payment_history_section').show();

                    response.transaction.activities.forEach(function(activity, index) {
                        const props = activity.properties;
                        const createdAt = activity.created_at ? new Date(activity.created_at)
                            .toLocaleString('id-ID') : '-';

                        let changes = [];
                        const trackedFields = {
                            'payment_date': 'Tanggal Bayar',
                            'payment_method': 'Metode Pembayaran',
                            'payment_reference': 'No. Bukti/Referensi',
                            'status': 'Status',
                            'amount': 'Jumlah Pembayaran',
                            'bukti_transfer': 'Bukti Transfer',
                            'notes': 'Catatan'
                        };

                        if (props.old && props.attributes) {
                            Object.keys(trackedFields).forEach(field => {
                                if (props.old[field] !== props.attributes[field]) {
                                    if (field === 'payment_date') {
                                        const oldValue = props.old[field] ? new Date(props.old[field]).toLocaleDateString('id-ID') : '-';
                                        const newValue = props.attributes[field] ? new Date(props.attributes[field]).toLocaleDateString('id-ID') : '-';
                                        changes.push(`${trackedFields[field]}: ${oldValue} → ${newValue}`);
                                        return;
                                    }
                                    if (field === 'bukti_transfer') {
                                        const oldBukti = props.old[field];
                                        const newBukti = props.attributes[field];
                                        let buktiChange = [];

                                        // if (oldBukti) buktiChange.push(`Bukti Lama: <a href="uploads/${oldBukti}" target="_blank">Lihat</a>`);
                                        if (newBukti) buktiChange.push(`Bukti: <a href="uploads/${newBukti}" target="_blank">Lihat</a>`);

                                        if (buktiChange.length) changes.push(buktiChange.join(' → '));
                                    } else {
                                        const oldValue = props.old[field] || '-';
                                        const newValue = props.attributes[field] || '-';
                                        changes.push(`${trackedFields[field]}: ${oldValue} → ${newValue}`);
                                    }
                                }
                            });
                        }

                        let row = '<tr>' +
                            '<td>' + createdAt + '</td>' +
                            '<td>' + (changes.length > 0 ? changes.join('<br>') : '-') + '</td>' +
                            '</tr>';

                        $('#payment_history').append(row);
                    });
                } else {
                    $('#payment_history_section').hide();
                }

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