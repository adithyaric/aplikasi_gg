<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SPKT | POLRES PACITAN</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-bgn.png') }}">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">

    <!-- Aos Animation Css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/dist/aos.css') }}">

    <!-- BGN Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=5.0.0') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=5.0.0') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.min.css?v=5.0.0') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.min.css?v=5.0.0') }}">


</head>

<body class="   boxed-fancy">
    <div class="boxed-inner">
        <!-- loader Start -->
        <div id="loading">
            <div class="loader simple-loader">
                <div class="loader-body">
                </div>
            </div>
        </div>
        <!-- loader END -->
        <span class="screen-darken"></span>
        <main class="main-content">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar">
                <div class="container-fluid navbar-inner custom-navbar-inner">
                    <button data-trigger="navbar_main" class="d-xl-none btn btn-primary rounded-pill p-1 pt-0" type="button">
                        <svg class="icon-20" width="20px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                        </svg>
                    </button>
                    <a href="/" class="logo-center navbar-horizontal-brand navbar-brand d-flex justify-content-center align-items-center">
                        <!--Logo start-->

                        <!--Logo start-->
                        <div class="logo-main">
                            <div class="logo-normal">
                                <img src="{{ asset('assets/images/logo-bgn.png') }}" width="50px" alt="logo-polri" class="img-fluid">
                            </div>
                            <div class="logo-mini">
                                <img src="{{ asset('assets/images/logo-bgn.png') }}" width="50px" alt="logo-polri" class="img-fluid">
                            </div>
                        </div>
                        <!--logo End-->

                        <!--logo End-->
                        <h4 class="logo-title">POLRES PACITAN</h4>
                    </a>
                    <!-- Horizontal Menu Start -->
                    <nav id="navbar_main" class="mobile-offcanvas nav navbar navbar-expand-xl hover-nav horizontal-nav mx-md-auto">
                        <div class="container-fluid">
                            <div class="offcanvas-header px-0">
                                <a href="/" class="navbar-brand ms-3">

                                    <!--Logo start-->
                                    <div class="logo-main">
                                        <div class="logo-normal">
                                            <img src="{{ asset('assets/images/logo-bgn.png') }}" width="50px" alt="logo-polri" class="img-fluid">
                                        </div>
                                        <div class="logo-mini">
                                            <img src="{{ asset('assets/images/logo-bgn.png') }}" width="50px" alt="logo-polri" class="img-fluid">
                                        </div>
                                    </div>
                                    <!--logo End-->

                                    <h4 class="logo-title">POLRES PACITAN</h4>
                                </a>
                                <!-- <button class="btn-close float-end"></button> -->
                            </div>

                        </div> <!-- container-fluid.// -->
                    </nav>
                    <!-- Sidebar Menu End -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link py-0 d-flex align-items-center" href="/">
                                    <button class="btn btn-secondary">Kembali Ke Beranda</button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav> <!--Nav End-->

            <div class="conatiner-fluid content-inner pb-0">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h5 class="card-title text-center">
                                    Survey Kepuasan Masyarakat (SKM) POLRES PACITAN
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 col-lg-12">
                                <form id="form-wizard1" class="mt-3 text-center" method="POST" action="{{ route('survey.submit') }}">
                                    @csrf

                                    <!-- Step Navigation -->
                                    <ul id="top-tab-list" class="p-0 row list-inline">
                                        <li class="mb-2 col-lg-3 col-md-6 text-start active" id="kategori">
                                            <a href="javascript:void(0);">
                                                <div class="iq-icon me-3">
                                                    <i class="bi bi-list-check"></i>
                                                </div>
                                                <span class="dark-wizard">Kategori</span>
                                            </a>
                                        </li>
                                        <li id="paket" class="mb-2 col-lg-3 col-md-6 text-start">
                                            <a href="javascript:void(0);">
                                                <div class="iq-icon me-3">
                                                    <i class="bi bi-folder2-open"></i>
                                                </div>
                                                <span class="dark-wizard">Paket</span>
                                            </a>
                                        </li>
                                        <li id="responden" class="mb-2 col-lg-3 col-md-6 text-start">
                                            <a href="javascript:void(0);">
                                                <div class="iq-icon me-3">
                                                    <i class="bi bi-person-vcard"></i>
                                                </div>
                                                <span class="dark-wizard">Data Diri</span>
                                            </a>
                                        </li>
                                        <li id="kuesioner" class="mb-2 col-lg-3 col-md-6 text-start">
                                            <a href="javascript:void(0);">
                                                <div class="iq-icon me-3">
                                                    <i class="bi bi-ui-checks"></i>
                                                </div>
                                                <span class="dark-wizard">Kuesioner</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- STEP 1: Kategori -->
                                    <fieldset>
                                        <div class="form-card text-start">
                                            <h5 class="mb-4">Pilih Kategori SKM</h5>
                                            <div class="form-group">
                                                <label class="form-label">Kategori:</label>
                                                <select class="form-control" id="kategori_id" name="kategori_id" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    @foreach($kategori as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary next action-button float-end">Next</button>
                                    </fieldset>

                                    <!-- STEP 2: Paket -->
                                    <fieldset>
                                        <div class="form-card text-start">
                                            <h5 class="mb-4">Pilih Paket Survey</h5>
                                            <div class="form-group">
                                                <label class="form-label">Paket:</label>
                                                <select class="form-control" id="paket_id" name="paket_id" required>
                                                    <option value="">-- Pilih Paket --</option>
                                                    {{-- akan diisi dinamis via AJAX berdasarkan kategori --}}
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary next action-button float-end">Next</button>
                                        <button type="button" class="btn btn-dark previous action-button-previous float-end me-1">Previous</button>
                                    </fieldset>

                                    <!-- STEP 3: Data Diri -->
                                    <fieldset>
                                        <div class="form-card text-start">
                                            <h5 class="mb-4">Data Diri Responden</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Nama:</label>
                                                    <input type="text" class="form-control" name="nama" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Jenis Kelamin:</label>
                                                    <select class="form-control" name="jenis_kelamin" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Laki-laki">Laki-laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tanggal Lahir:</label>
                                                    <input type="date" class="form-control" name="tanggal_lahir">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Pendidikan:</label>
                                                    <input type="text" class="form-control" name="pendidikan">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Pekerjaan:</label>
                                                    <input type="text" class="form-control" name="pekerjaan">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Jenis Layanan:</label>
                                                    <input type="text" class="form-control" name="jenis_layanan">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary next action-button float-end">Next</button>
                                        <button type="button" class="btn btn-dark previous action-button-previous float-end me-1">Previous</button>
                                    </fieldset>

                                    <!-- STEP 4: Kuesioner -->
                                    <fieldset>
                                        <div class="form-card text-start">
                                            <h5 class="mb-4">Isi Kuesioner</h5>
                                            <div id="list-kuesioner">
                                                {{-- akan diisi dinamis via AJAX berdasarkan paket --}}
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success float-end">Kirim Jawaban</button>
                                        <button type="button" class="btn btn-dark previous action-button-previous float-end me-1">Previous</button>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Section Start -->
            <footer class="footer">
                <div class="footer-body">
                    <div class="right-panel">
                        ©<script>
                            document.write(new Date().getFullYear())
                        </script> SPKT POLRES PACITAN, Developed by <a href="https://decaa.id">DECAA.ID</a>.
                    </div>
                </div>
            </footer>
            <!-- Footer Section End -->
        </main>
        <!-- Wrapper End-->
    </div>
    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('assets/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('assets/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('assets/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->
    <script src="{{ asset('assets/vendor/aos/dist/aos.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Load paket berdasarkan kategori
            document.querySelector('#kategori_id').addEventListener('change', function() {
                let kategoriId = this.value;
                fetch(`/survey/paket/${kategoriId}`)
                    .then(res => res.json())
                    .then(data => {
                        let paketSelect = document.querySelector('#paket_id');
                        paketSelect.innerHTML = '<option value="">-- Pilih Paket --</option>';
                        data.forEach(p => {
                            paketSelect.innerHTML += `<option value="${p.id}">${p.nama}</option>`;
                        });
                    });
            });

            // Load kuesioner berdasarkan paket
            document.querySelector('#paket_id').addEventListener('change', function() {
                let paketId = this.value;
                fetch(`/survey/kuesioner/${paketId}`)
                    .then(res => res.json())
                    .then(data => {
                        let container = document.querySelector('#list-kuesioner');
                        container.innerHTML = '';
                        data.forEach((q, i) => {
                            let opsi = '';
                            try {
                                let opsiList = JSON.parse(q.opsi_jawaban);
                                opsiList.forEach(o => {
                                    opsi += `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban[${q.id}]" value="${o.jawaban}">
                                    <label class="form-check-label">${o.jawaban}</label>
                                </div>`;
                                });
                            } catch {}
                            container.innerHTML += `
                        <div class="mb-3">
                            <label><strong>${i+1}. ${q.pertanyaan}</strong></label>
                            ${opsi}
                        </div>`;
                        });
                    });
            });
        });
    </script>


</body>

</html>
