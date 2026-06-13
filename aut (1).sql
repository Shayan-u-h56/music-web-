-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 01:17 PM
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
(7, 'Abdul Hannan', 'a1.png'),
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
(3, 1, 1, 5, 'nice song', '2026-06-12 10:41:50'),
(4, 1, 1, 3, '🔥🔥🔥🔥🔥', '2026-06-13 10:07:56'),
(5, 1, 1, 3, '🔥🔥🔥🔥🔥', '2026-06-13 10:07:59');

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
(8, 'Perfect', 'Talhah Yunus', '8.png', 's8.mp3', NULL, 4),
(9, 'Industry Baby', 'Talhah Yunus', '9.png', 's9.mp3', NULL, 4),
(10, 'Peaches', 'Talwiinder', '10.png', 's10.mp3', NULL, 5),
(11, 'Pal Pal', 'Talwiinder', '11.png', 's10.mp3', NULL, 5),
(12, 'Aarzu', 'Arijit Singh', '12.png', 's8.mp3', NULL, 2),
(14, 'Jhol', 'Hasan Raheem', '13.png', 's7.mp3', NULL, 6);

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
(14, 1, 'ALI', 'ali@GAMIL.COM', '$2y$10$Qm9ppn4/bNrfJTbYlS8XwO3yg8VHnmomX2m7Bqjhp0Ow7R8s/74EW', '2026-05-18 13:39:05', '2026-06-13 11:09:08'),
(15, 2, 'rehan', 'rhan@gmail.com', '$2y$10$UqM/hEuniDZweQifslnWRe4Rn9LRpGWu7aHOiFFjDM.sOy9rLvSd6', '2026-05-18 14:53:08', '2026-06-13 11:07:34'),
(17, 1, 'saba', 'saa@gmail.com', '$2y$10$OGeh.NxWqo7fidvsZIrhKeTM/6E65ukcTOm4h1g5e2Q9TCl.mXGRm', '2026-06-03 21:07:34', '2026-06-13 11:07:55'),
(18, 1, 'faisal', 'fasi@gmail.com', '$2y$10$X.88JUqJnZWCuWCXR.Rb5OFEbq7IsH3n3MbQjCibkwcxC2YAt5RUa', '2026-06-11 00:50:28', NULL),
(20, 1, 'shanu', 'sahnu@gmail.com', '$2y$10$tNNPAi2xerYFKlg1Fn09Y.oUpIlZHR4PfA2Sbfe4GVyv769kW9tde', '2026-06-13 10:35:35', NULL),
(21, 1, 'mira', 'mira@gmail.com', '$2y$10$ieb6e02rTAOt42Buyu6kK.yDwXpxDdWTuYQUQdWU0DC8W4scASJs.', '2026-06-13 10:36:57', NULL),
(22, 1, 'brand', 'brand@gmail.com', '$2y$10$B10KKw9CfXUbrUu.KlqTvOzL7yjRPHQ.5x28zx1wmGHgSO0Z0iwY6', '2026-06-13 10:40:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `thumbnail`, `video_file`) VALUES
(1, 'Mountains', 't2.jpg', 'v1.mp4'),
(2, 'Majestic Mountain Peaks', 't1.png', 'v4.mp4'),
(3, 'Whispers of the Highlands', 't6.png', 'v4.mp4'),
(4, 'Valley of Giants', 't10.png', 'v3.mp4'),
(5, 'Golden Summit View', 't4.jpg', 'v2.mp4'),
(6, 'Mountains Peak', 't7.png', 'v3.mp4');

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
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
