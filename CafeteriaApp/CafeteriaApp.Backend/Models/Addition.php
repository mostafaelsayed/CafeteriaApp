<?php 

class Addition 
{
	
public $create="CREATE TABLE `mydb`.`Addition` ( `Id` INT NOT NULL AUTO_INCREMENT ,
 `Name` VARCHAR(50) NOT NULL ,
 `Price` DECIMAL NOT NULL ,
 `CategoryId` INT NOT NULL ,
 PRIMARY KEY (`Id`) ,
 foreign key (CategoryId) references `Category`(Id)) ENGINE = InnoDB;";

public $drop = "drop table `mydb`.`Addition`";


}




?>