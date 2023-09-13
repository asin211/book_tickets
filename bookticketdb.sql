-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 08, 2023 at 09:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookticketdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `fname`, `lname`, `email`, `password`) VALUES
(1, 'Tatum', 'Drake', 'taturm@gmail.com', ''),
(2, 'Leroy', 'Mcgee', 'leroy@gmail.com', ''),
(3, 'Katell', 'Machonald', 'katell@gmail.com', ''),
(4, 'Sarah', 'Walton', 'sarah@gmail.com', ''),
(5, 'Emery', 'West', 'west@gmail.com', ''),
(6, 'Gill', 'Conway', 'gill@gmail.com', ''),
(7, 'test', 'test', 'test@gmail.com', 'testtest');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flightcode` int(11) NOT NULL,
  `flightname` varchar(20) NOT NULL,
  `departure_location` varchar(50) NOT NULL,
  `destination_location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightcode`, `flightname`, `departure_location`, `destination_location`) VALUES
(1, 'JQ240', 'Auckland', 'Sydney'),
(2, 'MU779', 'Auckland', 'Shanghai'),
(3, 'NZ941', 'Auckland', 'Christchurch'),
(4, 'QF143', 'Wellington', 'Queenstown'),
(5, 'QF8526', 'Auckland', 'Paris'),
(6, 'SQ285', 'Auckland', 'Singapore');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticketID` int(11) NOT NULL,
  `flightcode` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `departureDate` date NOT NULL,
  `arrivalDate` date NOT NULL,
  `price` double NOT NULL,
  `seat_options` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketID`, `flightcode`, `customerID`, `departureDate`, `arrivalDate`, `price`, `seat_options`) VALUES
(1, 6, 1, '2023-06-15', '2023-06-16', 2999, 'Basic economy'),
(2, 3, 4, '2023-06-01', '2023-06-02', 1399, 'Economy Plus'),
(3, 4, 3, '2023-06-07', '2023-06-07', 99, 'Premium Plus'),
(4, 1, 6, '2023-06-14', '2023-06-14', 399, NULL),
(5, 6, 3, '2023-06-15', '2023-06-16', 2999, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flightcode`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketID`),
  ADD KEY `FK_customerID` (`customerID`),
  ADD KEY `FK_flightcode` (`flightcode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flightcode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_customerID` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`),
  ADD CONSTRAINT `FK_flightcode` FOREIGN KEY (`flightcode`) REFERENCES `flight` (`flightcode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
