<?php 

class OrderItem 
{
	
	 public $create =   "CREATE TABLE `mydb`.`OrderItem` ( 
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	 `Quantity` INT UNSIGNED NOT NULL ,
	 `OrderId` INT NOT NULL ,
	 `MenuItemId` INT NOT NULL ,
	 `TotalPrice` DECIMAL(6,2) NOT NULL ,
	 PRIMARY KEY (`Id`) ,
	 foreign key (OrderId) references `Order`(Id) ON DELETE CASCADE , 
	 foreign key (MenuItemId) references `MenuItem`(Id) ON DELETE CASCADE
	 

  ) ENGINE = InnoDB;


CREATE TRIGGER `OrderTotalAfterDelete` BEFORE DELETE ON `orderitem`
 FOR EACH ROW UPDATE `Order`SET Total=IFNULL((SELECT SUM(TotalPrice) FROM OrderItem WHERE OrderId=Order.Id),0) WHERE Order.Id=OLD.OrderId;


CREATE TRIGGER `OrderTotalAfterInsert` AFTER INSERT ON `orderitem`
 FOR EACH ROW UPDATE `Order`SET Total=IFNULL((SELECT SUM(TotalPrice) FROM OrderItem WHERE OrderId=Order.Id),0) WHERE Order.Id=New.OrderId;

CREATE TRIGGER `OrderTotalAfterUpdate` AFTER UPDATE ON `orderitem`
 FOR EACH ROW UPDATE `Order`SET Total=IFNULL((SELECT SUM(TotalPrice) FROM OrderItem WHERE OrderId=Order.Id),0) WHERE Order.Id=New.OrderId;

  ";

public $drop = "drop table `mydb`.`OrderItem`";


}




?>


