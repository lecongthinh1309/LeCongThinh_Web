@extends('client.layouts.app')
@section('title', 'LaptopStore - Laptop Chính Hãng Giá Tốt Nhất')
@section('meta_description', 'Mua laptop chính hãng giá tốt, đa dạng thương hiệu Apple, Dell, HP, Lenovo, Asus, Acer. Bảo hành chính hãng, giao hàng toàn quốc.')

@section('content')

{{-- HERO SECTION --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="hero-badge"><i class="bi bi-lightning-charge-fill me-1"></i> Flash Sale hôm nay</span>
                <h1>Laptop <span class="highlight">Chính Hãng</span><br>Giá Tốt Nhất!</h1>
                <p>Đa dạng thương hiệu uy tín. Bảo hành chính hãng toàn quốc.<br>Giao hàng nhanh trong vòng 2 giờ.</p>
                <div class="mt-4">
                    <a href="#featured" class="btn-hero">
                        <i class="bi bi-bag-check me-2"></i>Mua ngay
                    </a>
                    <a href="#categories" class="btn-hero-outline">
                        <i class="bi bi-grid me-2"></i>Xem danh mục
                    </a>
                </div>
                <div class="hero-stats d-flex gap-4">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Sản phẩm</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Khách hàng</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Thương hiệu</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <div style="font-size:12rem;line-height:1;filter:drop-shadow(0 30px 40px rgba(0,102,255,0.3))">💻</div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURE BADGES --}}
<div style="background:var(--primary); padding: 1rem 0;">
    <div class="container">
        <div class="row text-center text-white g-0">
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-truck fs-5"></i>
                    <div class="text-start">
                        <div style="font-size:0.8rem;font-weight:700;">Miễn phí giao hàng</div>
                        <div style="font-size:0.7rem;opacity:0.8;">Đơn từ 5 triệu</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-shield-check fs-5"></i>
                    <div class="text-start">
                        <div style="font-size:0.8rem;font-weight:700;">Bảo hành chính hãng</div>
                        <div style="font-size:0.7rem;opacity:0.8;">12-24 tháng</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-arrow-repeat fs-5"></i>
                    <div class="text-start">
                        <div style="font-size:0.8rem;font-weight:700;">Đổi trả 30 ngày</div>
                        <div style="font-size:0.7rem;opacity:0.8;">Không cần lý do</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-2 py-1">
                    <i class="bi bi-headset fs-5"></i>
                    <div class="text-start">
                        <div style="font-size:0.8rem;font-weight:700;">Hỗ trợ 24/7</div>
                        <div style="font-size:0.7rem;opacity:0.8;">1800 1234 miễn phí</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CATEGORIES --}}
<section class="py-5" id="categories">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <div class="section-title">Danh mục sản phẩm</div>
                <div class="section-line"></div>
            </div>
        </div>
        <div class="row g-3">
            @foreach($categories as $cat)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('product.category', $cat->slug) }}" class="category-card">
                    <span class="cat-icon">💻</span>
                    <div class="cat-name">{{ $cat->catename }}</div>
                    <div class="cat-count">Xem ngay →</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS (Sale) --}}
<section class="py-5 bg-white" id="featured">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-danger mb-1" style="font-size:0.75rem;border-radius:6px;">🔥 HOT SALE</span>
                <div class="section-title">Sản phẩm giảm giá</div>
                <div class="section-line"></div>
            </div>
            <a href="{{ route('product.search', ['keyword' => '']) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-3">
            @forelse($featuredProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('client.partials.product-card', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-box-seam"></i></div>
                    <h5>Chưa có sản phẩm</h5>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- PROMO BANNER --}}
<section class="py-4">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-6">
                <div style="background:linear-gradient(135deg,#0066FF,#00c6ff);border-radius:16px;padding:2rem;color:#fff;min-height:150px;display:flex;align-items:center;gap:1.5rem;">
                    <div style="font-size:3.5rem;">🎁</div>
                    <div>
                        <div style="font-weight:800;font-size:1.2rem;margin-bottom:4px;">Ưu đãi sinh viên</div>
                        <div style="opacity:0.85;font-size:0.9rem;">Giảm thêm 5% với thẻ sinh viên</div>
                        <a href="#" class="btn btn-sm btn-light mt-2 rounded-pill fw-600" style="color:var(--primary);font-weight:600;">Tìm hiểu thêm</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div style="background:linear-gradient(135deg,#FF6B35,#f7c948);border-radius:16px;padding:2rem;color:#fff;min-height:150px;display:flex;align-items:center;gap:1.5rem;">
                    <div style="font-size:3.5rem;">⚡</div>
                    <div>
                        <div style="font-weight:800;font-size:1.2rem;margin-bottom:4px;">Trả góp 0%</div>
                        <div style="opacity:0.85;font-size:0.9rem;">12 tháng không lãi suất qua thẻ tín dụng</div>
                        <a href="#" class="btn btn-sm btn-light mt-2 rounded-pill" style="color:#FF6B35;font-weight:600;">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- NEW PRODUCTS --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success mb-1" style="font-size:0.75rem;border-radius:6px;">✨ MỚI NHẤT</span>
                <div class="section-title">Sản phẩm mới về</div>
                <div class="section-line"></div>
            </div>
            <a href="{{ route('product.search', ['keyword' => '']) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-3">
            @forelse($newProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('client.partials.product-card', ['product' => $product, 'isNew' => true])
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-box-seam"></i></div>
                    <h5>Chưa có sản phẩm</h5>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- BRANDS --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <div class="section-title">Thương hiệu uy tín</div>
            <p class="section-subtitle">Chúng tôi là đối tác chính thức của các thương hiệu hàng đầu thế giới</p>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach($brands as $brand)
            <div class="col-4 col-md-2">
                <a href="{{ route('product.brand', $brand->slug) }}"
                   style="display:block;background:#fff;border:1.5px solid #e9ecef;border-radius:10px;padding:1rem;text-align:center;text-decoration:none;transition:all 0.3s;font-weight:700;color:#1a1a2e;font-size:0.85rem;"
                   onmouseover="this.style.borderColor='#0066FF';this.style.color='#0066FF';"
                   onmouseout="this.style.borderColor='#e9ecef';this.style.color='#1a1a2e';">
                    <div style="font-size:1.8rem;margin-bottom:4px;">💻</div>
                    {{ $brand->brandname }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
