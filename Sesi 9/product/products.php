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
     PRODUCT TABLE
     ================================================= -->

    <div class="card product-table-card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table
                    id="productTable"
                    class="table table-hover align-middle product-table"
                    style="width:100%;"
                >

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($products as $product): ?>

                            <tr>
                                <!-- ID -->
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($product["id"]) ?>
                                </td>

                                <!-- IMAGE -->
                                <td>
                                    <?php if (!empty($product["image"])): ?>

                                        <img
                                            src="/Eduwork/Sesi%207/<?= htmlspecialchars($product["image"]) ?>"
                                            class="product-table-image"
                                            alt="<?= htmlspecialchars($product["name"]) ?>"
                                        >

                                    <?php else: ?>

                                        <div class="product-table-no-image">
                                            <i class="bi bi-image"></i>
                                        </div>

                                    <?php endif; ?>
                                </td>

                                <!-- NAME -->
                                <td>
                                    <span class="fw-semibold">
                                        <?= htmlspecialchars($product["name"]) ?>
                                    </span>
                                </td>

                                <!-- DESCRIPTION -->
                                <td class="product-description">
                                    <?= htmlspecialchars($product["description"]) ?>
                                </td>

                                <!-- PRICE -->
                                <td>
                                    <span class="product-table-price">
                                        Rp <?= number_format(
                                            $product["price"],
                                            0,
                                            ",",
                                            "."
                                        ) ?>
                                    </span>
                                </td>

                                <!-- STOCK -->
                                <td>
                                    <?= htmlspecialchars($product["stock"]) ?>
                                </td>

                                <!-- CATEGORY -->
                                <td>
                                    <span class="badge product-category">
                                        <?= htmlspecialchars($product["category"]) ?>
                                    </span>
                                </td>

                                <!-- ACTION -->
                                <td>
                                    <div class="d-flex gap-2">
                                        <a
                                            href="product-edit.php?id=<?= $product["id"] ?>"
                                            class="btn btn-outline-primary btn-sm"
                                            title="Update Product"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a
                                            href="product-delete.php?id=<?= $product["id"] ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            title="Delete Product"
                                            onclick="return confirm('Are you sure you want to delete this product?');"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

    </div>
</section>

<?php

require_once __DIR__ . "/../components/footer.php";

?>
