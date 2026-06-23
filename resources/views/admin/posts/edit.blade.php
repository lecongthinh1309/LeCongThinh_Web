@extends('admin.layouts.admin')
@section('title', 'Sửa bài viết')
@section('content')
<div class="card p-4 shadow-sm" style="max-width: 800px; margin: 0 auto;">
    <h3 class="mb-4 text-warning fw-bold">SỬA BÀI VIẾT</h3>

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

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-bold">Tiêu đề bài viết</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold d-block">Hình ảnh hiện tại</label>
            @if($post->image)
                <img src="{{ asset('images/posts/' . $post->image) }}" class="img-thumbnail mb-2" style="max-width: 200px;">
            @endif
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Mô tả ngắn</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $post->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Nội dung chi tiết</label>
            <textarea name="content" class="form-control" rows="6">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold d-block">Trạng thái bài đăng</label>
            <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $post->status) == 1 ? 'checked' : '' }}>
            <label class="btn btn-outline-success" for="active">Công khai</label>

            <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $post->status) == 0 ? 'checked' : '' }}>
            <label class="btn btn-outline-danger" for="inactive">Bản nháp</label>
            @error('status')
                <span class="text-danger d-block mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning px-4 fw-bold">Cập nhật</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary px-4">Hủy bỏ</a>
        </div>
    </form>
</div>
@endsection