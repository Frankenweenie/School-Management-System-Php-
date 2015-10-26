-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2015 at 05:06 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `student_id` int(10) NOT NULL,
  `score` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `teacher_id` int(10) NOT NULL,
  KEY `FKattendance942477` (`teacher_id`),
  KEY `FKattendance599068` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(10) NOT NULL AUTO_INCREMENT,
  `classname` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `classname`) VALUES
(1, 'Java');

-- --------------------------------------------------------

--
-- Table structure for table `score_acitivty`
--

CREATE TABLE IF NOT EXISTS `score_acitivty` (
  `student_id` int(10) NOT NULL,
  `score` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `teacher_id` int(10) NOT NULL,
  KEY `FKscore_acit485813` (`teacher_id`),
  KEY `FKscore_acit829222` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `score_exam`
--

CREATE TABLE IF NOT EXISTS `score_exam` (
  `student_id` int(10) NOT NULL,
  `score` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `ename` int(10) DEFAULT NULL,
  `teacher_id` int(10) NOT NULL,
  KEY `FKscore_exam85442` (`teacher_id`),
  KEY `FKscore_exam428851` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `score_homework`
--

CREATE TABLE IF NOT EXISTS `score_homework` (
  `student_id` int(10) NOT NULL,
  `score` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hwname` varchar(20) DEFAULT NULL,
  `teacher_id` int(10) NOT NULL,
  KEY `FKscore_home530204` (`teacher_id`),
  KEY `FKscore_home186795` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(10) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `teacherclass_id` int(10) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  KEY `FKstudent855086` (`teacherclass_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `lastname`, `firstname`, `teacherclass_id`, `code`) VALUES
(1, 'Dulam', 'Dulamaa', 1, 'AE150201'),
(2, 'Badka', 'Badral', 1, 'AE150203');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(10) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `firstname` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `subject_type` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `lastname`, `firstname`, `username`, `password`, `subject_type`) VALUES
(1, 'Дорж', 'Дулам', 'admin', 'admin', 'Java');

-- --------------------------------------------------------

--
-- Table structure for table `teacherclass`
--

CREATE TABLE IF NOT EXISTS `teacherclass` (
  `teacherclass_id` int(10) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(10) NOT NULL,
  `class_id` int(10) NOT NULL,
  PRIMARY KEY (`teacherclass_id`),
  KEY `FKteachercla245070` (`class_id`),
  KEY `FKteachercla268593` (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teacherclass`
--

INSERT INTO `teacherclass` (`teacherclass_id`, `teacher_id`, `class_id`) VALUES
(1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `FKattendance599068` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `FKattendance942477` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `score_acitivty`
--
ALTER TABLE `score_acitivty`
  ADD CONSTRAINT `FKscore_acit485813` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `FKscore_acit829222` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `score_exam`
--
ALTER TABLE `score_exam`
  ADD CONSTRAINT `FKscore_exam428851` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `FKscore_exam85442` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `score_homework`
--
ALTER TABLE `score_homework`
  ADD CONSTRAINT `FKscore_home186795` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `FKscore_home530204` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FKstudent855086` FOREIGN KEY (`teacherclass_id`) REFERENCES `teacherclass` (`teacherclass_id`);

--
-- Constraints for table `teacherclass`
--
ALTER TABLE `teacherclass`
  ADD CONSTRAINT `FKteachercla245070` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `FKteachercla268593` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
