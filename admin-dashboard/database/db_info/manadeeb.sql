-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2020 at 11:33 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manadeeb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adm_id` int(11) NOT NULL COMMENT 'admin id',
  `adm_full_name` varchar(255) NOT NULL COMMENT 'admin name',
  `adm_mail` varchar(255) NOT NULL COMMENT 'admin email',
  `adm_phone` int(11) NOT NULL COMMENT 'phone admin',
  `adm_password` varchar(255) NOT NULL COMMENT 'admin password',
  `avatar` varchar(255) NOT NULL COMMENT 'avatar admin',
  `adm_status` int(11) NOT NULL DEFAULT '0' COMMENT 'admin status',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `edit_date` datetime NOT NULL,
  `approve_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about admins';

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adm_id`, `adm_full_name`, `adm_mail`, `adm_phone`, `adm_password`, `avatar`, `adm_status`, `timestamp`, `edit_date`, `approve_date`) VALUES
(4, 'admin', 'admin@gmail.com', 1029222347, '67cc4419e87cc2f7496a24ea87da3541fb0c3717', '129319_22.jpg', 1, '2020-08-24 20:52:27', '2020-08-24 22:52:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL COMMENT 'brand id',
  `brand_name` varchar(255) NOT NULL COMMENT 'brand name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='brands';

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(6, 'adidas'),
(11, 'Apple'),
(4, 'BMW'),
(8, 'chanel'),
(5, 'colgate'),
(10, 'LG'),
(3, 'like'),
(2, 'Nike'),
(9, 'Samesung');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL COMMENT 'category ID',
  `c_name` varchar(255) NOT NULL COMMENT 'category name',
  `c_description` text NOT NULL COMMENT 'Category Description',
  `c_picture` varchar(255) NOT NULL COMMENT 'category photo',
  `sort_order` int(11) NOT NULL COMMENT 'special product sort ',
  `visibilty` int(11) NOT NULL DEFAULT '0' COMMENT 'category is active or pending',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT 'category parent',
  `date_inserted` datetime NOT NULL,
  `edit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info special categories ';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `c_name`, `c_description`, `c_picture`, `sort_order`, `visibilty`, `parent`, `date_inserted`, `edit_date`) VALUES
