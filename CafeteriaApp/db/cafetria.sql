-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2018 at 11:44 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafetria`
--

-- --------------------------------------------------------

--
-- Table structure for table `addition`
--

CREATE TABLE `addition` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Price` decimal(6,2) NOT NULL,
  `CategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `UserId`) VALUES
(1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `auth_provider`
--

CREATE TABLE `auth_provider` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_provider`
--

INSERT INTO `auth_provider` (`Id`, `Name`) VALUES
(1, 'Facebook'),
(2, 'Google'),
(3, 'Twitter');

-- --------------------------------------------------------

--
-- Table structure for table `cafeteria`
--

CREATE TABLE `cafeteria` (
  `Id` int(11) NOT NULL,
  `Name` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `Image` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cafeteria`
--

INSERT INTO `cafeteria` (`Id`, `Name`, `Image`) VALUES
(13, 'Vegetrian', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/Categories/vegetrian.jpg'),
(14, 'Pizza', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/Categories/Pizza.jpg'),
(15, 'Fries', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/Categories/fries.jpg'),
(16, 'ICe Cream', 'ICe Cream'),
(17, 'Cookies', 'Cookies'),
(18, 'Burger', 'Burger'),
(19, 'Drinks', 'Drinks'),
(20, 'Dessert', 'Dessert'),
(21, 'Sandwitches', 'Sandwitches');

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE `cashier` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`Id`, `UserId`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` int(11) NOT NULL,
  `Name` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `Image` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CafeteriaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Id`, `Name`, `Image`, `CafeteriaId`) VALUES
(9, 'Appetizers', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/Menus/soup-dish-appetizer.png', 13),
(10, 'Salad', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/Menus/food5.jpg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Id` int(11) NOT NULL,
  `Details` text COLLATE utf8_unicode_ci NOT NULL,
  `UserId` int(11) NOT NULL,
  `MenuItemId` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Id`, `Details`, `UserId`, `MenuItemId`, `Date`) VALUES
(1, 'sssssssssssssssss', 3, 7, '2018-04-06'),
(2, 'eeeee', 3, 7, '2018-04-06'),
(3, 'ddddddddddddd', 3, 7, '2018-04-06'),
(4, 'sssssssssssssss', 3, 7, '2018-04-06'),
(5, 'sssssssssssssss', 3, 7, '2018-04-06'),
(6, 'ccccccccccccccc', 3, 7, '2018-04-06'),
(7, 'cccccccccccccccccccc', 3, 7, '2018-04-06'),
(8, 'ffffffffffff', 3, 7, '2018-04-06'),
(9, 'ffffffffffffffffffffffffff', 3, 8, '2018-04-06'),
(10, 'dvdvdvdv', 3, 8, '2018-04-06'),
(11, 'خنخنخ', 3, 8, '2018-04-06'),
(12, 'ddddddddddddddd', 3, 8, '2018-04-06'),
(13, 'dddddddddddd', 3, 8, '2018-04-06'),
(14, 'aaaaaaaaaaaa', 3, 8, '2018-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Id` int(11) NOT NULL,
  `Credit` decimal(6,2) NOT NULL,
  `UserId` int(11) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `GenderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Id`, `Credit`, `UserId`, `DateOfBirth`, `GenderId`) VALUES
(4, '45.00', 3, '1994-12-20', 1),
(5, '0.00', 4, '2017-08-07', 1),
(6, '0.00', 8, '2017-09-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `favoriteitem`
--

CREATE TABLE `favoriteitem` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `MenuItemId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `favoriteitem`
--

INSERT INTO `favoriteitem` (`Id`, `UserId`, `MenuItemId`) VALUES
(8, 9, 8),
(13, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `Id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`Id`, `Name`, `Price`) VALUES
(1, 'Delivey', '1.00'),
(2, 'Shipping', '1.50'),
(3, 'Tax', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`Id`, `Name`) VALUES
(1, 'English'),
(2, 'French'),
(3, 'German');

-- --------------------------------------------------------

