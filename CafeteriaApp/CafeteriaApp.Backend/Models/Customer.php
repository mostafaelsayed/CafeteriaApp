<?php


class Customer
{

	public $create= "CREATE TABLE `mydb`.`Customer` (
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	  `Credit` DECIMAL(6,2) NOT NULL  DEFAULT '0' ,
	  `DateOfBirth` Date NOT NULL ,
	   `UserId` INT NOT NULL ,
	   `GenderId` INT NOT NULL ,
	    PRIMARY KEY (`Id`),
foreign key (UserId) references `User`(Id),
foreign key (GenderId) references `Gender`(Id) cascade ON DELETE CASCADE

	)
 ENGINE = InnoDB;
	";

	public $drop="drop table `mydb`.`Customer` ";


}


?>
