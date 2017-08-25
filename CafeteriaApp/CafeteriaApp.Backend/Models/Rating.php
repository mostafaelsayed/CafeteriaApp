<?php


class Rating
{

	public $create= "CREATE TABLE `mydb`.`Rating` (
	 `Id` INT NOT NULL AUTO_INCREMENT ,
	  `UserId` INT NOT NULL ,
	   `MenuItemId` INT NOT NULL ,
	    `Value` decimal(10,0) NOT NULL ,
	    PRIMARY KEY (`Id`),
	    foreign key (UserId) references `User`(Id) ON DELETE CASCADE  ,
	    foreign key (MenuItemId) references `MenuItem`(Id) ON DELETE CASCADE 
	    ) ENGINE = InnoDB;


-- Triggers `rating`

DELIMITER $$
CREATE TRIGGER `AveragRatingOnDelete` AFTER DELETE ON `rating` FOR EACH ROW UPDATE MenuItem set MenuItem.Rating = IFNULL((SELECT AVG(Rating.VALUE) from Rating WHERE MenuItem.Id =Rating.MenuItemId ),0)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AveragRatingOnUpdate` AFTER UPDATE ON `rating`
 FOR EACH ROW UPDATE MenuItem set MenuItem.Rating = IFNULL((SELECT AVG(Rating.VALUE) from Rating WHERE MenuItem.Id =Rating.MenuItemId ),0)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AverageRatingOnInsert` AFTER INSERT ON `rating` FOR EACH ROW UPDATE MenuItem set MenuItem.Rating = IFNULL((SELECT AVG(Rating.VALUE) from Rating WHERE MenuItem.Id =Rating.MenuItemId ),0)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RatingUsersNoOnDelete` AFTER DELETE ON `rating` FOR EACH ROW UPDATE menuitem SET RatingUsersNo=IFNULL(( SELECT COUNT(*) from rating WHERE Rating.MenuItemId=MenuItem.Id),0)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RatingUsersNoOnInsert` AFTER INSERT ON `rating` FOR EACH ROW UPDATE menuitem SET RatingUsersNo= IFNULL(( SELECT COUNT(*) from rating WHERE Rating.MenuItemId=MenuItem.Id),0)
$$
DELIMITER ;


-- Indexes for table `rating`

ALTER TABLE `rating`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `MenuItemId` (`MenuItemId`);


-- Constraints for table `rating`
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`MenuItemId`) REFERENCES `menuitem` (`Id`) ON DELETE CASCADE;



	    ";

	public $drop="drop table `mydb`.`Rating` ";


}


?>
