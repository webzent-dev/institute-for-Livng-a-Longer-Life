-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 06:29 PM
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
-- Database: `bike_living_longer`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `resource_type` varchar(255) DEFAULT NULL,
  `resource_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('6ab24829e614f8ae3507e059015a1412', 'i:1;', 1774968176),
('6ab24829e614f8ae3507e059015a1412:timer', 'i:1774968176;', 1774968176),
('c15c0a6dadb569cc099f5d69113415b8', 'i:1;', 1774968186),
('c15c0a6dadb569cc099f5d69113415b8:timer', 'i:1774968186;', 1774968186);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_sessions`
--

CREATE TABLE `cart_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}' CHECK (json_valid(`items`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `status` enum('active','abandoned','converted','expired') NOT NULL DEFAULT 'active',
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE `collaborators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `specialty_area_of_expertise` text NOT NULL,
  `professional_credentials` varchar(255) NOT NULL,
  `experience` int(11) NOT NULL,
  `practice_organization` varchar(255) NOT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'collaborator',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collaborator_profiles`
--

CREATE TABLE `collaborator_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_options`
--

CREATE TABLE `contact_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_options`
--

INSERT INTO `contact_options` (`id`, `type`, `icon`, `title`, `description`, `contact`, `note`, `created_at`, `updated_at`) VALUES
(1, 'mail', 'mail', 'Email Support', 'Get help via email', 'support@livinglonger.com', 'Response within 24 hours', '2025-12-30 06:22:30', '2025-12-30 06:22:30'),
(2, 'phone', 'phone', 'Phone Support', 'Speak with our team', '(555) 123-4567', 'Mon-Fri, 9am-5pm EST', '2025-12-30 06:22:30', '2025-12-30 06:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `content_management`
--

CREATE TABLE `content_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_name` varchar(255) DEFAULT NULL,
  `page_content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_management`
--

INSERT INTO `content_management` (`id`, `page_name`, `page_content`, `created_at`, `updated_at`) VALUES
(1, 'home_page', '<span class=\"text-sm font-light tracking-[0.2em] text-gray-800\">WELCOME TO</span>\r\n\r\n<h1 class=\"text-3xl md:text-4xl lg:text-5xl font-normal tracking-tight text-gray-900 mt-2\">\r\n  THE INSTITUTE FOR LIVING A LONGER LIFE\r\n</h1>\r\n\r\n<p class=\"mt-6 text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto leading-tight\">\r\n  Congratulations! This Is Your First Step To Living A Longer<br class=\"hidden md:block\" /> Healthier Life.\r\n</p>', NULL, '2026-03-27 01:30:47'),
(2, 'collaborator_page', '<div class=\"lg:px-8 max-w-7xl mx-auto px-4 sm:px-6 text-center\">\n    <h1 class=\"font-bold lg:text-6xl mb-6 text-4xl text-foreground\">Our Expert Collaborators</h1>\n    <p class=\"max-w-3xl mx-auto text-muted-foreground text-xl\">Learn from a network of world-class physicians and health practitioners, each bringing specialized expertise to your wellness journey. Access their exclusive courses and recommended products.</p>\n</div>', NULL, '2026-03-16 06:33:00'),
(3, 'testimonial_page', '<div class=\"lg:px-8 max-w-7xl mx-auto px-4 sm:px-6 text-center\">\r\n<h1 class=\"font-bold lg:text-6xl mb-6 text-4xl text-foreground\">Member Success Stories</h1>\r\n\r\n<p class=\"max-w-3xl mx-auto text-muted-foreground text-xl\">Real people, real results. Read how our members are transforming their health and living longer, healthier lives.</p>\r\n</div>\r\n\r\n<div class=\"lg:px-8 max-w-7xl mx-auto px-4 sm:px-6\">\r\n<div class=\"gap-8 grid grid-cols-2 md:grid-cols-4\">\r\n<div class=\"bg-card border-2 rounded-lg shadow-medium shadow-sm text-card-foreground\">\r\n<div class=\"p-6 text-center\">\r\n<div class=\"bg-clip-text font-bold gradient-primary mb-2 text-4xl text-transparent\">10,000+</div>\r\n\r\n<p class=\"text-muted-foreground\">Active Members</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"bg-card border-2 rounded-lg shadow-medium shadow-sm text-card-foreground\">\r\n<div class=\"p-6 text-center\">\r\n<div class=\"bg-clip-text font-bold gradient-primary mb-2 text-4xl text-transparent\">4.9/5</div>\r\n\r\n<p class=\"text-muted-foreground\">Average Rating</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"bg-card border-2 rounded-lg shadow-medium shadow-sm text-card-foreground\">\r\n<div class=\"p-6 text-center\">\r\n<div class=\"bg-clip-text font-bold gradient-primary mb-2 text-4xl text-transparent\">95%</div>\r\n\r\n<p class=\"text-muted-foreground\">Satisfaction Rate</p>\r\n</div>\r\n</div>\r\n\r\n<div class=\"bg-card border-2 rounded-lg shadow-medium shadow-sm text-card-foreground\">\r\n<div class=\"p-6 text-center\">\r\n<div class=\"bg-clip-text font-bold gradient-primary mb-2 text-4xl text-transparent\">89%</div>\r\n\r\n<p class=\"text-muted-foreground\">Report Better Health</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', NULL, '2026-03-16 06:36:00'),
(4, 'about_page', '<main class=\"flex-1\">\r\n<section class=\"gradient-subtle py-20\">\r\n<div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n<div class=\"grid lg:grid-cols-2 gap-12 items-center\">\r\n<div class=\"space-y-6\">\r\n<h1 class=\"text-4xl lg:text-6xl font-bold text-foreground text-left\">Meet Dr. Victor Zeinesss</h1>\r\n\r\n<p class=\"text-xl text-muted-foreground\">Founder of the Institute for Living Longer</p>\r\n\r\n<div class=\"h-1 w-24 gradient-primary rounded-full\"></div>\r\n</div>\r\n\r\n<div class=\"relative\">\r\n<div class=\"aspect-square rounded-2xl overflow-hidden shadow-strong\"><img alt=\"Dr. Victor Zeines\" class=\"w-full h-full object-cover\" src=\"https://bikewrapt.com/instituteoflivinglonger/public/assets/dr-zeines.webp\" /></div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n\r\n<section class=\"py-20 bg-background bg-white\">\r\n<div class=\"max-w-7xl mx-auto grid md:grid-cols-2 lg:grid-cols-4 gap-8 px-4\"><x-card class=\"equal-height\"> <x-card-content class=\"space-y-4\">\r\n<div class=\"iconbg w-14 h-14\"><svg aria-hidden=\"true\" class=\"lucide lucide-graduation-cap w-7 h-7 text-primary-foreground\" data-lucide=\"graduation-cap\" fill=\"none\" height=\"24\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" viewbox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z\"></path><path d=\"M22 10v6\"></path><path d=\"M6 12.5V16a6 3 0 0 0 12 0v-3.5\"></path></svg></div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground\">Education &amp; Training</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Doctorate in Dental Medicine with specialized training in holistic health and longevity medicine</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content class=\"space-y-4\">\r\n<div class=\"iconbg w-14 h-14\"><svg aria-hidden=\"true\" class=\"lucide lucide-award w-7 h-7 text-primary-foreground\" data-lucide=\"award\" fill=\"none\" height=\"24\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" viewbox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526\"></path><circle cx=\"12\" cy=\"8\" r=\"6\"></circle></svg></div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground\">40+ Years Experience</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Pioneering holistic approaches to health, wellness, and biological age reversal</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content class=\"space-y-4\">\r\n<div class=\"iconbg w-14 h-14\"><svg aria-hidden=\"true\" class=\"lucide lucide-book-open w-7 h-7 text-primary-foreground\" data-lucide=\"book-open\" fill=\"none\" height=\"24\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" viewbox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M12 7v14\"></path><path d=\"M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z\"></path></svg></div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground\">Published Author</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Multiple publications on integrative health and evidence-based wellness practices</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content class=\"space-y-4\">\r\n<div class=\"iconbg w-14 h-14\"><svg aria-hidden=\"true\" class=\"lucide lucide-heart w-7 h-7 text-primary-foreground\" data-lucide=\"heart\" fill=\"none\" height=\"24\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" viewbox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5\"></path></svg></div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground\">Wellness Philosophy</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Dedicated to empowering individuals to take control of their health through education and community support</p>\r\n</x-card-content> </x-card></div>\r\n</section>\r\n\r\n<section class=\"py-20 gradient-subtle\">\r\n<div class=\"max-w-4xl mx-auto px-4 sm:px-6 lg:px-8\">\r\n<div class=\"rounded-lg border bg-card text-card-foreground   shadow-sm\">\r\n<div class=\"p-8 lg:p-12 space-y-6 \">\r\n<h2 class=\"text-3xl font-bold text-foreground mb-6 text-left\">A Lifetime Dedicated to Health &amp; Wellness</h2>\r\n\r\n<div class=\"prose prose-lg max-w-none text-muted-foreground space-y-4 text-[16px]\">\r\n<p class=\"text-[16px]\">Dr. Victor Zeines has dedicated over four decades to understanding and teaching the principles of holistic health and longevity. As a pioneering voice in integrative medicine, he has helped thousands of individuals transform their lives through evidence-based wellness practices.</p>\r\n\r\n<p class=\"text-[16px]\">His unique approach combines traditional medical knowledge with cutting-edge research in nutrition, exercise science, stress management, and biological age reversal. Dr. Zeines believes that true health is not merely the absence of disease, but a state of complete physical, mental, and social well-being.</p>\r\n\r\n<p class=\"text-[16px]\">Through the Institute for Living Longer, Dr. Zeines has created a comprehensive educational platform that makes advanced wellness knowledge accessible to everyone. His teaching style is warm, engaging, and deeply rooted in scientific evidence, making complex health concepts easy to understand and implement.</p>\r\n\r\n<p class=\"text-[16px]\">Beyond his individual practice, Dr. Zeines has assembled a network of world-class collaborators &mdash; expert physicians and health practitioners who share his vision of empowering individuals to take charge of their health destiny. Together, they offer a comprehensive approach to wellness that addresses every aspect of healthy living.</p>\r\n</div>\r\n\r\n<div class=\"mt-8 p-6 bg-secondary rounded-xl\">\r\n<p class=\"text-lg font-semibold text-foreground mb-2 text-[18px]\">&quot;My mission is simple: to empower you with the knowledge and tools you need to live a longer, healthier, and more vibrant life.&quot;</p>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">- Dr. Victor Zeines</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n\r\n<section class=\"py-20 bg-background\">\r\n<div class=\"max-w-7xl mx-auto px-4\">\r\n<div class=\"text-center mb-12\">\r\n<h2 class=\"text-3xl lg:text-5xl font-bold text-foreground mb-4\">Dr. Zeines&#39; Wellness Philosophy</h2>\r\n\r\n<p class=\"text-xl text-muted-foreground max-w-3xl mx-auto\">Five core principles for lasting health and vitality</p>\r\n</div>\r\n\r\n<div class=\"grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto\"><x-card class=\"equal-height\"> <x-card-content>\r\n<div class=\"text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4\">01</div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground mb-2 text-[20px]\">Prevention First</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Focus on preventing disease rather than just treating symptoms</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content>\r\n<div class=\"text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4\">02</div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground mb-2 text-[20px]\">Whole Person Care</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Address physical, mental, emotional, and spiritual health</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content>\r\n<div class=\"text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4\">03</div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground mb-2 text-[20px]\">Evidence-Based</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Combine traditional wisdom with scientific research</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content>\r\n<div class=\"text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4\">04</div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground mb-2 text-[20px]\">Personalized Approach</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Recognize that each person&rsquo;s path to wellness is unique</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content>\r\n<div class=\"text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4\">05</div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground mb-2 text-[20px]\">Sustainable Habits</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Build lasting lifestyle changes, not quick fixes</p>\r\n</x-card-content> </x-card> <x-card class=\"equal-height\"> <x-card-content>\r\n<div class=\"text-5xl font-bold gradient-primary text-transparent bg-clip-text mb-4\">06</div>\r\n\r\n<h3 class=\"text-xl font-semibold text-foreground mb-2 text-[20px]\">Community Support</h3>\r\n\r\n<p class=\"text-muted-foreground text-[16px]\">Harness the power of community for lasting transformation</p>\r\n</x-card-content> </x-card></div>\r\n</div>\r\n</section>\r\n</main>', NULL, '2026-03-27 01:42:09');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_images`
--

