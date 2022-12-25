-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2022 at 07:36 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_api_cse5_bu`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `categoryPic` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `categoryPic`, `createdAt`, `updatedAt`) VALUES
(1, 'CSE', 'uploads/categories/cse.png', '2022-12-21 05:53:36', '2022-12-21 05:53:36'),
(2, 'Math', 'uploads/categories/math.png', '2022-12-21 05:56:44', '2022-12-21 05:56:44'),
(3, 'Biology', 'uploads/categories/biology.png', '2022-12-21 05:56:44', '2022-12-21 05:56:44'),
(4, 'GK', 'uploads/categories/gk.png', '2022-12-21 05:56:44', '2022-12-21 05:56:44'),
(5, 'Literature', 'uploads/categories/literature.png', '2022-12-21 05:56:44', '2022-12-21 05:56:44'),
(6, 'History', 'uploads/categories/history.png', '2022-12-21 05:56:44', '2022-12-21 05:56:44'),
(7, 'Physics', 'uploads/categories/physics.png', '2022-12-21 05:56:44', '2022-12-21 05:56:44'),
(12, 'Chemistry', 'uploads/categories/e4ddf97f45ea9a564911.png', '2022-12-24 13:08:47', '2022-12-24 14:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`options`)),
  `correctOptions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`correctOptions`)),
  `topicId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `question`, `options`, `correctOptions`, `topicId`, `createdAt`, `updatedAt`) VALUES
(1, 'A technique that was developed to determine whether a machine could or could not demonstrate the artificial intelligence known as the___', '[\"Boolean Algebra\", \"Turing Test\", \"Logarithm\", \"Algorithm\"]', '[1]', 8, '2022-12-21 11:03:05', '2022-12-21 11:03:05'),
(2, 'Which algorithm is used in the Game tree to make decisions of Win/Lose?', '[\"Heuristic Search Algorithm\", \"DFS/BFS algorithm\", \"Greedy Search Algorithm\", \"Min/Max algorithm\"]', '[3]', 8, '2022-12-21 11:03:05', '2022-12-21 11:03:05'),
(3, 'An AI agent perceives and acts upon the environment using___', '[\"Sensors\", \"Perceiver\", \"Actuators\"]', '[0, 2]', 8, '2022-12-21 11:03:05', '2022-12-21 11:03:05'),
(5, 'An Algorithm is said as Complete algorithm if_______________', '[\"It ends with a solution (if any exists)\", \"It begins with a solution\", \"It does not end with a solution\", \"It contains a loop\"]', '[0]', 8, '2022-12-21 11:03:05', '2022-12-21 11:03:05'),
(9, 'Rational agent always does the right things.', '[\"True\", \"False\"]', '[0]', 8, '2022-12-25 06:31:30', '2022-12-25 06:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `questionsCnt` int(11) NOT NULL,
  `correctAnsCnt` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `playedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `topicPic` varchar(255) DEFAULT NULL,
  `categoryId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`, `topicPic`, `categoryId`, `createdAt`, `updatedAt`) VALUES
(8, 'Artificial Intelligence', 'uploads/topics/artificial-intelligence-1.png', 1, '2022-12-21 08:26:32', '2022-12-21 08:26:32'),
(9, 'Computer Architecture', 'uploads/topics/computer-architecture-1.png', 1, '2022-12-21 08:26:32', '2022-12-21 08:26:32'),
(10, 'C Programming Language', 'uploads/topics/c-programming-language-1.png', 1, '2022-12-21 08:26:32', '2022-12-21 08:26:32'),
(11, 'Machine Learning', 'uploads/topics/machine-learning-1.png', 1, '2022-12-21 08:26:32', '2022-12-21 08:26:32'),
(12, 'Peripheral and Interfacing', 'uploads/topics/peripheral-and-interfacing-1.png', 1, '2022-12-21 08:26:32', '2022-12-21 08:26:32'),
(16, 'Theory of Computation', 'uploads/topics/eb8851bf6891bb412cf8.png', 1, '2022-12-24 17:13:53', '2022-12-24 17:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `phone` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `phone`, `password`, `profilePic`, `createdAt`, `updatedAt`) VALUES
(14, 'John', 'Doe', '+8801943253440', '$2y$10$fNgqLfmW.94XCjTI.71cn.3rWGyNL5cHLyKa3mbV0NcmBSNONqXK2', 'uploads/users/4ac786b2e784212ceda1.png', '2022-12-24 09:09:21', '2022-12-24 12:54:39'),
(15, NULL, NULL, '+8801687260070', '$2y$10$B7ke8W9wwIlnPDazA8c/uuDqFxmQuUQt1cXXBJdqsPXjRaJ63B8WG', NULL, '2022-12-24 09:09:36', '2022-12-24 09:09:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topicId` (`topicId`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`topicId`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
