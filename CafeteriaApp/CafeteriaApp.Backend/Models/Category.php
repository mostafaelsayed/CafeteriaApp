<?php
class Category {
public $create = "create table `mydb`.`Category` (
Id int(6) unsigned auto_increment primary key,
Name varchar(130) not null,
Image varchar(50),
CafeteriaId int(6) unsigned not null,
foreign key (CafeteriaId) references Cafeteria(Id)
)";

public $drop = "drop table `mydb`.`Category`";
}

?>
