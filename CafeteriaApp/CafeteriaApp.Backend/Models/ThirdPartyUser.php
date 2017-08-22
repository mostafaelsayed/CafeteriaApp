<?php

class ThirdPartyUser //roleId = 2
{

public $create="CREATE TABLE `ThirdPartyUser` (
  `Id` int(11) NOT NULL AUTO_INCREMENT ,
  `Auth_ProviderId` int(11) NOT NULL,
  `Auth_Provider_UserId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Created` datetime NOT NULL,
  `Modified` datetime NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

ALTER TABLE `ThirdPartyUser`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Auth_ProviderId` (`Auth_ProviderId`),
  ADD KEY `UserId` (`UserId`);

ALTER TABLE `thirdpartyuser`
  ADD CONSTRAINT `thirdpartyuser_ibfk_1` FOREIGN KEY (`Auth_ProviderId`) REFERENCES `auth_provider` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `thirdpartyuser_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE CASCADE ;



";

public $drop = "drop table `mydb`.`ThirdPartyUser`";


}




?>
