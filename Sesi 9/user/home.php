<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/app.php";

header("Content-Type: application/json; charset=utf-8");

$stmt = $pdo->query(
    "SELECT id, name, description, price, stock, image, category
     FROM products
     ORDER BY id DESC"
);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengambil semua produk dari database dan menyimpannya dalam array asosiatif.
$products = []; // Array untuk menyimpan data produk yang akan dikirim sebagai respons JSON.
$categories = []; 

foreach ($rows as $row) {
    $category = (string) ($row["category"] ?? "");
    $categories[] = $category;
    $products[] = [
        "id" => (int) $row["id"],
        "name" => (string) $row["name"],
        "description" => (string) ($row["description"] ?? ""),
        "price" => (float) $row["price"],
        "stock" => (int) $row["stock"],
        "image" => product_image_url($row["image"] ?? ""),
        "category" => $category
    ];
}

$categories = array_values(array_unique(array_filter($categories))); // Menghapus duplikasi dan nilai kosong dari daftar kategori, lalu mengatur ulang indeks array.
sort($categories, SORT_NATURAL | SORT_FLAG_CASE);

$cart = is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : [];
$cartCount = array_sum(array_map(
    static fn ($item) => is_array($item) ? max(0, (int) ($item["qty"] ?? 0)) : 0,
    $cart
)); // Menghitung jumlah total item dalam keranjang dengan menjumlahkan kuantitas setiap item yang valid.

echo json_encode(
    [
        "products" => $products,
        "categories" => $categories,
        "cartCount" => $cartCount
    ],
    JSON_UNESCAPED_UNICODE
        | JSON_UNESCAPED_SLASHES
        | JSON_INVALID_UTF8_SUBSTITUTE
        | JSON_HEX_TAG
        | JSON_HEX_APOS
        | JSON_HEX_QUOT
        | JSON_HEX_AMP
);
