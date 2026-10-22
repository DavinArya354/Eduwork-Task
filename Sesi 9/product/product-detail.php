<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/app.php";

// Ambil ID produk dari URL.
$productId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$productId || $productId < 1) {
    http_response_code(400);
    exit("ID produk tidak valid.");
}

try {
    // Ambil informasi produk.
    $stmt = $pdo->prepare(
        "SELECT id, name, description, image, price, stock, category
         FROM products
         WHERE id = :id"
    );

    $stmt->execute(["id" => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        http_response_code(404);
        exit("Produk tidak ditemukan.");
    }

    // Ambil seluruh gambar tambahan produk.
    $imageStmt = $pdo->prepare(
        "SELECT image_path
         FROM product_images
         WHERE product_id = :id
         ORDER BY id ASC"
    );

    $imageStmt->execute(["id" => $productId]);
    $extraImages = $imageStmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("Terjadi kesalahan saat mengambil data produk.");
}

// Gambar utama berasal dari tabel products.
// Gambar tambahan berasal dari tabel product_images.
$images = [];

$mainImageUrl = product_image_url($product["image"]);
if ($mainImageUrl !== "") {
    $images[] = $mainImageUrl;
}

foreach ($extraImages as $imagePath) {
    $imageUrl = product_image_url($imagePath);
    if ($imageUrl !== "" && !in_array($imageUrl, $images, true)) {
        $images[] = $imageUrl;
    }
}

// Jika produk belum memiliki gambar, gunakan placeholder.
if (empty($images)) {
    $images[] = "https://placehold.co/600x600?text=No+Image";
}

// Fungsi untuk mengamankan teks sebelum ditampilkan di HTML.
function e(string $value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        "UTF-8"
    );
}

// Format harga Rupiah.
$formattedPrice = "Rp " . number_format(
    (float) $product["price"],
    0,
    ",",
    "."
);

$storeLayout = true;
$activePage = "product";
$cart = is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : [];
$cartCount = array_sum(array_map(
    static fn ($item) => is_array($item) ? max(0, (int) ($item["qty"] ?? 0)) : 0,
    $cart
));

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail produk Arctic Store.">

    <title><?= e($product["name"]) ?> - Arctic Store</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= e(BASE_URL) ?>css/style.css">
    <link rel="stylesheet" href="<?= e(BASE_URL) ?>product/product-detail.css">
</head>

<body class="product-detail-page">
<?php require __DIR__ . "/../components/header.php"; ?>

<main class="container py-5">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= e(BASE_URL) ?>user/home.html#product-list">Produk</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Produk
            </li>
        </ol>
    </nav>

    <div class="detail-card">
        <div class="row g-4">

            <!-- Galeri gambar -->
            <div class="col-lg-6">
                <div
                    id="productCarousel"
                    class="carousel slide product-gallery"
                    data-bs-ride="false"
                >
                    <div class="carousel-inner">

                        <?php foreach ($images as $index => $image): ?>
                            <div class="carousel-item <?= $index === 0 ? "active" : "" ?>">
                                <img
                                    src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                                    class="d-block"
                                    alt="<?= e($product["name"]) ?> - gambar <?= $index + 1 ?>"
                                >
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <?php if (count($images) > 1): ?>
                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#productCarousel"
                            data-bs-slide="prev"
                            aria-label="Gambar sebelumnya"
                        >
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                        </button>

                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#productCarousel"
                            data-bs-slide="next"
                            aria-label="Gambar berikutnya"
                        >
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                        </button>
                    <?php endif; ?>
                </div>

                <p class="text-muted small mt-2">
                    <?= count($images) ?> gambar produk
                </p>
            </div>

            <!-- Informasi produk -->
            <div class="col-lg-6">
                <span class="badge text-bg-primary mb-2">
                    <?= e($product["category"]) ?>
                </span>

                <h1 class="h2 fw-bold mb-3">
                    <?= e($product["name"]) ?>
                </h1>

                <p class="detail-price mb-3">
                    <?= e($formattedPrice) ?>
                </p>

                <p class="text-muted mb-4">
                    <i class="bi bi-box-seam me-2"></i>
                    Stok tersedia: <?= (int) $product["stock"] ?>
                </p>

                <hr>

                <h2 class="h5 fw-bold">Deskripsi Produk</h2>

                <div class="detail-description mb-4">
                    <?= e($product["description"] ?? "") ?>
                </div>

                <?php if ((int) $product["stock"] > 0): ?>
                    <form method="POST" action="<?= e(BASE_URL) ?>user/cart.php">
                        <input
                            type="hidden"
                            name="action"
                            value="add_to_cart"
                        >
                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= (int) $product["id"] ?>"
                        >

                        <div class="mb-3">
                            <label for="quantity" class="form-label">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                class="form-control quantity-input"
                                id="quantity"
                                name="quantity"
                                value="1"
                                min="1"
                                max="<?= (int) $product["stock"] ?>"
                                required
                            >
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button
                                type="submit"
                                class="btn btn-warning flex-fill"
                            >
                                <i class="bi bi-cart-plus me-2"></i>
                                Add to Cart
                            </button>

                            <a
                                href="checkout.php?product_id=<?= (int) $product["id"] ?>"
                                class="btn btn-primary flex-fill"
                            >
                                <i class="bi bi-credit-card me-2"></i>
                                Checkout
                            </a>
                        </div>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary w-100" disabled>
                        Stok Habis
                    </button>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