--
-- Table structure for table `locale`
--

CREATE TABLE `locale` (
  `Id` int(11) NOT NULL,
  `Name` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `locale`
--

INSERT INTO `locale` (`Id`, `Name`) VALUES
(1, 'en_US');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `UserId` int(11) NOT NULL,
  `Lat` decimal(8,4) NOT NULL DEFAULT '0.0000',
  `Lng` decimal(8,4) NOT NULL DEFAULT '0.0000',
  `Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`UserId`, `Lat`, `Lng`, `Id`) VALUES
(3, '30.0451', '31.3737', 45),
(3, '30.0382', '31.3158', 47),
(3, '30.0085', '31.3186', 48),
(3, '30.0204', '31.3268', 49),
(3, '30.0204', '31.2788', 50),
(3, '30.0477', '31.3351', 51),
(3, '30.0144', '31.2815', 52),
(3, '30.0560', '31.3515', 53),
(3, '29.9882', '31.3831', 54),
(3, '30.0190', '31.3220', 55),
(3, '29.9786', '31.3083', 56),
(3, '29.9692', '31.3687', 57),
(3, '29.9704', '31.3632', 58),
(3, '29.9859', '31.3824', 59),
(3, '30.0450', '31.3736', 60),
(3, '29.9835', '31.3783', 61),
(3, '30.0450', '31.3737', 63),
(3, '29.9835', '31.3797', 64),
(3, '30.0013', '31.3900', 66),
(3, '29.9871', '31.3873', 68),
(3, '29.9835', '31.3763', 70),
(3, '29.9859', '31.3900', 72),
(3, '29.9787', '31.3845', 73),
(3, '29.9847', '31.3879', 74),
(3, '29.9953', '31.3934', 75),
(3, '29.9739', '31.3660', 76),
(3, '30.2869', '31.7908', 77),
(3, '30.7326', '31.6726', 78),
(3, '30.5474', '31.6854', 79),
(3, '29.4398', '31.5315', 80);

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

CREATE TABLE `menuitem` (
  `Id` int(11) NOT NULL,
  `Name` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `Image` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Price` decimal(6,2) NOT NULL,
  `Description` text COLLATE utf8_unicode_ci,
  `ReadyInMins` int(11) NOT NULL DEFAULT '0',
  `Visible` varchar(100) NOT NULL DEFAULT '1',
  `CategoryId` int(11) NOT NULL,
  `Rating` decimal(10,0) NOT NULL DEFAULT '0',
  `RatingUsersNo` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menuitem`
--

INSERT INTO `menuitem` (`Id`, `Name`, `Image`, `Price`, `Description`, `ReadyInMins`, `Visible`, `CategoryId`, `Rating`, `RatingUsersNo`) VALUES
(7, 'Garlic Salad', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/menu-items/page2_img9.jpg', '34.00', 'delicious', 0, 1, 9, '4', 4),
(8, 'Grilled Botatos', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/menu-items/grilled-sweet-potatoes-horiz-a-1600.jpg', '15.00', '7lw', 0, 1, 9, '4', 4);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `Id` int(11) NOT NULL,
  `Content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`Id`, `Content`) VALUES
