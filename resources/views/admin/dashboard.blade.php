@extends('admin.layouts.admin')
@section('title', 'Dashboard - Trang quản trị')

@section('content')
<div class="container-fluid py-3">

    {{-- Welcome Banner --}}
    <div class="p-4 mb-4 rounded-4 text-white"
         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 8px 32px rgba(102,126,234,0.3);">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center"
                 style="width:60px;height:60px;font-size:1.8rem;">
                <i class="bi bi-person-circle"></i>
            </div>
            <div>
                <h4 class="mb-0 fw-bold">Xin chào, {{ Auth::user()->fullname }}! 👋</h4>
                <p class="mb-0 opacity-75 small">{{ now()->format('l, d/m/Y') }} — Chào mừng bạn trở lại hệ thống quản trị.</p>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white"
                         style="width:50px;height:50px;background:linear-gradient(135deg,#667eea,#764ba2);">
                        <i class="bi bi-tags-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Loại sản phẩm</div>
                        <div class="fw-bold fs-5">{{ \App\Models\Category::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white"
                         style="width:50px;height:50px;background:linear-gradient(135deg,#f093fb,#f5576c);">
                        <i class="bi bi-box-seam-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Sản phẩm</div>
                        <div class="fw-bold fs-5">{{ \App\Models\Product::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white"
                         style="width:50px;height:50px;background:linear-gradient(135deg,#4facfe,#00f2fe);">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Người dùng</div>
                        <div class="fw-bold fs-5">{{ \App\Models\User::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white"
                         style="width:50px;height:50px;background:linear-gradient(135deg,#43e97b,#38f9d7);">
                        <i class="bi bi-journal-text fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Bài viết</div>
                        <div class="fw-bold fs-5">{{ \App\Models\Post::count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Thông tin tài khoản --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <h6 class="fw-bold text-muted mb-0">
                <i class="bi bi-info-circle me-2"></i>Thông tin tài khoản
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <span class="text-muted">Họ tên:</span>
                        <strong>{{ Auth::user()->fullname }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <span class="text-muted">Username:</span>
                        <strong>{{ Auth::user()->username }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <span class="text-muted">Email:</span>
                        <strong>{{ Auth::user()->email }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <span class="text-muted">Vai trò:</span>
                        @if(Auth::user()->role == 1)
                            <span class="badge bg-primary">Quản lý</span>
                        @else
                            <span class="badge bg-secondary">Nhân viên</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection