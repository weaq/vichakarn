-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 28 ก.พ. 2024 เมื่อ 04:09 PM
-- เวอร์ชันของเซิร์ฟเวอร์: 8.0.36-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vichakarn`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `groupsara`
--

CREATE TABLE `groupsara` (
  `ID` int UNSIGNED NOT NULL,
  `group_id` int UNSIGNED DEFAULT NULL COMMENT 'รหัสกลุ่มสาระ',
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'กลุ่มสาระ',
  `group_status` int DEFAULT NULL COMMENT 'สถานะ',
  `activity_id` int UNSIGNED DEFAULT NULL COMMENT 'รหัสกิจกรรม',
  `activity_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ชื่อกิจกรรม',
  `class_id` int UNSIGNED DEFAULT NULL COMMENT 'รหัสระดับ',
  `class_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ชื่อระดับ',
  `student_no_min` int UNSIGNED DEFAULT NULL COMMENT 'จำนวนนักเรียนน้อยสุด',
  `student_no` int UNSIGNED DEFAULT NULL COMMENT 'จำนวนนักเรียน',
  `teacher_no` int UNSIGNED DEFAULT NULL COMMENT 'จำนวนผู้ควบคุม',
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'สถานที่แข่งขัน',
  `match_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'เวลาการแข่งขัน',
  `match_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'วันที่แข่งขัน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- dump ตาราง `groupsara`
--

INSERT INTO `groupsara` (`ID`, `group_id`, `group_name`, `group_status`, `activity_id`, `activity_name`, `class_id`, `class_name`, `student_no_min`, `student_no`, `teacher_no`, `location`, `match_time`, `match_date`) VALUES
(1, 1, 'ภาษาไทย', 1, 1, 'กล่าวสุนทรพจน์', 3, 'ป.4-6', 1, 1, 1, '', '', ''),
(2, 1, 'ภาษาไทย', 1, 2, 'กล่าวสุนทรพจน์', 4, 'ม.1-3', 1, 1, 1, '', '', ''),
(3, 1, 'ภาษาไทย', 1, 3, 'กล่าวสุนทรพจน์', 5, 'ม.4-6', 1, 1, 1, '', '', ''),
(4, 1, 'ภาษาไทย', 1, 4, 'คัดลายมือ', 2, 'ป.1-3', 1, 1, 1, '', '', ''),
(5, 1, 'ภาษาไทย', 1, 5, 'คัดลายมือ', 3, 'ป.4-6', 1, 1, 1, '', '', ''),
(6, 1, 'ภาษาไทย', 1, 6, 'คัดลายมือ', 4, 'ม.1-3', 1, 1, 1, '', '', ''),
(7, 1, 'ภาษาไทย', 1, 7, 'คัดลายมือ', 5, 'ม.4-6', 1, 1, 1, '', '', ''),
(8, 1, 'ภาษาไทย', 1, 8, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(9, 1, 'ภาษาไทย', 1, 9, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(10, 1, 'ภาษาไทย', 1, 10, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(11, 1, 'ภาษาไทย', 1, 11, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(12, 2, 'คณิตศาสตร์', 1, 12, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(13, 2, 'คณิตศาสตร์', 1, 13, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(14, 2, 'คณิตศาสตร์', 1, 14, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(15, 2, 'คณิตศาสตร์', 1, 15, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(16, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 16, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(17, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 17, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(18, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 18, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(19, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 19, 'ทักษะคอมพิวเตอร์', 3, 'ป.4-6', 1, 1, 1, '', '', ''),
(20, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 20, 'ทักษะคอมพิวเตอร์', 4, 'ม.1-3', 1, 1, 1, '', '', ''),
(21, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 21, 'ทักษะคอมพิวเตอร์', 5, 'ม.4-6', 1, 1, 1, '', '', ''),
(22, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 22, 'หุ่นยนต์', 3, 'ป.4-6', 4, 4, 3, '', '', ''),
(23, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 23, 'หุ่นยนต์', 4, 'ม.1-3', 4, 4, 3, '', '', ''),
(24, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 24, 'หุ่นยนต์', 5, 'ม.4-6', 4, 4, 3, '', '', ''),
(25, 3, 'วิทยาศาสตร์และเทคโนโลยี ', 1, 25, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(26, 4, 'สังคมศึกษาศาสนา และวัฒนธรรม', 1, 26, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(27, 4, 'สังคมศึกษาศาสนา และวัฒนธรรม', 1, 27, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(28, 4, 'สังคมศึกษาศาสนา และวัฒนธรรม', 1, 28, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(29, 4, 'สังคมศึกษาศาสนา และวัฒนธรรม', 1, 29, 'ตอบปัญหาคุณธรรม', 3, 'ป.4-6', 1, 1, 1, '', '', ''),
(30, 4, 'สังคมศึกษาศาสนา และวัฒนธรรม', 1, 30, 'ตอบปัญหาคุณธรรม', 4, 'ม.1-3', 1, 1, 1, '', '', ''),
(31, 4, 'สังคมศึกษาศาสนา และวัฒนธรรม', 1, 31, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(32, 5, 'สุขศึกษา และพลศึกษา', 1, 32, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(33, 5, 'สุขศึกษา และพลศึกษา', 1, 33, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(34, 5, 'สุขศึกษา และพลศึกษา', 1, 34, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(35, 5, 'สุขศึกษา และพลศึกษา', 1, 35, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(36, 6, 'ศิลปะ', 1, 36, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(37, 6, 'ศิลปะ', 1, 37, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(38, 6, 'ศิลปะ', 1, 38, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(39, 6, 'ศิลปะ', 1, 39, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(40, 6, 'ศิลปะ', 1, 40, 'ร้องเพลงพระราชนิพนธ์', 3, 'ป.4-6', 6, 9, 3, '', '', ''),
(41, 6, 'ศิลปะ', 1, 41, 'ร้องเพลงพระราชนิพนธ์', 4, 'ม.1-3', 6, 10, 3, '', '', ''),
(42, 6, 'ศิลปะ', 1, 42, 'ร้องเพลงพระราชนิพนธ์', 5, 'ม.4-6', 6, 11, 3, '', '', ''),
(43, 6, 'ศิลปะ', 1, 43, 'ร้องเพลงลูกทุ่งพร้อมแดนเซอร์', 6, 'ป.1-6', 6, 12, 3, '', '', ''),
(44, 6, 'ศิลปะ', 1, 44, 'ร้องเพลงลูกทุ่งพร้อมแดนเซอร์', 7, 'ม.1-6', 6, 13, 3, '', '', ''),
(45, 6, 'ศิลปะ', 1, 45, 'รำวงมาตรฐาน', 6, 'ป.1-6', 8, 10, 4, '', '', ''),
(46, 6, 'ศิลปะ', 1, 46, 'รำวงมาตรฐาน', 7, 'ม.1-6', 8, 10, 4, '', '', ''),
(47, 6, 'ศิลปะ', 1, 47, 'นาฏศิลป์ไทยสร้างสรรค์', 6, 'ป.1-6', 8, 16, 4, '', '', ''),
(48, 6, 'ศิลปะ', 1, 48, 'นาฏศิลป์ไทยสร้างสรรค์', 7, 'ม.1-6', 8, 16, 4, '', '', ''),
(49, 6, 'ศิลปะ', 1, 49, 'วาดภาพระบายสี', 2, 'ป.1-3', 2, 2, 1, '', '', ''),
(50, 6, 'ศิลปะ', 1, 50, 'วาดภาพระบายสี', 3, 'ป.4-6', 2, 2, 1, '', '', ''),
(51, 6, 'ศิลปะ', 1, 51, 'วาดภาพระบายสี', 4, 'ม.1-3', 2, 2, 1, '', '', ''),
(52, 6, 'ศิลปะ', 1, 52, 'วาดภาพระบายสี', 5, 'ม.4-6', 2, 2, 1, '', '', ''),
(53, 7, 'การงานอาชีพ', 1, 53, 'โครงงาน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(54, 7, 'การงานอาชีพ', 1, 54, 'โครงงาน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(55, 7, 'การงานอาชีพ', 1, 55, 'โครงงาน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(56, 7, 'การงานอาชีพ', 1, 56, 'แกะสลักผลไม้', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(57, 7, 'การงานอาชีพ', 1, 57, 'แกะสลักผลไม้', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(58, 7, 'การงานอาชีพ', 1, 58, 'แกะสลักผลไม้', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(59, 7, 'การงานอาชีพ', 1, 59, 'งานประดิษฐ์จากใบตอง', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(60, 7, 'การงานอาชีพ', 1, 60, 'งานประดิษฐ์จากใบตอง', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(61, 7, 'การงานอาชีพ', 1, 61, 'งานประดิษฐ์จากใบตอง', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(62, 7, 'การงานอาชีพ', 1, 62, 'ประดิษฐ์ร้อยมาลัย', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(63, 7, 'การงานอาชีพ', 1, 63, 'ประดิษฐ์ร้อยมาลัย', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(64, 7, 'การงานอาชีพ', 1, 64, 'ประดิษฐ์ร้อยมาลัย', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(65, 7, 'การงานอาชีพ', 1, 65, 'ประดิษฐ์ของจากวัสดุเหลือใช้', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(66, 7, 'การงานอาชีพ', 1, 66, 'ประดิษฐ์ของจากวัสดุเหลือใช้', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(67, 7, 'การงานอาชีพ', 1, 67, 'ประดิษฐ์ของจากวัสดุเหลือใช้', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(68, 7, 'การงานอาชีพ', 1, 68, 'จัดสวนถาดแห้ง ไม่กำหนดช่วงชั้น', 11, 'ครู', 4, 4, 3, '', '', ''),
(69, 7, 'การงานอาชีพ', 1, 69, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(70, 8, 'ภาษาต่างประเทศ', 1, 70, 'กล่าวสุนทรพจน์ภาษาอังกฤษ', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(71, 8, 'ภาษาต่างประเทศ', 1, 71, 'กล่าวสุนทรพจน์ภาษาอังกฤษ', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(72, 8, 'ภาษาต่างประเทศ', 1, 72, 'กล่าวสุนทรพจน์ภาษาอังกฤษ', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(73, 8, 'ภาษาต่างประเทศ', 1, 73, 'กล่าวสุนทรพจน์ภาษาจีน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(74, 8, 'ภาษาต่างประเทศ', 1, 74, 'กล่าวสุนทรพจน์ภาษาจีน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(75, 8, 'ภาษาต่างประเทศ', 1, 75, 'กล่าวสุนทรพจน์ภาษาจีน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(76, 8, 'ภาษาต่างประเทศ', 1, 76, 'แสดงละครภาษาอังกฤษ', 3, 'ป.4-6', 5, 10, 5, '', '', ''),
(77, 8, 'ภาษาต่างประเทศ', 1, 77, 'แสดงละครภาษาอังกฤษ', 4, 'ม.1-3', 5, 10, 5, '', '', ''),
(78, 8, 'ภาษาต่างประเทศ', 1, 78, 'แสดงละครภาษาอังกฤษ', 5, 'ม.4-6', 5, 10, 5, '', '', ''),
(79, 8, 'ภาษาต่างประเทศ', 1, 79, 'แสดงละครภาษาจีน', 3, 'ป.4-6', 5, 10, 5, '', '', ''),
(80, 8, 'ภาษาต่างประเทศ', 1, 80, 'แสดงละครภาษาจีน', 4, 'ม.1-3', 5, 10, 5, '', '', ''),
(81, 8, 'ภาษาต่างประเทศ', 1, 81, 'แสดงละครภาษาจีน', 5, 'ม.4-6', 5, 10, 5, '', '', ''),
(82, 8, 'ภาษาต่างประเทศ', 1, 82, 'โครงงานภาษาอังกฤษ', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(83, 8, 'ภาษาต่างประเทศ', 1, 83, 'โครงงานภาษาอังกฤษ', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(84, 8, 'ภาษาต่างประเทศ', 1, 84, 'โครงงานภาษาอังกฤษ', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(85, 8, 'ภาษาต่างประเทศ', 1, 85, 'โครงงานภาษาจีน', 3, 'ป.4-6', 3, 3, 2, '', '', ''),
(86, 8, 'ภาษาต่างประเทศ', 1, 86, 'โครงงานภาษาจีน', 4, 'ม.1-3', 3, 3, 2, '', '', ''),
(87, 8, 'ภาษาต่างประเทศ', 1, 87, 'โครงงานภาษาจีน', 5, 'ม.4-6', 3, 3, 2, '', '', ''),
(88, 8, 'ภาษาต่างประเทศ', 1, 88, 'สื่อนวัตกรรมครูภาษาอังกฤษ', 11, 'ครู', 1, 1, 1, '', '', ''),
(89, 8, 'ภาษาต่างประเทศ', 1, 89, 'สื่อนวัตกรรมครูภาษาจีน', 11, 'ครู', 1, 1, 1, '', '', ''),
(90, 9, 'ปฐมวัย', 1, 90, 'โครงงาน', 1, 'อายุ 4-6 ปี', 3, 3, 2, '', '', ''),
(91, 9, 'ปฐมวัย', 1, 91, 'วาดภาพระบายสี', 1, 'อายุ 4-6 ปี', 2, 2, 1, '', '', ''),
(92, 9, 'ปฐมวัย', 1, 92, 'เกมส์ทายสิอะไรเอ่ย', 1, 'อายุ 4-6 ปี', 2, 2, 1, '', '', ''),
(93, 9, 'ปฐมวัย', 1, 93, 'เดินตัวหนอน', 1, 'อายุ 4-6 ปี', 10, 10, 5, '', '', ''),
(94, 9, 'ปฐมวัย', 1, 94, 'เริงเล่นเต้นแดนเซอร์', 1, 'อายุ 4-6 ปี', 10, 10, 5, '', '', ''),
(95, 9, 'ปฐมวัย', 1, 95, 'ต่อตัวเสริมทักษะ', 1, 'อายุ 4-6 ปี', 3, 3, 2, '', '', ''),
(96, 9, 'ปฐมวัย', 1, 96, 'ฮูลาฮูป ประกอบเพลง', 1, 'อายุ 4-6 ปี', 10, 10, 5, '', '', ''),
(97, 9, 'ปฐมวัย', 1, 97, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', ''),
(98, 10, 'ศูนย์พัฒนาเด็กเล็ก', 1, 98, 'สื่อนวัตกรรม', 11, 'ครู', 1, 1, 1, '', '', '');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `schools`
--

CREATE TABLE `schools` (
  `id` int NOT NULL,
  `school_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` int NOT NULL COMMENT 'id หน่วยงานต้นสังกัด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `staff`
--

CREATE TABLE `staff` (
  `id` int NOT NULL,
  `user` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- dump ตาราง `staff`
--

INSERT INTO `staff` (`id`, `user`, `passwd`, `name`, `tel`, `email`, `last_login`) VALUES
(1, '03410102', 'd54d1702ad0f8326224b817c796763c9', 'เทศบาลนครอุดรธานี', '042 325 178', 'admin@udoncity.go.th', '2024-02-28 16:00:50');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `studentreg`
--

CREATE TABLE `studentreg` (
  `ID` int NOT NULL,
  `school_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'id table schools',
  `staff_id` int NOT NULL COMMENT 'id หน่วยงานต้นสังกัด',
  `groupsara_id` int NOT NULL COMMENT 'ID tbl wp_groupsara',
  `activity_id` int NOT NULL COMMENT 'รหัสกิจกรรม',
  `class_id` int NOT NULL COMMENT 'รหัสระดับ',
  `student_prefix` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'คำนำหน้า',
  `student_firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อ',
  `student_lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'นามสกุล',
  `display_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_image` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รูปภาพ',
  `tel` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `teacherreg`
--

CREATE TABLE `teacherreg` (
  `ID` int UNSIGNED NOT NULL,
  `school_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'id table schools',
  `staff_id` int NOT NULL COMMENT 'id หน่วยงานต้นสังกัด',
  `groupsara_id` int NOT NULL,
  `activity_id` int NOT NULL COMMENT 'รหัสกิจกรรม',
  `class_id` int NOT NULL COMMENT 'รหัสระดับ',
  `teacher_prefix` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'คำนำหน้า',
  `teacher_firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อ',
  `teacher_lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'นามสกุล',
  `display_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_image` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รูปภาพ',
  `tel` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'โทร.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groupsara`
--
ALTER TABLE `groupsara`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentreg`
--
ALTER TABLE `studentreg`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `teacherreg`
--
ALTER TABLE `teacherreg`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groupsara`
--
ALTER TABLE `groupsara`
  MODIFY `ID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `studentreg`
--
ALTER TABLE `studentreg`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacherreg`
--
ALTER TABLE `teacherreg`
  MODIFY `ID` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
