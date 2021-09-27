-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2021 at 02:05 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`) VALUES
(1, 'vehicle', 'Cars and truck and bus '),
(2, 'electronic', 'Phone and computer etc..'),
(3, 'real estate', 'House and lands'),
(4, 'hardware', 'tools, machinery, and other durable equipment');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_ID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` smallint(6) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `Name`, `Description`, `Price`, `Date`, `Image`, `Status`, `Cat_ID`, `images`) VALUES
(3, 'Golf 6', '2012, 120k miles, clean title with new tires \r\n2012, 120k clean title.', '$3200', '2021-08-08', '', 2, 1, '260396_download.jpg'),
(4, 'Samsung s6', 'a good Phone', '$200', '2021-08-08', '', 3, 2, '608642_s6.jpg'),
(5, 'iPhone XS Max', 'new iPhone, 128Gb Gold color', '$430', '2021-08-09', '', 2, 2, '738056_xs-max.jpg'),
(6, 'House in new jersey', '130m² with garden and garage', '$212000', '2021-08-11', '', 3, 3, '936210_house.jpg'),
(7, 'intel i5 9200k', 'used for 2 month only ', '$280', '2021-08-11', '', 2, 4, '950340_intel.jpg'),
(8, 'Apple Smart watch series 5', '4g LTE and GPS', '$376', '2021-08-13', '', 1, 2, '650652_watck.jpg'),
(9, 'apple macbook pro', 'good computer ', '880', '2021-08-13', '', 1, 2, '788001_city.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `GroupID`, `Email`, `FullName`, `Date`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'admin@gamil.com', 'admin', '2021-07-26'),
(10, 'user123', '12dea96fec20593566ab75692c9949596833adc9', 1, 'user@user.com', 'user', '2021-07-29'),
(31, 'nexxt', '2503d77351dda55e43659163d2e0b09e566661e1', 0, 'nexxt@gmlail.cc', 'nexxt', '2021-08-05'),
(33, 'best123', 'c5f5e4d75252d9788ce20300d00023fa1ccd4d19', 0, 'best123@gamil.com', 'best123', '2021-08-06'),
(34, 'joe25', '16a9a54ddf4259952e3c118c763138e83693d7fd', 0, 'joaesef@hotmail.com', 'joe hatab', '2021-08-11'),
(35, 'imad', '97149319688178e090e20dd126d11fce2b3c9837', 0, 'imad@gmail.com', 'imad', '2021-08-12'),
(36, 'testreg255', '04dd5c94cbe1f72928ae57c70d61099489dfbddc', 0, 'testreg852@gmail.com', 'testreg8', '2021-08-12'),
(37, 'testrss', 'c0782ccf42a537ba76e556b3cd2918faa5e9c44e', 0, 'testrss@gmail.com', 'testresss', '2021-08-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_ID`),
  ADD KEY `itemId` (`Item_ID`),
  ADD KEY `userId` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `category_x` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `itemId` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userId` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `category_x` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
