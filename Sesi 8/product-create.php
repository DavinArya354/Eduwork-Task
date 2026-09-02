<?php

require_once "config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST["name"];
    $description = $_POST["description"];
    $image = $_POST["image"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];

    $sql = "
        INSERT INTO products
        (name, description, image, price, stock, category)
        VALUES
        (:name, :description, :image, :price, :stock, :category)
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":name" => $name,
        ":description" => $description,
        ":image" => $image,
        ":price" => $price,
        ":stock" => $stock,
        ":category" => $category
    ]);

    header("Location: product-read.php");
    exit;
}
