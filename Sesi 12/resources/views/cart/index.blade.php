<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Keranjang belanja Arctic Store">
        <title>Keranjang - Arctic Store</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    </head>
    <body class="cart-page" id="top">
        @include('template.navbar')

        <main class="container cart-main py-5">
            <h1 class="mb-4">Keranjang</h1>

            @if (session('cart_notice'))
                @php
                    $notice = session('cart_notice');
                    $noticeType = in_array($notice['type'] ?? '', ['success', 'warning', 'danger', 'info'], true)
                        ? $notice['type']
                        : 'info';
                @endphp
                <div class="alert alert-{{ $noticeType }}" role="alert">
                    {{ $notice['message'] ?? '' }}
                </div>
            @endif

            @if ($cart->isEmpty())
                <div class="card shadow-sm">
                    <div class="card-body cart-empty text-center py-5">
                        <i class="bi bi-cart-x display-1 text-secondary" aria-hidden="true"></i>
                        <h2 class="h4 mt-3">Keranjang Masih Kosong</h2>
                        <p class="text-muted">Yuk tambahkan produk terlebih dahulu.</p>
                        <a href="{{ url('/#product-list') }}" class="btn btn-success">Lihat Produk</a>
                    </div>
                </div>
            @else
                <div class="cart-layout">
                    <section class="cart-products" aria-label="Daftar produk di keranjang">
                        <form id="cart-form" method="post" action="{{ route('cart.update') }}">
                            @csrf
                            <input type="hidden" name="action" value="update_selection">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white cart-toolbar">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="check-all"
                                                {{ $allSelected ? 'checked' : '' }}
                                                aria-label="Pilih semua produk">
                                            <label class="form-check-label" for="check-all">Pilih Semua</label>
                                        </div>

                                        <button class="btn btn-danger" type="submit" form="clear-cart-form">
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                            Kosongkan Keranjang
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="cart-list">
                                        @foreach ($cart as $item)
                                            <article class="cart-item">
                                                <div class="cart-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input item-check"
                                                        name="selected_ids[]"
                                                        value="{{ $item['id'] }}"
                                                        {{ $item['selected'] ? 'checked' : '' }}
                                                        aria-label="Pilih {{ $item['name'] }}">
                                                </div>

                                                <div class="cart-image">
                                                    @if ($item['image'] !== '')
                                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                                    @else
                                                        <div class="cart-image-placeholder" aria-hidden="true">
                                                            <i class="bi bi-image"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="cart-info">
                                                    <h2 class="h5">{{ $item['name'] }}</h2>
                                                    @if ($item['category'] !== '')
                                                        <p class="text-muted mb-2">{{ $item['category'] }}</p>
                                                    @endif
                                                    <div class="fw-semibold text-dark">
                                                        Rp{{ number_format($item['price'], 0, ',', '.') }}
                                                    </div>

                                                    <div class="qty-box mt-3">
                                                        <button
                                                            class="btn btn-minus"
                                                            type="submit"
                                                            name="action"
                                                            value="decrease:{{ $item['id'] }}"
                                                            aria-label="Kurangi jumlah {{ $item['name'] }}">
                                                            <i class="bi bi-dash" aria-hidden="true"></i>
                                                        </button>
                                                        <span>{{ $item['qty'] }}</span>
                                                        <button
                                                            class="btn btn-plus"
                                                            type="submit"
                                                            name="action"
                                                            value="increase:{{ $item['id'] }}"
                                                            aria-label="Tambah jumlah {{ $item['name'] }}">
                                                            <i class="bi bi-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="cart-action">
                                                    <div class="subtotal-title">Subtotal</div>
                                                    <div class="subtotal-price">
                                                        Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                                    </div>
                                                    <button
                                                        class="btn btn-outline-danger btn-delete mt-3"
                                                        type="submit"
                                                        name="action"
                                                        value="remove:{{ $item['id'] }}"
                                                        aria-label="Hapus {{ $item['name'] }}">
                                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form id="clear-cart-form" method="post" action="{{ route('cart.update') }}">
                            @csrf
                            <input type="hidden" name="action" value="clear_cart">
                        </form>
                    </section>

                    <aside class="cart-summary" aria-label="Ringkasan belanja">
                        <div class="summary-card">
                            <h2 class="h4">Ringkasan Belanja</h2>
                            <hr>
                            <div class="summary-row">
                                <span>Produk Dipilih</span>
                                <span>{{ $selectedCount }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Total Item</span>
                                <span>{{ $selectedQuantity }}</span>
                            </div>
                            <hr>
                            <div class="summary-row">
                                <strong>Total</strong>
                                <strong>Rp{{ number_format($selectedTotal, 0, ',', '.') }}</strong>
                            </div>

                            <form method="post" action="{{ route('cart.update') }}">
                                @csrf
                                <input type="hidden" name="action" value="checkout">
                                <button
                                    id="checkout-btn"
                                    class="btn btn-success w-100 mt-3"
                                    type="submit"
                                    {{ $selectedCount === 0 ? 'disabled' : '' }}>
                                    Checkout
                                </button>
                            </form>
                        </div>
                    </aside>
                </div>
            @endif
        </main>

        @include('template.footer')

        <script src="{{ asset('js/cart.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
