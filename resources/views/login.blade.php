<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - Phone Ext RSBL</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --rs-primary: #0d9488;
            --rs-bg: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0d9488 0%, #0ea5e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .login-header {
            background-color: #ffffff;
            padding: 2.5rem 2rem 1rem;
            text-align: center;
            border-bottom: none;
        }

        .login-body {
            padding: 1rem 2.5rem 2.5rem;
            background-color: #ffffff;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--rs-primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }

        .btn-primary {
            background-color: var(--rs-primary);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #0f766e;
            transform: translateY(-1px);
        }

        .logo-img {
            height: 70px;
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            color: #94a3b8;
        }

        .form-control {
            border-left: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="login-header">
                        <img src="{{ asset('assets/img/rsud_logo.png') }}" alt="Logo" class="logo-img">
                        <h4 class="fw-bold text-dark mb-0">Selamat Datang</h4>
                        <p class="text-muted small mt-2">Silakan masuk ke akun Anda untuk mengelola direktori</p>
                    </div>
                    <div class="login-body">
                        <form action="{{ route('authenticate') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Username / Nama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input class="form-control" name="name" type="text" placeholder="Masukkan nama" required autofocus />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input class="form-control" name="password" type="password" placeholder="Masukkan password" required />
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 shadow-sm" type="submit">
                                Sign In <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 mt-4 small rounded-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">IT Team &copy; RSUD Blambangan 2024</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>

