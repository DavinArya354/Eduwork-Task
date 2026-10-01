<?php

$pageTitle = "All Products";

require_once __DIR__ . "/../config/database.php";

// =====================================================
// AMBIL KATEGORI
// FETCH_COLUMN menghasilkan array string, bukan array asosiatif.
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

        <!-- PAGE HEADER -->
        <div class="d-flex flex-column flex-md-row
                    justify-content-between
                    align-items-md-center
                    mb-4">
            <div>
                <h1 class="fw-bold mb-1">All Products</h1>
                <p class="text-muted mb-0">
                    Browse all products available in our store.
                </p>
            </div>
        </div>

        <!-- =================================================
             FILTER CARD: CATEGORY + DATATABLES CONTROLS
             Show Products dan Search dipindahkan ke sini
             oleh JavaScript setelah DataTables diinisialisasi.
             ================================================= -->
        <div class="product-filter-card">

            <div class="category-filter">
                <label for="category" class="form-label fw-semibold">
                    Filter by Category
                </label>

                <form method="GET" class="category-filter-form">
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>

                        <?php foreach ($categories as $category): ?>
                            <option
                                value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>"
                                <?= $selectedCategory === $category ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>

                    <a href="products.php" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i>
                        Clear
                    </a>
                </form>
            </div>

            <div id="dataTable-controls" class="dataTable-controls">
                <!-- DataTables length and search controls are moved here. -->
            </div>

        </div>

        <!-- ACTIVE FILTER -->
        <?php if ($selectedCategory !== ""): ?>
            <div class="mb-4">
                <span class="text-muted">Showing products in:</span>
                <span class="badge product-category">
                    <?= htmlspecialchars($selectedCategory, ENT_QUOTES, 'UTF-8') ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- =================================================
             TABLE CARD: TABLE ONLY
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
                                    <td class="fw-semibold">
                                        <?= htmlspecialchars((string) $product["id"], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($product["image"])): ?>
                                            <img
                                                src="/Eduwork/Sesi%207/<?= htmlspecialchars($product["image"], ENT_QUOTES, 'UTF-8') ?>"
                                                class="product-table-image"
                                                alt="<?= htmlspecialchars($product["name"], ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                        <?php else: ?>
                                            <div class="product-table-no-image">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="fw-semibold">
                                            <?= htmlspecialchars($product["name"], ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>

                                    <td class="product-description">
                                        <?= htmlspecialchars($product["description"], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <span class="product-table-price">
                                            Rp <?= number_format((float) $product["price"], 0, ",", ".") ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars((string) $product["stock"], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <span class="badge product-category">
                                            <?= htmlspecialchars($product["category"], ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a
                                                href="product-edit.php?id=<?= urlencode((string) $product["id"]) ?>"
                                                class="btn btn-outline-primary btn-sm"
                                                title="Update Product"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a
                                                href="product-delete.php?id=<?= urlencode((string) $product["id"]) ?>"
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

<?php require_once __DIR__ . "/../components/footer.php"; ?>
