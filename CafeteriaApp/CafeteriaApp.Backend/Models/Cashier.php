
<?php
class Cashier {
public $create = "CREATE TABLE `Cashier` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  KEY `user_id_idx` (`UserId`),
  CONSTRAINT `my_user_id` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 ";

public $drop = "drop table `mydb`.`Cashier`";
}

?>
