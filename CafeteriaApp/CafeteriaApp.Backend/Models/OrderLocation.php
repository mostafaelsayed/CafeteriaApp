
<?php
class OrderLocation {
public $create = "CREATE TABLE `OrderLocation` (
  `OrderId` int(11) NOT NULL,
  `LocationId` int(11) not null,
  foreign key (`OrderId`) references `order` (`Id`),
  foreign key (`LocationId`) references `location` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 ";

public $drop = "drop table `cafetria`.`OrderLocation`";
}

?>
