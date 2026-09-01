<?php

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
$image = trim($_POST["image"] ?? "");
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
if ($image === "") {
    $errors[] = "Image URL is required.";

} elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
    $errors[] = "Image must contain a valid URL.";
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

} elseif (!filter_var($stock, FILTER_VALIDATE_INT)) {
    $errors[] = "Stock must be an integer.";

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


// ===============================
// JIKA VALIDASI BERHASIL
// ===============================

echo "<h2>Product Validation Successful!</h2>";
echo "<p><strong>Name:</strong> "
    . htmlspecialchars($name)
    . "</p>";

echo "<p><strong>Description:</strong> "
    . htmlspecialchars($description)
    . "</p>";

echo "<p><strong>Image:</strong> "
    . htmlspecialchars($image)
    . "</p>";

echo "<p><strong>Price:</strong> Rp "
    . number_format((float)$price, 0, ",", ".")
    . "</p>";

echo "<p><strong>Stock:</strong> "
    . htmlspecialchars($stock)
    . "</p>";

echo "<p><strong>Category:</strong> "
    . htmlspecialchars($category)
    . "</p>";

echo '<br>';

echo '<a href="product-form.html">Add Another Product</a>';

?>
