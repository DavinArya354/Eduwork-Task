<?php
require_once __DIR__ . "/../config/app.php";
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
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top custom-navbar">
    <div class="container">

    <a class="navbar-brand" href="#">
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
                <a class="nav-link" href="#">
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/product/crud/product-read.php">
                    New Releases
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/product/products.php">
                    All Products
                </a>
            </li>
        </ul>
    </div>

</div>
</nav>

<!-- ================= MAIN CONTENT ================= -->
<main>
