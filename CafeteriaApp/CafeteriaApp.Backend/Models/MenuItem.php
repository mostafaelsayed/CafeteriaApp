<?php
class MenuItem {
public $create = "create table `mydb`.`MenuItem` (
Id int auto_increment primary key,
Name varchar(130) not null,
Image varchar(150),
Price decimal(5,2) not null,
Description text,
CategoryId int not null,
foreign key (CategoryId) references `Category`(Id)
) ENGINE = InnoDB; ";

public $drop = "drop table `mydb`.`MenuItem`";
}

?>
