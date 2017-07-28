<?php 

class FavoriteItem 
{
	
public $create="CREATE TABLE `mydb`.`FavoriteItem` (
 `Id` INT NOT NULL AUTO_INCREMENT ,
 `CustomerId` INT NOT NULL ,
 `MenuItemId` INT NOT NULL ,
 PRIMARY KEY (`Id`),
 foreign key (CustomerId) references `Customer`(Id),
 foreign key (MenuItemId) references `MenuItem`(Id)

 ) ";

public $drop = "drop table `mydb`.`FavoriteItem`";


}




?>