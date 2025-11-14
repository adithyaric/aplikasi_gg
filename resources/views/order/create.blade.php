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
                        <div>
                            <a href="{{ route('orders.index') }}" class="btn btn-link btn-soft-light">
                                <svg class="icon-32" width="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4"
                                        d="M16.084 2L7.916 2C4.377 2 2 4.276 2 7.665L2 16.335C2 19.724 4.377 22 7.916 22L16.084 22C19.622 22 22 19.723 22 16.334L22 7.665C22 4.276 19.622 2 16.084 2Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M11.1445 7.72082L7.37954 11.4688C7.09654 11.7508 7.09654 12.2498 7.37954 12.5328L11.1445 16.2808C11.4385 16.5728 11.9135 16.5718 12.2055 16.2778C12.4975 15.9838 12.4975 15.5098 12.2035 15.2168L9.72654 12.7498H16.0815C16.4965 12.7498 16.8315 12.4138 16.8315 11.9998C16.8315 11.5858 16.4965 11.2498 16.0815 11.2498L9.72654 11.2498L12.2035 8.78382C12.3505 8.63682 12.4235 8.44482 12.4235 8.25182C12.4235 8.06082 12.3505 7.86882 12.2055 7.72282C11.9135 7.42982 11.4385 7.42882 11.1445 7.72082Z"
                                        fill="currentColor"></path>
                                </svg>
                                Kembali
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
            <div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
        </div>
        <div class="card-body">
            <form id="orderForm">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Pemasok *</label>
                        <select name="supplier_id" class="form-select shadow-none" required>
                            <option value="">-- Pilih Pemasok --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label class="form-label">Tanggal PO *</label>
                        <input type="date" name="tanggal_po" class="form-control" required />
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label">Tanggal Penerimaan *</label>
                        <input type="date" name="tanggal_penerimaan" class="form-control" required />
                    </div>
                </div>

                <hr class="hr-horizontal" />
                <h5>Bahan Baku</h5>

                <div id="itemContainer">
                    <div class="row itemRow align-items-end mb-3">
                        <div class="form-group col-4">
                            <label class="form-label">Jenis Bahan Pokok *</label>
                            <select name="items[0][bahan_baku_id]" class="form-select shadow-none bahan-select" required>
                                <option value="">Pilih Bahan Pokok</option>
                                @foreach ($bahanbakus as $bahan)
                                    <option value="{{ $bahan->id }}" data-satuan="{{ $bahan->satuan }}">
                                        {{ $bahan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label class="form-label">Quantity *</label>
                            <input type="number" name="items[0][quantity]" class="form-control quantity-input"
                                step="0.01" min="0.01" required />
                        </div>
                        <div class="form-group col-2">
                            <label class="form-label">Satuan *</label>
                            <input type="text" name="items[0][satuan]" class="form-control satuan-input" readonly
                                required />
                        </div>
                        <div class="form-group col-3">
                            <label class="form-label">Harga *</label>
                            <input type="number" name="items[0][unit_cost]" class="form-control price-input" step="0.01"
                                min="0" required />
                        </div>
                        <div class="form-group col-1">
                            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                        </div>
                    </div>
                </div>

                <hr class="hr-horizontal mb-4" />

                <div class="row mb-3">
                    <div class="col-md-9 text-end">
                        <h6 class="fw-bold">Total Harga:</h6>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="totalHarga" class="form-control text-end fw-bold" value="Rp 0"
                            disabled />
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-primary" id="tambah-item">
                        <i class="bi bi-plus-circle"></i> Tambah Item
                    </button>
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
        let itemIndex = 1;
        const bahanbakus = @json($bahanbakus);

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        function calculateTotal() {
            let total = 0;
            $('.itemRow').each(function() {
                const qty = parseFloat($(this).find('.quantity-input').val()) || 0;
                const price = parseFloat($(this).find('.price-input').val()) || 0;
                total += qty * price;
            });
            $('#totalHarga').val(formatRupiah(total));
        }

        function createItemRow(index) {
            let options = '<option value="">Pilih Bahan Pokok</option>';
            bahanbakus.forEach(bahan => {
                options += `<option value="${bahan.id}" data-satuan="${bahan.satuan}">${bahan.nama}</option>`;
            });

            return `
            <div class="row itemRow align-items-end mb-3">
                <div class="form-group col-4">
                    <label class="form-label">Jenis Bahan Pokok *</label>
                    <select name="items[${index}][bahan_baku_id]" class="form-select shadow-none bahan-select" required>
                        ${options}
                    </select>
                </div>
                <div class="form-group col-2">
                    <label class="form-label">Quantity *</label>
                    <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" step="0.01" min="0.01" required />
                </div>
                <div class="form-group col-2">
                    <label class="form-label">Satuan *</label>
                    <input type="text" name="items[${index}][satuan]" class="form-control satuan-input" readonly required />
                </div>
                <div class="form-group col-3">
                    <label class="form-label">Harga *</label>
                    <input type="number" name="items[${index}][unit_cost]" class="form-control price-input" step="0.01" min="0" required />
                </div>
                <div class="form-group col-1">
                    <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                </div>
            </div>
        `;
        }

        $('#tambah-item').click(function() {
            $('#itemContainer').append(createItemRow(itemIndex));
            itemIndex++;
        });

        $(document).on('click', '.removeRow', function() {
            if ($('.itemRow').length > 1) {
                $(this).closest('.itemRow').remove();
                calculateTotal();
            } else {
                alert('Minimal harus ada 1 item');
            }
        });

        $(document).on('change', '.bahan-select', function() {
            const satuan = $(this).find(':selected').data('satuan');
            $(this).closest('.itemRow').find('.satuan-input').val(satuan || '');
        });

        $(document).on('input', '.quantity-input, .price-input', function() {
            calculateTotal();
        });

        $('#orderForm').submit(function(e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: '{{ route('orders.store') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = '{{ route('orders.index') }}';
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
