<?php

$pageTitle = "New Releases";

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../components/header.php";


// Ambil 8 produk terbaru
$sql = "
    SELECT *
    FROM products
    ORDER BY id DESC
    LIMIT 8
";

$stmt = $pdo->query($sql);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- ================= NEW RELEASES ================= -->

<head>
    <link rel="stylesheet" href="../css/style.css">
</head>

<section class="py-5">
<div class="container">
    <!-- Section Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                New Releases
            </h1>

            <p class="text-muted mb-0">
                Check out our latest products.
            </p>
        </div>

        <a href="products.php"
           class="btn btn-outline-primary">

            View All
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>


    <!-- Product List -->
    <div class="row g-4">
        <?php if (empty($products)): ?>

            <div class="col-12">
                <div class="empty-product text-center py-5">
                    <i class="bi bi-box-seam display-4"></i>

                    <h4 class="mt-3">
                        No products available
                    </h4>

                    <p class="text-muted">
                        There are currently no products.
                    </p>
                </div>
            </div>

        <?php else: ?>

            <?php foreach ($products as $product): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <div class="card product-card h-100">
                        <!-- Product Image -->

                        <div class="product-image-wrapper">
                            <?php if (!empty($product["image"])): ?>

                                <img
                                    src="../<?= htmlspecialchars($product["image"]) ?>"
                                    class="card-img-top product-image"
                                    alt="<?= htmlspecialchars($product["name"]) ?>">

                            <?php else: ?>
                                <div class="product-no-image">

                                    <i class="bi bi-image"></i>

                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product Body -->
                        <div class="card-body d-flex flex-column">
                            <!-- Category -->
                            <span class="badge product-category align-self-start mb-2">
                                <?= htmlspecialchars($product["category"]) ?>
                            </span>

                            <!-- Name -->
                            <h5 class="card-title fw-bold">
                                <?= htmlspecialchars($product["name"]) ?>
                            </h5>

                            <!-- Description -->
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars($product["description"]) ?>
                            </p>

                            <!-- Price -->
                            <h5 class="product-price mt-auto">
                                Rp <?= number_format(
                                    $product["price"],
                                    0,
                                    ",",
                                    "."
                                ) ?>
                            </h5>

                            <!-- Stock -->
                            <p class="small text-muted">
                                <i class="bi bi-box"></i>
                                Stock:
                                <?= htmlspecialchars($product["stock"]) ?>
                            </p>

                            <!-- Action -->
                            <a
                                href="product-detail.php?id=<?= $product["id"] ?>"
                                class="btn btn-primary w-100">
                                View Product
                            </a>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>
</section>

<?php

require_once __DIR__ . "/../components/footer.php";

?>
