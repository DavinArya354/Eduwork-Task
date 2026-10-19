<?php
define("BASE_URL", "/Eduwork/Sesi%209/");

function product_image_filename(?string $image): string
{
    $image = str_replace("\\", "/", trim($image ?? ""));

    return basename($image);
}

function product_image_url(?string $image): string
{
    $filename = product_image_filename($image);

    if ($filename === "" || $filename === ".") {
        return "";
    }

    return BASE_URL . "uploads/products/" . rawurlencode($filename);
}
?>
