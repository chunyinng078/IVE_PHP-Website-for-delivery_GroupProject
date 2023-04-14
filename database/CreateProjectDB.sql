-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 25, 2021 at 10:21 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- DROP existing database
DROP DATABASE IF EXISTS `ProjectDB`;

--
-- Database: `ProjectDB`
--
CREATE DATABASE IF NOT EXISTS `ProjectDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- select `ProjectDB` as the default database
USE `ProjectDB`;

START TRANSACTION;
SET time_zone = "+00:00";
-- --------------------------------------------------------

-- The AUTO_INCREMENT attribute can be used to generate a unique identity for new rows

--
-- Table structure for table `AirWaybill`
--
DROP TABLE IF EXISTS `airwaybill`;
CREATE TABLE `airwaybill` (
  `airWaybillNo` int(50) NOT NULL,
  `customerEmail` varchar(50) NOT NULL,
  `staffID` varchar(15) DEFAULT NULL,
  `locationID` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `receiverName` varchar(100) NOT NULL,
  `receiverPhoneNumber` varchar(100) NOT NULL,
  `receiverAddress` varchar(255) NOT NULL,
  `weight` float DEFAULT NULL,
  `totalPrice` decimal(10,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `airwaybill`
--

INSERT INTO `airwaybill` (`airWaybillNo`, `customerEmail`, `staffID`, `locationID`, `date`, `receiverName`, `receiverPhoneNumber`, `receiverAddress`, `weight`, `totalPrice`) VALUES
(1, 'jacky@gmail.com', 'Mary112', 1, '2021-07-16 09:16:02', 'Peter', '23456454', 'Flat 8, Chates Farm Court, John Street, Brighton', 25.5, '1880.0'),
(2, 'marcus@gmail.com', 'Mary112', 2, '2021-07-16 09:46:25', 'John', '76548273', 'Flat 1, Trevena Court, Avenue Road, London', 5, '1460.0');

-- --------------------------------------------------------

--
-- 資料表結構 `airwaybilldeliveryrecord`
--

DROP TABLE IF EXISTS `airwaybilldeliveryrecord`;
CREATE TABLE `airwaybilldeliveryrecord` (
  `airWaybillDeliveryRecordID` int(11) NOT NULL,
  `airWaybillNo` int(50) NOT NULL,
  `deliveryStatusID` int(2) NOT NULL,
  `recordDateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `currentLocation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `airwaybilldeliveryrecord`
--

INSERT INTO `airwaybilldeliveryrecord` (`airWaybillDeliveryRecordID`, `airWaybillNo`, `deliveryStatusID`, `recordDateTime`, `currentLocation`) VALUES
(1, 1, 1, '2021-03-22 20:36:00', NULL),
(2, 2, 1, '2021-03-25 21:37:00', NULL),
(3, 1, 2, '2021-03-23 23:36:00', NULL),
(4, 1, 3, '2021-03-24 09:36:00', 'Hong Kong'),
(5, 1, 3, '2021-03-25 09:36:00', 'Shenzhen'),
(6, 1, 3, '2021-03-26 09:36:00', 'Shanghai'),
(7, 1, 4, '2021-03-27 09:36:00', 'Shanghai'),
(8, 1, 5, '2021-03-28 09:36:00', 'Shanghai');

-- --------------------------------------------------------

--
-- 資料表結構 `chargetable`
--

DROP TABLE IF EXISTS `chargetable`;
CREATE TABLE `chargetable` (
  `chargeID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL,
  `weight` float NOT NULL,
  `rate` decimal(10,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `chargetable`
--

INSERT INTO `chargetable` (`chargeID`, `locationID`, `weight`, `rate`) VALUES
(1, 1, 1, '150.0'),
(2, 1, 2, '298.0'),
(3, 1, 3, '440.0'),
(4, 1, 4, '586.0'),
(5, 1, 5, '731.0'),
(6, 1, 6, '876.0'),
(7, 1, 7, '1021.0'),
(8, 1, 8, '1166.0'),
(9, 1, 9, '1311.0'),
(10, 1, 10, '1456.0'),
(11, 2, 1, '300.0'),
(12, 2, 2, '590.0'),
(13, 2, 3, '880.0'),
(14, 2, 4, '1170.0'),
(15, 2, 5, '1460.0'),
(16, 2, 6, '1750.0'),
(17, 2, 7, '2040.0'),
(18, 2, 8, '2330.0'),
(19, 2, 9, '2620.0'),
(20, 2, 10, '2910.0'),
(21, 3, 1, '549.0'),
(22, 3, 2, '1096.0'),
(23, 3, 3, '1643.0'),
(24, 3, 4, '2190.0'),
(25, 3, 5, '2737.0'),
(26, 3, 6, '3284.0'),
(27, 3, 7, '3831.0'),
(28, 3, 8, '4378.0'),
(29, 3, 9, '4925.0'),
(30, 3, 10, '5472.0');

-- --------------------------------------------------------

--
-- 資料表結構 `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customerEmail` varchar(50) NOT NULL,
  `customerName` varchar(100) NOT NULL,
  `customerPassword` varchar(40) NOT NULL,
  `accountCreationDate` date NOT NULL,
  `phoneNumber` varchar(8) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `customer`
--

INSERT INTO `customer` (`customerEmail`, `customerName`, `customerPassword`, `accountCreationDate`, `phoneNumber`, `address`) VALUES
('aa@aa.com', 'aa', 'aa', '2017-07-15', '11111111', 'aa'),
('aa', 'aa', 'aa', '2017-07-15', '11111111', 'aa'),
('Edwin@gmail.com', 'Edwin', 'Edwin112', '2021-07-15', '12345678', 'Hong Kong'),
('jacky@gmail.com', 'jacky', '123', '2017-07-15', '23382338', 'Hong Kong Yau Tsim Mong District Omega Plaza Yau Ma Tei '),
('marcus@gmail.com', 'Marcus Cheung', 'a1234', '2021-03-21', '57685876', '2/F 7 Carmel Village Street HO MAN TIN KOWLOON');

-- --------------------------------------------------------

--
-- 資料表結構 `deliverystatus`
--

DROP TABLE IF EXISTS `deliverystatus`;
CREATE TABLE `deliverystatus` (
  `deliveryStatusID` int(2) NOT NULL,
  `deliveryStatusName` varchar(255) NOT NULL,
  `deliveryStatusDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `deliverystatus`
--

INSERT INTO `deliverystatus` (`deliveryStatusID`, `deliveryStatusName`, `deliveryStatusDescription`) VALUES
(1, 'Waiting for Confirmation', 'Waiting staff to verify the information'),
(2, 'Confirmed', 'Order is confirmed'),
(3, 'In Transit', 'Means that the parcel is on the way to the destination'),
(4, 'Delivering', 'Means that the deliveryman is sending the parcel to the receiver'),
(5, 'Completed', 'Means that the receiver received the parcel');

-- --------------------------------------------------------

--
-- 資料表結構 `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `locationID` int(11) NOT NULL,
  `locationName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `location`
--

INSERT INTO `location` (`locationID`, `locationName`) VALUES
(1, 'China Shanghai'),
(2, 'Japan'),
(3, 'Australia');

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `staffID` varchar(15) NOT NULL,
  `staffName` varchar(255) NOT NULL,
  `staffPassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `staff`
--

INSERT INTO `staff` (`staffID`, `staffName`, `staffPassword`) VALUES
('Mary112', 'Mary Chau', 'mary999');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `airwaybill`
--
ALTER TABLE `airwaybill`
  ADD PRIMARY KEY (`airWaybillNo`),
  ADD KEY `FKAirWaybill444828` (`customerEmail`),
  ADD KEY `FKAirWaybill454482` (`staffID`),
  ADD KEY `FKAirWaybill118245` (`locationID`);

--
-- 資料表索引 `airwaybilldeliveryrecord`
--
ALTER TABLE `airwaybilldeliveryrecord`
  ADD PRIMARY KEY (`airWaybillDeliveryRecordID`),
  ADD KEY `FKAirWaybill437304` (`deliveryStatusID`),
  ADD KEY `FKAirWaybill115654` (`airWaybillNo`);

--
-- 資料表索引 `chargetable`
--
ALTER TABLE `chargetable`
  ADD PRIMARY KEY (`chargeID`),
  ADD KEY `FKChargeTabl634318` (`locationID`);

--
-- 資料表索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerEmail`);

--
-- 資料表索引 `deliverystatus`
--
ALTER TABLE `deliverystatus`
  ADD PRIMARY KEY (`deliveryStatusID`);

--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`locationID`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `airwaybill`
--
ALTER TABLE `airwaybill`
  MODIFY `airWaybillNo` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `airwaybilldeliveryrecord`
--
ALTER TABLE `airwaybilldeliveryrecord`
  MODIFY `airWaybillDeliveryRecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `chargetable`
--
ALTER TABLE `chargetable`
  MODIFY `chargeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `deliverystatus`
--
ALTER TABLE `deliverystatus`
  MODIFY `deliveryStatusID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `airwaybill`
--
ALTER TABLE `airwaybill`
  ADD CONSTRAINT `FKAirWaybill118245` FOREIGN KEY (`locationID`) REFERENCES `location` (`locationID`),
  ADD CONSTRAINT `FKAirWaybill444828` FOREIGN KEY (`customerEmail`) REFERENCES `customer` (`customerEmail`),
  ADD CONSTRAINT `FKAirWaybill454482` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);

--
-- 資料表的限制式 `airwaybilldeliveryrecord`
--
ALTER TABLE `airwaybilldeliveryrecord`
  ADD CONSTRAINT `FKAirWaybill115654` FOREIGN KEY (`airWaybillNo`) REFERENCES `airwaybill` (`airWaybillNo`),
  ADD CONSTRAINT `FKAirWaybill437304` FOREIGN KEY (`deliveryStatusID`) REFERENCES `deliverystatus` (`deliveryStatusID`);

--
-- 資料表的限制式 `chargetable`
--
ALTER TABLE `chargetable`
  ADD CONSTRAINT `FKChargeTabl634318` FOREIGN KEY (`locationID`) REFERENCES `location` (`locationID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
