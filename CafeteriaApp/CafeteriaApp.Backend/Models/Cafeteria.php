<?php
class Cafeteria {
public $create = "create table `mydb`.`Cafeteria` (
Id int(6) unsigned auto_increment primary key,
Name varchar(430) not null,
Image varchar(50)
)";

 public $drop = "drop table `mydb`.`Cafeteria`";
// }
public $alterCafeteriaTable = "alter table cafeteria modify column Id int(10)";
public $alterCategoryTable = "alter table category modify column CafeteriaId int(10)";

}
?>
