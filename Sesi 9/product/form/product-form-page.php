<?php
require_once __DIR__ . "/../../config/app.php";

$pageTitle = "Input Product";
$pageStyles = [BASE_URL . "product/form/product-form.css"];

require_once __DIR__ . "/../../components/header.php";
require __DIR__ . "/product-form.html";
require_once __DIR__ . "/../../components/footer.php";
