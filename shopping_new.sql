-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2020 at 05:30 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_thumb_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2020_09_28_193600_laratrust_setup_tables', 1),
(10, '2020_09_30_101222_create_products_table', 1),
(11, '2020_09_30_102413_create_categories_table', 1),
(12, '2020_10_07_183813_create_shoppingcart_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00f500ccafc9e4026a28198fb5568a189d73d844207580d3ae807c3cbdc6a08a4698de097fb17489', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 18:04:57', '2020-10-10 18:04:57', '2021-10-10 23:04:57'),
('07e71f5170b9133c194939c67e87ce7660baf2c0bdb6ebd78c31020281139b2a3da02907c34a4e3d', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 17:42:58', '2020-10-10 17:42:58', '2021-10-10 22:42:58'),
('092fac9240af8bac299a4a5005cc2353e0d913787ecf3e4c08d136f34f6d2b1fbbb7a63f8dc84f64', 9, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 19:29:45', '2020-10-10 19:29:45', '2021-10-11 00:29:45'),
('1437f4f1a87a139a78b45f27fe86c63118794bb5bc8fe9f6e16e3ad0603fbfdb647bd8d8f0982c85', 7, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 18:24:50', '2020-10-10 18:24:50', '2021-10-10 23:24:50'),
('18837a63fa3b16557c9b64e05ccf5ea55dc817178733657b960c5f290f0c8500245d6a7b0889ec04', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 13:51:58', '2020-10-10 13:51:58', '2021-10-10 18:51:58'),
('26cd2f62dd78c9d9088a61efd9d00b733772896480060f4ef47b45a0673ca918d0609c50652a7557', 9, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 19:29:39', '2020-10-10 19:29:39', '2021-10-11 00:29:39'),
('2d2b82e568746ad6c2a2ee6947661968d4967627a62dfdb6abb9f87756d721afe1e790388b5364fd', 2, 1, 'authToken', '[]', 0, '2020-10-10 19:28:19', '2020-10-10 19:28:19', '2021-10-11 00:28:19'),
('32b6db9415511e47ce71a0974d14448249ac9061a112dc45faafb0b064c5d777e7b3df5244250fb5', 2, 1, 'authToken', '[]', 0, '2020-10-10 19:00:43', '2020-10-10 19:00:43', '2021-10-11 00:00:43'),
('366c88c8576070bf6ea9c2653068f65e23d0047eb69262bd7185fb56c333f0390952e57170ea70c0', 4, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 13:49:50', '2020-10-10 13:49:50', '2021-10-10 18:49:50'),
('38ef0abf1d31ba393a7913fdceed1c9403155b3f81b5ac2dcdd91f480277f5c467bfc64955185f52', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 13:52:21', '2020-10-10 13:52:21', '2021-10-10 18:52:21'),
('3ecbbe3842e03b38d92d7016146e91ab22828145f42273e259a92f8df6f6e1575849be028c5a8b20', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 18:16:08', '2020-10-10 18:16:08', '2021-10-10 23:16:08'),
('5a93417ea3b96b54d1ffc6007432b74c74d18c71ba826b7bb7fd27b17b9ab1b275c1484494a4aebc', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 17:41:37', '2020-10-10 17:41:37', '2021-10-10 22:41:37'),
('8b37d4299a194b17795257371776d2b2f75f0a9da9f89a0fc627b69e121f8de30f46a81ce34b9266', 6, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 18:23:52', '2020-10-10 18:23:52', '2021-10-10 23:23:52'),
('a1e8646b04106835f65da7725d076222dbcdb9d4dc4cf785f7c17c9ad6125cac28a60b32a5c00c8d', 2, 1, 'authToken', '[]', 0, '2020-10-10 18:59:37', '2020-10-10 18:59:37', '2021-10-10 23:59:37'),
('b103dddb5e2b34c8a9b5e63e195480cc9905f19be08fcb69356eaa47ba1330440d9fa206c07831c7', 9, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 19:19:03', '2020-10-10 19:19:03', '2021-10-11 00:19:03'),
('bcb69d2f399983a3bc1ac3bb4b480b71308ee9169b5b736ecc4b3943b637a86548c4fd1fa7f15c11', 2, 1, 'authToken', '[]', 0, '2020-10-10 19:02:25', '2020-10-10 19:02:25', '2021-10-11 00:02:25'),
('c34d2b3d574cc78cb5887658b1b66c4ae3890504c0e8d9a439a92882abfa29e3a7fcea397771807e', 10, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 19:26:37', '2020-10-10 19:26:37', '2021-10-11 00:26:37'),
('d7fbc37640ba23bcad013bb51277d678db7e27bfea988ce63858154d444b5c1f6a02c68c2fbc887d', 2, 1, 'authToken', '[]', 0, '2020-10-10 19:03:17', '2020-10-10 19:03:17', '2021-10-11 00:03:17'),
('db26daa1cc2efe54e50d743379ee5f1eacdc6d80a47705d04ff3d39c461e2285aced194aa39c2143', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 18:17:45', '2020-10-10 18:17:45', '2021-10-10 23:17:45'),
('e6008d73585004d16a09bc5795c72e965e743697df3bcee8e259df5a3c5b68543085e72816f14c2a', 5, 1, 'ImprintTokenAccess', '[]', 0, '2020-10-10 17:38:33', '2020-10-10 17:38:33', '2021-10-10 22:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ImprintTokenAccess', 'tYqVXrdHNA6zJoWVeljy8CTeipO2sv5S4uWmlEQV', NULL, 'http://localhost', 1, 0, 0, '2020-10-07 15:35:30', '2020-10-07 15:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-10-07 15:35:30', '2020-10-07 15:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'users-create', 'Create Users', 'Create Users', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(2, 'users-read', 'Read Users', 'Read Users', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(3, 'users-update', 'Update Users', 'Update Users', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(4, 'users-delete', 'Delete Users', 'Delete Users', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(5, 'payments-create', 'Create Payments', 'Create Payments', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(6, 'payments-read', 'Read Payments', 'Read Payments', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(7, 'payments-update', 'Update Payments', 'Update Payments', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(8, 'payments-delete', 'Delete Payments', 'Delete Payments', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(9, 'profile-read', 'Read Profile', 'Read Profile', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(10, 'profile-update', 'Update Profile', 'Update Profile', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(11, 'module_1_name-create', 'Create Module_1_name', 'Create Module_1_name', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(12, 'module_1_name-read', 'Read Module_1_name', 'Read Module_1_name', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(13, 'module_1_name-update', 'Update Module_1_name', 'Update Module_1_name', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(14, 'module_1_name-delete', 'Delete Module_1_name', 'Delete Module_1_name', '2020-10-07 15:14:39', '2020-10-07 15:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(9, 2),
(10, 2),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 4),
(14, 4);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `thumb_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instock` tinyint(1) NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_thumb_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `cat_thumb_url`, `cat_image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'superadministrator', 'Superadministrator', NULL, NULL, 'Superadministrator', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(2, 'administrator', 'Administrator', NULL, NULL, 'Administrator', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(3, 'user', 'User', NULL, NULL, 'User', '2020-10-07 15:14:39', '2020-10-07 15:14:39'),
(4, 'role_name', 'Role Name', NULL, NULL, 'Role Name', '2020-10-07 15:14:39', '2020-10-07 15:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\User'),
(3, 2, 'App\\User'),
(3, 3, 'App\\User'),
(3, 4, 'App\\User'),
(3, 5, 'App\\User'),
(3, 6, 'App\\User'),
(3, 7, 'App\\User'),
(3, 8, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_user_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_flag` enum('1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `firebase_user_uid`, `verification_code`, `avatar`, `provider`, `provider_id`, `verify_flag`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Imprint Admin', 'admin@admin.com', '2020-10-21 07:34:20', '$2y$10$MnLB5EYf0bn.J0/bQRhRtu1Vzo44yAo3SfV9ryyipXsMj3TbUstmu', NULL, NULL, '8154', NULL, 'email', NULL, '3', '3PvvXy72Y5mVxXhn6XmNWVFtsQfOGQqYqiGMCWxAjcFxoMjjUxDWqBLaPCpr', '2020-10-21 02:34:01', '2020-10-21 02:34:01'),
(2, 'Imprint User', 'imprinttesuser@imprint.com', '2020-10-06 07:37:35', '$2y$10$UcNuMvQl4DQh4cOw0EmPhu2hNTKvgiS0WXMT.Ua.WGR.I.W6Kb5q6', NULL, NULL, NULL, NULL, NULL, NULL, '3', NULL, '2020-10-21 02:36:19', '2020-10-21 02:36:19'),
(3, 'Mudassar Rauf', 'mudassar.mscit@gmail.com', '2020-10-21 02:53:33', '$2y$10$BTny5siZyGn.YNyRMDOLv.MWKKn86HAdfzU6jtLxQYfmJhIVfGo5a', NULL, NULL, NULL, NULL, NULL, NULL, '3', 'pSCg9mij1jNTplz8PMKzSAUlVzIkj6TEhlTlOIicqqiUxWpV0fackuTgrIA2', '2020-10-21 02:47:47', '2020-10-21 02:53:33'),
(4, 'Moon Umair', 'moon_umair@yahoo.com', '2020-10-21 02:53:51', '$2y$10$GY/PePg7B7g36KqHHsy2F.f51c8a2RtYZj/h2nxvGP4mqr9gFxPnO', NULL, NULL, NULL, NULL, NULL, NULL, '3', 'b0ixjYcGeoQ6fnBBAJg589GHSuzSHoXSoI1mBxgSSYkfWvaqVQVVTDMCQ3wY', '2020-10-21 02:53:51', '2020-10-21 02:53:51'),
(5, 'Imprint User', 'imprintuser-5f8ff3919f759@imprint.com', '2020-10-21 03:39:59', '$2y$10$cvaxv.uLx7mGk3IUAXgKm.oWH3koXL51oRNPnQH.ePxROHU1NX/u6', '+923134649555', NULL, '6556', NULL, 'phone', NULL, '3', 'gFDcUWiB2SAyOlrw8xbGbBf7eEYhOMjTPiMcHc746ENGyRV5NFrVmKZAhstL', '2020-10-21 03:38:41', '2020-10-21 03:39:59'),
(6, 'Imprint User', 'testuser@test.com', '2020-10-21 11:02:24', '$2y$10$XvCDC6Alx716jXfDFiA5ceh/mx2xMMNKYmzH53McqoVLoeYvbjOg6', NULL, NULL, '9963', NULL, 'email', NULL, '3', 'oP0ga6qIFk4aWiZ1HSsqSnPl2m6QivEvCt81va2aXyumQyDehfxaYposqL18', '2020-10-21 11:01:41', '2020-10-21 11:02:24'),
(7, 'Imprint User', 'moon@1test.com', '2020-10-21 11:11:08', '$2y$10$qMklH/Q.m1Up.2sihdLu/eDqAUmD2XYHtJx5JxQLz.rVixjEit6Gq', NULL, NULL, '3610', NULL, 'email', NULL, '3', 'aXBKY3maDdx8U6kel2jDn3zTYGNOQOCuSWDZbqMKw21kvH1AlR4qIj8SS7tF', '2020-10-21 11:10:43', '2020-10-21 11:11:08'),
(8, 'Mudassar Test', 'testyy@test.com', '2020-10-21 12:06:36', '$2y$10$vr3rjDYqqVeTkcrw1M7Ii.f9LM1bcBg9nxOvFu3/bM0CfT3/bxpO6', NULL, NULL, '7405', NULL, 'email', NULL, '3', 'CjBf4LUaitfzFPhBfxBvthLe02ztnfz2k4zzrRkZVNOFpnK0tLa7a6NuZlC7', '2020-10-21 12:06:08', '2020-10-21 12:07:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
