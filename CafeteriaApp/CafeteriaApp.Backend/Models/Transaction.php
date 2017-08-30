<?php
class Transaction {
public $create = "CREATE TABLE `Transaction` (
  `PaymentId` varchar(200) NOT NULL,
  `PayerId` varchar(200) NOT NULL,
  `UserId` int(11) NOT NULL,
  `TransactionId` int(11) NOT NULL,
  PRIMARY KEY (`PaymentId`),
  UNIQUE KEY `Id_UNIQUE` (`PaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

 public $drop = "drop table `mydb`.`Transaction`";

//public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
//public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
