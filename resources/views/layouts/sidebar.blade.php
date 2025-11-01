<!-- SIDEBAR START -->
<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="/" class="navbar-brand">

            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                <img src="{{ asset('assets/images/polri.png') }}" width="50px" alt="logo-polri" class="img-fluid">
                </div>
                <div class="logo-mini">
                    <svg class=" icon-30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                    </svg>
                </div>
            </div>
            <!--logo End-->
            <h4 class="logo-title">
                <strong>E-SPKT POLRI</strong>
            </h4>
        </a>

        <!-- SIDEBAR TOGGLE -->
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>

    </div>

    <!-- SIDEBAR MENU-->
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Home</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="icon">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                                <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Penerbitan</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('surats.*') ? 'active' : '' }}" href="{{ route('surats.index') }}">
                        <i class="icon">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7044 3.51898C10.034 3.51898 9.46373 3.9848 9.30365 4.61265H14.6863C14.5263 3.9848 13.956 3.51898 13.2856 3.51898H10.7044ZM16.2071 4.61264H18.1881C20.2891 4.61264 22 6.34428 22 8.47085C22 8.47085 21.94 9.3711 21.92 10.6248C21.918 10.724 21.8699 10.8212 21.7909 10.88C21.3097 11.2354 20.8694 11.5291 20.8294 11.5493C19.1686 12.6632 17.2386 13.447 15.1826 13.8369C15.0485 13.8632 14.9165 13.7934 14.8484 13.6739C14.2721 12.6754 13.1956 12.0253 11.995 12.0253C10.8024 12.0253 9.71586 12.6683 9.12256 13.6678C9.05353 13.7853 8.92346 13.8531 8.7904 13.8278C6.75138 13.4369 4.82141 12.6541 3.17059 11.5594L2.21011 10.8911C2.13007 10.8405 2.08004 10.7493 2.08004 10.6481C2.05003 10.1316 2 8.47085 2 8.47085C2 6.34428 3.71086 4.61264 5.81191 4.61264H7.78289C7.97299 3.1443 9.2036 2 10.7044 2H13.2856C14.7864 2 16.017 3.1443 16.2071 4.61264ZM21.6598 12.8152L21.6198 12.8355C19.5988 14.1924 17.1676 15.0937 14.6163 15.4684C14.2561 15.519 13.8959 15.2861 13.7959 14.9216C13.5758 14.0912 12.8654 13.5443 12.015 13.5443H12.005H11.985C11.1346 13.5443 10.4242 14.0912 10.2041 14.9216C10.1041 15.2861 9.74387 15.519 9.38369 15.4684C6.83242 15.0937 4.4012 14.1924 2.38019 12.8355C2.37019 12.8254 2.27014 12.7646 2.1901 12.8152C2.10005 12.8659 2.10005 12.9874 2.10005 12.9874L2.17009 18.1519C2.17009 20.2785 3.87094 22 5.97199 22H18.018C20.1191 22 21.8199 20.2785 21.8199 18.1519L21.9 12.9874C21.9 12.9874 21.9 12.8659 21.8099 12.8152C21.7599 12.7849 21.6999 12.795 21.6598 12.8152ZM12.7454 17.0583C12.7454 17.4836 12.4152 17.8177 11.995 17.8177C11.5848 17.8177 11.2446 17.4836 11.2446 17.0583V15.7519C11.2446 15.3367 11.5848 14.9924 11.995 14.9924C12.4152 14.9924 12.7454 15.3367 12.7454 15.7519V17.0583Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Laporan Kehilangan</span>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon">Master Data</span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="icon">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Jenis Kehilangan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skm.kategori.*') ? 'active' : '' }}" href="{{ route('skm.kategori.index') }}">
                        <i class="icon">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Kategori SKM</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skm.paket.*') ? 'active' : '' }}" href="{{ route('skm.paket.index') }}">
                        <i class="icon">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Paket SKM</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="icon">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.294 7.29105C17.294 10.2281 14.9391 12.5831 12 12.5831C9.0619 12.5831 6.70601 10.2281 6.70601 7.29105C6.70601 4.35402 9.0619 2 12 2C14.9391 2 17.294 4.35402 17.294 7.29105ZM12 22C7.66237 22 4 21.295 4 18.575C4 15.8539 7.68538 15.1739 12 15.1739C16.3386 15.1739 20 15.8789 20 18.599C20 21.32 16.3146 22 12 22Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">User</span>
                    </a>
                </li>
            </ul>
            <!-- Sidebar Menu End -->
        </div>

    </div>
    <div class="sidebar-footer"></div>
</aside>
<!-- SIDEBAR END -->
