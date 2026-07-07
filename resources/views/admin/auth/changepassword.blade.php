@extends('admin.layouts.admin')
@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill fs-5"></i>
                        <h5 class="mb-0 fw-bold">Đổi mật khẩu</h5>
                    </div>
                </div>
                <div class="card-body p-4">

                    {{-- Thông tin người dùng đang đăng nhập --}}
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;font-size:1.3rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ Auth::user()->fullname }}</div>
                            <div class="text-muted small">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    {{-- Hiển thị thông báo --}}
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-check-circle-fill"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form đổi mật khẩu --}}
                    <form action="{{ route('admin.changepassword.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1 text-muted"></i>Mật khẩu hiện tại
                            </label>
                            <input type="password"
                                   class="form-control rounded-3 @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password"
                                   placeholder="Nhập mật khẩu hiện tại">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill me-1 text-primary"></i>Mật khẩu mới
                            </label>
                            <input type="password"
                                   class="form-control rounded-3 @error('new_password') is-invalid @enderror"
                                   id="new_password"
                                   name="new_password"
                                   placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill me-1 text-success"></i>Xác nhận mật khẩu mới
                            </label>
                            <input type="password"
                                   class="form-control rounded-3 @error('new_password_confirmation') is-invalid @enderror"
                                   id="new_password_confirmation"
                                   name="new_password_confirmation"
                                   placeholder="Nhập lại mật khẩu mới">
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="bi bi-check-lg me-2"></i>Cập nhật mật khẩu
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">
                                <i class="bi bi-x-lg me-2"></i>Hủy
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
