<?php
class MenuItem {
public $create = "create table `mydb`.`MenuItem` (
Id int auto_increment primary key,
Name varchar(130) not null,
Image varchar(150) not null,
Price decimal(6,2) not null,
Description text,
ReadyInMins int  not null  DEFAULT '0',
Visible boolean  not null  DEFAULT TRUE ,
CategoryId int not null,
Rating decimal not null DEFAULT '0' ,
RatingUsersNo int not null DEFAULT '0' ,
foreign key (CategoryId) references `Category`(Id)
) ENGINE = InnoDB; ";

public $drop = "drop table `mydb`.`MenuItem`";
}

?>
