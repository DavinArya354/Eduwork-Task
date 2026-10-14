<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/app.php";
require_once __DIR__ . "/../components/header.php";

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

// Proses Add to Cart.
$cartMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    // Pastikan tombol Add to Cart yang ditekan.
    if ($action === "add_to_cart") {
        $quantity = filter_input(
            INPUT_POST,
            "quantity",
            FILTER_VALIDATE_INT
        );

        if (!$quantity || $quantity < 1) {
            $cartMessage = "Jumlah produk tidak valid.";
        } elseif ($product["stock"] < 1) {
            $cartMessage = "Stok produk sedang habis.";
        } else {
            // Buat keranjang jika belum tersedia.
            if (!isset($_SESSION["cart"])) {
                $_SESSION["cart"] = [];
            }

            // Hitung jumlah yang sudah ada di keranjang.
            $currentQty = $_SESSION["cart"][$productId]["qty"] ?? 0;

            if ($currentQty + $quantity > $product["stock"]) {
                $cartMessage = "Jumlah melebihi stok yang tersedia.";
            } else {
                $_SESSION["cart"][$productId] = [
                    "id" => (int) $product["id"],
                    "name" => $product["name"],
                    "price" => (float) $product["price"],
                    "qty" => $currentQty + $quantity,
                    "image" => $images[0]
                ];

                // Redirect agar form tidak terkirim ulang saat refresh.
                header("Location: cart.php");
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e($product["name"]) ?> - Arctic Store</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <!-- CSS project yang sudah ada -->
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .detail-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
        }

        .product-gallery {
            background: #f5f7fb;
            border-radius: 12px;
            overflow: hidden;
        }

        .product-gallery .carousel-item img {
            width: 100%;
            height: 420px;
            object-fit: contain;
        }

        .detail-price {
            color: #3620ff;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .detail-description {
            white-space: pre-line;
            line-height: 1.8;
        }

        .quantity-input {
            max-width: 100px;
        }

        @media (max-width: 767px) {
            .product-gallery .carousel-item img {
                height: 300px;
            }
        }
    </style>
</head>

<body>

<main class="container py-5">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="products.php">Produk</a>
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

                <?php if ($cartMessage !== ""): ?>
                    <div class="alert alert-warning" role="alert">
                        <?= e($cartMessage) ?>
                    </div>
                <?php endif; ?>

                <?php if ((int) $product["stock"] > 0): ?>
                    <form method="POST" action="">
                        <input
                            type="hidden"
                            name="action"
                            value="add_to_cart"
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

<!-- Bootstrap JavaScript Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php require_once __DIR__ . "/../components/footer.php"; ?>
