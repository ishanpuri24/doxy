-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jul 26, 2021 at 03:48 PM
-- Server version: 8.0.25
-- PHP Version: 7.4.20

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
-- Table structure for table `custom_user_document`
--

CREATE TABLE `custom_user_document` (
  `id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fields` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`deleted_at`, `id`, `name`, `document_category_id`, `created_at`, `updated_at`, `slug`, `author_role`) VALUES
(NULL, 1, 'Residential Lease Or Month-To-Month Rental Agreement', 3, '2021-04-09 01:41:44', '2021-04-22 06:38:04', 'residential-lease-or-month-to-month-rental-agreement', 'admin'),
(NULL, 2, 'Cash For Keys Agreement', 3, '2021-04-09 01:41:44', '2021-04-22 06:38:09', 'cash-for-keys-agreement', 'admin'),
(NULL, 3, 'Commercial Lease Agreement', 3, '2021-04-09 01:41:44', '2021-04-22 06:38:12', 'commercial-lease-agreement', 'admin'),
(NULL, 4, 'Commercial Move In Move Out Inspection', 3, '2021-04-09 01:41:44', '2021-04-22 06:38:16', 'commercial-move-in-move-out-inspection', 'admin'),
(NULL, 5, 'Extension Of Lease', 3, '2021-04-09 01:41:45', '2021-04-22 06:38:19', 'extension-of-lease', 'admin'),
(NULL, 6, 'Cancellation Of Lease Or Rent', 3, '2021-04-09 01:41:45', '2021-04-22 06:38:23', 'cancellation-of-lease-or-rent', 'admin'),
(NULL, 7, 'Residential Move In Move Out Inspection', 3, '2021-04-09 01:41:45', '2021-04-22 06:38:26', 'residential-move-in-move-out-inspection', 'admin'),
(NULL, 8, 'Pets Addendum', 3, '2021-04-09 01:41:45', '2021-06-14 09:22:45', 'pets-addendum', 'admin'),
(NULL, 19, 'Custom', 3, NULL, NULL, 'custom', 'user'),
('2021-07-20 19:28:32', 20, 'Test', 3, '2021-07-07 18:46:40', '2021-07-20 19:28:32', 'test', 'admin'),
('2021-07-07 19:30:07', 21, 'jbh', 3, '2021-07-07 18:46:54', '2021-07-07 19:30:07', 'jbh', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `document_category`
--

CREATE TABLE `document_category` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_category_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_category`
--

INSERT INTO `document_category` (`id`, `name`, `parent_category_id`, `created_at`, `updated_at`) VALUES
(3, 'Real Estate', 0, '2021-04-21 11:17:56', '2021-05-24 04:16:58'),
(16, 'Business & Contracts', 0, '2021-05-24 04:17:10', '2021-05-24 04:17:10'),
(17, 'Family & Personal', 0, '2021-05-24 04:17:32', '2021-05-24 04:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `document_field`
--

CREATE TABLE `document_field` (
  `id` bigint UNSIGNED NOT NULL,
  `document_variation_id` bigint UNSIGNED NOT NULL,
  `field_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `field_slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `html_input_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `document_field_group_id` bigint UNSIGNED NOT NULL,
  `wrap_text` int NOT NULL DEFAULT '0',
  `line_length` int DEFAULT NULL,
  `line_height` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_field_group`
--

CREATE TABLE `document_field_group` (
  `id` bigint UNSIGNED NOT NULL,
  `document_variation_id` bigint UNSIGNED NOT NULL,
  `group_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_variation`
--

CREATE TABLE `document_variation` (
  `id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `document_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_position`
--

CREATE TABLE `field_position` (
  `id` bigint UNSIGNED NOT NULL,
  `document_field_id` bigint UNSIGNED NOT NULL,
  `page` int NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generated_document`
--

CREATE TABLE `generated_document` (
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `document_variation_id` bigint UNSIGNED NOT NULL,
  `document_fields_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
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
(17, '2021_03_05_153447_add_status_deleted_to_document_types', 5),
(18, '2021_04_08_113202_create_document_category_table', 6),
(19, '2021_04_08_105835_create_document_table', 7),
(20, '2021_04_08_111901_create_document_variation_table', 8),
(21, '2021_04_08_112801_create_document_field_table', 9),
(22, '2021_04_08_124119_create_generated_document_table', 10),
(23, '2021_04_08_125532_drop_documents_table', 11),
(24, '2021_04_09_060736_clone_data_types_table', 12),
(25, '2021_04_09_064257_drop_document_type_table', 13),
(26, '2021_04_09_072606_create_document_slugs', 14),
(27, '2021_04_09_104205_generate_document_field_slugs', 15),
(28, '2021_04_12_120334_add_document_field_types', 16),
(31, '2021_04_13_055903_create_document_field_group_table', 17),
(32, '2021_04_13_081251_make_field_group_description_nullable', 18),
(33, '2021_05_20_120551_remove_document_template_column_document_variation_table', 19),
(35, '2021_05_20_130358_create_field_position_table', 20),
(36, '2021_05_20_134301_create_template_image_table', 21),
(37, '2021_05_20_140006_create_signatories_table', 22),
(38, '2021_05_20_140914_create_signature_positions_table', 22),
(39, '2021_05_26_114425_create_questions_answers_table', 23),
(41, '2021_06_02_101125_drop_user_migrations_table', 24),
(42, '2021_06_02_101547_create_user_document_table', 25),
(43, '2021_06_03_140826_add_text_wrap_columns_to_document_field_table', 26),
(44, '2021_06_04_135827_drop_is_complete_column_user_document', 27),
(46, '2021_06_07_064230_rename_max_lines_col_to_line_height', 28),
(47, '2021_06_09_075836_add_user_id_to_user_document', 29),
(48, '2021_06_09_100027_add_user_document_share_details_to_user_document_table', 30),
(49, '2021_06_09_120250_create_custom_user_document_table', 31),
(50, '2021_06_09_123841_add_user_id_column_custom_user_document', 32),
(51, '2021_06_14_064811_add_author_role_to_document_table', 33),
(52, '2021_06_14_065452_add_creator_id_to_document_variation_table', 34),
(53, '2021_06_14_092457_update_foreign_relation_document_field_group', 35),
(57, '2021_06_14_125534_set_default_value_for_shared_with_user_document', 36),
(60, '2021_06_15_072331_create_user_signatures_table', 37),
(61, '2021_06_18_112003_create_signature_request_table', 38),
(62, '2021_06_18_121838_add_signature_status_signature_request', 39),
(63, '2021_07_26_152445_add_contact_description', 40);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('indeshprinja@gmail.com', '$2y$10$k5oH0/nXzwHu/GodUswXNuOG9pra30nI67pLwCnDneVS6jsYjYHzK', '2021-03-04 07:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `question_answer`
--

CREATE TABLE `question_answer` (
  `id` bigint UNSIGNED NOT NULL,
  `document_id` bigint UNSIGNED NOT NULL,
  `question` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_answer`
--

INSERT INTO `question_answer` (`id`, `document_id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(11, 1, 'Who is this document meant for?', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt ea recusandae officia quae aut explicabo ullam? Dolore quibusdam perferendis quaerat eius saepe architecto mollitia, atque error in beatae odit commodi.', '2021-05-27 02:09:12', '2021-05-27 02:09:12'),
(12, 1, 'Who are parties to this agreement?', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt ea recusandae officia quae aut explicabo ullam? Dolore quibusdam perferendis quaerat eius saepe architecto mollitia, atque error in beatae odit commodi.', '2021-05-27 02:09:57', '2021-05-27 02:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `signatory`
--

CREATE TABLE `signatory` (
  `id` bigint UNSIGNED NOT NULL,
  `document_variation_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signature_position`
--

CREATE TABLE `signature_position` (
  `id` bigint UNSIGNED NOT NULL,
  `signatory_id` bigint UNSIGNED NOT NULL,
  `template_image_id` bigint UNSIGNED NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signature_request`
--

CREATE TABLE `signature_request` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_document_id` bigint UNSIGNED NOT NULL,
  `user_contacts_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_signed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_image`
--

CREATE TABLE `template_image` (
  `id` bigint UNSIGNED NOT NULL,
  `document_variation_id` bigint UNSIGNED NOT NULL,
  `page` int NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` int NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `email_verified_at`, `password`, `remember_token`, `role`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '8847494721', NULL, '$2y$10$GeVx49.Nyy4O2x4CiIHmhuyR1ZdSCKbWKsje8GXzbzo99CLLkOOE.', 'lhIjNKnkI32rqKvn3G9BKPbAY8dTDpDPFb4mMH7wy5wv0g1kqenXQgEU7UXZ', 'admin', 1, NULL, '2021-03-04 06:40:14', '2021-03-07 08:46:25'),
(3, 'user', 'user@gmail.com', '75675656', NULL, '$2y$10$63Zzyk5p29.tS4OoH4bbVeFFtgaCs.DV8g1ieMKZGnT4M7VDRpnry', NULL, 'user', 1, NULL, '2021-06-03 08:50:19', '2021-06-07 03:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_contacts`
--

CREATE TABLE `user_contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `contact_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_mobile_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_address` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE `user_document` (
  `id` bigint UNSIGNED NOT NULL,
  `document_variation_id` bigint UNSIGNED NOT NULL,
  `filled_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `shared_with` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_signature`
--

CREATE TABLE `user_signature` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `signature_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_user_document`
--
ALTER TABLE `custom_user_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_user_document_user_id_foreign` (`user_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_name_unique` (`name`),
  ADD KEY `document_document_category_id_foreign` (`document_category_id`);

--
-- Indexes for table `document_category`
--
ALTER TABLE `document_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_category_name_unique` (`name`);

--
-- Indexes for table `document_field`
--
ALTER TABLE `document_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_field_document_variation_id_foreign` (`document_variation_id`);

--
-- Indexes for table `document_field_group`
--
ALTER TABLE `document_field_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_field_group_document_variation_id_foreign` (`document_variation_id`);

--
-- Indexes for table `document_variation`
--
ALTER TABLE `document_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_variation_document_id_foreign` (`document_id`),
  ADD KEY `document_variation_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `field_position`
--
ALTER TABLE `field_position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `field_position_document_field_id_foreign` (`document_field_id`);

--
-- Indexes for table `generated_document`
--
ALTER TABLE `generated_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generated_document_document_id_foreign` (`document_id`),
  ADD KEY `generated_document_document_variation_id_foreign` (`document_variation_id`);

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
-- Indexes for table `question_answer`
--
ALTER TABLE `question_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_answer_document_id_foreign` (`document_id`);

--
-- Indexes for table `signatory`
--
ALTER TABLE `signatory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `signatory_document_variation_id_foreign` (`document_variation_id`);

--
-- Indexes for table `signature_position`
--
ALTER TABLE `signature_position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `signature_position_signatory_id_foreign` (`signatory_id`),
  ADD KEY `signature_position_template_image_id_foreign` (`template_image_id`);

--
-- Indexes for table `signature_request`
--
ALTER TABLE `signature_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `signature_request_user_id_foreign` (`user_id`),
  ADD KEY `signature_request_user_document_id_foreign` (`user_document_id`),
  ADD KEY `signature_request_user_contacts_id_foreign` (`user_contacts_id`);

--
-- Indexes for table `template_image`
--
ALTER TABLE `template_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_image_document_variation_id_foreign` (`document_variation_id`);

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
-- Indexes for table `user_document`
--
ALTER TABLE `user_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_document_document_variation_id_foreign` (`document_variation_id`),
  ADD KEY `user_document_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_signature`
--
ALTER TABLE `user_signature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_signature_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_user_document`
--
ALTER TABLE `custom_user_document`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `document_category`
--
ALTER TABLE `document_category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `document_field`
--
ALTER TABLE `document_field`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `document_field_group`
--
ALTER TABLE `document_field_group`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `document_variation`
--
ALTER TABLE `document_variation`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_position`
--
ALTER TABLE `field_position`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `generated_document`
--
ALTER TABLE `generated_document`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `question_answer`
--
ALTER TABLE `question_answer`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `signatory`
--
ALTER TABLE `signatory`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `signature_position`
--
ALTER TABLE `signature_position`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `signature_request`
--
ALTER TABLE `signature_request`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `template_image`
--
ALTER TABLE `template_image`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_contacts`
--
ALTER TABLE `user_contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_document`
--
ALTER TABLE `user_document`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_signature`
--
ALTER TABLE `user_signature`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_user_document`
--
ALTER TABLE `custom_user_document`
  ADD CONSTRAINT `custom_user_document_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_document_category_id_foreign` FOREIGN KEY (`document_category_id`) REFERENCES `document_category` (`id`);

--
-- Constraints for table `document_field`
--
ALTER TABLE `document_field`
  ADD CONSTRAINT `document_field_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`);

--
-- Constraints for table `document_variation`
--
ALTER TABLE `document_variation`
  ADD CONSTRAINT `document_variation_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`),
  ADD CONSTRAINT `document_variation_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `field_position`
--
ALTER TABLE `field_position`
  ADD CONSTRAINT `field_position_document_field_id_foreign` FOREIGN KEY (`document_field_id`) REFERENCES `document_field` (`id`);

--
-- Constraints for table `generated_document`
--
ALTER TABLE `generated_document`
  ADD CONSTRAINT `generated_document_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`),
  ADD CONSTRAINT `generated_document_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`);

--
-- Constraints for table `question_answer`
--
ALTER TABLE `question_answer`
  ADD CONSTRAINT `question_answer_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`);

--
-- Constraints for table `signatory`
--
ALTER TABLE `signatory`
  ADD CONSTRAINT `signatory_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`);

--
-- Constraints for table `signature_position`
--
ALTER TABLE `signature_position`
  ADD CONSTRAINT `signature_position_signatory_id_foreign` FOREIGN KEY (`signatory_id`) REFERENCES `signatory` (`id`),
  ADD CONSTRAINT `signature_position_template_image_id_foreign` FOREIGN KEY (`template_image_id`) REFERENCES `template_image` (`id`);

--
-- Constraints for table `signature_request`
--
ALTER TABLE `signature_request`
  ADD CONSTRAINT `signature_request_user_contacts_id_foreign` FOREIGN KEY (`user_contacts_id`) REFERENCES `user_contacts` (`id`),
  ADD CONSTRAINT `signature_request_user_document_id_foreign` FOREIGN KEY (`user_document_id`) REFERENCES `user_document` (`id`),
  ADD CONSTRAINT `signature_request_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `template_image`
--
ALTER TABLE `template_image`
  ADD CONSTRAINT `template_image_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`);

--
-- Constraints for table `user_document`
--
ALTER TABLE `user_document`
  ADD CONSTRAINT `user_document_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`),
  ADD CONSTRAINT `user_document_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_signature`
--
ALTER TABLE `user_signature`
  ADD CONSTRAINT `user_signature_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
