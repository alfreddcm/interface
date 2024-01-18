-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 18, 2024 at 03:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elocker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `mi` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `profile` varchar(255) NOT NULL,
  `sex` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `department_id`, `email`, `fname`, `mi`, `lname`, `password`, `position`, `profile`, `sex`) VALUES
(1, 5, 'alfred.c.marcelino@isu.edu.ph', 'Alfred', 'C', 'Marcelino', '$2y$10$59tRR13jhlddlWc59v/e6.VULo8SDqUn3Xp0UjPAdBw5jGsFAh4kW', 'student', 'xmascard.png', '0');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `program` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `program`) VALUES
(1, 'Bachelor of Science in Information Technology'),
(2, 'Bachelor of Science in information System'),
(3, 'Bachelor of Science in Computer Science'),
(4, 'Computer Secretarial'),
(5, 'Bachelor of Science of Animal Husbandry'),
(6, 'Bachelor of Science in Agriculture'),
(7, 'Bachelor of Science in Agri-Business'),
(8, 'Bachelor of Science in Forestry'),
(9, 'Bachelor of Science in Environmental Science'),
(10, 'Bachelor of Science in Accountancy'),
(11, 'Bachelor of Science in Hotel, Restaurant, & Tourism Management'),
(12, 'Bachelor of Science in Entrepreneurship'),
(13, 'Bachelor of Science in Administration'),
(14, 'Bachelor of Science in Business Administration'),
(15, 'Bachelor of Science in Biology'),
(16, 'Bachelor of Science in Criminology'),
(17, 'Bachelor of Science in Fisheries'),
(18, 'Bachelor of Science in Science in Mathematics'),
(19, 'Bachelor of Science of Science in Psychology'),
(20, 'Bachelor of Science of Arts in English'),
(21, 'Bachelor of Science Arts in Mass Communication'),
(22, 'Bachelor of Science in Agricultural Engineering'),
(23, 'Bachelor of Science in Civil Engineering'),
(24, 'Bachelor of Science Chemical Engineering'),
(25, 'Bachelor of Science in Nursing'),
(26, 'Bachelor of Elementary Education'),
(27, 'Bachelor of Secondary Education'),
(28, 'Doctor of Veterinary Medicine (DVM)');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dep_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dep_name`) VALUES
(1, 'Central Graduate School'),
(2, 'College of Education'),
(3, 'College of Business Accountancy and Public Administration'),
(4, 'College of Arts and Sciences'),
(5, 'College of Computing Studies, Information and Communication Technology'),
(6, 'School of Veterinary Medicine'),
(7, 'College of Engineering'),
(8, 'College of Criminal Justice Education'),
(9, 'College of Nursing'),
(10, 'Institute of Fisheries');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `device_mode` varchar(20) DEFAULT NULL,
  `token` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `device_mode`, `token`) VALUES
(1, '1', '5');

-- --------------------------------------------------------

--
-- Table structure for table `locker_data`
--

CREATE TABLE `locker_data` (
  `id` int(11) NOT NULL,
  `status` varchar(25) DEFAULT 'active',
  `token` varchar(25) DEFAULT NULL,
  `uid` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locker_data`
--

INSERT INTO `locker_data` (`id`, `status`, `token`, `uid`) VALUES
(1, 'active', '5', '3588154171'),
(2, 'active', '5', '22717721815');

-- --------------------------------------------------------

--
-- Table structure for table `Log_history`
--

