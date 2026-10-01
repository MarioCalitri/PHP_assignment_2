-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 30, 2026 at 05:01 PM
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
-- Database: `race_setup_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `profileID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `teamName` varchar(100) NOT NULL,
  `emailAddress` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setups`
--

CREATE TABLE `setups` (
  `setupID` int(11) NOT NULL,
  `trackName` varchar(50) NOT NULL,
  `tirePressureLF` varchar(50) NOT NULL,
  `tirePressureRF` varchar(50) NOT NULL,
  `tirePressureLR` varchar(50) NOT NULL,
  `tirePressureRR` varchar(50) NOT NULL,
  `raceDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setups`
--

INSERT INTO `setups` (`setupID`, `trackName`, `tirePressureLF`, `tirePressureRF`, `tirePressureLR`, `tirePressureRR`, `raceDate`) VALUES
(1, 'Flamboro Speedway', '14.5 PSI', '22.0 PSI', '14.0 PSI', '21.5 PSI', '2026-09-12'),
(2, 'Sunset Speedway', '15.0 PSI', '23.0 PSI', '14.5 PSI', '22.5 PSI', '2026-09-19'),
(3, 'Sunset Speedway', '17.0', '22.5', '14.5', '25', '2026-09-26'),
(4, 'Sunset Speedway', '17.0', '22.5', '14.5', '25', '2026-09-25'),
(5, 'Flamboro Speedway', '14.5', '22.0', '14.0', '21.5', '2026-09-12'),
(6, 'Sunset Speedway', '15.0', '23.0', '14.5', '22.5', '2026-09-19'),
(7, 'Full Throttle Speedway', '13.6', '22.8', '12.5', '25.2', '2026-09-23'),
(8, 'Peterbough Speedway', '18.1', '20', '14.5', '28', '2026-09-24'),
(9, 'Barrie Speedway', '18.1', '20', '14.5', '28', '2026-09-23'),
(10, 'Oswago Speedway', '20', '22.9', '15', '28.5', '2026-09-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profileID`),
  ADD UNIQUE KEY `email` (`emailAddress`);

--
-- Indexes for table `setups`
--
ALTER TABLE `setups`
  ADD PRIMARY KEY (`setupID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profileID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setups`
--
ALTER TABLE `setups`
  MODIFY `setupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
