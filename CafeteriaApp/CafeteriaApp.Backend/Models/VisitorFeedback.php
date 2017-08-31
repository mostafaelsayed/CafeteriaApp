<?php

class VisitorFeedback {

public $create = "
CREATE TABLE `VisitorFeedback` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Phone` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Message` text COLLATE utf8_unicode_ci NOT NULL,
  `DateId`  INT NOT NULL ,
  `AboutId`  INT NOT NULL ,
   PRIMARY KEY (`Id`),
    foreign key (DateId) references `Dates`(Id) ,
     foreign key (AboutId) references `FeedbackAbouts`(Id) on delete cascade 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

";

public $drop = "drop table `mydb`.`VisitorFeedback`";
}

?>
