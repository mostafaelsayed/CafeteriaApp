<?php

class OrderStatus {
public $create = "CREATE TABLE `mydb`.`OrderStatus` ( `Id` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(100) NOT NULL , PRIMARY KEY (`Id`))";

public $drop = "drop table `mydb`.`OrderStatus`";
}

?>


