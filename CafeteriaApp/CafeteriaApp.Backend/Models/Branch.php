<?php
class Branch {
public $create = "CREATE TABLE `mydb`.`Branch` ( 
`Id` INT NOT NULL AUTO_INCREMENT ,
 `Address` VARCHAR(200) NOT NULL ,
  `Phone` VARCHAR(13) NOT NULL ,
   PRIMARY KEY (`Id`)
) ENGINE = InnoDB;";

 public $drop = "drop table `mydb`.`Branch`";

//public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
//public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
