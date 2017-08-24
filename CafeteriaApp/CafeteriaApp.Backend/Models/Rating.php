<?php


class Rating
{

	public $create= "CREATE TABLE `mydb`.`Rating` (
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	  `UserId` INT NOT NULL ,
	   `MenuItemId` INT NOT NULL ,
	    `Value` decimal(2,1) NOT NULL ,
	    PRIMARY KEY (`Id`),
	    foreign key (UserId) references `User`(Id) ON DELETE CASCADE  ,
	    foreign key (MenuItemId) references `MenuItem`(Id) ON DELETE CASCADE 
	    ) ENGINE = InnoDB;";

	public $drop="drop table `mydb`.`Rating` ";


}


?>
