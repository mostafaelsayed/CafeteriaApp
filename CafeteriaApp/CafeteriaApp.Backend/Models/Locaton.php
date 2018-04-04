
<?php
class Location {
public $create = "CREATE TABLE `Location` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PlaceName` varchar(300) NOT NULL,
  `PlaceAddress` varchar(300) NOT NULL,
  `PlaceId` varchar(300) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;";

public $drop = "drop table `cafetria`.`Location`";
}

?>
