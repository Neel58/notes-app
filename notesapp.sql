-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 08:27 PM
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
-- Database: `notesapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, '2 30 am club', 'j  n', '2025-04-28 21:04:55', '2025-04-28 21:04:55'),
(3, 1, 'test1', 'ulalalals', '2025-05-02 14:49:21', '2025-05-02 14:49:21'),
(4, 1, ' ffvsg ab', 'fiosahli  ', '2025-05-02 16:46:32', '2025-05-02 16:46:32'),
(5, 2, 'testing 1', ',ngkljwkngk           rg', '2025-05-02 17:51:23', '2025-05-02 17:51:23'),
(6, 3, 'cv', 'venga boys', '2025-05-02 18:07:38', '2025-05-02 18:07:38'),
(7, 3, 'cv', 'venga boys', '2025-05-02 18:09:02', '2025-05-02 18:09:02'),
(8, 3, 'jknk', 'nnnkjb', '2025-05-02 18:09:21', '2025-05-02 18:09:21'),
(9, 3, 'j.nkb ', 'm,n.j.b   kl\r\n', '2025-05-02 18:09:43', '2025-05-02 18:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `note_files`
--

CREATE TABLE `note_files` (
  `id` int(11) NOT NULL,
  `note_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `note_files`
--

INSERT INTO `note_files` (`id`, `note_id`, `file_path`, `created_at`) VALUES
(1, 1, 'uploads/1745874295_create_note.php', '2025-04-28 21:04:55'),
(2, 3, 'uploads/1746197361_neel_atomic_habits_challenge.png', '2025-05-02 14:49:21'),
(3, 4, 'uploads/1746204392_WhatsApp Image 2022-04-06 at 10.57.45 AM (2).jpeg', '2025-05-02 16:46:32'),
(4, 7, 'uploads/1746209342_WIN_20231213_00_10_54_Pro.jpg', '2025-05-02 18:09:02'),
(5, 7, 'uploads/1746209342_WIN_20231213_00_10_58_Pro.jpg', '2025-05-02 18:09:02'),
(6, 7, 'uploads/1746209342_WIN_20231213_00_11_01_Pro.jpg', '2025-05-02 18:09:02'),
(7, 7, 'uploads/1746209342_WIN_20231213_00_11_05_Pro.jpg', '2025-05-02 18:09:02'),
(8, 7, 'uploads/1746209342_WIN_20231213_00_11_11_Pro.jpg', '2025-05-02 18:09:02'),
(9, 7, 'uploads/1746209342_WIN_20231213_00_11_22_Pro.jpg', '2025-05-02 18:09:02'),
(10, 9, 'uploads/1746209383_WIN_20240531_09_02_39_Pro.jpg', '2025-05-02 18:09:43'),
(11, 9, 'uploads/1746209383_WIN_20240531_09_02_43_Pro.jpg', '2025-05-02 18:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'n', '$2y$10$vqMbgSBvOirjGPSzw3QgnOkaKvdhJtOpdU4knq1RySMVgMwAbE7Mi', '2025-04-28 20:57:31'),
(2, 'a', '$2y$10$HV4BOeyZZq45E4GhgXqcFOmbZ.f2sY5bvRIvmKPuFJ7inSIk1lnPO', '2025-05-02 17:50:40'),
(3, 'z', '$2y$10$7zmbKhD0tN7PW5Xw/tDHbuZrzBi48ei24aF95rE8cNsqO4tedhIle', '2025-05-02 18:06:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `note_files`
--
ALTER TABLE `note_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `note_id` (`note_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `note_files`
--
ALTER TABLE `note_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `note_files`
--
ALTER TABLE `note_files`
  ADD CONSTRAINT `note_files_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
