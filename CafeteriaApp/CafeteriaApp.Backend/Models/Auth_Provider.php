<?php 

class Auth_Provider 
{
	
public $create="CREATE TABLE `mydb`.`Auth_Provider` ( `Id` INT NOT NULL AUTO_INCREMENT ,
 `Name` VARCHAR(100) NOT NULL ,
 PRIMARY KEY (`Id`) 
) ENGINE = InnoDB;";

public $drop = "drop table `mydb`.`Auth_Provider`";

public $insert ="INSERT INTO  `mydb`.`Auth_Provider` (`Id`, `Name`) VALUES
	(1, 'Facebook'),
	(2, 'Google'),
	(3, 'Twitter')";

}




?>