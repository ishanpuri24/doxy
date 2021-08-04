-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `custom_user_document`;
CREATE TABLE `custom_user_document` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `custom_user_document_user_id_foreign` (`user_id`),
  CONSTRAINT `custom_user_document_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_name_unique` (`name`),
  KEY `document_document_category_id_foreign` (`document_category_id`),
  CONSTRAINT `document_document_category_id_foreign` FOREIGN KEY (`document_category_id`) REFERENCES `document_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `document` (`deleted_at`, `id`, `name`, `document_category_id`, `created_at`, `updated_at`, `slug`, `author_role`) VALUES
(NULL,	1,	'Residential Lease Or Month-To-Month Rental Agreement',	3,	'2021-04-09 01:41:44',	'2021-04-22 06:38:04',	'residential-lease-or-month-to-month-rental-agreement',	'admin'),
(NULL,	2,	'Cash For Keys Agreement',	3,	'2021-04-09 01:41:44',	'2021-04-22 06:38:09',	'cash-for-keys-agreement',	'admin'),
(NULL,	3,	'Commercial Lease Agreement',	3,	'2021-04-09 01:41:44',	'2021-04-22 06:38:12',	'commercial-lease-agreement',	'admin'),
(NULL,	4,	'Commercial Move In Move Out Inspection',	3,	'2021-04-09 01:41:44',	'2021-04-22 06:38:16',	'commercial-move-in-move-out-inspection',	'admin'),
(NULL,	5,	'Extension Of Lease',	3,	'2021-04-09 01:41:45',	'2021-04-22 06:38:19',	'extension-of-lease',	'admin'),
(NULL,	6,	'Cancellation Of Lease Or Rent',	3,	'2021-04-09 01:41:45',	'2021-04-22 06:38:23',	'cancellation-of-lease-or-rent',	'admin'),
(NULL,	7,	'Residential Move In Move Out Inspection',	3,	'2021-04-09 01:41:45',	'2021-04-22 06:38:26',	'residential-move-in-move-out-inspection',	'admin'),
(NULL,	8,	'Pets Addendum',	3,	'2021-04-09 01:41:45',	'2021-06-14 09:22:45',	'pets-addendum',	'admin'),
(NULL,	19,	'Custom',	3,	NULL,	NULL,	'custom',	'user'),
(NULL,	20,	'Test',	3,	'2021-07-07 18:46:40',	'2021-07-07 19:30:22',	'test',	'admin'),
('2021-07-07 19:30:07',	21,	'jbh',	3,	'2021-07-07 18:46:54',	'2021-07-07 19:30:07',	'jbh',	'admin');

DROP TABLE IF EXISTS `document_category`;
CREATE TABLE `document_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_category_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_category_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `document_category` (`id`, `name`, `parent_category_id`, `created_at`, `updated_at`) VALUES
(3,	'Real Estate',	0,	'2021-04-21 11:17:56',	'2021-05-24 04:16:58'),
(16,	'Business & Contracts',	0,	'2021-05-24 04:17:10',	'2021-05-24 04:17:10'),
(17,	'Family & Personal',	0,	'2021-05-24 04:17:32',	'2021-05-24 04:17:32');

DROP TABLE IF EXISTS `document_field`;
CREATE TABLE `document_field` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_variation_id` bigint(20) unsigned NOT NULL,
  `field_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `field_slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `html_input_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `document_field_group_id` bigint(20) unsigned NOT NULL,
  `wrap_text` int(11) NOT NULL DEFAULT '0',
  `line_length` int(11) DEFAULT NULL,
  `line_height` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_field_document_variation_id_foreign` (`document_variation_id`),
  CONSTRAINT `document_field_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `document_field` (`id`, `document_variation_id`, `field_name`, `created_at`, `updated_at`, `field_slug`, `html_input_type`, `document_field_group_id`, `wrap_text`, `line_length`, `line_height`) VALUES