(1, 'Sorry, some items have been removed from the cart as they\'re not availabe now !'),
(2, 'some prices were updated !,please take a look on the order before checking it out.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `name`) VALUES
(1, '1_addFeesToOrderTable.php'),
(2, '2_addDeliveryFeeToOrder.php'),
(3, '3_makeDefaultDeliveryFeeAndTaxFeeZero.php');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `MessageId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `DeliveryTime` datetime NOT NULL,
  `Total` decimal(6,2) NOT NULL,
  `OrderStatus` varchar(100) NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `Type` varchar(100) NOT NULL DEFAULT '0',
  `Visible` varchar(100) NOT NULL DEFAULT '1',
  `TaxFee` double DEFAULT '0',
  `DeliveryFee` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`Id`, `UserId`, `DeliveryTime`, `Total`, `OrderStatus`, `PaymentMethod`, `Type`, `Visible`, `TaxFee`, `DeliveryFee`) VALUES
(171, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'Delivery', 'Yes', NULL, NULL),
(172, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'TakeAway', 'Yes', NULL, NULL),
(173, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'Delivery', 'Yes', NULL, NULL),
(174, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'Delivery', 'Yes', NULL, NULL),
(175, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'Delivery', 'Yes', NULL, NULL),
(176, 4, '2018-04-01 00:00:00', '0.00', 'Close', 'Cash', 'TakeAway', 'No', NULL, NULL),
(177, 3, '2018-04-01 00:00:00', '2.00', 'Close', 'Cash', 'TakeAway', 'Yes', NULL, NULL),
(178, 3, '2018-04-01 00:00:00', '2.00', 'Close', 'Cash', 'TakeAway', 'Yes', NULL, NULL),
(179, 3, '2018-04-01 00:00:00', '2.00', 'Close', 'Cash', 'TakeAway', 'Yes', NULL, NULL),
(180, 3, '2018-04-01 00:00:00', '2.00', 'Close', 'Cash', 'TakeAway', 'Yes', NULL, NULL),
(181, 3, '2018-04-01 00:00:00', '2.00', 'Close', 'Cash', 'TakeAway', 'Yes', NULL, NULL),
(182, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'Delivery', 'Yes', NULL, NULL),
(183, 3, '2018-04-01 00:00:00', '4.50', 'Close', 'Cash', 'Delivery', 'Yes', NULL, NULL),
(184, 9, '2018-04-01 00:00:00', '4.00', 'Open', 'PayPal', 'Delivery', 'Yes', NULL, NULL),
(196, 4, '2018-04-06 08:04:00', '0.00', 'Open', 'PayPal', 'TakeAway', 'Yes', NULL, NULL),
(197, 3, '2018-04-08 08:04:00', '51.00', 'Open', 'PayPal', 'TakeAway', 'Yes', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `Id` int(11) NOT NULL,
  `Quantity` int(10) UNSIGNED NOT NULL,
  `OrderId` int(11) NOT NULL,
  `MenuItemId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`Id`, `Quantity`, `OrderId`, `MenuItemId`) VALUES
(170, 1, 197, 7),
(171, 1, 197, 8);

