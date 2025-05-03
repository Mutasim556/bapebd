-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 07:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bipebd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive 1=Active',
  `delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `username`, `image`, `email_verified_at`, `password`, `status`, `delete`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '01724698393', 'ad', NULL, NULL, '$2y$12$Q5c2PObYZk6Na7cxY5iVWOdgGqQXnLiBlDJjwBxN49JXcTYh4K/ny', 1, 0, NULL, '2025-01-22 07:00:09', '2025-01-22 07:00:09'),
(4, 'Abul Kalam Azad', 'm@m.com', '01724698397', 'm@m.com', 'public/admin/file/admin/instructor/1740292482.jpg', NULL, '$2y$12$7Frfzco0t5NuAdn3MM3n8u5a7NMr4UMnuiIWpEYckgCR/guXxFCEK', 1, 0, NULL, '2025-01-22 10:56:32', '2025-02-23 06:34:42'),
(5, 'Mutasim Naib Sumit', 'test@test.com', '01724698396', 'test', 'public/admin/file/admin/instructor/1738753191.jpg', NULL, '$2y$12$E.WhJZUKTm76ya8uGMUoiO7RFqtrfyGR7ly70JrdI9SKaDUxwTBS6', 1, 0, NULL, '2025-02-05 10:11:07', '2025-02-23 04:55:25'),
(6, 'Towfiq Elahi', 'towfiq@gmail.com', '123546789', 'towfiq123', 'public/admin/file/admin/instructor/1740286798.jpg', NULL, '$2y$12$CiCmhyBdGCONGmqBN77k3O6rvlYETycMLePJJWwmz7jKCQSxYpp6C', 1, 0, NULL, '2025-02-23 04:59:58', '2025-02-23 04:59:58'),
(7, 'Sadekul', 'sadekul@test.com', '1234567890', 'Sadekul', 'public/admin/file/admin/instructor/1743950609.png', NULL, '$2y$12$7I7ZWhDiEO6NjzZ5JHiOf.dc08MPUXYn8i7CAGi6eSIW0lAmR1lc2', 1, 0, NULL, '2025-04-06 14:43:29', '2025-04-06 14:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile_details`
--

CREATE TABLE `admin_profile_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(70) DEFAULT NULL,
  `department` varchar(70) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `twitter` varchar(200) DEFAULT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profile_details`
--

