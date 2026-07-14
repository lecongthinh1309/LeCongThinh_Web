@extends('client.layouts.app')
@section('title', 'Thanh toán - LaptopStore')

@section('content')

<div class="page-banner">
    <div class="container">
        <h1><i class="bi bi-bag-check me-2"></i>Thanh toán</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                <li class="breadcrumb-item active">Thanh toán</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        {{-- CHECKOUT FORM --}}
        <div class="col-lg-7">
            <div class="checkout-card">
                <h5 style="font-weight:800;margin-bottom:1.5rem;">
                    <i class="bi bi-person-lines-fill me-2" style="color:var(--primary)"></i>Thông tin giao hàng
                </h5>

                <form action="{{ route('cart.placeOrder') }}" method="POST">
                    @csrf

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-3" style="font-size:0.88rem;">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="fullname" value="{{ old('fullname') }}"
                               class="form-control @error('fullname') is-invalid @enderror"
                               placeholder="Nguyễn Văn A">
                        @error('fullname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="email@example.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="0901234567">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="form-control @error('address') is-invalid @enderror"
                               placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành">
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">Ghi chú</label>
                        <textarea name="note" class="form-control" rows="3"
                                  placeholder="Ghi chú thêm về đơn hàng (không bắt buộc)...">{{ old('note') }}</textarea>
                    </div>

                    {{-- Payment method (UI only) --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">Phương thức thanh toán</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <label style="border:2px solid var(--primary);border-radius:10px;padding:12px 16px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:0.88rem;font-weight:600;color:var(--primary);">
                                <input type="radio" name="payment" value="cod" checked style="accent-color:var(--primary);">
                                <i class="bi bi-cash-coin fs-5"></i> Thanh toán khi nhận hàng
                            </label>
                            <label style="border:2px solid #e9ecef;border-radius:10px;padding:12px 16px;cursor:pointer;display:flex;align-items:center;gap:8px;font-size:0.88rem;font-weight:600;color:#888;">
                                <input type="radio" name="payment" value="bank" disabled style="accent-color:var(--primary);">
                                <i class="bi bi-bank fs-5"></i> Chuyển khoản ngân hàng
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold" style="font-size:1.05rem;">
                        <i class="bi bi-bag-check me-2"></i>Đặt hàng ngay
                    </button>
                </form>
            </div>
        </div>

        {{-- ORDER SUMMARY --}}
        <div class="col-lg-5">
            <div class="checkout-summary">
                <h5>Đơn hàng của bạn</h5>

                @php $total = 0; @endphp
                @foreach($cart as $item)
                @php $total += $item['price'] * $item['quantity']; @endphp
                <div class="summary-item d-flex justify-content-between align-items-center">
                    <div style="max-width:65%">
                        <div style="font-size:0.85rem;font-weight:600;color:#fff;">{{ $item['name'] }}</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);">Số lượng: {{ $item['quantity'] }}</div>
                    </div>
                    <div style="font-size:0.9rem;color:rgba(255,255,255,0.9);font-weight:600;">
                        {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top:1px solid rgba(255,255,255,0.1);">
                    <span style="color:rgba(255,255,255,0.7);font-size:0.88rem;">Phí vận chuyển</span>
                    <span style="color:#28a745;font-weight:600;font-size:0.88rem;">Miễn phí</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top:2px solid rgba(255,255,255,0.2);">
                    <span style="color:#fff;font-weight:700;font-size:1rem;">Tổng cộng</span>
                    <span class="total-amount">{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>

                <div class="mt-4 p-3 rounded-3" style="background:rgba(255,255,255,0.05);font-size:0.8rem;color:rgba(255,255,255,0.6);">
                    <i class="bi bi-shield-check me-1" style="color:#0066FF"></i> Thông tin của bạn được bảo mật tuyệt đối.<br>
                    <i class="bi bi-truck me-1 mt-2 d-inline-block" style="color:#0066FF"></i> Giao hàng toàn quốc 2–5 ngày làm việc.
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
