<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/app.php";

function order_e(string $value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

function order_rupiah(float $value)
{
    return "Rp" . number_format($value, 0, ",", ".");
}

// Fungsi untuk memproses item keranjang yang dipilih untuk checkout
function order_cart_items(PDO $pdo, bool $lockProducts = false): array
{
    $cart = is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : [];
    $selectedItems = [];
    $errors = [];

    // Validasi item yang dipilih dari keranjang
    foreach ($cart as $item) {
        if (!is_array($item) || empty($item["selected"])) {
            continue;
        }

        $productId = filter_var($item["id"] ?? null, FILTER_VALIDATE_INT);
        $quantity = filter_var($item["qty"] ?? null, FILTER_VALIDATE_INT);

        if ($productId === false || $productId === null || $productId < 1
            || $quantity === false || $quantity === null || $quantity < 1) {
            $errors[] = "Data produk di keranjang tidak valid. Periksa kembali keranjang Anda.";
            continue;
        }

        $selectedItems[$productId] = $quantity;
    }

    if ($selectedItems === []) {
        $errors[] = "Pilih setidaknya satu produk untuk checkout.";
        return ["items" => [], "total" => 0.0, "errors" => $errors];
    }

    // Ambil data produk dari database untuk memverifikasi ketersediaan dan harga
    $placeholders = implode(",", array_fill(0, count($selectedItems), "?"));
    $sql = "SELECT id, name, price, stock FROM products WHERE id IN ($placeholders)";
    if ($lockProducts) {
        $sql .= " FOR UPDATE";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_keys($selectedItems));
    $products = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $product) {
        $products[(int) $product["id"]] = $product;
    }

    // Periksa setiap item yang dipilih untuk memastikan ketersediaan stok dan menghitung total harga
    $items = [];
    $total = 0.0;
    foreach ($selectedItems as $productId => $quantity) {
        if (!isset($products[$productId])) {
            $errors[] = "Salah satu produk sudah tidak tersedia. Perbarui keranjang Anda.";
            continue;
        }

        $product = $products[$productId];
        if ((int) $product["stock"] < $quantity) {
            $errors[] = "Stok " . $product["name"] . " tidak mencukupi. Perbarui jumlah di keranjang.";
            continue;
        }

        $unitPrice = (float) $product["price"];
        $lineTotal = $unitPrice * $quantity;
        $items[] = [
            "id" => $productId,
            "name" => (string) $product["name"],
            "quantity" => $quantity,
            "unit_price" => $unitPrice,
            "total_price" => $lineTotal
        ];
        $total += $lineTotal;
    }

    return ["items" => $items, "total" => $total, "errors" => $errors];
}
