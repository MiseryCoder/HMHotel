-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 03:45 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hmhoteldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_details`
--

CREATE TABLE `about_details` (
  `settings_ID` int(11) NOT NULL,
  `site_title` varchar(100) NOT NULL,
  `site_about` varchar(5000) NOT NULL,
  `site_mission` varchar(2000) NOT NULL,
  `site_vision` varchar(2000) NOT NULL,
  `shutdown` tinyint(1) NOT NULL,
  `Online_payment` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_details`
--

INSERT INTO `about_details` (`settings_ID`, `site_title`, `site_about`, `site_mission`, `site_vision`, `shutdown`, `Online_payment`) VALUES
(1, 'HM Hotel Pasig', 'The Pamantasan ng Lungsod ng Pasig (PLP) HRM Multi-purpose Building is a Serbisyong May Puso Project of the City Government of Pasig envisioned during the compassionate administration of Mayor Maribel Andaya Eusebio designed as a training facility for world class studentry.\nThe PLP-HRM Multi-Purpose Building consists of amenities that blends aesthetics and functionality and creates an environment meant to inspire the youth to conquer the limitless world of knowledge. It boosts of hotel like rooms (standard bedrooms, deluxe rooms, 1 bedroom and 2 bedroom suites and presidential suites), banquet hall, conference rooms, hot and cold cooking laboratories; computer laboratories; lecture rooms; communications room; mechatronics and robotics room; E.C.E. equipment room, al fresco dining, and a wide parking for its stakeholders.\nThe PLP-HRM multipurpose building is a testament to the City Government\'s firm commitment to provide the best quality affordable tertiary education for the youth of this beautiful Green City of Pasig.\nInaugurated today, the 25th day of July, in the year of our Lord 2018.\n', 'To provide relevant, purposive, innovative, value laden, community based, and life long learning opportunities to ensure maximum and full development of potentials, competencies and character needed to become responsible, disciplined, productive, patriotic, God loving and globally competitive professional who are contributory in uplifting the quality of life in the community.\n', 'A peaceful and progressive community where Pasigueños enjoy the best quality of life gained through experiences, exposures, and immersions that are directed for holistic personality development, character and values formation, social commitment and community involvement, enhancement of potentials and appreciation of culture and arts.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `bookingdet_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_name_prev` varchar(255) DEFAULT NULL,
  `room_no_upgrade` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(50) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `time_slot_start` time NOT NULL,
  `time_slot_end` time NOT NULL,
  `extended_price` int(11) NOT NULL,
  `num_of_extensions` int(11) NOT NULL,
  `expires_time` time NOT NULL DEFAULT '12:00:00',
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'Pending',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  `trans_amt` int(11) NOT NULL,
  `discounted_amt` int(11) NOT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `rate_review` int(11) DEFAULT NULL,
  `discounted` int(11) NOT NULL DEFAULT 0,
  `discount_percent` int(11) NOT NULL,
  `room_upgrade` int(11) NOT NULL DEFAULT 0,
  `upgrade_price` int(11) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `carousel_id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`carousel_id`, `image`) VALUES
(2, 'IMG_80218.png'),
(3, 'IMG_18236.png'),
(4, 'IMG_29906.png'),
(5, 'IMG_95449.png'),
(6, 'IMG_94517.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `contact_ID` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` varchar(30) NOT NULL,
  `pn2` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `instagram` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `iframe` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`contact_ID`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `instagram`, `twitter`, `iframe`) VALUES
