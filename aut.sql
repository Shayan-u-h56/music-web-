-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2026 at 01:46 PM
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
-- Database: `aut`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `folder_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `description`, `folder_name`) VALUES
(1, 'Any Moodgr', 'Calm your Anger', 'Angry_(mood)'),
(2, 'Bright Songs', 'Bright Songs for you', 'Bright_(mood)'),
(3, 'Copyright Songs', 'Cover Songs for you', 'cs'),
(4, 'Dark Horse', 'Dark Songs for you', 'Dark_(mood)'),
(5, 'Diljit Dosanjh', 'Diljit Dosanjh hits', 'Diljit'),
(6, 'Go Funky', 'Diljit Dosanjh hits', 'Funky_(mood)'),
(7, 'Karan Aujla', 'Lets go Funky', 'karan aujla');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `roles_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `roles_name`) VALUES
(1, 'users'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_pass` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`id`, `rol_id`, `u_name`, `u_email`, `u_pass`, `created_at`, `update_at`) VALUES
(1, 2, 'shayan ul haq', 'shayan56@gmail.com', '$2y$10$9uaevqIbbOyQ3xNiNu6T6.srUb5D9Q4mRQbq/D1O5zFJ3MYySIbxS', '2026-05-16 20:58:45', NULL),
(11, 1, 'fazyaz', 'fazi@gmail.com', '$2y$10$4FuBA/SQQsUSXG3QTkg4EewVMAYdA7uFyIjdQ0TsGdPnTdEyLrFPG', '2026-05-17 20:28:33', '2026-05-18 14:50:45'),
(12, 1, 'rehan', 'rehan@gamil.com', '$2y$10$962KisUxDf2GRUGB4GZACOEDq9l9G8L45PYnaAvTW8TWehLaJQ6yC', '2026-05-18 13:32:56', NULL),
(13, 1, 'walli', 'wall@gmail.com', '$2y$10$MRLbfKoJ6aVzwtGHeypsvO31/x4HKPsV3AkCZOgU/oXk6qWsIaKUW', '2026-05-18 13:33:48', NULL),
(14, 1, 'ALI', 'B@GAMIL.COM', '$2y$10$Qm9ppn4/bNrfJTbYlS8XwO3yg8VHnmomX2m7Bqjhp0Ow7R8s/74EW', '2026-05-18 13:39:05', NULL),
(15, 1, 'rehan', 'rehan@gmail.com', '$2y$10$UqM/hEuniDZweQifslnWRe4Rn9LRpGWu7aHOiFFjDM.sOy9rLvSd6', '2026-05-18 14:53:08', NULL),
(16, 1, 'app', 'app@gmail.com', '$2y$10$3/r/FkxZtgaNqioZhptsiuSD.7p5bFqJc9pCjkedc66QuE5l0xOe.', '2026-05-18 14:54:53', NULL),
(17, 1, 'saba', 'sab@gmail.com', '$2y$10$OGeh.NxWqo7fidvsZIrhKeTM/6E65ukcTOm4h1g5e2Q9TCl.mXGRm', '2026-06-03 21:07:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD KEY `fk_roles` (`rol_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD CONSTRAINT `fk_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
