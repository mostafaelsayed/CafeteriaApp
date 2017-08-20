<?php 

class FavoriteItem 
{
	
public $create="CREATE TABLE `mydb`.`FavoriteItem` (
 `Id` INT NOT NULL AUTO_INCREMENT ,
 `UserId` INT NOT NULL ,
 `MenuItemId` INT NOT NULL ,
 PRIMARY KEY (`Id`),
 foreign key (UserId) references `User`(Id),
 foreign key (MenuItemId) references `MenuItem`(Id)

 ) ENGINE = InnoDB; ";

public $drop = "drop table `mydb`.`FavoriteItem`";


}




?>