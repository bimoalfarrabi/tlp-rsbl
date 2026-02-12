<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Phone Extension Directory RSBL" />
    <meta name="author" content="IT RSBL" />
    <title>Phone Ext - RSBL</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Scripts JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <!-- Bootstrap & DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        :root {
            --rs-primary: #0d9488;
            --rs-primary-dark: #0f766e;
            --rs-secondary: #0ea5e9;
            --rs-bg: #f8fafc;
            --rs-sidebar: #ffffff;
            --rs-text: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--rs-bg);
            color: var(--rs-text);
        }

        /* Navbar Styling */
        .sb-topnav {
            background-color: #ffffff !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            height: 70px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sb-topnav .navbar-brand {
            color: var(--rs-primary) !important;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Sidebar Styling */
        .sb-sidenav {
            background-color: var(--rs-sidebar) !important;
            border-right: 1px solid #e2e8f0;
        }

        .sb-sidenav-light .sb-sidenav-menu .nav-link {
            color: #64748b;
            font-weight: 500;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .sb-sidenav-light .sb-sidenav-menu .nav-link:hover {
            color: var(--rs-primary);
            background-color: #f1f5f9;
        }

        .sb-sidenav-light .sb-sidenav-menu .nav-link.active {
            color: #ffffff !important;
            background-color: var(--rs-primary) !important;
        }

        .sb-sidenav-light .sb-sidenav-menu .nav-link .sb-nav-link-icon {
            color: inherit;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: var(--rs-primary);
            border-color: var(--rs-primary);
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-top: 70px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="{{ url('/') }}" style="gap: 12px;">
            <img src="{{ asset('assets/img/rsud_logo.png') }}" alt="RSUD Logo" style="height: 45px; width: auto;">
            <div class="d-flex flex-column" style="line-height: 1.2;">
                <span style="font-size: 1.1rem; font-weight: 700;">PHONE EXT</span>
                <span style="font-size: 0.75rem; color: #64748b; font-weight: 400;">RSUD Blambangan</span>
            </div>
        </a>

        <!-- Sidebar Toggle (Always Visible)-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 ms-2" id="sidebarToggle" href="#!">
            <i class="fas fa-bars" style="color: var(--rs-primary); font-size: 1.2rem;"></i>
        </button>
        
        <!-- Navbar Right Side-->
        <ul class="navbar-nav ms-auto pe-3">
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-light rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="fas fa-user text-primary" style="font-size: 0.9rem;"></i>
                    </div>
                    <span class="d-none d-md-inline fw-medium text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <li class="nav-item">
                <a class="btn btn-sm btn-outline-primary fw-bold px-3 rounded-pill" href="{{ route('login') }}">
                    <i class="fas fa-lock me-1"></i> Admin Login
                </a>
            </li>
            @endauth
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav mt-3">
                        @auth
                            <div class="sb-sidenav-menu-heading text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; color: #94a3b8;">Administrator</div>
                            
                            @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin')
                            <a class="nav-link {{ request()->routeIs('admin.extension') ? 'active' : '' }}" href="{{ route('admin.extension') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-phone-alt"></i></div>
                                Kelola Extension
                            </a>
                            @endif

                            @if (auth()->user()->role == 'super_admin')
                            <a class="nav-link {{ request()->routeIs('super_admin.extension') ? 'active' : '' }}" href="{{ route('super_admin.extension') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Kelola Memori
                            </a>
                            @endif

                            @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'humas')
                            <a class="nav-link {{ request()->routeIs('humas.dokter') ? 'active' : '' }}" href="{{ route('humas.dokter') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-md"></i></div>
                                Kelola Dokter
                            </a>
                            @endif

                            <div class="sb-sidenav-menu-heading text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; color: #94a3b8;">Lihat Sebagai Publik</div>
                        @else
                            <div class="sb-sidenav-menu-heading text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; color: #94a3b8;">Menu Utama</div>
                        @endauth

                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            Daftar Extension
                        </a>
                        <a class="nav-link {{ request()->routeIs('daftar-memori-telepon') ? 'active' : '' }}" href="{{ route('daftar-memori-telepon') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Memori Telepon
                        </a>
                    </div>
                </div>
                
                <div class="sb-sidenav-footer bg-light border-top mt-auto">
                    @auth
                        <div class="small text-muted">Role:</div>
                        <div class="fw-bold text-primary">{{ strtoupper(str_replace('_', ' ', Auth::user()->role)) }}</div>
                    @else
                        <div class="small text-muted text-center py-2 text-uppercase fw-bold" style="font-size: 0.65rem;">Sistem Informasi RSUD</div>
                    @endauth
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-white border-top mt-5">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">IT Team &copy; RSUD Blambangan 2024</div>
                        <div>
                            <span class="text-muted">Versi 2.0</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    @stack('scripts')
</body>

</html>
