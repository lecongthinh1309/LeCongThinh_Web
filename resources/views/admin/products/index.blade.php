@extends('admin.layouts.admin')
@section('title', 'Quản lý Sản Phẩm')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>DANH SÁCH SẢN PHẨM</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle"></i> Thêm mới
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered table-hover table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã SP</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá gốc</th>
            <th>Giá giảm</th>
            <th>Trạng thái</th>
            <th class="text-center" style="width: 120px;">Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $index + 1 }}</td>
            <td>{{ $item->id }}</td>
            <td>
                @if($item->image)
                    <img src="{{ asset('storage/products/' . $item->image) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                @endif
            </td>
            <td>{{ $item->productname }}</td>
            <td>{{ $item->category_name ?? 'Không rõ' }}</td>
            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
            <td>{{ number_format($item->pricediscount, 0, ',', '.') }} đ</td>
            <td>
                <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                    {{ $item->status == 1 ? 'Mở bán' : 'Ẩn' }}
                </span>
            </td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    
                    <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $list->links() }}
</div>
@endsection