<?php

require_once __DIR__ . "/../config/database.php";

if (!isset($_GET["id"])) {
    die("Product ID tidak ditemukan.");
}

$id = $_GET["id"];

$sql = "DELETE FROM products WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

header("Location: /Eduwork/Sesi 8/crud/product-read.php");
exit;