INSERT INTO `admin_profile_details` (`id`, `instructor_id`, `designation`, `department`, `facebook`, `twitter`, `linkedin`, `details`, `created_at`, `updated_at`) VALUES
(1, 5, 'CEO', 'Web Design & Development', 'sadasd', 'asdasdas', 'dasdasdasdas', NULL, '2025-02-05 10:11:08', '2025-02-05 10:50:57'),
(2, 4, 'Department Head', 'Graphics Design', 'https://www.facebook.com/evaly.com.bd/', 'asdasdas', 'dasdasdasdas', NULL, '2025-02-05 10:54:28', '2025-02-23 04:55:45'),
(3, 6, 'Senior Instructor', 'Digital Marketing', 'https://www.facebook.com/evaly.com.bd/', NULL, NULL, NULL, '2025-02-23 04:59:58', '2025-02-23 04:59:58'),
(4, 7, 'Instructor', 'Digital Marketing', 'https://www.facebook.com/lijon.raha', NULL, NULL, NULL, '2025-04-06 14:43:29', '2025-04-06 14:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `api_key`, `created_at`, `updated_at`) VALUES
(1, 'asdasdas', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_name` text NOT NULL,
  `course_name_slug` text DEFAULT NULL,
  `course_name_metaphone` text DEFAULT NULL,
  `course_headline` text NOT NULL,
  `course_details` text NOT NULL,
  `no_of_videos` int(11) NOT NULL,
  `course_duration` double(8,2) NOT NULL,
  `course_duration_type` varchar(30) NOT NULL,
  `course_level` varchar(255) DEFAULT NULL,
  `course_type` varchar(40) NOT NULL,
  `course_price` double(8,2) NOT NULL,
  `course_price_currency` varchar(40) NOT NULL,
  `course_discount` int(11) NOT NULL,
  `course_discount_type` varchar(20) NOT NULL,
  `course_discount_price` double(8,2) NOT NULL,
  `has_enroll_limit` tinyint(1) DEFAULT NULL,
  `enroll_limit` int(11) DEFAULT NULL,
  `enrolled_count` int(11) DEFAULT NULL,
  `course_images` text NOT NULL,
  `course_cupon_status` tinyint(1) NOT NULL DEFAULT 1,
  `course_multiple_cupon_status` tinyint(1) NOT NULL DEFAULT 1,
  `course_status` tinyint(1) NOT NULL DEFAULT 1,
  `course_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `course_added_by` bigint(20) UNSIGNED NOT NULL,
  `course_updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `category_id`, `sub_category_id`, `course_name`, `course_name_slug`, `course_name_metaphone`, `course_headline`, `course_details`, `no_of_videos`, `course_duration`, `course_duration_type`, `course_level`, `course_type`, `course_price`, `course_price_currency`, `course_discount`, `course_discount_type`, `course_discount_price`, `has_enroll_limit`, `enroll_limit`, `enrolled_count`, `course_images`, `course_cupon_status`, `course_multiple_cupon_status`, `course_status`, `course_delete`, `course_added_by`, `course_updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Web design and development', 'web-design-and-development', 'WBTSNNTTFLPMNT', 'TESH', '<p><span style=\"font-size:18px\"><strong>The Course Curriculam</strong></span></p>\r\n\r\n<p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the consectetur elit. All the Lorem Ipsum generators on the Internet tend to repeat that predefined chunks as necessary, making this the first true dummy generator on the Internet.</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n</ul>', 2, 160.00, 'Hour', 'Intermediate', 'Pre-recorded', 5000.00, 'BDT', 50, 'Flat', 4950.00, NULL, NULL, 0, 'public/admin/file/course/course-images/COURSE-1740898604765.jpg', 1, 1, 1, 0, 1, 1, '2025-01-22 10:59:33', '2025-03-02 06:56:47'),
(3, 1, 1, 'CPA Marketing', 'cpa-marketing', 'KPMRKTNK', 'CPA Marketing', '<p><strong>The Course Curriculam</strong></p>\r\n\r\n<p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the consectetur elit. All the Lorem Ipsum generators on the Internet tend to repeat that predefined chunks as necessary, making this the first true dummy generator on the Internet.</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n</ul>', 4, 160.00, 'Day', 'Beginner', 'Live', 5000.00, 'BDT', 50, 'Percent', 2500.00, NULL, NULL, 0, 'public/admin/file/course/course-images/COURSE-1737545245133.png', 0, 0, 1, 0, 1, 1, '2025-01-22 11:27:28', '2025-02-17 07:28:04'),
(4, 2, 2, 'MERN Stack Development', 'mern-stack-development', 'MRNSTKTFLPMNT', 'Make Full Stack Web Applications Through', '<p>MERN Stack is a combination of four different technologies that is used to develop a website in an efficient manner. In this course, you can gain your expertise in three areas- Web Development, Web Design and App Development. Most of the companies nowadays are using the MERN Stack Programme for its easily customizable, cost-effective features. Enroll in this course to develop your skills in this field.</p>', 60, 160.00, 'Hour', 'Intermediate', 'Pre-recorded', 8000.00, 'BDT', 100, 'Flat', 7900.00, NULL, NULL, NULL, 'public/admin/file/course/course-images/COURSE-1740287060041.png', 1, 1, 1, 0, 1, 1, '2025-02-23 05:04:21', '2025-02-23 05:04:21'),
(5, 3, 4, 'Professional Graphic Design', 'professional-graphic-design', 'PRFSNLKRFKTSN', 'Turn Your Passion into an Artistic Profession', '<p>Considering the growing demand for visual content, marketers are promoting their products through graphical ideas nowadays. The increasing need for graphic designers has unlocked many opportunities for the people who prefer working independently. A study shows, all the companies prioritize their visual acceptance, even a small company spends up to 500 dollars to create a perfect logo. If you are passionate about making designs, this updated Graphic Design course is for you.</p>', 50, 200.00, 'Hour', 'Advanced', 'Live', 10000.00, 'BDT', 10, 'Percent', 9000.00, NULL, NULL, NULL, 'public/admin/file/course/course-images/COURSE-1740287418135.jpg', 1, 0, 1, 0, 1, 1, '2025-02-23 05:10:19', '2025-02-23 05:10:19'),
(6, 2, 3, 'App Development With Kotlin', 'app-development-with-kotlin', 'APTFLPMNTW0KTLN', 'Start Your Career As an Android Developer', '<p>How would you feel if you start using an app developed by yourself? It sounds more interesting in reality, where you combine the programming language and frameworks to have an excellent outcome. A study shows, the demand for app developers is having an upward trend, which might increase by 24% by 2026. New apps are replacing the old ones with improved features and qualities. If you want to develop such a unique app, this course is for you.</p>', 60, 3.00, 'Month', 'Advanced', 'Live', 15000.00, 'BDT', 200, 'Flat', 14800.00, NULL, NULL, NULL, 'public/admin/file/course/course-images/COURSE-1740287828166.png', 1, 1, 1, 0, 1, 1, '2025-02-23 05:17:10', '2025-02-23 05:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `course_applied_coupons`
--

CREATE TABLE `course_applied_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_applied_coupons`
--

INSERT INTO `course_applied_coupons` (`id`, `course_id`, `coupon_id`, `coupon_code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ASDFSADSA', 1, NULL, '2025-02-02 09:15:02', '2025-02-02 09:15:02'),
(2, 3, 1, 'ASDFSADSA', 1, NULL, '2025-02-02 09:15:02', '2025-02-02 09:15:02'),
(6, 1, 4, 'DSFDSFD', 1, NULL, '2025-02-02 10:51:33', '2025-02-02 10:51:33'),
(7, 3, 4, 'DSFDSFD', 1, NULL, '2025-02-02 10:51:33', '2025-02-02 10:51:33'),
(8, 1, 5, 'DSFDSF', 1, NULL, '2025-02-02 10:51:56', '2025-02-02 10:51:56'),
(9, 3, 5, 'DSFDSF', 1, NULL, '2025-02-02 10:51:56', '2025-02-02 10:51:56'),
(25, 1, 2, 'SADSAD', 1, 1, '2025-03-04 08:02:36', '2025-03-04 08:02:36'),
(26, 3, 2, 'SADSAD', 1, 1, '2025-03-04 08:02:36', '2025-03-04 08:02:36'),
(27, 6, 2, 'SADSAD', 1, 1, '2025-03-04 08:02:36', '2025-03-04 08:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `course_batches`
--

CREATE TABLE `course_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `batch_name` text NOT NULL,
  `batch_code` varchar(255) NOT NULL,
  `batch_number` int(11) NOT NULL,
  `batch_instructor` varchar(255) NOT NULL,
  `batch_start_date` date NOT NULL,
  `batch_end_date` date NOT NULL,
  `batch_time` time NOT NULL,
  `batch_day` varchar(255) DEFAULT NULL,
  `enroll_limit` int(11) NOT NULL,
  `enrolled_count` int(11) NOT NULL,
  `live_in` varchar(255) NOT NULL,
  `link_or_address` varchar(255) NOT NULL,
  `batch_status` tinyint(1) NOT NULL DEFAULT 1,
  `batch_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `batch_added_by` bigint(20) UNSIGNED NOT NULL,
  `batch_updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_batches`
--

INSERT INTO `course_batches` (`id`, `course_id`, `batch_name`, `batch_code`, `batch_number`, `batch_instructor`, `batch_start_date`, `batch_end_date`, `batch_time`, `batch_day`, `enroll_limit`, `enrolled_count`, `live_in`, `link_or_address`, `batch_status`, `batch_delete`, `batch_added_by`, `batch_updated_by`, `created_at`, `updated_at`) VALUES
(1, 3, 'BATCH-1', 'B#234', 1, '4', '2025-03-03', '2025-04-20', '17:26:00', 'Staturday,Sunday,Monday,Tuesday,Wednesday,Thursday', 25, 0, 'Zoom', 'sadasdasdasd', 1, 0, 1, 1, '2025-01-22 11:27:28', '2025-02-17 07:07:04'),
(2, 3, 'BATCH-2', 'B#2344', 2, '4', '2025-04-03', '2025-06-03', '18:04:00', 'Monday,Wednesday,Friday', 44, 0, 'Google Meet', 'sadasdasdasd', 1, 0, 1, 1, '2025-01-28 10:15:18', '2025-02-17 07:07:45'),
(3, 3, 'TESTB', 'B#2346', 3, '4', '2025-04-03', '2025-06-03', '16:17:00', NULL, 33, 0, 'Physical Class', 'sadasdasdasd', 0, 0, 1, 1, '2025-01-28 10:18:05', '2025-02-05 06:27:34'),
(4, 3, 'TESTB', 'B#2347', 4, '4', '2025-04-20', '2025-06-03', '16:17:00', NULL, 33, 0, 'Physical Class', 'sadasdasdasd', 1, 0, 1, 1, '2025-01-28 10:19:54', '2025-01-28 10:24:58'),
(5, 3, 'TESTB', 'B#2349', 5, '4', '2025-04-20', '2025-06-03', '16:17:00', NULL, 33, 0, 'Physical Class', 'sadasdasdasd', 1, 0, 1, 1, '2025-01-28 10:21:13', '2025-01-28 10:24:59'),
(6, 5, 'BATCH-1', 'GDB1', 1, '6', '2025-04-20', '2025-06-03', '14:00:00', 'Wednesday,Thursday,Friday', 0, 0, 'Physical Class', 'sasdasdasdas', 1, 0, 1, 1, '2025-02-23 05:10:19', '2025-02-23 06:46:27'),
(7, 6, 'BATCH-1', 'APDV1', 1, '5', '2025-04-20', '2025-06-03', '15:30:00', NULL, 100, 0, 'Google Meet', 'sdfsdfsdf', 1, 0, 1, 1, '2025-02-23 05:17:10', '2025-02-23 05:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `course_carts`
--

CREATE TABLE `course_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_carts`
--

INSERT INTO `course_carts` (`id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
(24, 1, 4, '2025-04-06 08:38:02', '2025-04-06 08:38:02'),
(25, 1, 1, '2025-04-06 08:43:31', '2025-04-06 08:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) DEFAULT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `category_status` tinyint(1) NOT NULL DEFAULT 1,
  `category_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `category_added_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`id`, `category_name`, `category_slug`, `category_image`, `category_status`, `category_delete`, `category_added_by`, `created_at`, `updated_at`) VALUES
(1, 'Pharma Marketing', 'pharma-marketing', 'public/admin/file/course/category/Pharma Marketing1743951555.png', 1, 0, 1, '2025-01-22 07:03:03', '2025-04-06 14:59:16'),
(2, 'Global Pharmaceutical accreditation', 'global-pharmaceutical-accreditation', 'public/admin/file/course/category/Global Pharmaceutical accreditation1743951884.png', 1, 0, 1, '2025-02-23 04:39:07', '2025-04-06 15:04:46'),
(3, 'Industrial Pharmacy', 'industrial-pharmacy', 'public/admin/file/course/category/Industrial Pharmacy1743951703.png', 1, 0, 1, '2025-02-23 04:43:32', '2025-04-06 15:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `course_coupons`
--

CREATE TABLE `course_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon` varchar(255) NOT NULL,
  `coupon_start_date` date NOT NULL,
  `coupon_end_date` date NOT NULL,
  `can_apply` int(11) NOT NULL DEFAULT 1,
  `apply_type` varchar(60) NOT NULL,
  `has_minimum_price_for_apply` varchar(40) NOT NULL,
  `minimum_price_for_apply` double(8,2) NOT NULL,
  `coupon_discount` double(8,2) NOT NULL,
  `coupon_discount_type` varchar(60) NOT NULL,
  `has_maximum_discount` varchar(40) NOT NULL,
  `maximum_discount` double(8,2) NOT NULL,
  `coupon_details` text DEFAULT NULL,
  `applicable_for` tinyint(4) DEFAULT NULL,
  `coupon_status` tinyint(1) NOT NULL DEFAULT 1,
  `coupon_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_coupons`
--

INSERT INTO `course_coupons` (`id`, `coupon`, `coupon_start_date`, `coupon_end_date`, `can_apply`, `apply_type`, `has_minimum_price_for_apply`, `minimum_price_for_apply`, `coupon_discount`, `coupon_discount_type`, `has_maximum_discount`, `maximum_discount`, `coupon_details`, `applicable_for`, `coupon_status`, `coupon_delete`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'ASDFSADSA', '2025-03-02', '2025-05-14', 1, 'discount_on_regular_price', '1', 100.00, 45.00, 'Flat', '1', 50.00, 'asdasdasd', 1, 1, 0, 1, '2025-02-02 09:15:02', '2025-02-03 07:17:26'),
(2, 'SADSAD', '2025-03-03', '2025-07-08', 4, 'discount_on_regular_price', '10', 111.00, 45.00, 'Percent', '1', 61.00, 'asdasd', 1, 1, 0, 1, '2025-02-02 10:27:12', '2025-02-04 06:53:40'),
(4, 'DSFDSFD', '2025-03-02', '2025-05-10', 1, 'discount_on_discounted_price', '1', 100.00, 45.00, 'Flat', '1', 50.00, 'asdsadasd', 1, 1, 1, 1, '2025-02-02 10:51:33', '2025-02-03 07:17:41'),
(5, 'DSFDSF', '2025-02-01', '2025-02-20', 1, 'discount_on_discounted_price', '1', 100.00, 45.00, 'Flat', '1', 50.00, 'asdsadasd', 1, 1, 0, 1, '2025-02-02 10:51:56', '2025-02-03 05:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructors`
--

CREATE TABLE `course_instructors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `instructor_id` varchar(255) NOT NULL,
  `file_link` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_instructors`
--

INSERT INTO `course_instructors` (`id`, `course_id`, `batch_id`, `instructor_id`, `file_link`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '4', 'sdsadsadsadsadsadasdasdfgdfggdfg', '2025-01-22 10:59:33', '2025-01-28 10:34:35'),
(2, 3, 1, '4', NULL, '2025-01-22 11:27:28', '2025-01-22 11:27:28'),
(3, 4, NULL, '5', NULL, '2025-02-23 05:04:21', '2025-02-23 05:04:21'),
(4, 5, 6, '6', NULL, '2025-02-23 05:10:20', '2025-02-23 06:44:47'),
(5, 6, 7, '5', NULL, '2025-02-23 05:17:10', '2025-02-23 05:17:10');

-- --------------------------------------------------------

--
-- Table structure for table `course_sub_categories`
--

CREATE TABLE `course_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `sub_category_slug` varchar(255) DEFAULT NULL,
  `sub_category_image` varchar(255) DEFAULT NULL,
  `sub_category_status` tinyint(1) NOT NULL DEFAULT 1,
  `sub_category_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `sub_category_added_by` bigint(20) UNSIGNED NOT NULL,
  `sub_category_updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_sub_categories`
--

INSERT INTO `course_sub_categories` (`id`, `category_id`, `sub_category_name`, `sub_category_slug`, `sub_category_image`, `sub_category_status`, `sub_category_delete`, `sub_category_added_by`, `sub_category_updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'CPA Marketing', 'cpa-marketing', '', 1, 0, 1, 1, '2025-01-22 07:04:00', '2025-02-20 07:55:03'),
(2, 2, 'Web Application Development', 'web-application-development', '', 1, 0, 1, 1, '2025-02-23 04:47:38', '2025-02-23 04:47:38'),
(3, 2, 'Mobile App Development', 'mobile-app-development', '', 1, 0, 1, 1, '2025-02-23 04:48:03', '2025-02-23 04:48:03'),
(4, 3, 'Graphics Design', 'graphics-design', '', 1, 0, 1, 1, '2025-02-23 04:48:35', '2025-02-23 04:48:35'),
(5, 3, 'Video Editing', 'video-editing', '', 1, 0, 1, 1, '2025-02-23 04:48:59', '2025-02-23 04:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `course_videos`
--

CREATE TABLE `course_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `video_group` varchar(255) NOT NULL,
  `videos_file` varchar(255) DEFAULT NULL,
  `video_no` varchar(30) NOT NULL,
  `video_link` varchar(255) NOT NULL,
  `video_title` text NOT NULL,
  `video_duration` varchar(30) NOT NULL,
  `video_type` varchar(30) NOT NULL,
  `video_status` tinyint(1) NOT NULL DEFAULT 1,
  `video_delete` tinyint(1) NOT NULL DEFAULT 0,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_videos`
--

INSERT INTO `course_videos` (`id`, `course_id`, `video_group`, `videos_file`, `video_no`, `video_link`, `video_title`, `video_duration`, `video_type`, `video_status`, `video_delete`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Introduction', '', '1', 'rIfdg_Ot-LI', 'Introduction to Laravel', '4.5', 'Free', 1, 0, 1, '2025-01-22 10:59:33', '2025-02-16 11:06:04'),
(2, 1, 'Introduction', 'public/admin/file/course/course-files/COURSE_VIDEO_FILE_1737543573.xlsx', '2', '2qgS_MCvDfk', 'Installation', '2.3', 'Paid', 1, 0, 1, '2025-01-22 10:59:33', '2025-02-16 11:11:12'),
(3, 1, 'TEST', 'public/admin/file/course/course-files/COURSE_VIDEO_FILE_1_1_1738056990.pdf', '3', 'asdasdasdasdsad', 'asdasdasdasd', '44', 'Free', 1, 0, 1, '2025-01-28 09:36:30', '2025-01-28 11:16:57'),
(4, 1, 'TESTG', 'public/admin/file/course/course-files/COURSE_VIDEO_FILE_1_1_1738057311.pdf', '4', 'asdasdasdasdsad', 'rrrrrr', '10', 'Paid', 1, 0, 1, '2025-01-28 09:41:51', '2025-01-28 09:41:51'),
(5, 1, 'TESTG', 'public/admin/file/course/course-files/COURSE_VIDEO_FILE_1_1_1738057358.pdf', '5', 'asdasdasdasdsad', 'rrrrrr', '2', 'Free', 1, 0, 1, '2025-01-28 09:42:38', '2025-01-28 09:42:43'),
(6, 4, 'Introduction', 'public/admin/file/course/course-files/COURSE_VIDEO_FILE_4_0_1740287062.xlsx', '1', 'd35dfSwBTNY', 'Introducing to HTML', '6.56', 'Free', 1, 0, 1, '2025-02-23 05:04:22', '2025-04-06 08:20:08'),
(7, 4, 'Introduction', 'public/admin/file/course/course-files/COURSE_VIDEO_FILE_4_1_1744268788.xlsx', '2', 'OocqG7u1r6U', 'Introduction to Laravel Part 2', '44', 'Paid', 1, 0, 1, '2025-04-10 07:06:28', '2025-04-10 07:06:58');

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
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `lang`, `slug`, `default`, `status`, `delete`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'en', 1, 1, 0, '2025-01-22 07:01:16', '2025-01-22 07:02:03'),
(2, 'Bangla', 'bn', 'bn', 0, 1, 0, '2025-01-22 07:01:24', '2025-01-22 07:02:03'),
(3, 'Hindi', 'hi', 'hi', 0, 1, 0, '2025-01-22 07:01:37', '2025-01-22 07:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `secret_code` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `mail_option` varchar(255) NOT NULL,
  `mail_subject` varchar(255) NOT NULL,
  `mail_body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(5, '2023_12_27_095019_create_permission_tables', 1),
(6, '2023_12_27_101553_create_admins_table', 1),
(7, '2024_01_01_094807_create_languages_table', 1),
(8, '2024_01_01_145421_create_api_keys_table', 1),
(9, '2024_01_10_122602_create_maintenances_table', 1),
(10, '2025_01_07_125629_create_course_categories_table', 1),
(11, '2025_01_09_123044_create_course_sub_categories_table', 1),
(12, '2025_01_09_165906_create_translations_table', 1),
(13, '2025_01_12_161704_create_courses_table', 1),
(17, '2025_01_22_125448_create_course_instructors_table', 2),
(18, '2025_01_22_132655_create_course_videos_table', 3),
(19, '2025_01_15_133943_create_course_batches_table', 4),
(24, '2025_01_28_163654_create_course_cuppons_table', 7),
(25, '2025_02_02_130944_create_course_applied_coupons_table', 8),
(27, '2025_02_05_154306_create_admin_profile_details_table', 9),
(29, '2025_02_16_091802_add_course_name_slug_to_courses_table', 10),
(31, '2025_02_17_122326_add_batch_day_to_course_batches_table', 11),
(32, '2025_02_17_144307_add_enroll_limit_to_courses_table', 12),
(34, '2025_02_20_122514_add_category_slug_to_course_categories_table', 13),
(35, '2025_02_20_135407_add_sub_category_slug_to_course_sub_categories_table', 14),
(36, '2025_02_24_164644_create_course_carts_table', 15),
(37, '2025_03_23_131837_create_purchases_table', 16),
(38, '2025_03_23_132448_create_puchase_courses_table', 16),
(42, '2025_03_23_132448_create_purchase_courses_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1),
(2, 'App\\Models\\Admin', 4),
(2, 'App\\Models\\Admin', 5),
(2, 'App\\Models\\Admin', 6),
(2, 'App\\Models\\Admin', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `amount`, `address`, `status`, `transaction_id`, `currency`) VALUES
(1, 'MD. Mutasim Naib Sumit', 'mutasim@gmail.com', '01724698392', 39150, 'xxxxxxx', 'Processing', '67dfd09290b9a', 'BDT'),
(2, 'MD. Mutasim Naib Sumit', 'mutasim@gmail.com', '01724698392', 39150, 'xxxxxxx', 'Processing', '67dfd104f0627', 'BDT'),
(3, 'MD. Mutasim Naib Sumit', 'mutasim@gmail.com', '01724698392', 12789, 'xxxxxxx', 'Pending', '67f23f9ea075e', 'BDT'),
(4, 'MD. Mutasim Naib Sumit', 'mutasim@gmail.com', '01724698392', 12850, 'xxxxxxx', 'Pending', '67f23fae6f542', 'BDT'),
(5, 'MD. Mutasim Naib Sumit', 'mutasim@gmail.com', '01724698392', 12789, 'xxxxxxx', 'Pending', '67f23fc41ba6f', 'BDT'),
(6, 'TEST', 'test@test.com', '12345678998', 4950, 'xxxxxxx', 'Processing', '67f5e4908255c', 'BDT'),
(7, 'TEST', 'test@test.com', '12345678998', 7900, 'xxxxxxx', 'Pending', '67f5e5e6de203', 'BDT'),
(8, 'TEST', 'test@test.com', '12345678998', 7900, 'xxxxxxx', 'Pending', '67f5e5eebacdb', 'BDT'),
(9, 'TEST', 'test@test.com', '12345678998', 7900, 'xxxxxxx', 'Processing', '67f7661d11088', 'BDT'),
(10, 'TEST', 'test@test.com', '12345678998', 14800, 'xxxxxxx', 'Processing', '67f76f7ee2004', 'BDT');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'user-index', 'admin', 'User Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(2, 'user-create', 'admin', 'User Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(3, 'user-update', 'admin', 'User Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(4, 'user-delete', 'admin', 'User Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(5, 'instructor-index', 'admin', 'Instructor Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(6, 'instructor-create', 'admin', 'Instructor Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(7, 'instructor-update', 'admin', 'Instructor Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(8, 'instructor-delete', 'admin', 'Instructor Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(9, 'admin-role-permission-index', 'admin', 'Admin Roles And Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(10, 'admin-role-permission-create', 'admin', 'Admin Roles And Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(11, 'admin-role-permission-update', 'admin', 'Admin Roles And Permissions', '2025-01-22 06:57:23', '2025-01-22 06:57:23'),
(12, 'admin-role-permission-delete', 'admin', 'Admin Roles And Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(13, 'admin-specific-permission-create', 'admin', 'Admin Roles And Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(14, 'language-index', 'admin', 'Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(15, 'language-create', 'admin', 'Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(16, 'language-update', 'admin', 'Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(17, 'language-delete', 'admin', 'Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(18, 'backend-string-generate', 'admin', 'Backend Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(19, 'backend-string-translate', 'admin', 'Backend Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(20, 'backend-string-update', 'admin', 'Backend Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(21, 'backend-string-index', 'admin', 'Backend Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(22, 'backend-api-accesskey', 'admin', 'Backend Language Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(23, 'maintenance-mode-index', 'admin', 'Settings Permissions', '2025-01-22 06:57:24', '2025-01-22 06:57:24'),
(24, 'course-category-index', 'admin', 'Course Category', '2025-01-23 05:27:30', '2025-01-23 05:27:30'),
(25, 'course-category-create', 'admin', 'Course Category', '2025-01-23 05:27:30', '2025-01-23 05:27:30'),
(26, 'course-category-update', 'admin', 'Course Category', '2025-01-23 05:27:30', '2025-01-23 05:27:30'),
(27, 'course-category-delete', 'admin', 'Course Category', '2025-01-23 05:27:30', '2025-01-23 05:27:30'),
(28, 'course-subcategory-index', 'admin', 'Course Sub-Category', '2025-01-23 05:27:30', '2025-01-23 05:27:30'),
(29, 'course-subcategory-create', 'admin', 'Course Sub-Category', '2025-01-23 05:27:30', '2025-01-23 05:27:30'),
(30, 'course-subcategory-update', 'admin', 'Course Sub-Category', '2025-01-23 05:27:31', '2025-01-23 05:27:31'),
(31, 'course-subcategory-delete', 'admin', 'Course Sub-Category', '2025-01-23 05:27:31', '2025-01-23 05:27:31'),
(32, 'course-index', 'admin', 'Course', '2025-01-23 05:27:31', '2025-01-23 05:27:31'),
(33, 'course-create', 'admin', 'Course', '2025-01-23 05:27:31', '2025-01-23 05:27:31'),
(34, 'course-update', 'admin', 'Course', '2025-01-23 05:27:31', '2025-01-23 05:27:31'),
(35, 'course-delete', 'admin', 'Course', '2025-01-23 05:27:31', '2025-01-23 05:27:31'),
(37, 'course-cuppon-apply', 'admin', 'Course', '2025-01-23 08:54:35', '2025-01-23 08:54:35'),
(38, 'course-cuppun-remove', 'admin', 'Course', '2025-01-23 08:54:35', '2025-01-23 08:54:35'),
(39, 'course-batch-create', 'admin', 'Course', '2025-01-26 07:12:40', '2025-01-26 07:12:40'),
(40, 'course-batch-update', 'admin', 'Course', '2025-01-26 07:12:41', '2025-01-26 07:12:41'),
(41, 'course-batch-delete', 'admin', 'Course', '2025-01-26 07:12:41', '2025-01-26 07:12:41'),
(42, 'course-video-create', 'admin', 'Course', '2025-01-26 08:57:28', '2025-01-26 08:57:28'),
(43, 'course-video-update', 'admin', 'Course', '2025-01-26 08:57:28', '2025-01-26 08:57:28'),
(44, 'course-video-delete', 'admin', 'Course', '2025-01-26 08:57:28', '2025-01-26 08:57:28'),
(49, 'course-coupon-index', 'admin', 'Course Coupon', '2025-02-02 07:29:26', '2025-02-02 07:29:26'),
(50, 'course-coupon-create', 'admin', 'Course Coupon', '2025-02-02 07:29:26', '2025-02-02 07:29:26'),
(51, 'course-coupon-update', 'admin', 'Course Coupon', '2025-02-02 07:29:26', '2025-02-02 07:29:26'),
(52, 'course-coupon-delete', 'admin', 'Course Coupon', '2025-02-02 07:29:26', '2025-02-02 07:29:26');

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
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courses` varchar(255) NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `dicount_amount` double(8,2) NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_option` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `courses`, `total_amount`, `dicount_amount`, `subtotal`, `payment_method`, `payment_status`, `transaction_id`, `payment_option`, `created_at`, `updated_at`) VALUES
(1, '\"4|3|1|6|5|\"', 39150.00, 0.00, 39150.00, 'sslcommerz', 1, '67dfd09290b9a', 'BKASH-BKash', '2025-03-23 09:12:57', '2025-03-23 09:12:57'),
(2, '\"4|3|1|6|5|\"', 39150.00, 0.00, 39150.00, 'sslcommerz', 1, '67dfd09290b9a', 'BKASH-BKash', '2025-03-23 09:13:08', '2025-03-23 09:13:08'),
(3, '\"4|3|1|6|5|\"', 39150.00, 0.00, 39150.00, 'sslcommerz', 1, '67dfd104f0627', 'BKASH-BKash', '2025-03-23 09:14:52', '2025-03-23 09:14:52'),
(4, '\"1|\"', 4950.00, 0.00, 4950.00, 'sslcommerz', 1, '67f5e4908255c', 'BKASH-BKash', '2025-04-09 03:08:18', '2025-04-09 03:08:18'),
(5, '\"4|\"', 7900.00, 0.00, 7900.00, 'sslcommerz', 1, '67f7661d11088', 'BKASH-BKash', '2025-04-10 06:33:09', '2025-04-10 06:33:09'),
(6, '\"6|\"', 14800.00, 0.00, 14800.00, 'sslcommerz', 1, '67f76f7ee2004', 'BKASH-BKash', '2025-04-10 07:13:12', '2025-04-10 07:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_courses`
--

CREATE TABLE `purchase_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `course_type` varchar(255) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', '2025-01-22 07:00:08', '2025-01-22 07:00:08'),
(2, 'Instructor', 'admin', '2025-01-22 10:55:59', '2025-01-22 10:55:59'),
(3, 'Modaretor', 'admin', '2025-04-06 08:25:51', '2025-04-06 08:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(5, 2),
(5, 3),
(6, 2),
(6, 3),
(7, 3),
(8, 3),
(24, 3),
(25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `translationable_type` varchar(255) NOT NULL,
  `translationable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `translationable_type`, `translationable_id`, `locale`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Admin\\Language', 1, 'en', 'name', 'English', '2025-01-22 07:01:16', '2025-01-22 07:02:03'),
(2, 'App\\Models\\Admin\\Language', 2, 'en', 'name', 'Bangla', '2025-01-22 07:01:24', '2025-01-22 07:01:48'),
(3, 'App\\Models\\Admin\\Language', 3, 'en', 'name', 'Hindi', '2025-01-22 07:01:37', '2025-01-23 07:03:57'),
(4, 'App\\Models\\Admin\\Language', 2, 'bn', 'name', 'বাংলা', NULL, '2025-01-22 07:01:48'),
(5, 'App\\Models\\Admin\\Language', 2, 'hi', 'name', 'उतर', NULL, '2025-01-22 07:01:48'),
(6, 'App\\Models\\Admin\\Language', 1, 'bn', 'name', 'ইংরেজি', NULL, '2025-01-22 07:02:03'),
(7, 'App\\Models\\Admin\\Language', 1, 'hi', 'name', 'अंग्रेजी', NULL, '2025-01-22 07:02:04'),
(8, 'App\\Models\\Admin\\Course\\CourseCategory', 1, 'en', 'category_name', 'Pharma Marketing', '2025-01-22 07:03:03', '2025-04-06 14:59:15'),
(9, 'App\\Models\\Admin\\Course\\CourseCategory', 1, 'bn', 'category_name', 'ফার্মা বিপণন', '2025-01-22 07:03:03', '2025-04-06 14:59:15'),
(10, 'App\\Models\\Admin\\Course\\CourseCategory', 1, 'hi', 'category_name', 'तमाम', '2025-01-22 07:03:03', '2025-04-06 14:59:16'),
(11, 'App\\Models\\Admin\\Course\\CourseSubCategory', 1, 'en', 'sub_category_name', 'CPA Marketing', '2025-01-22 07:04:00', '2025-02-23 04:47:01'),
(12, 'App\\Models\\Admin\\Course\\CourseSubCategory', 1, 'bn', 'sub_category_name', 'সিপিএ বিপণন', '2025-01-22 07:04:00', '2025-02-23 04:47:02'),
(13, 'App\\Models\\Admin\\Course\\CourseSubCategory', 1, 'hi', 'sub_category_name', 'सीपीए विपणन', '2025-01-22 07:04:00', '2025-02-23 04:47:03'),
(14, 'App\\Models\\Admin\\Course\\Course', 1, 'en', 'course_name', 'Web design and development', '2025-01-22 10:59:33', '2025-03-02 06:56:47'),
(15, 'App\\Models\\Admin\\Course\\Course', 1, 'en', 'course_headline', 'TESH', '2025-01-22 10:59:33', '2025-03-02 06:56:47'),
(16, 'App\\Models\\Admin\\Course\\Course', 1, 'en', 'course_details', '<p><span style=\"font-size:18px\"><strong>The Course Curriculam</strong></span></p>\r\n\r\n<p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the consectetur elit. All the Lorem Ipsum generators on the Internet tend to repeat that predefined chunks as necessary, making this the first true dummy generator on the Internet.</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n</ul>', '2025-01-22 10:59:33', '2025-03-02 06:56:47'),
(17, 'App\\Models\\Admin\\Course\\Course', 3, 'en', 'course_name', 'CPA Marketing', '2025-01-22 11:27:28', '2025-02-17 07:28:04'),
(18, 'App\\Models\\Admin\\Course\\Course', 3, 'en', 'course_headline', 'CPA Marketing', '2025-01-22 11:27:28', '2025-02-17 07:28:04'),
(19, 'App\\Models\\Admin\\Course\\Course', 3, 'en', 'course_details', '<p><strong>The Course Curriculam</strong></p>\r\n\r\n<p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the consectetur elit. All the Lorem Ipsum generators on the Internet tend to repeat that predefined chunks as necessary, making this the first true dummy generator on the Internet.</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n	<li>\r\n	<p>How to use social media to reach local, national and international audiences</p>\r\n	</li>\r\n</ul>', '2025-01-22 11:27:28', '2025-02-17 07:28:04'),
(20, 'App\\Models\\Admin\\Language', 3, 'bn', 'name', 'হিন্দি', NULL, '2025-01-23 07:03:58'),
(21, 'App\\Models\\Admin\\Language', 3, 'hi', 'name', 'हिन्दी', NULL, '2025-01-23 07:03:58'),
(22, 'App\\Models\\Admin\\Course\\Course', 1, 'bn', 'course_name', 'TESTBN', '2025-01-22 10:59:33', '2025-03-02 06:56:47'),
(23, 'App\\Models\\Admin\\Course\\Course', 1, 'hi', 'course_name', 'TESTHI', NULL, '2025-03-02 06:56:47'),
(24, 'App\\Models\\Admin\\Course\\Course', 3, 'bn', 'course_name', 'TESTBN', NULL, '2025-02-17 07:28:04'),
(25, 'App\\Models\\Admin\\Course\\Course', 3, 'hi', 'course_name', 'TESTHI', NULL, '2025-02-17 07:28:04'),
(26, 'App\\Models\\Admin\\Course\\Course', 3, 'bn', 'course_headline', 'sdfsdfdsf', NULL, '2025-02-17 07:28:04'),
(27, 'App\\Models\\Admin\\Course\\Course', 3, 'hi', 'course_headline', 'sdfsdfsdfsd', NULL, '2025-02-17 07:28:04'),
(28, 'App\\Models\\Admin\\Course\\Course', 1, 'bn', 'course_headline', 'asdasdasdasdas asdas asd asdasd', NULL, '2025-03-02 06:56:47'),
(29, 'App\\Models\\Admin\\Course\\Course', 1, 'hi', 'course_headline', 'asdsadasdasdasdasdasd', NULL, '2025-03-02 06:56:47'),
(30, 'App\\Models\\Admin\\Course\\Course', 1, 'bn', 'course_details', '<p>asd&nbsp; d dfg gfdg&nbsp;</p>', NULL, '2025-03-02 06:56:47'),
(31, 'App\\Models\\Admin\\Course\\Course', 1, 'hi', 'course_details', '<p>dddddd</p>', NULL, '2025-03-02 06:56:47'),
(32, 'App\\Models\\Admin\\Course\\CourseCategory', 2, 'en', 'category_name', 'Global Pharmaceutical accreditation', '2025-02-23 04:39:07', '2025-04-06 15:04:44'),
(33, 'App\\Models\\Admin\\Course\\CourseCategory', 2, 'bn', 'category_name', 'গ্লোবাল ফার্মাসিউটিক্যাল স্বীকৃতি', '2025-02-23 04:39:08', '2025-04-06 15:04:45'),
(34, 'App\\Models\\Admin\\Course\\CourseCategory', 2, 'hi', 'category_name', 'अफ़मणता', '2025-02-23 04:39:10', '2025-04-06 15:04:46'),
(35, 'App\\Models\\Admin\\Course\\CourseCategory', 3, 'en', 'category_name', 'Industrial Pharmacy', '2025-02-23 04:43:32', '2025-04-06 15:01:43'),
(36, 'App\\Models\\Admin\\Course\\CourseCategory', 3, 'bn', 'category_name', 'শিল্প ফার্মাসি', '2025-02-23 04:43:34', '2025-04-06 15:01:45'),
(37, 'App\\Models\\Admin\\Course\\CourseCategory', 3, 'hi', 'category_name', 'तमाम', '2025-02-23 04:43:34', '2025-04-06 15:01:45'),
(38, 'App\\Models\\Admin\\Course\\CourseSubCategory', 2, 'en', 'sub_category_name', 'Web Application Development', '2025-02-23 04:47:38', NULL),
(39, 'App\\Models\\Admin\\Course\\CourseSubCategory', 2, 'bn', 'sub_category_name', 'ওয়েব অ্যাপ্লিকেশন বিকাশ', '2025-02-23 04:47:39', NULL),
(40, 'App\\Models\\Admin\\Course\\CourseSubCategory', 2, 'hi', 'sub_category_name', 'अराध्य', '2025-02-23 04:47:40', NULL),
(41, 'App\\Models\\Admin\\Course\\CourseSubCategory', 3, 'en', 'sub_category_name', 'Mobile App Development', '2025-02-23 04:48:03', NULL),
(42, 'App\\Models\\Admin\\Course\\CourseSubCategory', 3, 'bn', 'sub_category_name', 'মোবাইল অ্যাপ্লিকেশন বিকাশ', '2025-02-23 04:48:05', NULL),
(43, 'App\\Models\\Admin\\Course\\CourseSubCategory', 3, 'hi', 'sub_category_name', 'तंग', '2025-02-23 04:48:05', NULL),
(44, 'App\\Models\\Admin\\Course\\CourseSubCategory', 4, 'en', 'sub_category_name', 'Graphics Design', '2025-02-23 04:48:35', NULL),
(45, 'App\\Models\\Admin\\Course\\CourseSubCategory', 4, 'bn', 'sub_category_name', 'গ্রাফিক্স ডিজাইন', '2025-02-23 04:48:35', NULL),
(46, 'App\\Models\\Admin\\Course\\CourseSubCategory', 4, 'hi', 'sub_category_name', 'तमाम', '2025-02-23 04:48:37', NULL),
(47, 'App\\Models\\Admin\\Course\\CourseSubCategory', 5, 'en', 'sub_category_name', 'Video Editing', '2025-02-23 04:48:59', NULL),
(48, 'App\\Models\\Admin\\Course\\CourseSubCategory', 5, 'bn', 'sub_category_name', 'ভিডিও সম্পাদনা', '2025-02-23 04:49:00', NULL),
(49, 'App\\Models\\Admin\\Course\\CourseSubCategory', 5, 'hi', 'sub_category_name', 'अँगुला', '2025-02-23 04:49:00', NULL),
(50, 'App\\Models\\Admin\\Course\\Course', 4, 'en', 'course_name', 'MERN Stack Development', '2025-02-23 05:04:22', NULL),
(51, 'App\\Models\\Admin\\Course\\Course', 4, 'en', 'course_headline', 'Make Full Stack Web Applications Through', '2025-02-23 05:04:22', NULL),
(52, 'App\\Models\\Admin\\Course\\Course', 4, 'en', 'course_details', '<p>MERN Stack is a combination of four different technologies that is used to develop a website in an efficient manner. In this course, you can gain your expertise in three areas- Web Development, Web Design and App Development. Most of the companies nowadays are using the MERN Stack Programme for its easily customizable, cost-effective features. Enroll in this course to develop your skills in this field.</p>', '2025-02-23 05:04:22', NULL),
(53, 'App\\Models\\Admin\\Course\\Course', 4, 'bn', 'course_name', 'MERN স্ট্যাক ডেভেলপমেন্ট', '2025-02-23 05:04:22', NULL),
(54, 'App\\Models\\Admin\\Course\\Course', 4, 'bn', 'course_headline', 'এর মাধ্যমে সম্পূর্ণ স্ট্যাক ওয়েব অ্যাপ্লিকেশন তৈরি করুন', '2025-02-23 05:04:22', NULL),
(55, 'App\\Models\\Admin\\Course\\Course', 4, 'bn', 'course_details', '<pre>\r\nMERN স্ট্যাক হল চারটি ভিন্ন প্রযুক্তির সংমিশ্রণ যা একটি দক্ষ পদ্ধতিতে ওয়েবসাইট তৈরি করতে ব্যবহৃত হয়। এই কোর্সে, আপনি তিনটি ক্ষেত্রে আপনার দক্ষতা অর্জন করতে পারেন- ওয়েব ডেভেলপমেন্ট, ওয়েব ডিজাইন এবং অ্যাপ ডেভেলপমেন্ট। আজকাল বেশিরভাগ কোম্পানিই MERN স্ট্যাক প্রোগ্রাম ব্যবহার করছে এর সহজে কাস্টমাইজযোগ্য, খরচ-কার্যকর বৈশিষ্ট্যের জন্য। এই ক্ষেত্রে আপনার দক্ষতা বিকাশের জন্য এই কোর্সে নথিভুক্ত করুন।</pre>', '2025-02-23 05:04:22', NULL),
(56, 'App\\Models\\Admin\\Course\\Course', 4, 'hi', 'course_name', 'MERN স্ট্যাক ডেভেলপমেন্ট', '2025-02-23 05:04:22', NULL),
(57, 'App\\Models\\Admin\\Course\\Course', 4, 'hi', 'course_headline', 'के माध्यम से पूर्ण स्टैक वेब एप्लिकेशन बनाएं', '2025-02-23 05:04:22', NULL),
(58, 'App\\Models\\Admin\\Course\\Course', 4, 'hi', 'course_details', '<pre>\r\nMERN स्टैक चार अलग-अलग तकनीकों का एक संयोजन है जिसका उपयोग किसी वेबसाइट को कुशल तरीके से विकसित करने के लिए किया जाता है। इस कोर्स में आप तीन क्षेत्रों - वेब डेवलपमेंट, वेब डिज़ाइन और ऐप डेवलपमेंट में अपनी विशेषज्ञता हासिल कर सकते हैं। आजकल अधिकांश कंपनियाँ आसानी से अनुकूलन योग्य, लागत प्रभावी सुविधाओं के लिए MERN स्टैक प्रोग्राम का उपयोग कर रही हैं। इस क्षेत्र में अपना कौशल विकसित करने के लिए इस पाठ्यक्रम में दाखिला लें।</pre>', '2025-02-23 05:04:22', NULL),
(59, 'App\\Models\\Admin\\Course\\Course', 5, 'en', 'course_name', 'Professional Graphic Design', '2025-02-23 05:10:20', NULL),
(60, 'App\\Models\\Admin\\Course\\Course', 5, 'en', 'course_headline', 'Turn Your Passion into an Artistic Profession', '2025-02-23 05:10:20', NULL),
(61, 'App\\Models\\Admin\\Course\\Course', 5, 'en', 'course_details', '<p>Considering the growing demand for visual content, marketers are promoting their products through graphical ideas nowadays. The increasing need for graphic designers has unlocked many opportunities for the people who prefer working independently. A study shows, all the companies prioritize their visual acceptance, even a small company spends up to 500 dollars to create a perfect logo. If you are passionate about making designs, this updated Graphic Design course is for you.</p>', '2025-02-23 05:10:20', NULL),
(62, 'App\\Models\\Admin\\Course\\Course', 5, 'bn', 'course_name', 'Professional Graphic Design', '2025-02-23 05:10:20', NULL),
(63, 'App\\Models\\Admin\\Course\\Course', 5, 'bn', 'course_headline', 'Turn Your Passion into an Artistic Profession', '2025-02-23 05:10:20', NULL),
(64, 'App\\Models\\Admin\\Course\\Course', 5, 'hi', 'course_name', 'Professional Graphic Design', '2025-02-23 05:10:20', NULL),
(65, 'App\\Models\\Admin\\Course\\Course', 5, 'hi', 'course_headline', 'Turn Your Passion into an Artistic Profession', '2025-02-23 05:10:20', NULL),
(66, 'App\\Models\\Admin\\Course\\Course', 6, 'en', 'course_name', 'App Development With Kotlin', '2025-02-23 05:17:10', NULL),
(67, 'App\\Models\\Admin\\Course\\Course', 6, 'en', 'course_headline', 'Start Your Career As an Android Developer', '2025-02-23 05:17:10', NULL),
(68, 'App\\Models\\Admin\\Course\\Course', 6, 'en', 'course_details', '<p>How would you feel if you start using an app developed by yourself? It sounds more interesting in reality, where you combine the programming language and frameworks to have an excellent outcome. A study shows, the demand for app developers is having an upward trend, which might increase by 24% by 2026. New apps are replacing the old ones with improved features and qualities. If you want to develop such a unique app, this course is for you.</p>', '2025-02-23 05:17:10', NULL),
(69, 'App\\Models\\Admin\\Course\\Course', 6, 'bn', 'course_name', 'App Development With Kotlin', '2025-02-23 05:17:10', NULL),
(70, 'App\\Models\\Admin\\Course\\Course', 6, 'bn', 'course_headline', 'Start Your Career As an Android Developer', '2025-02-23 05:17:10', NULL),
(71, 'App\\Models\\Admin\\Course\\Course', 6, 'bn', 'course_details', '<p>How would you feel if you start using an app developed by yourself? It sounds more interesting in reality, where you combine the programming language and frameworks to have an excellent outcome. A study shows, the demand for app developers is having an upward trend, which might increase by 24% by 2026. New apps are replacing the old ones with improved features and qualities. If you want to develop such a unique app, this course is for you.</p>', '2025-02-23 05:17:10', NULL),
(72, 'App\\Models\\Admin\\Course\\Course', 6, 'hi', 'course_name', 'App Development With Kotlin', '2025-02-23 05:17:10', NULL),
(73, 'App\\Models\\Admin\\Course\\Course', 6, 'hi', 'course_headline', 'Start Your Career As an Android Developer', '2025-02-23 05:17:10', NULL),
(74, 'App\\Models\\Admin\\Course\\Course', 6, 'hi', 'course_details', '<p>How would you feel if you start using an app developed by yourself? It sounds more interesting in reality, where you combine the programming language and frameworks to have an excellent outcome. A study shows, the demand for app developers is having an upward trend, which might increase by 24% by 2026. New apps are replacing the old ones with improved features and qualities. If you want to develop such a unique app, this course is for you.</p>', '2025-02-23 05:17:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive 1=Active',
  `delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted 1=Deleted',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `username`, `image`, `email_verified_at`, `password`, `status`, `delete`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MD. Mutasim Naib Sumit', 'mutasim@gmail.com', '01724698392', NULL, NULL, NULL, '$2y$12$4ucPbpCy/mURWG9RhdkapOFDs02h.k338W2MueZu4mDz0oMMcY6MW', 1, 0, NULL, '2025-02-18 06:44:11', '2025-02-18 06:44:11'),
(2, 'TEST', 'test@test.com', '12345678998', NULL, NULL, NULL, '$2y$12$Y56MjzbaK3Bq/kYVlaRh/.RDz8cvwtbx/uS1f.e9iDVEUVNBwvzhS', 1, 0, NULL, '2025-04-06 08:23:24', '2025-04-06 08:23:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_phone_unique` (`phone`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `admin_profile_details`
--
ALTER TABLE `admin_profile_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_profile_details_instructor_id_foreign` (`instructor_id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_course_name_slug_unique` (`course_name_slug`) USING HASH,
  ADD KEY `courses_category_id_foreign` (`category_id`),
  ADD KEY `courses_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `courses_course_added_by_foreign` (`course_added_by`),
  ADD KEY `courses_course_updated_by_foreign` (`course_updated_by`);

--
-- Indexes for table `course_applied_coupons`
--
ALTER TABLE `course_applied_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_applied_coupons_course_id_foreign` (`course_id`),
  ADD KEY `course_applied_coupons_coupon_id_foreign` (`coupon_id`),
  ADD KEY `course_applied_coupons_created_by_foreign` (`created_by`),
  ADD KEY `course_applied_coupons_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `course_batches`
--
ALTER TABLE `course_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_batches_course_id_foreign` (`course_id`),
  ADD KEY `course_batches_batch_added_by_foreign` (`batch_added_by`),
  ADD KEY `course_batches_batch_updated_by_foreign` (`batch_updated_by`);

--
-- Indexes for table `course_carts`
--
ALTER TABLE `course_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_carts_user_id_foreign` (`user_id`),
  ADD KEY `course_carts_course_id_foreign` (`course_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_categories_category_added_by_foreign` (`category_added_by`);

--
-- Indexes for table `course_coupons`
--
ALTER TABLE `course_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_coupons_created_by_foreign` (`created_by`);

--
-- Indexes for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_instructors_course_id_foreign` (`course_id`),
  ADD KEY `course_instructors_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `course_sub_categories`
--
ALTER TABLE `course_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_sub_categories_category_id_foreign` (`category_id`),
  ADD KEY `course_sub_categories_sub_category_added_by_foreign` (`sub_category_added_by`),
  ADD KEY `course_sub_categories_sub_category_updated_by_foreign` (`sub_category_updated_by`);

--
-- Indexes for table `course_videos`
--
ALTER TABLE `course_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_videos_course_id_foreign` (`course_id`),
  ADD KEY `course_videos_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_courses`
--
ALTER TABLE `purchase_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_courses_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_courses_user_id_foreign` (`user_id`),
  ADD KEY `purchase_courses_course_id_foreign` (`course_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_profile_details`
--
ALTER TABLE `admin_profile_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_applied_coupons`
--
ALTER TABLE `course_applied_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `course_batches`
--
ALTER TABLE `course_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_carts`
--
ALTER TABLE `course_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_coupons`
--
ALTER TABLE `course_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_instructors`
--
ALTER TABLE `course_instructors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_sub_categories`
--
ALTER TABLE `course_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_videos`
--
ALTER TABLE `course_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_courses`
--
ALTER TABLE `purchase_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_profile_details`
--
ALTER TABLE `admin_profile_details`
  ADD CONSTRAINT `admin_profile_details_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`),
  ADD CONSTRAINT `courses_course_added_by_foreign` FOREIGN KEY (`course_added_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `courses_course_updated_by_foreign` FOREIGN KEY (`course_updated_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `courses_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `course_sub_categories` (`id`);

--
-- Constraints for table `course_applied_coupons`
--
ALTER TABLE `course_applied_coupons`
  ADD CONSTRAINT `course_applied_coupons_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `course_coupons` (`id`),
  ADD CONSTRAINT `course_applied_coupons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `course_applied_coupons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `course_applied_coupons_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `course_batches`
--
ALTER TABLE `course_batches`
  ADD CONSTRAINT `course_batches_batch_added_by_foreign` FOREIGN KEY (`batch_added_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `course_batches_batch_updated_by_foreign` FOREIGN KEY (`batch_updated_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `course_batches_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `course_carts`
--
ALTER TABLE `course_carts`
  ADD CONSTRAINT `course_carts_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD CONSTRAINT `course_categories_category_added_by_foreign` FOREIGN KEY (`category_added_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `course_coupons`
--
ALTER TABLE `course_coupons`
  ADD CONSTRAINT `course_coupons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `course_instructors`
--
ALTER TABLE `course_instructors`
  ADD CONSTRAINT `course_instructors_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `course_batches` (`id`),
  ADD CONSTRAINT `course_instructors_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `course_sub_categories`
--
ALTER TABLE `course_sub_categories`
  ADD CONSTRAINT `course_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`),
  ADD CONSTRAINT `course_sub_categories_sub_category_added_by_foreign` FOREIGN KEY (`sub_category_added_by`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `course_sub_categories_sub_category_updated_by_foreign` FOREIGN KEY (`sub_category_updated_by`) REFERENCES `admins` (`id`);

--
-- Constraints for table `course_videos`
--
ALTER TABLE `course_videos`
  ADD CONSTRAINT `course_videos_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `course_videos_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_courses`
--
ALTER TABLE `purchase_courses`
  ADD CONSTRAINT `purchase_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `purchase_courses_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