(1, '12-B Alcalde Jose Pasig 1600 Metro Manila', 'https://goo.gl/maps/Hct9tB1UWaVrmhxr7', '09394264248', '09394264248', 'HMHotel@plpasig.edu.ph', 'https://www.facebook.com/', 'https://www.google.com/', 'https://twitter.com/', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.6467614955322!2d121.07263991477016!3d14.562181581921251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c879182bfdc7:0x9f0705c7d0b99ad0!2s12-B Alcalde Jose, Pasig, 1600 Metro Manila!5e0!3m2!1sen!2sph!4v1670145179488!5m2!1sen!2sph');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(2, '', '1 Microwave Oven', ''),
(3, '', '1 Mini Refrigerator', ''),
(4, '', '1 Air-condition', ''),
(5, '', '1 Electric Kettle', ''),
(6, '', '1 Telephone', ''),
(7, 'IMG_77676.jpg', 'Telephone', '1'),
(8, 'IMG_28998.jpg', 'LED TV 32\"', '1'),
(9, 'IMG_96274.jpg', 'Hand Dryer Mediclinics', '1'),
(10, 'IMG_49611.jpg', 'LED TV 50\"', '1'),
(11, 'IMG_30229.jpg', 'Microwave Oven', '1'),
(12, 'IMG_92922.jpg', 'Electric Kettle', '1'),
(13, 'IMG_77594.jpg', 'Coffee Maker', '1'),
(14, 'IMG_48437.jpg', 'Slipper', '1'),
(15, 'IMG_51988.jpg', 'Bathrobe', '1'),
(16, 'IMG_25913.jpg', 'Bath Towel', '1'),
(17, 'IMG_41973.jpg', '2 LED TV 50\"', '1'),
(18, 'IMG_29363.jpg', 'Hair Blower', '1'),
(19, 'IMG_12618.jpg', 'TV Plus', '1'),
(20, 'IMG_19189.jpg', 'Aircon Ceiling Cassette', '1'),
(21, 'IMG_14289.jpg', 'Slippers', '1'),
(22, 'IMG_41095.jpg', 'Emergency Light', '1'),
(23, 'IMG_54578.jpg', 'Aircon Split Type', '1'),
(24, 'IMG_40378.jpg', 'Vault', '1'),
(25, 'IMG_89363.jpg', 'Hair Dryer', '1'),
(26, 'IMG_41071.jpg', 'Tissue Dispenser', '1'),
(27, 'IMG_97801.jpg', 'Tissue Holder', '1'),
(28, 'IMG_32227.jpg', '2 LED TV 32\"', '1'),
(29, 'IMG_14812.jpg', 'Television', '1');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(8, 'Kitchenette'),
(10, 'Sala Set (3 Seaters)'),
(11, 'Dining Set (6 Seaters)'),
(12, 'Bedside Table (with 2 Drawers)'),
(14, 'King Size Bed (with Button Tufted Headboard)'),
(16, 'Outdoor Coffee Dining Set (4 Seaters)'),
(17, 'Shower Glass Cubicle'),
(18, 'Single Sofa (with Foot Rest Lounge Chair with Otto'),
(19, 'Sofa Set (3 Seaters)'),
(20, 'Single Sofa Wing Chair'),
(21, 'Single Sofa (with Armrest Writing Chair Garnell Br'),
(22, 'Queen Size Bed (with Headboard)'),
(23, 'Clerical Mirror'),
(24, 'Plate Rack (Inside Cabinet)'),
(25, 'Queen Size Bed (with Button Tufted Headboard)'),
(26, 'Sofa Set (2 Seaters)'),
(27, 'Dining Table (4 Seaters)'),
(28, 'Single Seater Sofa'),
(29, 'Center Table (with Mirror Top)'),
(30, 'Plate Rack'),
(31, 'Tray Installed in Cabinet'),
(32, '3 Seaters Sofa'),
(33, 'Single Sofa'),
(34, '2 Queen Size Bed (with Button Tufted Headboard)'),
(35, 'Single Bed'),
(36, 'Cutlery Set');

-- --------------------------------------------------------

--
-- Table structure for table `guests_users`
--

CREATE TABLE `guests_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(120) NOT NULL,
  `bday` date NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `idpic` varchar(100) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `management_users`
--

CREATE TABLE `management_users` (
  `m_id` int(11) NOT NULL,
  `m_email` varchar(150) NOT NULL,
  `m_name` varchar(150) NOT NULL,
  `m_phone` varchar(150) NOT NULL,
  `m_address` varchar(255) NOT NULL,
  `m_password` varchar(150) NOT NULL,
  `m_type` varchar(150) NOT NULL,
  `l_type` varchar(255) NOT NULL,
  `expiration_time` datetime DEFAULT NULL,
  `otp` int(11) NOT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `approved` int(11) NOT NULL DEFAULT 0,
  `verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `management_users`
--

INSERT INTO `management_users` (`m_id`, `m_email`, `m_name`, `m_phone`, `m_address`, `m_password`, `m_type`, `l_type`, `expiration_time`, `otp`, `datentime`, `approved`, `verified`) VALUES
(12, 'hmhoteladmin@gmail.com', 'hmhotel', '09123456789', 'admin admin', '$2y$10$akm4RcOXJQV95dCKPdkClewYeJ50sNEKRjPuL8Qd1/0VtFdBH6zEW', 'Management', 'direct', '2023-07-31 13:35:33', 596927, '2023-07-31 13:32:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paypal_payments`
--

CREATE TABLE `paypal_payments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `rating_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(300) NOT NULL,
  `sentiment` varchar(255) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `type` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `room_ntype` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `type`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `room_ntype`, `status`, `removed`) VALUES
(1, 'Presidential Suite', 100, 2500, 2, 2, 1, '', 'Room', 1, 0),
(2, 'Bedroom Suite', 100, 2000, 1, 4, 1, '', 'Room', 1, 0),
(3, 'Suite Room', 100, 2000, 2, 2, 1, '', 'Room', 1, 0),
(5, 'Deluxe Room', 100, 1500, 2, 4, 1, '', 'Room', 1, 0),
(6, 'Standard Room', 100, 1000, 3, 2, 1, '', 'Room', 1, 0),
(9, 'Banquet Hall', 150, 10000, 1, 150, 1, '', 'Facility', 1, 0),
(10, 'Function Hall', 200, 5000, 1, 100, 1, '', 'Facility', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `roomfac_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`roomfac_id`, `room_id`, `facilities_id`) VALUES
(67, 1, 7),
(68, 1, 8),
(69, 1, 9),
(70, 1, 11),
(71, 1, 12),
(72, 1, 13),
(73, 1, 14),
(74, 1, 15),
(75, 1, 16),
(76, 1, 17),
(77, 1, 18),
(78, 1, 19),
(79, 1, 20),
(247, 3, 7),
(248, 3, 9),
(249, 3, 12),
(250, 3, 13),
(251, 3, 15),
(252, 3, 16),
(253, 3, 19),
(254, 3, 20),
(255, 3, 21),
(256, 3, 22),
(257, 3, 23),
(258, 3, 24),
(259, 3, 25),
(260, 5, 7),
(261, 5, 8),
(262, 5, 9),
(263, 5, 11),
(264, 5, 15),
(265, 5, 16),
(266, 5, 19),
(267, 5, 20),
(268, 5, 21),
(269, 5, 22),
(270, 5, 23),
(271, 5, 24),
(272, 5, 26),
(286, 6, 7),
(287, 6, 9),
(288, 6, 11),
(289, 6, 12),
(290, 6, 13),
(291, 6, 15),
(292, 6, 16),
(293, 6, 19),
(294, 6, 20),
(295, 6, 21),
(296, 6, 22),
(297, 6, 27),
(298, 6, 28),
(321, 2, 7),
(322, 2, 8),
(323, 2, 9),
(324, 2, 11),
(325, 2, 12),
(326, 2, 13),
(327, 2, 15),
(328, 2, 16),
(329, 2, 19),
(330, 2, 20),
(331, 2, 21);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `rfeatures_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`rfeatures_id`, `room_id`, `features_id`) VALUES
(56, 1, 8),
(57, 1, 10),
(58, 1, 11),
(59, 1, 12),
(60, 1, 14),
(61, 1, 16),
(62, 1, 17),
(63, 1, 18),
(169, 3, 8),
(170, 3, 12),
(171, 3, 14),
(172, 3, 18),
(173, 3, 25),
(174, 3, 28),
(175, 3, 30),
(176, 3, 31),
(177, 3, 32),
(178, 5, 12),
(179, 5, 25),
(180, 5, 33),
(181, 5, 34),
(182, 5, 35),
(187, 6, 12),
(188, 6, 14),
(189, 6, 25),
(190, 6, 33),
(191, 6, 36),
(212, 2, 8),
(213, 2, 11),
(214, 2, 12),
(215, 2, 20),
(216, 2, 21),
(217, 2, 22),
(218, 2, 23),
(219, 2, 24),
(220, 2, 25),
(221, 2, 32);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `rimages_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`rimages_id`, `room_id`, `image`, `thumb`) VALUES
(33, 1, 'IMG_43834.jpg', 0),
(35, 1, 'IMG_56438.jpg', 1),
(36, 1, 'IMG_66299.jpg', 0),
(37, 1, 'IMG_24763.jpg', 0),
(38, 1, 'IMG_34456.jpg', 0),
(39, 1, 'IMG_46045.jpg', 0),
(40, 1, 'IMG_96766.jpg', 0),
(41, 1, 'IMG_58455.jpg', 0),
(42, 1, 'IMG_28525.jpg', 0),
(43, 1, 'IMG_69397.jpg', 0),
(44, 1, 'IMG_57209.jpg', 0),
(45, 1, 'IMG_23873.jpg', 0),
(46, 1, 'IMG_93103.jpg', 0),
(47, 1, 'IMG_52275.jpg', 0),
(48, 2, 'IMG_44555.jpg', 1),
(49, 2, 'IMG_61826.jpg', 0),
(50, 2, 'IMG_38998.jpg', 0),
(51, 2, 'IMG_45886.jpg', 0),
(52, 2, 'IMG_71261.jpg', 0),
(53, 2, 'IMG_59190.jpg', 0),
(54, 2, 'IMG_11182.jpg', 0),
(55, 3, 'IMG_42488.jpg', 0),
(56, 3, 'IMG_90613.jpg', 1),
(57, 3, 'IMG_66346.jpg', 0),
(58, 3, 'IMG_57574.jpg', 0),
(59, 3, 'IMG_78843.jpg', 0),
(60, 3, 'IMG_53715.jpg', 0),
(61, 5, 'IMG_34582.jpg', 1),
(62, 5, 'IMG_42589.jpg', 0),
(63, 5, 'IMG_69344.jpg', 0),
(64, 5, 'IMG_67025.jpg', 0),
(65, 5, 'IMG_72287.jpg', 0),
(66, 5, 'IMG_52865.jpg', 0),
(67, 5, 'IMG_72010.jpg', 0),
(68, 5, 'IMG_27586.jpg', 0),
(69, 6, 'IMG_63186.jpg', 0),
(70, 6, 'IMG_24402.jpg', 1),
(72, 6, 'IMG_28810.jpg', 0),
(73, 6, 'IMG_52450.jpg', 0),
(74, 6, 'IMG_88063.jpg', 0),
(75, 6, 'IMG_85327.jpg', 0),
(77, 6, 'IMG_43667.jpg', 0),
(78, 6, 'IMG_87794.jpg', 0),
(79, 6, 'IMG_19182.jpg', 0),
(81, 6, 'IMG_79801.jpg', 0),
(82, 6, 'IMG_44569.jpg', 0),
(83, 6, 'IMG_86089.jpg', 0),
(84, 6, 'IMG_46328.jpg', 0),
(85, 9, 'IMG_16508.jpg', 1),
(86, 9, 'IMG_46416.jpg', 0),
(87, 9, 'IMG_58978.jpg', 0),
(88, 9, 'IMG_96049.jpg', 0),
(89, 9, 'IMG_55228.jpg', 0),
(90, 9, 'IMG_45705.jpg', 0),
(91, 9, 'IMG_32721.jpg', 0),
(92, 9, 'IMG_83405.jpg', 0),
(93, 9, 'IMG_23700.jpg', 0),
(94, 9, 'IMG_96504.jpg', 0),
(95, 9, 'IMG_40161.jpg', 0),
(96, 10, 'IMG_81351.jpg', 0),
(97, 10, 'IMG_35895.jpg', 1),
(98, 10, 'IMG_90036.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_no`
--

CREATE TABLE `room_no` (
  `id` int(11) NOT NULL,
  `room_nos` int(11) NOT NULL,
  `room_avail` varchar(255) NOT NULL DEFAULT 'available',
  `room_status` varchar(255) NOT NULL DEFAULT 'VC'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_no`
--

INSERT INTO `room_no` (`id`, `room_nos`, `room_avail`, `room_status`) VALUES
(1, 701, 'Checked-In', 'OC'),
(4, 702, 'Avaliable', 'VR'),
(5, 703, 'Avaliable', 'VR'),
(6, 704, 'Avaliable', 'VR'),
(7, 705, 'Avaliable', 'VR'),
(8, 706, 'Avaliable', 'VR'),
(9, 707, 'Avaliable', 'VR'),
(10, 708, 'Avaliable', 'VR'),
(11, 709, 'Checked-Out', 'OD'),
(12, 710, 'Avaliable', 'VR'),
(15, 711, 'available', 'VC');

-- --------------------------------------------------------

--
-- Table structure for table `room_no_data`
--

CREATE TABLE `room_no_data` (
  `rno_data_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_no_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_no_data`
--

INSERT INTO `room_no_data` (`rno_data_id`, `room_id`, `room_no_id`) VALUES
(36, 1, 1),
(37, 1, 4),
(61, 3, 6),
(62, 3, 7),
(63, 5, 8),
(64, 5, 9),
(68, 6, 10),
(69, 6, 11),
(70, 6, 12),
(73, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `systemlog`
--

CREATE TABLE `systemlog` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `team_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`team_id`, `name`, `picture`) VALUES
(24, 'hayley', 'IMG_15178.jpg'),
(25, 'hayley', 'IMG_56878.jpg'),
(26, 'hayley', 'IMG_27365.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `uqueries_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `sentiment` varchar(255) NOT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seen` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_details`
--
ALTER TABLE `about_details`
  ADD PRIMARY KEY (`settings_ID`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`bookingdet_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`carousel_id`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`contact_ID`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests_users`
--
ALTER TABLE `guests_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `management_users`
--
ALTER TABLE `management_users`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `paypal_payments`
--
ALTER TABLE `paypal_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paypal_payments_ibfk_1` (`customer_id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`roomfac_id`),
  ADD KEY `facilities id` (`facilities_id`),
  ADD KEY `room id` (`room_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`rfeatures_id`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `rm id` (`room_id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`rimages_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `room_no`
--
ALTER TABLE `room_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_no_data`
--
ALTER TABLE `room_no_data`
  ADD PRIMARY KEY (`rno_data_id`),
  ADD KEY `room_no_data_ibfk_1` (`room_id`),
  ADD KEY `room_no_id` (`room_no_id`);

--
-- Indexes for table `systemlog`
--
ALTER TABLE `systemlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`uqueries_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_details`
--
ALTER TABLE `about_details`
  MODIFY `settings_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `bookingdet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `carousel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `guests_users`
--
ALTER TABLE `guests_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `management_users`
--
ALTER TABLE `management_users`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `paypal_payments`
--
ALTER TABLE `paypal_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `roomfac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `rfeatures_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `rimages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `room_no`
--
ALTER TABLE `room_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `room_no_data`
--
ALTER TABLE `room_no_data`
  MODIFY `rno_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `systemlog`
--
ALTER TABLE `systemlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `uqueries_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `paypal_payments`
--
ALTER TABLE `paypal_payments`
  ADD CONSTRAINT `paypal_payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `booking_order` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
