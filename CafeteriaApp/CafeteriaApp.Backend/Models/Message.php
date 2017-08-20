<?php

class Message {

public $create = "CREATE TABLE `mydb`.`Message` ( 
`Id` INT NOT NULL AUTO_INCREMENT ,
 `Content` TEXT NOT NULL ,
  PRIMARY KEY (`Id`)
  ) ENGINE = InnoDB;";

 public $drop = "drop table `mydb`.`Message`";

//public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
//public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
