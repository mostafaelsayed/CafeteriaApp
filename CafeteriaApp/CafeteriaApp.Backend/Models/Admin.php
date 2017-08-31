
<?php
class Admin {
public $create = "CREATE TABLE `Admin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  KEY `UserId_idx` (`UserId`),
  CONSTRAINT `user_id` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8; ";

public $drop = "drop table `mydb`.`Admin`";
}

?>
