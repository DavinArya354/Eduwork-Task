-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2026 at 06:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arctic_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Insert/Create
--

INSERT INTO users (id, name, email, password)
VALUES (
  '1',
  'Davin',
  'davin@example.com',
  'hashed_password'
)

INSERT INTO products
(name, description, image, price, stock, category)
VALUES
(
    'Mechanical Keyboard',
    'Keyboard mechanical RGB',
    'keyboard.jpg',
    500000,
    20,
    'Aksesoris'
),
(
    'Wireless Mouse',
    'Mouse wireless',
    'mouse.jpg',
    150000,
    30,
    'Aksesoris'
),
(
    'Gaming Headset',
    'Headset gaming dengan microphone',
    'headset.jpg',
    300000,
    15,
    'Gaming'
);

INSERT INTO orders (user_id)
VALUES(1);

INSERT INTO order_items
(order_id, product_id, quantity, price)
VALUES
(1, 1, 1, 500000),
(1, 2, 2, 150000);

--
-- Select/Read
--

SELECT * FROM users;

/* Semua Produk */
SELECT * FROM products;

/* Produk tertentu */
SELECT * FROM products
WHERE id = 1;

/* Berdasarkan Kategori */
SELECT * FROM products
WHERE category = 'Aksesoris';

/* Berdasarkan Pencarian Nama */
SELECT * FROM products
WHERE name LIKE '%keyboard%';

/* Order dan User*/
SELECT
    orders.id AS order_id,
    users.name AS customer,
    orders.created_at
FROM orders
JOIN users
    ON orders.user_id = users.id;

/* Detail Order */
SELECT
    orders.id AS order_id,
    users.name AS customer,
    products.name AS product,
    order_items.quantity,
    order_items.price
FROM orders
JOIN users
    ON orders.user_id = users.id
JOIN order_items
    ON orders.id = order_items.order_id
JOIN products
    ON order_items.product_id = products.id
WHERE orders.id = 1;

--
-- Update
--

UPDATE users
SET name = 'Davin Arya'
WHERE id = 1;

UPDATE users
SET email = 'davin.arya@example.com'
WHERE id = 1;

UPDATE products
SET
    name = 'Mechanical Keyboard RGB',
    price = 550000,
    stock = 25
WHERE id = 1;

UPDATE products
SET stock = 15
WHERE id = 1;

UPDATE products
SET category = 'Aksesoris'
WHERE id = 1;

UPDATE order_items
SET quantity = 3
WHERE id = 1;

UPDATE order_items
SET
    quantity = 3,
    price = 500000
WHERE id = 1;

--
-- Delete
--

DELETE FROM users
WHERE id = 1;

DELETE FROM products
WHERE id = 1;

DELETE FROM order_items
WHERE id = 1;

DELETE FROM orders
WHERE id = 1;
