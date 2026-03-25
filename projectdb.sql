-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 16 Σεπ 2024 στις 19:55:40
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `projectdb`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `date_created`) VALUES
(1, 'Έλλειψη νερού ', 'Στην περιοχή κέντρο Πάτρας υπάρχει έλλειψη νερού λόγω φωτίας ', '2024-08-31 19:40:12'),
(2, 'Έλλειψη νερού ', 'Στην περιοχή κέντρο Πάτρας υπάρχει έλλειψη νερού λόγω φωτίας ', '2024-08-31 19:45:32'),
(3, 'Έλλειψη νερού ', 'Στην περιοχή κέντρο Πάτρας υπάρχει έλλειψη νερού λόγω φωτίας ', '2024-08-31 19:45:37'),
(4, 'Έλλειψη νερού ', 'Έλλειψη νερού στο κέντρο Πάτρας λόγω πυρκαγιάς', '2024-08-31 19:52:21'),
(5, 'Έλλειψη νερού ', 'Έλλειψη νερού στο κέντρο Πάτρας λόγω πυρκαγιάς', '2024-08-31 19:54:10'),
(6, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 19:54:45'),
(7, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 19:56:20'),
(8, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 19:56:24'),
(9, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 19:56:36'),
(10, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 19:59:01'),
(11, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 19:59:06'),
(12, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 20:01:35'),
(13, 'Έλλειψη νερού ', 'Έλλειψη νερού στην Πάτρα λόγω πυρκαγιάς.', '2024-08-31 20:04:35'),
(14, 'Πυρκαγιά', 'Πυρκαγία στο κέντρο της Πάτρας', '2024-08-31 20:26:34'),
(15, 'Έλλειψη νερού ', 'Φωτία στην περιοχή Πύργος \r\nαναγκη απο νερό', '2024-09-01 07:58:50'),
(16, 'Έλλειψη νερού ', 'φωτια στην πατρα ', '2024-09-01 08:17:41'),
(0, 'sokolata', 'lacta', '2024-09-07 14:23:56'),
(0, 'ΑΝΑΓΚΗ ΓΙΑ ΦΑΓΗΤΟ', 'ΕΠΕΙΓΩΝ \r\nΑΝΑΓΚΗ ΓΙΑ ΦΑΓΗΤΟ ΠΑΤΡΑ ΚΕΝΤΡΟ ΦΩΤΙΑ', '2024-09-16 12:45:10'),
(0, 'ΑΝΑΓΚΗ ΓΙΑ ΝΕΡΟ', 'ΦΩΤΙΑ ΣΤΗ ΠΛΑΤΕΙΑ ΓΕΩΡΓΙΟΥ', '2024-09-16 14:20:44'),
(0, 'ΑΝΑΓΚΗ ΓΙΑ ΝΕΡΟ', 'ΦΩΤΙΑ ΠΛΑΤΕΙΑ ΓΕΩΡΓΙΟΥ', '2024-09-16 14:24:30');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcement_items`
--

CREATE TABLE `announcement_items` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `register_polites_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `announcement_items`
--

INSERT INTO `announcement_items` (`id`, `announcement_id`, `item_id`, `register_polites_id`, `status`, `date_submitted`) VALUES
(1, 4, 15, 0, 'pending', '2024-09-15 11:16:10'),
(2, 5, 15, 0, 'pending', '2024-09-15 11:16:10'),
(3, 6, 16, 0, 'pending', '2024-09-15 11:16:10'),
(4, 7, 16, 0, 'pending', '2024-09-15 11:16:10'),
(5, 8, 16, 0, 'pending', '2024-09-15 11:16:10'),
(6, 9, 16, 0, 'pending', '2024-09-15 11:16:10'),
(7, 10, 16, 0, 'pending', '2024-09-15 11:16:10'),
(8, 11, 16, 0, 'pending', '2024-09-15 11:16:10'),
(9, 12, 16, 0, 'pending', '2024-09-15 11:16:10'),
(10, 13, 16, 0, 'pending', '2024-09-15 11:16:10'),
(11, 14, 15, 0, 'pending', '2024-09-15 11:16:10'),
(12, 15, 15, 0, 'pending', '2024-09-15 11:16:10'),
(13, 16, 16, 0, 'pending', '2024-09-15 11:16:10'),
(14, 0, 44, 0, 'cancelled', '2024-09-15 11:16:10'),
(15, 1, 1, 14, 'cancelled', '2024-09-15 11:16:10'),
(16, 1, 1, 14, 'cancelled', '2024-09-15 11:35:50'),
(17, 2, 1, 14, 'cancelled', '2024-09-15 11:35:51'),
(18, 1, 1, 14, 'cancelled', '2024-09-15 11:38:52'),
(19, 2, 1, 14, 'cancelled', '2024-09-15 11:38:53'),
(20, 14, 1, 14, 'cancelled', '2024-09-15 11:39:37'),
(21, 0, 1, 14, 'cancelled', '2024-09-15 11:39:39'),
(22, 14, 1, 14, 'cancelled', '2024-09-15 11:42:08'),
(23, 8, 1, 14, 'cancelled', '2024-09-15 11:42:10'),
(24, 16, 1, 14, 'cancelled', '2024-09-15 11:42:27'),
(25, 16, 1, 14, 'cancelled', '2024-09-15 11:42:32'),
(26, 0, 1, 14, 'cancelled', '2024-09-15 11:42:39'),
(27, 13, 1, 14, 'cancelled', '2024-09-15 11:42:41'),
(41, 13, 1, 14, 'cancelled', '2024-09-15 11:45:22'),
(42, 4, 1, 14, 'cancelled', '2024-09-15 11:45:24'),
(43, 1, 1, 14, 'cancelled', '2024-09-15 18:05:54'),
(44, 15, 1, 14, 'cancelled', '2024-09-16 12:42:31'),
(45, 0, 19, 0, 'pending', '2024-09-16 12:45:10'),
(46, 1, 1, 14, 'cancelled', '2024-09-16 12:54:10'),
(47, 0, 15, 0, 'pending', '2024-09-16 14:20:44'),
(48, 0, 15, 0, 'pending', '2024-09-16 14:24:30'),
(49, 1, 1, 14, 'pending', '2024-09-16 15:00:44');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `base_location`
--

CREATE TABLE `base_location` (
  `id` int(11) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `base_location`
--

INSERT INTO `base_location` (`id`, `lat`, `lng`) VALUES
(1, 38.246421167440005, 21.735055446624756);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(5, 'Food'),
(6, 'Beverages'),
(7, 'Clothing'),
(8, 'Hacker of class'),
(9, '2d hacker'),
(10, ''),
(11, 'Test'),
(13, '-----'),
(14, 'Flood'),
(15, 'new cat'),
(16, 'Medical Supplies'),
(19, 'Shoes'),
(21, 'Personal Hygiene '),
(22, 'Cleaning Supplies'),
(23, 'Tools'),
(24, 'Kitchen Supplies'),
(25, 'Baby Essentials'),
(26, 'Insect Repellents'),
(27, 'Electronic Devices'),
(28, 'Cold weather'),
(29, 'Animal Food'),
(30, 'Financial support'),
(33, 'Cleaning Supplies.'),
(34, 'Hot Weather'),
(35, 'First Aid '),
(39, 'Test_0'),
(40, 'test1'),
(41, 'pet supplies'),
(42, 'Μedicines'),
(43, 'Energy Drinks'),
(44, 'Disability and Assistance Items'),
(45, 'Communication items'),
(46, 'communications'),
(47, 'Humanitarian Shelters'),
(48, 'Water Purification'),
(49, 'Animal Care'),
(50, 'Earthquake Safety'),
(51, 'Sleep Essentilals'),
(52, 'Navigation Tools'),
(53, 'Clothing and cover'),
(54, 'Tools and Equipment'),
(56, 'Special items'),
(57, 'Household Items'),
(59, 'Books'),
(60, 'Fuel and Energy'),
(61, 'test category'),
(65, 'haris'),
(66, 'alkool'),
(67, 'xara');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `location` varchar(255) DEFAULT 'base'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `quantity`, `location`) VALUES
(15, 'Water', 6, 0, 'base'),
(16, 'Water', 6, 0, 'base'),
(17, 'Orange juice', 6, 0, 'base'),
(18, 'Sardine', 5, 2, 'base'),
(19, 'Canned corn', 5, 0, 'base'),
(20, 'Bread', 5, 0, 'base'),
(21, 'Chocolate', 5, 0, 'base'),
(22, 'Men Sneakers', 7, 0, 'base'),
(23, 'Test Product', 9, 0, 'base'),
(24, 'Test Val', 14, 0, 'base'),
(25, 'Spaghetti', 5, 0, 'base'),
(26, 'Croissant', 5, 0, 'base'),
(28, '', 10, 0, 'base'),
(29, 'Biscuits', 5, 0, 'base'),
(30, 'Bandages', 16, 0, 'base'),
(31, 'Disposable gloves', 16, 0, 'base'),
(32, 'Gauze', 16, 0, 'base'),
(33, 'Antiseptic', 16, 0, 'base'),
(34, 'First Aid Kit', 16, 0, 'base'),
(35, 'Painkillers', 16, 0, 'base'),
(36, 'Blanket', 7, 0, 'base'),
(37, 'Fakes', 5, 0, 'base'),
(38, 'Menstrual Pads', 21, 0, 'base'),
(39, 'Tampon', 21, 0, 'base'),
(40, 'Toilet Paper', 21, 0, 'base'),
(41, 'Baby wipes', 21, 0, 'base'),
(42, 'Toothbrush', 21, 0, 'base'),
(43, 'Toothpaste', 21, 0, 'base'),
(44, 'Vitamin C', 16, 0, 'base'),
(45, 'Multivitamines', 16, 0, 'base'),
(46, 'Paracetamol', 16, 0, 'base'),
(47, 'Ibuprofen', 16, 0, 'base'),
(48, '', 10, 0, 'base'),
(49, '', 10, 0, 'base'),
(50, '', 10, 0, 'base'),
(51, 'Cleaning rag', 22, 0, 'base'),
(52, 'Detergent', 22, 0, 'base'),
(53, 'Disinfectant', 22, 0, 'base'),
(54, 'Mop', 22, 0, 'base'),
(55, 'Plastic bucket', 22, 0, 'base'),
(56, 'Scrub brush', 22, 0, 'base'),
(57, 'Dust mask', 22, 0, 'base'),
(58, 'Broom', 22, 0, 'base'),
(59, 'Hammer', 23, 0, 'base'),
(60, 'Skillsaw', 23, 0, 'base'),
(61, 'Prybar', 23, 0, 'base'),
(62, 'Shovel', 23, 0, 'base'),
(63, 'Flashlight', 23, 0, 'base'),
(64, 'Duct tape', 23, 0, 'base'),
(65, 'Underwear', 7, 0, 'base'),
(66, 'Socks', 7, 0, 'base'),
(67, 'Warm Jacket', 7, 0, 'base'),
(68, 'Raincoat', 7, 0, 'base'),
(69, 'Gloves', 7, 0, 'base'),
(70, 'Pants', 7, 0, 'base'),
(71, 'Boots', 7, 0, 'base'),
(72, 'Dishes', 24, 0, 'base'),
(73, 'Pots', 24, 0, 'base'),
(74, 'Paring knives', 24, 0, 'base'),
(75, 'Pan', 24, 0, 'base'),
(76, 'Glass', 24, 0, 'base'),
(77, '', 10, 0, 'base'),
(78, '', 10, 0, 'base'),
(79, '', 10, 0, 'base'),
(80, '', 10, 0, 'base'),
(81, '', 10, 0, 'base'),
(82, '', 10, 0, 'base'),
(83, 't22', 9, 0, 'base'),
(84, 'water ', 6, 0, 'base'),
(85, 'Coca Cola', 6, 0, 'base'),
(86, 'spray', 26, 0, 'base'),
(87, 'Outdoor spiral', 26, 0, 'base'),
(88, 'Baby bottle', 25, 0, 'base'),
(89, 'Pacifier', 25, 0, 'base'),
(90, 'Condensed milk', 5, 0, 'base'),
(91, 'Cereal bar', 5, 0, 'base'),
(92, 'Pocket Knife', 23, 0, 'base'),
(93, 'Water Disinfection Tablets', 16, 0, 'base'),
(94, 'Radio', 27, 0, 'base'),
(95, 'Kitchen appliances', 14, 0, 'base'),
(96, 'Winter hat', 28, 0, 'base'),
(97, 'Winter gloves', 28, 0, 'base'),
(98, 'Scarf', 28, 0, 'base'),
(99, 'Thermos', 28, 0, 'base'),
(100, 'Tea', 6, 0, 'base'),
(101, 'Dog Food ', 29, 0, 'base'),
(102, 'Cat Food', 29, 0, 'base'),
(103, 'Canned', 5, 0, 'base'),
(104, 'Chlorine', 22, 0, 'base'),
(105, 'Medical gloves', 22, 0, 'base'),
(106, 'T-Shirt', 7, 0, 'base'),
(107, 'Cooling Fan', 34, 0, 'base'),
(108, 'Cool Scarf', 34, 0, 'base'),
(109, 'Whistle', 23, 0, 'base'),
(110, 'Blankets', 28, 0, 'base'),
(111, 'Sleeping Bag', 28, 0, 'base'),
(112, 'Toothbrush', 21, 0, 'base'),
(113, 'Toothpaste', 21, 0, 'base'),
(114, 'Thermometer', 16, 0, 'base'),
(115, 'Rice', 5, 0, 'base'),
(116, 'Bread', 5, 0, 'base'),
(117, 'Towels', 22, 0, 'base'),
(118, 'Wet Wipes', 22, 0, 'base'),
(119, 'Fire Extinguisher', 23, 0, 'base'),
(120, 'Fruits', 5, 0, 'base'),
(121, 'Duct Tape', 23, 0, 'base'),
(122, '', 10, 0, 'base'),
(123, 'Αθλητικά', 19, 0, 'base'),
(124, 'Πασατέμπος', 5, 0, 'base'),
(125, 'Bandages', 35, 0, 'base'),
(126, 'Betadine', 35, 0, 'base'),
(127, 'cotton wool', 35, 0, 'base'),
(128, 'Crackers', 5, 0, 'base'),
(129, 'Sanitary Pads', 21, 0, 'base'),
(130, 'Sanitary wipes', 21, 0, 'base'),
(131, 'Electrolytes', 16, 0, 'base'),
(132, 'Pain killers', 16, 0, 'base'),
(133, 'Flashlight', 23, 0, 'base'),
(134, 'Juice', 6, 0, 'base'),
(135, 'Toilet Paper', 21, 0, 'base'),
(136, 'Sterilized Saline', 16, 0, 'base'),
(137, 'Biscuits', 5, 0, 'base'),
(138, 'Antihistamines', 16, 0, 'base'),
(139, 'Instant Pancake Mix', 5, 0, 'base'),
(140, 'Lacta', 5, 0, 'base'),
(141, 'Canned Tuna', 5, 0, 'base'),
(142, 'Batteries', 23, 0, 'base'),
(143, 'Dust Mask', 35, 0, 'base'),
(144, 'Can Opener', 23, 0, 'base'),
(145, '', 10, 0, 'base'),
(146, 'Πατατάκια', 5, 0, 'base'),
(147, 'Σερβιέτες', 21, 0, 'base'),
(148, 'Dry Cranberries', 5, 0, 'base'),
(149, 'Dry Apricots', 5, 0, 'base'),
(150, 'Dry Figs', 5, 0, 'base'),
(151, 'Παξιμάδια', 5, 0, 'base'),
(152, '', 10, 0, 'base'),
(153, 'Test Item', 11, 0, 'base'),
(154, 'Painkillers', 35, 0, 'base'),
(155, 'Tampons', 16, 0, 'base'),
(156, 'plaster set', 41, 0, 'base'),
(157, 'elastic bandages', 41, 0, 'base'),
(158, 'traumaplast', 41, 0, 'base'),
(159, 'thermal blanket', 41, 0, 'base'),
(160, 'burn gel', 41, 0, 'base'),
(161, 'pet carrier', 41, 0, 'base'),
(162, 'pet dishes', 41, 0, 'base'),
(163, 'plastic bags', 41, 0, 'base'),
(164, 'toys', 41, 0, 'base'),
(165, 'burn pads', 41, 0, 'base'),
(166, 'cheese', 5, 0, 'base'),
(167, 'lettuce', 5, 0, 'base'),
(168, 'eggs', 5, 0, 'base'),
(169, 'steaks', 5, 0, 'base'),
(170, 'beef burgers', 5, 0, 'base'),
(171, 'tomatoes', 5, 0, 'base'),
(172, 'onions', 5, 0, 'base'),
(173, 'flour', 5, 0, 'base'),
(174, 'pastel', 5, 0, 'base'),
(175, 'nuts', 5, 0, 'base'),
(176, 'dramamines', 42, 0, 'base'),
(177, 'nurofen', 42, 0, 'base'),
(178, 'imodium', 42, 0, 'base'),
(179, 'emetostop', 42, 0, 'base'),
(180, 'xanax', 42, 0, 'base'),
(181, 'saflutan', 42, 0, 'base'),
(182, 'sadolin', 42, 0, 'base'),
(183, 'depon', 42, 0, 'base'),
(184, 'panadol', 42, 0, 'base'),
(185, 'ponstan ', 42, 0, 'base'),
(186, 'algofren', 42, 0, 'base'),
(187, 'effervescent depon', 42, 0, 'base'),
(188, 'cold coffee', 6, 0, 'base'),
(189, 'Hell', 43, 0, 'base'),
(190, 'Monster', 43, 0, 'base'),
(191, 'Redbull', 43, 0, 'base'),
(192, 'Powerade', 43, 0, 'base'),
(193, 'PRIME', 43, 0, 'base'),
(194, 'Lighter', 23, 0, 'base'),
(195, 'isothermally shirts', 28, 0, 'base'),
(196, '', 10, 0, 'base'),
(197, 'Depon', 42, 0, 'base'),
(198, 'Shorts', 34, 0, 'base'),
(199, 'Chicken', 5, 0, 'base'),
(200, 'Toilet Paper', 21, 0, 'base'),
(201, 'toys', 41, 0, 'base'),
(202, 'sanitary napkins', 21, 0, 'base'),
(203, 'COVID-19 Tests', 16, 0, 'base'),
(204, 'Club Soda', 6, 0, 'base'),
(205, 'Wheelchairs', 44, 0, 'base'),
(206, 'mobile phones', 45, 0, 'base'),
(207, 'spoon', 24, 0, 'base'),
(208, 'fork', 24, 0, 'base'),
(209, 'MOTOTRBO R7', 45, 0, 'base'),
(210, 'RM LA 250 (VHF Linear Ενισχυτής 140-150MHz)', 45, 0, 'base'),
(211, 'Humanitarian General Purpose Tent System (HGPTS)', 47, 0, 'base'),
(212, 'CELINA Dynamic Small Shelter ', 47, 0, 'base'),
(213, 'Multi-purpose Area Shelter System, Type-I', 47, 0, 'base'),
(214, 'Trousers', 7, 0, 'base'),
(215, 'Shoes', 7, 0, 'base'),
(216, 'Hoodie', 7, 0, 'base'),
(217, '', 10, 0, 'base'),
(218, 'dog food', 49, 0, 'base'),
(219, 'cat food', 49, 0, 'base'),
(220, 'macaroni', 5, 0, 'base'),
(221, 'rice', 5, 0, 'base'),
(222, 'scarf', 7, 0, 'base'),
(223, 'gloves', 7, 0, 'base'),
(224, 'underwear', 7, 0, 'base'),
(225, 'Silver blanket', 50, 0, 'base'),
(226, 'Helmet', 50, 0, 'base'),
(227, 'Disposable toilet', 50, 0, 'base'),
(228, 'Self-generated flashlight', 50, 0, 'base'),
(229, 'Mattresses ', 51, 0, 'base'),
(230, 'flashlight', 51, 0, 'base'),
(231, 'matches', 51, 0, 'base'),
(232, 'Heater', 51, 0, 'base'),
(233, 'Earplugs', 51, 0, 'base'),
(234, 'Compass', 52, 0, 'base'),
(235, 'Map', 52, 0, 'base'),
(236, 'GPS', 52, 0, 'base'),
(237, 'First Aid', 16, 0, 'base'),
(238, 'Bandage', 16, 0, 'base'),
(239, 'Mask', 16, 0, 'base'),
(240, 'Medicines', 16, 0, 'base'),
(241, 'Water', 5, 0, 'base'),
(242, 'Canned Goods', 5, 0, 'base'),
(243, 'Snacks', 5, 0, 'base'),
(244, 'Cereals', 5, 0, 'base'),
(245, 'Blankets', 53, 0, 'base'),
(246, 'Shirt', 53, 0, 'base'),
(247, 'Pants', 53, 0, 'base'),
(248, 'Shoes', 53, 0, 'base'),
(249, 'Socks', 53, 0, 'base'),
(250, 'Caps', 53, 0, 'base'),
(251, 'Gloves', 53, 0, 'base'),
(252, 'Flashlight', 54, 0, 'base'),
(253, 'Batteries', 54, 0, 'base'),
(254, 'Repair Tools', 54, 0, 'base'),
(255, 'Soap and Shampoo', 21, 0, 'base'),
(256, 'Toothpastes and Toothbrushes', 21, 0, 'base'),
(257, 'Towels', 21, 0, 'base'),
(258, 'Diapers', 56, 0, 'base'),
(259, 'Animal food', 56, 0, 'base'),
(260, 'Pots', 57, 0, 'base'),
(261, 'Plates', 57, 0, 'base'),
(262, 'Cups', 57, 0, 'base'),
(263, 'Cutlery ', 57, 0, 'base'),
(264, 'Cleaning Supplies', 57, 0, 'base'),
(265, 'Kitchen Appliances', 57, 0, 'base'),
(266, 'Home Repair Tools', 57, 0, 'base'),
(267, '', 10, 0, 'base'),
(268, 'Lord of the Rings', 59, 0, 'base'),
(269, 'Dog Food', 29, 0, 'base'),
(270, 'DEPON', 16, 0, 'base'),
(271, 'Painkillers', 16, 0, 'base'),
(272, 'Gasoline', 60, 0, 'base'),
(273, 'Power Banks', 60, 0, 'base'),
(274, '', 9, 0, 'base'),
(275, 'test item', 29, 0, 'base'),
(276, 'test item2', 61, 0, 'base'),
(277, 'T4 Levothyroxine', 42, 0, 'base'),
(282, 'sardeles', 5, 0, 'base'),
(283, 'xtapodi', 5, 6, 'base'),
(284, 'sokolata', 67, 0, 'base'),
(286, 'garida', 5, 15, 'base'),
(553, 'αμυγδαλο', 5, 15, 'base'),
(555, 'Byssinada', 5, 13, 'base'),
(556, 'Επίδεσμος', 16, 10, 'base');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `detail_name` varchar(100) NOT NULL,
  `detail_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `detail_name`, `detail_value`) VALUES
(2581, 17, 'volume', '250ml'),
(2582, 17, 'pack size', '12'),
(2583, 18, 'brand', 'Trata'),
(2584, 18, 'weight', '200g'),
(2585, 19, 'weight', '500g'),
(2586, 20, 'weight', '1kg'),
(2587, 20, 'type', 'white'),
(2588, 21, 'weight', '100g'),
(2589, 21, 'type', 'milk chocolate'),
(2590, 21, 'brand', 'ION'),
(2591, 22, 'size', '44'),
(2592, 23, 'weight', '500g'),
(2593, 23, 'pack size', '12'),
(2594, 23, 'expiry date', '13/12/1978'),
(2595, 24, 'Details', '600ml'),
(2596, 25, 'grams', '500'),
(2597, 26, 'calories', '200'),
(2598, 28, '', ''),
(2599, 29, '', ''),
(2600, 30, '', '25 pcs'),
(2601, 31, '', '100 pcs'),
(2602, 32, '', ''),
(2603, 33, '', '250ml'),
(2604, 34, '', ''),
(2605, 35, 'volume', '200mg'),
(2606, 36, 'size', '50\" x 60\"'),
(2607, 37, '', ''),
(2608, 38, 'stock', '500'),
(2609, 38, 'size', '3'),
(2610, 38, '', ''),
(2611, 39, 'stock', '500'),
(2612, 39, 'size', 'regular'),
(2613, 40, 'stock', '300'),
(2614, 40, 'ply', '3'),
(2615, 41, 'volume', '500gr'),
(2616, 41, 'stock ', '500'),
(2617, 41, 'scent', 'aloe'),
(2618, 42, 'stock', '500'),
(2619, 43, 'stock', '250'),
(2620, 44, 'stock', '200'),
(2621, 45, 'stock', '200'),
(2622, 46, 'stock', '2000'),
(2623, 46, 'dosage', '500mg'),
(2624, 47, 'stock ', '10'),
(2625, 47, 'dosage', '200mg'),
(2626, 48, '', ''),
(2627, 49, '', ''),
(2628, 50, '', ''),
(2629, 51, '', ''),
(2630, 52, '', ''),
(2631, 53, '', ''),
(2632, 54, '', ''),
(2633, 55, '', ''),
(2634, 56, '', ''),
(2635, 57, '', ''),
(2636, 58, '', ''),
(2637, 59, '', ''),
(2638, 60, '', ''),
(2639, 61, '', ''),
(2640, 62, '', ''),
(2641, 63, '', ''),
(2642, 64, '', ''),
(2643, 65, '', ''),
(2644, 66, '', ''),
(2645, 67, '', ''),
(2646, 68, '', ''),
(2647, 69, '', ''),
(2648, 70, '', ''),
(2649, 71, '', ''),
(2650, 72, '', ''),
(2651, 73, '', ''),
(2652, 74, '', ''),
(2653, 75, '', ''),
(2654, 76, '', ''),
(2655, 77, '', ''),
(2656, 78, '', ''),
(2657, 79, '', ''),
(2658, 80, '', ''),
(2659, 81, '', ''),
(2660, 82, '', ''),
(2661, 82, 'ghw56', 'twhwhrwh'),
(2662, 83, 'wtwty', 'wytwty'),
(2663, 84, '', ''),
(2664, 85, 'Volume', '500ml'),
(2665, 86, 'volume', '75ml'),
(2666, 87, 'duration', '7 hours'),
(2667, 88, 'volume', '250ml'),
(2668, 89, 'material', 'silicone'),
(2669, 90, 'weight', '400gr'),
(2670, 91, 'weight', '23,5gr'),
(2671, 92, 'Number of different tools', '3'),
(2672, 92, 'Tool', 'Spoon'),
(2673, 93, 'Basic Ingredients', 'Iodine'),
(2674, 93, 'Suggested for', 'Everyone expept pregnant women'),
(2675, 94, 'Power', 'Batteries'),
(2676, 94, 'Frequencies Range', '3 kHz - 3000 GHz'),
(2677, 95, '', '(scrubbers, rubber gloves, kitchen detergent, laundry soap)'),
(2678, 96, '', ''),
(2679, 97, '', ''),
(2680, 98, '', ''),
(2681, 99, '', ''),
(2682, 100, 'volume', '500ml'),
(2683, 101, 'volume', '500g'),
(2684, 102, 'volume', '500g'),
(2685, 103, '', ''),
(2686, 104, 'volume', '500ml'),
(2687, 105, 'volume', '20pieces'),
(2688, 106, 'size', 'XL'),
(2689, 107, '', ''),
(2690, 108, '', ''),
(2691, 109, '', ''),
(2692, 110, '', ''),
(2693, 111, '', ''),
(2694, 112, '', ''),
(2695, 113, '', ''),
(2696, 114, '', ''),
(2697, 115, '', ''),
(2698, 116, '', ''),
(2699, 117, '', ''),
(2700, 118, '', ''),
(2701, 119, '', ''),
(2702, 120, '', ''),
(2703, 121, '', ''),
(2704, 122, '', ''),
(2705, 123, 'Νο 46', ''),
(2706, 124, '', ''),
(2707, 125, 'Adhesive', '2 meters'),
(2708, 126, 'Povidone iodine 10%', '240 ml'),
(2709, 127, '100% Hydrofile', '70gr'),
(2710, 128, 'Quantity per package', '10'),
(2711, 128, 'Packages', '2'),
(2712, 129, 'piece', '10 pieces'),
(2713, 129, '', ''),
(2714, 130, 'pank', '10 packs'),
(2715, 131, 'packet of pills', '20 pills'),
(2716, 132, 'packet of pills', '20 pills'),
(2717, 133, 'pieces', '1'),
(2718, 133, '', ''),
(2719, 134, 'volume', '500ml'),
(2720, 135, 'rolls', '1 roll'),
(2721, 135, '', ''),
(2722, 136, 'volume', '100ml'),
(2723, 137, 'packet', '1 packet'),
(2724, 138, 'pills', '10 pills'),
(2725, 139, '', ''),
(2726, 140, 'weight', '105g'),
(2727, 141, '', ''),
(2728, 142, '6 pack', ''),
(2729, 143, '1', ''),
(2730, 144, '1', ''),
(2731, 145, '', ''),
(2732, 146, 'weight', '45g'),
(2733, 147, 'pcs', '18'),
(2734, 148, 'weight', '100'),
(2735, 149, 'weight', '100'),
(2736, 150, 'weight', '100'),
(2737, 151, 'weight', '200g'),
(2738, 152, '', ''),
(2739, 153, 'volume', '200g'),
(2740, 153, '', ''),
(2741, 154, 'Potency', 'High'),
(2742, 155, '', ''),
(2743, 156, '1', ''),
(2744, 156, '', ''),
(2745, 157, '', '12'),
(2746, 158, '', ''),
(2747, 159, '', '2'),
(2748, 160, 'ml', '500'),
(2749, 161, '', '2'),
(2750, 162, '', '10'),
(2751, 163, '', '20'),
(2752, 164, '', '5'),
(2753, 165, '', '5'),
(2754, 166, 'grams', '1000'),
(2755, 167, 'grams', '500'),
(2756, 168, 'pair', '10'),
(2757, 169, 'grams', '1000'),
(2758, 170, 'grams', '500'),
(2759, 171, 'grams', '1000'),
(2760, 172, 'grams', '500'),
(2761, 173, 'grams', '1000'),
(2762, 174, '', '7'),
(2763, 175, 'grams', '500'),
(2764, 176, '', '5'),
(2765, 177, '', '10'),
(2766, 178, '', '5'),
(2767, 179, '', '5'),
(2768, 180, '', '5'),
(2769, 181, '', '2'),
(2770, 182, '', '3'),
(2771, 183, '', '20'),
(2772, 184, '', '6'),
(2773, 185, '', '10'),
(2774, 186, '10', '600ml'),
(2775, 186, '', ''),
(2776, 187, '67', '1000mg'),
(2777, 188, '10', '330ml'),
(2778, 189, '22', '330'),
(2779, 190, '31', '500ml'),
(2780, 191, '40', '330ml'),
(2781, 192, '23', '500ml'),
(2782, 193, '15', '500ml'),
(2783, 194, '16', 'Mini'),
(2784, 195, '5', 'Medium'),
(2785, 195, '6', 'Large'),
(2786, 195, '10', 'Small'),
(2787, 195, '2', 'XL'),
(2788, 196, '', ''),
(2789, 197, '10', '500mg'),
(2790, 197, '', ''),
(2791, 198, '20', ''),
(2792, 198, '', ''),
(2793, 199, '5', '1.5kg'),
(2794, 200, '20', '200g'),
(2795, 200, '', ''),
(2796, 201, '30', ''),
(2797, 202, '30', '500g'),
(2798, 203, '20', ''),
(2799, 204, 'volume', '500ml'),
(2800, 205, 'quantity', '100'),
(2801, 206, 'iphone', '200'),
(2802, 207, '', ''),
(2803, 208, '', ''),
(2804, 209, 'band', 'UHF/VHF'),
(2805, 209, 'Wi-Fi', '2,4/5,0 GHz'),
(2806, 209, 'Bluetooth', '5.2'),
(2807, 209, 'Οθόνη', '2,4” 320 x 240 px. QVGA'),
(2808, 209, 'διάρκεια ζωής της μπαταρίας', '28 ώρες'),
(2809, 210, 'Frequency', '140-150Mhz'),
(2810, 210, 'Power Supply', '13VDC /- 1V 40A'),
(2811, 210, 'Output RF Power (Nominal)', '30 – 210W ; 230W max AM/FM/CW'),
(2812, 210, 'Modulation Types', 'SSB,CW,AM, FM, data etc (All narrowband modes)'),
(2813, 211, 'PART NUMBER', 'C14Y016X016-T'),
(2814, 211, 'CONTRACTOR NAME:', 'CELINA Tent, Inc'),
(2815, 211, 'COLOR', 'Tan'),
(2816, 211, 'SET-UP TIME/NUMBER OF PERSONS', '4 People/30 Minutes'),
(2817, 212, 'dimensions', ' 20’x32.5’'),
(2818, 212, 'TYPE', 'Frame Structure, Expandable, Air-Transportable'),
(2819, 212, 'WEIGHT', '1,200 lbs'),
(2820, 213, 'TYPE', 'Frame Structure, Expandable, Air- Transportable'),
(2821, 213, 'DIMENSIONS', 'E I-40’x80’'),
(2822, 213, 'WEIGHT', '24,000 lbs'),
(2823, 214, '', ''),
(2824, 215, '', ''),
(2825, 216, '', ''),
(2826, 217, '', ''),
(2827, 218, 'weight', '1k'),
(2828, 219, 'weight', '1k'),
(2829, 220, '', ''),
(2830, 221, '', ''),
(2831, 222, '', ''),
(2832, 223, '', ''),
(2833, 224, '', ''),
(2834, 225, '', ''),
(2835, 226, '', ''),
(2836, 227, '', ''),
(2837, 228, '', ''),
(2838, 229, 'size', '1.90X60'),
(2839, 230, 'light', 'blue'),
(2840, 231, 'pack', '60'),
(2841, 232, 'Volts', '208'),
(2842, 233, 'material', 'plastic'),
(2843, 234, 'Type', 'Digital'),
(2844, 235, 'Material', 'Paper'),
(2845, 236, 'Type', 'Waterproof'),
(2846, 237, '1', '1'),
(2847, 237, '', ''),
(2848, 238, '', '5'),
(2849, 239, '', '10'),
(2850, 240, '', ''),
(2851, 241, '6', '1500ml'),
(2852, 242, '2', '80g'),
(2853, 243, '3', '100g'),
(2854, 244, '1', '800g'),
(2855, 245, '1', ''),
(2856, 246, '', ''),
(2857, 247, '', ''),
(2858, 248, '', ''),
(2859, 249, '', ''),
(2860, 250, '', ''),
(2861, 251, '', ''),
(2862, 252, '', ''),
(2863, 253, 'AAA', '5'),
(2864, 254, '', ''),
(2865, 255, '1', '200ml'),
(2866, 256, '', ''),
(2867, 257, '', ''),
(2868, 258, '', ''),
(2869, 259, '', ''),
(2870, 260, '', ''),
(2871, 261, '', ''),
(2872, 262, '', ''),
(2873, 263, '', ''),
(2874, 264, '', ''),
(2875, 265, '', ''),
(2876, 266, '', ''),
(2877, 267, '', ''),
(2878, 268, 'pages', '230'),
(2879, 269, '', '1kg'),
(2880, 270, '', ''),
(2881, 271, '', ''),
(2882, 272, 'galons', '20'),
(2883, 273, 'quantity', '5'),
(2884, 274, '', ''),
(2885, 275, 'test item ', '1kg'),
(2886, 276, 'volume', '500ml'),
(2887, 276, '', ''),
(2888, 277, 'pills', '60 pills'),
(2889, 15, 'volume', '1l'),
(2890, 15, 'pack size', '6'),
(2891, 16, 'volume', '1.5l'),
(2892, 16, 'pack size', '6'),
(2897, 282, 'weight', '250g'),
(2898, 283, 'brand', 'rio mare'),
(2899, 283, 'weight', '150g'),
(2900, 284, 'brand', 'lacta'),
(2901, 284, 'weight', '230g'),
(2902, 553, 'weight', '200g'),
(2904, 555, 'brand', 'ivi'),
(2905, 556, 'brand', 'lacost');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `register_polites`
--

CREATE TABLE `register_polites` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `register_polites`
--

INSERT INTO `register_polites` (`username`, `password`, `fullname`, `phone`, `latitude`, `longitude`, `role`, `id`) VALUES
('xara', '$2y$10$./McSTap1WpwxPVtBilHMO7JtvFlxl1.3/vcGiGusxonWJPjz/oBq', 'SOFIAXARAPAPA', '6987124724', 38.246613279291175, 21.734518338607018, 'politis', 1),
('admin', '$2y$10$7DD/HSzA0xbm7IVt0routOrE9ZOHInDtCdDX4i/aNkhL7.XB6SRIa', 'SOFIAXARAPAPA', '6987124724', 38.27611152747894, 21.79533523880274, 'admin', 2),
('diaswsths', '$2y$10$8qNUFhQppQ5G7HJcFZdLaOSdoSM0ehLR1nVCguxsJPR66I9vGQYAO', 'SOFIAXARAPAPA', '6987124724', 38.2605181038245, 21.747340042673645, 'diaswsths', 3),
('user1', '7c6a180b36896a0a8c02787eeafb0e4c', 'Πολίτης 1', '1234567890', 38.24186185152443, 21.750712511111715, 'politis', 4),
('user2', '6cb75f652a9b52798eb6cf2201057c73', 'Πολίτης 2', '0987654321', 38.26345615036176, 21.73878359622209, 'politis', 5),
('user3', '819b0643d6b89dc9b579fdfc9094f28e', 'Πολίτης 3', '1231231234', 38.23891020421768, 21.770475744810398, 'politis', 6),
('user4', '34cc93ece0ba9e3f6f235d4af979b16c', 'Πολίτης 4', '9876543210', 38.25818853794428, 21.759986801994952, 'politis', 7),
('user5', 'db0edd04aaac4506f7edab03ac855d56', 'Πολίτης 5', '8765432109', 38.24539039404633, 21.755467551206674, 'politis', 8),
('user6', 'hashed_password6', 'Πολίτης 6', '2100000001', 38.244, 21.731, 'politis', 9),
('user7', 'hashed_password7', 'Πολίτης 7', '2100000002', 38.243, 21.732, 'politis', 10),
('user8', 'hashed_password8', 'Πολίτης 8', '2100000003', 38.242, 21.733, 'politis', 11),
('user9', 'hashed_password9', 'Πολίτης 9', '2100000004', 38.241, 21.734, 'politis', 12),
('user10', 'hashed_password10', 'Πολίτης 10', '2100000005', 38.24, 21.735, 'politis', 13),
('paraskevibotsa', '$2y$10$9Ol5BYvV2TbJLQ2f5.iFTuo2GKJkEOFEa/SKP5nf05J22ap90VmhO', 'Μπότσα Παρασκευή', '6987909876', 38.24602598929305, 21.734166734546466, 'politis', 14),
('maria', '$2y$10$U2vkyBslNaLpd0M4/t.GLO4/uwCxdWxmg8dV7fDC/aLO68p3KhSna', 'Maria Iwannou', '6987124724', 38.24840404901203, 21.736478222423774, NULL, 15),
('xaras', '$2y$10$D1qtaLLBCvOEsNWsmMfpV.GwYaxbxUusrUeJ..3njfD8oSlj8eLd2', 'xaras sdkd', '6987124724', 38.251909064688896, 21.743170444068816, 'politis', 16);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `requests_offers`
--

CREATE TABLE `requests_offers` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `item` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_taken` datetime DEFAULT NULL,
  `vehicle` int(11) DEFAULT NULL,
  `rescuer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `requests_offers`
--

INSERT INTO `requests_offers` (`id`, `type`, `username`, `item`, `quantity`, `phone`, `status`, `date_created`, `date_taken`, `vehicle`, `rescuer_id`) VALUES
(35, 'request', 'user1', 'Νερό', 10, '1234567890', 'pending', '2024-09-06 20:38:55', NULL, NULL, NULL),
(36, 'request', 'user1', 'Φάρμακα', 5, '1234567890', 'pending', '2024-09-06 20:38:55', NULL, NULL, NULL),
(37, 'request', 'user1', 'Φαγητό', 20, '1234567890', 'accepted', '2024-09-06 20:38:55', '2024-09-15 17:28:37', 2, 14),
(38, 'request', 'user2', 'Ρούχα', 15, '0987654321', 'pending', '2024-09-06 20:38:55', NULL, NULL, NULL),
(39, 'request', 'user2', 'Νερό', 8, '0987654321', 'accepted', '2024-09-06 20:38:55', '2024-09-15 16:58:45', 5, 6),
(40, 'request', 'user3', 'Φαγητό', 10, '1231231234', 'pending', '2024-09-06 20:38:55', NULL, NULL, NULL),
(41, 'offer', 'user4', 'Νερό', 20, '9876543210', 'accepted', '2024-09-06 20:39:07', '2024-09-16 16:18:07', 5, 6),
(42, 'offer', 'user4', 'Φάρμακα', 10, '9876543210', 'accepted', '2024-09-06 20:39:07', '2024-09-15 17:34:02', 2, 14),
(43, 'offer', 'user5', 'Φαγητό', 30, '8765432109', 'pending', '2024-09-06 20:39:07', NULL, NULL, NULL),
(44, 'request', 'user2', 'Φάρμακα', 10, '0987654321', 'accepted', '2024-09-08 21:24:47', '2024-09-15 17:33:54', 2, 14),
(46, 'request', 'user3', 'Ρούχα', 8, '1231231234', 'accepted', '2024-09-08 21:24:47', '2024-09-16 17:40:48', 5, 6),
(47, 'request', 'user3', 'Φάρμακα', 6, '1231231234', 'pending', '2024-09-08 21:24:47', NULL, NULL, NULL),
(48, 'request', 'user3', 'Νερό', 12, '1231231234', 'pending', '2024-09-08 21:24:47', '2024-09-13 16:45:41', NULL, NULL),
(49, 'offer', 'user4', 'Κουβέρτες', 10, '9876543210', 'pending', '2024-09-08 21:25:19', NULL, NULL, NULL),
(50, 'offer', 'user5', 'Ρούχα', 15, '8765432109', 'pending', '2024-09-08 21:25:19', NULL, NULL, NULL),
(51, 'offer', 'user5', 'Φάρμακα', 7, '8765432109', 'pending', '2024-09-08 21:25:19', '2024-09-11 22:51:18', NULL, NULL),
(52, 'request', 'user1', 'Ρούχα', 2, '1234567890', 'pending', '2024-09-06 20:38:55', NULL, NULL, NULL),
(53, 'request', 'user6', 'Φαγητό', 5, '2100000001', 'pending', '2024-09-08 22:00:00', NULL, NULL, NULL),
(54, 'request', 'user6', 'Νερό', 10, '2100000001', 'pending', '2024-09-08 22:01:00', NULL, NULL, NULL),
(55, 'request', 'user7', 'Ρούχα', 3, '2100000002', 'pending', '2024-09-08 22:05:00', NULL, NULL, NULL),
(56, 'offer', 'user8', 'Φαγητό', 6, '2100000003', 'pending', '2024-09-08 22:10:00', NULL, NULL, NULL),
(57, 'offer', 'user9', 'Νερό', 15, '2100000004', 'accepted', '2024-09-08 22:12:00', '2024-09-15 17:33:57', 2, 14),
(58, 'offer', 'user10', 'Ρούχα', 4, '2100000005', 'accepted', '2024-09-08 22:15:00', '2024-09-14 19:43:14', 5, 6),
(59, 'offer', 'user8', 'κουβέρτες', 6, '2100000003', 'pending', '2024-09-10 22:10:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `rescuers`
--

CREATE TABLE `rescuers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `current_latitude` double NOT NULL,
  `current_longitude` double NOT NULL,
  `assigned_tasks` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `rescuers`
--

INSERT INTO `rescuers` (`id`, `username`, `password`, `role`, `current_latitude`, `current_longitude`, `assigned_tasks`) VALUES
(2, 'leo', '$2y$10$os6TOiP17NieMS2RzsYDA.Thc/D2rQuRBVFbGuYBT5/U7iBVNyRWC', '', 0, 0, 0),
(3, 'hara', '$2y$10$H4Ej78S7/1cROOE8.9ewgulEwdfE4150BeOvDsSxRwJc4FpyTv//C', '', 0, 0, 0),
(6, 'diaswsths_xara', '$2y$10$AdTmQU6SNc1rdw8/gUnvPOzRn9uE/zMBJwd0BqdwMv5MlnIm2zT2u', 'diaswsths', 38.24186185152443, 21.753712511111715, 3),
(7, 'diaswsths_parask', '$2y$10$4/f/E8QirJvvijXXceWh2.7ezhJmRL6P4kg73b1hfg98nap0tfJsm', 'diaswsths', 0, 0, 0),
(14, 'diaswsths_leo', '$2y$10$AUMcEXormYh9RQKspFaoReciUOiPM6XK9KRcf5AT39XTBmhfP.Qk2', 'diaswsths', 0, 0, 0),
(15, 'iasonas', '$2y$10$uMIQqk1iOopZoNeHkTuRrupN9nOp7q6i5kC1dbRpcd5h17SSBtqE6', 'diaswsths', 0, 0, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `load` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tasks` text DEFAULT NULL,
  `rescuer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `vehicles`
--

INSERT INTO `vehicles` (`id`, `username`, `lat`, `lng`, `load`, `status`, `tasks`, `rescuer_id`) VALUES
(2, 'vehicle2', 38.245, 21.735, 'τρόφιμα', 'active', '[]', 14),
(4, 'vehicle1', 38.248, 21.734, 'νερό', 'active', '[\r\n    {\"type\": \"request\", \"lat\": 38.24186185152443, \"lng\": 21.750712511111715, \"username\": \"user1\", \"item\": \"Νερό\", \"quantity\": 10, \"phone\": \"1234567890\", \"date_taken\": \"2024-09-06\", \"vehicle\": \"vehicle1\"},\r\n    {\"type\": \"request\", \"lat\": 38.26345615036176, \"lng\": 21.73878359622209, \"username\": \"user2\", \"item\": \"Ρούχα\", \"quantity\": 15, \"phone\": \"0987654321\", \"date_taken\": \"2024-09-06\", \"vehicle\": \"vehicle1\"}\r\n]', NULL),
(5, 'vehicle3', 38.24616836503374, 21.735419752309017, '', 'active', '[]', 6),
(7, 'vehicle4', 38.34667394554472, 21.737308502197266, '', 'active', '[]', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `vehicle_cargo`
--

CREATE TABLE `vehicle_cargo` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `vehicle_cargo`
--

INSERT INTO `vehicle_cargo` (`id`, `vehicle_id`, `product_id`, `quantity`) VALUES
(1, 5, 15, 10);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `announcement_items`
--
ALTER TABLE `announcement_items`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `base_location`
--
ALTER TABLE `base_location`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `register_polites`
--
ALTER TABLE `register_polites`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `requests_offers`
--
ALTER TABLE `requests_offers`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `rescuers`
--
ALTER TABLE `rescuers`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rescuer_vehicle` (`rescuer_id`);

--
-- Ευρετήρια για πίνακα `vehicle_cargo`
--
ALTER TABLE `vehicle_cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcement_items`
--
ALTER TABLE `announcement_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT για πίνακα `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;

--
-- AUTO_INCREMENT για πίνακα `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2906;

--
-- AUTO_INCREMENT για πίνακα `register_polites`
--
ALTER TABLE `register_polites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT για πίνακα `requests_offers`
--
ALTER TABLE `requests_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT για πίνακα `rescuers`
--
ALTER TABLE `rescuers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT για πίνακα `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT για πίνακα `vehicle_cargo`
--
ALTER TABLE `vehicle_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `fk_rescuer_id` FOREIGN KEY (`rescuer_id`) REFERENCES `rescuers` (`id`),
  ADD CONSTRAINT `fk_rescuer_vehicle` FOREIGN KEY (`rescuer_id`) REFERENCES `rescuers` (`id`);

--
-- Περιορισμοί για πίνακα `vehicle_cargo`
--
ALTER TABLE `vehicle_cargo`
  ADD CONSTRAINT `vehicle_cargo_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_cargo_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
