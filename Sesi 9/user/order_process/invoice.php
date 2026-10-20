<?php
require_once __DIR__ . "/order-logic.php";

// Ambil ID pesanan dari parameter GET dan validasi
$orderId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$authorizedOrders = is_array($_SESSION["created_orders"] ?? null)
    ? $_SESSION["created_orders"]
    : [];

// Periksa apakah ID pesanan valid dan termasuk dalam daftar pesanan yang dibuat oleh pengguna saat ini
if ($orderId === false || $orderId === null || $orderId < 1
    || !in_array($orderId, $authorizedOrders, true)) {
    http_response_code(404);
    exit("Invoice tidak ditemukan.");
}

$orderStmt = $pdo->prepare(
    "SELECT id, user_name, address, phone_number, total_price, status, created_at
     FROM orders
     WHERE id = :id
     LIMIT 1"
);
$orderStmt->execute([":id" => $orderId]);
$order = $orderStmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    http_response_code(404);
    exit("Invoice tidak ditemukan.");
}

$itemStmt = $pdo->prepare(
    "SELECT product_name, quantity, total_price
     FROM order_items
     WHERE order_id = :order_id
     ORDER BY id ASC"
);
$itemStmt->execute([":order_id" => $orderId]);
$items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);

$storeLayout = true;
$activePage = "cart";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Invoice pesanan Arctic Store">
    <title>Invoice #<?= (int) $order["id"] ?> - Arctic Store</title>
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
        <section class="invoice-card card shadow-sm mx-auto">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                    <div>
                        <p class="text-success fw-semibold mb-1"><i class="bi bi-check-circle-fill"></i> Pesanan berhasil dibuat</p>
                        <h1 class="h2 mb-1">Invoice #<?= (int) $order["id"] ?></h1>
                        <p class="text-muted mb-0">
                            <?= order_e(date("d-m-Y H:i", strtotime((string) $order["created_at"]))) ?>
                        </p>
                    </div>
                    <span class="badge text-bg-warning align-self-start"><?= order_e(ucfirst((string) $order["status"])) ?></span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h2 class="h6">Informasi Customer</h2>
                        <p class="mb-1 fw-semibold"><?= order_e($order["user_name"]) ?></p>
                        <p class="mb-1"><?= nl2br(order_e($order["address"])) ?></p>
                        <p class="mb-0"><?= order_e($order["phone_number"]) ?></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h2 class="h6">Arctic Store</h2>
                        <p class="text-muted mb-0">Simpan invoice ini sebagai bukti pesanan Anda.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= order_e($item["product_name"]) ?></td>
                                    <td class="text-center"><?= (int) $item["quantity"] ?></td>
                                    <td class="text-end"><?= order_e(order_rupiah((float) $item["total_price"])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">Total Pesanan</th>
                                <th class="text-end"><?= order_e(order_rupiah((float) $order["total_price"])) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mt-4 invoice-actions">
                    <a href="<?= order_e(BASE_URL) ?>user/home.html" class="btn btn-success">Kembali Belanja</a>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Invoice
                    </button>
                </div>
            </div>
        </section>
    </main>

    <?php require __DIR__ . "/../components/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
