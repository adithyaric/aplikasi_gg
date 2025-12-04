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
                            <h4 class="card-title">Formulir Alokasi</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('anggaran.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Rentang Periode</label>
                                    <input type="text" id="dateRange" class="form-control"
                                        placeholder="Pilih rentang tanggal" readonly />
                                    <input type="hidden" id="start_date" name="start_date" required>
                                    <input type="hidden" id="end_date" name="end_date" required>
                                </div>
                                {{-- <div class="form-group col-md-6"> --}}
                                {{-- <label class="form-label" for="sekolah_id">Sekolah</label> --}}
                                {{-- <select class="form-select" id="sekolah_id" name="sekolah_id" required> --}}
                                {{-- <option value="" disabled selected>Pilih Sekolah</option> --}}
                                {{-- @foreach ($sekolahs as $sekolah) --}}
                                {{-- <option value="{{ $sekolah->id }}" data-porsi8k="{{ $sekolah->porsi_8k }}" --}}
                                {{-- data-porsi10k="{{ $sekolah->porsi_10k }}"> --}}
                                {{-- {{ $sekolah->nama }} --}}
                                {{-- </option> --}}
                                {{-- @endforeach --}}
                                {{-- </select> --}}
                                {{-- </div> --}}
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="porsi_8k">Porsi 8k</label>
                                    <input type="number" min="0" value="{{ $total_porsi_8k }}" class="form-control"
                                        id="porsi_8k" name="porsi_8k" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="porsi_10k">Porsi 10k</label>
                                    <input type="number" min="0" value="{{ $total_porsi_10k }}" class="form-control"
                                        id="porsi_10k" name="porsi_10k" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="total_porsi">Total Porsi</label>
                                    <input type="number" min="0" class="form-control" id="total_porsi"
                                        name="total_porsi" disabled>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_porsi_8k">Budget Porsi 8k</label>
                                    <input type="text" class="form-control" id="budget_porsi_8k" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_porsi_10k">Budget Porsi 10k</label>
                                    <input type="text" class="form-control" id="budget_porsi_10k" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_operasional">Budget Operasional (3k)</label>
                                    <input type="text" class="form-control" id="budget_operasional" disabled>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="form-group col-md-4">
                                    <label class="form-label">Aturan Budget Sewa</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aturan_sewa" id="aturan_1"
                                            value="aturan_1"
                                            {{ $total_porsi_8k + $total_porsi_10k <= 3000 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aturan_1">
                                            Aturan 1: Porsi ≤ 3000 → Budget Sewa 2,000 × 3,000
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aturan_sewa" id="aturan_2"
                                            value="aturan_2"
                                            {{ $total_porsi_8k + $total_porsi_10k > 3000 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aturan_2">
                                            Aturan 2: Porsi > 3000 → Budget Sewa 2,000 × Total Porsi
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label" for="budget_sewa">Budget Sewa (2k)</label>
                                    <input type="text" class="form-control" id="budget_sewa" disabled>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('anggaran.index') }}" class="btn btn-secondary me-2">Batal</a>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Date range picker
            const dateRangeInput = document.getElementById('dateRange');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            const fp = flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "d/m/Y",
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        // Use the dateStr directly and parse it without Date object
                        const dates = dateStr.split(' to ');
                        if (dates.length === 2) {
                            // Convert d/m/Y to Y-m-d
                            const convertToYMD = (dateStr) => {
                                const [day, month, year] = dateStr.split('/');
                                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                            };

                            startDateInput.value = convertToYMD(dates[0]);
                            endDateInput.value = convertToYMD(dates[1]);
                        }
                    } else {
                        startDateInput.value = '';
                        endDateInput.value = '';
                    }
                }
            });
            const sekolahSelect = document.getElementById('sekolah_id');
            const porsi8kInput = document.getElementById('porsi_8k');
            const porsi10kInput = document.getElementById('porsi_10k');
            const totalPorsiInput = document.getElementById('total_porsi');
            const budgetPorsi8kInput = document.getElementById('budget_porsi_8k');
            const budgetPorsi10kInput = document.getElementById('budget_porsi_10k');
            const budgetOperasionalInput = document.getElementById('budget_operasional');
            const budgetSewaInput = document.getElementById('budget_sewa');
            const aturanSewaRadios = document.querySelectorAll('input[name="aturan_sewa"]');

            function formatCurrency(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            }

            function updateRadioButtons(totalPorsi) {
                const aturan1Radio = document.getElementById('aturan_1');
                const aturan2Radio = document.getElementById('aturan_2');

                if (totalPorsi > 3000) {
                    aturan2Radio.checked = true;
                    aturan1Radio.disabled = true;
                    aturan2Radio.disabled = false;
                } else {
                    // When total porsi ≤ 3000, enable both but keep aturan_1 checked by default
                    aturan1Radio.disabled = false;
                    aturan2Radio.disabled = false;

                    // Only auto-select aturan_1 if no manual selection was made
                    if (!aturan2Radio.checked) {
                        aturan1Radio.checked = true;
                    }
                }
            }

            function calculateBudget() {
                const porsi8k = parseInt(porsi8kInput.value) || 0;
                const porsi10k = parseInt(porsi10kInput.value) || 0;
                const totalPorsi = porsi8k + porsi10k;

                totalPorsiInput.value = totalPorsi;

                // Update radio buttons based on total porsi
                updateRadioButtons(totalPorsi);

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

                budgetPorsi8kInput.value = formatCurrency(budgetPorsi8k);
                budgetPorsi10kInput.value = formatCurrency(budgetPorsi10k);
                budgetOperasionalInput.value = formatCurrency(budgetOperasional);
                budgetSewaInput.value = formatCurrency(budgetSewa);
            }

            // Event listeners (remove sekolahSelect)
            porsi8kInput.addEventListener('input', calculateBudget);
            porsi10kInput.addEventListener('input', calculateBudget);
            aturanSewaRadios.forEach(radio => {
                radio.addEventListener('change', calculateBudget);
            });

            // Initial calculation
            calculateBudget();

            // Event listeners
            sekolahSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.dataset.porsi8k) {
                    porsi8kInput.value = selectedOption.dataset.porsi8k;
                    porsi10kInput.value = selectedOption.dataset.porsi10k;
                    calculateBudget();
                }
            });

            porsi8kInput.addEventListener('input', calculateBudget);
            porsi10kInput.addEventListener('input', calculateBudget);
            aturanSewaRadios.forEach(radio => {
                radio.addEventListener('change', calculateBudget);
            });

            // Initial calculation
            calculateBudget();
        });
    </script>
@endpush
