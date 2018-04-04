<?php


class Gender
{

	public $create= "CREATE TABLE `cafetria`.`Gender` (
	 `Id` INT NOT NULL AUTO_INCREMENT ,
 	`Name` VARCHAR(50) NOT NULL ,
	    PRIMARY KEY (`Id`)
	)
 ENGINE = InnoDB;
	";

	public $drop="drop table `cafetria`.`Gender` ";

	public $insert ="INSERT INTO  `cafetria`.`Gender` (`Id`, `Name`) VALUES
	(1, 'Male'),
	(2, 'Female'),
	(3, 'Other')";

}



?>
