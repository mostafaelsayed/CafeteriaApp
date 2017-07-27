<?php 


class Role
{
	
	public $create= "CREATE TABLE `mydb`.`Role` ( `Id` INT(3) unsigned NOT NULL AUTO_INCREMENT , `Name` VARCHAR(50) NOT NULL , PRIMARY KEY (`Id`), UNIQUE `unique_role` (`Name`(50)))";

	public $drop="drop table `mydb`.`Role` ";


}


?>