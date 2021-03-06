-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2021 at 10:31 AM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `value` varchar(1000) COLLATE utf8_slovak_ci NOT NULL,
  `correct` enum('true','false','TBD') COLLATE utf8_slovak_ci NOT NULL,
  `points` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `value`, `correct`, `points`) VALUES
(1, 1, 'Ano', 'true', 10),
(2, 1, 'Nie', 'false', 0),
(3, 2, 'dobre', 'true', 20),
(4, 3, 'Neviem toto ako bude realizovane', 'TBD', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `message` varchar(300) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int NOT NULL,
  `test_id` int NOT NULL,
  `value` varchar(1000) COLLATE utf8_slovak_ci NOT NULL,
  `type` enum('text','choice','pair','math','drawing') COLLATE utf8_slovak_ci NOT NULL,
  `max_points` int NOT NULL,
  `review_answer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `test_id`, `value`, `type`, `max_points`, `review_answer`) VALUES
(1, 1, 'Som huge?', 'choice', 10, 0),
(2, 1, 'Ako sa mas?', 'text', 20, 1),
(3, 1, 'Nakresli obrazok', 'drawing', 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `pid` varchar(256) COLLATE utf8_slovak_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_slovak_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `pid`, `name`, `surname`) VALUES
(24, '1234', 'test', 'tester'),
(33, '3434', 'Samo', 'Hudak'),
(32, '434', 'dalsi', 'test'),
(10, '7890', 'Student', 'Ackar'),
(40, 'daw', 'da', 'da');

-- --------------------------------------------------------

--
-- Table structure for table `student_test`
--

CREATE TABLE `student_test` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `test_id` int NOT NULL,
  `timer_id` int NOT NULL,
  `in_test` tinyint(1) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `score` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `student_test`
--

INSERT INTO `student_test` (`id`, `student_id`, `test_id`, `timer_id`, `in_test`, `completed`, `score`) VALUES
(20, 10, 1, 2, 0, 0, NULL),
(21, 24, 1, 2, 1, 1, NULL),
(23, 32, 1, 2, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_test_answer`
--

CREATE TABLE `student_test_answer` (
  `id` int NOT NULL,
  `student_test_id` int NOT NULL,
  `question_id` int NOT NULL,
  `student_answer` varchar(300) COLLATE utf8_slovak_ci NOT NULL,
  `points` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int NOT NULL,
  `email` varchar(100) COLLATE utf8_slovak_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `email`, `password`) VALUES
(1, 'teacher@stuba.sk', 'heslo123'),
(2, 'ucitel@ucitel.sk', '$2y$10$LUbOmp9dLx5syCgbUVBxc.RMjeDgvPLWConvftFoyVkCMMnDntcjK'),
(3, 'marak@stuba.sk', '$2y$10$aRVaq1gHQ.REfHX.vyQGTePrPsZPgWTXwx3M0e9kFglKzdS.Hvaau');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int NOT NULL,
  `timer_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `shared_key` varchar(10) COLLATE utf8_slovak_ci NOT NULL,
  `name` varchar(256) COLLATE utf8_slovak_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `timer_id`, `teacher_id`, `shared_key`, `name`, `active`) VALUES
(1, 1, 2, 'key123', '', 0),
(2, 1, 2, 'ahoj12', 'Novy test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `id` int NOT NULL,
  `hours` int NOT NULL,
  `minutes` int NOT NULL,
  `seconds` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`id`, `hours`, `minutes`, `seconds`) VALUES
(1, 1, 0, 0),
(2, 0, 0, 0),
(3, 0, 34, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pid` (`pid`,`name`,`surname`);

--
-- Indexes for table `student_test`
--
ALTER TABLE `student_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `timer_id` (`timer_id`);

--
-- Indexes for table `student_test_answer`
--
ALTER TABLE `student_test_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_test_id` (`student_test_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shared_key` (`shared_key`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `timer_id` (`timer_id`);

--
-- Indexes for table `timer`
--
ALTER TABLE `timer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `student_test`
--
ALTER TABLE `student_test`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timer`
--
ALTER TABLE `timer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_test`
--
ALTER TABLE `student_test`
  ADD CONSTRAINT `student_test_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_test_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_test_ibfk_3` FOREIGN KEY (`timer_id`) REFERENCES `timer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_test_answer`
--
ALTER TABLE `student_test_answer`
  ADD CONSTRAINT `student_test_answer_ibfk_1` FOREIGN KEY (`student_test_id`) REFERENCES `student_test` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_test_answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `test_ibfk_2` FOREIGN KEY (`timer_id`) REFERENCES `timer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
