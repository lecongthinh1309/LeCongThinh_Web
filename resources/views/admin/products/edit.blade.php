@extends('admin.layouts.admin')
@section('title', 'Sửa Sản Phẩm')
@section('content')
<div class="border rounded bg-white p-4 shadow-sm" style="max-width: 700px; margin: 0 auto;">
    <h3 class="mb-4">Sửa sản phẩm</h3>

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

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="productname" class="form-control" value="{{ old('productname', $product->productname) }}" required>
            @error('productname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
            @error('slug')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Loại sản phẩm</label>
                <select name="cateid" class="form-select">
                    <option value="">-- Chọn loại sản phẩm --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->cateid }}" {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
                            {{ $category->catename }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Thương hiệu</label>
                <select name="brandid" class="form-select">
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brandid }}" {{ old('brandid', $product->brandid) == $brand->brandid ? 'selected' : '' }}>
                            {{ $brand->brandname }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Giá khuyến mãi</label>
                <input type="number" name="pricediscount" class="form-control" value="{{ old('pricediscount', $product->pricediscount) }}">
                @error('pricediscount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Trạng thái</label>
            <input type="radio" class="btn-check" name="status" id="active" value="1" {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
            <label class="btn btn-outline-success" for="active">Hiển thị</label>

            <input type="radio" class="btn-check" name="status" id="inactive" value="0" {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
            <label class="btn btn-outline-danger" for="inactive">Ẩn</label>
        </div>

        <div class="mb-3 img-group">
            <label class="form-label">Hình ảnh chính</label>
            <input type="file" name="img" class="form-control img-input">
            <div class="img-preview mt-2">
                @if ($product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" class="img-thumbnail" width="120" alt="Main image">
                @endif
            </div>
            @error('img')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3 img-group">
            <label class="form-label">Hình ảnh phụ</label>
            <input type="file" name="imgs[]" class="form-control img-input" multiple>
            <div class="img-preview mt-2 d-flex flex-wrap gap-2">
                @foreach ($product->images as $image)
                    <div class="position-relative d-inline-block" id="product-img-{{ $image->id }}">
                        <img src="{{ asset('storage/products/' . $image->image) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" alt="Extra image">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 btn-delete-img" data-id="{{ $image->id }}">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                @endforeach
            </div>
            @error('imgs')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.btn-delete-img').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm('Bạn có chắc muốn xóa ảnh này?')) return;
        
        let imgId = this.dataset.id;
        let imgBlock = document.getElementById('product-img-' + imgId);
        
        fetch(`/admin/product-images/${imgId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                imgBlock.remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa ảnh.');
        });
    });
});
</script>
@endsection