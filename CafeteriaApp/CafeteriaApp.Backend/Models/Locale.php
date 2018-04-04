<?php 

class Locale 
{
	
public $create="CREATE TABLE `cafetria`.`Locale` ( `Id` INT NOT NULL AUTO_INCREMENT ,
 `Name` VARCHAR(10) NOT NULL ,
 PRIMARY KEY (`Id`) 
) ENGINE = InnoDB;";

public $drop = "drop table `cafetria`.`Locale`";


}




?>

?>