<?php

require_once __DIR__ . "/../config/database.php";

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
$image = $_POST["image"] ?? "";
$price = $_POST["price"] ?? 0;
$stock = $_POST["stock"] ?? 0;
$category = $_POST["category"] ?? "";

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

// Kembali ke halaman produk terbaru
header("Location: product-read.php");
exit;

?>
