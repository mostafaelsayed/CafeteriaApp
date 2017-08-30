<?php
class PaymentMethod
{
	
	public $create= "CREATE TABLE `mydb`.`PaymentMethod` (
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	  `Name` VARCHAR(100) NOT NULL ,
	   PRIMARY KEY (`Id`)
	   	) ENGINE = InnoDB;";

	public $drop="drop table `mydb`.`PaymentMethod` ";

public $insert_all_PaymentMethods="insert into `mydb`.`PaymentMethod` (Id,Name) values (1,'Cash On Delivery'),(2,'Visa'),(3,'Online Bank')";
}


?>
