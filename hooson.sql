-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2024 at 10:06 AM
-- Server version: 5.7.44
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wkwvmsqa_orkhon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(8) NOT NULL,
  `pass` text NOT NULL,
  `at` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fname`, `lname`, `phone`, `pass`, `at`, `role`, `user_id`) VALUES
(1, 'Жавхлан', 'Бат-Ирээдүй', '88992842', '1', 'Мэдээллийн технологийн багш', 1, 42);

-- --------------------------------------------------------

--
-- Table structure for table `at`
--

CREATE TABLE `at` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tuluv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `at`
--

INSERT INTO `at` (`id`, `name`, `tuluv`) VALUES
(1, 'Багш', 1),
(2, 'Арга зүйч', 1),
(3, 'Менежер', 1),
(4, 'Захирал', 1),
(5, 'ЗАА-н ажилтан', 1);

-- --------------------------------------------------------

--
-- Table structure for table `att`
--

CREATE TABLE `att` (
  `id` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `lessonid` int(11) NOT NULL,
  `ltype` int(11) NOT NULL,
  `ognoo` date NOT NULL,
  `cagid` int(11) NOT NULL,
  `irc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `emoj` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `bich` datetime NOT NULL,
  `sedev` text COLLATE utf8_unicode_ci NOT NULL,
  `niit` int(11) NOT NULL,
  `v1` int(11) NOT NULL,
  `v2` int(11) NOT NULL,
  `v3` int(11) NOT NULL,
  `v4` int(11) NOT NULL,
  `tuluv` int(11) DEFAULT NULL,
  `this_on` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `att_work`
--

