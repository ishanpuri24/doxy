-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2021 at 06:10 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_data` blob NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `document_name`, `document_path`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Residential Lease Or Month-To-Month Rental Agreement', 'residential_lease_or_month_to_month_rental_agreement', 1, NULL, '2021-03-04 15:41:53', NULL),
(2, 'Cash For Keys Agreement', 'cash_for_keys_agreement', 1, NULL, '2021-03-04 15:39:07', NULL),
(3, 'Commercial Lease Agreement', 'commercial_lease_agreement', 1, NULL, '2021-03-04 15:39:45', NULL),
(4, 'Commercial Move In Move Out Inspection', 'commercial_move_in_move_out_inspection', 1, NULL, '2021-03-04 15:40:20', NULL),
(5, 'Extension Of Lease', 'extension_of_lease', 1, NULL, '2021-03-04 15:41:22', NULL),
(6, 'Cancellation Of Lease Or Rent', 'cancellation_of_lease_or_rent', 1, NULL, '2021-03-04 15:38:32', NULL),
(7, 'Residential Move In Move Out Inspection', 'residential_move_in_move_out_inspection', 1, NULL, '2021-03-04 15:41:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(8, '2014_10_12_000000_create_document_types_table', 1),
(9, '2014_10_12_000000_create_documents_table', 1),
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2019_08_19_000000_create_failed_jobs_table', 1),
(13, '2021_03_04_105435_add_role_gender_status_to_users', 1),
(14, '2021_03_04_165632_create_user_documents_table', 2),
(15, '2021_03_04_105435_add_mobile_drop_gender_from_users', 3),
(16, '2021_03_05_095523_create_user_contacts_table', 4),
(17, '2021_03_05_153447_add_status_deleted_to_document_types', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('indeshprinja@gmail.com', '$2y$10$k5oH0/nXzwHu/GodUswXNuOG9pra30nI67pLwCnDneVS6jsYjYHzK', '2021-03-04 07:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `email_verified_at`, `password`, `remember_token`, `role`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Prinja Indesh', 'indeshprinja@gmail.com', '8847494721', NULL, '$2y$10$iQfN08DidEPAParWwToRO.BkFno3zGMLgj3ThghatYoBqmxkRGKE6', NULL, 'user', 1, NULL, '2021-03-04 06:40:14', '2021-03-07 08:46:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_contacts`
--

CREATE TABLE `user_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_contacts`
--

INSERT INTO `user_contacts` (`id`, `user_id`, `contact_name`, `contact_email`, `contact_mobile_number`, `contact_address`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pratham Rikhi', 'pratham@gmail.com', '5555588888', '#255, Chheharta, Amritsar', 1, NULL, '2021-03-05 11:06:23', NULL),
(2, 1, 'Priya Prinja', 'priya@gmail.com', '8569874125', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(3, 1, 'Vishal Prinja', 'priya@gmail.com', '8569874125', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(4, 1, 'Diljeet Prinja', 'diljeetprinja@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(5, 1, 'Narinder Prinja', 'nk@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(6, 1, 'Prabha Prinja', 'cp@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(7, 1, 'Palin Prinja', 'cp@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(8, 1, 'Next Prinja', 'cp@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, NULL, '2021-03-05 10:06:23', NULL),
(9, 1, 'Next to Next Prinja', 'cp@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, '2021-03-05 09:41:28', '2021-03-05 10:06:23', '2021-03-05 09:41:28'),
(10, 1, 'Next to Next to Next Prinja', 'cp@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, '2021-03-05 09:39:03', '2021-03-05 10:06:23', '2021-03-05 09:39:03'),
(11, 1, 'Next to Next to Next to Next Prinja', 'cp@gmail.com', '5647851263', '#FC12, HariPura, Amritsar', 1, '2021-03-05 09:39:14', '2021-03-05 10:06:23', '2021-03-05 09:39:14'),
(14, 1, 'asas', 'contact@techhabile.com', '+919780913732', 'SCF 4, Jawala Estate', 1, '2021-03-05 08:51:27', '2021-03-05 08:07:42', '2021-03-05 08:51:27'),
(15, 1, 'IP', 'ip@gmail.com', '5588', NULL, 1, '2021-03-05 08:51:15', '2021-03-05 08:51:04', '2021-03-05 08:51:15'),
(16, 1, 'New', 'ip@gmail.com', '+449780913732', '291', 1, NULL, '2021-03-05 09:45:52', '2021-03-05 09:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `document_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `user_id`, `document_id`, `document_data`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'dsdfsdsfsfsdfs', 1, NULL, '2021-03-04 17:07:33', NULL),
(2, 1, 2, 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzdsdfsdsfsfsdfs', 1, NULL, '2021-03-04 17:07:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_contacts`
--
ALTER TABLE `user_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_contacts`
--
ALTER TABLE `user_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
