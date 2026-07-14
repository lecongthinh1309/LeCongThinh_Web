@php
    $discountPct = ($product->price > 0 && $product->pricediscount > 0)
        ? round((1 - $product->pricediscount / $product->price) * 100)
        : 0;
    $finalPrice = ($product->pricediscount > 0) ? $product->pricediscount : $product->price;
@endphp

<div class="product-card">
    <div class="card-img-wrapper">
        @if($product->image)
            <img src="{{ asset('images/products/' . $product->image) }}"
                 alt="{{ $product->productname }}"
                 onerror="this.onerror=null;this.src='https://placehold.co/300x200/1a1a2e/0066FF?text=💻+Laptop'">
        @else
            <img src="https://placehold.co/300x200/1a1a2e/0066FF?text=💻+Laptop" alt="{{ $product->productname }}">
        @endif

        @if($discountPct > 0)
            <span class="badge-discount">-{{ $discountPct }}%</span>
        @elseif(isset($isNew) && $isNew)
            <span class="badge-new">MỚI</span>
        @endif
    </div>
    <div class="card-body">
        @if($product->brand)
            <div class="card-brand">{{ $product->brand->brandname }}</div>
        @endif
        <div class="card-title">
            <a href="{{ route('product.show', $product->slug) }}">{{ $product->productname }}</a>
        </div>
        <div class="price-block">
            <span class="price-current">{{ number_format($finalPrice, 0, ',', '.') }}đ</span>
            @if($discountPct > 0)
                <span class="price-original">{{ number_format($product->price, 0, ',', '.') }}đ</span>
            @endif
        </div>
        <button class="btn-add-cart" data-product-id="{{ $product->id }}">
            <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
        </button>
    </div>
</div>
