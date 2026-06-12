-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 02:04 PM
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
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `image`) VALUES
(1, 'Atif Aslam', 'a2.png'),
(2, 'Arijit Singh', 'a7.png'),
(3, 'Talha Anjum', 'a4.png'),
(4, 'Talhah Yunus', 'a6.png'),
(5, 'Talwiinder', 'a5.png'),
(6, 'Hasan Raheem', 'a8.png'),
(7, 'Abdul Hannan', 'a7.png'),
(8, 'Young Stunners', 'a9.png'),
(9, 'Nusrat fateh', 'a3.png'),
(10, 'Karan Aujla', 'a10.png'),
(11, 'Yo YO Honey', 'a11.png'),
(12, 'diljit', 'a12.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `song_id`, `rating`, `review`, `created_at`) VALUES
(1, 18, 1, 1, 'amizing song', '2026-06-11 12:03:33'),
(2, 18, 1, 3, 'good', '2026-06-11 12:14:32'),
(3, 1, 1, 5, 'nice song', '2026-06-12 10:41:50');

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
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `artist` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `cover_image`, `audio_file`, `duration`, `artist_id`) VALUES
(1, 'Blinding Lights', 'Atif Aslam', '1.png', 's1.mp3', NULL, 1),
(2, 'Starboy', 'Atif Aslam', '2.png', 's2.mp3', NULL, 1),
(4, 'Heat Waves', 'Arijit Singh', '4.png', 's4.mp3', NULL, 2),
(5, 'Levitating', 'Arijit Singh', '5.png', 's5.mp3', NULL, 2),
(6, 'Shape Of You', 'Talha Anjum', '6.png', 's6.mp3', NULL, 3),
(7, 'Stay', 'Talha Anjum', '7.png', 's7.mp3', NULL, 3),
(8, 'Perfect', 'Talhah Yunus', '8.png', 's8.mp3', NULL, 4),
(9, 'Industry Baby', 'Talhah Yunus', '9.png', 's9.mp3', NULL, 4),
(10, 'Peaches', 'Talwiinder', '10.png', 's10.mp3', NULL, 5),
(11, 'Pal Pal', 'Talwiinder', '11.png', 's10.mp3', NULL, 5),
(12, 'Aarzu', 'Arijit Singh', '12.png', 's8.mp3', NULL, 2);

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
(13, 1, 'walli', 'wal@gmail.com', '$2y$10$MRLbfKoJ6aVzwtGHeypsvO31/x4HKPsV3AkCZOgU/oXk6qWsIaKUW', '2026-05-18 13:33:48', '2026-06-12 11:12:33'),
(14, 1, 'ALI', 'B@GAMIL.COM', '$2y$10$Qm9ppn4/bNrfJTbYlS8XwO3yg8VHnmomX2m7Bqjhp0Ow7R8s/74EW', '2026-05-18 13:39:05', NULL),
(15, 1, 'rehan', 'rehan@gmail.com', '$2y$10$UqM/hEuniDZweQifslnWRe4Rn9LRpGWu7aHOiFFjDM.sOy9rLvSd6', '2026-05-18 14:53:08', NULL),
(17, 1, 'saba', 'sab@gmail.com', '$2y$10$OGeh.NxWqo7fidvsZIrhKeTM/6E65ukcTOm4h1g5e2Q9TCl.mXGRm', '2026-06-03 21:07:34', NULL),
(18, 1, 'faisal', 'fasi@gmail.com', '$2y$10$X.88JUqJnZWCuWCXR.Rb5OFEbq7IsH3n3MbQjCibkwcxC2YAt5RUa', '2026-06-11 00:50:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
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
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdetails` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`);

--
-- Constraints for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD CONSTRAINT `fk_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
