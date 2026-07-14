@php
    $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));
    $categories = \App\Models\Category::where('status', 1)->take(6)->get();
    $brands = \App\Models\Brand::where('status', 1)->take(8)->get();
@endphp

<nav class="client-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-laptop me-1"></i>Laptop<span>Store</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'text-white fw-semibold' : '' }}" href="{{ route('home') }}">
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Danh mục</a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $cat)
                            <li>
                                <a class="dropdown-item" href="{{ route('product.category', $cat->slug) }}">
                                    {{ $cat->catename }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Thương hiệu</a>
                    <ul class="dropdown-menu">
                        @foreach($brands as $brand)
                            <li>
                                <a class="dropdown-item" href="{{ route('product.brand', $brand->slug) }}">
                                    {{ $brand->brandname }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            {{-- Search --}}
            <form action="{{ route('product.search') }}" method="GET" class="search-form d-flex me-3">
                <input class="form-control" type="search" name="keyword"
                       value="{{ request('keyword') }}"
                       placeholder="Tìm kiếm laptop...">
                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
            </form>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="cart-btn nav-link position-relative">
                <i class="bi bi-cart3 me-1"></i> Giỏ hàng
                <span id="cart-count-badge" class="cart-count" style="{{ $cartCount > 0 ? '' : 'display:none' }}">
                    {{ $cartCount }}
                </span>
            </a>
        </div>
    </div>
</nav>
