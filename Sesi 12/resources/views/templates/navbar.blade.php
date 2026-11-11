<header id="store-header">
    <nav class="navbar navbar-dark custom-navbar cart-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">
                <i class="bi bi-bag-fill" aria-hidden="true"></i>
                ArcticStore
            </a>

            @unless (request()->routeIs('cart.page'))
                <form class="nav-search-form" role="search" aria-label="Cari produk" action="{{ url('/') }}" method="get">
                    <label class="visually-hidden" for="searchInput">Cari produk</label>
                    <div class="input-group">
                        <span class="input-group-text" aria-hidden="true"><i class="bi bi-search"></i></span>
                        <input
                            type="search"
                            id="searchInput"
                            name="q"
                            class="form-control"
                            placeholder="Cari produk..."
                            autocomplete="off"
                            value="{{ request('q', '') }}">
                    </div>
                </form>
            @endunless

            <div class="navbar-links">
                <ul class="navbar-nav flex-row align-items-center">
                    <li class="nav-item">
                        <a
                            class="nav-link{{ request()->is('/') ? ' active text-warning' : '' }}"
                            @if (request()->is('/')) aria-current="page" @endif
                            href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link{{ request()->is('products') ? ' active text-warning' : '' }}"
                            @if (request()->is('products')) aria-current="page" @endif
                            href="{{ url('/#product-list') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link cart-link{{ request()->routeIs('cart.page') ? ' active text-warning' : '' }}"
                            @if (request()->routeIs('cart.page')) aria-current="page" @endif
                            href="{{ route('cart.page') }}"
                            aria-label="Keranjang">
                            <i class="bi bi-cart3" aria-hidden="true"></i>
                            <span class="cart-badge" id="cart-count">{{ collect(session('cart', []))->sum(fn ($item) => is_array($item) ? max(0, (int) ($item['qty'] ?? 0)) : 0) }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
