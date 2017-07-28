<?php
class MenuItem {
public $create = "create table `mydb`.`MenuItem` (
Id int auto_increment primary key,
Name varchar(50) not null,
Image varchar(500),
Price decimal(5,2) not null,
Description text,
CategoryId int(6) unsigned not null,
foreign key (CategoryId) references `Category`(Id)
)";

public $drop = "drop table `mydb`.`MenuItem`";
}

?>
