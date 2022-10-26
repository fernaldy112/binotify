-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Oct 26, 2022 at 12:24 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `album_id` int NOT NULL,
  `judul` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `penyanyi` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `total_duration` int NOT NULL DEFAULT '0',
  `image_path` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `genre` varchar(64) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `judul`, `penyanyi`, `total_duration`, `image_path`, `tanggal_terbit`, `genre`) VALUES
(1, 'White', 'James', 0, 'NOT_EXISTS', '2022-10-23', 'pop'),
(2, 'Blackpink In Your Area', 'Blackpink', 0, 'image/1666752491_Black_Pink_Black_In_Your_Area_Digital_Cover.jpg', '2022-10-26', 'K-Pop'),
(3, 'World Of Walker', 'Alan Walker', 0, 'image/1666768589_World_of_Walker.jpg', '2021-02-12', 'Hip-hop'),
(4, 'LALISA', 'LISA', 0, 'image/1666768703_LALISA.jpg', '2021-11-09', 'K-Pop'),
(5, 'Ghost Stories', 'Coldplay', 0, 'image/1666769032_Ghost_Stories.jpeg', '2014-05-16', 'Indie'),
(6, 'Origins', 'Imagine Dragon', 0, 'image/1666769140_Origins.png', '2018-11-09', 'Pop'),
(7, 'Evolve', 'Imagine Dragon', 0, 'image/1666769230_Evolve.jpg', '2017-06-23', 'Pop'),
(8, 'Page Two', 'TWICE', 0, 'image/1666769315_Page_Two.jpg', '2016-04-25', 'K-Pop'),
(9, 'Head or Heart', 'Christine Perri', 0, 'image/1666769468_Head_or_Heart.jpg', '2014-04-01', 'Pop'),
(10, 'The Greatest Showman', 'Atlantic Records', 0, 'image/1666769581_The_Greatest_Showman.jpg', '2017-12-08', 'Pop');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `song_id` int NOT NULL,
  `judul` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `penyanyi` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `genre` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `audio_path` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `album_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`song_id`, `judul`, `penyanyi`, `tanggal_terbit`, `genre`, `duration`, `audio_path`, `image_path`, `album_id`) VALUES
(1, 'Whistle', 'Blackpink', '2022-10-26', 'K-Pop', 0, 'music/1666756319_02-BLACKPINK-WHISTLE-(HiphopKit.com).mp3', 'image/1666756319_Black_Pink_Black_In_Your_Area_Digital_Cover.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `username`, `isAdmin`) VALUES
(1, 'admin1@gmail.com', '123456', 'admin1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `song_album` (`album_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `song_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
