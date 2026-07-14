@extends('client.layouts.app')

@php
    $finalPrice = ($product->pricediscount > 0) ? $product->pricediscount : $product->price;
    $discountPct = ($product->price > 0 && $product->pricediscount > 0)
        ? round((1 - $product->pricediscount / $product->price) * 100) : 0;
@endphp

@section('title', $product->productname . ' - LaptopStore')
@section('meta_description', Str::limit(strip_tags($product->description), 150))

@section('content')

{{-- PAGE BANNER --}}
<div class="page-banner">
    <div class="container">
        <h1>{{ Str::limit($product->productname, 50) }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                @if($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('product.category', $product->category->slug) }}">{{ $product->category->catename }}</a>
                    </li>
                @endif
                <li class="breadcrumb-item active">{{ Str::limit($product->productname, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        {{-- IMAGES --}}
        <div class="col-lg-5">
            <img src="{{ $product->image ? asset('images/products/' . $product->image) : 'https://placehold.co/500x380/1a1a2e/0066FF?text=💻+Laptop' }}"
                 class="product-main-img"
                 alt="{{ $product->productname }}"
                 onerror="this.onerror=null;this.src='https://placehold.co/500x380/1a1a2e/0066FF?text=💻+Laptop'">
        </div>

        {{-- PRODUCT INFO --}}
        <div class="col-lg-7">
            <div class="product-detail-card">
                @if($product->brand)
                    <div style="color:var(--primary);font-weight:700;font-size:0.85rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem;">
                        {{ $product->brand->brandname }}
                    </div>
                @endif

                <h1 class="product-name mb-3">{{ $product->productname }}</h1>

                <div class="d-flex align-items-baseline gap-3 mb-4">
                    <span class="product-price-main">{{ number_format($finalPrice, 0, ',', '.') }}đ</span>
                    @if($discountPct > 0)
                        <span class="product-price-original">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        <span class="badge bg-danger" style="font-size:0.8rem;">-{{ $discountPct }}%</span>
                    @endif
                </div>

                <div class="d-flex gap-2 mb-3" style="flex-wrap:wrap;">
                    <span style="background:#e8f0ff;color:var(--primary);border-radius:8px;padding:4px 12px;font-size:0.8rem;font-weight:600;">
                        <i class="bi bi-shield-check me-1"></i>Bảo hành 12 tháng
                    </span>
                    <span style="background:#e8f0ff;color:var(--primary);border-radius:8px;padding:4px 12px;font-size:0.8rem;font-weight:600;">
                        <i class="bi bi-truck me-1"></i>Giao hàng miễn phí
                    </span>
                    <span style="background:#fff3e0;color:#FF6B35;border-radius:8px;padding:4px 12px;font-size:0.8rem;font-weight:600;">
                        <i class="bi bi-arrow-repeat me-1"></i>Đổi trả 30 ngày
                    </span>
                </div>

                <hr>

                {{-- Qty & Add to cart --}}
                <div class="d-flex align-items-center gap-3 mb-3" style="flex-wrap:wrap;">
                    <div class="qty-control">
                        <button class="qty-btn" id="qty-minus">−</button>
                        <input type="number" class="qty-input" id="qty-input" value="1" min="1" max="99">
                        <button class="qty-btn" id="qty-plus">+</button>
                    </div>
                    <button class="btn-add-cart-detail" data-product-id="{{ $product->id }}">
                        <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ
                    </button>
                </div>
                <div class="mb-4">
                    <a href="{{ route('cart.checkout') }}" class="btn-buy-now">
                        <i class="bi bi-bag-check me-2"></i> Mua ngay
                    </a>
                </div>

                {{-- Description --}}
                @if($product->description)
                <div style="background:#f8f9fa;border-radius:10px;padding:1rem;font-size:0.9rem;color:#555;line-height:1.7;">
                    <strong>Mô tả sản phẩm:</strong><br>
                    {!! nl2br(e(Str::limit($product->description, 300))) !!}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- RELATED PRODUCTS --}}
    @if($related->count() > 0)
    <div class="mt-5">
        <div class="section-title mb-1">Sản phẩm liên quan</div>
        <div class="section-line mb-4"></div>
        <div class="row g-3">
            @foreach($related as $relProduct)
            <div class="col-6 col-md-3">
                @include('client.partials.product-card', ['product' => $relProduct])
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
