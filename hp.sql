-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 03:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hp`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Anta', NULL, NULL, NULL),
(2, 'Nike', NULL, NULL, NULL),
(3, 'Asics', NULL, NULL, NULL),
(4, 'New Balance', NULL, NULL, NULL),
(5, 'Adidas', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2),
(6, '2025_03_12_011622_add_role_to_users_table', 3),
(19, '2025_03_18_105214_create_carts_table', 5),
(21, '2025_03_27_011538_add_profile_picture_to_users_table', 7),
(33, '2025_04_05_172551_add_types_id_to_product_table.php', 1),
(34, '2025_04_05_172638_add_brand_id_to_products_table.php', 1),
(35, '2025_04_05_171322_create_type_table', 1),
(56, '2025_03_12_021719_create_products_table', 8),
(57, '2025_03_12_021738_create_orders_table', 8),
(58, '2025_03_13_003559_add_image_to_products_table', 8),
(59, '2025_03_13_025018_add_description_to_products_table', 8),
(60, '2025_03_17_152306_create_product_images_table', 8),
(61, '2025_03_18_111528_create_carts_table', 8),
(62, '2025_04_05_171251_create_brand_table', 8),
(63, '2025_04_05_172551_add_type_id_to_products_table', 8),
(64, '2025_04_05_172638_add_brand_id_to_products_table', 8),
(65, '2025_04_05_190822_add_status_to_users_table', 8),
(67, '2025_04_06_025500_create_order_items', 9),
(68, '2025_04_06_025738_add_status_to_orders_table', 9),
(69, '2025_04_06_082400_create_order_items_table', 10),
(71, '2025_04_06_084229_add_shipping_address_to_orders_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `shipping_address`, `created_at`, `updated_at`) VALUES
(1, 1, 100000.00, 'pending', 'dfherfbrwergss', '2025-04-06 05:21:34', '2025-04-06 05:21:34'),
(2, 1, 100000.00, 'pending', 'dito lang banda kila josh', '2025-04-06 05:30:56', '2025-04-06 05:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 3500.00, '2025-04-06 05:21:34', '2025-04-06 05:21:34'),
(2, 1, 2, 1, 7500.00, '2025-04-06 05:21:34', '2025-04-06 05:21:34'),
(3, 1, 3, 1, 11000.00, '2025-04-06 05:21:34', '2025-04-06 05:21:34'),
(4, 1, 4, 1, 3000.00, '2025-04-06 05:21:34', '2025-04-06 05:21:34'),
(5, 1, 5, 1, 75000.00, '2025-04-06 05:21:34', '2025-04-06 05:21:34'),
(6, 2, 1, 1, 3500.00, '2025-04-06 05:30:56', '2025-04-06 05:30:56'),
(7, 2, 2, 1, 7500.00, '2025-04-06 05:30:56', '2025-04-06 05:30:56'),
(8, 2, 3, 1, 11000.00, '2025-04-06 05:30:56', '2025-04-06 05:30:56'),
(9, 2, 4, 1, 3000.00, '2025-04-06 05:30:56', '2025-04-06 05:30:56'),
(10, 2, 5, 1, 75000.00, '2025-04-06 05:30:56', '2025-04-06 05:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `created_at`, `updated_at`, `image`, `type_id`, `brand_id`) VALUES
(1, 'Pegasus 40', 'Responsive cushioning provides a springy ride for any run. Experience lighter-weight energy return in this latest version, with a combination of Zoom Air units and React foam. Plus, the redesigned midfoot and upper provide an improved, super-comfortable fit.', 3500.00, 15, '2025-04-05 14:57:21', '2025-04-05 14:57:21', NULL, 1, 2),
(2, 'Zoom X Invincible 3', 'Maximum cushioning provides our most comfortable ride for everyday runs. Experience a breathable Flyknit upper and the robust platform of lightweight ZoomX foam that softens impact. Plus, the midsole of this model is wider and taller than the last for even more cushioned comfort.', 7500.00, 25, '2025-04-05 14:59:42', '2025-04-05 14:59:42', NULL, 2, 2),
(3, 'VaporFly 3', 'Catch \'em if you can. Giving you race-day speed to conquer any distance, the Nike Vaporfly 3 is made for the chasers, the racers, the elevated pacers who can\'t turn down the thrill of the pursuit.', 11000.00, 10, '2025-04-05 15:01:31', '2025-04-05 15:06:11', NULL, 3, 2),
(4, 'Gel Nimbus 27', 'The GEL-NIMBUS™ 27 shoe\'s soft cushioning properties help you feel like you\'re landing on clouds. This design is revamped to help create a softer and smoother running experience. A soft engineered jacquard mesh upper comfortably wraps your foot while supplying advanced ventilation. Additionally, the knit tongue and collar help provide a soft and supportive feel. By using FF BLAST™ PLUS ECO cushioning, this trainer creates a lighter and softer cushioning experience. Lastly, HYBRID ASICSGRIP™ outsole combines ASICSGRIP™ rubber and AHARPLUS™ materials to help provide advanced grip for various terrains and advanced durability.', 3000.00, 12, '2025-04-05 15:04:42', '2025-04-05 15:04:42', NULL, 1, 3),
(5, 'Gel Nimbus 25', 'adwasdawasdawsdawd', 75000.00, 11, '2025-04-05 18:06:44', '2025-04-05 18:06:44', NULL, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/1743893841_67f1b55109cd5.png', '2025-04-05 14:57:21', '2025-04-05 14:57:21'),
(2, 1, 'products/1743893841_67f1b55114747.png', '2025-04-05 14:57:21', '2025-04-05 14:57:21'),
(3, 1, 'products/1743893841_67f1b55116593.png', '2025-04-05 14:57:21', '2025-04-05 14:57:21'),
(4, 1, 'products/1743893841_67f1b55117d8e.png', '2025-04-05 14:57:21', '2025-04-05 14:57:21'),
(5, 2, 'products/1743893982_67f1b5def1034.png', '2025-04-05 14:59:43', '2025-04-05 14:59:43'),
(6, 2, 'products/1743893983_67f1b5df09247.jfif', '2025-04-05 14:59:43', '2025-04-05 14:59:43'),
(7, 3, 'products/1743894091_67f1b64bbedcb.png', '2025-04-05 15:01:31', '2025-04-05 15:01:31'),
(8, 3, 'products/1743894091_67f1b64bc6292.png', '2025-04-05 15:01:31', '2025-04-05 15:01:31'),
(9, 3, 'products/1743894091_67f1b64bc8139.png', '2025-04-05 15:01:31', '2025-04-05 15:01:31'),
(10, 4, 'products/1743894282_67f1b70acb6f5.webp', '2025-04-05 15:04:42', '2025-04-05 15:04:42'),
(11, 4, 'products/1743894282_67f1b70ad34b3.jfif', '2025-04-05 15:04:42', '2025-04-05 15:04:42'),
(12, 4, 'products/1743894282_67f1b70ad5c7c.jfif', '2025-04-05 15:04:42', '2025-04-05 15:04:42'),
(13, 5, 'products/1743905205_67f1e1b588bbf.png', '2025-04-05 18:06:45', '2025-04-05 18:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Daily Trainer', NULL, '2025-04-05 18:32:05', '2025-04-05 18:32:05'),
(2, 'Long Run', NULL, '2025-04-05 18:32:05', '2025-04-05 18:32:05'),
(3, 'Race Day', NULL, '2025-04-05 18:32:05', '2025-04-05 18:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_picture`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, 'evan', 'evan@gmail.com', 'profile_pictures/G2JFBo9drzSuWEb17637c6KU873OlYL2aLFfeteL.png', NULL, '$2y$12$eDCOMozLWqksW2.XU2Wh/OVuvLa5PF8CKAnRIaQUWIny7XhSC5WO6', NULL, '2025-03-11 17:15:08', '2025-04-05 05:49:12', 'user', 'active'),
(2, 'jemuel', 'malaga@gmail.com', NULL, NULL, '$2y$12$JR304K1Ncgqe1ETveurEaOFLGOnrFOn7NaW56tma2KHJlLLJTT6LW', NULL, '2025-03-11 17:31:58', '2025-03-11 17:34:58', 'admin', 'active'),
(3, 'ernz', 'ernz@gmail.com', 'profile_pictures/PduMjtIoPADfXIrOTWBhAEA0kLM5HeXrDefN4md7.png', NULL, '$2y$12$beqb.Xz/1Nj84EDkg.GJiO9Rqsf8kdU8goOdoNqlYt5/zDesZ9S0W', NULL, '2025-04-05 05:45:02', '2025-04-05 11:46:11', 'user', 'active'),
(4, 'mosy', 'ntmosy@gmail.com', 'profile_pictures/vtG3LwEFDT3jvt9cLw1fcoeJNV0pPfIv68c2C4Gz.png', NULL, '$2y$12$HidmI2MqJI8rt0Jnz9mYVOzUoHPY5S5XgS2WKjIRLOARvAsLprjwW', NULL, '2025-04-05 08:25:13', '2025-04-05 08:26:59', 'customer', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_type_id_foreign` (`type_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
