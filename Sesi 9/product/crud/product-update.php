<?php

require_once __DIR__ . "/../../config/database.php";

// Pastikan request berasal dari POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Ambil Product ID
$id = $_POST["id"] ?? null;

// Cek Product ID
if ($id === null || $id === "" || !is_numeric($id)) {
    die("Product ID tidak ditemukan.");
}

$id = (int) $id;

// Ambil data form
$name = $_POST["name"] ?? "";
$description = $_POST["description"] ?? "";
$price = $_POST["price"] ?? 0;
$stock = $_POST["stock"] ?? 0;
$category = $_POST["category"] ?? "";

// Ambil gambar lama dari database
$stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
$stmt->execute([$id]);

$currentProduct = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentProduct) {
    die("Product tidak ditemukan.");
}

// Pertahankan gambar lama
$image = $currentProduct["image"];

// Jika user memilih gambar baru
if (
    isset($_FILES["image"]) &&
    $_FILES["image"]["error"] === UPLOAD_ERR_OK
) {
    $uploadDir = __DIR__ . "/../../../Sesi 7/uploads/products/";

    $extension = strtolower(
        pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)
    );

    $allowedExtensions = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($extension, $allowedExtensions, true)) {
        die("Format gambar tidak diperbolehkan.");
    }

    $fileName = uniqid("product_", true) . "." . $extension;

    $targetPath = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
        die("Gagal mengupload gambar.");
    }

    // Ganti dengan gambar baru
    $image = "uploads/products/" . $fileName;
}

// Update product
$sql = "
    UPDATE products
    SET
        name = :name,
        description = :description,
        image = :image,
        price = :price,
        stock = :stock,
        category = :category
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":name" => $name,
    ":description" => $description,
    ":image" => $image,
    ":price" => $price,
    ":stock" => $stock,
    ":category" => $category,
    ":id" => $id
]);

// Kembali ke halaman produk
header("Location: ../products.php");
exit;

?>
