<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MBG FOOD HUB</title>

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

    <!-- Base CSS Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <!-- Tema Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css" />

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/bootstrap-icons.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <style>
        /* 🌈 Perindah input date range */
        #dateRange.flatpickr-input {
            background-color: #fff !important;
            border: 1px solid #d0d5dd !important;
            border-radius: 8px !important;
            padding: 8px 10px !important;
            font-size: 0.9rem !important;
            color: #2b2b2b !important;
            transition: all 0.3s ease;
        }

        #dateRange.flatpickr-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* 🌟 Kalender tampil dengan bayangan halus */
        .flatpickr-calendar {
            border-radius: 12px !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1) !important;
            font-family: "Inter", "Poppins", sans-serif !important;
            z-index: 9999 !important;
        }

        /* 🎯 Header kalender (bulan & tahun) */
        .flatpickr-months .flatpickr-month {
            background-color: #3b82f6 !important;
            color: white !important;
            border-radius: 12px 12px 0 0 !important;
        }

        .flatpickr-current-month {
            font-weight: 600 !important;
            font-size: 1rem !important;
        }

        /* 🗓️ Tombol navigasi bulan */
        .flatpickr-prev-month svg,
        .flatpickr-next-month svg {
            fill: #ffffff !important;
        }

        /* 📅 Hari biasa & dipilih */
        .flatpickr-day {
            border-radius: 6px !important;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .flatpickr-day:hover {
            background: #eff6ff !important;
            color: #2563eb !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #fff !important;
        }

        /* 🌄 Warna range di antara tanggal */
        .flatpickr-day.inRange {
            background: rgba(59, 130, 246, 0.15) !important;
        }

        /* 🧭 Hari Minggu warna abu */
        .flatpickr-weekday {
            color: #64748b !important;
            font-weight: 500 !important;
        }
    </style>
</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
            </div>
        </div>
    </div>
    <!-- loader END -->
    @include('layouts.sidebar')

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar">
                <div class="container-fluid navbar-inner">
                    <a href="{{ route('dashboard') }}" class="navbar-brand">
                        <!--Logo start-->
                        <div class="logo-main">
                            <div class="logo-normal">
                                <img src="/assets/images/logo-bgn.png" alt="Logo BKU" class="icon-60"
                                    style="width: 60px; height: 60px; object-fit: contain" />
                            </div>
                            <div class="logo-mini">
                                <img src="/assets/images/logo-bgn.png" alt="Logo BKU" class="icon-60"
                                    style="width: 60px; height: 60px; object-fit: contain" />
                            </div>
                        </div>
                        <!--logo End-->
                        <h4 style="font-size: 16px !important;" class="logo-title">MBG FOOD HUB</h4>
                    </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon">
                            <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <span class="mt-2 navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                            <li class="nav-item dropdown custom-drop">
                                <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/avatars/01.png') }}" alt="User-Profile"
                                        class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                    <img src="{{ asset('assets/images/avatars/avtar_1.png') }}" alt="User-Profile"
                                        class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                                    <img src="{{ asset('assets/images/avatars/avtar_2.png') }}" alt="User-Profile"
                                        class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded">
                                    <div class="caption ms-3 d-none d-md-block ">
                                        <h6 class="mb-0 caption-title">{{ auth()->user()->name }}</h6>
                                        <p class="mb-0 caption-sub-title">
                                            {{ auth()->user()->role }}
                                        </p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav><!--Nav End-->
            @include('sweetalert::alert')
            @yield('header')
        </div>
        @yield('container')
        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body">
                <div class="right-panel">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> MBG FOOD HUB</a>.
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    {{-- <script src="{{ asset('assets/js/charts/vectore-chart.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/charts/dashboard.js') }}"></script> --}}

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
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

    {{-- Add Select2 CSS in head or after styles --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    {{-- Add Select2 JS before closing body or in scripts section --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-input').select2({
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('navbarDropdown');
            const dropdownMenu = dropdownToggle.nextElementSibling;

            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>

</body>

</html>