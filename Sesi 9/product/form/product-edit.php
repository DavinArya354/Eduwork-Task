<?php

require_once __DIR__ . "/../../config/database.php";

// Pastikan ID tersedia
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid product ID.");
}

$id = (int) $_GET["id"];

// Ambil data produk lama terlebih dahulu
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product tidak ditemukan.");
}

$pageTitle = "Edit Product";

require_once __DIR__ . "/../../components/header.php";

?>

<div class="container py-5">

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-sm border-0">

            <div class="card-header">
                <h4 class="mb-0">
                    Edit Product
                </h4>
            </div>

            <div class="card-body p-4">
                <form action="../crud/product-update.php" method="POST" enctype="multipart/form-data">
                    <!-- Product ID -->
                    <input
                        type="hidden"
                        name="id"
                        value="<?= $product["id"] ?>">

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">
                            Product Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="<?= htmlspecialchars($product["name"]) ?>"
                            required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            required><?= htmlspecialchars($product["description"]) ?></textarea>
                    </div>

                    <!-- Image -->
                     <?php if (!empty($product["image"])): ?>

                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <br>

                            <img
                                src="/Eduwork/Sesi%207/<?= htmlspecialchars($product["image"], ENT_QUOTES, "UTF-8") ?>"
                                alt="<?= htmlspecialchars($product["name"], ENT_QUOTES, "UTF-8") ?>"
                                width="150"
                                class="img-thumbnail"
                            >
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="image" class="form-label">Replace Image</label>

                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp"
                        >

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar.
                        </small>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label class="form-label">
                            Price
                        </label>

                        <input
                            type="number"
                            name="price"
                            class="form-control"
                            value="<?= htmlspecialchars($product["price"]) ?>"
                            required>
                    </div>

                    <!-- Stock -->
                    <div class="mb-3">
                        <label class="form-label">
                            Stock
                        </label>

                        <input
                            type="number"
                            name="stock"
                            class="form-control"
                            value="<?= htmlspecialchars($product["stock"]) ?>"
                            required>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="form-label">
                            Category
                        </label>

                        <input
                            type="text"
                            name="category"
                            class="form-control"
                            value="<?= htmlspecialchars($product["category"]) ?>"
                            required>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <a
                            href="../products.php"
                            class="btn btn-secondary">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary">
                            <i class="bi bi-save"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>

</div>

<?php

require_once __DIR__ . "/../../components/footer.php";

?>