(1,	2,	'Property Address',	NULL,	'2021-04-09 06:00:01',	'property_address',	'text',	1,	0,	NULL,	NULL),
(2,	2,	'Cash Payment Amount',	NULL,	'2021-04-09 06:00:02',	'cash_payment_amount',	'number',	2,	0,	NULL,	NULL),
(3,	2,	'Property vacate date',	NULL,	'2021-04-09 06:00:02',	'property_vacation_date',	'date',	3,	0,	NULL,	NULL),
(4,	2,	'Transfer property title on Foreclosure',	NULL,	'2021-04-09 06:00:02',	'transfer_property_title_on_foreclosure',	'checkbox',	4,	0,	NULL,	NULL),
(5,	2,	'Occupant shall pay utilities by Move Out date',	NULL,	NULL,	'occupant_shall_pay_utilities_by_move_out_date',	'checkbox',	5,	0,	NULL,	NULL),
(6,	2,	'Property Occupants (comma-separated list)',	NULL,	NULL,	'property_occupants',	'text',	6,	0,	NULL,	NULL),
(7,	2,	'Signing Date',	NULL,	NULL,	'signing_date',	'date',	7,	0,	NULL,	NULL),
(9,	2,	'City',	NULL,	NULL,	'property_city',	'text',	1,	0,	NULL,	NULL),
(10,	2,	'State',	NULL,	NULL,	'property_state',	'text',	1,	0,	NULL,	NULL),
(11,	3,	'Date',	NULL,	NULL,	'date',	'date',	8,	0,	NULL,	NULL),
(12,	3,	'Landlord Name',	NULL,	NULL,	'landlord_name',	'text',	9,	0,	NULL,	NULL),
(13,	3,	'Tenant Name',	NULL,	NULL,	'tenant_name',	'text',	9,	0,	NULL,	NULL),
(14,	3,	'Premises Name',	NULL,	NULL,	'premises_name',	'text',	10,	0,	NULL,	NULL),
(15,	3,	'Percentage of Total Square Footage',	NULL,	NULL,	'premises_percentage_of_total_square_footage',	'number',	11,	0,	NULL,	NULL),
(16,	3,	'Premises Exhibit name',	NULL,	NULL,	'premises_exhibit_name',	'text',	12,	0,	NULL,	NULL),
(17,	3,	'Term Commencement Date',	NULL,	NULL,	'term_commencement_date',	'date',	13,	0,	NULL,	NULL),
(18,	3,	'Lease Agreement',	NULL,	NULL,	'contract_lease',	'checkbox',	14,	0,	NULL,	NULL),
(19,	3,	'Month-to-Month Rental Agreement',	NULL,	NULL,	'contract_month_to_month',	'checkbox',	14,	0,	NULL,	NULL),
(20,	3,	'Lease Termination Date',	NULL,	NULL,	'lease_termination_date',	'date',	15,	0,	NULL,	NULL),
(21,	3,	'Lease Termination Time',	NULL,	NULL,	'lease_termination_time',	'time',	15,	0,	NULL,	NULL),
(22,	3,	'Renew Month-to-Month Term',	NULL,	NULL,	'allow_renewal_of_month_to_month_term',	'checkbox',	16,	0,	NULL,	NULL),
(23,	3,	'Attached Addendum Name',	NULL,	NULL,	'month_to_month_addendum_name',	'text',	16,	0,	NULL,	NULL),
(24,	3,	'Fixed Rate',	NULL,	NULL,	'base_rent_rate_fixed',	'checkbox',	17,	0,	NULL,	NULL),
(25,	3,	'Varying Rate',	NULL,	NULL,	'base_rent_rate_varying',	'checkbox',	17,	0,	NULL,	NULL),
(26,	3,	'Between Period',	NULL,	NULL,	'base_rent_rate_between_period',	'checkbox',	17,	0,	NULL,	NULL),
(27,	3,	'Period Rent Amount',	NULL,	NULL,	'base_rent_rate_between_period_amount',	'number',	18,	0,	NULL,	NULL),
(28,	3,	'Period Start Date',	NULL,	NULL,	'base_rent_rate_between_period_start',	'date',	18,	0,	NULL,	NULL),
(29,	3,	'Period End Date',	NULL,	NULL,	'base_rent_rate_between_period_end',	'date',	18,	0,	NULL,	NULL),
(30,	3,	'Pay rent otherwise than 1st of Month',	NULL,	NULL,	'base_rent_pay_not_in_advance',	'checkbox',	19,	0,	NULL,	NULL),
(31,	3,	'Rent Payment Day',	NULL,	NULL,	'base_rent_pay_day',	'number',	19,	0,	NULL,	NULL),
(32,	3,	'Receiver Name',	NULL,	NULL,	'pay_rent_to_name',	'text',	20,	0,	NULL,	NULL),
(33,	3,	'Receiver Address',	NULL,	NULL,	'pay_rent_to_address',	'text',	20,	0,	NULL,	NULL),
(34,	3,	'Early Possession Date',	NULL,	NULL,	'early_possession_date',	'date',	21,	0,	NULL,	NULL),
(35,	3,	'Security Deposit Amount',	NULL,	NULL,	'security_deposit_amount',	'number',	22,	0,	NULL,	NULL),
(36,	3,	'Parking Fee',	NULL,	NULL,	'parking_rental_fee',	'number',	24,	0,	NULL,	NULL),
(37,	3,	'Additional Storage Fee',	NULL,	NULL,	'additional_storage_fee',	'number',	24,	0,	NULL,	NULL),
(38,	3,	'Late Payment Charge',	NULL,	NULL,	'late_rent_payment_charge',	'number',	25,	0,	NULL,	NULL),
(39,	3,	'Premises Condition Problems',	NULL,	NULL,	'premises_condition_problems',	'text',	26,	0,	NULL,	NULL),
(40,	3,	'Manner of Resolution',	NULL,	NULL,	'premises_condition_problems_resolution_manner',	'text',	26,	0,	NULL,	NULL),
(41,	3,	'Premises Usage',	NULL,	NULL,	'premises_usage',	'text',	27,	0,	NULL,	NULL),
(42,	1,	'Date',	NULL,	NULL,	'date',	'date',	28,	0,	NULL,	NULL),
(43,	1,	'Landlord Name',	NULL,	NULL,	'landlord_name',	'text',	29,	0,	NULL,	NULL),
(44,	1,	'Tenant Name',	NULL,	NULL,	'tenant_name',	'text',	29,	0,	NULL,	NULL),
(45,	1,	'Premises Address',	NULL,	NULL,	'premises_address',	'text',	30,	0,	NULL,	NULL),
(46,	1,	'Term Commencement Date',	NULL,	NULL,	'term_commencement_date',	'date',	31,	0,	NULL,	NULL),
(47,	1,	'Lease Agreement',	NULL,	NULL,	'contract_lease',	'checkbox',	32,	0,	NULL,	NULL),
(48,	1,	'Month-to-Month Rental Agreement',	NULL,	NULL,	'contract_month_to_month',	'checkbox',	32,	0,	NULL,	NULL),
(49,	1,	'Lease Termination Date',	NULL,	NULL,	'lease_termination_date',	'date',	33,	0,	NULL,	NULL),
(50,	1,	'Lease Termination Time',	NULL,	NULL,	'lease_termination_time',	'time',	33,	0,	NULL,	NULL),
(51,	1,	'Rent Amount',	NULL,	NULL,	'base_rent_pay_amount',	'number',	34,	0,	NULL,	NULL),
(52,	1,	'Pay rent at later date',	NULL,	NULL,	'base_rent_pay_not_in_advance',	'checkbox',	35,	0,	NULL,	NULL),
(53,	1,	'Day of Month Rent is Due',	NULL,	NULL,	'base_rent_pay_day',	'number',	35,	0,	NULL,	NULL),
(54,	1,	'Security Deposit Amount',	NULL,	NULL,	'security_deposit_amount',	'number',	36,	0,	NULL,	NULL),
(55,	1,	'Deposit with Owner',	NULL,	NULL,	'transfer_security_deposit_to_owner',	'checkbox',	37,	0,	NULL,	NULL),
(56,	1,	'Deposit with Broker',	NULL,	NULL,	'security_deposit_held_by_broker',	'checkbox',	37,	0,	NULL,	NULL),
(57,	1,	'Personal Check',	NULL,	NULL,	'move_in_fund_mode_personal_check',	'checkbox',	38,	0,	NULL,	NULL),
(58,	1,	'Money Order',	NULL,	NULL,	'move_in_fund_mode_money_order',	'checkbox',	38,	0,	NULL,	NULL),
(59,	1,	'Cashiers Check',	NULL,	NULL,	'move_in_fund_mode_cashiers_check',	'checkbox',	38,	0,	NULL,	NULL),
(60,	1,	'Wire / Electronic Transfer',	NULL,	NULL,	'move_in_fund_mode_wire_electronic',	'checkbox',	38,	0,	NULL,	NULL),
(61,	1,	'Maximum delay after Due date',	NULL,	NULL,	'rent_late_payment_max_delay',	'number',	39,	0,	NULL,	NULL),
(62,	1,	'Penalty in case of Payment by Check',	NULL,	NULL,	'rent_late_payment_check_charge',	'number',	39,	0,	NULL,	NULL),
(63,	1,	'Penalty Percentage of Rent Due, in case of Payment by Check',	NULL,	NULL,	'rent_late_payment_check_percentage',	'number',	39,	0,	NULL,	NULL),
(64,	1,	'Parking Fee',	NULL,	NULL,	'parking_rental_fee',	'number',	40,	0,	NULL,	NULL),
(65,	1,	'Additional Storage Fee',	NULL,	NULL,	'additional_storage_fee',	'number',	40,	0,	NULL,	NULL),
(66,	1,	'Other Utility Charges',	NULL,	NULL,	'other_utility_charges',	'text',	40,	0,	NULL,	NULL),
(67,	1,	'Other Utility Charges (exceptions)',	NULL,	NULL,	'other_utility_charges_exception',	'text',	40,	0,	NULL,	NULL),
(68,	1,	'Water Sub-Meters',	NULL,	NULL,	'premises_water_sub_meters',	'checkbox',	41,	0,	NULL,	NULL),
(69,	1,	'Gas Meter',	NULL,	NULL,	'premises_gas_meter',	'checkbox',	41,	0,	NULL,	NULL),
(70,	1,	'Electric Meter',	NULL,	NULL,	'premises_electric_meter',	'checkbox',	41,	0,	NULL,	NULL),
(71,	1,	'Premises Condition Problems',	NULL,	NULL,	'premises_condition_problems',	'text',	42,	0,	NULL,	NULL),
(201,	70,	'Owner Name',	'2021-06-09 02:15:56',	'2021-06-09 02:15:56',	'owner_name_g1PrDRtDrG',	'text',	137,	0,	NULL,	NULL),
(202,	70,	'Landlord Name',	'2021-06-09 02:15:56',	'2021-06-09 02:15:56',	'landlord_name_1SqyFwNmzj',	'text',	137,	0,	NULL,	NULL),
(203,	70,	'Pets age',	'2021-06-09 02:15:56',	'2021-06-09 02:15:56',	'pets_age_BE0jqhfjAj',	'number',	138,	0,	NULL,	NULL),
(205,	83,	'Sample',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21',	'sample_xybSEgPxV4',	'text',	147,	0,	NULL,	NULL),
(206,	84,	'Signature',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21',	'signature_pFn4PeyGIS',	'text',	148,	0,	NULL,	NULL),
(207,	85,	'Signature',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32',	'signature_bhytGWDO5H',	'text',	149,	0,	NULL,	NULL),
(208,	86,	'Signature',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38',	'signature_fq4dN8oORB',	'text',	150,	0,	NULL,	NULL),
(209,	87,	'Signature',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52',	'signature_nz4hyWY5pb',	'text',	151,	0,	NULL,	NULL);

DROP TABLE IF EXISTS `document_field_group`;
CREATE TABLE `document_field_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_variation_id` bigint(20) unsigned NOT NULL,
  `group_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_field_group_document_variation_id_foreign` (`document_variation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `document_field_group` (`id`, `document_variation_id`, `group_name`, `group_description`, `created_at`, `updated_at`) VALUES
(1,	2,	'What is the property address',	'Please provide property address details',	NULL,	NULL),
(2,	2,	'What is the agreed Cash Payment Amount',	'Please provide the full monetary amount that has been mutually agreed',	NULL,	NULL),
(3,	2,	'What is the date by which the property will be vacated by current tenants',	'Please provide the maximum date',	NULL,	NULL),
(4,	2,	'Will the property title be transferred to owner in case of foreclosure',	'',	NULL,	NULL),
(5,	2,	'Will the current residents of the property pay for outstanding utilities by Move-out date',	'',	NULL,	NULL),
(6,	2,	'Who will be the new occupants of the property',	'Please provide a list of new occupants',	NULL,	NULL),
(7,	2,	'What should be document signing date',	'Please provide a date at which this document is to become legally binding',	NULL,	NULL),
(8,	3,	'What is the date of agreement',	'Please enter the date at which this agreement is to become legally binding',	NULL,	NULL),
(9,	3,	'What are the names of the parties involed',	'Please enter the full names of the following persons',	NULL,	NULL),
(10,	3,	'What is the name of the premises',	'Please enter the full name of the premises',	NULL,	NULL),
(11,	3,	'What is the percentage of premises Square Footage',	'Please enter the percentage of premises square footage relative to the total rentable space of the entire property',	NULL,	NULL),
(12,	3,	'What is the name of the premises exhibit addendum',	'Please enter the name of the addendum detailing the premises',	NULL,	NULL),
(13,	3,	'What is the date of Term Commencement',	'Please enter that date at which the term will begin',	NULL,	NULL),
(14,	3,	'What is the type of Term contract',	'Please specify whether the term is in accordance with a Lease agreement or Month-to-Month rental agreement (select one)',	NULL,	NULL),
(15,	3,	'What are the dates related to Term Lease Agreement',	'If the term is in accordance with a Lease agreement, please provide the following information',	NULL,	NULL),
(16,	3,	'Will the tenant be allowed to renew Month-to-Month term',	'If the term is in accordance with Month-to-Month rental agreement, please provide the following information',	NULL,	NULL),
(17,	3,	'What is the nature of Premises Base Rent rate',	'Please select one of the following',	NULL,	NULL),
(18,	3,	'What are the details of the Base Rent rate payable between a period',	'If the Base rent rate is payable within a specific period, please provide the following details',	NULL,	NULL),
(19,	3,	'Will the Base Rent be payable at a date other that 1st of Month',	'',	NULL,	NULL),
(20,	3,	'Who is the receiver of the premises rent',	'',	NULL,	NULL),
(21,	3,	'What is the premises early possession date',	'If the tenant is entitled to early possession of the premises, please specify the prossession date',	NULL,	NULL),
(22,	3,	'What is the agreed amount of security deposit',	'',	NULL,	NULL),
(24,	3,	'What is the details of the following amenities fees',	'If following amenities are applicable to the premises, please provide their details',	NULL,	NULL),
(25,	3,	'What are the charges for late rent payment',	'Please specify the amount of penalty that will be imposed on the tenant in case of late payment of rent',	NULL,	NULL),
(26,	3,	'Are there any problems with the condition of the premises',	'If there are any problems with the premises condition, provide their details and the manner in which they will be resolved',	NULL,	NULL),
(27,	3,	'What will be the primary usage of the premises',	'Please provide the intended usage of premises by the new tenants',	NULL,	NULL),
(28,	1,	'What is the date of the Agreement',	'Please enter the date at which this agreement is to become legally binding',	NULL,	NULL),
(29,	1,	'What are the names of the parties involved',	'Please enter the full names of the following personnel',	NULL,	NULL),
(30,	1,	'What is the address of the Property',	'Please enter the full address of the property, with City and State',	NULL,	NULL),
(31,	1,	'What is the contract term commencement date',	'Please enter the date at which the term of the contract will start',	NULL,	NULL),
(32,	1,	'What is the type of the Term Contract',	'Please select one of the following',	NULL,	NULL),
(33,	1,	'What are the details of the Lease Agreement',	'If the Term agreement is to a Lease agreement, please provide the following information',	NULL,	NULL),
(34,	1,	'What is the amount of Monthly rent',	'',	NULL,	NULL),
(35,	1,	'Will the rent be paid otherwise than 1st of the Month',	'',	NULL,	NULL),
(36,	1,	'What is the amount of the Security Deposit',	'',	NULL,	NULL),
(37,	1,	'Where will the Security deposit be held',	'Please select one of the following',	NULL,	NULL),
(38,	1,	'What is the Mode of Payment for Move-in Fund',	'Please select one of the following',	NULL,	NULL),
(39,	1,	'What are the details of Rent Late Payment Charges',	'',	NULL,	NULL),
(40,	1,	'What are the details of premises amenities',	'',	NULL,	NULL),
(41,	1,	'Which of the following Meters are installed on the Premises',	'',	NULL,	NULL),
(42,	1,	'What is the condition of the premises',	'',	NULL,	NULL),
(137,	70,	'Who is this document meant for?',	NULL,	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(138,	70,	'What are the details of the pet?',	NULL,	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(147,	83,	'Games',	NULL,	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(148,	84,	'Test',	NULL,	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(149,	85,	'Test',	NULL,	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(150,	86,	'Test',	NULL,	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(151,	87,	'Test',	NULL,	'2021-07-07 19:34:52',	'2021-07-07 19:34:52');

DROP TABLE IF EXISTS `document_variation`;
CREATE TABLE `document_variation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint(20) unsigned NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `document_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_variation_document_id_foreign` (`document_id`),
  KEY `document_variation_user_id_foreign` (`user_id`),
  CONSTRAINT `document_variation_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`),
  CONSTRAINT `document_variation_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `document_variation` (`id`, `document_id`, `state`, `created_at`, `updated_at`, `user_id`, `document_name`) VALUES
(1,	1,	'General',	NULL,	NULL,	1,	NULL),
(2,	2,	'General',	NULL,	NULL,	1,	NULL),
(3,	3,	'General',	NULL,	NULL,	1,	NULL),
(70,	8,	'Alaska',	'2021-06-09 02:15:56',	'2021-06-09 02:15:56',	1,	NULL),
(83,	19,	NULL,	'2021-06-14 04:39:21',	'2021-06-14 04:39:21',	1,	'Sample Custom Document'),
(84,	1,	'Alabama',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21',	1,	NULL),
(85,	1,	'Alabama',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32',	1,	NULL),
(86,	1,	'Alabama',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38',	1,	NULL),
(87,	1,	'Alabama',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52',	1,	NULL);

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `field_position`;
CREATE TABLE `field_position` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_field_id` bigint(20) unsigned NOT NULL,
  `page` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_position_document_field_id_foreign` (`document_field_id`),
  CONSTRAINT `field_position_document_field_id_foreign` FOREIGN KEY (`document_field_id`) REFERENCES `document_field` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `field_position` (`id`, `document_field_id`, `page`, `x`, `y`, `created_at`, `updated_at`) VALUES
(118,	201,	1,	385,	209,	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(119,	202,	1,	1216,	770,	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(121,	203,	1,	344,	377,	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(123,	205,	1,	389,	389,	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(124,	206,	1,	920,	208,	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(125,	207,	1,	920,	208,	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(126,	208,	1,	920,	208,	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(127,	209,	1,	920,	208,	'2021-07-07 19:34:52',	'2021-07-07 19:34:52');

DROP TABLE IF EXISTS `generated_document`;
CREATE TABLE `generated_document` (
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint(20) unsigned NOT NULL,
  `document_variation_id` bigint(20) unsigned NOT NULL,
  `document_fields_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `generated_document_document_id_foreign` (`document_id`),
  KEY `generated_document_document_variation_id_foreign` (`document_variation_id`),
  CONSTRAINT `generated_document_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`),
  CONSTRAINT `generated_document_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8,	'2014_10_12_000000_create_document_types_table',	1),
(9,	'2014_10_12_000000_create_documents_table',	1),
(10,	'2014_10_12_000000_create_users_table',	1),
(11,	'2014_10_12_100000_create_password_resets_table',	1),
(12,	'2019_08_19_000000_create_failed_jobs_table',	1),
(13,	'2021_03_04_105435_add_role_gender_status_to_users',	1),
(14,	'2021_03_04_165632_create_user_documents_table',	2),
(15,	'2021_03_04_105435_add_mobile_drop_gender_from_users',	3),
(16,	'2021_03_05_095523_create_user_contacts_table',	4),
(17,	'2021_03_05_153447_add_status_deleted_to_document_types',	5),
(18,	'2021_04_08_113202_create_document_category_table',	6),
(19,	'2021_04_08_105835_create_document_table',	7),
(20,	'2021_04_08_111901_create_document_variation_table',	8),
(21,	'2021_04_08_112801_create_document_field_table',	9),
(22,	'2021_04_08_124119_create_generated_document_table',	10),
(23,	'2021_04_08_125532_drop_documents_table',	11),
(24,	'2021_04_09_060736_clone_data_types_table',	12),
(25,	'2021_04_09_064257_drop_document_type_table',	13),
(26,	'2021_04_09_072606_create_document_slugs',	14),
(27,	'2021_04_09_104205_generate_document_field_slugs',	15),
(28,	'2021_04_12_120334_add_document_field_types',	16),
(31,	'2021_04_13_055903_create_document_field_group_table',	17),
(32,	'2021_04_13_081251_make_field_group_description_nullable',	18),
(33,	'2021_05_20_120551_remove_document_template_column_document_variation_table',	19),
(35,	'2021_05_20_130358_create_field_position_table',	20),
(36,	'2021_05_20_134301_create_template_image_table',	21),
(37,	'2021_05_20_140006_create_signatories_table',	22),
(38,	'2021_05_20_140914_create_signature_positions_table',	22),
(39,	'2021_05_26_114425_create_questions_answers_table',	23),
(41,	'2021_06_02_101125_drop_user_migrations_table',	24),
(42,	'2021_06_02_101547_create_user_document_table',	25),
(43,	'2021_06_03_140826_add_text_wrap_columns_to_document_field_table',	26),
(44,	'2021_06_04_135827_drop_is_complete_column_user_document',	27),
(46,	'2021_06_07_064230_rename_max_lines_col_to_line_height',	28),
(47,	'2021_06_09_075836_add_user_id_to_user_document',	29),
(48,	'2021_06_09_100027_add_user_document_share_details_to_user_document_table',	30),
(49,	'2021_06_09_120250_create_custom_user_document_table',	31),
(50,	'2021_06_09_123841_add_user_id_column_custom_user_document',	32),
(51,	'2021_06_14_064811_add_author_role_to_document_table',	33),
(52,	'2021_06_14_065452_add_creator_id_to_document_variation_table',	34),
(53,	'2021_06_14_092457_update_foreign_relation_document_field_group',	35),
(57,	'2021_06_14_125534_set_default_value_for_shared_with_user_document',	36),
(60,	'2021_06_15_072331_create_user_signatures_table',	37),
(61,	'2021_06_18_112003_create_signature_request_table',	38),
(62,	'2021_06_18_121838_add_signature_status_signature_request',	39);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('indeshprinja@gmail.com',	'$2y$10$k5oH0/nXzwHu/GodUswXNuOG9pra30nI67pLwCnDneVS6jsYjYHzK',	'2021-03-04 07:50:54');

DROP TABLE IF EXISTS `question_answer`;
CREATE TABLE `question_answer` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint(20) unsigned NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_answer_document_id_foreign` (`document_id`),
  CONSTRAINT `question_answer_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `question_answer` (`id`, `document_id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(11,	1,	'Who is this document meant for?',	'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt ea recusandae officia quae aut explicabo ullam? Dolore quibusdam perferendis quaerat eius saepe architecto mollitia, atque error in beatae odit commodi.',	'2021-05-27 02:09:12',	'2021-05-27 02:09:12'),
(12,	1,	'Who are parties to this agreement?',	'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt ea recusandae officia quae aut explicabo ullam? Dolore quibusdam perferendis quaerat eius saepe architecto mollitia, atque error in beatae odit commodi.',	'2021-05-27 02:09:57',	'2021-05-27 02:09:57');

DROP TABLE IF EXISTS `signatory`;
CREATE TABLE `signatory` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_variation_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `signatory_document_variation_id_foreign` (`document_variation_id`),
  CONSTRAINT `signatory_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `signatory` (`id`, `document_variation_id`, `name`, `created_at`, `updated_at`) VALUES
(49,	70,	'Owner',	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(50,	83,	'Owner',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(51,	84,	'Isdan',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(52,	85,	'Isdan',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(53,	86,	'Isdan',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(54,	87,	'Isdan',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52');

DROP TABLE IF EXISTS `signature_position`;
CREATE TABLE `signature_position` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `signatory_id` bigint(20) unsigned NOT NULL,
  `template_image_id` bigint(20) unsigned NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `signature_position_signatory_id_foreign` (`signatory_id`),
  KEY `signature_position_template_image_id_foreign` (`template_image_id`),
  CONSTRAINT `signature_position_signatory_id_foreign` FOREIGN KEY (`signatory_id`) REFERENCES `signatory` (`id`),
  CONSTRAINT `signature_position_template_image_id_foreign` FOREIGN KEY (`template_image_id`) REFERENCES `template_image` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `signature_position` (`id`, `signatory_id`, `template_image_id`, `x`, `y`, `created_at`, `updated_at`) VALUES
(32,	50,	125,	594,	1302,	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(33,	51,	130,	951,	251,	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(34,	51,	130,	970,	244,	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(35,	51,	130,	970,	244,	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(36,	52,	134,	951,	251,	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(37,	52,	134,	970,	244,	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(38,	52,	134,	970,	244,	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(39,	53,	138,	951,	251,	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(40,	53,	138,	970,	244,	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(41,	53,	138,	970,	244,	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(42,	54,	142,	951,	251,	'2021-07-07 19:34:52',	'2021-07-07 19:34:52'),
(43,	54,	142,	970,	244,	'2021-07-07 19:34:52',	'2021-07-07 19:34:52'),
(44,	54,	142,	970,	244,	'2021-07-07 19:34:52',	'2021-07-07 19:34:52');

DROP TABLE IF EXISTS `signature_request`;
CREATE TABLE `signature_request` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_document_id` bigint(20) unsigned NOT NULL,
  `user_contacts_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_signed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `signature_request_user_id_foreign` (`user_id`),
  KEY `signature_request_user_document_id_foreign` (`user_document_id`),
  KEY `signature_request_user_contacts_id_foreign` (`user_contacts_id`),
  CONSTRAINT `signature_request_user_contacts_id_foreign` FOREIGN KEY (`user_contacts_id`) REFERENCES `user_contacts` (`id`),
  CONSTRAINT `signature_request_user_document_id_foreign` FOREIGN KEY (`user_document_id`) REFERENCES `user_document` (`id`),
  CONSTRAINT `signature_request_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `signature_request` (`id`, `user_id`, `user_document_id`, `user_contacts_id`, `created_at`, `updated_at`, `is_signed`) VALUES
(2,	3,	7,	18,	'2021-06-18 07:44:23',	'2021-06-19 04:48:30',	1),
(3,	1,	10,	17,	'2021-07-05 10:10:41',	'2021-07-05 10:13:20',	1),
(4,	1,	4,	1,	'2021-07-07 18:47:18',	'2021-07-07 18:47:18',	0),
(5,	1,	4,	20,	'2021-07-07 19:38:26',	'2021-07-07 19:38:26',	0);

DROP TABLE IF EXISTS `template_image`;
CREATE TABLE `template_image` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_variation_id` bigint(20) unsigned NOT NULL,
  `page` int(11) NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `template_image_document_variation_id_foreign` (`document_variation_id`),
  CONSTRAINT `template_image_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `template_image` (`id`, `document_variation_id`, `page`, `location`, `created_at`, `updated_at`) VALUES
(124,	70,	1,	'70_eMq34tgfwbSANFcXXQkpAxJ4HxoH1SthyvhPCrLz.png',	'2021-06-09 02:15:56',	'2021-06-09 02:15:56'),
(125,	83,	1,	'83_7t7SP5ZhSYLr2E5PEpwMUzuVUZhuE5CB1U4vSGw8.png',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(126,	83,	2,	'83_WCu2CUuxsS7khb7VQsRYDXSMkCeH2jRWx76G5diZ.png',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(127,	83,	3,	'83_3oEY44ydghjFZnsg4cGGcgQzbXie6SgBmcXQwHbr.png',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(128,	83,	4,	'83_sI8Agt5P3lBPQDwrHI4w0WobMShkHQyhAfFTWdMH.png',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(129,	83,	5,	'83_WxFtnRVN44TUWAc68EXAqiS1LXgzO4Q0FPPGAHP8.png',	'2021-06-14 04:39:21',	'2021-06-14 04:39:21'),
(130,	84,	1,	'84_IS7jjFqBdeudF6F7Wi25ijdymt1c6YWB7kcCi42W.png',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(131,	84,	2,	'84_cjFVVcyHXbJdZNzEWzLuXpqLtIMbqcKGBiwOZCWl.png',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(132,	84,	3,	'84_GAy0UDfdJWJD4i4Zgq7mDn4uxEslTakan3dJnyOa.png',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(133,	84,	4,	'84_nzWEQMiPgF02ORkvgpSxzILThJh0i17vx9JSxSr1.png',	'2021-07-07 19:32:21',	'2021-07-07 19:32:21'),
(134,	85,	1,	'85_aQK1LN0AQzb9bdiQKMGiupivQXzk0u6ZOucVQVtC.png',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(135,	85,	2,	'85_Lk0Hld3RXQlPPLEq3uKIpyuPgcOVTJxUo0JxpG52.png',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(136,	85,	3,	'85_F1ow62nhHuGHNDH4LXWsaTtnINL6TBFA68r5clv1.png',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(137,	85,	4,	'85_w8zwtowisErsacp1q50LwhBNRaH6p3s5xHVSoG5r.png',	'2021-07-07 19:32:32',	'2021-07-07 19:32:32'),
(138,	86,	1,	'86_QUhUXnqJAUa7zbTb8J0ScjB3UtBX3ZsCKCJYU8Gc.png',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(139,	86,	2,	'86_G1UDBnmAlW9dvzQMHCG2mOfPDXTInn7sRVElNr5k.png',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(140,	86,	3,	'86_WM0AouHYOZLK5SPJmqGSqKDByCOlPhnMAceNacdM.png',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(141,	86,	4,	'86_yLdB1OcWG8PHcbVIodnxEjfHDhZsTg0VH1swYJrq.png',	'2021-07-07 19:32:38',	'2021-07-07 19:32:38'),
(142,	87,	1,	'87_YIHmVtaxoKpBQPuc4to1HwDYCpwTcJqi4v3SnB4U.png',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52'),
(143,	87,	2,	'87_FzWev2atmlRSSeMhCOgasvGIz9fFSIk2FWm7gdGG.png',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52'),
(144,	87,	3,	'87_ShDaoM79AmNzL8e6CeRv9vNbfoYPKV5d7EbDIvb4.png',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52'),
(145,	87,	4,	'87_YGMZAwcojvggcxIWLJwM4yGEkIb8w2C2uhR0Lklv.png',	'2021-07-07 19:34:52',	'2021-07-07 19:34:52');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` int(11) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `email_verified_at`, `password`, `remember_token`, `role`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin@gmail.com',	'8847494721',	NULL,	'$2y$10$GeVx49.Nyy4O2x4CiIHmhuyR1ZdSCKbWKsje8GXzbzo99CLLkOOE.',	'xOGhAsw9bqy9uTNNux6YVKzPqyeuAGx8Ow8NvsYnbAw38RwARPJQfKOneO1u',	'admin',	1,	NULL,	'2021-03-04 06:40:14',	'2021-03-07 08:46:25'),
(3,	'user',	'user@gmail.com',	'75675656',	NULL,	'$2y$10$63Zzyk5p29.tS4OoH4bbVeFFtgaCs.DV8g1ieMKZGnT4M7VDRpnry',	NULL,	'user',	1,	NULL,	'2021-06-03 08:50:19',	'2021-06-07 03:26:49');

DROP TABLE IF EXISTS `user_contacts`;
CREATE TABLE `user_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_address` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_contacts` (`id`, `user_id`, `contact_name`, `contact_email`, `contact_mobile_number`, `contact_address`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	1,	'Pratham Rikhi',	'something@gmail.com',	'5555588888',	'#255, Chheharta, Amritsar',	1,	NULL,	'2021-03-05 11:06:23',	NULL),
(2,	1,	'Priya Prinja',	'priya@gmail.com',	'8569874125',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(3,	1,	'Vishal Prinja',	'priya@gmail.com',	'8569874125',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(4,	1,	'Diljeet Prinja',	'diljeetprinja@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(5,	1,	'Narinder Prinja',	'nk@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(6,	1,	'Prabha Prinja',	'cp@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(7,	1,	'Palin Prinja',	'cp@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(8,	1,	'Next Prinja',	'cp@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	NULL,	'2021-03-05 10:06:23',	NULL),
(9,	1,	'Next to Next Prinja',	'cp@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	'2021-03-05 09:41:28',	'2021-03-05 10:06:23',	'2021-03-05 09:41:28'),
(10,	1,	'Next to Next to Next Prinja',	'cp@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	'2021-03-05 09:39:03',	'2021-03-05 10:06:23',	'2021-03-05 09:39:03'),
(11,	1,	'Next to Next to Next to Next Prinja',	'cp@gmail.com',	'5647851263',	'#FC12, HariPura, Amritsar',	1,	'2021-03-05 09:39:14',	'2021-03-05 10:06:23',	'2021-03-05 09:39:14'),
(14,	1,	'asas',	'contact@techhabile.com',	'+919780913732',	'SCF 4, Jawala Estate',	1,	'2021-03-05 08:51:27',	'2021-03-05 08:07:42',	'2021-03-05 08:51:27'),
(15,	1,	'IP',	'ip@gmail.com',	'5588',	NULL,	1,	'2021-03-05 08:51:15',	'2021-03-05 08:51:04',	'2021-03-05 08:51:15'),
(16,	1,	'New',	'ip@gmail.com',	'+449780913732',	'291',	1,	'2021-06-09 04:57:08',	'2021-03-05 09:45:52',	'2021-06-09 04:57:08'),
(17,	1,	'User',	'user@gmail.com',	'312313123',	'123 Apple Street',	1,	NULL,	'2021-06-09 04:56:19',	'2021-06-09 04:56:19'),
(18,	3,	'Admin',	'admin@gmail.com',	'123123123123',	'1213 Google Street, Silicon Valley',	1,	NULL,	'2021-06-16 02:28:28',	'2021-06-16 02:28:28'),
(19,	1,	'adfd',	'swdfsd@gmail.com',	'2342',	'234234',	1,	NULL,	'2021-07-01 21:17:11',	'2021-07-01 21:17:11'),
(20,	1,	'Ishan',	'ishanpuri24@gmail.com',	'8053121754',	NULL,	1,	NULL,	'2021-07-07 19:38:05',	'2021-07-07 19:38:05');

DROP TABLE IF EXISTS `user_document`;
CREATE TABLE `user_document` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_variation_id` bigint(20) unsigned NOT NULL,
  `filled_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '1',
  `shared_with` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_document_document_variation_id_foreign` (`document_variation_id`),
  KEY `user_document_user_id_foreign` (`user_id`),
  CONSTRAINT `user_document_document_variation_id_foreign` FOREIGN KEY (`document_variation_id`) REFERENCES `document_variation` (`id`),
  CONSTRAINT `user_document_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_document` (`id`, `document_variation_id`, `filled_data`, `created_at`, `updated_at`, `user_id`, `shared_with`) VALUES
(4,	70,	'{\"owner_name_g1PrDRtDrG\":\"Moeen\",\"landlord_name_1SqyFwNmzj\":\"Saad\",\"pets_age_BE0jqhfjAj\":\"50\"}',	'2021-06-09 02:35:41',	'2021-06-16 06:50:33',	1,	'[3]'),
(5,	70,	'{\"owner_name_g1PrDRtDrG\":\"Someone\",\"landlord_name_1SqyFwNmzj\":\"Else\",\"pets_age_BE0jqhfjAj\":\"40\"}',	'2021-06-09 02:43:04',	'2021-06-09 02:43:04',	1,	'[3]'),
(7,	83,	'{\"sample_xybSEgPxV4\":\"Sample\"}',	'2021-06-14 08:10:01',	'2021-06-14 08:10:01',	3,	'[1]'),
(9,	1,	'{\"date\":\"2021-05-23\",\"landlord_name\":\"Werw\",\"tenant_name\":\"Werewrew\",\"premises_address\":\"23r234234\",\"term_commencement_date\":\"2021-06-23\",\"contract_lease\":false,\"contract_month_to_month\":false,\"lease_termination_date\":\"2021-06-23\",\"lease_termination_time\":\"17:21\",\"base_rent_pay_amount\":null,\"base_rent_pay_not_in_advance\":false,\"base_rent_pay_day\":null,\"security_deposit_amount\":null,\"transfer_security_deposit_to_owner\":false,\"security_deposit_held_by_broker\":false,\"move_in_fund_mode_personal_check\":false,\"move_in_fund_mode_money_order\":false,\"move_in_fund_mode_cashiers_check\":false,\"move_in_fund_mode_wire_electronic\":false,\"rent_late_payment_max_delay\":null,\"rent_late_payment_check_charge\":null,\"rent_late_payment_check_percentage\":null,\"parking_rental_fee\":null,\"additional_storage_fee\":null,\"other_utility_charges\":null,\"other_utility_charges_exception\":null,\"premises_water_sub_meters\":false,\"premises_gas_meter\":false,\"premises_electric_meter\":false,\"premises_condition_problems\":null}',	'2021-06-23 21:21:49',	'2021-06-23 21:21:49',	1,	NULL),
(10,	70,	'{\"owner_name_g1PrDRtDrG\":\"Dfdsf\",\"landlord_name_1SqyFwNmzj\":null,\"pets_age_BE0jqhfjAj\":null}',	'2021-06-23 21:23:05',	'2021-06-23 21:23:05',	1,	NULL),
(11,	1,	'{\"date\":\"2223-03-04\",\"landlord_name\":null,\"tenant_name\":null,\"premises_address\":null,\"term_commencement_date\":null,\"contract_lease\":false,\"contract_month_to_month\":false,\"lease_termination_date\":null,\"lease_termination_time\":null,\"base_rent_pay_amount\":null,\"base_rent_pay_not_in_advance\":false,\"base_rent_pay_day\":null,\"security_deposit_amount\":null,\"transfer_security_deposit_to_owner\":false,\"security_deposit_held_by_broker\":false,\"move_in_fund_mode_personal_check\":false,\"move_in_fund_mode_money_order\":false,\"move_in_fund_mode_cashiers_check\":false,\"move_in_fund_mode_wire_electronic\":false,\"rent_late_payment_max_delay\":null,\"rent_late_payment_check_charge\":null,\"rent_late_payment_check_percentage\":null,\"parking_rental_fee\":null,\"additional_storage_fee\":null,\"other_utility_charges\":null,\"other_utility_charges_exception\":null,\"premises_water_sub_meters\":false,\"premises_gas_meter\":false,\"premises_electric_meter\":false,\"premises_condition_problems\":null}',	'2021-07-01 20:52:42',	'2021-07-01 20:52:42',	1,	NULL),
(12,	1,	'{\"date\":\"3434-03-04\",\"landlord_name\":null,\"tenant_name\":null,\"premises_address\":null,\"term_commencement_date\":null,\"contract_lease\":false,\"contract_month_to_month\":false,\"lease_termination_date\":null,\"lease_termination_time\":null,\"base_rent_pay_amount\":null,\"base_rent_pay_not_in_advance\":false,\"base_rent_pay_day\":null,\"security_deposit_amount\":null,\"transfer_security_deposit_to_owner\":false,\"security_deposit_held_by_broker\":false,\"move_in_fund_mode_personal_check\":false,\"move_in_fund_mode_money_order\":false,\"move_in_fund_mode_cashiers_check\":false,\"move_in_fund_mode_wire_electronic\":false,\"rent_late_payment_max_delay\":null,\"rent_late_payment_check_charge\":null,\"rent_late_payment_check_percentage\":null,\"parking_rental_fee\":null,\"additional_storage_fee\":null,\"other_utility_charges\":null,\"other_utility_charges_exception\":null,\"premises_water_sub_meters\":false,\"premises_gas_meter\":false,\"premises_electric_meter\":false,\"premises_condition_problems\":null}',	'2021-07-01 21:11:10',	'2021-07-01 21:11:10',	1,	NULL),
(13,	1,	'{\"date\":\"2021-11-12\",\"landlord_name\":null,\"tenant_name\":null,\"premises_address\":null,\"term_commencement_date\":null,\"contract_lease\":false,\"contract_month_to_month\":false,\"lease_termination_date\":null,\"lease_termination_time\":null,\"base_rent_pay_amount\":null,\"base_rent_pay_not_in_advance\":false,\"base_rent_pay_day\":null,\"security_deposit_amount\":null,\"transfer_security_deposit_to_owner\":false,\"security_deposit_held_by_broker\":false,\"move_in_fund_mode_personal_check\":false,\"move_in_fund_mode_money_order\":false,\"move_in_fund_mode_cashiers_check\":false,\"move_in_fund_mode_wire_electronic\":false,\"rent_late_payment_max_delay\":null,\"rent_late_payment_check_charge\":null,\"rent_late_payment_check_percentage\":null,\"parking_rental_fee\":null,\"additional_storage_fee\":null,\"other_utility_charges\":null,\"other_utility_charges_exception\":null,\"premises_water_sub_meters\":false,\"premises_gas_meter\":false,\"premises_electric_meter\":false,\"premises_condition_problems\":null}',	'2021-07-07 18:44:40',	'2021-07-07 18:44:40',	1,	NULL),
(14,	1,	'{\"date\":\"6789-12-31\",\"landlord_name\":null,\"tenant_name\":null,\"premises_address\":null,\"term_commencement_date\":null,\"contract_lease\":false,\"contract_month_to_month\":false,\"lease_termination_date\":null,\"lease_termination_time\":null,\"base_rent_pay_amount\":null,\"base_rent_pay_not_in_advance\":false,\"base_rent_pay_day\":null,\"security_deposit_amount\":null,\"transfer_security_deposit_to_owner\":false,\"security_deposit_held_by_broker\":false,\"move_in_fund_mode_personal_check\":false,\"move_in_fund_mode_money_order\":false,\"move_in_fund_mode_cashiers_check\":false,\"move_in_fund_mode_wire_electronic\":false,\"rent_late_payment_max_delay\":null,\"rent_late_payment_check_charge\":null,\"rent_late_payment_check_percentage\":null,\"parking_rental_fee\":null,\"additional_storage_fee\":null,\"other_utility_charges\":null,\"other_utility_charges_exception\":null,\"premises_water_sub_meters\":false,\"premises_gas_meter\":false,\"premises_electric_meter\":false,\"premises_condition_problems\":null}',	'2021-07-07 18:44:44',	'2021-07-07 18:44:44',	1,	NULL);

DROP TABLE IF EXISTS `user_signature`;
CREATE TABLE `user_signature` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `signature_image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_signature_user_id_foreign` (`user_id`),
  CONSTRAINT `user_signature_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_signature` (`id`, `user_id`, `signature_image`, `created_at`, `updated_at`) VALUES
(1,	1,	'data:image/png;base64,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',	'2021-06-15 04:23:56',	'2021-06-18 11:32:16');

-- 2021-07-08 07:16:36