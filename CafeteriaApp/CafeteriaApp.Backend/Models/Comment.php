<?php

class Comment {

public $create = "
CREATE TABLE `mydb`.`Comment` (
 `Id` INT NOT NULL AUTO_INCREMENT ,
  `Details` TEXT NOT NULL ,
   `UserId` INT NOT NULL ,
   `MenuItemId` INT NOT NULL ,
     `DateId` INT NOT NULL , 
     PRIMARY KEY (`Id`),
    foreign key (UserId) references `User`(Id) ON DELETE CASCADE  ,
    foreign key (MenuItemId) references `MenuItem`(Id) ON DELETE CASCADE  ,
        foreign key (DateId) references `Dates`(Id) 
    )
     ENGINE = InnoDB;
";

public $drop = "drop table `mydb`.`Comment`";
}

?>
