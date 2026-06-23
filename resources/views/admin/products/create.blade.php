@extends('admin.layouts.admin')
@section('title', 'Thêm Sản Phẩm')
@section('content')
<div class="card p-4 shadow-sm" style="max-width: 700px; margin: 0 auto;">
    <h3 class="mb-4 text-primary fw-bold">THÊM SẢN PHẨM MỚI</h3>

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
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label fw-bold">Tên sản phẩm</label>
            <input type="text" name="productname" class="form-control" value="{{ old('productname') }}" required>
            {{-- hiển thị lỗi cho trường productname --}}
            @error('productname')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-bold">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            {{-- hiển thị lỗi cho trường slug --}}
            @error('slug')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Loại sản phẩm</label>
                <select name="cateid" class="form-select">
                    <option value="">-- Chọn loại sản phẩm --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->cateid }}" {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                            {{ $category->catename }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Thương hiệu</label>
                <select name="brandid" class="form-select">
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brandid }}" {{ old('brandid') == $brand->brandid ? 'selected' : '' }}>
                            {{ $brand->brandname }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Giá khuyến mãi</label>
                <input type="number" name="pricediscount" class="form-control" value="{{ old('pricediscount', 0) }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold d-block">Trạng thái</label>
            <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status') === '1' ? 'checked' : '' }}>
            <label class="btn btn-outline-success" for="active">Hiển thị</label>

            <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status') === '0' ? 'checked' : '' }}>
            <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
            {{-- hiển thị lỗi cho trường status --}}
            @error('status')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">Lưu lại</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4">Quay lại</a>
        </div>
    </form>
</div>
@endsection