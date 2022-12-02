-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: appdb:3306
-- Generation Time: Dec 02, 2022 at 05:23 AM
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
-- Database: `appdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `album_id` int NOT NULL,
  `judul` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penyanyi` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_duration` int NOT NULL DEFAULT '0',
  `image_path` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `genre` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `judul`, `penyanyi`, `total_duration`, `image_path`, `tanggal_terbit`, `genre`) VALUES
(1, 'White', 'James', 0, 'NOT_EXISTS', '2022-10-23', 'pop'),
(2, 'Blackpink In Your Area', 'Blackpink', 1570, 'image/1666889094_Blackpink_in_Your_Area.jpg', '2022-10-26', 'K-Pop'),
(3, 'World Of Walker', 'Alan Walker', 2502, 'image/1666889239_World_of_Walker.jpg', '2021-02-12', 'Hip-hop'),
(4, 'LALISA', 'LISA', 0, 'image/1666889146_Lalisa.jpg', '2021-11-09', 'K-Pop'),
(5, 'Ghost Stories', 'Coldplay', 1939, 'image/1666889122_Ghost_Stories.png', '2014-05-16', 'Indie'),
(6, 'Origins', 'Imagine Dragon', 3174, 'image/1666889156_Origins.png', '2018-11-09', 'Pop'),
(7, 'Evolve', 'Imagine Dragon', 2445, 'image/1666889109_Evolve.jpg', '2017-06-23', 'Pop'),
(8, 'Page Two', 'TWICE', 1268, 'image/1666889176_Page_Two.jpg', '2016-04-25', 'K-Pop'),
(9, 'Head or Heart', 'Christine Perri', 2669, 'image/1666889135_Head_or_Heart.png', '2014-04-01', 'Pop'),
(10, 'The Greatest Showman', 'Atlantic Records', 2022, 'image/1666889226_The_Greatest_Showman.png', '2017-12-08', 'Pop');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `song_id` int NOT NULL,
  `judul` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penyanyi` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `genre` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `audio_path` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image_path` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `album_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`song_id`, `judul`, `penyanyi`, `tanggal_terbit`, `genre`, `duration`, `audio_path`, `image_path`, `album_id`) VALUES
