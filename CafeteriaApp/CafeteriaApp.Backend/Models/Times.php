<?php 

class Times 
{
	
public $create="CREATE TABLE `mydb`.`Times` ( `Id` INT NOT NULL AUTO_INCREMENT , `Time` TIME NOT NULL , PRIMARY KEY (`Id`), UNIQUE `time` (`Time`))";

public $drop = "drop table `mydb`.`Times`";


}


?>

