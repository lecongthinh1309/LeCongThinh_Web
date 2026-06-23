@extends('admin.layouts.admin')
@section('title', 'Thêm Người Dùng')
@section('content')
<div class="card p-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <h3 class="mb-4 text-primary text-uppercase fw-bold">THÊM TÀI KHOẢN MỚI</h3>
    {{-- Hiển thị tất cả lỗi Validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Tên tài khoản (Username)</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Nhập tên tài khoản..." required>
            @error('username')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Họ và tên (Fullname)</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}" placeholder="Nhập họ và tên..." required>
            @error('fullname')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Số điện thoại (Phone)</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Nhập số điện thoại..." required>
            @error('phone')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Địa chỉ Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Mật khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự..." required>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Trạng thái tài khoản</label>
            <select name="status" class="form-select">
                <option value="">-- Chọn trạng thái --</option>
                <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Kích hoạt (Hoạt động)</option>
                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Tạm khóa</option>
            </select>
            @error('status')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">Lưu lại</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">Quay lại</a>
        </div>
    </form>
</div>
@endsection