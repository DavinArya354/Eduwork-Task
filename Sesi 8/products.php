<?php

$pageTitle = "All Products";

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../components/header.php";

// Ambil seluruh produk
$sql = "
    SELECT *
    FROM products
    ORDER BY id DESC
";

$stmt = $pdo->query($sql);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="py-5">

<div class="container">

    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="fw-bold">
            All Products
        </h1>

        <p class="text-muted">
            Browse all products available in our store.
        </p>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">

        <?php if (empty($products)): ?>

            <div class="col-12">
                <div class="empty-product text-center py-5">
                    <i class="bi bi-box-seam display-4"></i>

                    <h4 class="mt-3">
                        No products found
                    </h4>
                </div>
            </div>

        <?php else: ?>

            <?php foreach ($products as $product): ?>

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card product-card h-100">

                        <div class="product-image-wrapper">
                            <?php if (!empty($product["image"])): ?>

                                <img
                                    src="../<?= htmlspecialchars($product["image"]) ?>"
                                    class="product-image"
                                    alt="<?= htmlspecialchars($product["name"]) ?>">

                            <?php else: ?>

                                <div class="product-no-image">
                                    <i class="bi bi-image"></i>
                                </div>

                            <?php endif; ?>
                        </div>


                        <div class="card-body d-flex flex-column">
                            <span class="badge product-category align-self-start mb-2">
                                <?= htmlspecialchars($product["category"]) ?>
                            </span>

                            <h5 class="card-title fw-bold">
                                <?= htmlspecialchars($product["name"]) ?>
                            </h5>

                            <p class="card-text text-muted small">
                                <?= htmlspecialchars($product["description"]) ?>
                            </p>

                            <h5 class="product-price mt-auto">
                                Rp <?= number_format(
                                    $product["price"],
                                    0,
                                    ",",
                                    "."
                                ) ?>
                            </h5>

                            <p class="small text-muted">
                                <i class="bi bi-box"></i>
                                Stock:
                                <?= htmlspecialchars($product["stock"]) ?>
                            </p>

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
