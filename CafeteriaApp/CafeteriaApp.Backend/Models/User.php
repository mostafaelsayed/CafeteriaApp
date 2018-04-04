<?php

class User
{

public $create="CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `LocaleId` int(11) NOT NULL DEFAULT '1',
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Confirmed` BOOLEAN NOT NULL DEFAULT FALSE  ,/* 0 takeaway , 1 delivery*/
  `Image` varchar(500) COLLATE utf8_unicode_ci DEFAULT 'CafeteriaApp.Backend/defaultCustomerImage.png' ,
  `PasswordHash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PhoneNumber` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `RoleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RoleId` (`RoleId`),
  ADD KEY `LocaleId` (`LocaleId`);


ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `role` (`Id`) ON DELETE CASCADE ,
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`LocaleId`) REFERENCES `locale` (`Id`);

 ";

public $drop = "drop table `cafetria`.`User`";


}




?>
