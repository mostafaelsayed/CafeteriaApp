
<?php
class UserLocations {
public $create = "CREATE TABLE `UserLocations` (
  `UserId` int(11) NOT NULL,
  `LocationId` int(11) NOT NULL,
  KEY `UserId_idx` (`UserId`),
  KEY `LocationId_idx` (`LocationId`),
  CONSTRAINT `LocationId` FOREIGN KEY (`LocationId`) REFERENCES `location` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `UserId` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

 public $drop = "drop table `mydb`.`UserLocations`";

//public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
//public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
