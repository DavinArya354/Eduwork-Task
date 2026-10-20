<?php
require_once __DIR__ . "/order-logic.php";

$customerName = "";
$address = "";
$phone = "";
$errors = [];
$items = [];
$total = 0.0;
$itemsLoaded = false;
$itemsUnavailable = false;

// CSRF token untuk mencegah serangan CSRF (Cross-Site Request Forgery) pada proses checkout. 
// Token ini dibuat saat halaman checkout dimuat dan disimpan dalam sesi pengguna. Saat formulir checkout dikirim, token ini diverifikasi untuk memastikan bahwa permintaan berasal dari pengguna yang sah.
if (!isset($_SESSION["checkout_token"])) {
    $_SESSION["checkout_token"] = bin2hex(random_bytes(32));
}

// Mengecek apakah ada item yang dipilih untuk checkout. Jika tidak ada, pengguna akan diarahkan kembali ke halaman keranjang dengan pesan peringatan.
$cart = is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : [];
$hasSelectedCartItems = false;
foreach ($cart as $cartItem) {
    if (is_array($cartItem) && !empty($cartItem["selected"])) {
        $hasSelectedCartItems = true;
        break;
    }
}

if (!$hasSelectedCartItems) {
    $_SESSION["cart_notice"] = [
        "type" => "warning",
        "message" => "Pilih setidaknya satu produk untuk checkout."
    ];
    header("Location: " . BASE_URL . "user/cart.php");
    exit;
}

// Mengecek apakah formulir checkout telah dikirim melalui metode POST. Jika ya, data input dari pengguna akan divalidasi dan diproses untuk membuat pesanan baru.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customerName = trim(is_string($_POST["customer_name"] ?? null) ? $_POST["customer_name"] : "");
    $address = trim(is_string($_POST["address"] ?? null) ? $_POST["address"] : "");
    $phone = trim(is_string($_POST["phone"] ?? null) ? $_POST["phone"] : "");
    $token = is_string($_POST["checkout_token"] ?? null) ? $_POST["checkout_token"] : "";

    if (!hash_equals((string) $_SESSION["checkout_token"], $token)) {
        $errors[] = "Sesi checkout tidak valid. Muat ulang halaman dan coba kembali.";
    }
    if (preg_match('/^.{1,120}$/us', $customerName) !== 1) {
        $errors[] = "Nama wajib diisi dan maksimal 120 karakter.";
    }
    if ($address === "" || preg_match('/^.{1,5000}$/us', $address) !== 1) {
        $errors[] = "Alamat wajib diisi dan maksimal 5.000 karakter.";
    }
    if (preg_match('/^[0-9+().\-\s]{6,30}$/D', $phone) !== 1) {
        $errors[] = "Nomor telepon wajib diisi dengan format yang valid.";
    }

    // Jika tidak ada kesalahan validasi, proses checkout akan dilakukan dengan memanggil fungsi order_cart_items() untuk memeriksa ketersediaan item dan menghitung total harga. Jika semua item tersedia, pesanan akan disimpan ke database, dan pengguna akan diarahkan ke halaman faktur.
    if ($errors === []) {
        try {
            $pdo->beginTransaction();
            $checkoutData = order_cart_items($pdo, true);
            $items = $checkoutData["items"];
            $total = $checkoutData["total"];
            $errors = $checkoutData["errors"];
            $itemsUnavailable = $errors !== [];
            $itemsLoaded = true;

            // Jika tidak ada kesalahan dan semua item tersedia, pesanan akan disimpan ke database.
            if ($errors !== []) {
                $pdo->rollBack();
            } else {
                $orderStmt = $pdo->prepare(
                    "INSERT INTO orders (user_name, address, phone_number, total_price)
                     VALUES (:user_name, :address, :phone_number, :total_price)"
                );
                // Menyimpan data pesanan ke tabel "orders" dengan menggunakan prepared statement untuk mencegah serangan SQL injection. Data yang disimpan meliputi nama pengguna, alamat, nomor telepon, dan total harga pesanan.
                $orderStmt->execute([
                    ":user_name" => $customerName,
                    ":address" => $address,
                    ":phone_number" => (int) $phone,
                    ":total_price" => number_format($total, 2, ".", "")
                ]);
                $orderId = (int) $pdo->lastInsertId();

                // Menyimpan item pesanan ke tabel "order_items" dengan menggunakan prepared statement. Setiap item yang dibeli akan disimpan dengan informasi seperti ID pesanan, ID produk, nama produk, jumlah, dan total harga item.
                $itemStmt = $pdo->prepare(
                    "INSERT INTO order_items (order_id, product_id, product_name, quantity, total_price)
                     VALUES (:order_id, :product_id, :product_name, :quantity, :total_price)"
                );

                // Looping melalui setiap item yang dibeli dan mengeksekusi prepared statement untuk menyimpan data item ke tabel "order_items".
                foreach ($items as $item) {
                    $itemStmt->execute([
                        ":order_id" => $orderId,
                        ":product_id" => $item["id"],
                        ":product_name" => $item["name"],
                        ":quantity" => $item["quantity"],
                        ":total_price" => number_format($item["total_price"], 2, ".", "")
                    ]);
                }

                // Commit transaksi database untuk menyimpan perubahan secara permanen. Jika terjadi kesalahan selama proses penyimpanan, transaksi akan dibatalkan (rollback) untuk menjaga konsistensi data.
                $pdo->commit();
                $authorizedOrders = is_array($_SESSION["created_orders"] ?? null)
                    ? $_SESSION["created_orders"]
                    : [];
                $authorizedOrders[] = $orderId;
                $_SESSION["created_orders"] = array_slice($authorizedOrders, -20);

                // Menghapus item yang telah dibeli dari keranjang belanja pengguna. Item yang telah dibeli akan dihapus dari sesi pengguna untuk mencegah duplikasi pesanan.
                $purchasedIds = array_column($items, "id");
                $_SESSION["cart"] = array_values(array_filter(
                    is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : [],
                    static fn ($cartItem) => !is_array($cartItem)
                        || !in_array((int) ($cartItem["id"] ?? 0), $purchasedIds, true)
                ));
                unset($_SESSION["checkout_token"]);

                // Mengarahkan pengguna ke halaman faktur (invoice) setelah pesanan berhasil dibuat. Halaman faktur akan menampilkan rincian pesanan yang baru saja dibuat.
                header("Location: " . BASE_URL . "user/invoice.php?id=" . $orderId);
                exit;
            }
        } catch (PDOException $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log($exception->getMessage());
            $errors[] = "Pesanan gagal disimpan. Pastikan tabel pesanan sudah tersedia, lalu coba kembali.";
        }
    }
}

