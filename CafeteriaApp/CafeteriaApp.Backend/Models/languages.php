

<?php 

class Languages 
{
	
public $create="CREATE TABLE `mydb`.`Languages` (
 `Id` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(200) NOT NULL ,
  TxtDirection boolean  not null  DEFAULT FALSE ,

   PRIMARY KEY (`Id`)
   ) ENGINE = InnoDB;
";

public $drop = "drop table `mydb`.`Languages`";


}




?>