<footer class="client-footer">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="footer-brand"><i class="bi bi-laptop me-1"></i>Laptop<span>Store</span></div>
                <p>Chuyên cung cấp laptop chính hãng, giá tốt nhất thị trường. Cam kết bảo hành chính hãng, hỗ trợ 24/7.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,0.1);color:#fff;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,0.1);color:#fff;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,0.1);color:#fff;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6>Danh mục</h6>
                <ul class="list-unstyled">
                    @foreach(\App\Models\Category::where('status',1)->take(5)->get() as $cat)
                        <li class="mb-1"><a href="{{ route('product.category', $cat->slug) }}">{{ $cat->catename }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6>Hỗ trợ</h6>
                <ul class="list-unstyled">
                    <li class="mb-1"><a href="#">Chính sách bảo hành</a></li>
                    <li class="mb-1"><a href="#">Chính sách đổi trả</a></li>
                    <li class="mb-1"><a href="#">Hướng dẫn mua hàng</a></li>
                    <li class="mb-1"><a href="#">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h6>Liên hệ</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2" style="color:#0066FF"></i>123 Nguyễn Văn Linh, TP.HCM</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2" style="color:#0066FF"></i>1800 1234 (Miễn phí)</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2" style="color:#0066FF"></i>support@laptopstore.vn</li>
                    <li class="mb-2"><i class="bi bi-clock me-2" style="color:#0066FF"></i>8:00 – 21:00, Thứ 2 – Chủ nhật</li>
                </ul>
            </div>
        </div>
        <div class="border-top pt-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="mb-0" style="font-size:0.82rem;">© {{ date('Y') }} LaptopStore. All rights reserved.</p>
            <p class="mb-0" style="font-size:0.82rem;">Designed with <i class="bi bi-heart-fill text-danger"></i> by LaptopStore Team</p>
        </div>
    </div>
</footer>