// Jika halaman checkout dimuat tanpa mengirimkan formulir, data item yang dipilih untuk checkout akan dimuat dari keranjang belanja pengguna.
if (!$itemsLoaded) {
    $checkoutData = order_cart_items($pdo);
    $items = $checkoutData["items"];
    $total = $checkoutData["total"];
    $itemsUnavailable = $checkoutData["errors"] !== [];
    $errors = array_merge($errors, $checkoutData["errors"]);
}

// Jika tidak ada item yang dipilih untuk checkout dan tidak ada kesalahan, pengguna akan diarahkan kembali ke halaman keranjang dengan pesan peringatan.
if ($items === [] && $errors === []) {
    $_SESSION["cart_notice"] = [
        "type" => "warning",
        "message" => "Pilih setidaknya satu produk untuk checkout."
    ];
    header("Location: " . BASE_URL . "user/cart.php");
    exit;
}

$storeLayout = true;
$activePage = "cart";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Review pesanan dan isi data checkout Arctic Store">
    <title>Checkout - Arctic Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= order_e(BASE_URL) ?>css/style.css">
    <link rel="stylesheet" href="<?= order_e(BASE_URL) ?>user/style.css">
</head>
<body class="cart-page">
    <?php require __DIR__ . "/../components/header.php"; ?>

    <main class="container py-5">
        <h1 class="mb-4">Checkout</h1>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-warning" role="alert"><?= order_e($error) ?></div>
        <?php endforeach; ?>

        <div class="checkout-layout">
            <section class="card shadow-sm">
                <div class="card-header bg-white">
                    <h2 class="h4 mb-0">Review Order Items</h2>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= order_e($item["name"]) ?></td>
                                    <td class="text-center"><?= (int) $item["quantity"] ?></td>
                                    <td class="text-end"><?= order_e(order_rupiah($item["unit_price"])) ?></td>
                                    <td class="text-end"><?= order_e(order_rupiah($item["total_price"])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-end"><?= order_e(order_rupiah($total)) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>

            <section class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">Informasi Customer</h2>
                    <form method="post" action="<?= order_e(BASE_URL) ?>user/checkout.php">
                        <input type="hidden" name="checkout_token" value="<?= order_e($_SESSION["checkout_token"]) ?>">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama</label>
                            <input
                                type="text"
                                class="form-control"
                                id="customer_name"
                                name="customer_name"
                                maxlength="120"
                                value="<?= order_e($customerName) ?>"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea
                                class="form-control"
                                id="address"
                                name="address"
                                rows="4"
                                maxlength="5000"
                                autocomplete="street-address"
                                required
                            ><?= order_e($address) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input
                                type="tel"
                                class="form-control"
                                id="phone"
                                name="phone"
                                maxlength="30"
                                value="<?= order_e($phone) ?>"
                                autocomplete="tel"
                                required
                            >
                        </div>

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                            <?= $items === [] || $itemsUnavailable ? "disabled" : "" ?>
                        >
                            Buat Pesanan
                        </button>

                        <a href="<?= order_e(BASE_URL) ?>user/cart.php" class="btn btn-outline-secondary w-100 mt-2">
                            Kembali ke Keranjang
                        </a>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <?php require __DIR__ . "/../components/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
