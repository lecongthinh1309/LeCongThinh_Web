@extends('admin.layouts.admin')
@section('title', 'Thêm thương hiệu')
@section('content')
<div class="card p-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <h3 class="mb-4 text-primary fw-bold">THÊM THƯƠNG HIỆU MỚI</h3>

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

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Tên thương hiệu</label>
            <input type="text" name="brandname" class="form-control" value="{{ old('brandname') }}" required>
            @error('brandname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 img-group">
            <label class="form-label fw-bold">Hình ảnh</label>
            <input type="file" name="img" class="form-control img-input">
            <div class="img-preview mt-2"></div>
            @error('img')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold d-block">Trạng thái</label>
            <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status') === '1' ? 'checked' : '' }}>
            <label class="btn btn-outline-success" for="active">Hiển thị</label>

            <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status') === '0' ? 'checked' : '' }}>
            <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
            
            @error('status')
                <span class="text-danger d-block mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">Lưu lại</button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4">Quay lại</a>
        </div>
    </form>
</div>
@endsection