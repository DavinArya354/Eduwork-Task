<?php

$pageTitle = "All Products";

require_once __DIR__ . "/../config/database.php";

// =====================================================
// AMBIL KATEGORI
// =====================================================
$categorySql = "
    SELECT DISTINCT category
    FROM products
    WHERE category IS NOT NULL
    AND category != ''
    ORDER BY category ASC
";

$categoryStmt = $pdo->query($categorySql);

$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);

// =====================================================
// FILTER CATEGORY
// =====================================================
$selectedCategory = $_GET["category"] ?? "";

// =====================================================
// QUERY PRODUCT
// =====================================================
if ($selectedCategory !== "") {

    $sql = "
        SELECT *
        FROM products
        WHERE category = :category
        ORDER BY id DESC
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":category" => $selectedCategory
    ]);

} else {

    $sql = "
        SELECT *
        FROM products
        ORDER BY id DESC
    ";

    $stmt = $pdo->query($sql);

}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// =====================================================
// HEADER
// =====================================================
require_once __DIR__ . "/../components/header.php";

?>

<section class="py-5">

<div class="container">

    <!-- =================================================
         PAGE HEADER
         ================================================= -->
    <div class="d-flex flex-column flex-md-row
                justify-content-between
                align-items-md-center
                mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                All Products
            </h1>

            <p class="text-muted mb-0">
                Browse all products available in our store.
            </p>
        </div>

    </div>

    <!-- =================================================
         CATEGORY FILTER
         ================================================= -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">
            <form
                action="products.php"
                method="GET"
                class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label
                        for="category"
                        class="form-label fw-semibold">
                        Filter by Category
                    </label>

                    <select
                        name="category"
                        id="category"
                        class="form-select">

                        <option value="">
                            All Categories
                        </option>

                        <?php foreach ($categories as $category): ?>

                            <option
                                value="<?= htmlspecialchars($category) ?>"
                                <?= $selectedCategory === $category ? "selected" : "" ?>>

                                <?= htmlspecialchars($category) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="col-md-auto">
                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>
                </div>

                <?php if ($selectedCategory !== ""): ?>

                    <div class="col-md-auto">
                        <a
                            href="products.php"
                            class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i>
                            Clear
                        </a>
                    </div>

                <?php endif; ?>

            </form>
        </div>

    </div>

    <!-- =================================================
         ACTIVE FILTER
         ================================================= -->
    <?php if ($selectedCategory !== ""): ?>

        <div class="mb-4">
            <span class="text-muted">
                Showing products in:
            </span>

            <span class="badge product-category">
                <?= htmlspecialchars($selectedCategory) ?>
            </span>
        </div>

    <?php endif; ?>

    <!-- =================================================
         PRODUCT GRID
         ================================================= -->
    <div class="row g-4">

        <?php if (empty($products)): ?>

            <div class="col-12">

                <div class="empty-product text-center py-5">
                    <i class="bi bi-box-seam display-4"></i>

                    <h4 class="mt-3">
                        No products found
                    </h4>

                    <?php if ($selectedCategory !== ""): ?>

                        <p class="text-muted">
                            There are no products in the
                            <strong>
                                <?= htmlspecialchars($selectedCategory) ?>
                            </strong>
                            category.
                        </p>

                    <?php else: ?>

                        <p class="text-muted">
                            There are currently no products.
                        </p>

                    <?php endif; ?>

                    <a
                        href="products.php"
                        class="btn btn-primary">
                        View All Products
                    </a>
                </div>

            </div>

        <?php else: ?>

            <?php foreach ($products as $product): ?>

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <div class="card product-card h-100">
                        <!-- PRODUCT IMAGE -->
                        <div class="product-image-wrapper">

                            <?php if (!empty($product["image"])): ?>

                                <img
                                    src="/Eduwork/Sesi%207/<?= htmlspecialchars($product["image"]) ?>"
                                    class="product-image"
                                    alt="<?= htmlspecialchars($product["name"]) ?>">

                            <?php else: ?>

                                <div class="product-no-image">
                                    <i class="bi bi-image"></i>
                                </div>

                            <?php endif; ?>
                        </div>

                        <!-- PRODUCT BODY -->
                        <div class="card-body d-flex flex-column">

                            <!-- CATEGORY -->
                            <span
                                class="badge product-category align-self-start mb-2">
                                <?= htmlspecialchars($product["category"]) ?>
                            </span>

                            <!-- NAME -->
                            <h5 class="card-title fw-bold">
                                <?= htmlspecialchars($product["name"]) ?>
                            </h5>

                            <!-- DESCRIPTION -->
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars($product["description"]) ?>
                            </p>

                            <!-- PRICE -->
                            <h5 class="product-price mt-auto">
                                Rp <?= number_format(
                                    $product["price"],
                                    0,
                                    ",",
                                    "."
                                ) ?>
                            </h5>

                            <!-- STOCK -->
                            <p class="small text-muted">
                                <i class="bi bi-box"></i>
                                Stock:
                                <?= htmlspecialchars($product["stock"]) ?>
                            </p>

                            <!-- ACTIONS -->
                            <div class="d-flex gap-2">
                                <!-- UPDATE -->
                                <a
                                    href="product-edit.php?id=<?= $product["id"] ?>"
                                    class="btn btn-outline-primary flex-fill">
                                    <i class="bi bi-pencil"></i>
                                    Update
                                </a>

                                <!-- DELETE -->
                                <a
                                    href="product-delete.php?id=<?= $product["id"] ?>"
                                    class="btn btn-outline-danger flex-fill"
                                    onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="bi bi-trash"></i>
                                    Delete
                                </a>
                            </div>

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
