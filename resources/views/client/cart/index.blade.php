@extends('client.layouts.app')
@section('title', 'Giỏ hàng của bạn - LaptopStore')

@section('content')

<div class="page-banner">
    <div class="container">
        <h1><i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Giỏ hàng</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    @if(empty($cart))
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-cart-x"></i></div>
            <h5>Giỏ hàng của bạn đang trống</h5>
            <p class="text-muted">Hãy thêm sản phẩm yêu thích vào giỏ hàng nhé!</p>
            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill mt-2 px-4">
                <i class="bi bi-bag-plus me-2"></i>Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-table-card">
                    <h5 class="fw-700 mb-3" style="font-weight:700;">
                        <i class="bi bi-cart3 me-2" style="color:var(--primary)"></i>
                        {{ array_sum(array_column($cart, 'quantity')) }} sản phẩm
                    </h5>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                        <img src="{{ $item['image'] ? asset('storage/products/' . $item['image']) : 'https://placehold.co/80x70/f8f9fa/999?text=Laptop' }}"
                             class="cart-item-img"
                             alt="{{ $item['name'] }}"
                             onerror="this.src='https://placehold.co/80x70/f8f9fa/999?text=Laptop'">
                        <div class="flex-grow-1">
                            <div style="font-weight:600;font-size:0.9rem;line-height:1.4;margin-bottom:4px;">
                                <a href="{{ route('product.show', $item['slug']) }}" style="color:inherit;text-decoration:none;">{{ $item['name'] }}</a>
                            </div>
                            <div style="color:var(--accent);font-weight:700;font-size:0.95rem;">
                                {{ number_format($item['price'], 0, ',', '.') }}đ
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <input type="number"
                                   class="cart-qty-input form-control form-control-sm text-center"
                                   data-product-id="{{ $id }}"
                                   value="{{ $item['quantity'] }}"
                                   min="1" max="99"
                                   style="width:65px;font-weight:700;">
                        </div>
                        <div style="font-weight:700;min-width:110px;text-align:right;color:var(--text-dark);">
                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                        </div>
                        <button class="btn-remove-cart btn btn-sm btn-outline-danger rounded-circle"
                                data-product-id="{{ $id }}" title="Xóa">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary">
                    <h5 style="font-weight:700;margin-bottom:1rem;">Tóm tắt đơn hàng</h5>

                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem;">
                        <span class="text-muted" style="max-width:65%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $item['name'] }} × {{ $item['quantity'] }}
                        </span>
                        <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                    </div>
                    @endforeach

                    <hr>
                    <div class="d-flex justify-content-between mb-2" style="font-size:0.88rem;">
                        <span class="text-muted">Phí vận chuyển</span>
                        <span class="text-success fw-semibold">Miễn phí</span>
                    </div>
                    <div class="cart-total-line d-flex justify-content-between align-items-center">
                        <span style="font-weight:700;font-size:1rem;">Tổng cộng</span>
                        <span class="cart-total-price" id="cart-total-display">
                            <span>{{ number_format($total, 0, ',', '.') }}</span>đ
                        </span>
                    </div>

                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary w-100 mt-3 rounded-pill fw-bold py-3"
                       style="font-size:1rem;">
                        <i class="bi bi-bag-check me-2"></i>Thanh toán ngay
                    </a>
                    <div class="text-center mt-2" style="font-size:0.75rem;color:#999;">
                        <i class="bi bi-shield-lock me-1"></i>Thanh toán bảo mật & an toàn
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
