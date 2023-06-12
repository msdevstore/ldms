-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 07:15 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ldms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`, `created_at`, `updated_at`) VALUES
(1, 'License', NULL, '2022-06-11 01:41:47', '2022-06-11 01:41:47'),
(3, 'Trade License', '1', '2022-06-11 02:09:24', '2022-06-11 02:09:24'),
(4, 'Foreign Driving License', '1', '2022-06-11 02:10:05', '2022-06-12 03:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `expired_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `tags_for_search` text DEFAULT NULL,
  `alarm` varchar(255) NOT NULL DEFAULT 'no alarm'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `role_id`, `title`, `category_id`, `file_name`, `expired_date`, `email`, `mobile`, `tags_for_search`, `alarm`) VALUES
(50, 4, 'Trade License', NULL, '1551599833sample.pdf', '2020-03-31', 'abc@gmail.com', '+1929111', 'trade', '2020-03-01,2020-03-16,2020-03-24,2020-03-30'),
(51, 4, 'Passport', NULL, '1551599993sample.pdf', '2019-03-31', 'abc@gmail.com', '+88017111111', 'passport', '2019-03-16,2019-03-24,2019-03-30'),
(52, 4, 'Driving License', NULL, '1551600037sample.pdf', '2019-04-17', 'abc@gmail.com', '', 'driving', '2019-03-18,2019-04-02,2019-04-10,2019-04-16'),
(53, 4, 'cnf license', 1, '1551600179sample.pdf', '2019-03-06', 'abc@gmail.com', '+1929111', 'cnf', '2019-03-05'),
(54, 4, 'm123', NULL, '1640852643splash-port-hdpi.png', '2022-01-01', '123@yahoo.com', '123', NULL, '2021-12-31'),
(55, 4, '11wdfw', NULL, '1640853510bill.pdf', '2022-01-01', '11sdfsas@yaho.com', '11234234234dfasdfdsaf', NULL, '2021-12-31'),
(57, 4, 'fsafd', NULL, NULL, '2022-01-02', 'dsfa@ysadfao.com', '2432', 'nid, driving', '2022-01-01'),
(64, 4, 'test', 2, NULL, '2022-07-21', 'tarik_17@yahoo.co.uk', NULL, NULL, '2022-06-21,2022-07-06,2022-07-14,2022-07-20'),
(65, 4, 'Another test', NULL, NULL, '2022-06-30', 'tarik_17@yahoo.co.uk', NULL, NULL, '2022-06-15,2022-06-23,2022-06-29'),
(66, 4, 'jnnj', 3, NULL, '2022-06-22', 'tarik_17@yahoo.co.uk', NULL, NULL, '2022-06-15,2022-06-21');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notify_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `notify_by`, `created_at`, `updated_at`) VALUES
(1, 'LDMS', 'logo.jpg', 'sms', '2019-02-23 22:13:37', '2022-06-11 00:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'en', '2018-11-27 22:16:13', '2019-03-03 00:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_02_01_053447_create_roles_table', 2),
(4, '2018_02_01_083819_add_role_id_to_users_table', 3),
(5, '2018_02_01_090028_add_role_id_to_documents_table', 4),
(6, '2018_11_28_041119_create_languages_table', 5),
(7, '2019_02_23_063058_add_mobile_no_to_users_table', 6),
(8, '2019_02_24_035705_create_general_settings_table', 7),
(9, '2019_02_24_060911_add_site_logo_to_general_settings_table', 8),
(10, '2019_02_27_045754_add_mobile_to_documents_table', 9),
(11, '2022_06_11_062735_create_categories_table', 10),
(12, '2022_06_11_143739_update_documents_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(4, 'admin', '2018-02-03 00:17:28', '2018-02-03 00:17:28'),
(6, 'manager', '2018-02-04 22:42:01', '2018-02-04 22:42:01'),
(8, 'human resource', '2018-02-05 03:55:11', '2018-02-05 03:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `mobile_no`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 4, 'demo@lion-coders.com', NULL, '$2y$10$cuUmwQ5cv0e2qyxWm0imhOtvoojKzcYGVJ6g3DoQF5L08J9qXoozq', 'gZpG7LuT37kzKN6uU6LK0EliKeKyjXz7v9aU0nJPg7sda1Srelwgj91CXN6e', '2017-03-22 21:56:25', '2017-03-25 05:29:28'),
(7, 'mainul', 6, 'moinul@lion-coders.com', NULL, '$2y$10$rfCRayYCHJC.TJx3KQSFturAY4s9pc19cqa/TyqpGzp54mct6uFce', 'aNJ34sgbeKIWccuPhjJjnGWyD5dZLR3uvy3s2F42IPRdG0u7j4oDR9qG2kmY', '2018-02-07 00:44:55', '2018-02-07 00:46:06'),
(9, 'tariq', 8, 'tariq@lion-coders.com', NULL, '$2y$10$BPOE6lXYwhPTMmgLYWVaXOKnzbrDxTjyJO2Imy..UvKXYtIAT9Xua', NULL, '2018-02-07 03:31:52', '2018-02-07 03:31:52'),
(10, 'asd', 6, 'asd@asd.com', NULL, '$2y$10$QpOadbjUtOfWOw9j7D7ix.3sc8DMXUU7.bXshV8bMh6rNIRoBSkIO', 'aXOEiEYGpuURCtNr4HHbB6WEivMfIOJUoGWKPNi73pu8cG45FcDF5IGCiz6J', '2019-01-26 22:58:08', '2019-01-26 22:58:08'),
(18, 'sajid', 4, 'sajid@gmail.com', '+8801741202865', '$2y$10$EdGD0QTwtn0GARDMRgJKe.v.6Mi5KW6J40GstbHU2L9Mr2jAawBfm', NULL, '2019-02-26 23:17:43', '2019-02-26 23:17:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
