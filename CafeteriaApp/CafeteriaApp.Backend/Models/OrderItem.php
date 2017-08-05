<?php 

class OrderItem 
{
	
	 public $create =   "CREATE TABLE `mydb`.`OrderItem` ( 
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	 `Quantity` INT UNSIGNED NOT NULL ,
	 `OrderId` INT NOT NULL ,
	 `MenuItemId` INT NOT NULL ,
	 `TotalPrice` DECIMAL NOT NULL ,
	 PRIMARY KEY (`Id`) ,
	 foreign key (OrderId) references `Order`(Id) ON DELETE CASCADE , 
	 foreign key (MenuItemId) references `MenuItem`(Id) ON DELETE CASCADE
	 

  ) ENGINE = InnoDB;";

public $drop = "drop table `mydb`.`OrderItem`";


}




?>


