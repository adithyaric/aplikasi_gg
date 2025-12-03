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
                            <h4 class="card-title fw-bold">Stok Opname</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5><strong>STOK OPNAME</strong></h5>
                        </div>

                        <!-- 🔹 Input Identitas Bahan -->
                        <table class="table table-borderless mb-2" style="width: 40%">
                            <tr>
                                <td>Tanggal Stok Opname</td>
                                <td> :
                                    <input type="date" id="tglStockOpname" class="form-control d-inline-block"
                                        style="width: 100%" value="{{ date('Y-m-d') }}" />
                                </td>
                            </tr>
                        </table>

                        <!-- 🔹 Tabel Stock Opname -->
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Kode</th>
                                        <th>Satuan</th>
                                        <th>Stok Fisik</th>
                                        <th>Stok di Kartu</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="tableBody"></tbody>
                            </table>
                        </div>
                        <!-- Tombol Tambah -->
                        <div class="text-end mt-1 d-flex justify-content-between">
                            <button id="tambahBaris" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Baris
                            </button>
                            <button class="btn btn-success" id="btnSaveOpname">
                                <i class="bi bi-save"></i> Save Stok Opname
                            </button>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalCetakKartu">
                                <i class="bi bi-printer"></i> Cetak Stok Opname
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔶 Modal Cetak Kartu Stok -->
    <div class="modal fade" id="modalCetakKartu" tabindex="-1" aria-labelledby="modalCetakKartuLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content p-4">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-printer-fill"></i> Cetak Stok Opname
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Area Cetak -->
                    <div id="printArea">
                        <div class="text-center mb-4">
                            <h5><strong>STOK OPNAME</strong></h5>
                        </div>

                        <!-- Identitas Stock Opname-->
                        <table class="table table-borderless mb-2" style="width: 60%">
                            <tr>
                                <td style="width: 30%">Nama SPG</td>
                                <td>: <span>03 Mandai</span></td>
                            </tr>
                            <tr>
                                <td>Kelurahan / Desa</td>
                                <td>: <span>Bontoa</span></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>: <span>Mandai</span></td>
                            </tr>
                            <tr>
                                <td>Kabupaten / Kota</td>
                                <td>: <span>Maros</span></td>
                            </tr>
                            <tr>
                                <td>Provinsi</td>
                                <td>: <span>Sulawesi Selatan</span></td>
                            </tr>
                            <tr>
                                <td>Tanggal Stok Opname</td>
                                <td>: <span id="printTglStockOpname">-</span></td>
                            </tr>
                        </table>

                        <!-- Tabel Format Cetak -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center" id="tabelCetak">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Kode</th>
                                        <th>Satuan</th>
                                        <th>Stok Fisik</th>
                                        <th>Stok di Kartu</th>
                                        <th>Selisih</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Footer Tanda Tangan -->
                        <div class="row mt-5">
                            <div class="col-6 text-center">
                                <p>Mengetahui,</p>
                                <p class="mt-5 mb-0 fw-bold">______________________</p>
                                <small>Kepala SPPG</small>
                            </div>
                            <div class="col-6 text-center">
                                <p id="tanggalCetak"></p>
                                <p class="mt-5 mb-0 fw-bold">______________________</p>
                                <small>Akuntan SPPG</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                    <button class="btn btn-warning" id="btnCetakNow">
                        <i class="bi bi-printer-fill"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let allStokData = [];

        document.addEventListener("DOMContentLoaded", function() {
            const tableBody = document.getElementById("tableBody");
            const tambahBarisBtn = document.getElementById("tambahBaris");
            const tabelCetakBody = document.querySelector("#tabelCetak tbody");
            const tanggalCetak = document.getElementById("tanggalCetak");

            // Load stock data on page load
            loadStokData();

            function loadStokData() {
                fetch('{{ route('stok.opname.data') }}')
                    .then(response => response.json())
                    .then(data => {
                        allStokData = data.stok;
                        renderInitialRows();
                    })
                    .catch(error => {
                        console.error('Error loading stock data:', error);
                    });
            }

            function renderInitialRows() {
                tableBody.innerHTML = '';
                allStokData.forEach((item, index) => {
                    const newRow = document.createElement("tr");
                    newRow.innerHTML = `
                        <td>${index + 1}</td>
                        <td><input type="text" class="form-control nama-bahan" value="${item.nama}" data-id="${item.id}" data-type="${item.type}" disabled /></td>
                        <td><input type="text" class="form-control kode" value="${item.id}" disabled /></td>
                        <td><input type="text" class="form-control satuan" value="${item.satuan}" disabled /></td>
                        <td><input type="number" step="0.01" class="form-control stock_fisik" value="${item.qty}" /></td>
                        <td><input type="number" class="form-control stock_dikartu" value="${item.qty}" disabled /></td>
                        <td><input type="number" step="0.01" class="form-control selisih" value="0" disabled /></td>
                        <td><input type="text" class="form-control keterangan" /></td>
                    `;
                    tableBody.appendChild(newRow);
                });

                attachEventListeners();
            }

            function attachEventListeners() {
                // Calculate selisih on stock_fisik change
                tableBody.querySelectorAll('.stock_fisik').forEach(input => {
                    input.addEventListener('input', function() {
                        const row = this.closest('tr');
                        const stockFisik = parseFloat(this.value) || 0;
                        const stockKartu = parseFloat(row.querySelector('.stock_dikartu').value) ||
                            0;
                        const selisih = (stockFisik - stockKartu).toFixed(2);
                        row.querySelector('.selisih').value = selisih;
                    });
                });
            }

            function updateNomorUrut() {
                const rows = tableBody.querySelectorAll("tr");
                rows.forEach((row, index) => {
                    row.querySelector("td:first-child").textContent = index + 1;
                });
            }

            function buatBarisBaru() {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
        <td></td>
        <td>
            <select class="form-control select-bahan">
                <option value="">-- Pilih Bahan --</option>
                @foreach ($bahans as $bahan)
                    <option value="{{ $bahan['id'] }}" data-type="{{ $bahan['type'] }}" data-satuan="{{ $bahan['satuan'] }}" data-qty="">{{ $bahan['nama'] }} ({{ $bahan['type'] === 'bahan_baku' ? 'Bahan Baku' : 'Bahan Operasional' }})</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control kode" disabled /></td>
        <td><input type="text" class="form-control satuan" disabled /></td>
        <td><input type="number" step="0.01" class="form-control stock_fisik" value="0" /></td>
        <td><input type="number" class="form-control stock_dikartu" disabled /></td>
        <td><input type="number" step="0.01" class="form-control selisih" disabled /></td>
        <td><input type="text" class="form-control keterangan" /></td>
    `;
                tableBody.appendChild(newRow);
                updateNomorUrut();

                // Handle select change
                const selectBahan = newRow.querySelector('.select-bahan');
                selectBahan.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const row = this.closest('tr');
                    const bahanId = this.value;
                    const bahanType = selected.dataset.type;

                    if (bahanId) {
                        // Find stock quantity from allStokData
                        const stokItem = allStokData.find(s => s.id == bahanId && s.type === bahanType);
                        const stockQty = stokItem ? stokItem.qty : 0;

                        row.querySelector('.kode').value = bahanId;
                        row.querySelector('.satuan').value = selected.dataset.satuan || '';
                        row.querySelector('.stock_dikartu').value = stockQty;
                        row.querySelector('.stock_fisik').value = stockQty;

                        const stockFisik = parseFloat(row.querySelector('.stock_fisik').value) || 0;
                        row.querySelector('.selisih').value = (stockFisik - stockQty).toFixed(2);
                    }
                });

                // Attach stock_fisik listener
                const stockFisikInput = newRow.querySelector('.stock_fisik');
                stockFisikInput.addEventListener('input', function() {
                    const row = this.closest('tr');
                    const stockFisik = parseFloat(this.value) || 0;
                    const stockKartu = parseFloat(row.querySelector('.stock_dikartu').value) || 0;
                    const selisih = (stockFisik - stockKartu).toFixed(2);
                    row.querySelector('.selisih').value = selisih;
                });
            }

            tambahBarisBtn.addEventListener("click", function(e) {
                e.preventDefault();
                buatBarisBaru();
            });

            document.getElementById("btnSaveOpname").addEventListener("click", function() {
                const tglStockOpname = document.getElementById("tglStockOpname").value;

                if (!tglStockOpname) {
                    alert('Tanggal Stok Opname harus diisi!');
                    return;
                }

                const rows = tableBody.querySelectorAll("tr");
                let items = [];

                rows.forEach((row) => {
                    const namaBahanInput = row.querySelector("td:nth-child(2) input");
                    const namaBahanSelect = row.querySelector("td:nth-child(2) select");

                    let bahanId = row.querySelector(".kode").value.trim();
                    let bahanType = '';

                    if (namaBahanInput) {
                        bahanType = namaBahanInput.dataset.type;
                    } else if (namaBahanSelect && namaBahanSelect.value) {
                        bahanId = namaBahanSelect.value;
                        bahanType = namaBahanSelect.options[namaBahanSelect.selectedIndex].dataset.type;
                    }

                    const selisih = parseFloat(row.querySelector(".selisih").value) || 0;
                    const keterangan = row.querySelector(".keterangan").value.trim();

                    if (bahanId && selisih !== 0) {
                        items.push({
                            bahan_id: bahanId,
                            type: bahanType,
                            selisih: selisih,
                            keterangan: keterangan
                        });
                    }
                });

                if (items.length === 0) {
                    alert('Tidak ada perubahan stok untuk disimpan!');
                    return;
                }

                if (!confirm(`Simpan ${items.length} penyesuaian stok?`)) {
                    return;
                }

                fetch('{{ route('stok.opname.save') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        adjustment_date: tglStockOpname,
                        items: items
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Stok opname berhasil disimpan!');
                        location.reload();
                    } else {
                        alert('Gagal menyimpan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
            });

            // Modal print logic
            const btnModalCetak = document.querySelector('[data-bs-target="#modalCetakKartu"]');
            btnModalCetak.addEventListener("click", function() {
                const tglStockOpname = document.getElementById("tglStockOpname").value || "-";

                document.getElementById("printTglStockOpname").textContent = tglStockOpname !== "-" ?
                    new Date(tglStockOpname).toLocaleDateString("id-ID", {
                        day: "2-digit",
                        month: "long",
                        year: "numeric",
                    }) : "-";

                tabelCetakBody.innerHTML = "";
                const rows = tableBody.querySelectorAll("tr");
                let dataKosong = true;

                rows.forEach((row, index) => {
                    const namaBahanInput = row.querySelector("td:nth-child(2) input");
                    const namaBahanSelect = row.querySelector("td:nth-child(2) select");

                    let namaBahan = '';
                    if (namaBahanInput) {
                        namaBahan = namaBahanInput.value.trim();
                    } else if (namaBahanSelect) {
                        namaBahan = namaBahanSelect.options[namaBahanSelect.selectedIndex]?.text ||
                            '';
                    }

                    const kode = row.querySelector("td:nth-child(3) input").value.trim();
                    const satuan = row.querySelector("td:nth-child(4) input").value.trim();
                    const stockFisik = row.querySelector("td:nth-child(5) input").value.trim();
                    const stockKartu = row.querySelector("td:nth-child(6) input").value.trim();
                    const selisih = row.querySelector("td:nth-child(7) input").value.trim();
                    const keterangan = row.querySelector("td:nth-child(8) input").value.trim();

                    if (namaBahan || kode || stockFisik || stockKartu || selisih || keterangan) {
                        dataKosong = false;
                        const cetakRow = document.createElement("tr");
                        cetakRow.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${namaBahan || "-"}</td>
                            <td>${kode || "-"}</td>
                            <td>${satuan || "-"}</td>
                            <td>${stockFisik || "-"}</td>
                            <td>${stockKartu || "-"}</td>
                            <td>${selisih || "-"}</td>
                            <td>${keterangan || "-"}</td>
                        `;
                        tabelCetakBody.appendChild(cetakRow);
                    }
                });

                if (dataKosong) {
                    const noDataRow = document.createElement("tr");
                    noDataRow.innerHTML =
                        `<td colspan="8" class="text-center text-muted">Tidak ada data untuk dicetak</td>`;
                    tabelCetakBody.appendChild(noDataRow);
                }

                const today = new Date();
                const formattedDate = today.toLocaleDateString("id-ID", {
                    day: "2-digit",
                    month: "long",
                    year: "numeric",
                });
                tanggalCetak.textContent = `Pacitan, ${formattedDate}`;
            });

            document.getElementById("btnCetakNow").addEventListener("click", function() {
                const printContent = document.getElementById("printArea").outerHTML;
                const printWindow = window.open("", "_blank", "width=1000,height=800");

                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Cetak Stok Opname</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { font-family: 'Segoe UI', sans-serif; font-size: 13px; margin: 20px; }
                                table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
                                th, td { padding: 6px; vertical-align: middle; font-size: 12px; }
                                thead { display: table-header-group; }
                                tr { page-break-inside: avoid; page-break-after: auto; }
                                h5 { margin-bottom: 15px; }
                                @page { size: A4 landscape; margin: 12mm; }
                                @media print { body { -webkit-print-color-adjust: exact; } }
                            </style>
                        </head>
                        <body>${printContent}</body>
                    </html>
                `);

                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 800);
            });
        });
    </script>
@endpush
