<?php

require_once __DIR__ . "/../config/database.php";

// Pastikan ID tersedia
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid product ID.");
}

$id = (int) $_GET["id"];

// Ambil data product
$sql = "SELECT * FROM products WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Product tidak ditemukan
if (!$product) {
    die("Product not found.");
}

$pageTitle = "Edit Product";

require_once __DIR__ . "/../components/header.php";

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
                <form
                    action="product-update.php"
                    method="POST">

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
                    <div class="mb-3">
                        <label class="form-label">
                            Image Path
                        <label>

                        <input
                            type="text"
                            name="image"
                            class="form-control"
                            value="<?= htmlspecialchars($product["image"] ?? "") ?>">
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
                            href="product-read.php"
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

require_once __DIR__ . "/../components/footer.php";

?>
