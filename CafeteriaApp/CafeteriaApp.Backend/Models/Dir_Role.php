
<?php 

class Dir_Role
{
	
public $create="CREATE TABLE `mydb`.`Dir_Role` ( 
`Id` INT NOT NULL AUTO_INCREMENT ,
 `DirId` INT NOT NULL ,
 `RoleId` INT NOT NULL , 
PRIMARY KEY (`Id`),
foreign key (DirId) references `Dir`(Id) , 
  foreign key (RoleId) references `Role`(Id) 

) ENGINE = InnoDB; ";

public $drop = "drop table `mydb`.`Dir_Role`";

public $insert ="INSERT INTO  `mydb`.`Dir_Role` (`Id`, `DirId`, `RoleId`) VALUES
(1,1,1 ),
(2,2,2),
(3,3,1),
(4,3,2)";

}




?>