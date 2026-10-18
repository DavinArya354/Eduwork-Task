<?php
require_once __DIR__ . "/cart-logic.php";
?>
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
    <link rel="stylesheet" href="<?= e(BASE_URL) ?>css/style.css">
    <link rel="stylesheet" href="<?= e(BASE_URL) ?>user/style.css">
</head>
<body class="cart-page">
    <?php
    $storeLayout = true;
    $activePage = "cart";
    require __DIR__ . "/../components/header.php";
    ?>

    <main class="container py-5">
        <h1 class="mb-4">Keranjang</h1>

        <?php if (is_array($notice) && isset($notice["message"])): ?>
            <?php $noticeType = in_array($notice["type"] ?? "", ["success", "warning", "danger", "info"], true) ? $notice["type"] : "info"; ?>
            <div class="alert alert-<?= e($noticeType) ?>" role="alert">
                <?= e((string) $notice["message"]) ?>
            </div>
        <?php endif; ?>

        <?php if (count($cart) === 0): ?>
            <div class="card shadow-sm">
                <div class="card-body cart-empty text-center py-5">
                    <i class="bi bi-cart-x display-1 text-secondary"></i>
                    <h2 class="h4 mt-3">Keranjang Masih Kosong</h2>
                    <p class="text-muted">Yuk tambahkan produk terlebih dahulu.</p>
                    <a href="<?= e(BASE_URL) ?>user/home.html#product-list" class="btn btn-success">
                        Lihat Produk
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <section class="cart-products" aria-label="Daftar produk di keranjang">
                    <form id="cart-form" method="post" action="<?= e(BASE_URL) ?>user/cart.php">
                        <input type="hidden" name="action" value="update_selection">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white cart-toolbar">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="check-all"
                                            <?= $allSelected ? "checked" : "" ?>
                                            aria-label="Pilih semua produk"
                                        >
                                        <label class="form-check-label" for="check-all">Pilih Semua</label>
                                    </div>

                                    <button
                                        class="btn btn-danger"
                                        type="submit"
                                        form="clear-cart-form"
                                    >
                                        <i class="bi bi-trash"></i>
                                        Kosongkan Keranjang
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="cart-list">
                                    <?php foreach ($cart as $item): ?>
                                        <?php if (!is_array($item)) { continue; } ?>
                                        <?php
                                            $productId = (int) ($item["id"] ?? 0);
                                            $name = (string) ($item["name"] ?? "Produk");
                                            $image = (string) ($item["image"] ?? "");
                                            $category = (string) ($item["category"] ?? "");
                                            $price = (float) ($item["price"] ?? 0);
                                            $quantity = max(1, (int) ($item["qty"] ?? 1));
                                        ?>
                                        <article class="cart-item">
                                            <div class="cart-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input item-check"
                                                    name="selected_ids[]"
                                                    value="<?= $productId ?>"
                                                    <?= !empty($item["selected"]) ? "checked" : "" ?>
                                                    aria-label="Pilih <?= e($name) ?>"
                                                >
                                            </div>

                                            <div class="cart-image">
                                                <?php if ($image !== ""): ?>
                                                    <img src="<?= e($image) ?>" alt="<?= e($name) ?>">
                                                <?php else: ?>
                                                    <div class="cart-image-placeholder" aria-hidden="true">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="cart-info">
                                                <h2 class="h5"><?= e($name) ?></h2>
                                                <?php if ($category !== ""): ?>
                                                    <p class="text-muted mb-2"><?= e($category) ?></p>
                                                <?php endif; ?>
                                                <div class="fw-semibold text-dark"><?= e(rupiah($price)) ?></div>

                                                <div class="qty-box mt-3">
                                                    <button
                                                        class="btn btn-minus"
                                                        type="submit"
                                                        name="action"
                                                        value="decrease:<?= $productId ?>"
                                                        aria-label="Kurangi jumlah <?= e($name) ?>"
                                                    >
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <span><?= $quantity ?></span>
                                                    <button
                                                        class="btn btn-plus"
                                                        type="submit"
                                                        name="action"
                                                        value="increase:<?= $productId ?>"
                                                        aria-label="Tambah jumlah <?= e($name) ?>"
                                                    >
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="cart-action">
                                                <div class="subtotal-title">Subtotal</div>
                                                <div class="subtotal-price"><?= e(rupiah($price * $quantity)) ?></div>
                                                <button
                                                    class="btn btn-outline-danger btn-delete mt-3"
                                                    type="submit"
                                                    name="action"
                                                    value="remove:<?= $productId ?>"
                                                    aria-label="Hapus <?= e($name) ?>"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="clear-cart-form" method="post" action="<?= e(BASE_URL) ?>user/cart.php">
                        <input type="hidden" name="action" value="clear_cart">
                    </form>
                </section>

                <aside class="cart-summary" aria-label="Ringkasan belanja">
                    <div class="summary-card">
                        <h2 class="h4">Ringkasan Belanja</h2>
                        <hr>
                        <div class="summary-row">
                            <span>Produk Dipilih</span>
                            <span><?= $selectedCount ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Total Item</span>
                            <span><?= $selectedQuantity ?></span>
                        </div>
                        <hr>
                        <div class="summary-row">
                            <strong>Total</strong>
                            <strong><?= e(rupiah($selectedTotal)) ?></strong>
                        </div>

                        <form method="post" action="<?= e(BASE_URL) ?>user/cart.php">
                            <input type="hidden" name="action" value="checkout">
                            <button
                                id="checkout-btn"
                                class="btn btn-success w-100 mt-3"
                                type="submit"
                                <?= $selectedCount === 0 ? "disabled" : "" ?>
                            >
                                Checkout
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        <?php endif; ?>
    </main>

    <?php require __DIR__ . "/../components/footer.php"; ?>
    <script src="<?= e(BASE_URL) ?>user/cart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