CREATE TABLE `att_work` (
  `id` int(11) NOT NULL,
  `hezee` date NOT NULL,
  `tsag` time NOT NULL,
  `userid` int(11) NOT NULL,
  `lon` double DEFAULT NULL,
  `lat` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `at_tax`
--

CREATE TABLE `at_tax` (
  `id` int(11) NOT NULL,
  `erh` int(11) NOT NULL,
  `at_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batal`
--

CREATE TABLE `batal` (
  `id` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `sar` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cag`
--

CREATE TABLE `cag` (
  `id` int(11) NOT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `inter` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `tuluv` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cag`
--

INSERT INTO `cag` (`id`, `name`, `inter`, `tuluv`) VALUES
(1, '1-р цаг', '08:00-09:20', 1),
(2, '2-р цаг', '09:25-10:45', 1),
(3, '3-р цаг', '10:50-12:10', 1),
(4, '4-р цаг', '12:15-13:35', 1),
(5, '5-р цаг', '14:00-15:20', 1),
(6, '6-р цаг', '15:25-16:45', 1),
(7, '7-р цаг', '16:50-18:10', 1),
(8, '8-р цаг', '18:15-19:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `sname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hugacaa` double NOT NULL,
  `tuluv` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `this_on` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_on` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  `tuluv` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expo`
--

CREATE TABLE `expo` (
  `id` int(11) NOT NULL,
  `token` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flashnews`
--

CREATE TABLE `flashnews` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `ognoo` datetime NOT NULL,
  `link` text COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hural`
--

CREATE TABLE `hural` (
  `id` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `huralusers`
--

CREATE TABLE `huralusers` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jil`
--

CREATE TABLE `jil` (
  `id` int(11) NOT NULL,
  `this_on` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jil`
--

INSERT INTO `jil` (`id`, `this_on`) VALUES
(1, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `lon` varchar(100) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `zai` int(11) NOT NULL,
  `tai` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `lon`, `lat`, `zai`, `tai`) VALUES
(1, '102.78160053960875', '46.2571286492482', 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loginlog`
--

CREATE TABLE `loginlog` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `hezee` datetime NOT NULL,
  `device` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ltype`
--

CREATE TABLE `ltype` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `kr` int(11) NOT NULL,
  `jil` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ltype`
--

INSERT INTO `ltype` (`id`, `name`, `kr`, `jil`) VALUES
(1, 'Лекц', 36, 0),
(2, 'Сем/Лаб', 36, NULL),
(4, 'СДД', 36, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ognoo` datetime NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `noti`
--

CREATE TABLE `noti` (
  `id` int(11) NOT NULL,
  `title` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ognoo` datetime NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `noti_user`
--

CREATE TABLE `noti_user` (
  `id` int(11) NOT NULL,
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `see` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `tuluv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`id`, `name`, `manager_id`, `tuluv`) VALUES
(1, 'Сургалтын алба', 89, 1),
(12, 'Захиргаа аж ахуйн алба', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `expo` text,
  `user_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `class` int(11) NOT NULL,
  `pass` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tuluv` int(11) NOT NULL,
  `last_on` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_pareant`
--

CREATE TABLE `tax_pareant` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tclass`
--

CREATE TABLE `tclass` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `classid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zereg` int(11) DEFAULT NULL,
  `at` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL,
  `tuluv` int(11) NOT NULL,
  `token` text COLLATE utf8_unicode_ci,
  `expo` text COLLATE utf8_unicode_ci,
  `office_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `fname`, `lname`, `phone`, `email`, `zereg`, `at`, `pass`, `user_role`, `tuluv`, `token`, `expo`, `office_id`, `department_id`) VALUES
(42, 'Жавхлан', 'Бат-Ирээдүй', '88992842', 'j.batireedui@gmail.com', 3, 'Багш, мэдээллийн технологийн', '$2y$08$700.rhFsjzEaulRWXvElvuoMiJ0.DZbq1OOjd5q9LImm2QEmP4D9G', 1, 1, 't5sO9A508y77oVw5R8Tj7v2410mmJNju', 'ExponentPushToken[DxDYZuG1YhNnyV4Cw0svkz]', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tlesson`
--

CREATE TABLE `tlesson` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `lessonName` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cag` int(11) DEFAULT NULL,
  `tuluv` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tzereg`
--

CREATE TABLE `tzereg` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `money` int(11) DEFAULT NULL,
  `anorm` double DEFAULT NULL,
  `bnorm` double DEFAULT NULL,
  `tuluv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tzereg`
--

INSERT INTO `tzereg` (`id`, `name`, `money`, `anorm`, `bnorm`, `tuluv`) VALUES
(1, 'Багш', 1500000, 19, 1, 1),
(2, 'Заах аргач багш', 0, 18, 2, 1),
(3, 'Тэргүүлэх багш', 0, 17, 3, 1),
(4, 'Зөвлөх багш', 0, 16, 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `at`
--
ALTER TABLE `at`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `att`
--
ALTER TABLE `att`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `att_work`
--
ALTER TABLE `att_work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `at_tax`
--
ALTER TABLE `at_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batal`
--
ALTER TABLE `batal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cag`
--
ALTER TABLE `cag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expo`
--
ALTER TABLE `expo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `flashnews`
--
ALTER TABLE `flashnews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hural`
--
ALTER TABLE `hural`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `huralusers`
--
ALTER TABLE `huralusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jil`
--
ALTER TABLE `jil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginlog`
--
ALTER TABLE `loginlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ltype`
--
ALTER TABLE `ltype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noti`
--
ALTER TABLE `noti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noti_user`
--
ALTER TABLE `noti_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_pareant`
--
ALTER TABLE `tax_pareant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tclass`
--
ALTER TABLE `tclass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `tlesson`
--
ALTER TABLE `tlesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tzereg`
--
ALTER TABLE `tzereg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `at`
--
ALTER TABLE `at`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `att`
--
ALTER TABLE `att`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `att_work`
--
ALTER TABLE `att_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `at_tax`
--
ALTER TABLE `at_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batal`
--
ALTER TABLE `batal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cag`
--
ALTER TABLE `cag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expo`
--
ALTER TABLE `expo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flashnews`
--
ALTER TABLE `flashnews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hural`
--
ALTER TABLE `hural`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `huralusers`
--
ALTER TABLE `huralusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jil`
--
ALTER TABLE `jil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loginlog`
--
ALTER TABLE `loginlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ltype`
--
ALTER TABLE `ltype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noti`
--
ALTER TABLE `noti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noti_user`
--
ALTER TABLE `noti_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `office`
--
ALTER TABLE `office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_pareant`
--
ALTER TABLE `tax_pareant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tclass`
--
ALTER TABLE `tclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `tlesson`
--
ALTER TABLE `tlesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tzereg`
--
ALTER TABLE `tzereg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
