<?php 


class Customer
{
	
	public $create= "CREATE TABLE `mydb`.`Customer` ( `Id` INT unsigned NOT NULL AUTO_INCREMENT , `Credit` DECIMAL(6,2) NOT NULL , `UserId` INT NOT NULL , PRIMARY KEY (`Id`),
foreign key (UserId) references User(Id))
	";

	public $drop="drop table `mydb`.`Customer` ";


}


?>