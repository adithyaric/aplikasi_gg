@extends('layouts.master')
@section('header')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h3>Purchase Order</h3>
                            <p>Makan Sehat Bergizi</p>
                        </div>
                        <div>
                            <a href="{{ route('orders.create') }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.5495 13.73H14.2624C14.6683 13.73 15.005 13.4 15.005 12.99C15.005 12.57 14.6683 12.24 14.2624 12.24H12.5495V10.51C12.5495 10.1 12.2228 9.77 11.8168 9.77C11.4109 9.77 11.0743 10.1 11.0743 10.51V12.24H9.37129C8.96535 12.24 8.62871 12.57 8.62871 12.99C8.62871 13.4 8.96535 13.73 9.37129 13.73H11.0743V15.46C11.0743 15.87 11.4109 16.2 11.8168 16.2C12.2228 16.2 12.5495 15.87 12.5495 15.46V13.73ZM19.3381 9.02561C19.5708 9.02292 19.8242 9.02 20.0545 9.02C20.302 9.02 20.5 9.22 20.5 9.47V17.51C20.5 19.99 18.5099 22 16.0446 22H8.17327C5.59901 22 3.5 19.89 3.5 17.29V6.51C3.5 4.03 5.5 2 7.96535 2H13.2525C13.5099 2 13.7079 2.21 13.7079 2.46V5.68C13.7079 7.51 15.203 9.01 17.0149 9.02C17.4381 9.02 17.8112 9.02316 18.1377 9.02593C18.3917 9.02809 18.6175 9.03 18.8168 9.03C18.9578 9.03 19.1405 9.02789 19.3381 9.02561ZM19.61 7.5662C18.7961 7.5692 17.8367 7.5662 17.1466 7.5592C16.0516 7.5592 15.1496 6.6482 15.1496 5.5422V2.9062C15.1496 2.4752 15.6674 2.2612 15.9635 2.5722C16.4995 3.1351 17.2361 3.90891 17.9693 4.67913C18.7002 5.44689 19.4277 6.21108 19.9496 6.7592C20.2387 7.0622 20.0268 7.5652 19.61 7.5662Z"
                                        fill="currentColor"></path>
                                </svg>
                                Tambah PO
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

    <!-- Modal Detail -->
    <div class="modal fade" id="modalOrderDetail" tabindex="-1" aria-labelledby="modalOrderDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content"
                style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalOrderDetailLabel">Detail Purchase Order</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No PO</label>
                                    <p id="detail_order_number" class="form-control-plaintext"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Supplier</label>
                                    <p id="detail_supplier" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal PO</label>
                                    <p id="detail_tanggal_po" class="form-control-plaintext"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Penerimaan</label>
                                    <p id="detail_tanggal_penerimaan" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Grand Total</label>
                                    <p id="detail_grand_total" class="form-control-plaintext"></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status</label>
                                    <p id="detail_status" class="form-control-plaintext"></p>
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label fw-bold">Items</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bahan Baku</th>
                                                <th>Quantity</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail_items"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('container')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bold">Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tableOrder">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No PO</th>
                                        <th>Tanggal PO</th>
                                        <th>Tanggal Penerimaan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->tanggal_po->formatId('d/m/Y') }}</td>
                                            <td>{{ $order->tanggal_penerimaan ? $order->tanggal_penerimaan->formatId('d/m/Y') : '-' }}
                                            </td>
                                            <td>{{ ucfirst($order->status) }}</td>
                                            <td>
                                                @if ($order->status == 'draft')
                                                    <a href="{{ route('orders.edit', $order->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        Edit
                                                    </a>

                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        onclick="postOrder({{ $order->id }})">
                                                        POST
                                                    </button>
                                                @endif
                                                {{-- @else --}}
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="showOrderDetail({{ $order->id }})">
                                                    <span class="btn-inner"><i class="bi bi-eye"></i> Detail</span>
                                                </button>
                                                {{-- @endif --}}
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="deleteData({{ $order->id }})">
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#tableOrder').DataTable();
        });

        function showOrderDetail(id) {
            $.ajax({
                url: "{{ route('orders.index') }}/" + id,
                method: 'GET',
                success: function(response) {
                    $('#detail_order_number').text(response.order_number);
                    $('#detail_supplier').text(response.supplier?.nama || '-');
                    $('#detail_tanggal_po').text(response.tanggal_po ? new Date(response.tanggal_po)
                        .toLocaleDateString('id-ID') : '-');
                    $('#detail_tanggal_penerimaan').text(response.tanggal_penerimaan ? new Date(response
                        .tanggal_penerimaan).toLocaleDateString('id-ID') : '-');
                    $('#detail_grand_total').text('Rp ' + new Intl.NumberFormat('id-ID').format(response
                        .grand_total || 0));
                    $('#detail_status').text(response.status || '-');

                    // Clear items table
                    $('#detail_items').empty();

                    // Populate items
                    if (response.items && response.items.length > 0) {
                        response.items.forEach(function(item) {
                            $('#detail_items').append(
                                '<tr>' +
                                '<td>' + (item.bahan_baku?.nama || item.bahan_operasional?.nama) +
                                '</td>' +
                                '<td>' + (item.quantity || 0) + '</td>' +
                                '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.unit_cost ||
                                    0) + '</td>' +
                                '<td>Rp ' + new Intl.NumberFormat('id-ID').format(item.subtotal ||
                                    0) + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        $('#detail_items').append(
                            '<tr><td colspan="4" class="text-center">Tidak ada items</td></tr>');
                    }

                    $('#modalOrderDetail').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengambil data detail'
                    });
                }
            });
        }

        function postOrder(id) {
            Swal.fire({
                title: 'Post order?',
                text: 'Status akan diubah menjadi POSTED',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/orders/" + id + "/topost",
                        method: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                            });
                        }
                    });
                }
            });
        }

        function deleteData(id) {
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
                        url: "{{ route('orders.index') }}/" + id,
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
                                title: 'Error!',
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
@endpush
