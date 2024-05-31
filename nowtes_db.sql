-- phpMyAdmin SQL Dump
-- version 5.2.1-4.fc40
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 29, 2024 at 08:12 AM
-- Server version: 10.11.6-MariaDB
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `LTN`

DROP DATABASE IF EXISTS nowtes;
CREATE DATABASE nowtes
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
USE nowtes;

-- Table structure for table `billing`

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `bills` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `billing`

INSERT INTO `billing` (`id`, `bills`) VALUES
(1, 'Free Plan'),
(2, 'Pro'),
(3, 'Business');

-- Table structure for table `color`

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `color` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `color`

INSERT INTO `color` (`id`, `color`) VALUES
(1, 'Yellow'),
(2, 'SkyBlue'),
(3, 'Red'),
(4, 'Cyan'),
(5, 'Purple');

-- Table structure for table `note`

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_color` int(11) NOT NULL,
  `title` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `task`

CREATE TABLE `task` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_user` INT(11) NOT NULL,
    `id_color` INT(11) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `due_date` DATE,
    `priority` ENUM('low', 'medium', 'high') DEFAULT 'medium',
    `status` ENUM('pending', 'completed') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table structure for table `user`

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pswd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bill_type` int(11) NOT NULL DEFAULT 1,
  `note_nb` int(11) NOT NULL DEFAULT 0,
  `last_maj` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `last_cnx` datetime NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Indexes for dumped tables

-- Indexes for table `billing`
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `color`
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `note`
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_note_user` (`id_user`),
  ADD KEY `fk_note_color` (`id_color`);

-- Indexes for table `user`
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_billing` (`bill_type`);

-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `billing`
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT for table `color`
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT for table `note`
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `user`
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- Constraints for dumped tables

-- Constraints for table `note`
ALTER TABLE `note`
  ADD CONSTRAINT `fk_note_color` FOREIGN KEY (`id_color`) REFERENCES `color` (`id`),
  ADD CONSTRAINT `fk_note_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

-- Constraints for table `user`
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_billing` FOREIGN KEY (`bill_type`) REFERENCES `billing` (`id`);

-- Constraints for table `task`
ALTER TABLE `task`
  ADD CONSTRAINT `fk_task_user` FOREIGN KEY (`id_user`) REFERENCES `user`(`id`),
  ADD CONSTRAINT `fk_task_color` FOREIGN KEY (`id_color`) REFERENCES `color`(`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;