CREATE TABLE `course_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'id of courses table',
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Membership', '2025-12-30 04:07:04', '2025-12-30 04:07:04'),
(2, 'Vital Boost', '2025-12-30 04:07:04', '2025-12-30 04:07:04'),
(3, 'Live Sessions', '2025-12-30 04:08:16', '2025-12-30 04:08:16'),
(4, 'Technical Support', '2025-12-30 04:08:16', '2025-12-30 04:08:16'),
(5, 'Collaborators', '2025-12-30 04:09:29', '2025-12-30 04:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `f_a_q_s`
--

CREATE TABLE `f_a_q_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faq_category_id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `f_a_q_s`
--

INSERT INTO `f_a_q_s` (`id`, `faq_category_id`, `question`, `answer`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'What included in the membership plans?', 'Our membership plans include access to pre-recorded video lectures, live monthly Zoom sessions with Dr. Zeines..', 1, '2025-12-30 04:10:13', '2026-03-16 05:34:38'),
(2, 1, 'Can I upgrade or downgrade my membership?', 'Yes, you can upgrade or downgrade your membership at any time...', 1, '2025-12-30 04:11:14', '2026-03-06 22:18:05'),
(3, 1, 'Is there a free trial available?', 'Intro videos are available for free so you can get a sense...', 1, '2025-12-30 04:12:17', '2025-12-30 04:12:17'),
(4, 1, 'What\'s the difference between the membership tiers?', 'Standard Membership includes 1 lecture per month...', 1, '2025-12-30 04:13:36', '2026-03-06 22:16:33'),
(5, 2, 'What is Vital Boost?', 'Vital Boost is a comprehensive powdered nutritional supplement...', 1, '2025-12-30 04:14:17', '2025-12-30 04:14:17'),
(6, 2, 'How do I take Vital Boost?', 'Simply mix one packet into your smoothie or water...', 1, '2025-12-30 04:14:50', '2025-12-30 04:14:50'),
(7, 2, 'Is Vital Boost safe with my current medications?', 'Consult your healthcare provider before starting any supplement...', 1, '2025-12-30 04:15:37', '2025-12-30 04:15:37'),
(8, 2, 'Will it fit my dietary needs?', 'Vital Boost is vegan, gluten-free, non-dairy and sugar-free...', 1, '2025-12-30 04:16:18', '2025-12-30 04:16:18'),
(9, 3, 'When are the live Zoom sessions held?', 'Live sessions are held monthly and recorded...', 1, '2025-12-30 04:16:56', '2025-12-30 04:16:56'),
(10, 3, 'Can I ask questions during live sessions?', 'Yes! Live Q&A is available for all members...', 1, '2025-12-30 04:17:40', '2025-12-30 04:17:40'),
(11, 3, 'What if I miss a live session?', 'All live sessions are recorded and uploaded within 24 hours...', 1, '2025-12-30 04:18:15', '2025-12-30 04:18:15'),
(12, 4, 'I\'m having trouble accessing my account. What should I do?', 'Try resetting your password or contact support@livinglonger.com...', 1, '2025-12-30 04:18:49', '2025-12-30 04:18:49'),
(13, 4, 'How do I access the member dashboard?', 'After login, you will be redirected to your dashboard...', 1, '2025-12-30 04:19:54', '2025-12-30 04:19:54'),
(14, 4, 'Can I access content on mobile devices?', 'Yes! The platform is fully responsive...', 1, '2025-12-30 04:20:40', '2025-12-30 04:20:40'),
(15, 5, 'Who are the collaborators?', 'World-class health practitioners and physicians...', 1, '2025-12-30 04:21:22', '2025-12-30 04:21:22'),
(16, 5, 'Can I become a collaborator?', 'Visit the Contact page and submit your details...', 1, '2025-12-30 04:21:22', '2025-12-30 04:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `help_articles`
--

CREATE TABLE `help_articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `help_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_articles`
--

INSERT INTO `help_articles` (`id`, `help_category_id`, `title`, `slug`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'Creating Your Account', 'creating-your-account', 'Creating Your Account', '2025-12-30 05:34:34', '2026-03-16 06:23:44'),
(2, 1, 'Navigating the Member Dashboard', '', 'Navigating the Member Dashboard', '2025-12-30 05:34:34', '2025-12-30 05:34:34'),
(10, 1, 'Accessing Your First Course', 'Accessing Your First Course', 'Accessing Your First Course', '2025-12-30 05:39:59', '2025-12-30 05:39:59'),
(12, 1, 'Setting Up Your Profile', 'Setting Up Your Profile', 'Setting Up Your Profile', '2025-12-30 05:40:56', '2025-12-30 05:40:56'),
(13, 2, 'How to Access Pre-Recorded Lectures', 'How-to-Access-Pre-Recorded-Lectures', 'How to Access Pre-Recorded Lectures', '2025-12-30 05:41:57', '2025-12-30 05:41:57'),
(14, 2, 'Viewing Live Zoom Sessions', 'Viewing Live Zoom Sessions', 'Viewing Live Zoom Sessions', '2025-12-30 05:41:57', '2025-12-30 05:41:57'),
(21, 2, 'Downloading Content for Offline Viewing', 'Downloading-Content-for-Offline-Viewing', 'Downloading Content for Offline Viewing', '2025-12-30 05:45:38', '2025-12-30 05:45:38'),
(22, 2, 'Video Playback Troubleshooting', 'Video-Playback-Troubleshooting', 'Video Playback Troubleshooting', '2025-12-30 05:46:21', '2025-12-30 05:46:21'),
(23, 3, 'Understanding Membership Plans', 'Understanding-Membership-Plans', 'Understanding Membership Plans', '2025-12-30 05:47:20', '2025-12-30 05:47:20'),
(24, 3, 'Updating Payment Information', 'Updating-Payment-Information', 'Updating Payment Information', '2025-12-30 05:47:20', '2025-12-30 05:47:20'),
(25, 3, 'Upgrading or Downgrading Membership', 'Upgrading-or-Downgrading-Membership', 'Upgrading or Downgrading Membership', '2025-12-30 05:49:08', '2025-12-30 05:49:08'),
(26, 3, 'Cancellation and Refund Policy', 'Cancellation-and-Refund-Policy', 'Cancellation and Refund Policy', '2025-12-30 05:49:08', '2025-12-30 05:49:08'),
(27, 4, 'Joining Live Zoom Sessions', 'Joining-Live-Zoom-Sessions', 'Joining Live Zoom Sessions', '2025-12-30 05:50:48', '2025-12-30 05:50:48'),
(28, 4, 'Asking Questions During Q&A', 'Asking-Questions-During-Q&A', 'Asking Questions During Q&A', '2025-12-30 05:50:48', '2025-12-30 05:50:48'),
(29, 4, 'Connecting with Other Members', 'Connecting-with-Other-Members', 'Connecting with Other Members', '2025-12-30 05:52:09', '2025-12-30 05:52:09'),
(30, 4, 'Upcoming Events Calendar', 'Upcoming-Events-Calendar', 'Upcoming Events Calendar', '2025-12-30 05:52:09', '2025-12-30 05:52:09'),
(31, 5, 'Updating Personal Information', 'Updating-Personal-Information', 'Updating Personal Information', '2025-12-30 05:53:26', '2025-12-30 05:53:26'),
(32, 5, 'Changing Password', 'Changing-Password', 'Changing Password', '2025-12-30 05:53:26', '2025-12-30 05:53:26'),
(33, 5, 'Email Notification Settings', 'Email-Notification-Settings', 'Email Notification Settings', '2025-12-30 05:54:39', '2025-12-30 05:54:39'),
(34, 5, 'Privacy and Data Settings', 'Privacy-and-Data-Settings', 'Privacy and Data Settings', '2025-12-30 05:54:39', '2025-12-30 05:54:39'),
(35, 6, 'Login Problems', 'login-problems', 'Login Problems sjdnskd', '2025-12-30 05:56:17', '2026-03-23 13:11:07'),
(36, 6, 'Video Won\'t Play', 'Video-Won\'t-Play', 'Video Won\'t Play', '2025-12-30 05:56:17', '2025-12-30 05:56:17'),
(37, 6, 'Payment Declined', 'Payment-Declined', 'Payment Declined', '2025-12-30 05:57:37', '2025-12-30 05:57:37'),
(38, 6, 'Email Not Received', 'Email-Not-Received', 'Email Not Received', '2025-12-30 05:57:37', '2025-12-30 05:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `help_categories`
--

CREATE TABLE `help_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_categories`
--

INSERT INTO `help_categories` (`id`, `icon`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Book', 'Getting Started', 'Getting Started', 'Learn how to set up your account and navigate the platform', '2025-12-30 05:24:09', '2025-12-30 05:24:09'),
(2, 'Video', 'Video Content', 'Video Content', 'Everything about accessing and watching our educational content', '2025-12-30 05:24:09', '2025-12-30 05:24:09'),
(3, 'credit-card', 'Billing Payments', 'billing-payments', 'Manage your subscription and payment information', '2025-12-30 05:27:18', '2026-03-16 06:19:45'),
(4, 'Users', 'ommunity & Live Sessions', 'ommunity & Live Sessions', 'Connect with other members and join live events', '2025-12-30 05:27:18', '2025-12-30 05:27:18'),
(5, 'Settings', 'Account Management', 'Account-Management', 'Control your account settings and preferences', '2025-12-30 05:29:05', '2025-12-30 05:29:05'),
(6, 'life-buoy', 'Troubleshooting', 'Troubleshooting', 'Common issues and how to resolve them', '2025-12-30 05:29:05', '2025-12-30 05:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `intro_videos`
--

CREATE TABLE `intro_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `intro_videos`
--

INSERT INTO `intro_videos` (`id`, `title`, `video_url`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Periodontal', 'https://vimeo.com/817941121', 'If you have periodontal disease you are twice as likely to have a heart attack or a stroke. Find out how to protect yourself.', 'active', '2026-03-31 00:10:18', '2026-03-31 00:10:18'),
(2, 'Herbology', 'https://vimeo.com/817940460', 'For thousands of years herbs were our only medicine.', 'active', '2026-03-31 00:19:27', '2026-03-31 00:19:27'),
(3, 'Root Canal Therapy', 'https://vimeo.com/817940153', 'Not really therapy. What you should know.', 'active', '2026-03-31 00:19:49', '2026-03-31 00:19:49'),
(4, 'Cancer', 'https://vimeo.com/817940330', 'Learn the dental aspects of cancer survival.', 'active', '2026-03-31 00:20:13', '2026-03-31 00:20:13'),
(5, 'Acupuncture', 'https://vimeo.com/817940305', 'Meridians and the flow of energy', 'active', '2026-03-31 00:20:50', '2026-03-31 00:20:50'),
(6, 'Immunology', 'https://vimeo.com/817940474', 'Your immune system is basic to your health. Learn how the immune system works and ways to improve yours.', 'active', '2026-03-31 00:21:29', '2026-03-31 00:21:29'),
(7, 'Kinesiology', 'https://vimeo.com/817940932', 'Improve your life. Balance your energy and increase your self awareness.', 'active', '2026-03-31 00:22:19', '2026-03-31 00:22:19'),
(8, 'Mercury Toxicity', 'https://vimeo.com/817940994', 'Mercury fillings are toxic. Removal protocols.', 'active', '2026-03-31 00:22:45', '2026-03-31 00:22:45'),
(9, 'Magnets', 'https://vimeo.com/817940967', 'For centuries magnets have been used along with herbs to promote healing.', 'active', '2026-03-31 00:23:14', '2026-03-31 00:23:14'),
(10, 'Ozone', 'https://vimeo.com/817941086', 'Effects and uses.', 'active', '2026-03-31 00:23:35', '2026-03-31 00:23:35'),
(11, 'Nutrition', 'https://vimeo.com/817941027', 'You are what you eat. Diet is everything', 'active', '2026-03-31 00:24:03', '2026-03-31 00:24:03'),
(12, 'TMJ', 'https://vimeo.com/817941154', 'About 70% of the population have undiagnosed TMJ. Learn how to balance your TMJ.', 'active', '2026-03-31 00:24:30', '2026-03-31 00:24:30'),
(13, 'Stem Cell', 'https://vimeo.com/1072245011', 'New technology starting to make a difference in our lives', 'active', '2026-03-31 00:24:51', '2026-03-31 00:24:51'),
(14, 'Tongue', 'https://vimeo.com/817941027', 'The tongue aids in taste, speech, and swallowing.', 'active', '2026-03-31 00:25:11', '2026-03-31 00:25:11'),
(15, 'Fluoride', 'https://vimeo.com/817940425', 'Fluoride? A question', 'active', '2026-03-31 00:25:30', '2026-03-31 00:25:30'),
(16, 'Color Therapy', 'https://vimeo.com/817941240', 'Balance your chakras. Getting you healthy.', 'active', '2026-03-31 00:25:59', '2026-03-31 00:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `city`, `state`, `zip`, `country`, `address`, `phone`, `email`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(1, 'New York Office', 'New York', 'NY', '10065', 'USA', '580 Park Avenue Suite 1E', NULL, NULL, 40.7643600, -73.9675100, 'active', NULL, '2026-03-16 06:15:51'),
(2, 'Shokan Office', 'Shokan', 'NY', '12481', 'USA', '3103 Route 28', NULL, NULL, 41.9743000, -74.2113000, 'active', NULL, '2026-03-03 22:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `membership_name` varchar(255) DEFAULT NULL,
  `membership_price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `membership_period` varchar(255) DEFAULT NULL,
  `membership_description` text DEFAULT NULL,
  `membership_features` text DEFAULT NULL,
  `membership_benefits` text DEFAULT NULL,
  `popular` varchar(10) NOT NULL DEFAULT 'no',
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `membership_name`, `membership_price`, `membership_period`, `membership_description`, `membership_features`, `membership_benefits`, `popular`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Standard Membership', 183.00, 'Year', 'Our most popular plan for dedicated health enthusiasts', 'Access to 1pre-recorded lecture a month,All courses from partner doctors,$10 Discoun Vital boost,\r\nMonthly Live Zoom Session,3 free guides', 'Best value for money,Access to premium collaborator stores,VIP community status', 'no', 'inactive', '2026-01-31 09:16:59', '2026-03-27 07:43:03'),
(3, 'Premium Membership', 387.00, 'Year', 'Complete wellness transformation with personalized care', 'Access to all pre-recorded lectures for a year,$15 Discount Vital boost,Monthly Live Zoom Session,3 free books,10 free guides,Direct messaging with health experts,Custom supplement recommendations,Annual comprehensive health assessment', 'Highest level of personalized care,Direct expert access,Priority event registration', 'no', 'active', '2026-01-31 09:18:31', '2026-03-31 22:40:01'),
(7, 'Lifetime Membership', 799.00, 'Lifetime', 'Unlock the secrets to success with our Lifetime Access Membership', 'Access to all pre-recorded lectures for lifetime,$20 Discount Vital boost,Monthly Live Zoom Session,3 free books,10 free guides,50% off on consultations', 'Lifetime access to all premium videos,Special price for Vital Boost – only $37,Get personalized answers from industry experts,Members get extra value not available to others', 'yes', 'active', '2026-03-27 03:39:14', '2026-03-27 03:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_19_055244_create_collaborator_profiles_table', 1),
(5, '2025_11_19_061748_create_orders_table', 1),
(6, '2025_11_19_063411_create_audit_logs_table', 1),
(7, '2025_11_19_063834_create_site_settings_table', 1),
(8, '2025_11_19_073157_create_testimonials_table', 1),
(10, '2025_11_20_062102_create_personal_access_tokens_table', 1),
(11, '2025_11_20_062255_add_two_factor_columns_to_users_table', 1),
(12, '2025_11_26_113458_add_social_fields_to_users', 1),
(13, '2025_12_26_095636_create_subscribes_table', 1),
(14, '2025_12_26_100712_create_contacts_table', 1),
(15, '2025_12_29_095009_create_locations_table', 1),
(16, '2025_12_30_065746_create_stats_table', 1),
(17, '2025_12_30_070752_create_video_testimonials_table', 1),
(18, '2025_12_30_072038_create_testimonials_table', 1),
(19, '2025_12_30_093041_create_faq_categories_table', 1),
(21, '2025_12_30_101847_create_help_categories_table', 1),
(22, '2025_12_30_102133_create_help_articles_table', 1),
(23, '2025_12_30_102442_create_contact_options_table', 1),
(24, '2026_01_07_102812_create_products_table', 1),
(25, '2026_01_08_100526_create_courses_table', 1),
(26, '2026_01_13_095339_create_collaborators_table', 1),
(27, '2026_01_16_090433_add_status_to_users_table', 1),
(29, '2026_01_29_create_cart_sessions_table', 1),
(30, '2026_01_29_create_user_addresses_table', 1),
(31, '2026_02_02_093402_create_messages_table', 2),
(32, '2026_02_07_140910_add_session_timeout_to_site_settings_table', 3),
(34, '2026_02_10_135307_create_zoom_sessions_table', 4),
(35, '2026_02_13_174508_create_zoom_session_recorded_links_table', 5),
(37, '2026_02_16_114631_add_zoom_id_to_zoom_sessions_table', 6),
(38, '2026_02_17_171503_create_product_images_table', 7),
(39, '2026_02_18_172222_create_course_images_table', 8),
(40, '2026_02_18_173800_add_image_to_courses_table', 9),
(41, '2026_01_16_110648_create_web_settings_table', 10),
(42, '2026_03_01_091508_create_content_management_table', 11),
(43, '2026_03_03_130251_add_status_to_locations_table', 12),
(44, '2026_03_03_140703_add_zip_to_locations_table', 13),
(47, '2025_12_30_093214_create_f_a_q_s_table', 15),
(48, '2026_03_06_171625_create_intro_videos_table', 16),
(50, '2026_03_11_142719_create_payment_histories', 17),
(51, '2026_02_26_153732_add_status_to_memberships_table', 18),
(52, '2026_03_19_153600_add_stripe_customer_id_to_users_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('not','woman','man') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line_1` text DEFAULT NULL,
  `address_line_2` text DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `payment_method` enum('card','paypal','stripe','cod') NOT NULL DEFAULT 'card',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_method` varchar(20) DEFAULT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`shipping_address`)),
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`billing_address`)),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `address_line_1`, `address_line_2`, `city`, `state`, `zip_code`, `country`, `payment_method`, `subtotal`, `shipping_method`, `shipping_cost`, `tax`, `discount`, `total`, `status`, `payment_status`, `shipping_address`, `billing_address`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD_1774970611', 80, 'jonathon', 'osorio', 'upendracstech@gmail.com', '4707769618', 'wicklow dr', NULL, 'frisco', 'TX', '75034', 'US', 'stripe', 30.00, 'standard', 5.99, 0.00, 0.00, 35.99, 'pending', 'failed', '{\"user_id\":80,\"first_name\":\"jonathon\",\"last_name\":\"osorio\",\"email\":\"upendracstech@gmail.com\",\"phone\":\"4707769618\",\"address_line_1\":\"wicklow dr\",\"address_line_2\":null,\"city\":\"frisco\",\"state\":\"TX\",\"zip_code\":\"75034\",\"country\":\"US\"}', 'null', 'testing', '2026-03-31 22:23:31', '2026-03-31 22:23:40'),
(2, 'ORD_1774971268', 80, 'jonathon', 'osorio', 'upendracstech@gmail.com', '4707769618', 'wicklow dr', NULL, 'frisco', 'TX', '75034', 'US', 'stripe', 30.00, 'standard', 5.99, 0.00, 0.00, 35.99, 'pending', 'completed', '{\"first_name\":\"jonathon\",\"last_name\":\"osorio\",\"email\":\"upendracstech@gmail.com\",\"phone\":\"4707769618\",\"address_line_1\":\"wicklow dr\",\"address_line_2\":null,\"city\":\"frisco\",\"state\":\"TX\",\"zip_code\":\"75034\",\"country\":\"US\"}', 'null', 'testing', '2026-03-31 22:34:28', '2026-03-31 22:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `user_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 4, '3 E-BOOK SPECIAL', 1, 30.00, 30.00, '2026-03-31 22:23:31', '2026-03-31 22:23:31'),
(2, NULL, 2, 4, '3 E-BOOK SPECIAL', 1, 30.00, 30.00, '2026-03-31 22:34:29', '2026-03-31 22:34:29');

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
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'id of users table',
  `transaction_id` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `card_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`card_details`)),
  `invoice_detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`invoice_detail`)),
  `receipt_detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`receipt_detail`)),
  `payment_for` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_histories`
--

INSERT INTO `payment_histories` (`id`, `user_id`, `transaction_id`, `description`, `payment_method`, `amount`, `card_details`, `invoice_detail`, `receipt_detail`, `payment_for`, `status`, `created_at`, `updated_at`) VALUES
(1, 80, 'pi_3TH4K6JjF4BKIOdO0RgVcG1G', 'Order #ORD_1774971268', 'card', 35.99, '{\"brand\":\"visa\",\"last4\":\"4242\",\"exp_month\":12,\"exp_year\":2034}', '{\"invoice_id\":\"in_1TH4K8JjF4BKIOdO7kQulfZM\",\"invoice_number\":\"FT3DXWWT-0001\",\"invoice_pdf\":\"https:\\/\\/pay.stripe.com\\/invoice\\/acct_1O7jkEJjF4BKIOdO\\/test_YWNjdF8xTzdqa0VKakY0QktJT2RPLF9VRlpUZXJGR1dYekFQUTdlOTZrZWh5THIxT0Y0UmdaLDE2NTUxMjEzMg02001icdcT7n\\/pdf?s=ap\"}', '{\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/invoices\\/CAcaFwoVYWNjdF8xTzdqa0VKakY0QktJT2RPKMXTr84GMgaYFnNDAeI6LBa-HswEb91q5siAdrF0syMPzvZ513o2Yeizhn68-4xhTSLKPh4NAA__AWSw?s=ap\"}', 'order', 'succeeded', '2026-03-31 22:35:33', '2026-03-31 22:35:33'),
(2, 84, 'pi_3TH4YlJjF4BKIOdO1yvLGrGG', 'Premium Membership', 'card', 387.00, '{\"brand\":\"visa\",\"last4\":\"4242\",\"exp_month\":12,\"exp_year\":2034}', '{\"invoice_id\":\"in_1TH4YnJjF4BKIOdO0X5D3ubS\",\"invoice_number\":\"TXXQHQIT-0001\",\"invoice_pdf\":\"https:\\/\\/pay.stripe.com\\/invoice\\/acct_1O7jkEJjF4BKIOdO\\/test_YWNjdF8xTzdqa0VKakY0QktJT2RPLF9VRlppRkRkWGhrd0diY0hkYWxBb3Y0dGdCaGNIWmQxLDE2NTUxMzI5Mw02009uMJ2k11\\/pdf?s=ap\"}', '{\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/invoices\\/CAcaFwoVYWNjdF8xTzdqa0VKakY0QktJT2RPKM3cr84GMgbup458jBM6LBZM4kejhqggnwOGeaqts_-3FTY_BWBIPpM45-T4GAd7Bo1LNQLLxBGwgC5t?s=ap\"}', 'membership', 'succeeded', '2026-03-31 22:54:53', '2026-03-31 22:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
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
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount` varchar(255) NOT NULL DEFAULT '0',
  `originalPrice` varchar(255) NOT NULL DEFAULT '0',
  `category` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `reviews` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` longtext DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `product_type`, `name`, `description`, `price`, `discount`, `originalPrice`, `category`, `rating`, `reviews`, `stock_quantity`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'vital_boost', 'Vital Boost', 'Dr. Zeines created Vital Boost, a Superfood, specifically but not exclusively for his patients.\r\n\r\nVital Boost is not just a supplement; it\'s a revolution in your daily wellness routine. Crafted for the modern lifestyle, it\'s a powerhouse of phyto-nutrients and nutraceutical ingredients, all packed into one vegan-friendly formula. Whether you\'re looking to energize your day, bolster your immune system, or just improve overall health, Vital Boost is your go-to solution.', 57.00, '0', '0', 'vital_boost', NULL, NULL, 12, '1774601296_9YDtW4yjfp.webp', 'active', '2026-03-27 03:18:16', '2026-03-27 05:20:01'),
(3, 9, 'supplement', 'Vital Boost', 'VITAL BOOST – ELEVATE YOUR WELLNESS ROUTINE!\r\n\r\nExperience the revolutionary power of Vital Boost, your ultimate daily wellness companion. This exceptional supplement transcends typical multivitamins, offering a symphony of super foods in a vegan-friendly formula. Crafted for the demands of the modern lifestyle, Vital Boost is a potent blend of phyto-nutrients and nutraceutical ingredients to energize your day, fortify your immune system, and enhance your overall health.\r\n\r\nWHY CHOOSE VITAL BOOST?\r\n\r\nNutrient-Rich: A complete nutritional toolkit featuring antioxidants, digestive enzymes, probiotics, and herbal extracts.\r\n\r\nHealth Benefits Galore: Boost energy levels, metabolism, digestion, and immunity with this science-backed formula.\r\n\r\nEconomical Choice: Save on supplements with this all-in-one solution that prioritizes your well-being.\r\n\r\nCombat Everyday Challenges: Shield yourself from stress, pollution, and modern health hazards with Vital Boost.\r\n\r\nQuality Life Awaits: Notice a difference in vitality, energy, and overall well-being by incorporating Vital Boost into your daily routine.\r\n\r\nKEY FEATURES:\r\n\r\nSuper food Symphony: Organic spirulina, barley grass, wheat grass, spinach, and more packed into every serving.\r\n\r\nEasy Integration: Mix effortlessly into your smoothie or juice for a delicious and nutritious start to your day.\r\n\r\nDoctor-Approved: Developed with medical expertise and research to ensure safety and efficacy.\r\n\r\nFAQs Answered: Comprehensive blend of over 72 vital nutrients, catering to various dietary preferences.\r\n\r\nChoose Vital Boost for a transformative wellness experience that empowers you to live your best life every day. Unlock the vitality you deserve with Vital Boost!', 57.00, '0', '0', 'collaborator', NULL, NULL, 10, '1774609030_d5rreAvuAN.webp', 'active', '2026-03-27 05:27:10', '2026-03-27 05:27:10'),
(4, 9, 'book', '3 E-BOOK SPECIAL', 'Set out on an enlightening journey to optimal health with my exclusive 3-book bundle, all for the incredible price of just $19.99. Each book, meticulously crafted with your well-being in mind, unveils a different facet of the intricate relationship between oral health and overall vitality.\r\n\r\n“Living a Longer, Healthier Life” acts as your workbook companion to a luminous existence – a practical guide transforming the insights of “Dr. A’s Habits of Health” into actionable steps toward a more vibrant, healthier you.\r\n\r\nIn “Healthy Mouth, Healthy Body,” I, Dr. Zeines, delve into the profound connection between your oral wellness and systemic health, addressing the often-overlooked importance of the mouth in your body’s overall equilibrium and offering natural, effective solutions to boost your body’s inherent healing abilities.\r\n\r\nCompleting this trio, “Your Tongue Never Lies” leads you through the intriguing realm of tongue diagnosis – an ancient practice that provides clear insights into your health by merely examining the appearance of your tongue, guiding you toward better digestion, detoxification, and overall well-being.\r\n\r\nCollectively, these three books equip you with an arsenal of knowledge for anyone keen to take control of their health journey. Designed to be understood and applied with ease, the teachings within will empower you to harmonise with nature’s wisdom and engage the healing powers within. In the informative and trans-formative style you’ve come to expect from Dr. Zeines, these are more than books; they’re a blueprint for a healthier, intimately connected you, from the inside out.', 30.00, '0', '0', 'institute', NULL, NULL, 15, '1774609180_9WhM4ynQSO.webp', 'active', '2026-03-27 05:29:40', '2026-03-27 05:29:40'),
(5, 9, 'guide', 'Dr. Zeines Patient Guide: Tongues PDF', '“Your Tongue: The Gateway to Whole-Body Health”\r\n\r\nUnlock wellness with “Your Tongue: The Gateway to Whole-Body Health,” an insightful guide by holistic dentist Dr. Victor Zeines. Learn how oral health is a window to your body’s health, with practical tips for a healthier lifestyle.\r\n\r\nDiscover the role of nutrition and inflammation in your well-being and take control with Dr. Zeines’ expert advice. This concise guide is your key to healthier living through better oral care.\r\n\r\nStart your journey to vibrant health for just $5. Visit our eStore now.\r\n\r\nFind your guide to better health.', 5.00, '0', '0', 'institute', NULL, NULL, 10, '1774609543_vAJioJM1pf.webp', 'active', '2026-03-27 05:35:43', '2026-03-27 05:35:43'),
(6, 9, 'guide', 'Dr. Zeines Patient Guide: TMJ (Temporomandibular joint dysfunction) PDF', 'Discover the intricacies of TMJ with Dr. Victor Zeines’ “Patient Guide: TMJ.” This essential guide brings clarity to the perplexing condition of Temporomandibular Joint Dysfunction. Accessible for just $5 at the Institute for Living Longer and Dr. Zeines’ online stores. Begin your understanding by watching the introductory video available through this link.', 5.00, '0', '0', 'institute', NULL, NULL, 10, '1774610465_AgJ5p12KrX.webp', 'active', '2026-03-27 05:51:05', '2026-03-27 05:51:05'),
(7, 9, 'guide', 'Dr. Zeines Patient Guide: Root Canals PDF', 'Discover essential insights into oral health with “Dr. Zeines’s Patient Guide: Root Canals,” crafted to guide you through the intricate relationship between dental procedures and systemic well-being. This guide, in Neil Patel’s intelligible style as envisioned by Dr. Zeines, unfolds the concerning connections between root canals, mercury exposure from amalgams, and a range of systemic diseases, including cancer.\r\n\r\nDr. Zeines meticulously breaks down how mercury, a neuro-toxin found in amalgam fillings, poses a significant threat through daily exposure that far exceeds that from seafood. He aligns himself with the cautionary stances taken by countries like Germany, Sweden, and Denmark, which have restricted or banned mercury amalgams due to health concerns.\r\n\r\nRoot canals, described as safe havens for microbes, come under scrutiny for their potential to harbour infection-causing bacteria that desist the immune system’s reach. Dr. Zeines cites research indicating a high presence of root canals in cancer patients, suggesting a strong link between these dental procedures and recurring diseases.\r\n\r\nWith your oral health in mind, this guide advises on the complete removal of root canals and mercury amalgams. Encouraging the adoption of non-toxic materials like porcelain, Dr. Zeines emphasizes the importance of a holistic approach to dental care in achieving and maintaining systemic health. This essential guide is available for $5 in our eStore, offering a transformative outlook on the impact of dental choices on your overall health.', 5.00, '0', '0', 'institute', NULL, NULL, 20, '1774610640_qFbHdIBqdq.webp', 'active', '2026-03-27 05:54:00', '2026-03-27 05:54:00'),
(8, 9, 'guide', 'Dr. Zeines Patient Guide: Periodontal Health PDF', 'Dr. Zeines advances periodontal health with a holistic approach, tackling the complexities of gum disease with an array of non-surgical, non-invasive treatments. Beyond addressing bad breath, he delves into the root causes, emphasizing the significance of periodontal disease in relation to overall health. His methods prioritise minimal intervention, embracing the body’s natural healing processes while considering the impact of lifestyle factors like smoking, hormonal imbalances, and dietary habits.\r\n\r\nPatients of all ages benefit from Dr. Zeines’s expertise, as he tailors care to the individual, acknowledging the diverse influences on gum health, from stress to sports and even musical pursuits. In his care, prevention takes center stage through natural home care, lifestyle adjustments, and stress management, all aimed at empowering patients to maintain healthy gums and enhance their quality of life', 5.00, '0', '0', 'institute', NULL, NULL, 20, '1774610825_LJQiyPAGWr.webp', 'active', '2026-03-27 05:57:05', '2026-03-27 05:57:05'),
(9, 9, 'guide', 'Dr. Zeines Patient Guide: Magnets PDF', '“Dr. Zeines’s Patient Guide: Magnets,” part of Dr. Victor Zeines’s comprehensive collection on oral and overall health, provides pivotal insights into the world of magnetic therapy. Priced at a modest $5.00, this informative guide is available for download as a PDF from his website, offering patients a valuable resource at their fingertips.\r\n\r\nChronicling back to ancient Africa, the tradition of magnetic healing is explored, highlighting the revered use of magnetite for its remedial qualities. Dr. Zeines delves into the multitude of benefits that magnetic fields can offer, including enhanced circulation, pain relief, and the promotion of relaxation, alongside their potential to regulate bodily energy and alleviate inflammation.\r\n\r\nDr. Zeines’s unique integration of magnetic therapy with acupuncture is illuminated in this guide, revealing the synergistic power of these combined practices for a truly holistic approach to health management. Though he advises that the magnetic therapy’s scientific backing is still evolving, he presents it as an adjunct to mainstream medical treatments rather than a replacement.\r\n\r\nEmphasizing the necessity of informed healthcare decisions, Dr. Zeines encourages readers to use this guide as a stepping stone towards informed use of magnets for enhanced well-being. Always advocating for professional consultation, Dr. Zeines offers this guide as a way to explore magnetic therapy’s complementary benefits within a broader healing context.', 5.00, '0', '0', 'institute', NULL, NULL, 20, '1774610919_ufI9tYn8xU.webp', 'active', '2026-03-27 05:58:39', '2026-03-27 05:58:39'),
(10, 9, 'guide', 'Dr. Zeines Patient Guide: Mercury PDF', 'Take control of your health with Dr. Zeines Patient Guide: Mercury, a comprehensive and easy-to-understand digital resource designed to educate patients about mercury exposure and its impact on the body.', 5.00, '0', '0', 'institute', NULL, NULL, 10, '1774611112_UF9m4vXQSC.webp', 'active', '2026-03-27 06:01:00', '2026-03-27 06:04:53'),
(11, 9, 'guide', 'Dr. Zeines Patient Guide: Immune System PDF', 'Strengthen your understanding of how your body defends itself with Dr. Zeines Patient Guide: Immune System, a clear and practical digital resource designed to help you support and optimize your immune health.', 5.00, '0', '0', 'institute', NULL, NULL, 10, '1774611230_zPqmXTR4ST.webp', 'active', '2026-03-27 06:03:50', '2026-03-27 06:05:37'),
(13, 9, 'guide', 'Dr. Zeines Patient Guide: Herbs PDF', 'Dr. Zeines’s Patient Guide: Herbs” serves as an essential resource for those interested in the supportive benefits of herbal remedies for immune strength and overall health. While emphasizing the importance of professional consultation and personal research before beginning any herbal regimen, this guide offers a detailed exploration of various herbs and spices and their roles in promoting well-being.\r\n\r\nDr. Zeines, with his expertise in holistic health, has carefully curated this guide to provide comprehensive insights into the herbal world. He encourages readers to use it as a knowledgeable reference point while also reminding them of the importance of seeking tailored advice from healthcare professionals regarding any medical treatments or concerns.\r\n\r\nThe guide is a tool designed to empower patients with information about the potential of herbs in maintaining health and supporting the body’s natural defences. Dr. Zeines invites you to dive into this guide to discover more about the power of herbs as part of a holistic approach to health and wellness. Remember, informed use in conjunction with guidance from healthcare providers is key to safely integrating herbs into your healthcare routine.', 5.00, '0', '0', 'institute', NULL, NULL, 20, '1774611587_9b1p7dFl2E.webp', 'active', '2026-03-27 06:09:47', '2026-03-27 06:09:47'),
(14, 9, 'guide', 'Dr. Zeines Patient Guide: Fluoride PDF', 'Make informed decisions about your health with Dr. Zeines Patient Guide: Fluoride, a clear and informative digital resource designed to help you understand fluoride exposure and its effects on the body.\r\n\r\nThis easy-to-read PDF guide simplifies complex information, giving you practical knowledge about where fluoride is found, how it impacts your health, and how to manage your exposure safely.', 5.00, '0', '0', 'institute', NULL, NULL, 15, '1774611797_YcWRCm8DWJ.webp', 'active', '2026-03-27 06:12:31', '2026-03-27 06:13:17'),
(15, 9, 'guide', 'Dr. Zeines Patient Guide: Color Therapy PDF', 'Discover the healing potential of color with Dr. Zeines Patient Guide: Color Therapy, an insightful and easy-to-follow digital resource designed to help you understand how colors can influence your mood, energy, and overall well-being.\r\n\r\nThis downloadable PDF guide introduces the fundamentals of color therapy (chromotherapy) and shows you simple ways to incorporate it into your daily life for balance and relaxation.', 5.00, '0', '0', 'institute', NULL, NULL, 20, '1774611918_ghWpj1tB44.webp', 'active', '2026-03-27 06:15:18', '2026-03-27 06:15:18'),
(16, 9, 'guide', 'Dr. Zeines Patient Guide: Cancer PDF', 'Want a discount? Become a member by purchasing Membership – Tier One or Membership – Tier Two!', 5.00, '0', '0', 'institute', NULL, NULL, 10, '1774612027_LDJjYpceUg.webp', 'active', '2026-03-27 06:17:07', '2026-03-27 06:17:07'),
(17, 9, 'guide', 'Dr. Zeines Patient Guide: Acupuncture PDF', 'Explore the benefits of traditional healing with Dr. Zeines Patient Guide: Acupuncture, a clear and informative digital resource designed to help you understand how acupuncture supports balance, pain relief, and overall wellness.', 5.00, '0', '0', 'institute', NULL, NULL, 15, '1774612163_dNaSEuZqA8.webp', 'active', '2026-03-27 06:19:23', '2026-03-27 06:19:23'),
(18, 9, 'guide', 'Dr. Zeines Patient Guide: A Nutritional Primer PDF', 'Build a strong foundation for better health with Dr. Zeines Patient Guide: A Nutritional Primer, a practical and easy-to-understand digital resource designed to help you make smarter nutrition choices every day.\r\n\r\nThis comprehensive PDF guide simplifies the essentials of nutrition, giving you clear guidance on how food fuels your body, supports wellness, and promotes long-term health.', 5.00, '0', '0', 'institute', NULL, NULL, 10, '1774612282_0HGXWA9ymZ.webp', 'active', '2026-03-27 06:20:58', '2026-03-27 06:21:22'),
(19, 9, 'book', 'Living A Longer Life', 'There are so many books out there telling us how to eat healthy, live longer, lose weight, and make yourself look ten years younger, that you can go dizzy browsing the shelves of your bookstore trying to figure out which one to buy.\r\n \r\n\r\nAs both a holistic dentist and nutritionist for many years, that’s one of the reasons why I decided to write this book; to help cut through all the confusion and offer readers a common sense guide to feeling great, looking great, losing weight, and adding years to their lives.\r\n \r\n\r\nThis book will point you in the right direction. It is an easy-to-follow road map to achieving the excellent quality of life you desire, and is based on my own years of writing and lecturing about nutrition and dentistry. It also utilizes many of the concepts and courses offered at the institute of Natural Dentistry which graduates some of the nations best holistic dentists.\r\n \r\n\r\nLet me add that the alternative modalities mentioned in this book are per fectly safe. They are time-tested techniques that over the centuries have been proven to promote health and healing without any undo side effects. Of course, they should be used only in addition to your regular medical care.\r\n \r\n\r\nDr. Zeines has been practicing Holistic Dentistry for the past 25 years. He received his degree from N.Y.U College of Dentistry and completed and internship at Eastman Dental Center in Rochester New York.\r\n \r\n\r\nDr. Zeines always believed that dentistry needed to do more than just “fix teeth”. In 1980, he received a Master in Science (Nutrition) from the University of Bridgeport, Bridgeport, Connecticut. He received Fel- 1owship Status from the Academy of General Dentistry in 1982. An early article by Dr. Zeines called “Nutritional Eases Dental Problems”, published in 1980, talks about the link regarding oral and systemic health.', 10.00, '0', '0', 'institute', NULL, NULL, 15, '1774612509_X0bEo131du.webp', 'active', '2026-03-27 06:25:09', '2026-03-27 06:27:02'),
(20, 9, 'book', 'Healthy Mouth, Healthy Body', 'Your Dental Treatment May Be Harming You!.\r\nDid you know that conventional dental care often causes more harm than good-that treatments such as mercury dental fillings, root canals, and fluoride applications to disease, and auto-immune illnesses?.\r\n\r\nNow There’s A Better Way.\r\nIn this groundbreaking new book, Dr. Victor Zeines, D.D.S. shows how examining the mouth can reveql the presence of illnesses or unstable conditions in other areas of the body. He then offers safe, proven. therapies that enhance – not lessen -. the body’s own healing powers.\r\n\r\nAmong the highly effective Holistic approaches he uses are:\r\nAcupressure points to relieve tooth pain .\r\nHealing herbal mouth and gum rinses you can make yourself .\r\nNatural root canal methods for better results.\r\nA special novocaine that prevents palpitations .\r\nTMJ adjustment to restore proper tooth alignment. and alleviate headaches.\r\nA simple 8-step treatment to knock out gum disease.\r\nMinerals that reduce tooth sensitivity.', 10.00, '0', '0', 'institute', NULL, NULL, 18, '1774612608_wUklaSrDzm.webp', 'active', '2026-03-27 06:26:48', '2026-03-27 06:26:48'),
(21, 9, 'book', 'E-BOOK – YOUR TONGUE NEVER LIES – THE TRUTH THAT THE TONGUE REVEALS', 'YOUR TONGUE NEVER LIES\r\nIn this ground breaking book, Dr. Victor Zeines, a holistic dentist who uses homeopathy, kinesiology, nutritional counseling, and aromatic therapy in his practice, and author of “Healthy Teeth, Healthy Mouth,” clearly explains the significance of the tongue examina- tion and how it reflects the state of one’s health.\r\n \r\n\r\nAlthough there are several books on tongue analysis available, they are written for practitio- ners of Traditional Chinese Medicine. YOUR TONGUE NEVER LIES is unique in that it’s the first book written in easy-to-understand terminology and geared to the general public. Learn about a simple eight step treatment to reduce gum disease.\r\n \r\n\r\nThis book is unique in that it emphasizes how the problems seen on the tongue may be related to digestion, and how with proper detoxification and supplementation, the body can be put back on the road to health. This change for the better can also be monitored simply by looking at the tongue.\r\n \r\n\r\nWhile this book attempts to keep the focus on the method of tongue examination, it further serves as an introduction to the wider field of oriental diagnoses.\r\nThe ultimate goal of YOUR TONGUE NEVER LIES is to enable readers to have a better understanding of their own bodies. It opens their minds to ancient, but still relevant ideas pertaining to health. It is hoped that the ideas expressed in these pages will help readers link themselves to nature and gain exposure to new insights about healing.\r\n \r\n\r\nDr. Zeines has been practicing Holistic Dentistry for the past 25 completed and internship at Eastman Dental Center in Rochester New York. Dr. Zeines always believed that dentistry needed to do more than just “fix teeth”. In 1980, he received a Master in Science (Nutrition) from the University of Bridgeport, Bridgeport, Connecticut. He in 1982. An early article by Dr. Zeines called “Nutritional Eases Dental Problems”, published in 1980, talks about the link regarding oral and systemic health.. www.drvictorzeines.com', 10.00, '0', '0', 'institute', NULL, NULL, 15, '1774612757_8CbOqxeYKp.webp', 'active', '2026-03-27 06:29:17', '2026-03-27 06:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'id of products table',
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, '1774601296_9YDtW4yjfp.webp', '2026-03-27 03:18:16', '2026-03-27 03:18:16'),
(3, 3, '1774609030_d5rreAvuAN.webp', '2026-03-27 05:27:10', '2026-03-27 05:27:10'),
(4, 4, '1774609180_9WhM4ynQSO.webp', '2026-03-27 05:29:40', '2026-03-27 05:29:40'),
(5, 5, '1774609543_vAJioJM1pf.webp', '2026-03-27 05:35:43', '2026-03-27 05:35:43'),
(6, 6, '1774610465_AgJ5p12KrX.webp', '2026-03-27 05:51:05', '2026-03-27 05:51:05'),
(7, 7, '1774610640_qFbHdIBqdq.webp', '2026-03-27 05:54:00', '2026-03-27 05:54:00'),
(8, 8, '1774610825_LJQiyPAGWr.webp', '2026-03-27 05:57:05', '2026-03-27 05:57:05'),
(9, 9, '1774610919_ufI9tYn8xU.webp', '2026-03-27 05:58:39', '2026-03-27 05:58:39'),
(10, 10, '1774611060_oYjW2c5stP.webp', '2026-03-27 06:01:00', '2026-03-27 06:01:00'),
(11, 10, '1774611112_UF9m4vXQSC.webp', '2026-03-27 06:01:52', '2026-03-27 06:01:52'),
(12, 11, '1774611230_zPqmXTR4ST.webp', '2026-03-27 06:03:50', '2026-03-27 06:03:50'),
(14, 13, '1774611587_9b1p7dFl2E.webp', '2026-03-27 06:09:47', '2026-03-27 06:09:47'),
(15, 14, '1774611751_yaRmw3kKB1.webp', '2026-03-27 06:12:31', '2026-03-27 06:12:31'),
(16, 14, '1774611797_YcWRCm8DWJ.webp', '2026-03-27 06:13:17', '2026-03-27 06:13:17'),
(17, 15, '1774611918_ghWpj1tB44.webp', '2026-03-27 06:15:18', '2026-03-27 06:15:18'),
(18, 16, '1774612027_LDJjYpceUg.webp', '2026-03-27 06:17:07', '2026-03-27 06:17:07'),
(19, 17, '1774612163_dNaSEuZqA8.webp', '2026-03-27 06:19:23', '2026-03-27 06:19:23'),
(20, 18, '1774612258_KLkcqQRZbV.webp', '2026-03-27 06:20:58', '2026-03-27 06:20:58'),
(21, 18, '1774612282_0HGXWA9ymZ.webp', '2026-03-27 06:21:22', '2026-03-27 06:21:22'),
(22, 19, '1774612509_X0bEo131du.webp', '2026-03-27 06:25:09', '2026-03-27 06:25:09'),
(23, 20, '1774612608_wUklaSrDzm.webp', '2026-03-27 06:26:48', '2026-03-27 06:26:48'),
(24, 21, '1774612757_8CbOqxeYKp.webp', '2026-03-27 06:29:17', '2026-03-27 06:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5g6weKbZ6AoY5T75iszYZidAawEV2K2LWfraWlow', 84, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRk5CVUtTeHVXajJBcE1IT2FSOGlkZThxSDNYTHgydWhsekpFMUxvdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg0O30=', 1774972668),
('7F86eYQ63Yy5GcTd2jUYizLk4rb54nvQBlNUQrfn', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkZGVm5qaTFCYTZxS2tjNVNZdjdVcXJYcENRUGwwSTFlcTJ1RndQVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1774974544);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_description` longtext DEFAULT NULL,
  `contact_email` varchar(255) NOT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `session_timeout` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_description`, `contact_email`, `smtp_host`, `smtp_port`, `session_timeout`, `created_at`, `updated_at`) VALUES
(2, 'Institute for Living Longer - Your Journey to Wellness', 'Institute for Living Longer - Your Journey to Wellness', 'info@instituteforlivinglonger.com', NULL, NULL, NULL, NULL, '2026-03-23 13:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `number`, `label`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '10,000+', 'Active Members', 1, NULL, NULL),
(2, '4.9/5', 'Average Rating', 1, NULL, NULL),
(3, '95%', 'Satisfaction Rate', 1, NULL, NULL),
(4, '89%', 'Report Better Health', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `quote` text NOT NULL,
  `result` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `age`, `location`, `rating`, `quote`, `result`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Margaret Thompson', 68, 'Boston, MA', 5, 'After just 6 months with the Institute, my energy levels have increased dramatically. Dr. Zeines&amp;#039; approach to wellness has truly transformed my life. I feel 20 years younger!', 'Lost 25 lbs, improved mobility', 0, 1, NULL, '2026-03-23 13:08:13'),
(2, 'Robert Chen', 54, 'San Francisco, CA', 5, 'The collaborator network is incredible. I\'ve learned so much from Dr. Rodriguez about fitness and Dr. Chen about nutrition. My blood work has improved remarkably.', 'Reversed pre-diabetes', 1, 2, NULL, NULL),
(4, 'James Wilson', 71, 'Chicago, IL', 5, 'I was skeptical at first, but the science-based approach won me over. Dr. Zeines and his team provide clear, actionable advice that actually works.', 'Improved heart health markers', 1, 4, NULL, NULL),
(5, 'Patricia Davis', 59, 'Seattle, WA', 5, 'The community support is amazing. I\'ve made friends from all over the country who share the same wellness goals. We motivate each other daily.', 'Consistent exercise routine', 1, 5, NULL, '2026-03-06 00:59:52'),
(6, 'Michael Rodriguez', 66, 'Denver, CO', 5, 'Elite membership was the best investment Ive made in my health. The personalized consultations have helped me optimize my wellness plan perfectly.', 'Enhanced cognitive function', 1, 6, NULL, '2026-03-16 05:46:35'),
(7, 'Susan Anderson', 57, 'Austin, TX', 5, 'The video lessons are so well-produced and easy to understand. I love learning at my own pace and revisiting the content whenever I need a refresher.', 'Better nutrition habits', 0, 7, NULL, '2026-03-23 13:08:30'),
(8, 'David Park', 63, 'Portland, OR', 5, 'Dr. Zeines\' holistic approach addresses the whole person, not just symptoms. This is the healthcare model of the future, and I\'m grateful to be part of it.', 'Reduced inflammation', 1, 8, NULL, NULL),
(9, 'Carol Williams', 69, 'Phoenix, AZ', 5, 'The store products recommended by the collaborators are top-quality. I especially love the Vital Boost supplement - it&#039;s become a staple in my daily routine.', 'Increased vitality', 1, 9, NULL, '2026-03-23 04:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_image` text DEFAULT NULL,
  `speciality` varchar(255) DEFAULT NULL,
  `professional_credentials` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `collaborator_message` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `plan_id` int(11) NOT NULL DEFAULT 0,
  `plan_name` varchar(255) DEFAULT NULL,
  `plan_price` decimal(10,2) DEFAULT NULL,
  `plan_period` varchar(20) DEFAULT NULL,
  `plan_expiry` date DEFAULT NULL,
  `stripe_customer_id` varchar(255) DEFAULT NULL,
  `role` enum('super_admin','admin','member','collaborator','vendor','user') NOT NULL DEFAULT 'user',
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `profile_image`, `speciality`, `professional_credentials`, `experience`, `organization`, `website`, `collaborator_message`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `plan_id`, `plan_name`, `plan_price`, `plan_period`, `plan_expiry`, `stripe_customer_id`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, 'Deanna', 'Crossre', 'hynurixocu@mailinator.com', '+1 (489) 873-3043', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$/9WsU3DEakiFTU/qlEQMM.uzgqGK7eneQ1tf235ymY0K3kkHES1lO', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'admin', 'active', NULL, '2026-01-09 01:44:00', '2026-03-23 04:54:35'),
(80, 'Upendra', 'Kushwaha', 'upendracstech@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$zaANzSznTThQZgESdpekV.MViNTxz4/pFMObjyBcfvyqhTYfn131K', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'user', 'active', NULL, '2026-03-23 11:47:06', '2026-03-23 13:46:10'),
(82, 'Dr. Elena', 'Klimenko', 'test@institute.com', '9837492873', '1774618239.png', 'Test', 'test', '20', 'test', NULL, 'I grew up in Russia, where three significant experiences put me on the path to being the health practitioner I am today—an American board-certified medical doctor in internal medicine, licensed in medical acupuncture, who empowers patients to take charge of their health, using the tools of acupuncture, homeopathy, and functional medicine, supported by a deep understanding of both science and the mind-body-spirit connection.  Based on my training and experience, my philosophy of practice is grounded in an understanding of our bodies’ innate ability to heal.  I use tools that encourage natural healing. I treat the whole person, taking the time to discover underlying causes rather than merely prescribing pills to suppress symptoms.', NULL, '$2y$12$wn25aP.70rjKIjVBjgU8COi/RLTrqGaj47dkgTsGBhuqNswrAlYCG', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'collaborator', 'active', NULL, '2026-03-23 12:46:52', '2026-03-27 08:00:39'),
(84, 'Upendra', 'Kushwaha', 'ol53n2w8@maildropdm312.chetu.com', '4707769618', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$sL0hX/L5t6OzF3qRQnf.JuuIcOe2lkwldKv0Kk2Fo.wuiewgrLb2G', NULL, NULL, NULL, 3, 'Premium Membership', 387.00, 'Year', '2027-03-31', 'cus_UFZi2RTaSmyEtR', 'user', 'active', NULL, '2026-03-31 22:42:33', '2026-03-31 22:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_line_1` text DEFAULT NULL,
  `address_line_2` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'United States',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_billing` tinyint(1) NOT NULL DEFAULT 0,
  `address_type` varchar(255) NOT NULL DEFAULT 'shipping',
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `label`, `first_name`, `last_name`, `phone`, `email`, `address_line_1`, `address_line_2`, `city`, `state`, `zip_code`, `country`, `is_default`, `is_billing`, `address_type`, `bio`, `created_at`, `updated_at`) VALUES
(22, 9, NULL, 'Rhoda', 'Cox', '+1 (214) 506-6591', 'fuvu@mailinator.com', '582 White First Parkway', 'Ut mollit ducimus n', 'Error laboriosam re', 'Voluptate nostrum qu', 'Est eligendi qui ali', 'US', 0, 0, 'shipping', NULL, '2026-03-16 07:09:57', '2026-03-16 07:09:57'),
(23, 80, NULL, 'jonathon', 'osorio', '4707769618', 'upendracstech@gmail.com', 'wicklow dr', NULL, 'frisco', 'TX', '75034', 'US', 0, 0, 'shipping', NULL, '2026-03-31 22:23:10', '2026-03-31 22:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `video_testimonials`
--

CREATE TABLE `video_testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `quote` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_testimonials`
--

INSERT INTO `video_testimonials` (`id`, `video_url`, `thumbnail`, `quote`, `name`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(4, 'https://vimeo.com/1089923078', 'thumbnail_1774614616.png', 'I Learned a lot', 'Uriel Hampton', 1, 0, '2026-03-27 07:00:16', '2026-03-27 07:00:16'),
(5, 'https://vimeo.com/1089923006', 'thumbnail_1774614748.png', 'I love it a lot', 'Ciaran Warren', 1, 0, '2026-03-27 07:02:28', '2026-03-27 07:02:28'),
(6, 'https://vimeo.com/1089917979', 'thumbnail_1774614819.png', 'It really helped me.', 'Xenos Giles', 1, 0, '2026-03-27 07:03:39', '2026-03-27 07:03:39'),
(7, 'https://vimeo.com/1089889364', 'thumbnail_1774614885.png', 'IT CHANGED My LIFE..', 'Tanya Hawkins', 1, 0, '2026-03-27 07:04:45', '2026-03-27 07:04:45'),
(8, 'https://vimeo.com/1089889297', 'thumbnail_1774614945.png', 'Videos taught me so much..', 'Chester Adams', 1, 0, '2026-03-27 07:05:45', '2026-03-27 07:05:45'),
(9, 'https://vimeo.com/1089889212', 'thumbnail_1774615013.png', 'you should join..', 'Victor Nichols', 1, 0, '2026-03-27 07:06:53', '2026-03-27 07:06:53'),
(10, 'https://vimeo.com/1089874598', 'thumbnail_1774615130.png', 'i gave it 5 star..', 'Olga Mathews', 1, 0, '2026-03-27 07:08:50', '2026-03-27 07:08:50'),
(11, 'https://vimeo.com/1089874079', 'thumbnail_1774615193.png', 'i loved it so much..', 'Wanda Herrera', 1, 0, '2026-03-27 07:09:53', '2026-03-27 07:09:53'),
(12, 'https://vimeo.com/1089873882', 'thumbnail_1774615275.png', 'Fantastic..', 'Brenna Velasquez', 1, 0, '2026-03-27 07:11:15', '2026-03-27 07:11:15'),
(13, 'https://vimeo.com/1089873797', 'thumbnail_1774615329.png', 'IT CHANGED My LIFE..', 'Maxwell Dunn', 1, 0, '2026-03-27 07:12:09', '2026-03-27 07:12:09'),
(14, 'https://vimeo.com/1089873471', 'thumbnail_1774615379.png', 'i learned so much..', 'Reuben Sanders', 1, 0, '2026-03-27 07:12:59', '2026-03-27 07:12:59'),
(15, 'https://vimeo.com/1089873656', 'thumbnail_1774615428.png', 'Learned a lot..', 'Tyrone Wells', 1, 0, '2026-03-27 07:13:48', '2026-03-27 07:13:48'),
(16, 'https://vimeo.com/1089873165', 'thumbnail_1774615476.png', 'videos really helped me a lot..', 'Wesley Gutierrez', 1, 0, '2026-03-27 07:14:36', '2026-03-27 07:14:36'),
(17, 'https://vimeo.com/1089872998', 'thumbnail_1774615543.png', 'loved the videos..', 'Candace Harmon', 1, 0, '2026-03-27 07:15:43', '2026-03-27 07:15:43'),
(18, 'https://vimeo.com/1089872688', 'thumbnail_1774615613.png', 'IT CHANGED My LIFE..', 'Hillary Peck', 1, 0, '2026-03-27 07:16:53', '2026-03-27 07:16:53'),
(19, 'https://vimeo.com/1089833397', 'thumbnail_1774615660.png', 'I loved it a lot..', 'Alea Smith', 1, 0, '2026-03-27 07:17:40', '2026-03-27 07:17:40'),
(20, 'https://vimeo.com/1089830900', 'thumbnail_1774615697.png', 'IT helped Me so much..', 'Tana Britt', 1, 0, '2026-03-27 07:18:17', '2026-03-27 07:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `web_settings`
--

CREATE TABLE `web_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagline` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_settings`
--

INSERT INTO `web_settings` (`id`, `tagline`, `footer_text`, `logo`, `favicon`, `facebook_url`, `instagram_url`, `youtube_url`, `twitter_url`, `meta_title`, `meta_description`, `og_image`, `created_at`, `updated_at`) VALUES
(1, 'Institute for Living Longer - Your Journey to Wellness', 'This website’s content, including texts, graphics, and videos, is for informational purposes and should not replace professional medical advice, diagnosis, or treatment. Always seek advice from your healthcare provider for medical concerns or before starting new treatments. The views presented are Dr. Zeines’s, based on his dental and nutrition expertise, and may not reflect universal medical opinions. As oral health and overall health connections are still researched, we recommend consulting healthcare professionals for medical issues, and not solely relying on information from this site. Dr. Zeines and the creators of this website are not liable for any consequences stemming from treatments or dietary changes made based on the site’s content.', '', '', 'https://facebook.com/instituteforlivinglonger', 'https://instagram.com/instituteforlivinglonger', 'https://youtube.com/instituteforlivinglonger', 'https://twitter.com/instituteforlivinglonger', NULL, NULL, NULL, NULL, '2026-03-27 02:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `zoom_sessions`
--

CREATE TABLE `zoom_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `host` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'id of users table',
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `meeting_link` text DEFAULT NULL,
  `zoom_id` varchar(255) DEFAULT NULL,
  `meeting_response` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoom_sessions`
--

INSERT INTO `zoom_sessions` (`id`, `session_title`, `description`, `host`, `date`, `time`, `duration`, `meeting_link`, `zoom_id`, `meeting_response`, `created_at`, `updated_at`) VALUES
(1, 'Trading Class', 'testing', 80, '24-03-2026', '02:15 PM', '30 minutes', 'https://bikewrapt.com/instituteoflivinglonger/public/admin/zoom-sessions', '82668837633', '{\"uuid\":\"IQk0otgpS5O8xMeV+qPQjA==\",\"id\":82668837633,\"host_id\":\"mHn2V1L2RA6PTx3I0Rff6A\",\"host_email\":\"upendracstech@gmail.com\",\"topic\":\"Trading Class\",\"type\":2,\"status\":\"waiting\",\"start_time\":\"2026-03-24T08:45:00Z\",\"duration\":30,\"timezone\":\"Asia\\/Kolkata\",\"created_at\":\"2026-03-23T11:48:52Z\",\"start_url\":\"https:\\/\\/us05web.zoom.us\\/s\\/82668837633?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMiIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJpc3MiOiJ3ZWIiLCJjbHQiOjAsIm1udW0iOiI4MjY2ODgzNzYzMyIsImF1ZCI6ImNsaWVudHNtIiwidWlkIjoibUhuMlYxTDJSQTZQVHgzSTBSZmY2QSIsInppZCI6IjgzMDIwN2ZlZjcxZjQ3NGFiNmQ5MzkxNWE0ZjIxN2ZjIiwic2siOiIwIiwic3R5IjoxMDAsIndjZCI6InVzMDUiLCJleHAiOjE3NzQyNzM3MzIsImlhdCI6MTc3NDI2NjUzMiwiYWlkIjoiSmVod3M5WGdRNzJpZ0tfUjhFSzRmUSIsImNpZCI6IiJ9.O7jw9tZFSp0io15EikJfC_VQWNQLN5MTOJb9vw2RXbA\",\"join_url\":\"https:\\/\\/us05web.zoom.us\\/j\\/82668837633?pwd=OAohfIKzsyWqITHTUA8Nvl574QIlag.1\",\"password\":\"xV15DR\",\"h323_password\":\"736991\",\"pstn_password\":\"736991\",\"encrypted_password\":\"OAohfIKzsyWqITHTUA8Nvl574QIlag.1\",\"settings\":{\"host_video\":true,\"participant_video\":false,\"cn_meeting\":false,\"in_meeting\":false,\"join_before_host\":false,\"jbh_time\":0,\"mute_upon_entry\":false,\"watermark\":false,\"use_pmi\":false,\"approval_type\":2,\"audio\":\"voip\",\"auto_recording\":\"none\",\"auto_add_recording_to_video_management\":{\"enable\":false},\"enforce_login\":false,\"enforce_login_domains\":\"\",\"alternative_hosts\":\"\",\"alternative_host_update_polls\":false,\"alternative_host_manage_meeting_summary\":false,\"alternative_host_manage_cloud_recording\":false,\"close_registration\":false,\"show_share_button\":false,\"allow_multiple_devices\":false,\"registrants_confirmation_email\":true,\"waiting_room\":false,\"request_permission_to_unmute_participants\":false,\"registrants_email_notification\":true,\"meeting_authentication\":false,\"encryption_type\":\"enhanced_encryption\",\"approved_or_denied_countries_or_regions\":{\"enable\":false},\"breakout_room\":{\"enable\":false},\"internal_meeting\":false,\"continuous_meeting_chat\":{\"enable\":true,\"auto_add_invited_external_users\":false,\"auto_add_meeting_participants\":false,\"channel_id\":\"web_sch_5c60d83608ba4b35807cc544dec504ee\"},\"participant_focused_meeting\":false,\"push_change_to_calendar\":false,\"resources\":[],\"auto_start_meeting_summary\":false,\"auto_start_ai_companion_questions\":false,\"summary_template_id\":\"1e1356ad\",\"allow_host_control_participant_mute_state\":false,\"alternative_hosts_email_notification\":true,\"show_join_info\":false,\"device_testing\":false,\"focus_mode\":false,\"meeting_invitees\":[],\"private_meeting\":false,\"email_notification\":true,\"host_save_video_order\":false,\"sign_language_interpretation\":{\"enable\":false},\"email_in_attendee_report\":false},\"creation_source\":\"open_api\",\"pre_schedule\":false}', '2026-03-23 11:48:52', '2026-03-23 11:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `zoom_session_recorded_links`
--

CREATE TABLE `zoom_session_recorded_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zoom_session_table_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'id of zoom_sessions table',
  `recorded_link` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart_sessions`
--
ALTER TABLE `cart_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_sessions_session_id_unique` (`session_id`),
  ADD KEY `cart_sessions_user_id_index` (`user_id`),
  ADD KEY `cart_sessions_status_index` (`status`),
  ADD KEY `cart_sessions_expires_at_index` (`expires_at`),
  ADD KEY `cart_sessions_created_at_index` (`created_at`);

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `collaborators_email_unique` (`email`);

--
-- Indexes for table `collaborator_profiles`
--
ALTER TABLE `collaborator_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_options`
--
ALTER TABLE `contact_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management`
--
ALTER TABLE `content_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_courses_user_id` (`user_id`);

--
-- Indexes for table `course_images`
--
ALTER TABLE `course_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_images_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f_a_q_s`
--
ALTER TABLE `f_a_q_s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `f_a_q_s_faq_category_id_foreign` (`faq_category_id`);

--
-- Indexes for table `help_articles`
--
ALTER TABLE `help_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `help_articles_slug_unique` (`slug`),
  ADD KEY `help_articles_help_category_id_foreign` (`help_category_id`);

--
-- Indexes for table `help_categories`
--
ALTER TABLE `help_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `help_categories_slug_unique` (`slug`);

--
-- Indexes for table `intro_videos`
--
ALTER TABLE `intro_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_order_id_foreign` (`order_id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletters_email_unique` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_order_number_index` (`order_number`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_created_at_index` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `payment_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_index` (`user_id`),
  ADD KEY `user_addresses_is_default_index` (`is_default`),
  ADD KEY `user_addresses_created_at_index` (`created_at`);

--
-- Indexes for table `video_testimonials`
--
ALTER TABLE `video_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_settings`
--
ALTER TABLE `web_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zoom_sessions`
--
ALTER TABLE `zoom_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zoom_sessions_host_foreign` (`host`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_sessions`
--
ALTER TABLE `cart_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collaborator_profiles`
--
ALTER TABLE `collaborator_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_options`
--
ALTER TABLE `contact_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `content_management`
--
ALTER TABLE `content_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_images`
--
ALTER TABLE `course_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `f_a_q_s`
--
ALTER TABLE `f_a_q_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `help_articles`
--
ALTER TABLE `help_articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `help_categories`
--
ALTER TABLE `help_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `intro_videos`
--
ALTER TABLE `intro_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `video_testimonials`
--
ALTER TABLE `video_testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `web_settings`
--
ALTER TABLE `web_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zoom_sessions`
--
ALTER TABLE `zoom_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_sessions`
--
ALTER TABLE `cart_sessions`
  ADD CONSTRAINT `cart_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `course_images`
--
ALTER TABLE `course_images`
  ADD CONSTRAINT `course_images_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `f_a_q_s`
--
ALTER TABLE `f_a_q_s`
  ADD CONSTRAINT `f_a_q_s_faq_category_id_foreign` FOREIGN KEY (`faq_category_id`) REFERENCES `faq_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `help_articles`
--
ALTER TABLE `help_articles`
  ADD CONSTRAINT `help_articles_help_category_id_foreign` FOREIGN KEY (`help_category_id`) REFERENCES `help_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD CONSTRAINT `payment_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `zoom_sessions`
--
ALTER TABLE `zoom_sessions`
  ADD CONSTRAINT `zoom_sessions_host_foreign` FOREIGN KEY (`host`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
