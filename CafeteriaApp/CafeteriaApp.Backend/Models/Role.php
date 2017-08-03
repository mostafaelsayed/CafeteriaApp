<?php


class Role
{

	public $create= "CREATE TABLE `mydb`.`Role` ( `Id` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(50) NOT NULL , PRIMARY KEY (`Id`), UNIQUE `unique_role` (`Name`(50)))";

	public $drop="drop table `mydb`.`Role` ";

	public $insert_all_Roles="insert into `mydb`.`Role` (Id,Name) values (1,'Admin'),(2,'Customer'),(3,'Cashier')";


}


?>
