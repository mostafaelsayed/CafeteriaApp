<?php
class Cafeteria {
public $create = "create table `cafetria`.`Cafeteria` (
Id int auto_increment primary key,
Name varchar(130) not null,
Image varchar(150) not null
) ENGINE = InnoDB;";

 public $drop = "drop table `cafetria`.`Cafeteria`";

//public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
//public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
