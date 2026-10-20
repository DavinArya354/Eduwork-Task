<?php
session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/app.php";

/**
 * Mengamankan nilai sebelum ditampilkan di HTML.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

/**
 * Mengubah angka menjadi format mata uang rupiah.
 */
function rupiah(float $value): string
{
    return "Rp" . number_format($value, 0, ",", ".");
}

/**
 * Mencari posisi produk di dalam data keranjang.
 */
function find_cart_item_index(array $cart, int $productId): ?int
{
    foreach ($cart as $index => $item) {
        if (is_array($item) && (int) ($item["id"] ?? 0) === $productId) {
            return $index;
        }
    }

    return null;
}

/**
 * Mengarahkan kembali ke halaman keranjang setelah data berubah.
 */
function redirect_to_cart(): void
{
    header("Location: " . BASE_URL . "user/cart.php");
    exit;
}

// Mengambil data keranjang dari sesi, jika ada, atau menginisialisasinya sebagai array kosong.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = is_string($_POST["action"] ?? null) ? $_POST["action"] : "";
    $cart = is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : [];

    // Menangani aksi yang dikirim melalui metode POST, seperti menambahkan produk ke keranjang, memperbarui pilihan produk, mengosongkan keranjang, atau checkout.
    if ($action === "add_to_cart") {
        $productId = filter_var($_POST["product_id"] ?? null, FILTER_VALIDATE_INT);
        $quantity = filter_var($_POST["quantity"] ?? 1, FILTER_VALIDATE_INT);

        // Validasi input untuk memastikan ID produk dan jumlah yang diminta valid.
        if (
            $productId === false || $productId === null || $productId < 1
            || $quantity === false || $quantity === null || $quantity < 1
        ) {
            $_SESSION["cart_notice"] = [
                "type" => "danger",
                "message" => "Produk atau jumlah yang diminta tidak valid."
            ];
        } else {
            $productStmt = $pdo->prepare(
                "SELECT id, name, description, price, stock, image, category
                 FROM products
                 WHERE id = :id
                 LIMIT 1"
            );
            $productStmt->execute([":id" => $productId]);
            $product = $productStmt->fetch(PDO::FETCH_ASSOC);

            // Validasi apakah produk ditemukan dan stok mencukupi sebelum menambahkannya ke keranjang.
            if (!$product) {
                $_SESSION["cart_notice"] = [
                    "type" => "danger",
                    "message" => "Produk tidak ditemukan."
                ];
            } elseif ((int) $product["stock"] < 1) {
                $_SESSION["cart_notice"] = [
                    "type" => "warning",
                    "message" => "Produk tersebut sedang habis."
                ];
            } else {
                $itemIndex = find_cart_item_index($cart, (int) $product["id"]);
                $currentQuantity = $itemIndex === null
                    ? 0
                    : max(0, (int) ($cart[$itemIndex]["qty"] ?? 0));

                if ($currentQuantity + $quantity > (int) $product["stock"]) {
                    $_SESSION["cart_notice"] = [
                        "type" => "warning",
                        "message" => "Jumlah produk melebihi stok yang tersedia."
                    ];
                } else {
                    if ($itemIndex !== null) {
                        $cart[$itemIndex]["qty"] = $currentQuantity + $quantity;
                        $cart[$itemIndex]["price"] = (float) $product["price"];
                        $cart[$itemIndex]["stock"] = (int) $product["stock"];
                        $cart[$itemIndex]["image"] = product_image_url($product["image"]);
                    } else {
                        $cart[] = [
                            "id" => (int) $product["id"],
                            "name" => $product["name"],
                            "description" => $product["description"],
                            "price" => (float) $product["price"],
                            "stock" => (int) $product["stock"],
                            "image" => product_image_url($product["image"]),
                            "category" => $product["category"],
                            "qty" => $quantity,
                            "selected" => true
                        ];
                    }

                    $_SESSION["cart"] = $cart;
                    $_SESSION["cart_notice"] = [
                        "type" => "success",
                        "message" => $product["name"] . " berhasil ditambahkan ke keranjang."
                    ];
                }
            }
        }

        redirect_to_cart();
    }

    // Menangani aksi pembaruan pilihan produk, pengosongan keranjang, checkout, atau pengubahan jumlah produk di keranjang.
    if ($action === "update_selection") {
        $selectedIds = $_POST["selected_ids"] ?? [];
        $selectedIds = is_array($selectedIds)
            ? array_map("intval", $selectedIds)
            : [];

        foreach ($cart as &$item) {
            if (is_array($item)) {
                $item["selected"] = in_array((int) ($item["id"] ?? 0), $selectedIds, true);
            }
        }
        unset($item);

        $_SESSION["cart"] = $cart;
        redirect_to_cart();
    }

    if ($action === "clear_cart") {
        $_SESSION["cart"] = [];
        $_SESSION["cart_notice"] = [
            "type" => "success",
            "message" => "Keranjang berhasil dikosongkan."
        ];
        redirect_to_cart();
    }

    if ($action === "checkout") {
        $hasSelectedItem = false;
        foreach ($cart as $item) {
            if (is_array($item) && !empty($item["selected"])) {
                $hasSelectedItem = true;
                break;
            }
        }

        if (!$hasSelectedItem) {
            $_SESSION["cart_notice"] = [
                "type" => "warning",
                "message" => "Pilih setidaknya satu produk untuk checkout."
            ];
            redirect_to_cart();
        }

        header("Location: " . BASE_URL . "user/checkout.php");
        exit;
    }

    // Menangani aksi pengubahan jumlah produk di keranjang, termasuk menambah, mengurangi, atau menghapus produk.
    if (preg_match('/^(increase|decrease|remove):([1-9][0-9]*)$/D', $action, $matches)) {
        $itemAction = $matches[1];
        $productId = (int) $matches[2];
        $itemIndex = find_cart_item_index($cart, $productId);

        if ($itemIndex === null) {
            $_SESSION["cart_notice"] = [
                "type" => "warning",
                "message" => "Produk tersebut tidak ditemukan di keranjang."
            ];
        } elseif ($itemAction === "remove") {
            array_splice($cart, $itemIndex, 1);
            $_SESSION["cart"] = $cart;
            $_SESSION["cart_notice"] = [
                "type" => "success",
                "message" => "Produk berhasil dihapus dari keranjang."
            ];
        } elseif ($itemAction === "decrease") {
            $currentQuantity = max(1, (int) ($cart[$itemIndex]["qty"] ?? 1));
            if ($currentQuantity <= 1) {
                array_splice($cart, $itemIndex, 1);
            } else {
                $cart[$itemIndex]["qty"] = $currentQuantity - 1;
            }
            $_SESSION["cart"] = $cart;
        } else {
            $stockStmt = $pdo->prepare(
                "SELECT stock FROM products WHERE id = :id LIMIT 1"
            );
            $stockStmt->execute([":id" => $productId]);
            $stock = $stockStmt->fetchColumn();
            $currentQuantity = max(1, (int) ($cart[$itemIndex]["qty"] ?? 1));

            if ($stock === false) {
                $_SESSION["cart_notice"] = [
                    "type" => "warning",
                    "message" => "Produk tidak ditemukan di katalog."
                ];
            } elseif ($currentQuantity >= (int) $stock) {
                $_SESSION["cart_notice"] = [
                    "type" => "warning",
                    "message" => "Jumlah produk sudah mencapai stok yang tersedia."
                ];
            } else {
                $cart[$itemIndex]["qty"] = $currentQuantity + 1;
                $cart[$itemIndex]["stock"] = (int) $stock;
                $_SESSION["cart"] = $cart;
            }
        }

        redirect_to_cart();
    }

    $_SESSION["cart_notice"] = [
        "type" => "danger",
        "message" => "Permintaan keranjang tidak dikenal."
    ];
    redirect_to_cart();
}

