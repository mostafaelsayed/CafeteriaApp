<?php

class OrderStatus {
public $create = "CREATE TABLE `cafetria`.`OrderStatus` ( 
`Id` INT NOT NULL AUTO_INCREMENT ,
 `Name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`Id`)
  ) ENGINE = InnoDB; ";

public $drop = "drop table `cafetria`.`OrderStatus`";


public $insert_all_OrderStatus="insert into `cafetria`.`OrderStatus` (Id,Name) values (1,'Open'),(2,'Closed Or Delivered'),(3,'Shipped')";


}

?>


