<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Belanja produk pilihan di Arctic Store.">
    <title>Arctic Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body class="home-page" id="top">
    @include('template.navbar')

    <main>
        <section class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold">
                            Belanja Jadi
                            <span class="text-warning">Lebih Mudah</span>
                        </h1>
                        <p class="mt-3">
                            Temukan berbagai produk elektronik,
                            aksesoris, dan gadget dengan harga terbaik.
                        </p>
                        <a class="btn btn-warning btn-lg mt-3" href="#product-list">Belanja Sekarang</a>
                    </div>
                    <div class="col-lg-6 text-center" aria-hidden="true">
                        <i class="bi bi-bag-heart-fill hero-art"></i>
                    </div>
                </div>
            </div>
        </section>

        <section class="container py-5">
            <div class="row">
                <aside class="col-md-3 mb-4">
                    <div class="card filter-card shadow-sm">
                        <div class="card-header fw-bold">Filter Produk</div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="categoryFilter" class="form-label">Kategori</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="Semua">Semua</option>
                                    <option value="Gadget">Gadget</option>
                                    <option value="Gaming">Gaming</option>
                                    <option value="Aksesoris">Aksesoris</option>
                                    <option value="Computer">Computer</option>
                                </select>
                            </div>
                            <div>
                                <label for="priceFilter" class="form-label">Harga</label>
                                <select id="priceFilter" class="form-select">
                                    <option value="all">Semua</option>
                                    <option value="0-500000">Di bawah Rp500.000</option>
                                    <option value="500000-2000000">Rp500rb - Rp2jt</option>
                                    <option value="2000000-5000000">Rp2jt - Rp5jt</option>
                                    <option value="5000000+">Di atas Rp5jt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </aside>

                <section class="col-md-9" aria-labelledby="products-heading">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <h2 class="h3 mb-0" id="products-heading">Produk Terbaru</h2>
                        <label class="visually-hidden" for="sortFilter">Urutkan produk</label>
                        <select id="sortFilter" class="form-select w-auto">
                            <option value="">Urutkan</option>
                            <option value="low-high">Harga Terendah</option>
                            <option value="high-low">Harga Tertinggi</option>
                            <option value="az">Nama A-Z</option>
                            <option value="za">Nama Z-A</option>
                        </select>
                    </div>

                    <div class="row g-4" id="product-list" aria-live="polite">
                        @foreach ($showcaseProducts as $product)
                            <div
                                class="col-6 col-sm-4 product-item"
                                data-name="{{ $product['name'] }}"
                                data-category="{{ $product['category'] }}"
                                data-description="{{ $product['description'] }}"
                                data-price="{{ $product['price'] }}">
                                <article class="card product-card h-100 shadow-sm">
                                    <img
                                        src="{{ asset('images/image.jpg') }}"
                                        class="card-img-top"
                                        alt="{{ $product['name'] }}"
                                        loading="lazy">
                                    <div class="card-body d-flex flex-column">
                                        <span class="product-category mb-2">{{ $product['category'] }}</span>
                                        <h3 class="h5 card-title">{{ $product['name'] }}</h3>
                                        <p class="small text-muted mb-2">{{ $product['description'] }}</p>
                                        <h4 class="product-price fw-bold mt-auto">
                                            Rp{{ number_format($product['price'], 0, ',', '.') }}
                                        </h4>
                                        <a class="btn btn-primary w-100 mt-3" href="#product-list">
                                            <i class="bi bi-eye me-1" aria-hidden="true"></i>Detail Produk
                                        </a>
                                        <form method="post" action="{{ route('cart.update') }}">
                                            @csrf
                                            <input type="hidden" name="action" value="add_to_cart">
                                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                            <button class="btn btn-warning w-100 mt-3" type="submit">
                                                <i class="bi bi-cart-plus me-1" aria-hidden="true"></i>Tambah ke Keranjang
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                        <div class="col-12 d-none" id="empty-filter-results">
                            <div class="alert alert-warning text-center">Produk tidak ditemukan.</div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>

    @include('template.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}" defer></script>
</body>
</html>
