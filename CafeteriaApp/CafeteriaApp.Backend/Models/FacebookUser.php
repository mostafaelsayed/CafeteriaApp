<?php

class FacebookUser //roleId = 2
{

public $create="CREATE TABLE `FacebookUser` (
 `Id` int(11) NOT NULL AUTO_INCREMENT,
 -- `oauth_provider` enum('','facebook','google','twitter') COLLATE utf8_unicode_ci NOT NULL,
 `Auth_ProviderId` INT COLLATE utf8_unicode_ci NOT NULL,
 `Auth_Provider_UserId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `UserName` VARCHAR(150) NOT NULL ,
 `FirstName` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
 `LastName` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
 `Email` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
 `GenderId` INT COLLATE utf8_unicode_ci NOT NULL,
 `LocaleId` INT COLLATE utf8_unicode_ci NOT NULL,
 `ImageLink` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
 `Link` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
 `Credit` DECIMAL(6,2) NOT NULL  DEFAULT '0' ,
 `Created` datetime NOT NULL,
 `Modified` datetime NOT NULL,
 PRIMARY KEY (`Id`),
 foreign key (`Auth_ProviderId`) references `Auth_Provider`(`Id`),
 foreign key (`LocaleId`) references `Locale`(`Id`),
 foreign key (`GenderId`) references `Gender`(`Id`)


) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; ";

public $drop = "drop table `mydb`.`FacebookUser`";


}




?>
