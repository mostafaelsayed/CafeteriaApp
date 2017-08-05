<?php

class User
{

public $create="CREATE TABLE `mydb`.`User` ( `Id` INT NOT NULL AUTO_INCREMENT , `UserName` VARCHAR(100) NOT NULL , `FirstName` VARCHAR(50) NOT NULL , `LastName` VARCHAR(50) NOT NULL , `Email` VARCHAR(30) NOT NULL , `Image` VARCHAR(500) NOT NULL , `PasswordHash` VARCHAR(100) NOT NULL , `PhoneNumber` VARCHAR(13) NOT NULL , `RoleId` INT  NOT NULL , PRIMARY KEY (`Id`) , foreign key (RoleId) references `Role`(Id)) ENGINE = InnoDB; ";

public $drop = "drop table `mydb`.`User`";


}




?>
