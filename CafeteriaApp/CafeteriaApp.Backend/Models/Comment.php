<?php

class Comment {

public $create = "
CREATE TABLE `mydb`.`Comment` ( `Id` INT NOT NULL AUTO_INCREMENT , `Details` TEXT NOT NULL , `CustomerId` INT NOT NULL , `MenuItemId` INT NOT NULL , PRIMARY KEY (`Id`), foreign key (CustomerId) references `Customer`(Id) ,foreign key (MenuItemId) references `MenuItem`(Id) ) ENGINE = InnoDB;
";

public $drop = "drop table `mydb`.`Comment`";
}

?>
