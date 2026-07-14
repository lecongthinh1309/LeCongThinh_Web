// Cart count badge update helper
function updateCartCount(count) {
    const badge = document.getElementById('cart-count-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }
}

// Show toast notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const icon = type === 'success' ? '✓' : '✗';
    const bg = type === 'success' ? '#28a745' : '#dc3545';

    const toast = document.createElement('div');
    toast.className = 'toast-success';
    toast.style.background = bg;
    toast.innerHTML = `<span>${icon}</span> ${message}`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(60px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add to cart via AJAX
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Add to cart buttons
    document.querySelectorAll('.btn-add-cart, .btn-add-cart-detail').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const qtyInput = document.getElementById('qty-input');
            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
            const originalText = this.innerHTML;

            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang thêm...';
            this.disabled = true;

            fetch('/gio-hang/them', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    showToast(data.message);
                    this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Đã thêm!';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 1800);
                }
            })
            .catch(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                showToast('Có lỗi xảy ra!', 'error');
            });
        });
    });

    // Qty controls in product detail
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    const qtyInput = document.getElementById('qty-input');

    if (qtyMinus && qtyPlus && qtyInput) {
        qtyMinus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (val > 1) qtyInput.value = val - 1;
        });
        qtyPlus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            qtyInput.value = val + 1;
        });
    }

    // Cart item update/remove
    document.querySelectorAll('.cart-qty-input').forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.dataset.productId;
            const quantity = parseInt(this.value);

            fetch('/gio-hang/cap-nhat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    document.getElementById('cart-total-display')?.querySelector('span')
                        && (document.getElementById('cart-total-display').querySelector('span').textContent =
                            new Intl.NumberFormat('vi-VN').format(data.total) + ' đ');
                    location.reload();
                }
            });
        });
    });

    document.querySelectorAll('.btn-remove-cart').forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.productId;

            fetch('/gio-hang/xoa', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    location.reload();
                }
            });
        });
    });

    // Scroll to top button
    const scrollBtn = document.getElementById('scrollTopBtn');
    if (scrollBtn) {
        window.addEventListener('scroll', () => {
            scrollBtn.classList.toggle('show', window.scrollY > 300);
        });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }
});
