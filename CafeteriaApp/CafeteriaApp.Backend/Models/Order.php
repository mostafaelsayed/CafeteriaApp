<?php 


class Order
{
	
	public $create= "CREATE TABLE `mydb`.`Order` ( `Id` INT NOT NULL AUTO_INCREMENT , `CustomerId` INT NOT NULL , `DeliveryPlace` INT NOT NULL , `DeliveryDateId` DATE NOT NULL , `DeliveryTimeId` INT NOT NULL , `Paid` DECIMAL NOT NULL , `Total` DECIMAL NOT NULL , `OrderStatusId` INT NOT NULL , `PaymentMethodId` INT NOT NULL , PRIMARY KEY (`Id`), 
		foreign key (CustomerId) references Customer(Id),
		foreign key (DeliveryDateId) references DeliveryDate(Id),
		foreign key (DeliveryTimeId) references DeliveryTime(Id),
		foreign key (OrderStatusId) references OrderStatus(Id),
		foreign key (PaymentMethodId) references PaymentMethod(Id),


	)";

	public $drop="drop table `mydb`.`Order` ";


}


?>

