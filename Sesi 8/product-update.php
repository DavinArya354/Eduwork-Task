<?php

require_once "../Sesi 8/config/database.php";

// ===============================
// CEK METHOD REQUEST
// ===============================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}


// ===============================
// AMBIL DATA DARI FORM
// ===============================
$name = trim($_POST["name"] ?? "");
$description = trim($_POST["description"] ?? "");
$image = $_FILES["image"] ?? null;
$price = $_POST["price"] ?? "";
$stock = $_POST["stock"] ?? "";
$category = trim($_POST["category"] ?? "");


// ===============================
// ARRAY UNTUK MENYIMPAN ERROR
// ===============================
$errors = [];


// ===============================
// VALIDASI NAME
// ===============================
if ($name === "") {
    $errors[] = "Product name is required.";

} elseif (strlen($name) < 3) {
    $errors[] = "Product name must contain at least 3 characters.";

} elseif (strlen($name) > 100) {
    $errors[] = "Product name must not exceed 100 characters.";
}


// ===============================
// VALIDASI DESCRIPTION
// ===============================
if ($description === "") {
    $errors[] = "Description is required.";

} elseif (strlen($description) < 10) {
    $errors[] = "Description must contain at least 10 characters.";

}


// ===============================
// VALIDASI IMAGE
// ===============================
if ($image === null) {
    $errors[] = "Product image is required.";

} elseif ($image["error"] !== UPLOAD_ERR_OK) {
    $errors[] = "There was an error uploading the image.";

} else {
    // Maksimal 2 MB
    $maxSize = 2 * 1024 * 1024;
    if ($image ["size"] > $maxSize) {
        $errors[] = "Image size must not exceed 2 MB.";
    }

    // Mengecek MIME type
    $allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/webp"
    ];

    $imageInfo = getimagesize($image["tmp_name"]);
    if ($imageInfo === false) {
        $errors[] = "The uploaded file is not a valid image.";
    } elseif (!in_array($imageInfo["mime"], $allowedTypes, true)) {
        $errors[] = "Only JPEG, PNG, and WEBP images are allowed.";
    }
}

// ===============================
// VALIDASI PRICE
// ===============================
if ($price === "") {
    $errors[] = "Price is required.";

} elseif (!is_numeric($price)) {
    $errors[] = "Price must be a number.";

} elseif ($price < 0) {
    $errors[] = "Price cannot be negative.";
}


// ===============================
// VALIDASI STOCK
// ===============================
if ($stock === "") {
    $errors[] = "Stock is required.";

} elseif (!ctype_digit($stock)) {
    $errors[] = "Stock must be a positive integer.";

} elseif ($stock < 0) {
    $errors[] = "Stock cannot be negative.";
}


// ===============================
// VALIDASI CATEGORY
// ===============================
$allowedCategories = [
    "Elektronik",
    "Aksesoris",
    "Fashion",
    "Gaming",
    "Lainnya"
];

if ($category === "") {
    $errors[] = "Category is required.";

} elseif (!in_array($category, $allowedCategories, true)) {
    $errors[] = "Invalid category.";
}


// ===============================
// HASIL VALIDASI
// ===============================
if (!empty($errors)) {
    echo "<h2>Validation Error</h2>";

    echo "<ul>";

    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }

    echo "</ul>";

    echo '<a href="product-form.html">Back to Form</a>';

    exit;
}

// ==========================================
// BUAT FOLDER UPLOAD
// ==========================================
$uploadDirectory = "uploads/products/";

if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}


// ==========================================
// BUAT NAMA FILE BARU
// ==========================================
$extension = strtolower(
    pathinfo($image["name"], PATHINFO_EXTENSION)
);

$newFileName = uniqid("product_", true) . "." . $extension;
$destination = $uploadDirectory . $newFileName;

// ==========================================
// PINDAHKAN FILE
// ==========================================
if (!move_uploaded_file($image["tmp_name"], $destination)) {
    die("Failed to save product image.");
}

// ==========================================
// LANJUTKAN KE PRODUCT-CREATE.PHP
// ==========================================

require_once "../Sesi 8/crud/product-create.php";

?>