// Mengambil data keranjang dari sesi, jika ada, atau menginisialisasinya sebagai array kosong.
$cart = is_array($_SESSION["cart"] ?? null) ? array_values($_SESSION["cart"]) : [];
$notice = $_SESSION["cart_notice"] ?? null;
unset($_SESSION["cart_notice"]);

$cartCount = 0;
$selectedCount = 0;
$selectedQuantity = 0;
$selectedTotal = 0.0;

// Menghitung jumlah total item, jumlah item yang dipilih, kuantitas item yang dipilih, dan total harga dari item yang dipilih di keranjang.
foreach ($cart as &$item) {
    if (!is_array($item)) {
        continue;
    }

    if (!array_key_exists("selected", $item)) {
        $item["selected"] = true;
    }

    $quantity = max(0, (int) ($item["qty"] ?? 0));
    $cartCount += $quantity; 

    if (!empty($item["selected"])) {
        $selectedCount++;
        $selectedQuantity += $quantity;
        $selectedTotal += (float) ($item["price"] ?? 0) * $quantity;
    }
}
unset($item);
$_SESSION["cart"] = $cart;

// Mengecek apakah semua item di keranjang dipilih atau tidak.
$allSelected = count($cart) > 0;
foreach ($cart as $item) {
    if (!is_array($item) || empty($item["selected"])) {
        $allSelected = false;
        break;
    }
}