(4, 'men clothing', 'all special clothing', '529952_cloth men.jpeg', 1, 0, 3, '2020-07-01 00:00:00', '0000-00-00 00:00:00'),
(5, 'women\'s clothing', 'all special women\'s clothing', '862294_cloth cat.png', 3, 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'consumer electronic', 'all special consumer electronic', '168052_electronic.jpeg', 5, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'cell phones and communications', 'all special cell phones and communications', '214293_phone.jpeg', 7, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'mothers and children', 'all special mothers and children', '218572_mot.jpeg', 8, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'bags and luggage', 'all special bags and luggage', '901831_bag.jpeg', 9, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Home & garden', 'all special Home & garden', '283311_home.jpeg', 10, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'sports & leisure', 'all special sports & leisure', '703840_sports.jpeg', 11, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'animals', 'all special animales', '491302_5.jpg', 2, 0, 0, '0000-00-00 00:00:00', '2020-08-24 22:54:34');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `coun_id` int(11) NOT NULL COMMENT 'country id',
  `coun_name` varchar(255) NOT NULL COMMENT 'country name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='countries';

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`coun_id`, `coun_name`) VALUES
(4, 'China'),
(8, 'Dubai'),
(2, 'Egypt'),
(3, 'Kuwait'),
(1, 'Saudi Arabia'),
(6, 'Sudan'),
(5, 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id` int(11) NOT NULL COMMENT 'customer id',
  `cus_f_name` varchar(255) NOT NULL COMMENT ' customer first name ',
  `cus_l_name` varchar(255) NOT NULL COMMENT 'customer last name',
  `cus_address_1` varchar(255) NOT NULL DEFAULT 'not_found' COMMENT 'customer first address',
  `cus_address_2` varchar(225) NOT NULL DEFAULT 'not_found' COMMENT 'customer second address',
  `cus_city` varchar(225) NOT NULL COMMENT 'customer city',
  `cus_phone` int(11) NOT NULL COMMENT 'customer phone',
  `cus_state` varchar(255) NOT NULL DEFAULT 'not_found' COMMENT 'customer state',
  `cus_postalCode` int(11) NOT NULL DEFAULT '0' COMMENT 'customer postal code',
  `cus_country_id` int(11) NOT NULL COMMENT 'customer country',
  `cus_password` varchar(255) NOT NULL COMMENT 'customer password',
  `cus_mail` varchar(255) NOT NULL COMMENT 'mail customer',
  `cerditCard_type` varchar(255) NOT NULL DEFAULT 'not_found' COMMENT 'customer credit card type',
  `cus_cerditCard` int(11) NOT NULL DEFAULT '0',
  `cart` int(11) NOT NULL DEFAULT '0' COMMENT 'customer cart',
  `cart_exp_date` int(11) NOT NULL DEFAULT '0' COMMENT 'customer credit card date',
  `cus_enter_date` date NOT NULL COMMENT 'customer sign in date',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about customers';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `cus_f_name`, `cus_l_name`, `cus_address_1`, `cus_address_2`, `cus_city`, `cus_phone`, `cus_state`, `cus_postalCode`, `cus_country_id`, `cus_password`, `cus_mail`, `cerditCard_type`, `cus_cerditCard`, `cart`, `cart_exp_date`, `cus_enter_date`, `timestamp`, `update_date`) VALUES
(11, '', 'esan', 'not_found', 'not_found', 'dddd', 1029222347, 'not_found', 0, 4, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'hamed.esa2002@gmail.com', 'not_found', 0, 0, 0, '2020-04-23', '2020-07-01 00:42:13', '2020-07-01 00:00:00'),
(14, '', 'noor', 'not_found', 'not_found', 'sammanoud', 1029222347, 'not_found', 0, 4, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'noor@gmail.com', 'not_found', 0, 0, 0, '2020-05-11', '2020-05-11 16:27:43', '0000-00-00 00:00:00'),
(16, 'hamed', 'esam', 'not_found', 'not_found', 'saas', 1029222347, 'not_found', 0, 2, '8cb2237d0679ca88db6464eac60da96345513964', 'hamed@org.com', 'not_found', 0, 0, 0, '2020-05-24', '2020-05-23 22:28:34', '0000-00-00 00:00:00'),
(17, 'nona', 'nona', 'not_found', 'not_found', 'haned', 1029222347, 'not_found', 0, 5, '20eabe5d64b0e216796e834f52d61fd0b70332fc', 'nona@gmail.com', 'not_found', 0, 0, 0, '2020-06-03', '2020-06-03 12:24:11', '0000-00-00 00:00:00'),
(18, 'hamed', 'esam', 'not_found', 'not_found', 'sammanoud', 1029222347, 'not_found', 0, 5, '7930c2e44e689b0ad82720e4105393aed6d71ea9', 'hamed2002@gmail.com', 'not_found', 0, 0, 0, '2020-07-29', '2020-07-29 16:01:07', '0000-00-00 00:00:00'),
(19, 'noor hamed', 'hamed', 'not_found', 'not_found', 'sammanoud', 1029222347, 'not_found', 0, 4, '7930c2e44e689b0ad82720e4105393aed6d71ea9', 'hamedn@gmail.com', 'not_found', 0, 0, 0, '2020-08-05', '2020-08-05 12:25:07', '0000-00-00 00:00:00'),
(20, 'hamed', 'esams', 'not_found', 'not_found', 'Muraqab', 1029222347, 'not_found', 0, 5, '7930c2e44e689b0ad82720e4105393aed6d71ea9', 'hamed@gmail.com', 'not_found', 0, 0, 0, '2020-08-08', '2020-08-08 13:07:15', '0000-00-00 00:00:00'),
(21, 'noorH', 'hamdd', 'not_found', 'not_found', 'Jahra', 1029222347, 'not_found', 0, 1, '7930c2e44e689b0ad82720e4105393aed6d71ea9', 'noor22@gmail.com', 'not_found', 0, 0, 0, '2020-08-09', '2020-08-09 03:47:11', '0000-00-00 00:00:00'),
(22, 'hamed', 'Esam', 'not_found', 'not_found', 'Hawly', 1094670197, 'not_found', 0, 6, 'c32453a82e3d1d0cca2d3f46ec371ad0ad494d2f', 'hamedE@gmail.com', 'not_found', 0, 0, 0, '2020-08-14', '2020-08-14 11:33:12', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `ord_detail_id` int(11) NOT NULL COMMENT 'order details id',
  `productID` int(11) NOT NULL COMMENT 'product id special order',
  `ord_number` int(11) NOT NULL COMMENT 'order number',
  `ord_quantity` int(11) NOT NULL COMMENT 'order quantity',
  `product_name` varchar(255) NOT NULL COMMENT 'product name',
  `product_price` int(11) NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0' COMMENT 'product size',
  `color` varchar(255) NOT NULL DEFAULT 'no_colors' COMMENT 'product color',
  `cus_id` int(11) NOT NULL COMMENT 'customer id',
  `order_id` int(11) NOT NULL COMMENT 'order id',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transfar_to_sellar` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about order detail';

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ord_id` int(11) NOT NULL COMMENT 'order id',
  `customerID` int(11) NOT NULL COMMENT 'customer id',
  `ord_number` int(11) NOT NULL COMMENT 'order number',
  `payment_method` varchar(255) NOT NULL COMMENT 'payment identifier',
  `order_id` int(11) NOT NULL,
  `ord_date` date NOT NULL COMMENT 'order date',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'time stamp',
  `address_1` varchar(255) NOT NULL COMMENT 'address recieve first',
  `address_2` varchar(255) NOT NULL COMMENT 'address recieve second',
  `city` varchar(255) NOT NULL COMMENT 'city recieve',
  `country_id` int(11) NOT NULL COMMENT 'country identfire',
  `customer_name` varchar(255) NOT NULL COMMENT 'customer name',
  `place_center` varchar(255) NOT NULL DEFAULT 'not_found' COMMENT 'place center for recieve',
  `customer_phone` int(11) NOT NULL COMMENT 'customer phone ',
  `order_total_price` int(11) NOT NULL COMMENT 'order toal price',
  `delivery_type` varchar(255) NOT NULL COMMENT 'delivery type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about orders';

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `customerID`, `ord_number`, `payment_method`, `order_id`, `ord_date`, `timestamp`, `address_1`, `address_2`, `city`, `country_id`, `customer_name`, `place_center`, `customer_phone`, `order_total_price`, `delivery_type`) VALUES
(44, 16, 1671098, 'money_on_recieve', 1609717, '2020-05-31', '2020-05-31 16:36:20', '92739 albashmaop', 'hhhhhhhhh', 'hffffffffffffffffffffff', 4, 'hamed esam hamed', '', 1029222347, 1333, 'at_home'),
(45, 16, 5491947, 'money_on_recieve', 3860372, '2020-05-31', '2020-05-31 16:36:48', '92739 albashmaop', 'hhhhhhhhh', 'hffffffffffffffffffffff', 4, 'hamed esam hamed', '', 1029222347, 1333, 'at_home'),
(46, 16, 1106338, 'money_on_recieve', 1291358, '2020-05-31', '2020-05-31 16:37:47', '92739 albashmaop', 'hhhhhhhhh', 'hffffffffffffffffffffff', 4, 'hamed esam hamed', '', 1029222347, 1333, 'at_home'),
(47, 16, 1239069, 'money_on_recieve', 3217881, '2020-05-31', '2020-05-31 16:41:23', '126389 hflkfj', 'hfsahfhdfhdfgfdjfdjdjkajfjj', 'hffffffffffffffffffffff', 6, 'hamed esam hamed', '', 1029222347, 1217, 'at_home'),
(48, 16, 842441, 'money_on_recieve', 2315971, '2020-06-10', '2020-06-10 21:11:59', '92739 albashmaop', 'hfsahfhdfhdfgfdjfdjdjkajfjj', 'gfdgfgfgf', 6, 'fdddfdfdfdffddf', '', 1029222347, 116, 'at_home'),
(49, 16, 6967205, 'money_on_recieve', 6990833, '2020-06-12', '2020-06-12 21:13:18', '123 had', 'door', 'sammanoud', 5, 'hamed esam hamed', '', 1029222347, 1200, 'at_home'),
(50, 18, 10078276, 'money_on_recieve', 2473457, '2020-07-30', '2020-07-30 09:22:17', '126389 hflkfj', 'hfsahfhdfhdfgfdjfdjdjkajfjj', 'sammanoud', 2, 'ffsddssfdsfsdfsdf', '', 1029222347, 22389, 'at_home'),
(51, 18, 5562128, 'money_on_recieve', 586964, '2020-07-31', '2020-07-30 23:40:19', '182kdkjdsdjsdj', 'hfsahfhdfhdfgfdjfdjdjkajfjj', 'hffffffffffffffffffffff', 2, 'hamed esam hamed', '', 1029222347, 39556, 'at_home'),
(52, 22, 726082, 'money_on_recieve', 2267279, '2020-08-24', '2020-08-24 18:47:07', 'nkdndsnfdsnnmdfmsnsd', 'ndsjdsdsjdsjk', 'sammanoud', 4, 'hamed mohamed', '', 1029222347, 453, 'at_home'),
(53, 22, 9835784, 'money_on_recieve', 1460162, '2020-08-24', '2020-08-24 19:01:15', 'mitt assas', 'eeeeeeeeeeeeeeeeeeeeeeeeee', 'mansoura', 5, 'hamedddddddd', '', 1094670197, 484, 'at_home');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(255) NOT NULL COMMENT 'email special person who forget pass',
  `p_key` varchar(255) NOT NULL COMMENT 'key will send',
  `expDate` datetime NOT NULL COMMENT 'key expiry date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL COMMENT 'payment id',
  `payment_method` varchar(255) NOT NULL,
  `ord_num` int(20) NOT NULL COMMENT 'order payment number',
  `credit_cart_num` varchar(255) NOT NULL DEFAULT 'no_number' COMMENT 'credit cart number',
  `exp_m` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'credit cart exp month',
  `exp_y` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'credit cart exp year',
  `security_code` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'security_code',
  `customer_id` int(11) NOT NULL COMMENT 'customer id',
  `payment_id` int(11) NOT NULL DEFAULT '0' COMMENT 'pay',
  `date_record` datetime NOT NULL COMMENT 'date recorded'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about payment';

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `payment_method`, `ord_num`, `credit_cart_num`, `exp_m`, `exp_y`, `security_code`, `customer_id`, `payment_id`, `date_record`) VALUES
(46, 'money_on_recieve', 3287428, 'no_number', 0, 0, 0, 16, 0, '2020-05-31 18:35:30'),
(47, 'money_on_recieve', 1671098, 'no_number', 0, 0, 0, 16, 0, '2020-05-31 18:36:20'),
(48, 'money_on_recieve', 5491947, 'no_number', 0, 0, 0, 16, 0, '2020-05-31 18:36:48'),
(49, 'money_on_recieve', 1106338, 'no_number', 0, 0, 0, 16, 0, '2020-05-31 18:37:47'),
(50, 'money_on_recieve', 1239069, 'no_number', 0, 0, 0, 16, 0, '2020-05-31 18:41:23'),
(51, 'money_on_recieve', 842441, 'no_number', 0, 0, 0, 16, 0, '2020-06-10 23:11:59'),
(52, 'money_on_recieve', 6967205, 'no_number', 0, 0, 0, 16, 0, '2020-06-12 23:13:18'),
(53, 'money_on_recieve', 10078276, 'no_number', 0, 0, 0, 18, 0, '2020-07-30 11:22:17'),
(54, 'money_on_recieve', 5562128, 'no_number', 0, 0, 0, 18, 0, '2020-07-31 01:40:19'),
(55, 'money_on_recieve', 726082, 'no_number', 0, 0, 0, 22, 0, '2020-08-24 20:47:07'),
(56, 'money_on_recieve', 9835784, 'no_number', 0, 0, 0, 22, 0, '2020-08-24 21:01:15');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL COMMENT 'product id',
  `p_name` varchar(255) NOT NULL COMMENT 'product name',
  `p_description` text NOT NULL COMMENT 'product description',
  `quantity` int(11) NOT NULL DEFAULT '1' COMMENT 'product quantity',
  `p_picture` varchar(255) NOT NULL COMMENT 'product picture',
  `discount` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'discount price',
  `price` int(11) NOT NULL COMMENT 'product price',
  `color` varchar(255) NOT NULL DEFAULT 'no_color' COMMENT 'product color',
  `p_available_color` varchar(255) NOT NULL DEFAULT '0' COMMENT 'product available color',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT 'product size',
  `p_available_size` int(11) NOT NULL DEFAULT '0' COMMENT 'product available size',
  `categoryID` int(11) NOT NULL COMMENT 'category identifier',
  `Rating` int(11) NOT NULL DEFAULT '0' COMMENT 'product ranking',
  `p_country_id` int(11) NOT NULL COMMENT 'product country made',
  `city_product` varchar(255) NOT NULL COMMENT 'place product city',
  `status` varchar(255) NOT NULL COMMENT 'product status [ new - old - e.g]',
  `sellar_id` int(11) NOT NULL COMMENT 'sellar id',
  `brand_ID` int(11) NOT NULL DEFAULT '0' COMMENT 'brand id',
  `Approve` int(11) NOT NULL DEFAULT '0' COMMENT 'approve product',
  `orders_number` int(11) NOT NULL DEFAULT '0' COMMENT 'order numbers',
  `available_product_num` int(11) NOT NULL DEFAULT '0' COMMENT 'available product number',
  `Places_distribution` varchar(255) NOT NULL,
  `date_insert` datetime NOT NULL COMMENT 'for date insert product',
  `approve_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='all info about products';

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_description`, `quantity`, `p_picture`, `discount`, `price`, `color`, `p_available_color`, `size`, `p_available_size`, `categoryID`, `Rating`, `p_country_id`, `city_product`, `status`, `sellar_id`, `brand_ID`, `Approve`, `orders_number`, `available_product_num`, `Places_distribution`, `date_insert`, `approve_date`, `edit_date`) VALUES
(103, 'fvvdf', 'gdfgfdgf', 1, '268052_avatar2.png', 4, 0, 'no_color', '0', 0, 0, 7, 4, 5, 'Fahaheel', 'Used', 15, 5, 1, 0, 44, '', '2020-07-30 03:52:13', '2020-08-09 05:31:29', '0000-00-00 00:00:00'),
(104, 'product_test', 'thsi isskdfjgj', 1, '120397_brown-bracelet-boys.jpg', 2, 12, 'no_color', '0', 0, 0, 8, 0, 1, 'Al Riyadh', 'Like-New', 16, 8, 1, 0, 2, '', '2020-08-08 11:06:33', '2020-08-08 11:07:24', '0000-00-00 00:00:00'),
(106, 'bracelet brown', 'this is bracelet brown', 1, '532150_custom-printed-bracelets-collections.jpg', 11, 122, 'no_color', '0', 0, 0, 8, 0, 3, 'Fahaheel', 'Like-New', 15, 5, 1, 0, 22, '', '2020-08-09 05:19:40', '2020-08-09 05:31:19', '0000-00-00 00:00:00'),
(107, 'bracelet mens', 'this is bracelet mens', 1, '745853_brown-tan-back-braided-bracelet.jpg', 2, 33, 'no_color', '0', 0, 0, 9, 0, 5, 'Hawly', 'Like-New', 16, 8, 1, 0, 33, '', '2020-08-09 05:20:34', '2020-08-09 05:31:16', '0000-00-00 00:00:00'),
(108, 'bracelet man', 'this is bracelet man', 1, '126421_wide-black-studded-cuff-bracelet.jpg', 32, 333, 'no_color', '0', 0, 0, 9, 0, 8, 'Salmiya', 'Like-New', 15, 6, 1, 0, 2, '', '2020-08-09 05:21:35', '2020-08-09 05:31:09', '0000-00-00 00:00:00'),
(109, 'bracelet kw', 'This is bracelet kw', 1, '697790_white-black-back-bracelet.jpg', 11, 222, 'no_color', '0', 0, 0, 9, 0, 8, 'Almankf', 'New', 15, 6, 1, 0, 2, '', '2020-08-09 05:22:56', '2020-08-09 05:31:12', '0000-00-00 00:00:00'),
(110, 'product feature', 'this is product feature', 1, '19086_coordinates-bracelets-collections.jpg', 2, 77, 'no_color', '0', 0, 0, 6, 0, 4, 'Ad-Dilam', 'Used', 17, 5, 1, 0, 8, '', '2020-08-09 05:24:12', '2020-08-09 05:31:06', '0000-00-00 00:00:00'),
(112, 'ghhggfgf', 'fghfdhgfh', 1, '98197_7.jpg', 5, 55, 'no_color', '0', 0, 0, 12, 0, 3, 'Sabah-Al-Salem', 'Like-New', 18, 4, 0, 0, 4, 'Salmiya', '2020-08-23 13:27:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 'fdgdfgdfgfdfgd', 'gdfgdggdfgd', 1, '90687_7.jpg', 4, 44, 'no_color', '0', 0, 0, 12, 0, 8, 'Ahmadi', 'Used', 18, 4, 0, 0, 4, '', '2020-08-23 13:35:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 'gfhfghggfhf', 'fghfghfhgfh', 1, '906904_6.jpg', 4, 55, 'no_color', '0', 0, 0, 12, 0, 1, 'Jahra', 'new', 18, 5, 0, 0, 9, 'Fahaheel,Hawly,Salmiya,alkhabar,Jubail,', '2020-08-23 13:39:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 'UYTUTYUTY', 'TYUUYTUTUT', 1, '277934_7.jpg', 5, 66, 'no_color', '0', 0, 0, 10, 0, 6, 'Ahmadi', 'New', 15, 6, 1, 0, 5, 'Fahaheel,Hawly,Salmiya', '2020-08-23 15:10:09', '2020-08-23 20:22:44', '0000-00-00 00:00:00'),
(118, 'sdffffff', 'fsdddddddddddd', 1, '767460_7.jpg', 6, 333, 'no_color', '0', 0, 0, 12, 5, 1, 'Jahra', 'new', 18, 4, 1, 0, 6, 'Dhahran,Hafr-Al-Batin,Al Riyadh,', '2020-08-23 20:43:31', '2020-08-23 20:44:50', '2020-08-24 21:58:09'),
(119, 'product 3333', 'all special product 3333', 1, '441672_p12.jpg', 1, 111, 'no_color', '0', 0, 0, 6, 0, 6, 'Abha', 'Old', 17, 8, 1, 0, 22, 'Fahaheel,Hawly,Al-Farwaniyah,', '2020-08-24 23:12:08', '2020-08-24 23:23:41', '0000-00-00 00:00:00'),
(120, 'sport 1', 'this is sport 1', 1, '504457_124008_sp5.jpg', 3, 2322, 'no_color', '0', 0, 0, 11, 0, 5, 'Ad-Dilam', 'Like-New', 17, 9, 1, 0, 4, 'Fahaheel,Al-Farwaniyah,Alearidia,', '2020-08-24 23:14:42', '2020-08-24 23:23:38', '0000-00-00 00:00:00'),
(121, 'sportss', 'this is sports', 1, '361211_180760_sp4.jpg', 3, 232, 'no_color', '0', 0, 0, 11, 0, 5, 'Jahra', 'New', 16, 6, 1, 0, 4, 'Alearidia,', '2020-08-24 23:15:13', '2020-08-24 23:21:43', '0000-00-00 00:00:00'),
(122, 'sports', 'all special sports', 1, '978081_34068_sp7.jpg', 3, 192, 'no_color', '0', 0, 0, 11, 0, 5, 'Almankf', 'New', 17, 9, 1, 0, 3, 'Fahaheel,Hawly,', '2020-08-24 23:15:50', '2020-08-24 23:20:35', '0000-00-00 00:00:00'),
(123, 'sports 33', 'all special sports 33', 1, '569603_481033_sp2.jpg', 4, 22029, 'no_color', '0', 0, 0, 11, 0, 6, 'Jahra', 'Like-New', 17, 10, 1, 0, 3, 'Salmiya,Sabah-Al-Salem,', '2020-08-24 23:18:02', '2020-08-24 23:20:32', '0000-00-00 00:00:00'),
(124, 'home 232', 'this special home 232', 1, '27021_48395_6.jpg', 22, 123, 'no_color', '0', 0, 0, 10, 0, 8, 'Jahra', 'Like-New', 15, 9, 1, 0, 2, 'Alearidia,Jubail,', '2020-08-24 23:24:58', '2020-08-24 23:27:20', '0000-00-00 00:00:00'),
(125, 'home 233', 'all special home 233', 1, '606575_27021_48395_6.jpg', 2, 122, 'no_color', '0', 0, 0, 10, 0, 8, 'Jahra', 'New', 17, 6, 1, 0, 3, 'Alearidia,Abha,Badr,', '2020-08-24 23:25:30', '2020-08-24 23:27:18', '0000-00-00 00:00:00'),
(126, 'home 235', 'all special home 235', 1, '434078_209169_1.jpg', 1, 111, 'no_color', '0', 0, 0, 10, 0, 4, 'Jahra', 'Like-New', 17, 5, 1, 0, 22, 'Alearidia,Abha,', '2020-08-24 23:26:09', '2020-08-24 23:27:15', '0000-00-00 00:00:00'),
(127, 'cell phones', 'all special cell phones', 1, '657554_217985_ph1.jpg', 2, 120, 'no_color', '0', 0, 0, 7, 0, 5, 'Sabah-Al-Salem', 'Used', 17, 9, 1, 0, 3, 'Badr,Baljurashi,', '2020-08-24 23:28:55', '2020-08-24 23:31:16', '0000-00-00 00:00:00'),
(128, 'cell phones2', 'all special cell phones', 1, '505364_173737_rr.jpg', 3, 12, 'no_color', '0', 0, 0, 7, 0, 5, 'Salmiya', 'Like-New', 16, 9, 1, 0, 2, 'Fahaheel,Hawly,', '2020-08-24 23:29:33', '2020-08-24 23:31:13', '0000-00-00 00:00:00'),
(129, 'cell phones333', 'all special cell phones333', 1, '231410_282435_ph3.jpg', 4, 122, 'no_color', '0', 0, 0, 7, 0, 5, 'Jahra', 'Like-New', 18, 8, 1, 0, 3, 'Baljurashi,Dhahran,', '2020-08-24 23:30:24', '2020-08-24 23:31:10', '0000-00-00 00:00:00'),
(130, 'cell phones3334', 'all special cell phones334', 1, '146741_552479_ph.jpg', 3, 222, 'no_color', '0', 0, 0, 7, 0, 3, 'Salmiya', 'Like-New', 17, 9, 1, 0, 33, 'Hawly,Salmiya,', '2020-08-24 23:31:02', '2020-08-24 23:31:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_rating`
--

CREATE TABLE `product_rating` (
  `id` int(11) NOT NULL,
  `rating` int(2) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='product rating ingo';

--
-- Dumping data for table `product_rating`
--

INSERT INTO `product_rating` (`id`, `rating`, `product_id`, `user_id`, `timestamp`) VALUES
(3, 4, 103, 18, '2020-07-30 08:38:48'),
(5, 4, 118, 18, '2020-08-23 22:41:51'),
(6, 5, 118, 22, '2020-08-24 09:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `sellars`
--

CREATE TABLE `sellars` (
  `sellar_id` int(11) NOT NULL COMMENT 'sellar id',
  `sellar_name` varchar(255) NOT NULL COMMENT 'sellar name',
  `sellar_phone` int(11) NOT NULL COMMENT 'sellar phone',
  `sellar_mail` varchar(255) NOT NULL COMMENT 'sellar mail',
  `sellar_pass` varchar(255) NOT NULL COMMENT 'sellar pass',
  `sellar_img` varchar(255) NOT NULL COMMENT 'sellar image',
  `country_id` int(11) NOT NULL COMMENT 'sellar country',
  `city` varchar(255) NOT NULL,
  `date_register` date NOT NULL COMMENT 'date register',
  `Reg_status` int(11) NOT NULL DEFAULT '0',
  `edit_date` datetime NOT NULL,
  `approve_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sellar information';

--
-- Dumping data for table `sellars`
--

INSERT INTO `sellars` (`sellar_id`, `sellar_name`, `sellar_phone`, `sellar_mail`, `sellar_pass`, `sellar_img`, `country_id`, `city`, `date_register`, `Reg_status`, `edit_date`, `approve_date`) VALUES
(8, 'hamed', 1029222347, 'hamed@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '631216_11.jpg', 4, '', '2020-04-21', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'hamed esamm', 1029222347, 'hamed.esa2002@gmail.com', '7930c2e44e689b0ad82720e4105393aed6d71ea9', '383039_avatar2.png', 6, '', '2020-07-30', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'hamed esamsm', 1029222347, 'noor@gmail.com', '7930c2e44e689b0ad82720e4105393aed6d71ea9', '771828_avatar2.png', 2, '', '2020-07-30', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'noor', 1029222347, 'hamedn@gmail.com', '7930c2e44e689b0ad82720e4105393aed6d71ea9', '61864_arrays-in-java---الباشمبرمج.jpg', 6, '', '2020-08-05', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'habfffdfd', 1029222347, 'hamed2002@gmail.com', '7930c2e44e689b0ad82720e4105393aed6d71ea9', '783781_custom-printed-bracelets-collections.jpg', 6, 'Jahra', '2020-08-08', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `store_cart_item`
--

CREATE TABLE `store_cart_item` (
  `p_c_id` int(11) NOT NULL COMMENT 'product cart id',
  `p_id` int(11) NOT NULL COMMENT 'main product cart id',
  `p_name` varchar(255) NOT NULL COMMENT 'product_cart_name',
  `sellar_name` varchar(255) NOT NULL COMMENT 'sellar_product_name',
  `p_img` varchar(255) NOT NULL COMMENT 'product cart img',
  `p_price` int(11) NOT NULL COMMENT 'product cart price',
  `p_quantity` int(11) NOT NULL DEFAULT '1' COMMENT 'product quntity',
  `discount` int(11) NOT NULL COMMENT 'price discount',
  `customer_id` int(11) NOT NULL COMMENT 'customer id',
  `date_insert` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adm_id`),
  ADD KEY `adm_full_name` (`adm_full_name`),
  ADD KEY `adm_mail` (`adm_mail`),
  ADD KEY `adm_phone` (`adm_phone`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_name_2` (`c_name`),
  ADD KEY `c_name` (`c_name`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`coun_id`),
  ADD UNIQUE KEY `coun_name` (`coun_name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`),
  ADD KEY `cerditCard_type_id` (`cerditCard_type`),
  ADD KEY `coun` (`cus_country_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`ord_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `productID` (`productID`),
  ADD KEY `ord_number` (`ord_number`),
  ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `paymentID` (`payment_method`),
  ADD KEY `ord_number` (`ord_number`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `cus_id` (`customer_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `payment_method` (`payment_method`),
  ADD KEY `ord_num` (`ord_num`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `brand_ID` (`brand_ID`),
  ADD KEY `p_country_id` (`p_country_id`),
  ADD KEY `sellar_id` (`sellar_id`);

--
-- Indexes for table `product_rating`
--
ALTER TABLE `product_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`product_id`),
  ADD KEY `u_id` (`user_id`);

--
-- Indexes for table `sellars`
--
ALTER TABLE `sellars`
  ADD PRIMARY KEY (`sellar_id`),
  ADD UNIQUE KEY `sellar_name` (`sellar_name`),
  ADD KEY `country` (`country_id`);

--
-- Indexes for table `store_cart_item`
--
ALTER TABLE `store_cart_item`
  ADD PRIMARY KEY (`p_c_id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'admin id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'brand id', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'category ID', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `coun_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'country id', AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cus_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'customer id', AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `ord_detail_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'order details id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'order id', AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'payment id', AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'product id', AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `product_rating`
--
ALTER TABLE `product_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sellars`
--
ALTER TABLE `sellars`
  MODIFY `sellar_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'sellar id', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `store_cart_item`
--
ALTER TABLE `store_cart_item`
  MODIFY `p_c_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'product cart id', AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `coun` FOREIGN KEY (`cus_country_id`) REFERENCES `countries` (`coun_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `ord_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`productID`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `country_id` FOREIGN KEY (`country_id`) REFERENCES `countries` (`coun_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_id` FOREIGN KEY (`customerID`) REFERENCES `customers` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `cus_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `brand_id` FOREIGN KEY (`brand_ID`) REFERENCES `brands` (`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_id` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_country` FOREIGN KEY (`p_country_id`) REFERENCES `countries` (`coun_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellar_id` FOREIGN KEY (`sellar_id`) REFERENCES `sellars` (`sellar_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_rating`
--
ALTER TABLE `product_rating`
  ADD CONSTRAINT `p_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sellars`
--
ALTER TABLE `sellars`
  ADD CONSTRAINT `country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`coun_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `store_cart_item`
--
ALTER TABLE `store_cart_item`
  ADD CONSTRAINT `custom_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produc_id` FOREIGN KEY (`p_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
