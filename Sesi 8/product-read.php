<?php

require_once "config/database.php";

$sql = "SELECT * FROM products ORDER BY id DESC";

$stmt = $pdo->query($sql);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>

<body>

    <h1>Products</h1>

    <a href="product-form.php">
        Add Product
    </a>

    <br><br>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Action</th>
        </tr>

        <?php foreach ($products as $product): ?>

            <tr>
                <td>
                    <?= htmlspecialchars($product["id"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product["name"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product["description"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product["image"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product["price"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product["stock"]) ?>
                </td>

                <td>
                    <?= htmlspecialchars($product["category"]) ?>
                </td>

                <td>
                    <a href="product-update.php?id=<?= $product["id"] ?>">
                        Edit
                    </a>

                    |

                    <a href="product-delete.php?id=<?= $product["id"] ?>"
                       onclick="return confirm('Delete this product?')">
                        Delete
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

</body>
</html>
