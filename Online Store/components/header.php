<?php
require_once __DIR__ . "/../config/app.php";

// isStoreHeader digunakan untuk menentukan apakah header yang akan ditampilkan adalah header khusus untuk tampilan toko atau header umum.
$isStoreHeader = ($storeLayout ?? false) === true
    || (($_GET["component"] ?? "") === "header");

if ($isStoreHeader) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // $activePage digunakan untuk menentukan halaman aktif saat ini, yang dapat memengaruhi tampilan dan perilaku header.
    $requestedActivePage = $activePage ?? ($_GET["active"] ?? "");
    $activePage = in_array($requestedActivePage, ["home", "cart", "product"], true)
        ? $requestedActivePage
        : "";
    $cart = is_array($_SESSION["cart"] ?? null) ? $_SESSION["cart"] : []; // Mengambil data keranjang dari sesi, jika ada, atau menginisialisasinya sebagai array kosong.
    $storeCartCount = isset($cartCount) // Jika $cartCount sudah ditentukan sebelumnya, gunakan nilainya.
        ? (int) $cartCount
        : array_sum(array_map(
            static fn ($item) => is_array($item) ? max(0, (int) ($item["qty"] ?? 0)) : 0,
            $cart
        ));
    $homeUrl = BASE_URL . "user/home.html"; 
    $searchQuery = isset($_GET["q"]) && is_string($_GET["q"])
        ? $_GET["q"]
        : "";
    $productsUrl = $activePage === "home" // Jika halaman aktif adalah "home", tambahkan anchor "#product-list" ke URL produk, jika tidak, gunakan URL produk tanpa anchor.
        ? "#product-list"
        : $homeUrl . "#product-list";
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top custom-navbar cart-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="<?= htmlspecialchars($homeUrl, ENT_QUOTES, "UTF-8") ?>">
                <i class="bi bi-bag-fill"></i>
                ArcticStore
            </a>

            <?php if ($activePage === "home" || $activePage === "product"): ?>
                <form
                    class="nav-search-form"
                    role="search"
                    aria-label="Cari produk"
                    action="<?= htmlspecialchars($homeUrl, ENT_QUOTES, "UTF-8") ?>"
                    method="get">
                    <label class="visually-hidden" for="searchInput">Cari produk</label>
                    <div class="input-group">
                        <span class="input-group-text" aria-hidden="true">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="search"
                            id="searchInput"
                            name="q"
                            class="form-control"
                            placeholder="Cari produk..."
                            autocomplete="off"
                            value="<?= htmlspecialchars($searchQuery, ENT_QUOTES, "UTF-8") ?>">
                    </div>
                </form>
            <?php endif; ?>

            <div class="navbar-links<?= $activePage === "cart" ? " ms-auto" : "" ?>">
                <ul class="navbar-nav flex-row align-items-center">
                    <li class="nav-item">
                        <a class="nav-link<?= $activePage === "home" ? " active" : "" ?>" href="<?= htmlspecialchars($homeUrl, ENT_QUOTES, "UTF-8") ?>">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $activePage === "product" ? " active" : "" ?>" href="<?= htmlspecialchars($productsUrl, ENT_QUOTES, "UTF-8") ?>">
                            Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link cart-link<?= $activePage === "cart" ? " active" : "" ?>"
                            href="<?= htmlspecialchars(BASE_URL . "user/cart.php", ENT_QUOTES, "UTF-8") ?>"
                            aria-label="Keranjang">
                            <i class="bi bi-cart3"></i>
                            <span class="cart-badge" id="cart-count"><?= $storeCartCount ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    return;
}

$pageTitle = $pageTitle ?? "Arctic Store";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css"
    >

    <!--Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">

    <?php foreach ($pageStyles ?? [] as $pageStyle): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($pageStyle, ENT_QUOTES, "UTF-8") ?>">
    <?php endforeach; ?>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top custom-navbar">
    <div class="container">

    <a class="navbar-brand" href="../user/home.html">
        Arctic Store
    </a>

    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#mainNavbar">

        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto align-items-lg-center">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>user/home.html">
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>product/crud/product-read.php">
                    New Releases
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>product/products.php">
                    All Products
                </a>
            </li>
        </ul>
    </div>

</div>
</nav>

<!-- ================= MAIN CONTENT ================= -->
<main>
