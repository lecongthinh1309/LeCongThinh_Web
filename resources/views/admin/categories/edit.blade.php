@extends('admin.layouts.admin')
@section('title', 'Sửa danh mục')
@section('content')
<div class="card p-4 shadow-sm" style="max-width: 600px; margin: 0 auto;">
    <h3 class="mb-4 text-warning fw-bold">SỬA DANH MỤC</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.categories.update', $category->cateid) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-bold">Tên danh mục</label>
            <input type="text" name="catename" class="form-control" value="{{ old('catename', $category->catename) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
        </div>
        <div class="mb-3 img-group">
            <label class="form-label fw-bold">Hình ảnh</label>
            <input type="file" name="img" class="form-control img-input">
            <div class="img-preview mt-2">
                @if($category->image)
                    <img src="{{ asset('storage/categories/' . $category->image) }}" alt="{{ $category->catename }}" class="img-thumbnail" width="150">
                @endif
            </div>
            @error('img')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold d-block">Trạng thái</label>
            <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $category->status) == 1 ? 'checked' : '' }}>
            <label class="btn btn-outline-success" for="active">Hiển thị</label>

            <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $category->status) == 0 ? 'checked' : '' }}>
            <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning px-4 fw-bold">Cập nhật</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary px-4">Hủy bỏ</a>
        </div>
    </form>
</div>
@endsection