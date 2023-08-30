-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2023 at 12:27 PM
-- Server version: 5.7.33
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kodepixel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_settings` longtext COLLATE utf8mb4_unicode_ci,
  `permissions` longtext COLLATE utf8mb4_unicode_ci,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `super_admin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `created_by`, `updated_by`, `uid`, `role_id`, `user_name`, `name`, `phone`, `email`, `notification_settings`, `permissions`, `address`, `email_verified_at`, `password`, `status`, `super_admin`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'aT39-NpFjdYRL-6g75', NULL, 'admin', 'SuperAdmin', '01616243666', 'admin@gmail.com', NULL, NULL, NULL, '2023-08-29 03:54:59', '$2y$10$i0fZUfRAb/4a5GdMdTd3D.oWH9raeBxAIUrpWxmLupHzWmAUnX0Sy', '1', '1', '2023-08-29 12:19:55', NULL, '2023-08-29 03:54:59', '2023-08-29 12:19:55');

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
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `link_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fileable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `disk` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `fileable_type`, `fileable_id`, `name`, `disk`, `type`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Core\\Setting', 3, '64ed6e76e21731693281910.png', 'local', NULL, '2023-08-29 04:05:11', '2023-08-29 04:05:11'),
(2, 'App\\Models\\Core\\Setting', 4, '64ed6e775657b1693281911.png', 'local', NULL, '2023-08-29 04:05:11', '2023-08-29 04:05:11'),
(3, 'App\\Models\\Core\\Setting', 5, '64ed6e775d5261693281911.png', 'local', NULL, '2023-08-29 04:05:11', '2023-08-29 04:05:11'),
(4, 'App\\Models\\Admin\\Frontend', 1, '64ed6f2b491b31693282091.png', 'local', NULL, '2023-08-29 04:08:17', '2023-08-29 04:08:17'),
(5, 'App\\Models\\Admin\\Frontend', 2, '64ed6f4a083371693282122.png', 'local', NULL, '2023-08-29 04:08:42', '2023-08-29 04:08:42'),
(6, 'App\\Models\\Admin\\Frontend', 7, '64ed6fa938a911693282217.png', 'local', NULL, '2023-08-29 04:10:17', '2023-08-29 04:10:17'),
(7, 'App\\Models\\Admin\\Service', 1, '64ed9512566231693291794.png', 'local', NULL, '2023-08-29 06:49:54', '2023-08-29 06:49:54'),
(9, 'App\\Models\\Admin\\Portfolio', 1, '64eda12c0386c1693294892.png', 'local', NULL, '2023-08-29 07:41:32', '2023-08-29 07:41:32'),
(10, 'App\\Models\\Admin\\Service', 3, '64edb7980957f1693300632.avif', 'local', NULL, '2023-08-29 09:17:23', '2023-08-29 09:17:23'),
(11, 'App\\Models\\Admin\\Team', 1, '64edc559f3a141693304153.png', 'local', NULL, '2023-08-29 10:15:54', '2023-08-29 10:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Active : 1,Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `uid`, `updated_by`, `name`, `slug`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Banner section', 'banner_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Creative Design & Development IT Solution !\"},\"primary_short_description\":{\"type\":\"textarea\",\"value\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi obcaecati quae fugit quod deleniti repudiandae veritatis amet sapiente veniam totam ut est ex blanditiis in architecto minima, quos adipisci saepe?\"},\"secondary_heading\":{\"type\":\"text\",\"value\":\"Exclusive Author\"},\"secondary_short_description\":{\"type\":\"textarea\",\"value\":\"Trusted by 10,000+ Businesses in over 120 Countries\"},\"banner_image\":{\"type\":\"file\",\"size\":\"4000x6000\",\"value\":\"64ed6f2b491b31693282091.png\"}}}', '1', NULL, '2023-08-29 04:08:17'),
(2, NULL, 1, 'About section', 'about_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Our mission is to empower businesses with modern technology.\"},\"primary_short_description\":{\"type\":\"textarea\",\"value\":\"Kode Pixel Limited has been providing top-notch IT services to clients worldwide. Our expertise lies in developing software applications and mobile apps, catering to the diverse needs of the digital platform, IT, and software industry.\"},\"banner_image\":{\"type\":\"file\",\"size\":\"480x500\",\"value\":\"64ed6f4a083371693282122.png\"}}}', '0', NULL, '2023-08-29 09:27:06'),
(3, NULL, 1, 'Service section', 'service_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"We Just Offer The Best Services\"}}}', '1', NULL, '2023-08-29 04:08:54'),
(4, NULL, 1, 'Portfolio section', 'portfolio_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Explore some amazing portfolio for our clients\"}}}', '1', NULL, '2023-08-29 09:35:55'),
(5, NULL, 1, 'Process section', 'process_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Our Software Development Process\"}}}', '1', NULL, '2023-08-29 09:51:32'),
(6, NULL, 1, 'Product section', 'product_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Some of our product on marketplace\"}}}', '1', NULL, '2023-08-29 04:09:58'),
(7, NULL, 1, 'Support section', 'support_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Get Support From Our Expert Team Members.\"},\"banner_image\":{\"type\":\"file\",\"size\":\"1901x921\",\"value\":\"64ed6fa938a911693282217.png\"}}}', '1', NULL, '2023-08-29 04:10:17'),
(8, NULL, 1, 'Team section', 'team_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Meet our creative team members.\"},\"primary_short_description\":{\"type\":\"textarea\",\"value\":\"We\\u2019re a diverse team that works as fancies attention to details, enjoys beers on Friday nights and aspires to design the dent in the universe.\"}}}', '1', NULL, '2023-08-29 04:10:38'),
(9, NULL, 1, 'ContactUs section', 'contactUs_section', '{\"static_element\":{\"primary_heading\":{\"type\":\"text\",\"value\":\"Have Questions? Get In Touch!\"},\"primary_short_description\":{\"type\":\"textarea\",\"value\":\"Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo.\"},\"phone_number\":{\"type\":\"text\",\"value\":\"12115656\"},\"email\":{\"type\":\"email\",\"value\":\"something@gmail.com\"}}}', '1', NULL, '2023-08-29 04:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `ltr` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `uid`, `created_by`, `updated_by`, `name`, `code`, `is_default`, `status`, `ltr`, `created_at`, `updated_at`) VALUES
(1, '8o0P-4EtSgHZ6-0qgp', 1, NULL, 'English', 'en', '1', '1', '1', '2023-08-29 03:54:59', '2023-08-29 03:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `mail_gateways`
--

CREATE TABLE `mail_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential` longtext COLLATE utf8mb4_unicode_ci,
  `default` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2023_06_11_101656_create_admins_table', 1),
(5, '2023_06_12_045319_create_languages_table', 1),
(6, '2023_06_12_045405_create_translations_table', 1),
(7, '2023_06_12_063444_create_settings_table', 1),
(8, '2023_06_14_055945_add_creator_to_admins_table', 1),
(9, '2023_06_15_053643_create_roles_table', 1),
(10, '2023_06_15_114919_add_role_id_to_admins_table', 1),
(11, '2023_06_15_124627_add_ltr_to_languages_table', 1),
(12, '2023_06_17_045913_add_name_column_to_admins_table', 1),
(13, '2023_06_25_110314_create_files_table', 1),
(14, '2023_06_26_223207_create_templates_table', 1),
(15, '2023_07_10_161751_create_mail_gateways_table', 1),
(16, '2023_07_12_111808_create_otps_table', 1),
(17, '2023_07_16_191644_create_visitors_table', 1),
(18, '2023_07_17_120854_create_frontends_table', 1),
(19, '2023_07_19_190840_create_seos_table', 1),
(20, '2023_07_25_134045_create_favourites_table', 1),
(21, '2023_07_28_185417_create_jobs_table', 1),
(22, '2023_08_01_130142_create_tickets_table', 1),
(23, '2023_08_01_130712_create_messages_table', 1),
(24, '2023_08_06_152247_create_notifications_table', 1),
(25, '2023_08_22_120059_create_staff_table', 1),
(26, '2023_08_29_070121_create_web_applications_table', 1),
(28, '2023_08_29_105951_create_services_table', 2),
(29, '2023_08_29_130157_create_portfolios_table', 3),
(30, '2023_08_29_134628_create_processes_table', 4),
(31, '2023_08_29_155501_create_teams_table', 5),
(32, '2023_08_29_162310_create_products_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notificationable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notificationable_id` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `is_read` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `otpable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otpable_id` bigint(20) UNSIGNED NOT NULL,
  `otp` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `uid`, `created_by`, `updated_by`, `title`, `short_description`, `url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'gKZI-7MQ6bmwa-bkH7', 1, 1, 'Accusantium aut aliq', 'In expedita fugiat in expedita autem minus iste aspernatur ipsa ut esse', '#', '1', '2023-08-29 07:41:32', '2023-08-29 09:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `processes`
--

CREATE TABLE `processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `processes`
--

