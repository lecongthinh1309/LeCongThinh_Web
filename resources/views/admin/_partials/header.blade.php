<nav class="navbar navbar-light bg-white admin-header border-bottom shadow-sm">

    <div class="container-fluid px-3">

        <span class="navbar-brand fw-bold text-primary">
            <i class="bi bi-speedometer2 me-2"></i>Admin Panel
        </span>

        <div class="d-flex align-items-center gap-3">

            {{-- Hiển thị tên người dùng đang đăng nhập --}}
            @auth
                <span class="text-muted small">
                    Xin chào <strong class="text-dark">{{ Auth::user()->fullname }}</strong>
                </span>

                {{-- Link đổi mật khẩu --}}
                <a href="{{ route('admin.changepassword') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-key me-1"></i>Đổi mật khẩu
                </a>

                {{-- Form đăng xuất --}}
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </button>
                </form>
            @endauth

        </div>

    </div>

</nav>