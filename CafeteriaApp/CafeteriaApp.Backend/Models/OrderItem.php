<?php 

class OrderItem 
{
	
	 public $create =   "CREATE TABLE `mydb`.`OrderItem` ( 
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	 `Quantity` INT UNSIGNED NOT NULL ,
	 `OrderId` INT NOT NULL ,
	 `MenuItemId` INT NOT NULL ,
	 PRIMARY KEY (`Id`) ,
	 foreign key (OrderId) references `Order`(Id) , 
	 foreign key (MenuItemId) references `MenuItem`(Id)
	 

  );";

public $drop = "drop table `mydb`.`OrderItem`";


}




?>


