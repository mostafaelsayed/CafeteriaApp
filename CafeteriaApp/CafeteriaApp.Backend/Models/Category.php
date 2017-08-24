<?php
class Category {
public $create = "create table `mydb`.`Category` (
Id int auto_increment primary key,
Name varchar(130) not null,
Image varchar(150) not null,
CafeteriaId int not null,
foreign key (CafeteriaId) references `Cafeteria`(Id) ON DELETE CASCADE 
) ENGINE = InnoDB; ";

public $drop = "drop table `mydb`.`Category`";
}

?>
