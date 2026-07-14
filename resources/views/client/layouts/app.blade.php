<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaptopStore - Laptop Chính Hãng Giá Tốt')</title>
    <meta name="description" content="@yield('meta_description', 'Mua laptop chính hãng, giá tốt nhất thị trường. Đa dạng thương hiệu: Apple, Dell, HP, Lenovo, Asus, Acer.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/css/client.css', 'resources/js/app.js', 'resources/js/client.js'])
    @yield('styles')
</head>
<body>

    {{-- HEADER --}}
    @include('client.partials.header')

    {{-- MAIN CONTENT --}}
    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-0 rounded-0 text-center py-2" style="font-size:0.9rem;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0 text-center py-2" style="font-size:0.9rem;" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('client.partials.footer')

    {{-- Toast container --}}
    <div id="toast-container" class="toast-container"></div>

    {{-- Scroll to top --}}
    <button id="scrollTopBtn" title="Lên đầu trang"><i class="bi bi-arrow-up"></i></button>

    @yield('scripts')
</body>
</html>
