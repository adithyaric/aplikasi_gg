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
                            <a href="{{ route('anggaran.index') }}" class="btn btn-link btn-soft-light">
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Anggaran</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('anggaran.update', $anggaran->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Rentang Periode</label>
                                    <input type="text" id="dateRange" class="form-control"
                                        placeholder="Pilih rentang tanggal" readonly
                                        value="{{ \Carbon\Carbon::parse($anggaran->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($anggaran->end_date)->format('d/m/Y') }}" />
                                    <input type="hidden" id="start_date" name="start_date"
                                        value="{{ $anggaran->start_date }}">
                                    <input type="hidden" id="end_date" name="end_date" value="{{ $anggaran->end_date }}">
                                </div>
                                {{-- <div class="form-group col-md-6"> --}}
                                    {{-- <label class="form-label" for="sekolah_id">Sekolah</label> --}}
                                    {{-- <select class="form-select" id="sekolah_id" name="sekolah_id" required disabled> --}}
                                        {{-- <option value="" disabled>Pilih Sekolah</option> --}}
                                        {{-- @foreach ($sekolahs as $sekolah) --}}
                                            {{-- <option value="{{ $sekolah->id }}" data-porsi8k="{{ $sekolah->porsi_8k }}" --}}
                                                {{-- data-porsi10k="{{ $sekolah->porsi_10k }}" --}}
                                                {{-- {{ $anggaran->sekolah_id == $sekolah->id ? 'selected' : '' }}> --}}
                                                {{-- {{ $sekolah->nama }} --}}
                                            {{-- </option> --}}
                                        {{-- @endforeach --}}
                                    {{-- </select> --}}
                                {{-- </div> --}}
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="porsi_8k">Porsi 8k</label>
                                    <input type="number" min="0" class="form-control" id="porsi_8k" name="porsi_8k"
                                        value="{{ $anggaran->porsi_8k }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="porsi_10k">Porsi 10k</label>
                                    <input type="number" min="0" class="form-control" id="porsi_10k" name="porsi_10k"
                                        value="{{ $anggaran->porsi_10k }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="total_porsi">Total Porsi</label>
                                    <input type="number" min="0" class="form-control" id="total_porsi" name="total_porsi"
                                        value="{{ $anggaran->total_porsi }}" disabled>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_porsi_8k">Budget Porsi 8k</label>
                                    <input type="text" class="form-control" id="budget_porsi_8k"
                                        value="Rp {{ number_format($anggaran->budget_porsi_8k, 0, ',', '.') }}" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_porsi_10k">Budget Porsi 10k</label>
                                    <input type="text" class="form-control" id="budget_porsi_10k"
                                        value="Rp {{ number_format($anggaran->budget_porsi_10k, 0, ',', '.') }}" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_operasional">Budget Operasional (3k)</label>
                                    <input type="text" class="form-control" id="budget_operasional"
                                        value="Rp {{ number_format($anggaran->budget_operasional, 0, ',', '.') }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="form-label">Aturan Budget Sewa</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aturan_sewa" id="aturan_1"
                                            value="aturan_1" {{ $anggaran->aturan_sewa == 'aturan_1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aturan_1">
                                            Aturan 1: Porsi ≤ 3000 → Budget Sewa 2,000 × 3,000
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aturan_sewa" id="aturan_2"
                                            value="aturan_2" {{ $anggaran->aturan_sewa == 'aturan_2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aturan_2">
                                            Aturan 2: Porsi > 3000 → Budget Sewa 2,000 × Total Porsi
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_sewa">Budget Sewa (2k)</label>
                                    <input type="text" class="form-control" id="budget_sewa"
                                        value="Rp {{ number_format($anggaran->budget_sewa, 0, ',', '.') }}" disabled>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('anggaran.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Date range picker
            const dateRangeInput = document.getElementById('dateRange');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Format dates for display
            const formatDateForDisplay = (dateStr) => {
                const [year, month, day] = dateStr.split('-');
                return `${day}/${month}/${year}`;
            };

            const fp = flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "d/m/Y",
                allowInput: true,
                defaultDate: [
                    formatDateForDisplay(startDateInput.value),
                    formatDateForDisplay(endDateInput.value)
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        // Format dates as YYYY-MM-DD without timezone conversion
                        const formatDateForStorage = (date) => {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const day = String(date.getDate()).padStart(2, '0');
                            return `${year}-${month}-${day}`;
                        };

                        startDateInput.value = formatDateForStorage(selectedDates[0]);
                        endDateInput.value = formatDateForStorage(selectedDates[1]);
                    }
                }
            });

            function formatCurrency(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            }

            function calculateBudget() {
                const porsi8k = parseInt(document.getElementById('porsi_8k').value) || 0;
                const porsi10k = parseInt(document.getElementById('porsi_10k').value) || 0;
                const totalPorsi = porsi8k + porsi10k;

                document.getElementById('total_porsi').value = totalPorsi;

                const budgetPorsi8k = porsi8k * 8000;
                const budgetPorsi10k = porsi10k * 10000;
                const budgetOperasional = totalPorsi * 3000;

                const aturanSewa = document.querySelector('input[name="aturan_sewa"]:checked').value;
                let budgetSewa;

                if (aturanSewa === 'aturan_1') {
                    budgetSewa = 2000 * 3000;
                } else {
                    budgetSewa = 2000 * totalPorsi;
                }

                document.getElementById('budget_porsi_8k').value = formatCurrency(budgetPorsi8k);
                document.getElementById('budget_porsi_10k').value = formatCurrency(budgetPorsi10k);
                document.getElementById('budget_operasional').value = formatCurrency(budgetOperasional);
                document.getElementById('budget_sewa').value = formatCurrency(budgetSewa);
            }

            document.getElementById('porsi_8k').addEventListener('input', calculateBudget);
            document.getElementById('porsi_10k').addEventListener('input', calculateBudget);
            document.querySelectorAll('input[name="aturan_sewa"]').forEach(radio => {
                radio.addEventListener('change', calculateBudget);
            });
        });
    </script>
@endpush