CREATE TABLE `Log_history` (
  `access` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `id` int(11) NOT NULL,
  `locker_id` int(11) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `user_idno` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Log_history`
--

INSERT INTO `Log_history` (`access`, `date_time`, `id`, `locker_id`, `user`, `user_idno`) VALUES
('open', '2024-01-16 18:58:44', 43, 1, 'Alfred C. Marcelino', '21-0395'),
('close', '2024-01-16 18:58:55', 44, 1, 'Alfred C. Marcelino', '21-0395'),
('open', '2024-01-16 18:59:01', 45, 1, 'Alfred C. Marcelino', '21-0395'),
('close', '2024-01-16 18:59:11', 46, 1, 'Alfred C. Marcelino', '21-0395'),
('open', '2024-01-16 18:59:16', 47, 1, 'Alfred C. Marcelino', '21-0395'),
('close', '2024-01-16 18:59:21', 48, 1, 'Alfred C. Marcelino', '21-0395'),
('open', '2024-01-17 13:34:59', 49, 2, 'jaymar M. Chavez', '21-0436'),
('close', '2024-01-17 13:35:10', 50, 2, 'jaymar M. Chavez', '21-0436'),
('open', '2024-01-17 13:35:22', 51, 2, 'jaymar M. Chavez', '21-0436'),
('close', '2024-01-17 13:35:28', 52, 2, 'jaymar M. Chavez', '21-0436'),
('open', '2024-01-17 14:41:45', 53, 2, 'Oliver m. Dimalanta', '21-2333'),
('close', '2024-01-17 14:41:57', 54, 2, 'Oliver m. Dimalanta', '21-2333'),
('open', '2024-01-17 14:42:10', 55, 2, 'Oliver m. Dimalanta', '21-2333'),
('close', '2024-01-17 14:42:26', 56, 2, 'Oliver m. Dimalanta', '21-2333');

-- --------------------------------------------------------

--
-- Table structure for table `newcard`
--

CREATE TABLE `newcard` (
  `id` int(11) NOT NULL,
  `uid` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Note`
--

CREATE TABLE `Note` (
  `id` int(11) NOT NULL,
  `idno` char(25) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Note`
--

INSERT INTO `Note` (`id`, `idno`, `text`) VALUES
(1, '21-0395', ''),
(2, '21-2333', 'Shoes'),
(3, '21-0391', 'Socks\r\nPapers\r\nNotebooks');

-- --------------------------------------------------------

--
-- Table structure for table `requestlist`
--

CREATE TABLE `requestlist` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `mi` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `idno` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `yrsec` varchar(255) DEFAULT NULL,
  `signup_time` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `reset_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requestlist`
--

INSERT INTO `requestlist` (`id`, `fname`, `lname`, `mi`, `course_id`, `date_added`, `department_id`, `email`, `idno`, `sex`, `status`, `yrsec`, `signup_time`, `otp`, `activation_code`, `reset_code`) VALUES
(9, 'alemer', 'dangilan', 'm', 1, '2024-01-17 14:32:29', 5, 'alemer@gmail.com', '21-0391', 'm', 'pending', '3-2', NULL, NULL, NULL, NULL),
(22, 'alfred', 'marcelino', 'm', 1, '2024-01-18 22:01:48', 5, 'alfredmarcelino455@gmail.com', '21-2313', 'm', NULL, '1-2', NULL, '23481', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `course_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `idno` char(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `locker_id` int(11) DEFAULT NULL,
  `mi` varchar(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `user_profile` varchar(255) DEFAULT NULL,
  `yrsec` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`course_id`, `department_id`, `email`, `fname`, `id`, `idno`, `lname`, `locker_id`, `mi`, `password`, `sex`, `user_profile`, `yrsec`) VALUES
(1, 5, 'alfredmarcelinoii45@gmail.com', 'Alfred', 1, '21-0395', 'Marcelino', NULL, 'C', '$2y$10$usfP9G6DzyGm6Lfip2u0vupl0sTgX8YfTyE4ZLJZexHV6RcxWlkJ6', 'm', '3342.jpg', '3-2'),
(1, 5, 'jaymarchavez666@gmail.com', 'jaymar', 2, '21-0436', 'Chavez', NULL, 'M', '$2y$10$6Mam2sr01jTja4/1XZJkTutUu2Tva5Rax11C.89vf.6/jZdzzvmYO', 'm', 'blank-profile.png', '3-2'),
(1, 5, 'alemer@d.com', 'Alemer', 3, '21-0391', 'Dangilan', 1, 'M', '$2y$10$UvDgbGpcwjAEYWQzMjSDFeXwUFgf5/YifgaX4CLjpDo4T75tBAbb.', 'm', 'alemer.jpeg', '3-2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locker_data`
--
ALTER TABLE `locker_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `Log_history`
--
ALTER TABLE `Log_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newcard`
--
ALTER TABLE `newcard`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `Note`
--
ALTER TABLE `Note`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idno` (`idno`);

--
-- Indexes for table `requestlist`
--
ALTER TABLE `requestlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `locker_data`
--
ALTER TABLE `locker_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Log_history`
--
ALTER TABLE `Log_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `newcard`
--
ALTER TABLE `newcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Note`
--
ALTER TABLE `Note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requestlist`
--
ALTER TABLE `requestlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