INSERT INTO `processes` (`id`, `uid`, `created_by`, `updated_by`, `title`, `short_description`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, '4ZJI-rvbGMNyh-c4ye', 1, 1, 'Perspiciatis hic se', 'Aspernatur quam aspernatur dolore ullam dolor explicabo Odit nisi vero cillum tenetur nihil veniam', 'bi bi-arrow-bar-down', '1', '2023-08-29 08:38:27', '2023-08-29 08:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `uid`, `created_by`, `updated_by`, `name`, `permissions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pafj-6RNpgSDv-szM5', 1, NULL, 'Manager', '{\"role\": [\"view_role\", \"create_role\", \"update_role\", \"delete_role\"], \"staff\": [\"view_staff\", \"create_staff\", \"update_staff\", \"delete_staff\"], \"gateway\": [\"view_gateway\", \"update_gateway\"], \"frontend\": [\"view_frontend\", \"update_frontend\"], \"language\": [\"view_language\", \"translate_language\", \"create_language\", \"update_language\", \"delete_language\"], \"settings\": [\"view_settings\", \"update_settings\"], \"dashboard\": [\"view_dashboard\"], \"notification\": [\"view_notification\"], \"notification_template\": [\"view_template\", \"update_template\"]}', '1', '2023-08-29 03:54:59', '2023-08-29 03:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `identifier` text COLLATE utf8mb4_unicode_ci,
  `title` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `uid`, `updated_by`, `identifier`, `title`, `slug`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(16, '2mY6-iDf6aI3R-vtcd', 1, 'home', '{\"en\":\"home\",\"al\":null}', '/', '{\"en\":\"home\",\"al\":null}', '{\"en\":\"home\",\"al\":null}', '[\"adas\"]', '2023-07-20 08:51:20', '2023-08-03 12:50:16'),
(19, '4VAE-xgjmCOJS-Nn6g', NULL, 'contacts', '{\"en\":\"contacts\"}', 'contacts', '{\"en\":\"contacts\"}', '[\"contacts\"]', '[\"popular-links\"]', '2023-07-20 08:51:20', '2023-07-20 08:51:20'),
(25, '6JR1-jHeZ3kYf-uig1', NULL, 'feedback', '{\"en\":\"feedback\"}', 'feedback', '{\"en\":\"feedback\"}', '{\"en\":\"feedback\"}', '[\"feedback\"]', '2023-07-23 09:51:57', '2023-07-23 09:51:57'),
(26, '7Hwo-weI0z5Dm-P5tn', NULL, 'login', '{\"en\":\"login\"}', 'login', '{\"en\":\"login\"}', '{\"en\":\"login\"}', '[\"login\"]', '2023-07-23 11:38:16', '2023-07-23 11:38:16'),
(27, 'tDzL-1RYQDr88-eAx2', NULL, 'register', '{\"en\":\"register\"}', 'register', '{\"en\":\"register\"}', '{\"en\":\"register\"}', '[\"register\"]', '2023-07-23 11:38:16', '2023-07-23 11:38:16'),
(28, 'p3Ag-ofIdphNn-Lld7', 1, 'verification', '{\"en\":\"verification\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '', '{\"en\":\"auth_verification\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"auth_verification\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"auth_verification\"]', '2023-07-23 11:38:16', '2023-07-24 05:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `long_description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `parameters` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `uid`, `created_by`, `updated_by`, `title`, `short_description`, `long_description`, `status`, `parameters`, `created_at`, `updated_at`) VALUES
(3, '4ckd-ejVdRb1P-49Bv', 1, NULL, 'Web Application', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla placeat eius a impedit cum ducimus.', NULL, '1', '{\"APIBackend\": {\"field_label\": \"API & Backend\", \"service_name\": \"APIBackend\"}, \"CustomDevelopment\": {\"field_label\": \"Custom Development\", \"service_name\": \"CustomDevelopment\"}, \"E-commerceSolution\": {\"field_label\": \"E-commerce Solution\", \"service_name\": \"E-commerceSolution\"}, \"EnterpriseSolution\": {\"field_label\": \"Enterprise Solution\", \"service_name\": \"EnterpriseSolution\"}}', '2023-08-29 09:17:12', '2023-08-29 09:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `plugin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `uid`, `key`, `value`, `status`, `plugin`, `created_at`, `updated_at`) VALUES
(1, NULL, 'site_name', 'Kode Pixel', '1', '1', NULL, NULL),
(2, NULL, 'logo_icon', '#', '1', '1', NULL, NULL),
(3, NULL, 'site_logo', '64ed6e76e21731693281910.png', '1', '1', NULL, '2023-08-29 04:05:11'),
(4, NULL, 'user_site_logo', '64ed6e775657b1693281911.png', '1', '1', NULL, '2023-08-29 04:05:11'),
(5, NULL, 'site_favicon', '64ed6e775d5261693281911.png', '1', '1', NULL, '2023-08-29 04:05:11'),
(6, NULL, 'phone', '0xxxxxxxx', '1', '1', NULL, NULL),
(7, NULL, 'address', 'Something', '1', '1', NULL, NULL),
(8, NULL, 'email', 'quickpack@gmail.com', '1', '1', NULL, NULL),
(9, NULL, 'user_authentication', '{\"registration\":\"1\",\"login\":\"1\",\"login_with\":[\"user_name\",\"email\",\"phone\"]}', '1', '1', NULL, NULL),
(10, NULL, 'login_with', '[\"user_name\",\"email\",\"phone\"]', '1', '1', NULL, NULL),
(11, NULL, 'default_sms_template', 'hi {{name}}, {{message}}', '1', '1', NULL, NULL),
(12, NULL, 'default_mail_template', 'hi {{name}}, {{message}}', '1', '1', NULL, NULL),
(13, NULL, 'two_factor_auth', '0', '1', '1', NULL, NULL),
(14, NULL, 'two_factor_auth_with', '{\"google\":\"1\",\"sms\":\"0\",\"mail\":\"0\"}', '1', '1', NULL, NULL),
(15, NULL, 'sms_otp_verification', '0', '1', '1', NULL, NULL),
(16, NULL, 'registration_otp_verification', '0', '1', '1', NULL, NULL),
(17, NULL, 'sms_notifications', '0', '1', '1', NULL, NULL),
(18, NULL, 'email_verification', '0', '1', '1', NULL, NULL),
(19, NULL, 'email_notifications', '0', '1', '1', NULL, NULL),
(20, NULL, 'slack_notifications', '0', '1', '1', NULL, NULL),
(21, NULL, 'browser_notifications', '0', '1', '1', NULL, NULL),
(22, NULL, 'slack_channel', '#', '1', '1', NULL, NULL),
(23, NULL, 'slack_web_hook_url', '#', '1', '1', NULL, NULL),
(24, NULL, 'time_zone', '\'Asia/Dhaka\'', '1', '1', NULL, NULL),
(25, NULL, 'app_debug', '0', '1', '1', NULL, NULL),
(26, NULL, 'maintenance_mode', '0', '1', '1', NULL, NULL),
(27, NULL, 'pagination_number', '10', '1', '1', NULL, NULL),
(28, NULL, 'chunk_value', '5', '1', '1', NULL, NULL),
(29, NULL, 'copy_right_text', '2023', '1', '1', NULL, NULL),
(30, NULL, 'country', 'United States', '1', '1', NULL, NULL),
(31, NULL, 'currency', 'AFN', '1', '1', NULL, NULL),
(32, NULL, 'currency_symbol', '$', '1', '1', NULL, NULL),
(33, NULL, 'ticket_settings', '[{\"labels\":\"Subject\",\"name\":\"subject\",\"placeholder\":\"Subject\",\"type\":\"text\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"labels\":\"Message\",\"name\":\"message\",\"placeholder\":\"message\",\"type\":\"textarea\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"labels\":\"Attachments\",\"name\":\"attachment\",\"placeholder\":\"You Can Upload Multiple File Here\",\"type\":\"file\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"1\"}]', '1', '1', NULL, NULL),
(34, NULL, 'user_registration_settings', '[{\"order\":1,\"labels\":\"Name\",\"name\":\"name\",\"placeholder\":\"Name\",\"type\":\"text\",\"width\":\"50\",\"status\":\"1\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"order\":2,\"labels\":\"Email\",\"name\":\"email\",\"placeholder\":\"Email\",\"type\":\"email\",\"width\":\"50\",\"required\":\"1\",\"default\":\"1\",\"status\":\"1\",\"multiple\":\"0\"},{\"order\":3,\"labels\":\"Username\",\"name\":\"user_name\",\"placeholder\":\"Enter Your User Name\",\"type\":\"text\",\"width\":\"50\",\"status\":\"1\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"order\":7,\"labels\":\"phone\",\"name\":\"phone\",\"placeholder\":\"Enter Your Phone Number\",\"type\":\"text\",\"width\":\"50\",\"status\":\"1\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"order\":6,\"labels\":\"Country Code\",\"name\":\"country_code\",\"placeholder\":\"Enter Your Phone Number\",\"type\":\"select\",\"width\":\"50\",\"status\":\"1\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"order\":8,\"labels\":\"Password\",\"name\":\"password\",\"placeholder\":\"Enter Password\",\"type\":\"password\",\"width\":\"50\",\"status\":\"1\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"},{\"order\":9,\"labels\":\"Confirm Password\",\"name\":\"password_confirmation\",\"placeholder\":\"Enter Confirm password\",\"type\":\"password\",\"width\":\"50\",\"status\":\"1\",\"required\":\"1\",\"default\":\"1\",\"multiple\":\"0\"}]', '1', '1', NULL, NULL),
(35, NULL, 'same_site_name', '1', '1', '1', NULL, '2023-08-29 04:38:42'),
(36, NULL, 'user_site_name', 'Demo Name', '1', '1', NULL, NULL),
(37, NULL, 'google_recaptcha', '{\"key\":\"6Lc5PpImAAAAABM-m4EgWw8vGEb7Tqq5bMOSI1Ot\",\"secret_key\":\"6Lc5PpImAAAAACdUh5Hth8NXRluA04C-kt4Xdbw7\",\"status\":\"0\"}', '1', '1', NULL, NULL),
(38, NULL, 'strong_password', '0', '1', '1', NULL, NULL),
(39, NULL, 'captcha', '0', '1', '1', NULL, NULL),
(40, NULL, 'vistors', '500', '1', '1', NULL, NULL),
(41, NULL, 'default_recaptcha', '0', '1', '1', NULL, NULL),
(42, NULL, 'captcha_with_login', '1', '1', '1', NULL, NULL),
(43, NULL, 'captcha_with_registration', '1', '1', '1', NULL, NULL),
(44, NULL, 'social_login', '0', '1', '1', NULL, NULL),
(45, NULL, 'social_login_with', '{\"google_oauth\":{\"client_id\":\"580301070453-job03fms4l7hrlnobt7nr5lbsk9bvoq9.apps.googleusercontent.com\",\"client_secret\":\"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\",\"status\":\"1\"},\"facebook_oauth\":{\"client_id\":\"5604901016291309\",\"client_secret\":\"41c62bf15c8189171196ffde1d2a6848\",\"status\":\"1\"}}', '1', '1', NULL, NULL),
(46, NULL, 'google_map', '{\"key\":\"#\"}', '1', '1', NULL, NULL),
(47, NULL, 'storage', 'local', '1', '1', NULL, NULL),
(48, NULL, 'mime_types', '[\"png\"]', '1', '1', NULL, NULL),
(49, NULL, 'max_file_size', '20000', '1', '1', NULL, NULL),
(50, NULL, 'max_file_upload', '4', '1', '1', NULL, NULL),
(51, NULL, 'aws_s3', '{\"s3_key\":\"#\",\"s3_secret\":\"#\",\"s3_region\":\"#\",\"s3_bucket\":\"#\"}', '1', '1', NULL, NULL),
(52, NULL, 'ftp', '{\"host\":\"#\",\"port\":\"#\",\"user_name\":\"#\",\"password\":\"#\",\"root\":\"\\/\"}', '1', '1', NULL, NULL),
(53, NULL, 'pusher_settings', '{\"app_id\":\"#\",\"app_key\":\"#\",\"app_secret\":\"#\",\"app_cluster\":\"#\",\"chanel\":\"#\",\"event\":\"#\"}', '1', '1', NULL, NULL),
(54, NULL, 'wasabi', '{\"driver\":\"#\",\"key\":\"#\",\"secret\":\"#\",\"region\":\"#\",\"bucket\":\"#\",\"endpoint\":\"#\"}', '1', '1', NULL, NULL),
(55, NULL, 'database_notifications', '0', '1', '1', NULL, NULL),
(56, NULL, 'cookie', '0', '1', '1', NULL, NULL),
(57, NULL, 'cookie_text', 'demo cookie_text', '1', '1', NULL, NULL),
(58, NULL, 'google_map_key', '#', '1', '1', NULL, NULL),
(59, NULL, 'geo_location', 'map_base', '1', '1', NULL, NULL),
(60, NULL, 'sentry_dns', '#', '1', '1', NULL, NULL),
(61, NULL, 'loggin_attempt_validation', '0', '1', '1', NULL, NULL),
(62, NULL, 'max_login_attemtps', '5', '1', '1', NULL, NULL),
(63, NULL, 'otp_expired_status', '0', '1', '1', NULL, NULL),
(64, NULL, 'otp_expired_in', '2', '1', '1', NULL, NULL),
(65, NULL, 'api_route_rate_limit', '1000', '1', '1', NULL, NULL),
(66, NULL, 'web_route_rate_limit', '1000', '1', '1', NULL, NULL),
(67, NULL, 'primary_color', '#673ab7', '1', '1', NULL, NULL),
(68, NULL, 'secondary_color', '#ba6cff', '1', '1', NULL, NULL),
(69, NULL, 'text_primary', '#26152e', '1', '1', NULL, NULL),
(70, NULL, 'text_secondary', '#777777', '1', '1', NULL, NULL),
(71, NULL, 'dark_mood', '0', '1', '1', NULL, NULL),
(72, NULL, 'site_description', 'demo description', '1', '1', NULL, NULL),
(73, NULL, 'twiter_username', 'username', '1', '1', NULL, NULL),
(74, NULL, 'google_analytics_tracking_id', 'No Data Found !!', '1', '1', NULL, NULL),
(75, NULL, 'show_pages_in_header', '1', '1', '1', NULL, NULL),
(76, NULL, 'breadcrumbs', '1', '1', '1', NULL, NULL),
(77, NULL, 'pre_loader', '1', '1', '1', NULL, NULL),
(78, NULL, 'ip_base_view_count', '0', '1', '1', NULL, NULL),
(79, NULL, 'social_sharing', '1', '1', '1', NULL, NULL),
(80, NULL, 'expired_data_delete', '0', '1', '1', NULL, NULL),
(81, NULL, 'expired_data_delete_after', '10', '1', '1', NULL, NULL),
(82, NULL, 'live_chat', '1', '1', '1', NULL, NULL),
(83, NULL, 'socket_port', '3000', '1', '1', NULL, NULL),
(84, NULL, 'socket_ip', '3000', '1', '1', NULL, NULL),
(85, NULL, 'google_adsense_publisher_id', 'No Data Found !!', '1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notification_settings` longtext COLLATE utf8mb4_unicode_ci,
  `permissions` longtext COLLATE utf8mb4_unicode_ci,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `super_admin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `uid`, `created_by`, `updated_by`, `name`, `designation`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sqeU-qkeTe7If-0Bf6', 1, NULL, 'Alexander', 'UI/UX', '1', '2023-08-29 10:15:53', '2023-08-29 10:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `sms_body` longtext COLLATE utf8mb4_unicode_ci,
  `sort_code` json DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_data` text COLLATE utf8mb4_unicode_ci,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Open: 1, Pending: 2, Processing: 3, Closed: 4 ,Solved: 5 ,On-Hold: 6',
  `priority` tinyint(4) DEFAULT NULL COMMENT 'Urgent: 1, High: 2, Low: 3, Medium: 4',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `uid`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Pt6L-cLKxFSl9-5Q77', 'en', 'login', 'Login', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(2, '4YKO-IOlbwvDH-n5E1', 'en', 'usernameemail', 'Username/Email', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(3, 'ZujH-svNqqcPN-ANU7', 'en', 'enter_username__or_email', 'Enter Username  or Email', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(4, 'wzhn-9pnXvPgU-N714', 'en', 'password', 'Password', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(5, '1M3U-EL8ppsbb-i9cm', 'en', 'remember_me', 'Remember me', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(6, 'Bb6K-4WzGiJNg-gi21', 'en', 'forgot_password', 'Forgot password', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(7, 'iftt-BtJ5PNGC-rZS8', 'en', 'sign_in', 'Sign In', '2023-08-29 03:57:25', '2023-08-29 03:57:25'),
(8, 'gy8w-8Y4iKhun-ROO7', 'en', 'server_error_please_reload_then_try_again_', 'Server Error!! Please Reload Then Try Again ', '2023-08-29 03:57:27', '2023-08-29 03:57:27'),
(9, '6cHX-jTMlAI7R-kPGd', 'en', '_feild_is_required', ' Feild Is Required', '2023-08-29 03:57:27', '2023-08-29 03:57:27'),
(10, 'y7ui-KqpHU3Td-FyR4', 'en', 'password_feild_is_required', 'Password Feild Is Required', '2023-08-29 03:57:27', '2023-08-29 03:57:27'),
(11, 'cU4X-phP4stqK-XwD9', 'en', 'successfully_loggedin', 'Successfully Loggedin', '2023-08-29 03:57:28', '2023-08-29 03:57:28'),
(12, 'KJSv-VopdhmF4-8S29', 'en', 'dashboard', 'Dashboard', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(13, 'P0jG-Uaupn43V-GAs0', 'en', 'last_cron_run', 'Last Cron Run', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(14, 'hCan-vyMIDtbO-P034', 'en', 'na', 'N/A', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(15, 'dq44-H0Z9ob5C-F3w1', 'en', 'total_visitors', 'Total Visitors', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(16, '7Tzw-QomfsdHW-Cz1f', 'en', 'visitors_by_month_in', 'Visitors By Month In', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(17, '7p4d-A1RhZU60-OOy4', 'en', 'visitors', 'Visitors', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(18, '3Zcu-fO5b049B-aiXI', 'en', 'welcome', 'Welcome', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(19, 'nMcL-dn6NhiNl-sEb7', 'en', 'setting', 'Setting', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(20, 'xN2A-2qQgy1Cb-AIe4', 'en', 'do_you_really_want_to_sign_out__', 'Do You Really Want To Sign out ?? ', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(21, '4xDt-BX1fAHlV-EWf9', 'en', 'logout', 'logout', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(22, '5oIP-zvMFMp2e-TcYa', 'en', 'are_you_sure', 'Are You Sure!!', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(23, 'pDAn-pXieTqHN-0ag4', 'en', 'no', 'No', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(24, '4g5W-qXBnzgZV-vTNJ', 'en', 'yes', 'Yes', '2023-08-29 03:59:03', '2023-08-29 03:59:03'),
(25, 'TyjC-2hGqKYys-AGW6', 'en', 'home', 'Home', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(26, '4ZAE-FJLr4Qta-cS93', 'en', 'manage_staff', 'Manage Staff', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(27, '8JmF-k3Fdp1nj-z5Ke', 'en', 'staffs__permissions', 'Staffs & Permissions', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(28, 'Vcmh-1qnGoKrv-D7o4', 'en', 'roles__permissions', 'Roles & Permissions', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(29, 'mq6P-VE9By6Ee-ih19', 'en', 'staffs', 'Staffs', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(30, '99Ju-HWtC7Ftx-3HS8', 'en', 'support_tickets', 'Support Tickets', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(31, '4l58-2vm6XQ8M-7FHQ', 'en', 'website_control', 'Website Control', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(32, '9nML-RzSC0Vv6-sAL0', 'en', 'manage_frontend', 'Manage Frontend', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(33, '6tqp-ZBnac3BT-Ev2R', 'en', 'frontend_section', 'Frontend Section', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(34, 'eEiH-gEHjhyGx-kaZ3', 'en', 'seo', 'Seo', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(35, '2awz-iUDxelO4-4kfZ', 'en', 'notifications_template', 'Notifications Template', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(36, '7UKd-ZOCnbVT7-gIQG', 'en', 'templates', 'Templates', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(37, '7YSo-yIUeRs2Z-xYWA', 'en', 'notification_template', 'Notification Template', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(38, 'WSM4-eT9BgCaS-vX57', 'en', 'global_template', 'Global Template', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(39, '5kMh-6DdBCiDN-3pU0', 'en', 'mail__sms_settings', 'Mail & Sms Settings', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(40, '04gl-ACLfHNhX-7UZb', 'en', 'mail_gateway', 'Mail Gateway', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(41, 'IdHO-qxyB6aTW-D2u9', 'en', 'language__localizations', 'Language / Localizations', '2023-08-29 03:59:04', '2023-08-29 03:59:04'),
(42, '2AVp-EmlyckiJ-3jPo', 'en', 'language', 'Language', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(43, 'fzh4-K1yDw303-yOB5', 'en', 'adminstrator__business', 'Adminstrator / Business', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(44, '6tPL-5hKSoPNU-s9Oc', 'en', 'applications_settings', 'Applications Settings', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(45, '4Abe-j5hM0OZE-U1Fg', 'en', 'app_settings', 'App Settings', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(46, '13Ag-pc1alvJO-p9gw', 'en', 'system_preferences', 'System Preferences', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(47, '5bmy-VsYUXF3V-uVRN', 'en', 'softwae_info', 'Softwae Info', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(48, '6V9l-43VXuqK9-7MrR', 'en', 'software_info', 'Software Info', '2023-08-29 03:59:05', '2023-08-29 03:59:05'),
(49, '57sC-Nwsj0Thv-ZiOG', 'en', 'delete', 'Delete', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(50, 'l146-S2TQBpxn-sSq6', 'en', 'active', 'Active', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(51, 'SIvn-WWu8cJDN-Wch8', 'en', 'inactive', 'Inactive', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(52, '2ljc-8UvKhz9A-xuvl', 'en', 'add_new', 'Add New', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(53, '4UUH-6hZiwEYf-x6FK', 'en', 'show_archive_role', 'Show Archive Role', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(54, '73fZ-n3ULazCQ-DXDv', 'en', 'search_by_name', 'Search By Name', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(55, '6UQ4-Fn0g3wyj-dIYg', 'en', 'name', 'Name', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(56, 'Yur0-wGjzpmhr-mP90', 'en', 'status', 'Status', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(57, 'RcTK-BrQBXZIV-v9c7', 'en', 'created_by', 'Created By', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(58, '29Gn-U6VQSgJR-lzc7', 'en', 'updated_by', 'Updated By', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(59, '9DrS-W2fyjPeJ-qUv0', 'en', 'options', 'Options', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(60, '5mFv-Rbj3Gpow-iRSv', 'en', 'action', 'Action', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(61, 'VlSU-X3bPjsa3-EM97', 'en', 'do_you_want_to_delete_these_records', 'Do You Want To Delete These Records??', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(62, '6pCe-EKaVqRDv-23U5', 'en', 'manage_roles', 'Manage Roles', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(63, '9YEY-qibOYQ71-5dlY', 'en', 'roles', 'Roles', '2023-08-29 04:00:28', '2023-08-29 04:00:28'),
(64, 'ONjf-aOsQjnZV-jm74', 'en', 'email_notification', 'Email Notification', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(65, 'uOwr-WhkRm0Lw-OKC3', 'en', 'when_enabled_this_module_sends_necessary_emails_to_users_if_disabled_no_emails_will_be_sent_prior_to_disabling_ensure_there_are_no_pending_emails', 'When enabled, this module sends necessary emails to users. If disabled, no emails will be sent. Prior to disabling, ensure there are no pending emails.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(66, '3miy-CrTJ91l3-jW1V', 'en', 'database_notifications', 'Database Notifications', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(67, '3j6u-Lu3fcAyp-laH3', 'en', 'enable_this_module_for_notifications_on_database_events_eg_new_ticket_generation_new_messages_to_users_agents_and_administrators', 'Enable this module for notifications on database events (e.g., New Ticket Generation, New Messages) to users, agents, and administrators.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(68, 'xhWI-X2q6RjQ6-oPH6', 'en', 'cookie_activation', 'Cookie Activation', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(69, '402D-YjECDz2X-WCEg', 'en', 'enabling_this_module_activates_the_accept_cookie_prompt_allowing_personalized_user_tracking_with_small_files_on_their_computer', 'Enabling this module activates the Accept Cookie prompt, allowing personalized user tracking with small files on their computer', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(70, '6AhS-a1fRTecu-upnY', 'en', 'app_debug', 'App Debug', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(71, 'VEIR-ALPQGgKZ-mBp1', 'en', 'enabling_this_module_activates_system_debugging_mode_aiding_in_troubleshooting_by_providing_detailed_error_messages_to_identify_code_issues', 'Enabling this module activates system debugging mode, aiding in troubleshooting by providing detailed error messages to identify code issues.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(72, 'G3xJ-cRNy3UpP-hGc4', 'en', 'user_registration', 'User Registration', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(73, 'KDdj-84kaOFWb-1383', 'en', 'enabling_the_module_activates_the_user_register_module_indicating_their_interdependency_for_proper_functioning', 'Enabling the module activates the User Register Module, indicating their interdependency for proper functioning.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(74, '9A0n-ogKKVKQp-x20F', 'en', 'social_auth', 'Social Auth', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(75, '5jjg-SCrRtKTF-EmvW', 'en', 'it_allows_users_to_sign_in_or_register_using_their_social_media_accounts', 'It allows users to sign in or register using their social media accounts', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(76, '2v7Z-1yX1MVJc-f42e', 'en', 'email_verfications', 'Email Verfications', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(77, 'jKiA-XtnZ2UzL-Gfp3', 'en', 'when_enabled_this_module_prompts_users_to_verify_their_email_addresses_during_registration_by_clicking_a_link_or_entering_a_code_sent_to_their_email', 'When enabled, this module prompts users to verify their email addresses during registration by clicking a link or entering a code sent to their email.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(78, 'oqTj-a3QrRagE-tCt7', 'en', 'article_review_feature', 'Article Review Feature', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(79, '6isS-rAhhnz3l-dj0I', 'en', 'this_feature_allows_users_to_provide_reviews_and_feedback_on__articles_they_have_accessed_enhancing_user_engagement_and_content_assessment', 'This feature allows users to provide reviews and feedback on  articles they have accessed, enhancing user engagement and content assessment.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(80, '39rQ-dK15c3JH-x8RY', 'en', 'view_count_by_ip', 'View Count By Ip', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(81, 'mWpl-MZQpF82s-6en5', 'en', 'tracks_the_number_of_views_from_unique_ip_addresses_providing_valuable_insights_into_user_engagement_and_traffic_patterns_on_your_website', 'Tracks the number of views from unique IP addresses, providing valuable insights into user engagement and traffic patterns on your website.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(82, '9iAh-fyMfpY7i-fhkY', 'en', 'social_sharing', 'Social Sharing', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(83, '5ViL-ZUJcSk5o-5nsb', 'en', 'enables_users_to_easily_share_content_from_your_website_on_various_social_media_platforms_boosting_visibility_and_user_engagement', 'Enables users to easily share content from your website on various social media platforms, boosting visibility and user engagement.', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(84, '6XkL-qM76wIwL-vDh7', 'en', 'show_pages_in_header', 'Show Pages In Header', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(85, '5rGh-rEuoIqb0-im13', 'en', 'enables_a_pages_section_inside_the_website_header', 'Enables a \'Pages\' section inside the website header', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(86, '70ub-VqnoTsXG-HMzN', 'en', 'expired_subscription_delete', 'Expired Subscription Delete', '2023-08-29 04:00:50', '2023-08-29 04:00:50'),
(87, '7S8c-V8jPco9U-KHO9', 'en', 'live_chat', 'Live Chat', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(88, '90un-H2uc179c-OuT8', 'en', 'this_module__enable_user__admin_live_chat', 'This Module  Enable User & Admin Live Chat', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(89, '5oiq-svABseOx-2LAx', 'en', 'slack_notification', 'Slack Notification', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(90, '607i-KPBG5erY-FWcs', 'en', 'this_module__enable_slack_notifications', 'This Module  Enable Slack Notifications', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(91, '0YsE-1ycEcwjG-Ayg6', 'en', 'browser_notification', 'Browser Notification', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(92, '8StN-NM7Ihvp0-zLWv', 'en', 'this_module__enable_browser_notifications', 'This Module  Enable Browser Notifications', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(93, 'l1vm-I7I6kYNi-aUT9', 'en', 'system_configuration', 'System Configuration', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(94, 'UJCe-DyaFHGup-oqy6', 'en', 'configuration', 'Configuration', '2023-08-29 04:00:51', '2023-08-29 04:00:51'),
(95, '6xDf-6mGLoioc-3Sa3', 'en', 'document_root_folder', 'Document Root Folder', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(96, '0IFw-bnNS4TGl-XCBp', 'en', 'system_laravel_version', 'System Laravel Version', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(97, 'BHn2-rxu7XcVt-sM13', 'en', 'php_version', 'PHP Version', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(98, 'k10Q-p1MzfvEG-4Jc7', 'en', 'ip_address', 'IP Address', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(99, '1acU-E4PIN3Uu-WpdZ', 'en', 'system_server_host', 'System Server host', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(100, '8NCW-thylhkzT-eS7m', 'en', 'database_port_number', 'Database Port Number', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(101, '63Y2-YM4eqnHg-U0k8', 'en', 'system_information', 'System Information', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(102, '4GdG-5Ki4Hht5-gIdT', 'en', 'systeminfo', 'SystemInfo', '2023-08-29 04:00:53', '2023-08-29 04:00:53'),
(103, '1rFb-PVeOChPZ-eh9v', 'en', 'basic_settings', 'Basic Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(104, 'LBlf-mpLFym7N-kX83', 'en', 'logging', 'Logging', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(105, '5yZQ-YZkvR4Br-xy8p', 'en', 'rate_limiting', 'Rate Limiting', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(106, '20Nc-yj2JHkJI-lRpa', 'en', 'theme_settings', 'Theme Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(107, '4hiK-t4M1ctce-9UTq', 'en', 'ticket_settings', 'Ticket Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(108, '6B6L-tsJPI0UK-02Ra', 'en', 'storage_settings', 'Storage Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(109, 'fHmq-hmYlhyth-vkE7', 'en', 'slack_settings', 'Slack Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(110, 'sTYQ-J9Afjpej-sgl3', 'en', 'pusher_settings', 'Pusher Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(111, 'Z5co-sGercAJW-PEe8', 'en', 'recaptcha_settings', 'Recaptcha Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(112, 'ZfaH-LIqn7zRk-xcB2', 'en', 'social_login_settings', 'Social Login Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(113, 'FfBp-6DAog9EE-T780', 'en', 'registration_settings', 'Registration Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(114, '64hk-RC3KImdL-ATs9', 'en', 'login_settings', 'Login Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(115, '3MEo-tPGLYcqx-rucM', 'en', 'logo_settings', 'Logo Settings', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(116, '3rwb-PCiGII60-6zJC', 'en', 'basic_information', 'Basic Information', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(117, 'BFgg-8yDW2JTU-AL59', 'en', 'setup_cron_jobs', 'Setup Cron Jobs', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(118, 'iUlK-Xqr6Msyy-4lO4', 'en', 'use_same_site_name', 'Use Same Site Name', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(119, '0smI-dIlhdUMl-k6F7', 'en', 'site_name', 'Site Name', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(120, '8fc0-89jozdUk-dEG3', 'en', 'user_site_name', 'User Site Name', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(121, '00KL-ikHiWr3r-QdLp', 'en', 'phone', 'Phone', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(122, '7kLQ-vZMO6tJb-Chp4', 'en', 'email', 'Email', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(123, 'WbdC-xO8Ks3oK-TgQ0', 'en', 'address', 'Address', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(124, '912Y-iRdeTrUZ-guj0', 'en', 'twitter_username', 'Twitter Username', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(125, 'eodP-0aXB1fpQ-u7m5', 'en', 'time_zone', 'Time Zone', '2023-08-29 04:00:57', '2023-08-29 04:00:57'),
(126, '8sny-NnTHdeCF-emyL', 'en', 'country', 'Country', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(127, '2tnU-GjTiGfZe-R0o3', 'en', 'currency', 'Currency', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(128, '0ixu-uTrIp4zV-2ge5', 'en', 'currency_symbol', 'Currency Symbol', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(129, '77CD-R9ipByhZ-Hvu1', 'en', 'copy_right_text', 'Copy Right Text', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(130, '6mMR-eYCxDp8v-MAfF', 'en', 'data_per_page', 'Data Per Page', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(131, 'C77f-egxHYWJH-7ph0', 'en', 'web_visitors', 'Web Visitors', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(132, '7qN8-SDVbTpJI-DnXZ', 'en', 'cookie_text', 'Cookie Text', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(133, 'xXXy-XWf7nFIs-X7j2', 'en', 'enter_cookie_text', 'Enter Cookie Text', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(134, '07P1-og7D3rlH-3UFM', 'en', 'google_adsense_publisher_id', 'Google Adsense Publisher Id', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(135, '9wL4-h5SqGkOu-91b7', 'en', 'enter_id', 'Enter Id', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(136, 'tpR3-zRHwrWFu-GXd8', 'en', 'google_analytics_tracking_id', 'Google Analytics Tracking Id', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(137, '5zTX-nJcbBibX-HAT8', 'en', 'chunk_value', 'Chunk Value', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(138, 'GMXt-ZnatwpZH-liy5', 'en', 'site_description', 'Site Description', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(139, '8hm9-zwKxQr9u-wK51', 'en', 'submit', 'Submit', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(140, 'TenU-ZeYwoz9r-Pck2', 'en', 'sentry_dns', 'Sentry Dns', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(141, 'im57-SR1LcbS4-vkH3', 'en', 'information', 'Information', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(142, 'lZaF-8MB4C7Uq-gnz3', 'en', 'sentry', 'Sentry', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(143, '7adA-agsBBHUp-HiQb', 'en', 'rate_limitting', 'Rate Limitting', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(144, 'aMBc-lYNRWdei-7Kh8', 'en', 'api_hit_limit', 'Api Hit limit', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(145, '8CyN-lXQlMVy3-j7Q1', 'en', 'per_minute', 'Per Minute', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(146, '9XOB-iwavxgUF-kuDX', 'en', 'web_route_limit', 'Web Route limit', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(147, '3h36-Ne3VD91O-FyQN', 'en', 'frontend_themecolor_settings', 'Frontend Theme/Color Settings', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(148, '5QMx-u1T72kvI-ZBq7', 'en', 'primary_color', 'Primary Color', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(149, 'xBCN-FIuo5A51-ifU4', 'en', 'secondary_color', 'Secondary Color', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(150, '2hg5-NhylZnsk-1VNB', 'en', 'text_primary_color', 'Text Primary Color', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(151, 'i4ED-fh1od8aw-0e49', 'en', 'text_secondary_color', 'Text Secondary Color', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(152, '9jIJ-s1TKG9Rp-4msm', 'en', 'add_more', 'Add More', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(153, '0LEa-TiGj5Oik-oW6X', 'en', 'labels', 'Labels', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(154, '5ndk-nDgGVACB-DMAz', 'en', 'type', 'Type', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(155, '9pfJ-vPzmAL0H-wJmK', 'en', 'mandatoryrequired', 'Mandatory/Required', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(156, '3cBb-3QgRZMj4-3n0K', 'en', 'placeholder', 'Placeholder', '2023-08-29 04:00:58', '2023-08-29 04:00:58'),
(157, '6YoE-LqTIH8x8-fYbg', 'en', 'label', 'Label', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(158, '2M3J-CfvpVxFf-XGTx', 'en', 'required', 'Required', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(159, 'pwid-7XDTdfW5-hkS4', 'en', 'option', 'Option', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(160, '22KS-Dh8Qvgnt-elUN', 'en', 'local', 'local', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(161, '4MCR-w26mbqFD-N78P', 'en', 'aws_s3', 'Aws S3', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(162, '04K7-ySHIOP8Q-gnv7', 'en', 'ftp', 'Ftp', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(163, '0xP2-POHtbXQb-MWii', 'en', 'wasabi', 'Wasabi', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(164, '01qe-zrEGgJ1X-NsP4', 'en', 'local_storage_settings', 'Local Storage Settings', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(165, '5gIj-Z1tpMAr0-XzBf', 'en', 'supported_file_types', 'Supported File Types', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(166, '0nHy-6FRPWjwJ-WS0X', 'en', 'maximum_file_upload', 'Maximum File Upload', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(167, '0qjJ-vbu5jEP6-r7p7', 'en', 'you_can_not_upload_more_than_that_at_a_time_', 'You Can Not Upload More Than That At a Time ', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(168, '3SGb-84PsjLje-re5x', 'en', 'max_file_upload_size', 'Max File Upload size', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(169, '6g86-cz268Rym-Uxwm', 'en', 'in_kilobyte', 'In Kilobyte', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(170, '5Bev-hmBSSevJ-eGWV', 'en', 's3_storage_settings', 'S3 Storage Settings', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(171, '9OEa-mlFtYVWo-iSwv', 'en', 'ftp_settings', 'Ftp Settings', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(172, 'fxPD-v6SYWmJR-7af7', 'en', 'wasabi_settings', 'Wasabi Settings', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(173, '8c6x-1OFXhsHb-2WvB', 'en', 'slack_configuration', 'Slack Configuration', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(174, '0ewh-hz9v7GLz-tz6J', 'en', 'slack_channel', 'Slack Channel', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(175, '9HYk-d9tZIsXs-OXai', 'en', 'optional', 'optional', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(176, '31sp-nmQ20rl6-b5Xy', 'en', 'slack_web_hook_url', 'Slack Web Hook Url', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(177, 'A9qp-UUgjzP12-FMY7', 'en', 'pusher_configuration', 'Pusher Configuration', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(178, '7Gq8-DciCQ9cb-eTB1', 'en', 'use_default_captcha', 'Use Default Captcha', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(179, 'JEdm-MHzn16Tf-oZy5', 'en', 'captcha_with_registration', 'Captcha With Registration', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(180, 'VfR2-3CzEDsCO-lBF3', 'en', 'captcha_with_login', 'Captcha With Login', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(181, 'N6c3-79OYPh20-MnO4', 'en', 'google_recaptcha_v3', 'Google Recaptcha (V3)', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(182, 'dE8n-ww72A0pQ-2518', 'en', 'socail_login_setup', 'Socail Login Setup', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(183, '5nh2-13eMJZQH-Qz6g', 'en', 'callback_url', 'Callback Url', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(184, '596P-xNFeLjGZ-HJjp', 'en', 'register_form_settings', 'Register Form Settings', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(185, '4ElH-SXsKOus4-6q51', 'en', 'email_verification', 'Email Verification', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(186, '0WEi-MUMasBvN-St2F', 'en', 'order', 'Order', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(187, '50rd-PkyzhWe3-GAzg', 'en', 'width', 'Width', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(188, 'cFfC-wPjYSWs5-fyX1', 'en', 'user_login_settings', 'User Login Settings', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(189, '53el-q1isy0G6-Udnb', 'en', 'max_login_attempt_validation', 'Max Login Attempt Validation', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(190, '7J0Q-bVBuiSTM-O2k7', 'en', 'maximum_login_attempts', 'Maximum Login Attempts', '2023-08-29 04:00:59', '2023-08-29 04:00:59'),
(191, 'Zr1f-xI4IPZJw-8hg3', 'en', 'login_with', 'Login With', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(192, '3T9z-AGjNR9Q5-Kv0i', 'en', 'sms_otp_verification', 'Sms Otp Verification', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(193, '2YB2-XdsIEUN3-hqQ0', 'en', 'site_logo', 'Site Logo', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(194, 'JF2F-yamrMsa7-neb3', 'en', 'frontend_logo', 'Frontend Logo', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(195, 'Civl-kmWpvLww-iHv0', 'en', 'favicon', 'Favicon', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(196, 't3EO-A7lwIMSo-1E09', 'en', 'cron_job_setup', 'Cron Job Setup', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(197, 'wbfE-XULqaCPP-m3s8', 'en', 'queue', 'Queue', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(198, '9UIO-3CAr2jEi-bkw0', 'en', 'set_time_for_1_minute', 'Set time for 1 minute', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(199, '8Q9P-EP2LkXG7-Vlf3', 'en', 'cron_job_', 'Cron Job ', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(200, '24uw-PeAF42iR-o4a3', 'en', 'close', 'Close', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(201, '0Ptn-37IrKHfD-4NGS', 'en', 'enter_label', 'Enter Label', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(202, 'Kfmq-a67LtisV-zgM5', 'en', 'enter_placeholder', 'Enter Placeholder', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(203, 'bwq0-MYdTnSaf-mNw6', 'en', 'select_option', 'Select Option', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(204, '9RxG-S1wce3WX-8x2G', 'en', 'successfully_reseted_to_base_color', 'Successfully Reseted To Base Color', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(205, 'Usaf-DyLhxvqc-9ZZ8', 'en', 'settings', 'Settings', '2023-08-29 04:01:00', '2023-08-29 04:01:00'),
(206, '7zNi-HeXl1Em0-qIPv', 'en', 'updated_successfully', 'Updated Successfully', '2023-08-29 04:01:10', '2023-08-29 04:01:10'),
(207, '2ktA-ffIrVwoA-YbfP', 'en', 'feild_is_required', 'Feild is Required', '2023-08-29 04:01:10', '2023-08-29 04:01:10'),
(208, '0Dk5-MMFT6yew-u61q', 'en', 'file_uploaded_successfully', 'File Uploaded Successfully', '2023-08-29 04:03:55', '2023-08-29 04:03:55'),
(209, '42NB-5pvKPkii-6vu3', 'en', 'frontend_section_list', 'Frontend Section List', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(210, '1cdz-QtwFoHBa-KHRT', 'en', 'primary_heading', 'Primary heading', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(211, '5dj3-xv2k2bxp-8nBT', 'en', 'type_here', 'Type Here', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(212, 'g0rj-g4uFLHnL-YTO6', 'en', 'primary_short_description', 'Primary short description', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(213, '3mLU-slmAF7Dg-6BY5', 'en', 'secondary_heading', 'Secondary heading', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(214, '2Bst-MXQgOvA1-AOEX', 'en', 'secondary_short_description', 'Secondary short description', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(215, 'cPz0-1r8xHgKe-cRs0', 'en', 'banner_image', 'Banner image', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(216, '0Ln0-NO5wmsmk-nR5i', 'en', 'phone_number', 'Phone number', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(217, '2NUr-jswDBaSf-jqs1', 'en', 'select_status', 'Select Status', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(218, '1o1d-mi5zo1YA-Xryo', 'en', 'frontends', 'Frontends', '2023-08-29 04:06:31', '2023-08-29 04:06:31'),
(219, '7xvX-L5kQaELV-iAny', 'en', 'image_must_be_png_format', 'image Must be png Format', '2023-08-29 04:07:30', '2023-08-29 04:07:30'),
(220, 'hUhf-V6nFiuPv-3Kf1', 'en', 'frontend_section_updated_successfully', 'Frontend Section Updated Successfully', '2023-08-29 04:08:18', '2023-08-29 04:08:18'),
(221, 'Gol8-RGvwZaXn-dvd5', 'en', 'some_thing_went_wrong', 'Some thing Went Wrong', '2023-08-29 04:38:42', '2023-08-29 04:38:42'),
(222, 'Dp1f-ujxtG3Kc-eQL7', 'en', 'status_updated_successfully', 'Status Updated Successfully', '2023-08-29 04:38:42', '2023-08-29 04:38:42'),
(223, '6LDI-xNnJA6IT-SEhe', 'en', 'website_content', 'Website Content', '2023-08-29 06:23:30', '2023-08-29 06:23:30'),
(224, '0ufE-PDNwuHC8-cK2C', 'en', 'manage_content', 'Manage Content', '2023-08-29 06:23:30', '2023-08-29 06:23:30'),
(225, '9AJL-z3MnHKCk-p9px', 'en', 'service_section', 'Service Section', '2023-08-29 06:23:30', '2023-08-29 06:23:30'),
(226, 'aJv8-j6KZgpOg-TmR7', 'en', 'search_by_title', 'Search By Title', '2023-08-29 06:23:33', '2023-08-29 06:23:33'),
(227, '6iwK-K48N14E2-Kykm', 'en', 'title', 'Title', '2023-08-29 06:23:33', '2023-08-29 06:23:33'),
(228, '58A2-Q2fJcJrK-moxK', 'no_result_found', 'no_data_found_', 'No Data Found !!', '2023-08-29 06:23:34', '2023-08-29 06:23:34'),
(229, '1awi-W9lbpwZY-vXdN', 'en', 'service_list', 'Service List', '2023-08-29 06:23:34', '2023-08-29 06:23:34'),
(230, '2f3O-N79uLCo6-OLFg', 'en', 'service', 'Service', '2023-08-29 06:23:34', '2023-08-29 06:23:34'),
(231, 'CWW9-Zkfw1NMT-KE02', 'en', 'create_service', 'Create Service', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(232, '19cs-kSLjVvn9-i6yO', 'en', 'enter_title', 'Enter Title', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(233, '4cIg-zRQeJr4l-Dni6', 'en', 'image', 'Image', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(234, 'E7dA-Bv3hrSGm-wa97', 'en', 'description', 'Description', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(235, 'vQct-dndtmi1n-zqh7', 'en', 'add_service', 'Add Service', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(236, '2qj0-mZB1nDjl-NPRV', 'en', 'service_name', 'Service Name', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(237, '4OQH-xoHrMvFQ-uD9J', 'en', 'create', 'Create', '2023-08-29 06:30:23', '2023-08-29 06:30:23'),
(238, '1q9x-rizjZIX3-LvFF', 'en', 'short_description', 'Short Description', '2023-08-29 06:35:43', '2023-08-29 06:35:43'),
(239, 'H2xd-yGxoCnEn-KHO9', 'en', 'long_description', 'Long Description', '2023-08-29 06:35:43', '2023-08-29 06:35:43'),
(240, '1SPA-jsKmtU5N-lGw3', 'en', 'updated_successfuly', 'Updated Successfuly', '2023-08-29 06:50:31', '2023-08-29 06:50:31'),
(241, '44Bv-aRTkQjtu-bNIz', 'en', 'update_service', 'Update Service', '2023-08-29 06:59:31', '2023-08-29 06:59:31'),
(242, '50tZ-UK1pYiyK-YvqU', 'en', 'add_field', 'Add Field', '2023-08-29 06:59:31', '2023-08-29 06:59:31'),
(243, 'hgWx-ZwUgvImc-yrI9', 'en', 'service_not_found', 'Service Not Found', '2023-08-29 07:02:18', '2023-08-29 07:02:18'),
(244, '9fHW-UtX4e2JC-C0lF', 'en', 'service_deleted', 'Service Deleted', '2023-08-29 07:04:18', '2023-08-29 07:04:18'),
(245, '5i1W-ebGwRyX3-UVxp', 'en', 'successfully_updated_services_status', 'Successfully updated services status', '2023-08-29 07:04:24', '2023-08-29 07:04:24'),
(246, 'FiSk-Zx1mz6bj-1ts4', 'en', 'services_have_been_successfully_deleted', 'Services have been successfully deleted.', '2023-08-29 07:04:29', '2023-08-29 07:04:29'),
(247, 'O41e-kMRpYWsZ-LMw0', 'en', 'portfolio_section', 'Portfolio Section', '2023-08-29 07:38:18', '2023-08-29 07:38:18'),
(248, 'YKrk-hGxJpjm5-SGZ0', 'en', 'url', 'URL', '2023-08-29 07:40:48', '2023-08-29 07:40:48'),
(249, 'nkFm-iqxqR7fl-Gf03', 'en', 'portfolio_list', 'Portfolio List', '2023-08-29 07:40:48', '2023-08-29 07:40:48'),
(250, '0OMO-MR9LYJ1L-Lo7J', 'en', 'portfolio', 'Portfolio', '2023-08-29 07:40:48', '2023-08-29 07:40:48'),
(251, 'lNvN-e0PQBJvl-PyH0', 'en', 'create_portfolio', 'Create Portfolio', '2023-08-29 07:40:52', '2023-08-29 07:40:52'),
(252, '5Mjt-fM3xbcVa-5sA0', 'en', 'enter_url', 'Enter Url', '2023-08-29 07:40:52', '2023-08-29 07:40:52'),
(253, '78YF-1KhbjKFS-VY8Q', 'en', 'update_portfolio', 'Update Portfolio', '2023-08-29 07:42:18', '2023-08-29 07:42:18'),
(254, 'Cz9Y-3WbyViXY-B8Q2', 'en', 'update_process', 'Update Process', '2023-08-29 08:12:21', '2023-08-29 08:12:21'),
(255, '69l2-aDmYyNaK-ody8', 'en', 'process_section', 'Process Section', '2023-08-29 08:34:38', '2023-08-29 08:34:38'),
(256, '9R3o-Ivfu6mmE-wNma', 'en', 'icon', 'icon', '2023-08-29 08:34:47', '2023-08-29 08:34:47'),
(257, 'xHvv-bdFyn813-Ssc2', 'en', 'process_list', 'Process List', '2023-08-29 08:34:47', '2023-08-29 08:34:47'),
(258, '61HW-8CGYYGTN-WOxd', 'en', 'process', 'Process', '2023-08-29 08:34:47', '2023-08-29 08:34:47'),
(259, '2jdW-uryadS8o-EyJF', 'en', 'create_process', 'Create Process', '2023-08-29 08:34:50', '2023-08-29 08:34:50'),
(260, 'kNCu-tfcFXo7C-DuJ3', 'en', 'enter_icon', 'Enter icon', '2023-08-29 08:34:50', '2023-08-29 08:34:50'),
(261, 'rSTr-23CPbD0z-3wF0', 'en', 'search_here_', 'Search Here !!', '2023-08-29 08:34:50', '2023-08-29 08:34:50'),
(262, '6KWM-jnTIDKp4-eAA8', 'en', 'team_section', 'Team Section', '2023-08-29 10:12:21', '2023-08-29 10:12:21'),
(263, '7aVY-UaibmXMa-9bzO', 'en', 'team_member', 'Team Member', '2023-08-29 10:12:25', '2023-08-29 10:12:25'),
(264, '35q5-8Teugeh1-dBbh', 'en', 'designation', 'Designation', '2023-08-29 10:12:25', '2023-08-29 10:12:25'),
(265, '4QFI-rgCkqBoG-0Gt2', 'en', 'team_list', 'Team List', '2023-08-29 10:12:25', '2023-08-29 10:12:25'),
(266, '06rm-2nBvlgAx-U8tW', 'en', 'team', 'Team', '2023-08-29 10:12:25', '2023-08-29 10:12:25'),
(267, 'm0Qt-ijkcoztK-FFB8', 'en', 'create_team', 'Create Team', '2023-08-29 10:12:28', '2023-08-29 10:12:28'),
(268, '9rsM-WX6aPOlt-snu6', 'en', 'team_member_name', 'Team Member Name', '2023-08-29 10:12:28', '2023-08-29 10:12:28'),
(269, '95d6-fs2QaOOR-Rm2T', 'en', 'enter_designation', 'Enter Designation', '2023-08-29 10:12:28', '2023-08-29 10:12:28'),
(270, '87wl-FXxv7FJC-6wnj', 'en', 'seo_items', 'Seo Items', '2023-08-29 10:54:58', '2023-08-29 10:54:58'),
(271, '5Lzo-q0Boc5oI-PgV5', 'en', 'page_title', 'Page Title', '2023-08-29 10:54:58', '2023-08-29 10:54:58'),
(272, '9oFG-99aSxzOc-Yms4', 'en', 'url_slug', 'Url Slug', '2023-08-29 10:54:58', '2023-08-29 10:54:58'),
(273, '64qj-chik8fxa-MIYf', 'en', 'meta_title', 'Meta Title', '2023-08-29 10:54:58', '2023-08-29 10:54:58'),
(274, '7qx5-3XeB6yaM-NmCD', 'en', 'manage_seo', 'Manage Seo', '2023-08-29 10:54:58', '2023-08-29 10:54:58'),
(275, '641U-SLAsnL3i-IRLL', 'en', 'seos', 'Seos', '2023-08-29 10:54:58', '2023-08-29 10:54:58'),
(276, '0wWK-WMbXE7eJ-c4Tr', 'en', 'template_list', 'Template List', '2023-08-29 11:00:14', '2023-08-29 11:00:14'),
(277, 'UtPo-gQy39hwl-r6f8', 'en', 'show_archive_template', 'Show Archive Template', '2023-08-29 11:00:14', '2023-08-29 11:00:14'),
(278, 'hywG-aRIfWtHC-Ohd7', 'en', 'subject', 'Subject', '2023-08-29 11:00:14', '2023-08-29 11:00:14'),
(279, '3HrA-vYQIauVt-H0z1', 'en', 'manage_template', 'Manage Template', '2023-08-29 11:00:15', '2023-08-29 11:00:15'),
(280, '4IQ2-aqSDeQh2-CV5U', 'en', 'product_section', 'Product Section', '2023-08-29 12:14:46', '2023-08-29 12:14:46'),
(281, '8rrM-6SBewzZT-AgBJ', 'en', 'rating', 'Rating', '2023-08-29 12:15:34', '2023-08-29 12:15:34'),
(282, '7nP3-cyl3zmhd-rCYd', 'en', 'product_list', 'Product List', '2023-08-29 12:15:34', '2023-08-29 12:15:34'),
(283, '3frV-28wFQaFW-o0E9', 'en', 'product', 'Product', '2023-08-29 12:15:34', '2023-08-29 12:15:34'),
(284, 'uZjk-gppnjxzh-7lo6', 'en', 'enter_rating', 'Enter Rating', '2023-08-29 12:15:37', '2023-08-29 12:15:37'),
(285, '9MGh-ucmeIVT5-fAq9', 'en', 'message', 'Message', '2023-08-29 12:18:32', '2023-08-29 12:18:32'),
(286, '5xAx-ZBjuiX6R-7cp2', 'en', 'enter_message', 'Enter Message', '2023-08-29 12:18:32', '2023-08-29 12:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_blocked` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `agent_info` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `updated_by`, `ip_address`, `is_blocked`, `agent_info`, `created_at`, `updated_at`) VALUES
(27, 1, '::1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"::1\",\"time\":\"29-08-2023 06:14:40 PM\"}', '2023-07-20 13:31:29', '2023-08-29 12:14:40'),
(28, NULL, '127.0.0.1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"127.0.0.1\",\"time\":\"21-07-2023 08:33:20 PM\"}', '2023-06-21 14:33:20', '2023-07-21 14:33:20'),
(30, NULL, '192.168.0.122', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.122\",\"time\":\"30-07-2023 06:32:32 PM\"}', '2023-07-30 12:32:32', '2023-07-30 12:32:32'),
(31, NULL, '192.168.0.117', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.117\",\"time\":\"01-08-2023 05:21:20 PM\"}', '2023-07-31 04:22:11', '2023-08-01 11:21:20'),
(32, NULL, '192.168.0.107', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Firefox\",\"ip\":\"192.168.0.107\",\"time\":\"01-08-2023 11:22:01 AM\"}', '2023-08-01 05:18:21', '2023-08-01 05:22:01'),
(33, NULL, '192.168.0.111', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-08-03 11:17:47', '2023-08-03 13:12:44'),
(34, NULL, '192.168.0.113', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-08-03 11:17:47', '2023-08-03 13:12:44'),
(35, NULL, '192.168.0.123', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-10-03 11:17:47', '2023-08-03 13:12:44'),
(36, NULL, '192.168.0.1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-09-03 11:17:47', '2023-08-03 13:12:44'),
(37, NULL, '192.168.0.1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-09-03 11:17:47', '2023-08-03 13:12:44'),
(38, NULL, '192.168.0.1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-09-03 11:17:47', '2023-08-03 13:12:44'),
(39, NULL, '192.168.0.1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 07:12:44 PM\"}', '2023-09-03 11:17:47', '2023-08-03 13:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `web_applications`
--

CREATE TABLE `web_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_uid_index` (`uid`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_fileable_type_fileable_id_index` (`fileable_type`,`fileable_id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `frontends_uid_index` (`uid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD KEY `languages_uid_index` (`uid`);

--
-- Indexes for table `mail_gateways`
--
ALTER TABLE `mail_gateways`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_gateways_uid_index` (`uid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notificationable_type_notificationable_id_index` (`notificationable_type`,`notificationable_id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otps_otpable_type_otpable_id_index` (`otpable_type`,`otpable_id`);

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
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `portfolios_title_unique` (`title`),
  ADD KEY `portfolios_uid_index` (`uid`);

--
-- Indexes for table `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `processes_title_unique` (`title`),
  ADD KEY `processes_uid_index` (`uid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_title_unique` (`title`),
  ADD KEY `products_uid_index` (`uid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD KEY `roles_uid_index` (`uid`);

--
-- Indexes for table `seos`
--
ALTER TABLE `seos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seos_uid_index` (`uid`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_title_unique` (`title`),
  ADD KEY `services_uid_index` (`uid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_uid_index` (`uid`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_name_unique` (`name`),
  ADD UNIQUE KEY `staff_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `staff_email_unique` (`email`),
  ADD KEY `staff_uid_index` (`uid`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teams_name_unique` (`name`),
  ADD KEY `teams_uid_index` (`uid`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_uid_index` (`uid`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_uid_index` (`uid`),
  ADD KEY `tickets_ticket_number_index` (`ticket_number`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_uid_index` (`uid`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_applications`
--
ALTER TABLE `web_applications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mail_gateways`
--
ALTER TABLE `mail_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seos`
--
ALTER TABLE `seos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `web_applications`
--
ALTER TABLE `web_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
