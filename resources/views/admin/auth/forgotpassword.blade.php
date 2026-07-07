<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên mật khẩu - Hệ thống quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }
        .icon-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 10px 30px rgba(253,160,133,0.4);
        }
        .page-title {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.3rem;
        }
        .page-subtitle {
            color: rgba(255,255,255,0.5);
            text-align: center;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }
        .form-label { color: rgba(255,255,255,0.8); font-size: 0.875rem; font-weight: 500; }
        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            color: #fff;
            padding: 0.75rem 1rem;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.12);
            border-color: #fda085;
            box-shadow: 0 0 0 3px rgba(253,160,133,0.25);
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }
        .btn-submit {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(253,160,133,0.4);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(253,160,133,0.6);
            color: #fff;
        }
        .back-link {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }
        .back-link:hover { color: #fda085; }
        .alert-success-glass {
            background: rgba(25,135,84,0.15);
            border: 1px solid rgba(25,135,84,0.3);
            border-radius: 10px;
            color: #75e0a7;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="card-glass">
        <div class="icon-circle">
            <i class="bi bi-key-fill"></i>
        </div>

        <h1 class="page-title">Quên mật khẩu</h1>
        <p class="page-subtitle">Nhập email của bạn để nhận hướng dẫn đặt lại mật khẩu.</p>

        @if(session('success'))
            <div class="alert-success-glass mb-3">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-3" style="background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.3); border-radius: 10px; color: #ff6b6b; padding: 0.75rem 1rem; font-size: 0.875rem;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.forgotpass.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="f-email" class="form-label">Địa chỉ Email</label>
                <input type="email"
                       class="form-control"
                       id="f-email"
                       name="email"
                       placeholder="Nhập địa chỉ email"
                       value="{{ old('email') }}">
            </div>

            <button type="submit" class="btn btn-submit w-100">
                <i class="bi bi-send-fill me-2"></i>Gửi yêu cầu
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('admin.login') }}" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>Quay lại đăng nhập
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
