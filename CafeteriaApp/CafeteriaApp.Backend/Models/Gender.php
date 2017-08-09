<?php


class Gender
{

	public $create= "CREATE TABLE `mydb`.`Gender` (
	 `Id` INT NOT NULL AUTO_INCREMENT ,
 	`Name` VARCHAR(50) NOT NULL ,
	    PRIMARY KEY (`Id`)
	)
 ENGINE = InnoDB;
	";

	public $drop="drop table `mydb`.`Gender` ";

	public $insert ="INSERT INTO  `mydb`.`Gender` (`Id`, `Name`) VALUES
	(1, 'Male'),
	(2, 'Female'),
	(3, 'Other')";

}



?>
