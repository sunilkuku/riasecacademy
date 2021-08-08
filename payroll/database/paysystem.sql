-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2021 at 10:37 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `detail` text NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch`, `address`, `detail`, `delete_status`) VALUES
(1, 'Virtual Academy', 'Virtual Academy', 'Virtual Academy', '0'),
(2, 'Career Guidance', 'Career Guidance', 'Career Guidance', '0'),
(3, 'Online Services', 'Online Services', 'Online Services', '0'),
(4, 'Educational Services', 'Educational Services', 'Educational Services', '0');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(255) NOT NULL,
  `cname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `emailid` varchar(255) CHARACTER SET latin1 NOT NULL,
  `contact` varchar(255) CHARACTER SET latin1 NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `department` varchar(255) CHARACTER SET latin1 NOT NULL,
  `departmentname` varchar(255) CHARACTER SET latin1 NOT NULL,
  `company` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `about` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `cname`, `emailid`, `contact`, `place`, `department`, `departmentname`, `company`, `about`, `balance`, `delete_status`) VALUES
(1, 'cyan', 'cyan@gmail.com', '9562336541', 'Thrissur', '3', 'Online Services', 'cyan innovations', 'company', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `coursetype` varchar(255) NOT NULL,
  `detail` text DEFAULT NULL,
  `delete_status` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course`, `coursetype`, `detail`, `delete_status`) VALUES
(2, 'STANDARD 10', 'OPEN SCHOOL', '', '0'),
(3, '+2', 'OPEN SCHOOL', '+2', '0');

-- --------------------------------------------------------

--
-- Table structure for table `edu_transaction`
--

CREATE TABLE `edu_transaction` (
  `id` int(255) NOT NULL,
  `stdid` varchar(255) CHARACTER SET latin1 NOT NULL,
  `submitdate` datetime NOT NULL,
  `academicyear` text NOT NULL,
  `university` varchar(150) NOT NULL,
  `admissionadvance` double NOT NULL DEFAULT 0,
  `firstyearfee` double NOT NULL DEFAULT 0,
  `secondyearfee` double NOT NULL DEFAULT 0,
  `thirdyearfee` double NOT NULL DEFAULT 0,
  `miscellaneousfee` double NOT NULL DEFAULT 0,
  `totalamount` double NOT NULL DEFAULT 0,
  `paid` double NOT NULL DEFAULT 0,
  `transcation_remark` varchar(255) DEFAULT NULL,
  `total_deduction` double NOT NULL DEFAULT 0,
  `skey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `edu_transaction`
--

INSERT INTO `edu_transaction` (`id`, `stdid`, `submitdate`, `academicyear`, `university`, `admissionadvance`, `firstyearfee`, `secondyearfee`, `thirdyearfee`, `miscellaneousfee`, `totalamount`, `paid`, `transcation_remark`, `total_deduction`, `skey`) VALUES
(1, '17', '2021-07-24 00:00:00', '2021-22', 'KTU', 1000, 8000, 0, 0, 0, 9000, 9000, 'CASH', 0, 'Aw63xxIJgeEX');

-- --------------------------------------------------------

--
-- Table structure for table `fees_transaction`
--

CREATE TABLE `fees_transaction` (
  `id` int(255) NOT NULL,
  `stdid` varchar(255) NOT NULL,
  `paid` double NOT NULL,
  `counsellingfee` double NOT NULL DEFAULT 0,
  `monitoringfee` double NOT NULL DEFAULT 0,
  `aptitudefee` double NOT NULL DEFAULT 0,
  `personalityfee` double NOT NULL DEFAULT 0,
  `assessmentfee` double NOT NULL DEFAULT 0,
  `totalfee` double NOT NULL,
  `submitdate` varchar(50) NOT NULL,
  `transcation_remark` text DEFAULT NULL,
  `total_deduction` double DEFAULT NULL,
  `balacetopay` double DEFAULT NULL,
  `othexpense` double NOT NULL DEFAULT 0,
  `skey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fees_transaction`
--

INSERT INTO `fees_transaction` (`id`, `stdid`, `paid`, `counsellingfee`, `monitoringfee`, `aptitudefee`, `personalityfee`, `assessmentfee`, `totalfee`, `submitdate`, `transcation_remark`, `total_deduction`, `balacetopay`, `othexpense`, `skey`) VALUES
(1, '15', 3000, 1000, 1000, 0, 0, 0, 1000, '2021-07-24', 'Google Pay', 0, 3000, 0, '4VRXOtzzhAT1');

-- --------------------------------------------------------

--
-- Table structure for table `onlinepay_transaction`
--

CREATE TABLE `onlinepay_transaction` (
  `id` int(255) NOT NULL,
  `stdid` varchar(255) CHARACTER SET latin1 NOT NULL,
  `submitdate` datetime NOT NULL,
  `websitefee` double NOT NULL DEFAULT 0,
  `digitalfee` double NOT NULL DEFAULT 0,
  `appfee` double NOT NULL DEFAULT 0,
  `financialfee` double NOT NULL DEFAULT 0,
  `applicationfee` double NOT NULL DEFAULT 0,
  `certificatefee` double NOT NULL DEFAULT 0,
  `others` double NOT NULL DEFAULT 0,
  `totalamount` double NOT NULL DEFAULT 0,
  `paid` double NOT NULL DEFAULT 0,
  `transcation_remark` varchar(255) DEFAULT NULL,
  `total_deduction` double NOT NULL DEFAULT 0,
  `skey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `onlinepay_transaction`
--

INSERT INTO `onlinepay_transaction` (`id`, `stdid`, `submitdate`, `websitefee`, `digitalfee`, `appfee`, `financialfee`, `applicationfee`, `certificatefee`, `others`, `totalamount`, `paid`, `transcation_remark`, `total_deduction`, `skey`) VALUES
(1, '1', '2021-07-24 00:00:00', 10000, 0, 0, 0, 0, 0, 0, 10000, 10000, 'Google Pay', 0, 'Cln3i3XX7CCG');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `joindate` datetime NOT NULL,
  `birthdate` datetime NOT NULL,
  `about` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `fees` int(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `branchname` varchar(255) DEFAULT NULL,
  `balance` double NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0',
  `rollno` varchar(100) NOT NULL,
  `course` varchar(255) NOT NULL,
  `coursename` varchar(255) DEFAULT NULL,
  `coursetype` varchar(255) NOT NULL,
  `organization` text NOT NULL,
  `university` varchar(255) DEFAULT NULL,
  `academicyear` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `emailid`, `sname`, `joindate`, `birthdate`, `about`, `contact`, `place`, `fees`, `branch`, `branchname`, `balance`, `delete_status`, `rollno`, `course`, `coursename`, `coursetype`, `organization`, `university`, `academicyear`) VALUES
(15, 'sunildhony@gmail.com', 'sunil', '2021-07-10 00:00:00', '1992-06-06 00:00:00', '', '9562336541', 'Thrissur', 1000, '2', 'Career Guidance', 0, '0', 'masadssdsd', '2', 'STANDARD 10', 'OPEN SCHOOL', 'malabar', NULL, NULL),
(16, 'sunildhony@gmail.com', 'kuku', '2021-07-10 00:00:00', '1992-06-03 00:00:00', 'kuku', '9562336541', 'thrissur', 1000, '1', 'Virtual Academy', 0, '0', '111', '2', 'STANDARD 10', 'OPEN SCHOOL', 'malabar', 'KTU', '2021-22'),
(17, 'sunildhony@gmail.com', 'sunil kuku', '2021-07-11 00:00:00', '1992-06-03 00:00:00', '', '9562336541', 'thrissur', 0, '4', 'Educational Services', 0, '0', '2007', '3', '+2', 'OPEN SCHOOL', 'malabar2', 'KTU', '2021-22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `emailid`, `lastlogin`) VALUES
(1, 'admin', '7488e331b8b64e5794da3fa4eb10ad5d', 'admin', 'sunil@gmail.com', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `virtual_transaction`
--

CREATE TABLE `virtual_transaction` (
  `id` int(255) NOT NULL,
  `stdid` varchar(255) CHARACTER SET latin1 NOT NULL,
  `submitdate` datetime NOT NULL,
  `admissionfee` double NOT NULL DEFAULT 0,
  `secondaryfee` double NOT NULL DEFAULT 0,
  `seniorsecondary` double NOT NULL DEFAULT 0,
  `ugfee` double NOT NULL DEFAULT 0,
  `miscellaneousfee` double NOT NULL DEFAULT 0,
  `totalamount` double NOT NULL DEFAULT 0,
  `paid` double NOT NULL DEFAULT 0,
  `transcation_remark` varchar(255) DEFAULT NULL,
  `total_deduction` double NOT NULL DEFAULT 0,
  `pgfee` double NOT NULL DEFAULT 0,
  `diplomafee` double NOT NULL DEFAULT 0,
  `regfee` double NOT NULL DEFAULT 0,
  `examfee` double NOT NULL DEFAULT 0,
  `materialsfee` double NOT NULL DEFAULT 0,
  `skey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `virtual_transaction`
--

INSERT INTO `virtual_transaction` (`id`, `stdid`, `submitdate`, `admissionfee`, `secondaryfee`, `seniorsecondary`, `ugfee`, `miscellaneousfee`, `totalamount`, `paid`, `transcation_remark`, `total_deduction`, `pgfee`, `diplomafee`, `regfee`, `examfee`, `materialsfee`, `skey`) VALUES
(1, '16', '2021-07-24 00:00:00', 500, 10000, 0, 0, 0, 11500, 11500, 'Phone Pe', 0, 0, 0, 0, 0, 1000, 'JvkEvynxxi6k');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edu_transaction`
--
ALTER TABLE `edu_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlinepay_transaction`
--
ALTER TABLE `onlinepay_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtual_transaction`
--
ALTER TABLE `virtual_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `edu_transaction`
--
ALTER TABLE `edu_transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `onlinepay_transaction`
--
ALTER TABLE `onlinepay_transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `virtual_transaction`
--
ALTER TABLE `virtual_transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
