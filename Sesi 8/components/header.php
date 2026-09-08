<?php
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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container">

    <a class="navbar-brand fw-bold" href="#">
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
                <a class="nav-link active" href="product-read.php">
                    Products
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    Orders
                </a>
            </li>

            <li class="nav-item ms-lg-3">
                <a class="cart-icon text-white" href="#">
                    <i class="bi bi-cart3"></i>

                    <span class="cart-badge">
                        0
                    </span>
                </a>
            </li>
        </ul>
    </div>

</div>
</nav>

<!-- ================= MAIN CONTENT ================= -->
<main>
