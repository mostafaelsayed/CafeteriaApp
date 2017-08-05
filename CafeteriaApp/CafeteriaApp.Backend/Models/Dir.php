
<?php 

class Dir
{
	
public $create="CREATE TABLE `mydb`.`Dir` ( `Id` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(50) NOT NULL , `Dir` VARCHAR(100) NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;";

public $drop = "drop table `mydb`.`Dir`";

public $insert ="INSERT INTO  `mydb`.`Dir` (`Id`, `Name`, `Dir`) VALUES
(1, 'Admin', 'CafeteriaApp\\CafeteriaApp.Frontend\\Areas\\Admin'),
(2, 'Customer', 'CafeteriaApp\\CafeteriaApp.Frontend\\Areas\\Customer'),
(3, 'Public', 'CafeteriaApp\\CafeteriaApp.Frontend\\Areas\\Public')";

}




?>