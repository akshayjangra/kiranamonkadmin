-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2021 at 07:03 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutuspage`
--

CREATE TABLE `aboutuspage` (
  `about_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aboutuspage`
--

INSERT INTO `aboutuspage` (`about_id`, `title`, `description`) VALUES
(1, 'About Us', '<p><strong>About Us</strong><br />\r\nGogrocer&nbsp;&nbsp;is a online Delivery &nbsp;Mobile App as a Service. We are committed to nurturing a neutral platform and are helping food establishments maintain high standards through Hyperpure. Food Hygiene Ratings is a coveted mark of quality among our restaurant partners.c</p>');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `society` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `select_status` int(11) NOT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `admin_image`, `remember_token`) VALUES
(1, 'GoGrocer Admin', 'admin@demo.com', '$2y$10$VD8DroA2J31Zfsvhef3zUO7dwBeLlXMmmggstTzkzsZ6WdgtBC6UK', 'images/admin/profile/07-04-20/070420120712pm-604a0cadf94914c7ee6c6e552e9b4487-curved-check-mark-circle-icon-by-vexels.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_driver_incentive`
--

CREATE TABLE `admin_driver_incentive` (
  `id` int(11) NOT NULL,
  `incentive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_payouts`
--

CREATE TABLE `admin_payouts` (
  `payout_id` int(11) NOT NULL,
  `payout_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respond_payout_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payout_amt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_link`
--

CREATE TABLE `app_link` (
  `id` int(11) NOT NULL,
  `android_app_link` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_app_link` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_link`
--

INSERT INTO `app_link` (`id`, `android_app_link`, `ios_app_link`) VALUES
(1, 'fdgfdg', 'gdfgdfg');

-- --------------------------------------------------------

--
-- Table structure for table `app_notice`
--

CREATE TABLE `app_notice` (
  `app_notice_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `notice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_notice`
--

INSERT INTO `app_notice` (`app_notice_id`, `status`, `notice`) VALUES
(1, 1, 'This is Test Notice. Admin can change it.');

-- --------------------------------------------------------

--
-- Table structure for table `assign_homecat`
--

CREATE TABLE `assign_homecat` (
  `assign_id` int(11) NOT NULL,
  `homecat_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `callback_req`
--

CREATE TABLE `callback_req` (
  `callback_req_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `processed` int(11) NOT NULL,
  `date` date NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancel_for`
--

CREATE TABLE `cancel_for` (
  `res_id` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cancel_for`
--

INSERT INTO `cancel_for` (`res_id`, `reason`) VALUES
(6, 'TAKING TO MUCH TIME'),
(7, 'PRICE IS DIFFRENT FROM OTHER STORE'),
(8, 'Changed My Mind.'),
(9, 'NOT INTERESTED');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `varient_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart_payments`
--

CREATE TABLE `cart_payments` (
  `py_id` int(11) NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_rewards`
--

CREATE TABLE `cart_rewards` (
  `cart_rewards_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rewards` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `added_by` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closing_hours`
--

CREATE TABLE `closing_hours` (
  `closing_hrs_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_hrs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_hrs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country_code`
--

CREATE TABLE `country_code` (
  `code_id` int(11) NOT NULL,
  `country_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_code`
--

INSERT INTO `country_code` (`code_id`, `country_code`) VALUES
(1, 91);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `cart_value` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uses_restriction` int(11) NOT NULL DEFAULT 1,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_sign` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `currency_name`, `currency_sign`) VALUES
(1, 'INR', 'Rs');

-- --------------------------------------------------------

--
-- Table structure for table `deal_product`
--

CREATE TABLE `deal_product` (
  `deal_id` int(11) NOT NULL,
  `varient_id` int(11) NOT NULL,
  `deal_price` float NOT NULL,
  `valid_from` datetime NOT NULL,
  `valid_to` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `dboy_id` int(11) NOT NULL,
  `boy_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boy_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boy_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boy_loc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `store_dboy_id` int(11) NOT NULL DEFAULT 0,
  `added_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_rating`
--

CREATE TABLE `delivery_rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dboy_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_bank`
--

CREATE TABLE `driver_bank` (
  `ac_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_callback_req`
--

CREATE TABLE `driver_callback_req` (
  `callback_req_id` int(11) NOT NULL,
  `driver_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `driver_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `processed` int(11) NOT NULL,
  `date` date NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_incentive`
--

CREATE TABLE `driver_incentive` (
  `id` int(11) NOT NULL,
  `dboy_id` int(11) NOT NULL,
  `earned_till_now` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_till_now` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remaining` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_notification`
--

CREATE TABLE `driver_notification` (
  `not_id` int(11) NOT NULL,
  `not_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `not_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `dboy_id` int(11) NOT NULL,
  `read_by_driver` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` int(11) NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fcm`
--

CREATE TABLE `fcm` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_server_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_server_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fcm`
--

INSERT INTO `fcm` (`id`, `sender_id`, `server_key`, `store_server_key`, `driver_server_key`) VALUES
(1, '352076647507', 'AAAALdHobYs:APA91bEyCMIR4rVwubX1Gjhgfhf9FgvEpSNRPvwAse4UH7FdpKgPVfnb5T91vdHBpu-qJ6j3Dp0zTf87WMpnizQmPalkEFjHG0YMQYpFnqA5do66_jIYxQP3v7Y4mQ9y8xgm6THiVjBAbevPnV', 'AAAAuWPsAfc:APA91bGLj50jpj7BmvCgZxQjhjfTy;uhkghkdnWFJAIK_GIEpvE36tpN49pwkJcl36Fi4MdjV8YHZ_6Y2yPnN6OVHGsZWheYjG7tvKGpZ7krZkyY3T1CXGiui5BPrchgUbx75dD0z1TQLcgPjo9', 'AAAASjdx00M:APA91bFAyxYHVxdLDddghkghkYYZzTaB-lrLWfppDEVH_rpBt-z86s3kvwZsp7Z8vItKSX_hx2Ssvq2u6Nn02D2RGlVEUvzdD0RcBLuKjBnBbzevT8boWn5dYuzELRvPfXPwxb3kNS5GW5305b');

-- --------------------------------------------------------

--
-- Table structure for table `firebase`
--

CREATE TABLE `firebase` (
  `f_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `firebase`
--

INSERT INTO `firebase` (`f_id`, `status`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `firebase_iso`
--

CREATE TABLE `firebase_iso` (
  `iso_id` int(11) NOT NULL,
  `iso_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `firebase_iso`
--

INSERT INTO `firebase_iso` (`iso_id`, `iso_code`) VALUES
(1, 'INR');

-- --------------------------------------------------------

--
-- Table structure for table `freedeliverycart`
--

CREATE TABLE `freedeliverycart` (
  `id` int(11) NOT NULL,
  `min_cart_value` float NOT NULL DEFAULT 0,
  `del_charge` float NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freedeliverycart`
--

INSERT INTO `freedeliverycart` (`id`, `min_cart_value`, `del_charge`, `store_id`) VALUES
(1, 1000, 20, 0),
(2, 2000, 40, 37);

-- --------------------------------------------------------

--
-- Table structure for table `homecat`
--

CREATE TABLE `homecat` (
  `homecat_id` int(11) NOT NULL,
  `homecat_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `homecat_status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_space`
--

CREATE TABLE `image_space` (
  `space_id` int(11) NOT NULL,
  `digital_ocean` int(11) NOT NULL,
  `aws` int(11) NOT NULL,
  `same_server` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image_space`
--

INSERT INTO `image_space` (`space_id`, `digital_ocean`, `aws`, `same_server`) VALUES
(1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `img_base_url`
--

CREATE TABLE `img_base_url` (
  `url_id` int(11) NOT NULL,
  `base_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `img_base_url`
--

INSERT INTO `img_base_url` (`url_id`, `base_url`) VALUES
(1, 'https://gogrocer.tecmanic.com/');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licensebox`
--

CREATE TABLE `licensebox` (
  `id` int(11) NOT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installed_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_cart`
--

CREATE TABLE `list_cart` (
  `l_cid` int(11) NOT NULL,
  `l_vid` int(11) NOT NULL,
  `l_qty` int(11) NOT NULL,
  `l_uid` int(11) NOT NULL,
  `ord_by_photo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapbox`
--

CREATE TABLE `mapbox` (
  `map_id` int(11) NOT NULL,
  `mapbox_api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mapbox`
--

INSERT INTO `mapbox` (`map_id`, `mapbox_api`) VALUES
(1, 'pk.eyJ1IjoiYWppdDIzNSIsImEiOiJja2c1OTVpdjAwcmRzM');

-- --------------------------------------------------------

--
-- Table structure for table `map_api`
--

CREATE TABLE `map_api` (
  `id` int(11) NOT NULL,
  `map_api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_api`
--

INSERT INTO `map_api` (`id`, `map_api_key`) VALUES
(1, 'AIzaSyD6qfdfdsgvvhtghtVgUChH7AOrfI');

-- --------------------------------------------------------

--
-- Table structure for table `map_settings`
--

CREATE TABLE `map_settings` (
  `map_id` int(11) NOT NULL,
  `mapbox` int(11) NOT NULL,
  `google_map` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_settings`
--

INSERT INTO `map_settings` (`map_id`, `mapbox`, `google_map`) VALUES
(1, 0, 1);

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
(1, '2014_01_07_073615_create_tagged_table', 1),
(2, '2014_01_07_073615_create_tags_table', 1),
(3, '2016_06_29_073615_create_tag_groups_table', 1),
(4, '2016_06_29_073615_update_tags_table', 1),
(5, '2021_02_26_153036_create_jobs_table', 2),
(14, '2014_10_12_000000_create_users_table', 3),
(15, '2014_10_12_100000_create_password_resets_table', 3),
(16, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(17, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(18, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(19, '2016_06_01_000004_create_oauth_clients_table', 3),
(20, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(21, '2019_08_19_000000_create_failed_jobs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `minimum_maximum_order_value`
--

CREATE TABLE `minimum_maximum_order_value` (
  `min_max_id` int(100) NOT NULL,
  `min_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `minimum_maximum_order_value`
--

INSERT INTO `minimum_maximum_order_value` (`min_max_id`, `min_value`, `max_value`, `store_id`) VALUES
(1, '100', '2000', 38),
(2, '200', '5000', 37),
(3, '200', '5000', 40),
(5, '100', '10000', 43),
(6, '100', '10000', 44);

-- --------------------------------------------------------

--
-- Table structure for table `msg91`
--

CREATE TABLE `msg91` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `msg91`
--

INSERT INTO `msg91` (`id`, `sender_id`, `api_key`, `active`) VALUES
(1, 'GOGRCR', '35888tYHm8t2ftG45fe1d046P1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notificationby`
--

CREATE TABLE `notificationby` (
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sms` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `email` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00083c02f16a192fb7420243f8906043f58a873ef9ca230d9198390454efe0d8d98bb521c9f29489', 2, 1, 'token', '[]', 0, '2021-06-10 13:54:41', '2021-06-10 13:54:41', '2022-06-10 13:54:41'),
('0251de3a81f5c1d6e061bae4bbd0aec60d40dfeb47e909477e4e8b2ea0a4831c29065bff332297b1', 2, 1, 'token', '[]', 0, '2021-06-16 18:48:03', '2021-06-16 18:48:03', '2022-06-16 18:48:03'),
('035592cb3fb88216fc8fda697ce599fa149051811e1abd7d85e7ca722a66064ce03bc90f9fd745fc', 2, 1, 'token', '[]', 0, '2021-06-22 09:26:48', '2021-06-22 09:26:48', '2022-06-22 09:26:48'),
('083ce357e044463aa06c2b0ffdeb60db08879d2d5b69679d4b2b09e7b32216b79cc8b0a9b2813684', 2, 1, 'token', '[]', 0, '2021-06-17 11:25:29', '2021-06-17 11:25:29', '2022-06-17 11:25:29'),
('090ddb1aa2ecb804bf54e082c70b99f550fd8d55d57471fae750dfcd62989ae7279bc842f710fd9a', 2, 1, 'token', '[]', 0, '2021-06-22 14:36:50', '2021-06-22 14:36:50', '2022-06-22 14:36:50'),
('09192d5916c0dda236c6e58d2a6c276d13268e607cdc0956260bcd04b1eb572acd602a4378e2dede', 2, 1, 'token', '[]', 0, '2021-06-10 08:19:07', '2021-06-10 08:19:07', '2022-06-10 08:19:07'),
('09d5ab9b9a5c7f2ef864124f691babeb77b83799f7bf27617b47865aa4c0643633065757b0ba182e', 2, 1, 'token', '[]', 0, '2021-06-22 16:22:22', '2021-06-22 16:22:22', '2022-06-22 16:22:22'),
('0b61e47ae42788f9ed805e56b01b2f92981b2ac45357a7d2b28c058cc60d5cb3f7307a3e3d3a9166', 2, 1, 'token', '[]', 0, '2021-06-11 17:13:19', '2021-06-11 17:13:19', '2022-06-11 17:13:19'),
('0de82cbf1b0c60a1391aa5e6534e2e6f799dd907c39364092581753f1c61580ee7a4b3b587d8d413', 2, 1, 'token', '[]', 0, '2021-06-09 09:55:37', '2021-06-09 09:55:37', '2022-06-09 09:55:37'),
('14957f524184c653d485b7dd2c277cc5f6b16e3002323e72076208b3846643181cd9f43f128168ec', 2, 1, 'token', '[]', 0, '2021-06-22 14:36:23', '2021-06-22 14:36:23', '2022-06-22 14:36:23'),
('14d525b2356ab7332e9f3a799134185be36b7d7b530694c7fb82a67df80175e2267ff0ba59c4f347', 2, 1, 'token', '[]', 0, '2021-06-15 12:55:48', '2021-06-15 12:55:48', '2022-06-15 12:55:48'),
('178227ad695d0126ff7a77b022e94161613cfa4a0fafc0522507e081b06aa6c87b210da88efe49ac', 2, 1, 'token', '[]', 0, '2021-06-22 16:54:47', '2021-06-22 16:54:47', '2022-06-22 16:54:47'),
('18fd5330a446c2c017328004aaceb1a6f7120c36d81c221bee524df4fb56a59afb934d41764d5190', 2, 1, 'token', '[]', 0, '2021-06-16 16:58:45', '2021-06-16 16:58:45', '2022-06-16 16:58:45'),
('1c0b869b24d53af8e1bb984bd60e191cc5fea6da8671597cab00f027d34fe3e85ed2932d4650907f', 2, 1, 'token', '[]', 0, '2021-06-10 08:53:46', '2021-06-10 08:53:46', '2022-06-10 08:53:46'),
('25c05d4f918b648aa537b0e24f4beb77d2c2493ac9015a057839fcc837e810de5171a913fbe39eea', 2, 1, 'token', '[]', 0, '2021-06-09 08:06:11', '2021-06-09 08:06:11', '2022-06-09 08:06:11'),
('26c615c2bcc817903df9d6c5117c2974afccd736cd8125109b6cc9ef759955eb56a7c4ee752a4bfc', 2, 1, 'token', '[]', 0, '2021-06-15 21:36:30', '2021-06-15 21:36:30', '2022-06-15 21:36:30'),
('2720d625aeccc2d2f3e8128aa49889d710a68eb6cf105ff3de1c18a4dff655f17e8791af9e32eacd', 2, 1, 'token', '[]', 0, '2021-06-23 05:19:58', '2021-06-23 05:19:58', '2022-06-23 05:19:58'),
('296f32fe7ace52c8f37581d3468f76b03691aca78f83c9aa07f1545cea9f162f5110f560d36844c6', 2, 1, 'token', '[]', 0, '2021-06-16 18:43:46', '2021-06-16 18:43:46', '2022-06-16 18:43:46'),
('2d0b547a0a07e7bab78b38ed36bdc0ddb8969bd9854f74291621e2b7402de902bad1dac9944decb0', 2, 1, 'token', '[]', 0, '2021-06-19 01:32:56', '2021-06-19 01:32:56', '2022-06-19 01:32:56'),
('2e59702b0f04d036575e29ce408e2c162fe75e2db0855bdba1ea7f51f16307f698bad10ca9a6c54d', 2, 1, 'token', '[]', 0, '2021-06-22 16:48:44', '2021-06-22 16:48:44', '2022-06-22 16:48:44'),
('2fce4f4384b8c85c554514107bf6d34c61cd230f9ea6979237088dfef7f58156b746f471c115f30e', 2, 1, 'token', '[]', 0, '2021-06-23 03:38:43', '2021-06-23 03:38:43', '2022-06-23 03:38:43'),
('301f55ac7916fa76694678df97d5c43d723706f344f1d442ade938b4046f8e9ab3626c22b467a935', 2, 1, 'token', '[]', 0, '2021-06-22 13:20:17', '2021-06-22 13:20:17', '2022-06-22 13:20:17'),
('38707d8af2df52c08d1030744c65e88a3cfb1d73aaaf35c7c740b05e7ea02617d2a697052b2dc6b1', 2, 1, 'token', '[]', 0, '2021-06-21 11:01:36', '2021-06-21 11:01:36', '2022-06-21 11:01:36'),
('3c7f320e4da8ecfe8ca958b4afd903d836a08612a0e92717865328b8b2d0614e36623d5f643dfc2b', 2, 1, 'token', '[]', 0, '2021-06-22 18:14:28', '2021-06-22 18:14:28', '2022-06-22 18:14:28'),
('3cbe21838ca6366a36b3e92cf281ac755c7c2249b41d8f30f815f96f39ea3855ed7caf4abc6a1460', 2, 1, 'token', '[]', 0, '2021-06-22 09:43:47', '2021-06-22 09:43:47', '2022-06-22 09:43:47'),
('447177717297a67dac632cc15d65e884af795bc3c28266307cff14a9b74a4f0b9950bc913e014a80', 3, 1, 'token', '[]', 0, '2021-05-25 04:36:15', '2021-05-25 04:36:15', '2022-05-25 10:06:15'),
('456cfb9cf94544b1ff40af05a3bdd92474994b1c7aa7ea03b6d56efd2e8852be26a69003175fb92d', 2, 1, 'token', '[]', 0, '2021-06-21 15:09:26', '2021-06-21 15:09:26', '2022-06-21 15:09:26'),
('45f5a67a02729dd8e10d45ec00ddfab25e576d704ba2a6042271aa3e0946869c997196073f2bfcb2', 2, 1, 'token', '[]', 0, '2021-06-10 08:54:26', '2021-06-10 08:54:26', '2022-06-10 08:54:26'),
('4dc5a3d8d40648bb91bc1cd6c9b370ddd6f1dbbfab661dd77d29c7df8ad132471de6c44b48e230ed', 2, 1, 'token', '[]', 0, '2021-06-10 09:10:08', '2021-06-10 09:10:08', '2022-06-10 09:10:08'),
('4eb5807e53677eabf6d3da5af8c27a0d1bae66491d0634862af189a838b493f264c4ba1dbbdc9371', 2, 1, 'token', '[]', 0, '2021-06-17 10:08:20', '2021-06-17 10:08:20', '2022-06-17 10:08:20'),
('5090bc761baa98d925385422cd264579b3da9cf127e740f8394675130f79e8e77bfc3a1f9aa429b1', 2, 1, 'token', '[]', 0, '2021-06-22 09:01:38', '2021-06-22 09:01:38', '2022-06-22 09:01:38'),
('50e25fe24fe1bea47b191a77f55958cc684ec1375d1fe73614633f3287b6624332691b756832392a', 2, 1, 'token', '[]', 0, '2021-06-16 19:46:52', '2021-06-16 19:46:52', '2022-06-16 19:46:52'),
('5354ba2e8a1f7d81360b9f9683b87d3fd796b58c937025c0d058a4ad0feefa3897a510a0e1cd3387', 2, 1, 'token', '[]', 0, '2021-06-22 20:12:02', '2021-06-22 20:12:02', '2022-06-22 20:12:02'),
('5ae1fe89705459b25ee8e4e2a6e9e69a8b3d4102050c7f0f08a00cc49e024adf8b46c23dd9e345d2', 2, 1, 'token', '[]', 0, '2021-06-22 09:18:38', '2021-06-22 09:18:38', '2022-06-22 09:18:38'),
('5bc7dea1eae5270e27329032dd152e3140d0e83fd18ae81b5d0d625d1b14f636457a7b1cc24ef5e2', 2, 1, 'token', '[]', 0, '2021-06-09 10:49:57', '2021-06-09 10:49:57', '2022-06-09 10:49:57'),
('60853d2ba44b586882d794c851d58c3c03dfc5ad0d8c87aa8eb62b5c80ab289d11cd60b2a22c79cc', 2, 1, 'token', '[]', 0, '2021-06-20 16:43:31', '2021-06-20 16:43:31', '2022-06-20 16:43:31'),
('64665123d798f819e0fea7c2e7615ed5eda35e99ba4230d78548b6d3501079d5a53a5303d5cabe36', 2, 1, 'token', '[]', 0, '2021-06-22 07:23:56', '2021-06-22 07:23:56', '2022-06-22 07:23:56'),
('666e91a7e31f3f534a22e24704b7cd60c876d9ca53a2b4a26c7813f0a1228148b0799b94bf1ac76f', 2, 1, 'token', '[]', 0, '2021-06-11 15:42:20', '2021-06-11 15:42:20', '2022-06-11 15:42:20'),
('747ae780e8da747f9ca60a179c24e375fd9c4e00d5d6b6a389249eaa67ccbd720234b3dcaa79a1a2', 2, 1, 'token', '[]', 0, '2021-06-22 16:22:32', '2021-06-22 16:22:32', '2022-06-22 16:22:32'),
('74af31ae799a98a9bc4151ba8de0a80b08be90df5a7d62942ce9460c54c29b890effe42f1234b922', 2, 1, 'token', '[]', 0, '2021-06-22 18:41:47', '2021-06-22 18:41:47', '2022-06-22 18:41:47'),
('75b48fbb3697b06e2d3cd22886edd461a7698df072e3177d25b075d75b894dc76f8c11150c267c2f', 2, 1, 'token', '[]', 0, '2021-06-09 10:56:06', '2021-06-09 10:56:06', '2022-06-09 10:56:06'),
('7a8a106399030e6e4c1c0cde2f2ffc8cbfeb939929d7d3f2928e526f828722b29cffffb2cd29332f', 2, 1, 'token', '[]', 0, '2021-06-23 03:38:54', '2021-06-23 03:38:54', '2022-06-23 03:38:54'),
('7a96d629e65fdcd85f5781863b393447886f033754d976267d6ee8f5ece00a4152597e48c9b60ab8', 2, 1, 'token', '[]', 0, '2021-06-22 18:10:45', '2021-06-22 18:10:45', '2022-06-22 18:10:45'),
('7d015b83bc0692e00eed32f0662edf3df2436d6f3061dd6f3d234d26a831a28ca468eff2d54a11d4', 2, 1, 'token', '[]', 0, '2021-06-22 13:43:16', '2021-06-22 13:43:16', '2022-06-22 13:43:16'),
('812897d9746eac45399bdcb8d2d97a5c3ca5addc4266e36229cd218c4ea9e209899edd297a1560db', 2, 1, 'token', '[]', 0, '2021-06-19 20:19:33', '2021-06-19 20:19:33', '2022-06-19 20:19:33'),
('81e704758c6d53b4690d2c0bd5628e45a6dffa7c8f669404d65a9617733c656f7f7e8c2d096566f7', 2, 1, 'token', '[]', 0, '2021-06-15 20:24:13', '2021-06-15 20:24:13', '2022-06-15 20:24:13'),
('8acd4cc2fc855bbd296795b20d7b916a8704c80b8693ce03789c5f50de4d5b3a12d8982d4b778ee6', 2, 1, 'token', '[]', 0, '2021-06-22 19:08:26', '2021-06-22 19:08:26', '2022-06-22 19:08:26'),
('8b0cacef9fdf5970cb00c2d9f039729bd9c9b6b40ab7aa9035f0cd9a4d1657839ce4a550b17ee75a', 2, 1, 'token', '[]', 0, '2021-06-22 16:56:02', '2021-06-22 16:56:02', '2022-06-22 16:56:02'),
('90bc8d04b2ed7ef0570730124f53f338e3a9dc5f56d12cf154b901465cb9d5439f77bfb01436d32f', 2, 1, 'token', '[]', 0, '2021-06-10 08:52:13', '2021-06-10 08:52:13', '2022-06-10 08:52:13'),
('9458b4d5e44cbe4115651a017a64590203db0b565041b8fd06586bfbc52aab84c179e5b529012192', 2, 1, 'token', '[]', 0, '2021-06-22 11:02:20', '2021-06-22 11:02:20', '2022-06-22 11:02:20'),
('994e8a1fdc488f4738ef2fb117347cd483b6eeac3d390f233630240f471eb86384aba39cd3ad6d7c', 2, 1, 'token', '[]', 0, '2021-06-22 17:35:12', '2021-06-22 17:35:12', '2022-06-22 17:35:12'),
('9b400fcd3b8748d868e98ef0a9d2c9a54b66bf4a1698876c3bbb1d252fbd63d9e9343f689266cc91', 2, 1, 'token', '[]', 0, '2021-06-16 17:55:20', '2021-06-16 17:55:20', '2022-06-16 17:55:20'),
('9d41e93875c25afb25573039ff56eefabf644e68fb6a8f6d1b851db034352eaf5a360a5f1feacfef', 2, 1, 'token', '[]', 0, '2021-06-22 07:16:39', '2021-06-22 07:16:39', '2022-06-22 07:16:39'),
('a2737d5a78053eb3d28d44bb8487972ff6bf0788b4e330199483e6a629c8f5433dfa1b0a7aca69e7', 2, 1, 'token', '[]', 0, '2021-05-25 04:34:57', '2021-05-25 04:34:57', '2022-05-25 10:04:57'),
('a41ce57c1edbfd468d9fc64b8c4f43185414d733d85aa235516eedb250784de36bced061d1adc274', 2, 1, 'token', '[]', 0, '2021-06-11 14:04:32', '2021-06-11 14:04:32', '2022-06-11 14:04:32'),
('a56254a492bdf350dff0b30559b3c950a1ac36b2b7cb4e87b19c6a032aa70db800a296e454df6f87', 2, 1, 'token', '[]', 0, '2021-06-09 09:05:12', '2021-06-09 09:05:12', '2022-06-09 09:05:12'),
('a58d18068b6141475701723493e956f9ae7229c2fce74f3cf22cff7a81ac4d77c16570f13ce40e52', 2, 1, 'token', '[]', 0, '2021-06-22 17:40:53', '2021-06-22 17:40:53', '2022-06-22 17:40:53'),
('ab63eb184da5ed96ada86f9a6f56f0a7b0de1cad4a6d78d98fe425fd441419fcabcbd9dddb8ff870', 2, 1, 'token', '[]', 0, '2021-06-22 19:43:59', '2021-06-22 19:43:59', '2022-06-22 19:43:59'),
('abcd8db0900b93ce5d31e0f84cff346b2d8bf032adcbc20b856651ac06d6138d3c8d631ac7f6b4a8', 2, 1, 'token', '[]', 0, '2021-06-22 05:28:06', '2021-06-22 05:28:06', '2022-06-22 05:28:06'),
('b24f546b22473eb4232a7731d63f9b31e5a003c3d1770e1b4cab8d127278406aab76da7d64b31a75', 2, 1, 'token', '[]', 0, '2021-06-09 09:05:12', '2021-06-09 09:05:12', '2022-06-09 09:05:12'),
('b319888466ef95dabeaf7ef10dfd169c9a82e87219be48673181ab9d239a35c3854aced278784c18', 2, 1, 'token', '[]', 0, '2021-06-22 07:36:01', '2021-06-22 07:36:01', '2022-06-22 07:36:01'),
('b682575dd58b1683723116a7cf28db77fadcb3214c921810c2f5c8769ecf6ad5edcea8cefa72644d', 1, 1, 'token', '[]', 0, '2021-05-25 04:32:03', '2021-05-25 04:32:03', '2022-05-25 10:02:03'),
('bb8419b3b03abb470805bf94e1730e401e2cf5043bc8e698ecb568571b2393db7672630c62848a13', 2, 1, 'token', '[]', 0, '2021-06-23 03:38:39', '2021-06-23 03:38:39', '2022-06-23 03:38:39'),
('bf73630ee3b02486f1bcac148eb7a7b2d1b232b1169d64c6890cbff540b7cb39b761472faf8dc52d', 2, 1, 'token', '[]', 0, '2021-06-22 18:15:55', '2021-06-22 18:15:55', '2022-06-22 18:15:55'),
('bf79a531f0686f607edf9310fe402f61c072f61cd2763579224969e5fae5b9d34ecd9328f007335c', 2, 1, 'token', '[]', 0, '2021-06-22 18:49:12', '2021-06-22 18:49:12', '2022-06-22 18:49:12'),
('c8d8491a290a98ee4ffbdb025682f2516dc393e70b92a80784bf45b17edf495a813add79b768f0dc', 2, 1, 'token', '[]', 0, '2021-06-09 08:12:03', '2021-06-09 08:12:03', '2022-06-09 08:12:03'),
('c987770f59d9e45dc2f3ea03d07618cccb9f14fa70d24e08fa7d774d92d557b570bfdea2f67df122', 2, 1, 'token', '[]', 0, '2021-06-22 10:10:45', '2021-06-22 10:10:45', '2022-06-22 10:10:45'),
('ca16f51ae5fd646e4de8f3d7e2e997df336568651b0e38845b463b5a1d0d391e7b3e41dd72635e13', 2, 1, 'token', '[]', 0, '2021-06-19 22:54:46', '2021-06-19 22:54:46', '2022-06-19 22:54:46'),
('ce9a7c48fdc6e20219f245e69b26430bcf710eac6dd280838beb241694ef27eaff8eb03fd6b0010b', 2, 1, 'token', '[]', 0, '2021-06-22 10:44:37', '2021-06-22 10:44:37', '2022-06-22 10:44:37'),
('cfa116d8d4744cde4a82d8647863a48cecdcece54ac3bf7f0f8dc618b1b6aea3e99c0f1e7fed1f7d', 2, 1, 'token', '[]', 0, '2021-06-10 13:22:01', '2021-06-10 13:22:01', '2022-06-10 13:22:01'),
('d667098b636fcd76d065b19dc8db0d0ea4567661673e7d59b879566fc7ec37e8083d7b20d154ef61', 2, 1, 'token', '[]', 0, '2021-06-22 16:14:54', '2021-06-22 16:14:54', '2022-06-22 16:14:54'),
('d81935c325f971c61654ebb272b529fd332bf4838614cc1033c493fd1dac7f5de2b330f71e217dba', 2, 1, 'token', '[]', 0, '2021-06-22 11:21:15', '2021-06-22 11:21:15', '2022-06-22 11:21:15'),
('dae1c565849ac046781f8a3e487bf57d74fdb3ef8c60508acfdc7ff09f6e5eaa4587c15ff96eab02', 2, 1, 'token', '[]', 0, '2021-06-22 16:26:40', '2021-06-22 16:26:40', '2022-06-22 16:26:40'),
('df8f9ebbfee2bc77a093c80cd4613ebcbcf9f3518be833088b32901cb3ac08c6d16555eca6b68f28', 2, 1, 'token', '[]', 0, '2021-06-16 18:12:47', '2021-06-16 18:12:47', '2022-06-16 18:12:47'),
('df986ffaccd84e39df602ffb3b0c4450a067d4f0ac10804314ba4465bea5ac6e933d9451cdec3f57', 2, 1, 'token', '[]', 0, '2021-06-20 14:58:59', '2021-06-20 14:58:59', '2022-06-20 14:58:59'),
('e33b70515cc48603278ca7bebda17c76766be99e2da9297c9efe3c373e8fe3c104427f9c349534ea', 2, 1, 'token', '[]', 0, '2021-06-22 15:47:01', '2021-06-22 15:47:01', '2022-06-22 15:47:01'),
('f521eece7cd015bba975f20da97415385c67e649966437bf8f4d130f32fddcf0b59cfa4e12daac24', 2, 1, 'token', '[]', 0, '2021-06-19 18:55:30', '2021-06-19 18:55:30', '2022-06-19 18:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(11) UNSIGNED NOT NULL,
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
(1, NULL, 'Laravel Personal Access Client', 'KM0Ibsw47XWFhuBxsBdLUSuDY97epilSaZlqU72D', NULL, 'http://localhost', 1, 0, 0, '2021-05-25 02:14:22', '2021-05-25 02:14:22'),
(2, NULL, 'Laravel Password Grant Client', 'qAtMRgb4oCqL5U1E5Z43MpBYa2RSI6Pp40HMabYT', 'users', 'http://localhost', 0, 1, 0, '2021-05-25 02:14:22', '2021-05-25 02:14:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-05-25 02:14:22', '2021-05-25 02:14:22');

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` float NOT NULL,
  `price_without_delivery` float NOT NULL,
  `total_products_mrp` float NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_by_wallet` float NOT NULL DEFAULT 0,
  `rem_price` float NOT NULL DEFAULT 0,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_charge` float NOT NULL DEFAULT 0,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dboy_id` int(11) NOT NULL DEFAULT 0,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `user_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelling_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT 0,
  `coupon_discount` float NOT NULL DEFAULT 0,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_by_store` int(11) NOT NULL DEFAULT 0,
  `dboy_incentive` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_by_photo`
--

CREATE TABLE `order_by_photo` (
  `ord_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `list_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `processed` int(11) NOT NULL DEFAULT 0,
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Table structure for table `payout_requests`
--

CREATE TABLE `payout_requests` (
  `req_id` int(11) NOT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payout_amt` float NOT NULL,
  `req_date` date NOT NULL,
  `complete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payout_req_valid`
--

CREATE TABLE `payout_req_valid` (
  `val_id` int(11) NOT NULL,
  `min_amt` int(11) NOT NULL,
  `min_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payout_req_valid`
--

INSERT INTO `payout_req_valid` (`val_id`, `min_amt`, `min_days`) VALUES
(1, 100, 10);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Regular',
  `hide` int(11) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `approved` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_rating`
--

CREATE TABLE `product_rating` (
  `rate_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `varient_id` int(11) NOT NULL,
  `rating` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_varient`
--

CREATE TABLE `product_varient` (
  `varient_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_mrp` float DEFAULT NULL,
  `base_price` float NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ean` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` int(11) NOT NULL DEFAULT 1,
  `added_by` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_key`
--

CREATE TABLE `razorpay_key` (
  `key_id` int(11) NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `razorpay_key`
--

INSERT INTO `razorpay_key` (`key_id`, `api_key`) VALUES
(1, 'rzp_test_K4YMcaRBxfhthfgh');

-- --------------------------------------------------------

--
-- Table structure for table `reedem_values`
--

CREATE TABLE `reedem_values` (
  `reedem_id` int(11) NOT NULL,
  `reward_point` int(100) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reedem_values`
--

INSERT INTO `reedem_values` (`reedem_id`, `reward_point`, `value`) VALUES
(1, 2, '0.30');

-- --------------------------------------------------------

--
-- Table structure for table `referral_points`
--

CREATE TABLE `referral_points` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `points` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referral_points`
--

INSERT INTO `referral_points` (`id`, `name`, `points`, `created_at`, `updated_at`) VALUES
(5, 'Registration Referral', '{\"min\":\"1\",\"max\":\"15\"}', '2021-12-17 09:50:21', '2021-01-25 13:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `reward_points`
--

CREATE TABLE `reward_points` (
  `reward_id` int(11) NOT NULL,
  `min_cart_value` int(100) NOT NULL,
  `reward_point` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_points`
--

INSERT INTO `reward_points` (`reward_id`, `min_cart_value`, `reward_point`) VALUES
(3, 10, 1),
(4, 1000, 450);

-- --------------------------------------------------------

--
-- Table structure for table `secondary_banner`
--

CREATE TABLE `secondary_banner` (
  `sec_banner_id` int(11) NOT NULL,
  `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(31, 'paypal_active', 'No', '2020-11-18 13:56:42', '2021-02-15 16:32:58'),
(32, 'paypal_email', 'deekhati63@gmail.com', '2020-11-18 13:56:42', '2021-02-08 15:59:27'),
(34, 'stripe_active', 'No', '2020-11-18 13:56:42', '2021-02-15 16:32:58'),
(35, 'stripe_secret_key', 'sk_test_51HzzheJi3WFPjQpEK6E8IPvB0qKXCpnebiMSu1JmKeioveuTbKHfONn5VT1eIfQfJdCr4C1rg1VOoLp3b6DkeqdC006aUfoP', '2020-11-18 13:56:42', '2021-06-09 05:49:49'),
(36, 'stripe_publishable_key', 'pk_test_51HzzheJi3WFPjQpEVSPqOTgVcICnxl9BnVPj9o2xp0ZJxNeHTz0hVNYrG5NPFvx44H6B6ihZcKd76hkT2KEHmnsG00N6', '2020-11-18 13:56:42', '2021-06-09 05:49:49'),
(38, 'razorpay_active', 'Yes', '2020-11-18 13:56:42', '2021-02-15 16:32:58'),
(39, 'razorpay_key_id', 'rzp_test_jVjEcwvzJZj', '2020-11-18 13:56:42', '2021-06-09 05:49:49'),
(40, 'razorpay_secret_key', 'k1Sw8Ne5czWoJ27f4S2WdBTl', '2020-11-18 13:56:42', '2021-06-09 05:49:49'),
(42, 'paystack_active', 'No', '2020-11-18 13:56:42', '2021-02-15 16:32:58'),
(43, 'paystack_public_key', 'dg', '2020-11-18 13:56:42', '2021-06-09 05:49:50'),
(44, 'paystack_secret_key', 'sdgdgdsg', '2020-11-18 13:56:42', '2021-06-09 05:49:50'),
(61, 'paypal_client_id', 'efsdgfdhdfhf', '2021-02-15 16:32:58', '2021-06-09 05:49:49'),
(62, 'paypal_secret_key', 'sdgdhfdhsfhhsf', '2021-02-15 16:32:58', '2021-06-09 05:49:49'),
(63, 'stripe_merchant_id', 'acct_1HzzheJi3WFPjQpE', '2021-03-11 15:44:01', '2021-06-09 05:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `smsby`
--

CREATE TABLE `smsby` (
  `by_id` int(11) NOT NULL,
  `msg91` int(11) NOT NULL DEFAULT 1,
  `twilio` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smsby`
--

INSERT INTO `smsby` (`by_id`, `msg91`, `twilio`, `status`) VALUES
(1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `society`
--

CREATE TABLE `society` (
  `society_id` int(11) NOT NULL,
  `society_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_share` float NOT NULL DEFAULT 0,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del_range` float NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_approval` int(11) NOT NULL DEFAULT 1,
  `orders` int(11) NOT NULL DEFAULT 1,
  `store_status` int(11) NOT NULL DEFAULT 1,
  `store_opening_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_closing_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_interval` int(11) NOT NULL,
  `inactive_reason` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_assign_homecat`
--

CREATE TABLE `store_assign_homecat` (
  `assign_id` int(11) NOT NULL,
  `homecat_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_bank`
--

CREATE TABLE `store_bank` (
  `ac_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_banner`
--

CREATE TABLE `store_banner` (
  `banner_id` int(100) NOT NULL,
  `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'H'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_callback_req`
--

CREATE TABLE `store_callback_req` (
  `callback_req_id` int(11) NOT NULL,
  `store_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `processed` int(11) NOT NULL,
  `date` date NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_delivery_boy`
--

CREATE TABLE `store_delivery_boy` (
  `dboy_id` int(11) NOT NULL,
  `boy_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boy_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boy_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boy_loc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `store_id` int(11) NOT NULL,
  `added_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'store',
  `ad_dboy_id` int(11) NOT NULL DEFAULT 0,
  `rem_by_admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_doc`
--

CREATE TABLE `store_doc` (
  `doc_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_driver_incentive`
--

CREATE TABLE `store_driver_incentive` (
  `id` int(11) NOT NULL,
  `incentive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_earning`
--

CREATE TABLE `store_earning` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `paid` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_homecat`
--

CREATE TABLE `store_homecat` (
  `homecat_id` int(200) NOT NULL,
  `homecat_name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `homecat_status` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_notification`
--

CREATE TABLE `store_notification` (
  `not_id` int(11) NOT NULL,
  `not_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `not_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `read_by_store` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_orders`
--

CREATE TABLE `store_orders` (
  `store_order_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` float NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `total_mrp` float NOT NULL,
  `order_cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` datetime NOT NULL,
  `store_approval` int(11) NOT NULL DEFAULT 1,
  `store_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_products`
--

CREATE TABLE `store_products` (
  `p_id` int(11) NOT NULL,
  `varient_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `mrp` float NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_society`
--

CREATE TABLE `store_society` (
  `store_society_id` int(11) NOT NULL,
  `society_id` int(100) NOT NULL,
  `store_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tagged`
--

CREATE TABLE `tagging_tagged` (
  `id` int(10) UNSIGNED NOT NULL,
  `taggable_id` int(10) UNSIGNED NOT NULL,
  `taggable_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_slug` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tags`
--

CREATE TABLE `tagging_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_group_id` int(10) UNSIGNED DEFAULT NULL,
  `slug` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suggest` tinyint(1) NOT NULL DEFAULT 0,
  `count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tag_groups`
--

CREATE TABLE `tagging_tag_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_referral`
--

CREATE TABLE `tbl_referral` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referral_by` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_top_cat`
--

CREATE TABLE `tbl_top_cat` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `cat_rank` int(11) NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_setting`
--

CREATE TABLE `tbl_web_setting` (
  `set_id` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_limit` int(11) NOT NULL,
  `last_loc` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_web_setting`
--

INSERT INTO `tbl_web_setting` (`set_id`, `icon`, `name`, `favicon`, `number_limit`, `last_loc`) VALUES
(1, '/images/app_logo/app_icon/22-06-2021/imgingest-2046930042948365474.png', 'GoGrocer', '/images/app_logo/app_icon/22-06-2021/imgingest-2046930042948365474.png', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `termspage`
--

CREATE TABLE `termspage` (
  `terms_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `termspage`
--

INSERT INTO `termspage` (`terms_id`, `title`, `description`) VALUES
(1, 'Terms & Condition', '<table cellspacing=\"0\" id=\"datatables\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>\r\n			<p><strong>Terms and Conditions</strong></p>\r\n\r\n			<p>Last Updated: 05&nbsp;May 2021</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` int(11) NOT NULL,
  `open_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `close_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `twilio`
--

CREATE TABLE `twilio` (
  `twilio_id` int(11) NOT NULL,
  `twilio_sid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twilio_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twilio_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `twilio`
--

INSERT INTO `twilio` (`twilio_id`, `twilio_sid`, `twilio_token`, `twilio_phone`, `active`) VALUES
(1, 'AC3eb584f35ee74e27383ccb2', 'b47641f04f129ba6bbc2fefda269d7a8', '+1334 402 4974', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `user_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `wallet` float NOT NULL DEFAULT 0,
  `rewards` int(11) NOT NULL DEFAULT 0,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `block` int(11) NOT NULL DEFAULT 2,
  `reg_date` date NOT NULL,
  `app_update` int(11) NOT NULL DEFAULT 1,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `noti_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noti_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_by_user` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_support`
--

CREATE TABLE `user_support` (
  `supp_id` int(11) NOT NULL,
  `query` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_recharge_history`
--

CREATE TABLE `wallet_recharge_history` (
  `wallet_recharge_history` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recharge_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` float NOT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_recharge` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `websitelink`
--

CREATE TABLE `websitelink` (
  `id` int(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wish_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `varient_id` int(11) NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutuspage`
--
ALTER TABLE `aboutuspage`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_driver_incentive`
--
ALTER TABLE `admin_driver_incentive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  ADD PRIMARY KEY (`payout_id`);

--
-- Indexes for table `app_link`
--
ALTER TABLE `app_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_notice`
--
ALTER TABLE `app_notice`
  ADD PRIMARY KEY (`app_notice_id`);

--
-- Indexes for table `assign_homecat`
--
ALTER TABLE `assign_homecat`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `callback_req`
--
ALTER TABLE `callback_req`
  ADD PRIMARY KEY (`callback_req_id`);

--
-- Indexes for table `cancel_for`
--
ALTER TABLE `cancel_for`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `varient_id` (`varient_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_payments`
--
ALTER TABLE `cart_payments`
  ADD PRIMARY KEY (`py_id`);

--
-- Indexes for table `cart_rewards`
--
ALTER TABLE `cart_rewards`
  ADD PRIMARY KEY (`cart_rewards_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `closing_hours`
--
ALTER TABLE `closing_hours`
  ADD PRIMARY KEY (`closing_hrs_id`);

--
-- Indexes for table `country_code`
--
ALTER TABLE `country_code`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_product`
--
ALTER TABLE `deal_product`
  ADD PRIMARY KEY (`deal_id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`dboy_id`);

--
-- Indexes for table `delivery_rating`
--
ALTER TABLE `delivery_rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `driver_bank`
--
ALTER TABLE `driver_bank`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `driver_callback_req`
--
ALTER TABLE `driver_callback_req`
  ADD PRIMARY KEY (`callback_req_id`);

--
-- Indexes for table `driver_incentive`
--
ALTER TABLE `driver_incentive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_notification`
--
ALTER TABLE `driver_notification`
  ADD PRIMARY KEY (`not_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcm`
--
ALTER TABLE `fcm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `firebase`
--
ALTER TABLE `firebase`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `firebase_iso`
--
ALTER TABLE `firebase_iso`
  ADD PRIMARY KEY (`iso_id`);

--
-- Indexes for table `freedeliverycart`
--
ALTER TABLE `freedeliverycart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homecat`
--
ALTER TABLE `homecat`
  ADD PRIMARY KEY (`homecat_id`);

--
-- Indexes for table `image_space`
--
ALTER TABLE `image_space`
  ADD PRIMARY KEY (`space_id`);

--
-- Indexes for table `img_base_url`
--
ALTER TABLE `img_base_url`
  ADD PRIMARY KEY (`url_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`(191));

--
-- Indexes for table `licensebox`
--
ALTER TABLE `licensebox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_cart`
--
ALTER TABLE `list_cart`
  ADD PRIMARY KEY (`l_cid`);

--
-- Indexes for table `mapbox`
--
ALTER TABLE `mapbox`
  ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `map_api`
--
ALTER TABLE `map_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_settings`
--
ALTER TABLE `map_settings`
  ADD PRIMARY KEY (`map_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minimum_maximum_order_value`
--
ALTER TABLE `minimum_maximum_order_value`
  ADD PRIMARY KEY (`min_max_id`);

--
-- Indexes for table `msg91`
--
ALTER TABLE `msg91`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificationby`
--
ALTER TABLE `notificationby`
  ADD PRIMARY KEY (`noti_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `cart_id` (`cart_id`(191));

--
-- Indexes for table `order_by_photo`
--
ALTER TABLE `order_by_photo`
  ADD PRIMARY KEY (`ord_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `payout_requests`
--
ALTER TABLE `payout_requests`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `payout_req_valid`
--
ALTER TABLE `payout_req_valid`
  ADD PRIMARY KEY (`val_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `product_rating`
--
ALTER TABLE `product_rating`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `product_varient`
--
ALTER TABLE `product_varient`
  ADD PRIMARY KEY (`varient_id`);

--
-- Indexes for table `razorpay_key`
--
ALTER TABLE `razorpay_key`
  ADD PRIMARY KEY (`key_id`);

--
-- Indexes for table `reedem_values`
--
ALTER TABLE `reedem_values`
  ADD PRIMARY KEY (`reedem_id`);

--
-- Indexes for table `referral_points`
--
ALTER TABLE `referral_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `secondary_banner`
--
ALTER TABLE `secondary_banner`
  ADD PRIMARY KEY (`sec_banner_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smsby`
--
ALTER TABLE `smsby`
  ADD PRIMARY KEY (`by_id`);

--
-- Indexes for table `society`
--
ALTER TABLE `society`
  ADD PRIMARY KEY (`society_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_assign_homecat`
--
ALTER TABLE `store_assign_homecat`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `store_bank`
--
ALTER TABLE `store_bank`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `store_banner`
--
ALTER TABLE `store_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `store_callback_req`
--
ALTER TABLE `store_callback_req`
  ADD PRIMARY KEY (`callback_req_id`);

--
-- Indexes for table `store_delivery_boy`
--
ALTER TABLE `store_delivery_boy`
  ADD PRIMARY KEY (`dboy_id`);

--
-- Indexes for table `store_doc`
--
ALTER TABLE `store_doc`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `store_driver_incentive`
--
ALTER TABLE `store_driver_incentive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_earning`
--
ALTER TABLE `store_earning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_homecat`
--
ALTER TABLE `store_homecat`
  ADD PRIMARY KEY (`homecat_id`);

--
-- Indexes for table `store_notification`
--
ALTER TABLE `store_notification`
  ADD PRIMARY KEY (`not_id`);

--
-- Indexes for table `store_orders`
--
ALTER TABLE `store_orders`
  ADD PRIMARY KEY (`store_order_id`);

--
-- Indexes for table `store_products`
--
ALTER TABLE `store_products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `varient_id` (`varient_id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `store_society`
--
ALTER TABLE `store_society`
  ADD PRIMARY KEY (`store_society_id`);

--
-- Indexes for table `tagging_tagged`
--
ALTER TABLE `tagging_tagged`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tagged_taggable_id_index` (`taggable_id`),
  ADD KEY `tagging_tagged_taggable_type_index` (`taggable_type`),
  ADD KEY `tagging_tagged_tag_slug_index` (`tag_slug`);

--
-- Indexes for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tags_slug_index` (`slug`),
  ADD KEY `tagging_tags_tag_group_id_foreign` (`tag_group_id`);

--
-- Indexes for table `tagging_tag_groups`
--
ALTER TABLE `tagging_tag_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tag_groups_slug_index` (`slug`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_referral`
--
ALTER TABLE `tbl_referral`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_top_cat`
--
ALTER TABLE `tbl_top_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_web_setting`
--
ALTER TABLE `tbl_web_setting`
  ADD PRIMARY KEY (`set_id`);

--
-- Indexes for table `termspage`
--
ALTER TABLE `termspage`
  ADD PRIMARY KEY (`terms_id`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`);

--
-- Indexes for table `twilio`
--
ALTER TABLE `twilio`
  ADD PRIMARY KEY (`twilio_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `user_support`
--
ALTER TABLE `user_support`
  ADD PRIMARY KEY (`supp_id`);

--
-- Indexes for table `wallet_recharge_history`
--
ALTER TABLE `wallet_recharge_history`
  ADD PRIMARY KEY (`wallet_recharge_history`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutuspage`
--
ALTER TABLE `aboutuspage`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_driver_incentive`
--
ALTER TABLE `admin_driver_incentive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  MODIFY `payout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_link`
--
ALTER TABLE `app_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_notice`
--
ALTER TABLE `app_notice`
  MODIFY `app_notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assign_homecat`
--
ALTER TABLE `assign_homecat`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `callback_req`
--
ALTER TABLE `callback_req`
  MODIFY `callback_req_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancel_for`
--
ALTER TABLE `cancel_for`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_payments`
--
ALTER TABLE `cart_payments`
  MODIFY `py_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_rewards`
--
ALTER TABLE `cart_rewards`
  MODIFY `cart_rewards_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `closing_hours`
--
ALTER TABLE `closing_hours`
  MODIFY `closing_hrs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country_code`
--
ALTER TABLE `country_code`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deal_product`
--
ALTER TABLE `deal_product`
  MODIFY `deal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `dboy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_rating`
--
ALTER TABLE `delivery_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_bank`
--
ALTER TABLE `driver_bank`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_callback_req`
--
ALTER TABLE `driver_callback_req`
  MODIFY `callback_req_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_incentive`
--
ALTER TABLE `driver_incentive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_notification`
--
ALTER TABLE `driver_notification`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcm`
--
ALTER TABLE `fcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `firebase`
--
ALTER TABLE `firebase`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `firebase_iso`
--
ALTER TABLE `firebase_iso`
  MODIFY `iso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `freedeliverycart`
--
ALTER TABLE `freedeliverycart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `homecat`
--
ALTER TABLE `homecat`
  MODIFY `homecat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_space`
--
ALTER TABLE `image_space`
  MODIFY `space_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `img_base_url`
--
ALTER TABLE `img_base_url`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licensebox`
--
ALTER TABLE `licensebox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_cart`
--
ALTER TABLE `list_cart`
  MODIFY `l_cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mapbox`
--
ALTER TABLE `mapbox`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `map_api`
--
ALTER TABLE `map_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `map_settings`
--
ALTER TABLE `map_settings`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `minimum_maximum_order_value`
--
ALTER TABLE `minimum_maximum_order_value`
  MODIFY `min_max_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `msg91`
--
ALTER TABLE `msg91`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notificationby`
--
ALTER TABLE `notificationby`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_by_photo`
--
ALTER TABLE `order_by_photo`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payout_requests`
--
ALTER TABLE `payout_requests`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payout_req_valid`
--
ALTER TABLE `payout_req_valid`
  MODIFY `val_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_rating`
--
ALTER TABLE `product_rating`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_varient`
--
ALTER TABLE `product_varient`
  MODIFY `varient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_key`
--
ALTER TABLE `razorpay_key`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reedem_values`
--
ALTER TABLE `reedem_values`
  MODIFY `reedem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `referral_points`
--
ALTER TABLE `referral_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reward_points`
--
ALTER TABLE `reward_points`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `secondary_banner`
--
ALTER TABLE `secondary_banner`
  MODIFY `sec_banner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `smsby`
--
ALTER TABLE `smsby`
  MODIFY `by_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `society`
--
ALTER TABLE `society`
  MODIFY `society_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_assign_homecat`
--
ALTER TABLE `store_assign_homecat`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_bank`
--
ALTER TABLE `store_bank`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_delivery_boy`
--
ALTER TABLE `store_delivery_boy`
  MODIFY `dboy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_notification`
--
ALTER TABLE `store_notification`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_orders`
--
ALTER TABLE `store_orders`
  MODIFY `store_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_products`
--
ALTER TABLE `store_products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_society`
--
ALTER TABLE `store_society`
  MODIFY `store_society_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagging_tagged`
--
ALTER TABLE `tagging_tagged`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagging_tag_groups`
--
ALTER TABLE `tagging_tag_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_referral`
--
ALTER TABLE `tbl_referral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_top_cat`
--
ALTER TABLE `tbl_top_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_web_setting`
--
ALTER TABLE `tbl_web_setting`
  MODIFY `set_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `termspage`
--
ALTER TABLE `termspage`
  MODIFY `terms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `twilio`
--
ALTER TABLE `twilio`
  MODIFY `twilio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_support`
--
ALTER TABLE `user_support`
  MODIFY `supp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_recharge_history`
--
ALTER TABLE `wallet_recharge_history`
  MODIFY `wallet_recharge_history` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wish_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
