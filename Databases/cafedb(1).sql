-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 12:41 PM
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
-- Database: `cafedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `category`, `image`, `created_at`) VALUES
(1, 'CRISPY CHICKEN BURGER ', 'crispy chicken wedged between a homemade\\r\\nbun with cheese, tomato, caramelized onions,\\r\\npickled gherkins, jalapenos, lettuce and honey\\r\\nmustard mayo.', 2150.00, 'Burger & Tacos', '../uploads/food_6682889b42c0c9.89363743.png', '2024-07-01 10:44:43'),
(2, 'DISHOOM PAKORA BURGER ', 'a crispy deep fried veggie patty (pakora style),\r\nwedged between a homemade bun with mint\r\nraita, mango chutney, onion and coriander\r\nsalad. served with\r\na side of baby potatoes', 1890.00, 'Burger & Tacos', '../uploads/food_66828949dce2d5.64332073.png', '2024-07-01 10:47:37'),
(3, 'PRAWN TACO', 'two soft shell tacos served with pan-fried prawns,\r\nmixed cabbage, guacamole, mango salsa,\r\ngarnished with pickled onions and spicy honey\r\nmustard mayo. comes with a side of chimichurri', 2350.00, 'Burger & Tacos', '../uploads/food_66828b3d7684d7.79975900.jpeg', '2024-07-01 10:55:57'),
(4, 'FISH TACO', 'two soft shell tacos served with crispy fish,\r\nred cabbage, mango salsa and finished off with\r\nsriracha mayo. comes with a side of chimichurr', 2490.00, 'Burger & Tacos', '../uploads/food_66828bca475b08.67637143.jpeg', '2024-07-01 10:58:18'),
(5, 'Sri Lankan Rice and Curry', 'A traditional meal featuring steamed rice accompanied by a variety of curries, including dhal (lentil curry), meat or fish curry, and vegetable curries. It’s often served with sambol (spicy condiment).', 1750.00, 'Sri Lankan', '../uploads/food_66a3cfb6d5b3a4.92079679.jpg', '2024-07-26 16:32:54'),
(6, 'Kottu Roti', 'A stir-fry dish made with chopped roti (flatbread), vegetables, eggs, and meat or seafood. It’s flavored with spices and often served with curry.', 2400.00, 'Sri Lankan', '../uploads/food_66a3d0bc3e78f9.69053449.jpg', '2024-07-26 16:37:16'),
(8, 'Buriyani', 'A flavorful rice dish cooked with spices, meat (usually chicken, beef, or mutton), and sometimes vegetables. It’s often garnished with fried onions, nuts, and raisins.', 2200.00, 'Sri Lankan', '../uploads/food_66a3d3085660b0.45318874.jpg', '2024-07-26 16:47:04'),
(9, 'Dumplings', 'Steamed or fried dough pockets filled with ground meat (pork, chicken, or beef) and vegetables. They can also be filled with seafood or be vegetarian.', 1890.00, 'Chineese', '../uploads/food_66a3d408e1cad6.13181415.jpg', '2024-07-26 16:51:20'),
(10, 'Sweet and Sour Pork', 'Crispy pork pieces tossed in a tangy sweet and sour sauce with bell peppers, onions, and pineapple chunks.', 1950.00, 'Chineese', '../uploads/food_66a3d493623ca2.94656778.jpg', '2024-07-26 16:53:39'),
(11, 'Chow Mein', 'Crispy fried noodles with vegetables and meat or seafood, often served with a light soy-based sauce.\r\n', 1790.00, 'Chineese', '../uploads/food_66a3d59c78dae4.77801121.jpg', '2024-07-26 16:58:04'),
(12, 'Chocolate Lava Cake', 'A rich and gooey chocolate cake with a molten center that oozes out when cut. Often served warm with a dusting of powdered sugar and a scoop of vanilla ice cream.', 1150.00, 'Desserts', '../uploads/food_66a769c80cde71.59473668.jpg', '2024-07-29 10:07:04'),
(13, 'Tiramisu', 'An Italian classic made with layers of coffee-soaked ladyfingers and mascarpone cheese, dusted with cocoa powder. Its creamy texture and coffee flavor make it a favorite.\r\n', 1350.00, 'Desserts', '../uploads/food_66a76a39bc5ee9.80156788.jpg', '2024-07-29 10:08:57'),
(14, 'Cheesecake', 'A creamy and dense dessert with a graham cracker crust and a smooth cheese filling. It can be topped with various fruits, chocolate, or caramel.', 1190.00, 'Desserts', '../uploads/food_66a76abcc04547.93873451.jpg', '2024-07-29 10:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_status` enum('Placed','Processing','Packed','Delivered','Served','Cancelled') NOT NULL DEFAULT 'Placed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `customer_id`, `customer_name`, `order_number`, `order_date`, `total`, `order_status`) VALUES
(1, 0, 'Sunitha padmini', '66a29718c8f21', '0000-00-00 00:00:00', 4540.00, 'Placed'),
(2, 0, 'Ishara Manage', '66a640106346a', '0000-00-00 00:00:00', 6750.00, 'Placed');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `customer_id`, `item_title`, `item_price`, `item_quantity`) VALUES
(0, '66a29718c8f21', 1, 'CRISPY CHICKEN BURGER', 2650.00, 1),
(0, '66a29718c8f21', 1, 'DISHOOM PAKORA BURGER', 1890.00, 1),
(0, '66a640106346a', 2, 'Kottu Roti', 2400.00, 2),
(0, '66a640106346a', 2, 'Sweet and Sour Pork', 1950.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `table_choice` varchar(255) NOT NULL,
  `meal` varchar(255) NOT NULL,
  `reservation_status` enum('requested','confirmed','cancelled','finished') DEFAULT 'requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `timestamp`, `username`, `phonenumber`, `date`, `table_choice`, `meal`, `reservation_status`) VALUES
(3, '2024-07-01 14:00:28', 'Omasha Manage', '0704109744', '2024-11-07', 'Table 4', 'dinner', 'requested'),
(4, '2024-07-29 09:14:23', 'Oma Manage', '0711754764', '2024-07-30', 'Duos_Delight', 'breakfast', 'requested');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `acc_type` enum('customer','admin','staff') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`id`, `username`, `image`, `phonenumber`, `address`, `email`, `password`, `acc_type`) VALUES
(16, 'Sunitha Padmini', '../uploads/profile_66a023752bca61.85491176.jpg', '0711111111', '31/2, beach road, matara', '12@gmail.com', '$2y$10$IShd/zjsV70QaIKfgbY0numqU6Vfu6K0pK3qURuIR2w/Q1235MNcy', 'staff'),
(18, 'Omasha Manage', '../uploads/profile_66a517a6217918.12453882.jpg', '0704109744', '31/2, beach road, matara', 'omasha@gmail.com', '$2y$10$k3QJH3oteOI6PWk/bHYsZe23thS1Pei8BpofVC.5ddE1UBDrNNhRm', 'admin'),
(19, 'Oma Manage', '../uploads/profile_66a54617662f22.11813851.jpg', '0711754764', '31/2, beach road, matara', 'omasha@gmail.com', '$2y$10$OxIIxGcoyWLx9JWVuc1EqewokYruSZRfdqt03uIYsKiBrEakStsIy', 'customer'),
(21, 'Ishara Manage', '../uploads/profile_66a615ee27c5d0.94661848.jpeg', '0711234565', '31/2, beach road, matara', 'ishara@gmail.com', '$2y$10$xMpr7uw5N5gonll4HbnnnOancKXYQ/Fu9oV.GJSigj0Rtx/xzpyIC', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
