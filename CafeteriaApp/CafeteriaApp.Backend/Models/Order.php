<?php


class Order
{

	public $create= "CREATE TABLE `mydb`.`Order` (
	`Id` INT NOT NULL AUTO_INCREMENT ,
	 `CustomerId` INT NOT NULL ,
	 `DeliveryPlace` VARCHAR(200) NOT NULL ,
	  `DeliveryDateId` INT NOT NULL ,
	  `DeliveryTimeId` INT NOT NULL ,
	  `Paid` DECIMAL NOT NULL ,
	  `Total` DECIMAL NOT NULL ,
	  `OrderStatusId` INT NOT NULL ,
	   `PaymentMethodId` INT NOT NULL ,
		PRIMARY KEY (`Id`),
		foreign key (CustomerId) references `Customer`(Id),
		foreign key (DeliveryDateId) references `Dates`(Id),
		foreign key (DeliveryTimeId) references `Times`(Id),
		foreign key (OrderStatusId) references `OrderStatus`(Id),
		foreign key (PaymentMethodId) references `PaymentMethod`(Id)

	) ENGINE = InnoDB;";

	public $drop="drop table `mydb`.`Order` ";


}


?>