--
-- Triggers `orderitem`
--
DELIMITER $$
CREATE TRIGGER `OrderTotalAfterDelete` AFTER DELETE ON `orderitem` FOR EACH ROW UPDATE `order` SET `Total` = `Total` - `OLD`.`Quantity` * (select `Price` from `menuitem` where `OLD`.`MenuItemId` = `menuitem`.`Id`) where `Id` = `OLD`.`OrderId`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `OrderTotalAfterInsert` AFTER INSERT ON `orderitem` FOR EACH ROW UPDATE `order` SET `Total` = `Total` + (select `Price` from `menuitem` where `NEW`.`MenuItemId` = `Id`) where `order`.`Id` = `NEW`.`OrderId`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `OrderTotalAfterUpdate` AFTER UPDATE ON `orderitem` FOR EACH ROW UPDATE `order` SET `Total` =
  (case when `OLD`.`Quantity` < `NEW`.`Quantity` then `Total` +
  (select `Price` from `menuitem` where `Id` = `NEW`.`MenuItemId`)
  when `OLD`.`quantity` > `NEW`.`quantity`
  then `Total` - (select `Price` from `menuitem` where `Id` = `NEW`.`MenuItemId`) end)
  where `order`.`Id` = `NEW`.`OrderId`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orderlocation`
--

CREATE TABLE `orderlocation` (
  `OrderId` int(11) NOT NULL,
  `LocationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderlocation`
--

INSERT INTO `orderlocation` (`OrderId`, `LocationId`) VALUES
(171, 45),
(173, 45),
(174, 47),
(175, 54),
(182, 45),
(183, 76),
(184, 45),
(197, 80);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `Id` int(11) NOT NULL,
  `Path` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `MenuItemId` int(11) NOT NULL,
  `Value` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`Id`, `UserId`, `MenuItemId`, `Value`) VALUES
(1, 3, 7, '2'),
(2, 3, 8, '3'),
(3, 7, 7, '4'),
(4, 7, 8, '5'),
(5, 9, 7, '4'),
(6, 9, 8, '3'),
(7, 4, 7, '5'),
(8, 4, 8, '5');

--
-- Triggers `rating`
--
DELIMITER $$
CREATE TRIGGER `MenuItemRatingAfterDelete` AFTER DELETE ON `rating` FOR EACH ROW UPDATE `menuitem` SET `Rating` = (select avg(`Value`) from `rating` where `MenuItemId` = `OLD`.`MenuItemId`), `menuitem`.`RatingUsersNo` = `RatingUsersNo` - 1 where `Id` = `OLD`.`MenuItemId`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `MenuItemRatingAfterInsert` AFTER INSERT ON `rating` FOR EACH ROW UPDATE `menuitem` SET `Rating` = (select avg(`Value`) from `rating` where `MenuItemId` = `New`.`MenuItemId`), `menuitem`.`RatingUsersNo` = `RatingUsersNo` + 1 where `Id` = `New`.`MenuItemId`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `MenuItemRatingAfterUpdate` AFTER UPDATE ON `rating` FOR EACH ROW UPDATE `menuitem` SET `Rating` = (select avg(`Value`) from `rating` where `MenuItemId` = `New`.`MenuItemId`) where `Id` = `New`.`MenuItemId`
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Id`, `Name`) VALUES
(1, 'Admin'),
(3, 'Cashier'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `thirdpartyuser`
--

CREATE TABLE `thirdpartyuser` (
  `Id` int(11) NOT NULL,
  `Auth_ProviderId` int(11) NOT NULL,
  `Auth_Provider_UserId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Created` datetime NOT NULL,
  `Modified` datetime NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `PaymentId` varchar(200) NOT NULL DEFAULT '0',
  `PayerId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `UserName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `LocaleId` int(11) NOT NULL DEFAULT '1',
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Image` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PasswordHash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PhoneNumber` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `RoleId` int(11) NOT NULL,
  `Confirmed` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `UserName`, `FirstName`, `LastName`, `LocaleId`, `Email`, `Image`, `PasswordHash`, `PhoneNumber`, `RoleId`, `Confirmed`) VALUES
(3, 'mostafaelsayed9419@gmail.com', 'mostafa', 'elsayed', 1, 'mostafaelsayed9419@gmail.com', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/images/unkown/noPerson.png', '$2y$10$YTJlYWU3ODQ0YmEwNDlmZ.S2s3X2rtv/R9fL/Ev1dbAOaHTz/wSMi', '01012345678', 2, '1'),
(4, 'ahmed@gmail.com', 'ahmed', 'mohamed', 1, 'ahmed@gmail.com', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/2017-09-08 09 09 38.jpg', '$2y$10$MTliMjA3YzA5OTk1YmE2OOVGjSbeUzQ4E23P9tLQplSPTO/3hrSlO', '01012345678', 2, '1'),
(7, 'waleed@gmail.com', 'waleed', 'ahmed', 1, 'waleed@gmail.com', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/2017-09-10 18 26 58.jpg', '$2y$10$ZDJlN2FkYmVjNjI1N2ZlNe0fA.FoohZxtP5qIqM6rYndvxvUcSM6y', '123', 1, '1'),
(8, 'esmail', 'esmail', '3bas', 1, 'esmail@gmail.com', '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/2017-09-19 11 03 56.jpg', '$2y$10$YTQyNzk5ZGU4YmMxYTYxO.OZyu2mPGTI.EchtcWWUS/48QPrZXs8y', '01012345678', 2, '1'),
(9, 'mmhnabawy@gmail.com', 'mohamed', 'nabawy', 1, 'mmhnabawy@gmail.com', NULL, '$2y$10$MzQxY2YwOTEzN2RhMjk4NeUpuuEq/pMkIb81TpvnHsYrwgGsj6VCC', '01016415791', 2, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addition`
--
ALTER TABLE `addition`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CategoryId` (`CategoryId`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`Id`),
  ADD KEY `UserId_idx` (`UserId`);

--
-- Indexes for table `auth_provider`
--
ALTER TABLE `auth_provider`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `cafeteria`
--
ALTER TABLE `cafeteria`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `cashier`
--
ALTER TABLE `cashier`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`Id`),
  ADD KEY `user_id_idx` (`UserId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CafeteriaId` (`CafeteriaId`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `MenuItemId` (`MenuItemId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `favoriteitem`
--
ALTER TABLE `favoriteitem`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `MenuItemId` (`MenuItemId`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `locale`
--
ALTER TABLE `locale`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`Id`),
  ADD KEY `LocationUserId_idx` (`UserId`);

--
-- Indexes for table `menuitem`
--
ALTER TABLE `menuitem`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CategoryId` (`CategoryId`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `MessageId` (`MessageId`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `OrderId` (`OrderId`),
  ADD KEY `MenuItemId` (`MenuItemId`);

--
-- Indexes for table `orderlocation`
--
ALTER TABLE `orderlocation`
  ADD KEY `OrderId` (`OrderId`),
  ADD KEY `LocationId` (`LocationId`);

--

-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `MenuItemId` (`MenuItemId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `unique_role` (`Name`);

--
-- Indexes for table `thirdpartyuser`
--
ALTER TABLE `thirdpartyuser`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Auth_ProviderId` (`Auth_ProviderId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`Id`),
  ADD KEY `transaction_user_id_idx` (`UserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RoleId` (`RoleId`),
  ADD KEY `LocaleId` (`LocaleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addition`
--
ALTER TABLE `addition`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `auth_provider`
--
ALTER TABLE `auth_provider`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cafeteria`
--
ALTER TABLE `cafeteria`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `cashier`
--
ALTER TABLE `cashier`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `favoriteitem`
--
ALTER TABLE `favoriteitem`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `locale`
--
ALTER TABLE `locale`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `menuitem`
--
ALTER TABLE `menuitem`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT for table `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--

-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `thirdpartyuser`
--
ALTER TABLE `thirdpartyuser`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addition`
--
ALTER TABLE `addition`
  ADD CONSTRAINT `addition_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`Id`);

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cashier`
--
ALTER TABLE `cashier`
  ADD CONSTRAINT `my_user_id` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`CafeteriaId`) REFERENCES `cafeteria` (`Id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`MenuItemId`) REFERENCES `menuitem` (`Id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);

--
-- Constraints for table `favoriteitem`
--
ALTER TABLE `favoriteitem`
  ADD CONSTRAINT `favoriteitem_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`),
  ADD CONSTRAINT `favoriteitem_ibfk_2` FOREIGN KEY (`MenuItemId`) REFERENCES `menuitem` (`Id`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `LocationUserId` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menuitem`
--
ALTER TABLE `menuitem`
  ADD CONSTRAINT `menuitem_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`Id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`MessageId`) REFERENCES `message` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`),

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `order` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`MenuItemId`) REFERENCES `menuitem` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `orderlocation`
--
ALTER TABLE `orderlocation`
  ADD CONSTRAINT `orderlocation_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `order` (`Id`),
  ADD CONSTRAINT `orderlocation_ibfk_2` FOREIGN KEY (`LocationId`) REFERENCES `location` (`Id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`MenuItemId`) REFERENCES `menuitem` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `thirdpartyuser`
--
ALTER TABLE `thirdpartyuser`
  ADD CONSTRAINT `thirdpartyuser_ibfk_1` FOREIGN KEY (`Auth_ProviderId`) REFERENCES `auth_provider` (`Id`),
  ADD CONSTRAINT `thirdpartyuser_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_user_id` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `role` (`Id`),
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`LocaleId`) REFERENCES `locale` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
