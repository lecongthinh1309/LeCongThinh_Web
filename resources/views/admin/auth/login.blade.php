<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập hệ thống</title>
    {{-- CDN Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }
        .login-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        .login-title {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.3rem;
        }
        .login-subtitle {
            color: rgba(255,255,255,0.5);
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .form-label {
            color: rgba(255,255,255,0.8);
            font-size: 0.875rem;
            font-weight: 500;
        }
        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            color: #fff;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.12);
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.25);
            color: #fff;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.3);
        }
        .input-group-text {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.5);
            border-radius: 10px 0 0 10px;
        }
        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }
        .form-check-label {
            color: rgba(255,255,255,0.6);
            font-size: 0.875rem;
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102,126,234,0.4);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102,126,234,0.6);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .forgot-link {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }
        .forgot-link:hover {
            color: #667eea;
        }
        .alert-error {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.3);
            border-radius: 10px;
            color: #ff6b6b;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <div class="login-card">
        {{-- Logo --}}
        <div class="login-logo">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h1 class="login-title">Đăng nhập</h1>
        <p class="login-subtitle">Chào mừng trở lại! Vui lòng đăng nhập để tiếp tục.</p>

        {{-- Hiển thị thông báo lỗi validation --}}
        @if ($errors->any())
            <div class="alert-error mb-3">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        {{-- Hiển thị lỗi từ session flash --}}
        @if(session('message'))
            <div class="alert-error mb-3">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('message') }}
            </div>
        @endif

        {{-- Form đăng nhập --}}
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="f-username" class="form-label">Tên đăng nhập</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <input type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           id="f-username"
                           placeholder="Nhập tên đăng nhập"
                           name="username"
                           value="{{ old('username') }}"
                           autocomplete="username">
                </div>
            </div>

            <div class="mb-3">
                <label for="f-password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="f-password"
                           placeholder="Nhập mật khẩu"
                           name="password"
                           autocomplete="current-password">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
                <a href="{{ route('admin.forgotpass') }}" class="forgot-link">
                    Quên mật khẩu?
                </a>
            </div>

            <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
            </button>
        </form>
    </div>

    {{-- CDN Bootstrap JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
