<?php 

class FavoriteItem 
{
	
public $create="CREATE TABLE `cafetria`.`FavoriteItem` (
 `Id` INT NOT NULL AUTO_INCREMENT ,
 `UserId` INT NOT NULL ,
 `MenuItemId` INT NOT NULL ,
 PRIMARY KEY (`Id`),
 foreign key (UserId) references `User`(Id) ON DELETE CASCADE  ,
 foreign key (MenuItemId) references `MenuItem`(Id) ON DELETE CASCADE 

 ) ENGINE = InnoDB; ";

public $drop = "drop table `cafetria`.`FavoriteItem`";


}




?>