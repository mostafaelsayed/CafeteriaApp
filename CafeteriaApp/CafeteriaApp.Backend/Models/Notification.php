

<?php
class Notification {
public $create = "CREATE TABLE `cafetria`.`Notification` ( 
`Id` INT NOT NULL AUTO_INCREMENT ,
 `UserId` INT NOT NULL , 
 `MessageId` INT NOT NULL ,
  PRIMARY KEY (`Id`),
  foreign key (UserId) references `User`(Id) ON DELETE CASCADE,
  foreign key (MessageId) references `Message`(Id) ON DELETE CASCADE
  ) ENGINE = InnoDB;";

 public $drop = "drop table `cafetria`.`Notification`";

//public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
//public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
