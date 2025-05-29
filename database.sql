-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: medicalapp.detenta.com
-- Generation Time: Jan 11, 2025 at 03:19 PM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 8.1.2-1ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicalapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int NOT NULL,
                         `username` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
                         `name` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
                         `status` int NOT NULL,
                         `surename` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
                         `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `password` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
                         `email` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
                         `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `status`, `surename`, `created_date`, `password`, `email`, `expiration`) VALUES
    (1, 'admin', 'AdminUser', 1, 'AdminSurname', '2024-11-30 17:00:15', 'test', 'test@test.de', '2025-11-30 08:59:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;