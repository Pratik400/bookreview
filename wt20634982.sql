-- phpMyAdmin SQL Dump
-- version 5.2.0-1.fc35
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2024 at 12:32 PM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_20634982`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `authorId` varchar(10) NOT NULL,
  `authorName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`authorId`, `authorName`) VALUES
('18406', 'Solomon Lindsay'),
('21159', 'Miranda Roy'),
('21992', 'Giacomo Berg'),
('28062', 'Melanie Duke'),
('39382', 'Gay Blackburn'),
('56476', 'Uriel Raymond'),
('77625', 'Nita Weber'),
('82597', 'Victoria Marshall'),
('A001', 'John Lewis'),
('A002', 'William Loftus'),
('A003', 'Paul Deitel'),
('A004', 'David'),
('A005', 'Jessica'),
('A006', 'Chris');

-- --------------------------------------------------------

--
-- Table structure for table `authorship`
--

CREATE TABLE `authorship` (
  `bookId` varchar(10) NOT NULL,
  `authorId` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorship`
--

INSERT INTO `authorship` (`bookId`, `authorId`) VALUES
('B001', 'A001'),
('B001', 'A002'),
('B002', 'A003'),
('B003', 'A004'),
('B003', 'A005'),
('B003', 'A006'),
('B006', '77625'),
('B008', '28062'),
('B008', '39382'),
('B008', '82597'),
('B426', '18406'),
('B426', '21992'),
('B426', '56476'),
('B789', '21159');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `bookId` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`bookId`, `title`) VALUES
('B001', 'Java Software Solutions'),
('B002', 'Internet and World Wide Web'),
('B003', 'Mathematics'),
('B006', 'Cracking the Coding Interview: 189 Programming Questions and Solutions'),
('B008', 'Clean Code: A Handbook of Agile Software'),
('B426', 'Programming Perl'),
('B789', 'Information Security: Principles and Practice');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `bookId` varchar(10) NOT NULL,
  `reviewerId` varchar(10) NOT NULL,
  `rating` int(11) DEFAULT 1,
  `reviewDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`bookId`, `reviewerId`, `rating`, `reviewDate`) VALUES
('B001', 'R001', 5, '2024-06-21 11:11:59'),
('B001', 'R003', 4, '2024-09-24 11:11:59'),
('B002', 'R002', 4, '2024-07-22 12:11:59'),
('B002', 'R003', 5, '2024-10-25 12:11:59'),
('B003', 'R003', 3, '2024-08-23 13:11:59');

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `reviewerId` varchar(10) NOT NULL,
  `reviewerName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`reviewerId`, `reviewerName`) VALUES
('R001', 'Donald'),
('R002', 'Vladimir'),
('R003', 'Theresa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2, 'wt', '$2y$10$GxkEtGAnuhTKhGyZBJ6ejuOaiPgwsLFTwR.YwKXmj2uct3z7VuU2K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`authorId`);

--
-- Indexes for table `authorship`
--
ALTER TABLE `authorship`
  ADD PRIMARY KEY (`bookId`,`authorId`),
  ADD KEY `authorId` (`authorId`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bookId`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`bookId`,`reviewerId`),
  ADD KEY `reviewerId` (`reviewerId`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD PRIMARY KEY (`reviewerId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authorship`
--
ALTER TABLE `authorship`
  ADD CONSTRAINT `authorship_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `book` (`bookId`),
  ADD CONSTRAINT `authorship_ibfk_2` FOREIGN KEY (`authorId`) REFERENCES `author` (`authorId`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `book` (`bookId`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`reviewerId`) REFERENCES `reviewer` (`reviewerId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
