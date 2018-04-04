<?php


class Order
{

	public $create= "CREATE TABLE `cafetria`.`Order` (
	`Id` INT NOT NULL AUTO_INCREMENT ,
	 `UserId` INT NOT NULL ,
	 `DeliveryPlace` VARCHAR(200) NOT NULL ,
	  `DeliveryDateId` INT NOT NULL ,
	  `DeliveryTimeId` INT NOT NULL ,
	  `Paid` DECIMAL(6,2) NOT NULL ,
	  `Total` DECIMAL(6,2) NOT NULL ,
	  `OrderStatusId` INT NOT NULL ,
	   `PaymentMethodId` INT NOT NULL ,
		`Type` BOOLEAN NOT NULL DEFAULT TRUE ,/* 0 takeaway , 1 delivery*/
		PRIMARY KEY (`Id`),
		foreign key (UserId) references `User`(Id) ON DELETE CASCADE  ,
		foreign key (DeliveryDateId) references `Dates`(Id),
		foreign key (DeliveryTimeId) references `Times`(Id),
		foreign key (OrderStatusId) references `OrderStatus`(Id),
		foreign key (PaymentMethodId) references `PaymentMethod`(Id)

	) ENGINE = InnoDB;";

	public $drop="drop table `cafetria`.`Order` ";


}


?>