(2, 'Boombayah', 'Blackpink', '2016-08-08', 'EDM', 245, 'music/1666892307_01-BLACKPINK-BOOMBAYAH-(HiphopKit.com).mp3', 'image/1666892307_Boombayah.jpg', 2),
(3, 'Whistle', 'Blackpink', '2016-08-09', 'Hip Hop', 26, 'music/1666892363_02-BLACKPINK-WHISTLE-(HiphopKit.com).mp3', 'image/1666892363_Whistl.jpg', 2),
(4, 'Playing With Fire', 'Blackpink', '2016-11-01', 'Tropical House', 209, 'music/1666892391_03-BLACKPINK-PLAYING-WITH-FIRE-(HiphopKit.com).mp3', 'image/1666892391_Playing_With_FIre.jpg', 2),
(5, 'Stay', 'Blackpink', '2016-11-01', 'Folk-pop', 242, 'music/1666892419_04-BLACKPINK-STAY-(HiphopKit.com).mp3', 'image/1666892419_Stay.jpg', 2),
(6, 'As If Its Your Last', 'Blackpink', '2017-06-22', 'Synth-pop', 217, 'music/1666892459_05-BLACKPINK-AS-IF-IT-S-YOUR-LAST-(HiphopKit.com).mp3', 'image/1666892459_As_if_its_your_last.jpg', 2),
(7, 'Forever Young', 'Blackpink', '2018-06-15', 'moombahton', 240, 'music/1666892520_07-BLACKPINK-FOREVER-YOUNG-(HiphopKit.com).mp3', 'image/1666892520_Forever_Young.jpg', 2),
(8, 'Really', 'Blackpink', '2018-04-30', 'Pop', 195, 'music/1666892554_08-BLACKPINK-REALLY-(HiphopKit.com).mp3', 'image/1666892554_Really.jpg', 2),
(9, 'See U Later', 'Blackpink', '2018-06-06', 'Pop', 196, 'music/1666892575_09-BLACKPINK-SEE-U-LATER-(HiphopKit.com).mp3', 'image/1666892575_See_U_Later.jpg', 2),
(10, 'Drone Wars', 'Alan Walker', '2021-11-26', 'Indie', 43, 'music/1666892651_Alan_Walker_-_Drone_Wars_(Visualizer).mp3', 'image/1666892651_Drone_Wars.jpg', 3),
(11, 'Time', 'Alan Walker', '2021-03-05', 'Electronic', 211, 'music/1666892680_Alan_Walker_–_Time_(Official_Remix).mp3', 'image/1666892680_Time.jpg', 3),
(12, 'Out Of Love', 'Alan Walker', '2021-08-19', 'Electronic', 145, 'music/1666892704_Alan_Walker_&_Au_Ra_-_Out_Of_Love_(Visualizer).mp3', 'image/1666892704_Out_of_Love.jpg', 3),
(13, 'Alone', 'Alan Walker', '2016-12-02', 'Electro House', 245, 'music/1666892730_Alan_Walker_&_Ava_Max_-_Alone_Pt._II.mp3', 'image/1666892730_Alone.png', 3),
(14, 'Not You', 'Alan Walker', '2020-10-15', 'Pop', 151, 'music/1666892767_Alan_Walker_&_Emma_Steinbakken_-_Not_You_(Visualizer).mp3', 'image/1666892767_Not_you.jpg', 3),
(15, 'Hummel Gets The Rockets', 'Alan Walker', '2021-02-09', 'Electronic', 177, 'music/1666892793_Alan_Walker_&_Hans_Zimmer_-_Hummell_Gets_the_Rockets_(Alan_Walker_Remix)_(Visualizer).mp3', 'image/1666892793_Hummel_Gets_the_Rockets.jpg', 3),
(16, 'Sorry', 'Alan Walker', '2021-07-16', 'Electronic', 190, 'music/1666892822_Alan_Walker_&_ISÁK_-_Sorry_(Official_Music_Video).mp3', 'image/1666892822_Sorry.jpg', 3),
(17, 'Heading Home', 'Alan Walker', '2021-04-02', 'Indie', 212, 'music/1666892845_Alan_Walker_&_Ruben_–_Heading_Home_(Official_Music_Video).mp3', 'image/1666892845_Heading_Home.jpg', 3),
(18, 'Man On The Moon', 'Alan Walker', '2022-06-15', 'Indie', 182, 'music/1666892909_Alan_Walker_x_Benjamin_Ingrosso_-_Man_On_The_Moon_(Official_Music_Video).mp3', 'image/1666892909_Man_on_the_Moon.jpg', 3),
(19, 'Paradise', 'Alan Walker', '2021-08-18', 'Indie', 203, 'music/1666892941_Alan_Walker_K-391_Boy_in_Space_-_Paradise_(Official_Music_Video).mp3', 'image/1666892941_Paradise.jpg', 3),
(20, 'OK', 'Alan Walker', '2020-06-17', 'Electronic', 166, 'music/1666892963_Alan_Walker_x_JOP_-_OK_(Visualizer).mp3', 'image/1666892963_Ok.jpg', 3),
(21, 'Fake A Smile', 'Alan Walker', '2021-03-11', 'Pop', 196, 'music/1666892994_Alan_Walker_x_salem_ilese_-_Fake_A_Smile_(Official_Music_Video).mp3', 'image/1666892994_Fake_a_Smile.jpg', 3),
(22, 'World We Used To Know', 'Alan Walker', '2022-11-26', 'Indie', 164, 'music/1666893033_Alan_Walker_x_Winona_Oak_-_World_We_Used_To_Know_(Lyric_Video).mp3', 'image/1666893033_World_We_Use_to_Know.jpg', 3),
(23, 'On My Way', 'Alan Walker', '2019-03-21', 'moombahton', 217, 'music/1666893061_Alan_Walker,_Sabrina_Carpenter_&_Farruko__-_On_My_Way.mp3', 'image/1666893061_On_My_Way.jpg', 3),
(24, 'Trust', 'Christina Perri', '2014-06-09', 'Pop', 212, 'music/1666910383_Christina_Perri_-_Trust_[Official_Audio].mp3', 'image/1666910383_Trust.jpg', 9),
(32, 'A Sky Full Of Stars', 'Coldplay', '2014-05-02', 'Progressive House', 268, 'music/1666927956_A_Sky_Full_of_Stars.mp3', 'image/1666927956_A_Sky_Full_of_Stars.png', 5),
(33, 'Always In My Head', 'Coldplay', '2014-05-02', 'Alternative Rock', 217, 'music/1666928005_Always_in_My_Head.mp3', 'image/1666928005_Always_in_My_Head.jpg', 5),
(34, 'Ink', 'Coldplay', '2014-10-13', 'Pop rock', 228, 'music/1666928094_Ink.mp3', 'image/1666928094_Ink.jpg', 5),
(35, 'Magic', 'Coldplay', '2014-03-03', 'Pop Rock', 285, 'music/1666928128_Magic.mp3', 'image/1666928128_Magic.jpg', 5),
(36, 'Midnight', 'Coldplay', '2017-04-17', 'Pop rock', 295, 'music/1666928483_Midnight.mp3', 'image/1666928483_Midnight.png', 5),
(37, 'O', 'Coldplay', '2014-04-02', 'Soft rock', 324, 'music/1666928561_O.mp3', 'image/1666928561_O.jpg', 5),
(38, 'Oceans', 'Coldplay', '2014-04-17', 'Soft rock', 322, 'music/1666928641_Oceans.mp3', 'image/1666928641_Oceans.jpg', 5),
(41, 'Bad Liar', 'Imagine Dragons', '2016-11-06', 'Electropop', 284, 'music/1666930048_Imagine_Dragons_-_Bad_Liar_(Official_Music_Video).mp3', 'image/1666930048_Bad_Liar.jpg', 6),
(42, 'Birds', 'Imagine Dragons', '2018-11-09', 'Indie', 219, 'music/1666930081_Birds.mp3', 'image/1666930081_Birds.jpg', 6),
(43, 'Boomerang', 'Imagine Dragons', '2018-11-09', 'Pop', 188, 'music/1666930111_Boomerang.mp3', 'image/1666930111_Boomerang.jpg', 6),
(44, 'Bullet In A Gun', 'Imagine Dragons', '2018-11-01', 'Indie', 205, 'music/1666930155_Bullet_In_A_Gun.mp3', 'image/1666930155_Bullet_in_a_Gun.jpg', 6),
(45, 'Burn Out', 'Imagine Dragons', '2018-10-11', 'Indie', 274, 'music/1666930200_Burn_Out.mp3', 'image/1666930200_Burn_Out.jpg', 6),
(46, 'Cool Out', 'Imagine Dragons', '2018-11-09', 'Pop', 218, 'music/1666930247_Cool_Out.mp3', 'image/1666930247_Cool_Out.jpg', 6),
(47, 'Digital', 'Imagine Dragons', '2018-11-09', 'Alternative Rock', 201, 'music/1666930295_Digital.mp3', 'image/1666930295_Digital.jpg', 6),
(48, 'Machine', 'Imagine Dragons', '2018-11-09', 'Alternative Rock', 181, 'music/1666930352_Imagine_Dragons_-_Machine_(Audio).mp3', 'image/1666930352_Machine.jpg', 6),
(49, 'Natural', 'Imagine Dragons', '2018-11-09', 'Pop rock', 190, 'music/1666930966_Imagine_Dragons_-_Natural_(Official_Music_Video).mp3', 'image/1666930966_Natural.png', 6),
(50, 'Love', 'Imagine Dragons', '2018-11-09', 'Indie', 166, 'music/1666931007_Love.mp3', 'image/1666931007_Love.jpg', 6),
(51, 'Only', 'Imagine Dragons', '2018-11-09', 'Indie', 181, 'music/1666932127_Only.mp3', 'image/1666932127_Only.jpg', 6),
(52, 'Real Life', 'Imagine Dragons', '2018-11-09', 'Pop', 248, 'music/1666932153_Real_Life.mp3', 'image/1666932153_Real_Life.jpg', 6),
(53, 'Stuck', 'Imagine Dragons', '2018-11-09', 'Pop', 191, 'music/1666932186_Stuck.mp3', 'image/1666932186_Stuck.jpg', 6),
(54, 'West Coast', 'Imagine Dragons', '2018-11-09', 'Indie', 217, 'music/1666932212_West_Coast.mp3', 'image/1666932212_West_Coast.jpg', 6),
(55, 'Zero', 'Imagine Dragons', '2019-11-09', 'Pop rock', 211, 'music/1666932247_Zero_(From_the_Original_Motion_Picture__Ralph_Breaks_The_Internet_).mp3', 'image/1666932247_Zero.jpg', 6),
(56, 'Believer', 'Imagine Dragons', '2017-02-01', 'Arena Rock', 217, 'music/1666932297_Imagine_Dragons_-_Believer_(Official_Music_Video).mp3', 'image/1666932297_Believer.jpg', 7),
(57, 'Dancing In The Dark', 'Imagine Dragons', '2017-02-01', 'Indie', 234, 'music/1666932333_Dancing_In_The_Dark.mp3', 'image/1666932333_Dancing_in_the_Dark.jpg', 7),
(58, 'Next To Me', 'Imagine Dragons', '2017-02-01', 'Indie', 230, 'music/1666932395_Imagine_Dragons_-_Next_To_Me_(Audio).mp3', 'image/1666932395_Next_To_Me.jpg', 7),
(59, 'Thunder', 'Imagine Dragons', '2017-02-01', 'Synth pop', 204, 'music/1666932539_Imagine_Dragons_-_Thunder.mp3', 'image/1666932539_Thunder.jpg', 7),
(60, 'Walking The Wire', 'Imagine Dragons', '2017-02-01', 'Indie', 232, 'music/1666932592_Imagine_Dragons_-_Walking_The_Wire_(Official_Audio).mp3', 'image/1666932592_Walking_the_Wire.jpg', 7),
(61, 'Whatever It Takes', 'Imagine Dragons', '2017-02-01', 'Contemporary', 220, 'music/1666932629_Imagine_Dragons_-_Whatever_It_Takes_(Official_Music_Video).mp3', 'image/1666932629_Whatever_It_Takes.jpg', 7),
(62, 'Start Over', 'Imagine Dragons', '2017-02-01', 'Indie', 186, 'music/1666932710_Start_Over.mp3', 'image/1666932710_Start_Over.jpg', 7),
(63, 'Yesterday', 'Imagine Dragons', '2017-02-01', 'Indie', 205, 'music/1666932733_Yesterday.mp3', 'image/1666932733_Yesterday.jpg', 7),
(64, 'Cheer Up', 'TWICE', '2016-04-25', 'K-Pop', 241, 'music/1666932776_TWICE__CHEER_UP__M_V.mp3', 'image/1666932776_Cheer_Up.png', 8),
(65, 'My Headphone', 'TWICE', '2016-03-03', 'K-Pop', 196, 'music/1666932814_Headphone_써___My_Headphones_on.mp3', 'image/1666932814_My_Headphone.jpg', 8),
(66, 'Precious Love', 'TWICE', '2016-04-25', 'K-Pop', 231, 'music/1666932846_소중한_사랑___Precious_Love.mp3', 'image/1666932846_Precious_Love.jpg', 8),
(67, 'Touchdown', 'TWICE', '2017-04-17', 'Korea Dance', 203, 'music/1666932880_Touchdown.mp3', 'image/1666932880_Touchdown.jpg', 8),
(68, 'Tuk Tok', 'TWICE', '2016-02-22', 'K-Pop', 196, 'music/1666932915_툭하면_톡___Tuk_Tok.mp3', 'image/1666932915_Tuk_TOk.jpg', 8),
(69, 'Wooho', 'TWICE', '2016-04-06', 'K-Pop', 201, 'music/1666932955_Woohoo.mp3', 'image/1666932955_Woohoo.jpg', 8),
(70, 'Burning Gold', 'Christina Perri', '2014-06-09', 'Pop rock', 237, 'music/1666933027_Christina_Perri_–_Burning_Gold_[Official_Video].mp3', 'image/1666933027_Burning_Gold.jpg', 9),
(71, 'Butterfly', 'Christina Perri', '2014-06-09', 'Pop', 228, 'music/1666933054_Christina_Perri_-_Butterfly_[Official_Audio].mp3', 'image/1666933054_Butterfly.jpg', 9),
(72, 'Human', 'Christina Perri', '2013-11-18', 'Soft rock', 262, 'music/1666933086_Christina_Perri_-_Human_[Official_Video].mp3', 'image/1666933086_Human.png', 9),
(73, 'Lonely Child', 'Christina Perri', '2014-06-09', 'Pop', 223, 'music/1666933164_Christina_Perri_-_Lonely_Child_[Official_Audio].mp3', 'image/1666933164_Lonely_Child.jpg', 9),
(74, 'One Night', 'Christina Perri', '2014-06-09', 'Pop', 185, 'music/1666933193_Christina_Perri_-_One_Night_[Official_Audio].mp3', 'image/1666933193_One_Night.jpg', 9),
(75, 'One Night', 'Christina Perri', '2014-06-09', 'Pop', 185, 'music/1666933225_Christina_Perri_-_One_Night_[Official_Audio].mp3', 'image/1666933225_One_Night.jpg', 9),
(76, 'Sea of Lovers', 'Christina Perri', '2014-06-09', 'Electronic', 215, 'music/1666933252_Christina_Perri_-_Sea_of_Lovers_[Official_Audio].mp3', 'image/1666933252_Sea_of_Lovers.jpg', 9),
(77, 'Shot Me In The Heart', 'Christina Perri', '2014-06-09', 'Electronic', 223, 'music/1666933288_Christina_Perri_-_Shot_Me_In_The_Heart_[Official_Audio].mp3', 'image/1666933288_Shot_Me_in_the_Heart.jpg', 9),
(78, 'Trust', 'Christina Perri', '2014-06-09', 'Pop', 212, 'music/1666933317_Christina_Perri_-_Trust_[Official_Audio].mp3', 'image/1666933317_Trust.jpg', 9),
(79, 'The Words', 'Christina Perri', '2014-06-09', 'Pop', 253, 'music/1666933344_the_words.mp3', 'image/1666933344_The_Words.jpg', 9),
(80, 'Come Alive', 'Loren Allred', '2012-05-21', 'Drum and Bass', 226, 'music/1666933784_The_Greatest_Showman_Cast_-_Come_Alive_(Official_Audio).mp3', 'image/1666933784_Come_Alive.jpg', 10),
(81, 'Never Enough', 'Loren Allred', '2017-12-08', 'Pop', 208, 'music/1666933846_The_Greatest_Showman_Cast_-_Never_Enough_(Official_Audio).mp3', 'image/1666933846_Never_Enough.jpg', 10),
(82, 'Rewite The Stars', 'Loren Allred', '2018-07-20', 'Country', 216, 'music/1666933879_The_Greatest_Showman_Cast_-_Rewrite_The_Stars_(Official_Audio).mp3', 'image/1666933879_Rewrite_The_Stars.jpg', 10),
(83, 'The Other Side', 'Loren Allred', '2017-12-09', 'Pop', 215, 'music/1666933942_The_Greatest_Showman_Cast_-_The_Other_Side_(Official_Audio).mp3', 'image/1666933942_The_Other_Side.jpg', 10),
(84, 'This Is Me', 'Loren Allred', '2017-12-09', 'Country', 235, 'music/1666933965_The_Greatest_Showman_Cast_-_This_Is_Me_(Official_Audio).mp3', 'image/1666933965_This_is_Me.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `creator_id` int NOT NULL,
  `subscriber_id` int NOT NULL,
  `status` enum('PENDING','ACCEPTED','REJECTED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `email` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `username`, `isAdmin`) VALUES
(1, 'admin1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin1', 1),
(2, 'example1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'example1', 0);

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
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`creator_id`,`subscriber_id`),
  ADD KEY `subscriber_id` (`subscriber_id`);

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
  MODIFY `album_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `song_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_user` FOREIGN KEY (`subscriber_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
