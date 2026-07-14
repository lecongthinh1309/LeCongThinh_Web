@extends('client.layouts.app')

@php
    $pageTitle = isset($category) ? 'Danh mục: ' . $category->catename
                : (isset($brand) ? 'Thương hiệu: ' . $brand->brandname
                : (isset($keyword) ? 'Kết quả tìm kiếm: "' . $keyword . '"' : 'Tất cả sản phẩm'));
@endphp

@section('title', $pageTitle . ' - LaptopStore')

@section('content')

{{-- PAGE BANNER --}}
<div class="page-banner">
    <div class="container">
        <h1>{{ $pageTitle }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">{{ $pageTitle }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        {{-- SIDEBAR --}}
        <div class="col-lg-3">
            <div class="sidebar-filter">
                <h6><i class="bi bi-funnel me-1"></i> Danh mục</h6>
                <a href="{{ route('product.search', ['keyword' => '']) }}" class="filter-link {{ !isset($category) && !isset($brand) ? 'active' : '' }}">
                    Tất cả sản phẩm
                </a>
                @foreach(\App\Models\Category::where('status',1)->get() as $cat)
                    <a href="{{ route('product.category', $cat->slug) }}"
                       class="filter-link {{ isset($category) && $category->cateid == $cat->cateid ? 'active' : '' }}">
                        {{ $cat->catename }}
                    </a>
                @endforeach
            </div>

            <div class="sidebar-filter">
                <h6><i class="bi bi-award me-1"></i> Thương hiệu</h6>
                @foreach(\App\Models\Brand::where('status',1)->get() as $br)
                    <a href="{{ route('product.brand', $br->slug) }}"
                       class="filter-link {{ isset($brand) && $brand->brandid == $br->brandid ? 'active' : '' }}">
                        {{ $br->brandname }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- PRODUCTS --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="mb-0 text-muted" style="font-size:0.88rem;">
                    Tìm thấy <strong>{{ $products->total() }}</strong> sản phẩm
                </p>
            </div>

            @if($products->count() > 0)
                <div class="row g-3">
                    @foreach($products as $product)
                    <div class="col-6 col-md-4">
                        @include('client.partials.product-card', ['product' => $product])
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-search"></i></div>
                    <h5>Không tìm thấy sản phẩm nào</h5>
                    <p class="text-muted">Vui lòng thử tìm kiếm với từ khóa khác</p>
                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill mt-2">
                        <i class="bi bi-house me-1"></i> Về trang chủ
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
