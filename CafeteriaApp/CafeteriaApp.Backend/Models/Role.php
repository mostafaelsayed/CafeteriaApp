<?php


class Role
{

	public $create= "CREATE TABLE `cafetria`.`Role` ( 
	`Id` INT NOT NULL AUTO_INCREMENT ,
	 `Name` VARCHAR(50) NOT NULL ,
	  PRIMARY KEY (`Id`),
	   UNIQUE `unique_role` (`Name`(50))
	  ) ENGINE = InnoDB;";

	public $drop="drop table `cafetria`.`Role` ";

	public $insert_all_Roles="insert into `cafetria`.`Role` (Id,Name) values (1,'Admin'),(2,'Customer'),(3,'Cashier')";


}


?>
