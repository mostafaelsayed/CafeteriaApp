

<?php 

class Languages 
{
	
public $create="CREATE TABLE `cafetria`.`Languages` (
 `Id` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(200) NOT NULL ,
  TxtDirection boolean  not null  DEFAULT FALSE ,

   PRIMARY KEY (`Id`)
   ) ENGINE = InnoDB;
";//TxtDirection if false >> means left to right

public $drop = "drop table `cafetria`.`Languages`";


}




?>