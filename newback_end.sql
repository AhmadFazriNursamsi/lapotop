-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 06, 2022 at 09:44 AM
-- Server version: 5.7.35-0ubuntu0.18.04.1
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newback_end`
--

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `id_division` int(100) NOT NULL,
  `division_name` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `flag_delete` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id_division`, `division_name`, `created_at`, `updated_at`, `active`, `flag_delete`) VALUES
(1, 'IT', '2022-04-30 17:00:00', '2022-04-30 17:00:00', 1, 0),
(2, 'Design', '2022-04-30 17:00:00', '2022-04-30 17:00:00', 1, 0),
(3, 'Gudang', '2022-04-30 17:00:00', '2022-04-30 17:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_access`
--

CREATE TABLE `list_access` (
  `id_access` int(11) NOT NULL,
  `name_access` varchar(100) DEFAULT NULL,
  `name_url` varchar(100) DEFAULT NULL,
  `flag_delete` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_access`
--

INSERT INTO `list_access` (`id_access`, `name_access`, `name_url`, `flag_delete`) VALUES
(1, 'users', 'users', 1),
(2, 'divisi', 'division', 0),
(3, 'role', 'role', 0),
(4, 'product', 'product', 0),
(5, 'listaccess', 'listaccess', 0),
(6, 'coba', 'coba', 0),
(7, 'coba2', 'coba2', 0);

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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(10) NOT NULL,
  `role_name` varchar(100) DEFAULT NULL,
  `flag_delete` int(1) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role_name`, `flag_delete`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00'),
(2, 'user', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00'),
(3, 'guest', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00'),
(99, 'superadmin', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_division` int(10) NOT NULL DEFAULT '1',
  `join_date` datetime DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `id_role` int(2) NOT NULL DEFAULT '3',
  `flag_delete` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `id_division`, `join_date`, `mobile`, `active`, `id_role`, `flag_delete`) VALUES
(1, 'superuser', 'superuser', 'superuser@admin.com', NULL, '$2y$10$SFwa85IFn61XbJGjjg5P3uTOY4hSWY..aqhJaPoFL2BUeZULECfjS', NULL, '2022-05-27 06:22:29', '2022-05-26 06:22:29', 1, '2022-05-25 00:00:00', '08775884515', 1, 99, 0),
(2, 'Joko', 'admin1', 'admin1@admin.com', NULL, '$2y$10$SFwa85IFn61XbJGjjg5P3uTOY4hSWY..aqhJaPoFL2BUeZULECfjS', NULL, '2022-05-27 06:22:29', '2022-06-02 02:46:35', 2, '2022-05-25 00:00:00', '08775884515', 1, 1, 1),
(3, 'Budi', 'itbudi', 'it1@admin.com', NULL, '$2y$10$r.xdlZp5pOa58e631UFNd./h5LDhO9rZpwbEgqpWfEcPgKDMVGw5m', NULL, '2022-05-27 06:22:29', '2022-06-02 02:47:00', 3, '2022-05-25 00:00:00', '08775884515', 1, 1, 0),
(4, 'IcTc', 'adminx1', 'adminx1@admin11.com', NULL, '$2y$10$SFwa85IFn61XbJGjjg5P3uTOY4hSWY..aqhJaPoFL2BUeZULECfjS', NULL, '2022-06-01 10:21:31', '2022-06-01 10:21:31', 1, NULL, '0809199204012', 1, 1, 0),
(5, 'IctIlmi', 'IctIlmi', 'IctIlmi@gmail.com', NULL, '$2y$10$1RARxqPb23O/c86uX5XPd.lzlZwf2utQ0NicOB3Csnse/QZ6SuUEq', NULL, '2022-06-01 10:27:29', '2022-06-01 10:27:29', 1, NULL, '087887918595', 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id_access` int(200) NOT NULL,
  `id_users` int(100) DEFAULT '0',
  `name_access` varchar(100) DEFAULT NULL,
  `key_access` varchar(10) DEFAULT NULL,
  `val_access` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id_access`, `id_users`, `name_access`, `key_access`, `val_access`) VALUES
(1, 2, 'users', 'view', '1'),
(2, 2, 'users', 'add', '1'),
(3, 2, 'users', 'edit', '1'),
(4, 2, 'users', 'delete', '1'),
(5, 2, 'users', 'import', '1'),
(6, 2, 'users', 'export', '1'),
(7, 3, 'users', 'view', '1'),
(8, 3, 'users', 'add', '1'),
(9, 3, 'users', 'edit', '0'),
(10, 3, 'users', 'delete', '1'),
(11, 3, 'users', 'import', '1'),
(12, 3, 'users', 'export', '1'),
(13, 2, 'divisi', 'view', '1'),
(14, 2, 'divisi', 'add', '1'),
(15, 2, 'divisi', 'edit', '1'),
(16, 2, 'divisi', 'delete', '1'),
(17, 2, 'divisi', 'import', '1'),
(18, 2, 'divisi', 'export', '1'),
(19, 3, 'divisi', 'view', '1'),
(20, 3, 'divisi', 'add', '1'),
(21, 3, 'divisi', 'edit', '0'),
(22, 3, 'divisi', 'delete', '1'),
(23, 3, 'divisi', 'import', '1'),
(24, 3, 'divisi', 'export', '1'),
(25, 2, 'role', 'add', '1'),
(26, 2, 'role', 'view', '1'),
(27, 3, 'role', 'export', '1'),
(28, 3, 'role', 'import', '0'),
(29, 3, 'role', 'delete', '0'),
(30, 3, 'role', 'edit', '1'),
(31, 3, 'role', 'add', '1'),
(32, 3, 'role', 'view', '1'),
(33, 2, 'role', 'export', '1'),
(34, 2, 'role', 'import', '1'),
(35, 2, 'role', 'delete', '1'),
(36, 2, 'role', 'edit', '1'),
(49, 4, 'divisi', 'view', '1'),
(50, 4, 'divisi', 'add', '1'),
(51, 4, 'divisi', 'edit', '1'),
(52, 4, 'divisi', 'delete', '1'),
(53, 4, 'divisi', 'import', '1'),
(54, 4, 'divisi', 'export', '1'),
(55, 4, 'role', 'view', '1'),
(56, 4, 'role', 'add', '1'),
(57, 4, 'role', 'edit', '1'),
(58, 4, 'role', 'delete', '1'),
(59, 4, 'role', 'import', '1'),
(60, 4, 'role', 'export', '1'),
(61, 4, 'users', 'view', '0'),
(62, 4, 'users', 'add', '0'),
(63, 4, 'users', 'edit', '0'),
(64, 4, 'users', 'delete', '0'),
(65, 4, 'users', 'import', '0'),
(66, 4, 'users', 'export', '0'),
(67, 5, 'divisi', 'view', '1'),
(68, 5, 'divisi', 'add', '1'),
(69, 5, 'divisi', 'edit', '0'),
(70, 5, 'divisi', 'delete', '0'),
(71, 5, 'divisi', 'import', '0'),
(72, 5, 'divisi', 'export', '0'),
(73, 5, 'role', 'view', '1'),
(74, 5, 'role', 'add', '1'),
(75, 5, 'role', 'edit', '0'),
(76, 5, 'role', 'delete', '0'),
(77, 5, 'role', 'import', '0'),
(78, 5, 'role', 'export', '0'),
(79, 5, 'users', 'view', '1'),
(80, 5, 'users', 'add', '1'),
(81, 5, 'users', 'edit', '0'),
(82, 5, 'users', 'delete', '0'),
(83, 5, 'users', 'import', '0'),
(84, 5, 'users', 'export', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id_division`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `list_access`
--
ALTER TABLE `list_access`
  ADD PRIMARY KEY (`id_access`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id_access`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id_division` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `list_access`
--
ALTER TABLE `list_access`
  MODIFY `id_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id_access` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
