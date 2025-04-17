-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 12:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@example.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dpt_id` int(11) NOT NULL,
  `dpt_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

-- INSERT INTO `department` (`dpt_id`, `dpt_name`, `location`, `created_at`) VALUES
-- (1, 'HR', 'Building A', '2024-12-17 16:58:37'),
-- (2, 'IT', 'Building B', '2024-12-17 16:58:37'),
-- (3, 'Finance', 'Building C', '2024-12-17 16:58:37');


INSERT INTO `department` (`dpt_id`, `dpt_name`, `location`, `created_at`) VALUES
(1, 'Human Resources', 'Building A F1', '2025-01-01'),
(2, 'Marketing', 'Building A F2', '2025-01-01'),
(3, 'Finance', 'Building A F3', '2025-01-01'),
(4, 'Sales', 'Building A F4', '2025-01-01'),
(5, 'IT', 'Building B F1', '2025-01-01'),
(6, 'Legal', 'Building B F2', '2025-01-01'),
(7, 'Customer Support', 'Building B F3', '2025-01-01'),
(8, 'Operations', 'Building C F1', '2025-01-01'),
(9, 'Research & Development', 'Building C F2', '2025-01-01'),
(10, 'Product Management', 'Building C F3', '2025-01-01'),
(11, 'Business Development', 'Building D F1', '2025-01-01'),
(12, 'Procurement', 'Building D F2', '2025-01-01'),
(13, 'Engineering', 'Building D F3', '2025-01-01'),
(14, 'Quality Assurance', 'Building E F1', '2025-01-01'),
(15, 'Training & Development', 'Building E F2', '2025-01-01'),
(16, 'Compliance', 'Building E F3', '2025-01-01'),
(17, 'Supply Chain', 'Building F F1', '2025-01-01'),
(18, 'Public Relations', 'Building F F2', '2025-01-01'),
(19, 'Design', 'Building F F3', '2025-01-01'),
(20, 'Administrative', 'Building F F4', '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `emp_id` int(11) NOT NULL,
  `dpt_id` int(11) DEFAULT NULL,
  `emp_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `type` enum('full-time','part-time','contract') NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `login_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `resume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_details`
--

-- INSERT INTO `employee_details` (`emp_id`, `dpt_id`, `emp_name`, `email`, `phone`, `address`, `type`, `status`, `login_id`, `password`, `created_at`, `image`, `resume`) VALUES
-- (1, 1, 'John Doe', 'johndoe@example.com', '1234567890', '123 Main St', 'full-time', 'active', 'johndoe', '123', '2024-12-17 16:58:37', 'download.jpg', 'Ankush_Web_Dev_Resume_2024.pdf'),
-- (2, 2, 'Jane Smith', 'janesmith@example.com', '0987654321', '456 Oak St', 'part-time', 'active', 'janesmith', '456', '2024-12-17 16:58:37', 'jane_smith.jpg', 'jane_smith_resume.pdf');


INSERT INTO `employee_details` (`emp_id`, `dpt_id`, `emp_name`, `email`, `phone`, `address`, `type`, `status`, `login_id`, `password`, `created_at`, `image`, `resume`) VALUES
(1, 1, 'John Doe', 'john.doe@example.com', '555-0101', '123 Apple St, New York, NY', 'Full-time', 'Active', 'john.d', 'password123', '2025-01-01', 'john.jpg', 'john_resume.pdf'),
(2, 2, 'Bob Smith', 'bob.smith@example.com', '555-0102', '456 Oak St, Los Angeles, CA', 'Full-time', 'Active', 'bob.s', 'password123', '2025-01-02', 'bob.jpg', 'bob_resume.pdf'),
(3, 3, 'Charlie Brown', 'charlie.brown@example.com', '555-0103', '789 Pine St, Chicago, IL', 'Part-time', 'Active', 'charlie.b', 'password123', '2025-01-03', 'charlie.jpg', 'charlie_resume.pdf'),
(4, 4, 'David Clark', 'david.clark@example.com', '555-0104', '101 Elm St, San Francisco, CA', 'Full-time', 'Active', 'david.c', 'password123', '2025-01-04', 'david.jpg', 'david_resume.pdf'),
(5, 5, 'Emma Lee', 'emma.lee@example.com', '555-0105', '202 Birch St, Seattle, WA', 'Full-time', 'Active', 'emma.l', 'password123', '2025-01-05', 'emma.jpg', 'emma_resume.pdf'),
(6, 6, 'Frank Miller', 'frank.miller@example.com', '555-0106', '303 Cedar St, Boston, MA', 'Contract', 'Inactive', 'frank.m', 'password123', '2025-01-06', 'frank.jpg', 'frank_resume.pdf'),
(7, 7, 'Grace Davis', 'grace.davis@example.com', '555-0107', '404 Pine St, Austin, TX', 'Full-time', 'Active', 'grace.d', 'password123', '2025-01-07', 'grace.jpg', 'grace_resume.pdf'),
(8, 8, 'Henry Wilson', 'henry.wilson@example.com', '555-0108', '505 Fir St, Denver, CO', 'Part-time', 'Active', 'henry.w', 'password123', '2025-01-08', 'henry.jpg', 'henry_resume.pdf'),
(9, 9, 'Ivy Walker', 'ivy.walker@example.com', '555-0109', '606 Oak St, Miami, FL', 'Full-time', 'Active', 'ivy.w', 'password123', '2025-01-09', 'ivy.jpg', 'ivy_resume.pdf'),
(10, 10, 'Jack King', 'jack.king@example.com', '555-0110', '707 Maple St, Dallas, TX', 'Full-time', 'Active', 'jack.k', 'password123', '2025-01-10', 'jack.jpg', 'jack_resume.pdf'),
(11, 11, 'Katherine Scott', 'katherine.scott@example.com', '555-0111', '808 Pine St, Houston, TX', 'Full-time', 'Active', 'katherine.s', 'password123', '2025-01-11', 'katherine.jpg', 'katherine_resume.pdf'),
(12, 12, 'Leo Martinez', 'leo.martinez@example.com', '555-0112', '909 Birch St, Atlanta, GA', 'Part-time', 'Inactive', 'leo.m', 'password123', '2025-01-12', 'leo.jpg', 'leo_resume.pdf'),
(13, 13, 'Mona Perez', 'mona.perez@example.com', '555-0113', '1010 Cedar St, Portland, OR', 'Contract', 'Active', 'mona.p', 'password123', '2025-01-13', 'mona.jpg', 'mona_resume.pdf'),
(14, 14, 'Nathan Hall', 'nathan.hall@example.com', '555-0114', '1111 Elm St, Washington D.C.', 'Full-time', 'Active', 'nathan.h', 'password123', '2025-01-14', 'nathan.jpg', 'nathan_resume.pdf'),
(15, 15, 'Olivia Green', 'olivia.green@example.com', '555-0115', '1212 Oak St, Phoenix, AZ', 'Full-time', 'Active', 'olivia.g', 'password123', '2025-01-15', 'olivia.jpg', 'olivia_resume.pdf'),
(16, 16, 'Paul Adams', 'paul.adams@example.com', '555-0116', '1313 Birch St, San Diego, CA', 'Full-time', 'Active', 'paul.a', 'password123', '2025-01-16', 'paul.jpg', 'paul_resume.pdf'),
(17, 17, 'Quincy Carter', 'quincy.carter@example.com', '555-0117', '1414 Cedar St, Charlotte, NC', 'Part-time', 'Active', 'quincy.c', 'password123', '2025-01-17', 'quincy.jpg', 'quincy_resume.pdf'),
(18, 18, 'Rita Harris', 'rita.harris@example.com', '555-0118', '1515 Pine St, Minneapolis, MN', 'Full-time', 'Active', 'rita.h', 'password123', '2025-01-18', 'rita.jpg', 'rita_resume.pdf'),
(19, 19, 'Sam Young', 'sam.young@example.com', '555-0119', '1616 Oak St, Detroit, MI', 'Contract', 'Inactive', 'sam.y', 'password123', '2025-01-19', 'sam.jpg', 'sam_resume.pdf'),
(20, 20, 'Tina Roberts', 'tina.roberts@example.com', '555-0120', '1717 Birch St, Las Vegas, NV', 'Full-time', 'Active', 'tina.r', 'password123', '2025-01-20', 'tina.jpg', 'tina_resume.pdf'),
(21, 1, 'Ursula Moore', 'ursula.moore@example.com', '555-0121', '1818 Fir St, New York, NY', 'Full-time', 'Active', 'ursula.m', 'password123', '2025-01-21', 'ursula.jpg', 'ursula_resume.pdf'),
(22, 2, 'Victor Lee', 'victor.lee@example.com', '555-0122', '1919 Cedar St, Los Angeles, CA', 'Full-time', 'Active', 'victor.l', 'password123', '2025-01-22', 'victor.jpg', 'victor_resume.pdf'),
(23, 3, 'Wendy Green', 'wendy.green@example.com', '555-0123', '2020 Oak St, Chicago, IL', 'Full-time', 'Active', 'wendy.g', 'password123', '2025-01-23', 'wendy.jpg', 'wendy_resume.pdf'),
(24, 4, 'Xander White', 'xander.white@example.com', '555-0124', '2121 Pine St, San Francisco, CA', 'Full-time', 'Active', 'xander.w', 'password123', '2025-01-24', 'xander.jpg', 'xander_resume.pdf'),
(25, 5, 'Yvonne King', 'yvonne.king@example.com', '555-0125', '2222 Birch St, Seattle, WA', 'Part-time', 'Active', 'yvonne.k', 'password123', '2025-01-25', 'yvonne.jpg', 'yvonne_resume.pdf'),
(26, 6, 'Zane Scott', 'zane.scott@example.com', '555-0126', '2323 Fir St, Boston, MA', 'Full-time', 'Active', 'zane.s', 'password123', '2025-01-26', 'zane.jpg', 'zane_resume.pdf'),
(27, 7, 'Aaron Martinez', 'aaron.martinez@example.com', '555-0127', '2424 Cedar St, Austin, TX', 'Contract', 'Inactive', 'aaron.m', 'password123', '2025-01-27', 'aaron.jpg', 'aaron_resume.pdf'),
(28, 8, 'Bridget Lee', 'bridget.lee@example.com', '555-0128', '2525 Oak St, Denver, CO', 'Full-time', 'Active', 'bridget.l', 'password123', '2025-01-28', 'bridget.jpg', 'bridget_resume.pdf'),
(29, 9, 'Cynthia Harris', 'cynthia.harris@example.com', '555-0129', '2626 Pine St, Miami, FL', 'Full-time', 'Active', 'cynthia.h', 'password123', '2025-01-29', 'cynthia.jpg', 'cynthia_resume.pdf'),
(30, 10, 'Daniel Thompson', 'daniel.thompson@example.com', '555-0130', '2727 Birch St, Dallas, TX', 'Full-time', 'Active', 'daniel.t', 'password123', '2025-01-30', 'daniel.jpg', 'daniel_resume.pdf'),
(31, 11, 'Eve Williams', 'eve.williams@example.com', '555-0131', '2828 Cedar St, Houston, TX', 'Contract', 'Inactive', 'eve.w', 'password123', '2025-01-31', 'eve.jpg', 'eve_resume.pdf'),
(32, 12, 'Felix Walker', 'felix.walker@example.com', '555-0132', '2929 Pine St, Atlanta, GA', 'Full-time', 'Active', 'felix.w', 'password123', '2025-02-01', 'felix.jpg', 'felix_resume.pdf'),
(33, 13, 'Gina Clark', 'gina.clark@example.com', '555-0133', '3030 Oak St, Portland, OR', 'Full-time', 'Active', 'gina.c', 'password123', '2025-02-02', 'gina.jpg', 'gina_resume.pdf'),
(34, 14, 'Hank Scott', 'hank.scott@example.com', '555-0134', '3131 Cedar St, Washington D.C.', 'Part-time', 'Active', 'hank.s', 'password123', '2025-02-03', 'hank.jpg', 'hank_resume.pdf'),
(35, 15, 'Iris King', 'iris.king@example.com', '555-0135', '3232 Birch St, Phoenix, AZ', 'Full-time', 'Active', 'iris.k', 'password123', '2025-02-04', 'iris.jpg', 'iris_resume.pdf'),
(36, 16, 'James Robinson', 'james.robinson@example.com', '555-0136', '3333 Fir St, San Diego, CA', 'Contract', 'Inactive', 'james.r', 'password123', '2025-02-05', 'james.jpg', 'james_resume.pdf'),
(37, 17, 'Kara Moore', 'kara.moore@example.com', '555-0137', '3434 Pine St, Charlotte, NC', 'Part-time', 'Active', 'kara.m', 'password123', '2025-02-06', 'kara.jpg', 'kara_resume.pdf'),
(38, 18, 'Liam Young', 'liam.young@example.com', '555-0138', '3535 Oak St, Minneapolis, MN', 'Full-time', 'Active', 'liam.y', 'password123', '2025-02-07', 'liam.jpg', 'liam_resume.pdf'),
(39, 19, 'Megan Adams', 'megan.adams@example.com', '555-0139', '3636 Birch St, Detroit, MI', 'Full-time', 'Active', 'megan.a', 'password123', '2025-02-08', 'megan.jpg', 'megan_resume.pdf'),
(40, 20, 'Nina Roberts', 'nina.roberts@example.com', '555-0140', '3737 Cedar St, Las Vegas, NV', 'Full-time', 'Active', 'nina.r', 'password123', '2025-02-09', 'nina.jpg', 'nina_resume.pdf'),
(41, 1, 'Owen Moore', 'owen.moore@example.com', '555-0141', '3838 Fir St, New York, NY', 'Full-time', 'Active', 'owen.m', 'password123', '2025-02-10', 'owen.jpg', 'owen_resume.pdf'),
(42, 2, 'Paula Davis', 'paula.davis@example.com', '555-0142', '3939 Cedar St, Los Angeles, CA', 'Full-time', 'Active', 'paula.d', 'password123', '2025-02-11', 'paula.jpg', 'paula_resume.pdf'),
(43, 3, 'Quinn Harris', 'quinn.harris@example.com', '555-0143', '4040 Pine St, Chicago, IL', 'Full-time', 'Active', 'quinn.h', 'password123', '2025-02-12', 'quinn.jpg', 'quinn_resume.pdf'),
(44, 4, 'Raymond White', 'raymond.white@example.com', '555-0144', '4141 Birch St, San Francisco, CA', 'Contract', 'Inactive', 'raymond.w', 'password123', '2025-02-13', 'raymond.jpg', 'raymond_resume.pdf'),
(45, 5, 'Sophia Martinez', 'sophia.martinez@example.com', '555-0145', '4242 Oak St, Seattle, WA', 'Part-time', 'Active', 'sophia.m', 'password123', '2025-02-14', 'sophia.jpg', 'sophia_resume.pdf'),
(46, 6, 'Troy Clark', 'troy.clark@example.com', '555-0146', '4343 Cedar St, Boston, MA', 'Full-time', 'Active', 'troy.c', 'password123', '2025-02-15', 'troy.jpg', 'troy_resume.pdf'),
(47, 7, 'Uma Smith', 'uma.smith@example.com', '555-0147', '4444 Birch St, Austin, TX', 'Full-time', 'Active', 'uma.s', 'password123', '2025-02-16', 'uma.jpg', 'uma_resume.pdf'),
(48, 8, 'Vera Scott', 'vera.scott@example.com', '555-0148', '4545 Pine St, Denver, CO', 'Contract', 'Inactive', 'vera.s', 'password123', '2025-02-17', 'vera.jpg', 'vera_resume.pdf'),
(49, 9, 'Willow Adams', 'willow.adams@example.com', '555-0149', '4646 Oak St, Miami, FL', 'Full-time', 'Active', 'willow.a', 'password123', '2025-02-18', 'willow.jpg', 'willow_resume.pdf'),
(50, 10, 'Alice Johnson', 'alice.johnson@example.com', '555-0150', '123 Maple St, New York, NY', 'Full-time', 'Active', 'alice.j', 'password123', '2025-02-19', 'alice.jpg', 'alice_resume.pdf');


-- --------------------------------------------------------

--
-- Table structure for table `login_activity`
--

CREATE TABLE `login_activity` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_activity`
--

INSERT INTO `login_activity` (`id`, `emp_id`, `activity`, `time`) VALUES
(1, 1, 'Logged in from IP 192.168.1.1', '2024-12-17 11:28:38'),
(2, 2, 'Logged in from IP 192.168.1.2', '2024-12-17 11:28:38'),
(3, 1, 'login', '2024-12-17 11:30:16'),
(4, 1, 'logout', '2024-12-17 11:36:58'),
(5, 1, 'login', '2024-12-18 06:18:56'),
(6, 1, 'logout', '2024-12-18 06:19:25'),
(7, 1, 'login', '2024-12-18 09:28:46'),
(8, 1, 'logout', '2024-12-18 09:40:20'),
(9, 1, 'login', '2024-12-18 10:41:29'),
(10, 1, 'logout', '2024-12-18 10:41:35'),
(11, 1, 'login', '2024-12-18 10:41:40'),
(12, 1, 'logout', '2024-12-18 10:43:27'),
(13, 1, 'login', '2024-12-18 10:43:52'),
(14, 1, 'logout', '2024-12-18 10:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `pay_slip`
--

CREATE TABLE `pay_slip` (
  `payslip_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `total_hours_worked` decimal(10,2) NOT NULL,
  `gross_salary` decimal(10,2) NOT NULL,
  `total_deductions` decimal(10,2) NOT NULL,
  `net_salary` decimal(10,2) NOT NULL,
  `date_generated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pay_slip`
--

-- INSERT INTO `pay_slip` (`payslip_id`, `emp_id`, `month`, `year`, `total_hours_worked`, `gross_salary`, `total_deductions`, `net_salary`, `date_generated`) VALUES
-- (1, 1, 12, 2024, 160.00, 5000.00, 500.00, 4500.00, '2024-12-17 11:28:39'),
-- (2, 2, 12, 2024, 150.00, 3000.00, 300.00, 2700.00, '2024-12-17 11:28:39');

INSERT INTO `pay_slip` (`payslip_id`, `emp_id`, `month`, `year`, `total_hours_worked`, `gross_salary`, `total_deductions`, `net_salary`, `date_generated`) VALUES
(1, 1, '12', 2025, 160, 5000, 500, 4500, '2025-01-31'),
(2, 2, '12', 2025, 170, 5200, 450, 4750, '2025-01-31'),
(3, 3, '12', 2025, 80, 3000, 300, 2700, '2025-01-31'),
(4, 4, '12', 2025, 160, 6000, 600, 5400, '2025-01-31'),
(5, 5, '12', 2025, 170, 5500, 550, 4950, '2025-01-31'),
(6, 6, '12', 2025, 120, 4000, 400, 3600, '2025-01-31'),
(7, 7, '12', 2025, 160, 4500, 450, 4050, '2025-01-31'),
(8, 8, '12', 2025, 120, 3500, 350, 3150, '2025-01-31'),
(9, 9, '12', 2025, 160, 4800, 480, 4320, '2025-01-31'),
(10, 10, '12', 2025, 170, 5700, 570, 5130, '2025-01-31'),
(11, 11, '12', 2025, 160, 5000, 500, 4500, '2025-01-31'),
(12, 12, '12', 2025, 80, 2500, 250, 2250, '2025-01-31'),
(13, 13, '12', 2025, 140, 4700, 470, 4230, '2025-01-31'),
(14, 14, '12', 2025, 160, 5300, 530, 4770, '2025-01-31'),
(15, 15, '12', 2025, 170, 5600, 560, 5040, '2025-01-31'),
(16, 16, '12', 2025, 160, 5000, 500, 4500, '2025-01-31'),
(17, 17, '12', 2025, 140, 4600, 460, 4140, '2025-01-31'),
(18, 18, '12', 2025, 160, 4900, 490, 4410, '2025-01-31'),
(19, 19, '12', 2025, 80, 3200, 320, 2880, '2025-01-31'),
(20, 20, '12', 2025, 160, 4800, 480, 4320, '2025-01-31'),
(21, 21, '12', 2025, 160, 5300, 530, 4770, '2025-01-31'),
(22, 22, '12', 2025, 170, 5400, 540, 4860, '2025-01-31'),
(23, 23, '12', 2025, 160, 4600, 460, 4140, '2025-01-31'),
(24, 24, '12', 2025, 160, 5600, 560, 5040, '2025-01-31'),
(25, 25, '12', 2025, 150, 4700, 470, 4230, '2025-01-31'),
(26, 26, '12', 2025, 160, 5100, 510, 4590, '2025-01-31'),
(27, 27, '12', 2025, 120, 3300, 330, 2970, '2025-01-31'),
(28, 28, '12', 2025, 140, 4200, 420, 3780, '2025-01-31'),
(29, 29, '12', 2025, 160, 4900, 490, 4410, '2025-01-31'),
(30, 30, '12', 2025, 170, 5500, 550, 4950, '2025-01-31'),
(31, 31, '12', 2025, 160, 5000, 500, 4500, '2025-01-31'),
(32, 32, '12', 2025, 80, 2500, 250, 2250, '2025-01-31'),
(33, 33, '12', 2025, 120, 3800, 380, 3420, '2025-01-31'),
(34, 34, '12', 2025, 160, 5200, 520, 4680, '2025-01-31'),
(35, 35, '12', 2025, 170, 5400, 540, 4860, '2025-01-31'),
(36, 36, '12', 2025, 160, 4800, 480, 4320, '2025-01-31'),
(37, 37, '12', 2025, 140, 4700, 470, 4230, '2025-01-31'),
(38, 38, '12', 2025, 160, 5000, 500, 4500, '2025-01-31'),
(39, 39, '12', 2025, 80, 2700, 270, 2430, '2025-01-31'),
(40, 40, '12', 2025, 160, 5300, 530, 4770, '2025-01-31'),
(41, 41, '12', 2025, 160, 5400, 540, 4860, '2025-01-31'),
(42, 42, '12', 2025, 170, 5500, 550, 4950, '2025-01-31'),
(43, 43, '12', 2025, 160, 4600, 460, 4140, '2025-01-31'),
(44, 44, '12', 2025, 160, 5700, 570, 5130, '2025-01-31'),
(45, 45, '12', 2025, 150, 4500, 450, 4050, '2025-01-31'),
(46, 46, '12', 2025, 160, 4900, 490, 4410, '2025-01-31'),
(47, 47, '12', 2025, 160, 4800, 480, 4320, '2025-01-31'),
(48, 48, '12', 2025, 120, 3300, 330, 2970, '2025-01-31'),
(49, 49, '12', 2025, 160, 5000, 500, 4500, '2025-01-31'),
(50, 50, '12', 2025, 160, 5500, 550, 4950, '2025-01-31');


-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `monthly` decimal(10,2) NOT NULL,
  `daily` decimal(10,2) NOT NULL,
  `hourly_rate` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

-- INSERT INTO `salary` (`salary_id`, `emp_id`, `monthly`, `daily`, `hourly_rate`, `created_at`) VALUES
-- (1, 1, 5000.00, 200.00, 25.00, '2024-12-17 16:58:37'),
-- (2, 2, 3000.00, 150.00, 20.00, '2024-12-17 16:58:37');

INSERT INTO `salary` (`salary_id`, `emp_id`, `monthly`, `daily`, `hourly_rate`, `created_at`) VALUES
(1, 1, 5000, 166.67, 31.25, '2025-01-01'),
(2, 2, 5200, 173.33, 30.59, '2025-01-01'),
(3, 3, 3000, 100.00, 18.75, '2025-01-01'),
(4, 4, 6000, 200.00, 37.50, '2025-01-01'),
(5, 5, 5500, 183.33, 34.38, '2025-01-01'),
(6, 6, 4000, 133.33, 25.00, '2025-01-01'),
(7, 7, 4500, 150.00, 28.13, '2025-01-01'),
(8, 8, 3500, 116.67, 21.88, '2025-01-01'),
(9, 9, 4800, 160.00, 30.00, '2025-01-01'),
(10, 10, 5700, 190.00, 35.63, '2025-01-01'),
(11, 11, 5000, 166.67, 31.25, '2025-01-01'),
(12, 12, 2500, 83.33, 15.63, '2025-01-01'),
(13, 13, 4700, 156.67, 29.38, '2025-01-01'),
(14, 14, 5300, 176.67, 33.13, '2025-01-01'),
(15, 15, 5600, 186.67, 35.00, '2025-01-01'),
(16, 16, 5000, 166.67, 31.25, '2025-01-01'),
(17, 17, 4600, 153.33, 28.75, '2025-01-01'),
(18, 18, 4900, 163.33, 30.63, '2025-01-01'),
(19, 19, 3200, 106.67, 20.00, '2025-01-01'),
(20, 20, 4800, 160.00, 30.00, '2025-01-01'),
(21, 21, 5300, 176.67, 33.13, '2025-01-01'),
(22, 22, 5400, 180.00, 33.75, '2025-01-01'),
(23, 23, 4600, 153.33, 28.75, '2025-01-01'),
(24, 24, 5600, 186.67, 35.00, '2025-01-01'),
(25, 25, 4700, 156.67, 29.38, '2025-01-01'),
(26, 26, 5100, 170.00, 31.88, '2025-01-01'),
(27, 27, 3300, 110.00, 20.63, '2025-01-01'),
(28, 28, 4200, 140.00, 26.25, '2025-01-01'),
(29, 29, 4900, 163.33, 30.63, '2025-01-01'),
(30, 30, 5500, 183.33, 34.38, '2025-01-01'),
(31, 31, 5000, 166.67, 31.25, '2025-01-01'),
(32, 32, 2500, 83.33, 15.63, '2025-01-01'),
(33, 33, 3800, 126.67, 23.75, '2025-01-01'),
(34, 34, 5200, 173.33, 32.50, '2025-01-01'),
(35, 35, 5400, 180.00, 33.75, '2025-01-01'),
(36, 36, 4800, 160.00, 30.00, '2025-01-01'),
(37, 37, 4700, 156.67, 29.38, '2025-01-01'),
(38, 38, 5000, 166.67, 31.25, '2025-01-01'),
(39, 39, 2700, 90.00, 16.88, '2025-01-01'),
(40, 40, 5300, 176.67, 33.13, '2025-01-01'),
(41, 41, 5400, 180.00, 33.75, '2025-01-01'),
(42, 42, 5500, 183.33, 34.38, '2025-01-01'),
(43, 43, 4600, 153.33, 28.75, '2025-01-01'),
(44, 44, 5700, 190.00, 35.63, '2025-01-01'),
(45, 45, 4500, 150.00, 28.13, '2025-01-01'),
(46, 46, 4900, 163.33, 30.63, '2025-01-01'),
(47, 47, 4800, 160.00, 30.00, '2025-01-01'),
(48, 48, 3300, 110.00, 20.63, '2025-01-01'),
(49, 49, 5000, 166.67, 31.25, '2025-01-01'),
(50, 50, 5500, 183.33, 34.38, '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `screenshots`
--

CREATE TABLE `screenshots` (
  `screenshot_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screenshots`
--

INSERT INTO `screenshots` (`screenshot_id`, `emp_id`, `image`, `created_at`) VALUES
(1, 1, 'screenshot1.jpg', '2024-12-17 11:28:39'),
(2, 2, 'screenshot2.jpg', '2024-12-17 11:28:39'),
(3, 1, 'screenshots/676161c1a068f.png', '2024-12-17 11:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `task_description` text NOT NULL,
  `task_status` enum('pending','in_progress','completed') NOT NULL,
  `task_deadline` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

-- INSERT INTO `tasks` (`task_id`, `emp_id`, `task_description`, `task_status`, `task_deadline`, `created_at`) VALUES
-- (1, 1, 'Complete the monthly report', 'completed', '2024-12-05', '2024-12-17 11:28:38'),
-- (2, 2, 'Fix bugs in the system', 'in_progress', '2024-12-10', '2024-12-17 11:28:38'),
-- (4, 1, 'Complete the annual report', 'in_progress', '2025-01-02', '2024-12-17 11:35:10');

INSERT INTO `tasks` (`task_id`, `emp_id`, `task_description`, `task_status`, `task_deadline`, `created_at`) VALUES
(1, 1, 'Complete monthly financial report', 'Completed', '2025-01-28', '2025-01-01'),
(2, 2, 'Develop new marketing strategy for Q1', 'In Progress', '2025-01-20', '2025-01-02'),
(3, 3, 'Assist with customer service queries', 'Pending', '2025-01-25', '2025-01-03'),
(4, 4, 'Prepare client presentations for next meeting', 'Completed', '2025-01-15', '2025-01-04'),
(5, 5, 'Conduct market analysis for product launch', 'In Progress', '2025-01-18', '2025-01-05'),
(6, 6, 'Update website with new content', 'Pending', '2025-01-20', '2025-01-06'),
(7, 7, 'Prepare monthly inventory report', 'Completed', '2025-01-30', '2025-01-07'),
(8, 8, 'Assist in customer complaint resolution', 'In Progress', '2025-01-19', '2025-01-08'),
(9, 9, 'Develop internal training materials', 'Pending', '2025-01-23', '2025-01-09'),
(10, 10, 'Update software systems for clients', 'In Progress', '2025-01-22', '2025-01-10'),
(11, 11, 'Write quarterly business review', 'Pending', '2025-01-25', '2025-01-11'),
(12, 12, 'Organize team meeting for project updates', 'Completed', '2025-01-15', '2025-01-12'),
(13, 13, 'Handle employee onboarding tasks', 'In Progress', '2025-01-19', '2025-01-13'),
(14, 14, 'Coordinate team collaboration efforts', 'Pending', '2025-01-21', '2025-01-14'),
(15, 15, 'Develop new features for the company app', 'Completed', '2025-01-25', '2025-01-15'),
(16, 16, 'Prepare tax documentation for filing', 'Pending', '2025-01-28', '2025-01-16'),
(17, 17, 'Perform system audits and checks', 'Completed', '2025-01-20', '2025-01-17'),
(18, 18, 'Organize company event for Q1', 'In Progress', '2025-01-22', '2025-01-18'),
(19, 19, 'Complete client project proposal', 'Pending', '2025-01-23', '2025-01-19'),
(20, 20, 'Update project management software with new data', 'In Progress', '2025-01-21', '2025-01-20'),
(21, 21, 'Prepare monthly performance reports', 'Completed', '2025-01-25', '2025-01-21'),
(22, 22, 'Plan new marketing campaigns for product launch', 'Pending', '2025-01-30', '2025-01-22'),
(23, 23, 'Update client database with new information', 'In Progress', '2025-01-25', '2025-01-23'),
(24, 24, 'Develop new design proposals for product packaging', 'Completed', '2025-01-22', '2025-01-24'),
(25, 25, 'Monitor competitors and market trends', 'In Progress', '2025-01-19', '2025-01-25'),
(26, 26, 'Assist in system integration tasks', 'Pending', '2025-01-20', '2025-01-26'),
(27, 27, 'Review monthly sales performance', 'In Progress', '2025-01-21', '2025-01-27'),
(28, 28, 'Conduct employee performance reviews', 'Pending', '2025-01-24', '2025-01-28'),
(29, 29, 'Design new employee training program', 'Completed', '2025-01-25', '2025-01-29'),
(30, 30, 'Update company website with latest news', 'Pending', '2025-01-22', '2025-01-30'),
(31, 31, 'Prepare team for upcoming project deadlines', 'In Progress', '2025-01-18', '2025-01-31'),
(32, 32, 'Coordinate team for project development', 'Completed', '2025-01-28', '2025-02-01'),
(33, 33, 'Handle customer feedback and suggestions', 'Pending', '2025-01-23', '2025-02-02'),
(34, 34, 'Perform database optimization tasks', 'Completed', '2025-01-25', '2025-02-03'),
(35, 35, 'Develop a new company app feature', 'In Progress', '2025-01-19', '2025-02-04'),
(36, 36, 'Update software patch for security', 'Completed', '2025-01-21', '2025-02-05'),
(37, 37, 'Conduct customer service training for team', 'In Progress', '2025-01-20', '2025-02-06'),
(38, 38, 'Complete compliance audit report', 'Pending', '2025-01-23', '2025-02-07'),
(39, 39, 'Assist in product quality control', 'Completed', '2025-01-25', '2025-02-08'),
(40, 40, 'Manage logistics for new product shipment', 'Pending', '2025-01-27', '2025-02-09'),
(41, 41, 'Conduct marketing research for new campaigns', 'In Progress', '2025-01-22', '2025-02-10'),
(42, 42, 'Prepare new client contracts and agreements', 'Completed', '2025-01-30', '2025-02-11'),
(43, 43, 'Update inventory management system', 'Pending', '2025-01-25', '2025-02-12'),
(44, 44, 'Prepare weekly task performance reviews', 'In Progress', '2025-01-20', '2025-02-13'),
(45, 45, 'Create marketing presentation for new launch', 'Completed', '2025-01-27', '2025-02-14'),
(46, 46, 'Test new product features', 'In Progress', '2025-01-18', '2025-02-15'),
(47, 47, 'Prepare content for new training module', 'Completed', '2025-01-19', '2025-02-16'),
(48, 48, 'Perform data analysis for sales projections', 'Pending', '2025-01-22', '2025-02-17'),
(49, 49, 'Create project timeline for upcoming tasks', 'In Progress', '2025-01-24', '2025-02-18'),
(50, 50, 'Finalize budget proposal for next quarter', 'Completed', '2025-01-30', '2025-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `work_log`
--

CREATE TABLE `work_log` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `hours_worked` decimal(5,2) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_log`
--

INSERT INTO `work_log` (`id`, `emp_id`, `date`, `check_in_time`, `check_out_time`, `hours_worked`, `remarks`) VALUES
(1, 1, '2024-12-01', '09:00:00', '17:00:00', 8.00, 'Completed tasks assigned'),
(2, 2, '2024-12-01', '09:30:00', '16:30:00', 7.50, 'Worked on project X'),
(3, 1, '2024-12-17', '00:00:00', '00:00:00', 0.00, 'dummy record'),
(5, 1, '2024-12-18', '17:03:54', '15:10:04', 22.10, '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dpt_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `dpt_id` (`dpt_id`);

--
-- Indexes for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `pay_slip`
--
ALTER TABLE `pay_slip`
  ADD PRIMARY KEY (`payslip_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `screenshots`
--
ALTER TABLE `screenshots`
  ADD PRIMARY KEY (`screenshot_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `work_log`
--
ALTER TABLE `work_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_activity`
--
ALTER TABLE `login_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pay_slip`
--
ALTER TABLE `pay_slip`
  MODIFY `payslip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `screenshots`
--
ALTER TABLE `screenshots`
  MODIFY `screenshot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `work_log`
--
ALTER TABLE `work_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `employee_details_ibfk_1` FOREIGN KEY (`dpt_id`) REFERENCES `department` (`dpt_id`);

--
-- Constraints for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD CONSTRAINT `login_activity_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_details` (`emp_id`);

--
-- Constraints for table `pay_slip`
--
ALTER TABLE `pay_slip`
  ADD CONSTRAINT `pay_slip_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_details` (`emp_id`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_details` (`emp_id`);

--
-- Constraints for table `screenshots`
--
ALTER TABLE `screenshots`
  ADD CONSTRAINT `screenshots_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_details` (`emp_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_details` (`emp_id`);

--
-- Constraints for table `work_log`
--
ALTER TABLE `work_log`
  ADD CONSTRAINT `work_log_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee_details` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
