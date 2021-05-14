-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: Pi 14.Máj 2021, 10:12
-- Verzia serveru: 8.0.23-0ubuntu0.20.04.1
-- Verzia PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `exam`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `answer`
--

CREATE TABLE `answer` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `value` varchar(1000) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `correct` enum('true','false','TBD') CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `points` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `value`, `correct`, `points`) VALUES
(1, 1, 'Ano', 'true', 10),
(2, 1, 'Nie', 'false', 0),
(3, 2, 'dobre', 'true', 20),
(4, 3, 'Neviem toto ako bude realizovane', 'TBD', 1000),
(41, 12, 'chcem', 'false', 0),
(42, 12, 'nerobim', 'false', 0),
(43, 12, 'nechcem', 'true', 4),
(44, 12, 'musim', 'false', 0),
(45, 13, 'odpoved', 'true', 4),
(46, 14, 'odpoved 2', 'true', 5),
(47, 15, 'odpoved a', 'true', 1),
(48, 15, 'odpoved b', 'false', 0),
(49, 15, 'odpoved c', 'false', 0),
(50, 15, 'odpoved d', 'false', 0),
(51, 16, 'odpoved a', 'true', 1),
(52, 16, 'odpoved b', 'false', 0),
(53, 16, '', 'false', 0),
(54, 16, '', 'false', 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `question`
--

CREATE TABLE `question` (
  `id` int NOT NULL,
  `test_id` int NOT NULL,
  `value` varchar(1000) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `type` enum('text','choice','pair','math','drawing') CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `max_points` int NOT NULL,
  `review_answer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `question`
--

INSERT INTO `question` (`id`, `test_id`, `value`, `type`, `max_points`, `review_answer`) VALUES
(1, 1, 'Som huge?', 'choice', 10, 0),
(2, 1, 'Ako sa mas?', 'text', 20, 1),
(3, 1, 'Nakresli obrazok', 'drawing', 1000, 1),
(4, 2, 'neznama', 'choice', 3, 1),
(12, 2, 'Preco to cele robim?', 'choice', 4, 1),
(13, 3, 'otazka 1', 'text', 4, 1),
(14, 3, 'otazka 2', 'text', 5, 1),
(15, 3, 'otazka 1 choice', 'choice', 1, 0),
(16, 3, 'otazka 2 choice', 'choice', 1, 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `pid` varchar(256) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `student`
--

INSERT INTO `student` (`id`, `pid`, `name`, `surname`) VALUES
(24, '1234', 'test', 'tester'),
(32, '434', 'dalsi', 'test'),
(10, '7890', 'Student', 'Ackar'),
(44, 'as', 'as', 'as'),
(45, 'ass', 'ass', 'ass'),
(46, 'asss', 'asss', 'asss'),
(40, 'd', 'ae', 'e'),
(41, 'd', 'aea', 'e'),
(42, 'd', 'aeaa', 'e'),
(43, 'd', 'aeaaa', 'e'),
(33, 'd', 'e', 'e'),
(38, 'er', 'q', 'q'),
(47, 'ki', 'mi', 'mi'),
(51, 'o', 'o', 'o');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `student_test`
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
-- Sťahujem dáta pre tabuľku `student_test`
--

INSERT INTO `student_test` (`id`, `student_id`, `test_id`, `timer_id`, `in_test`, `completed`, `score`) VALUES
(20, 10, 1, 2, 1, 1, NULL),
(21, 24, 1, 2, 1, 1, NULL),
(23, 32, 1, 2, 0, 0, NULL),
(31, 33, 2, 2, 0, 0, NULL),
(35, 40, 2, 2, 0, 0, NULL),
(36, 44, 2, 4, 0, 0, NULL),
(39, 44, 3, 7, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `student_test_answer`
--

CREATE TABLE `student_test_answer` (
  `id` int NOT NULL,
  `student_test_id` int NOT NULL,
  `question_id` int NOT NULL,
  `points` int NOT NULL,
  `student_answer` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `student_test_answer`
--

INSERT INTO `student_test_answer` (`id`, `student_test_id`, `question_id`, `points`, `student_answer`) VALUES
(50, 20, 2, 0, ''),
(51, 20, 3, 20, ''),
(52, 20, 1, 1000, ''),
(55, 20, 4, 3, 'cierna'),
(56, 21, 4, 3, ' Cierna '),
(59, 39, 13, 0, 'afasdf'),
(60, 39, 14, 0, 'fasf'),
(61, 39, 15, 1, 'odpoved a'),
(62, 39, 16, 0, 'odpoved b');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `teacher`
--

CREATE TABLE `teacher` (
  `id` int NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `teacher`
--

INSERT INTO `teacher` (`id`, `email`, `password`) VALUES
(1, 'teacher@stuba.sk', 'heslo123'),
(2, 'mim@gmail.com', '$2y$10$yBkn3322lGJkYWdkN0XkD.t1l2zjBmuvtUJEYoNP5oO3r8NhP0sn.'),
(3, 'michaela.polakova@gmail.com', '$2y$10$JK7VRHD8bB5OtfDnAZOhk.o.cwqW.oZFi.1sKS31x6pgetOM3Gah6'),
(4, 'mi@gmail.com', '$2y$10$KwhQXdQ6j5m.pcmfpIr0/ua1gzPhny1Td.gJHndq3neV9YZQgMq5W');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `test`
--

CREATE TABLE `test` (
  `id` int NOT NULL,
  `timer_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `shared_key` varchar(10) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `test`
--

INSERT INTO `test` (`id`, `timer_id`, `teacher_id`, `shared_key`, `name`, `active`) VALUES
(1, 1, 1, 'key123', '', 0),
(2, 1, 1, 'a', 'qer', 1),
(3, 1, 1, 'abc', 'test', 1);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `timer`
--

CREATE TABLE `timer` (
  `id` int NOT NULL,
  `hours` int NOT NULL,
  `minutes` int NOT NULL,
  `seconds` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `timer`
--

INSERT INTO `timer` (`id`, `hours`, `minutes`, `seconds`) VALUES
(1, 1, 0, 0),
(2, 0, 32, 59),
(3, 0, 0, 0),
(4, 1, 0, 0),
(5, 1, 0, 0),
(6, 1, 0, 0),
(7, 1, 0, 0),
(8, 1, 0, 0),
(9, 1, 0, 0),
(10, 1, 0, 0),
(11, 1, 0, 0);

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexy pre tabuľku `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexy pre tabuľku `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pid` (`pid`,`name`,`surname`);

--
-- Indexy pre tabuľku `student_test`
--
ALTER TABLE `student_test`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id_2` (`student_id`,`test_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `timer_id` (`timer_id`);

--
-- Indexy pre tabuľku `student_test_answer`
--
ALTER TABLE `student_test_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_test_id` (`student_test_id`),
  ADD KEY `answer_id` (`question_id`);

--
-- Indexy pre tabuľku `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexy pre tabuľku `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shared_key` (`shared_key`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `timer_id` (`timer_id`);

--
-- Indexy pre tabuľku `timer`
--
ALTER TABLE `timer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pre tabuľku `question`
--
ALTER TABLE `question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pre tabuľku `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pre tabuľku `student_test`
--
ALTER TABLE `student_test`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pre tabuľku `student_test_answer`
--
ALTER TABLE `student_test_answer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pre tabuľku `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pre tabuľku `test`
--
ALTER TABLE `test`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `timer`
--
ALTER TABLE `timer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Obmedzenie pre tabuľku `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Obmedzenie pre tabuľku `student_test`
--
ALTER TABLE `student_test`
  ADD CONSTRAINT `student_test_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_test_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_test_ibfk_3` FOREIGN KEY (`timer_id`) REFERENCES `timer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Obmedzenie pre tabuľku `student_test_answer`
--
ALTER TABLE `student_test_answer`
  ADD CONSTRAINT `student_test_answer_ibfk_1` FOREIGN KEY (`student_test_id`) REFERENCES `student_test` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_test_answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
