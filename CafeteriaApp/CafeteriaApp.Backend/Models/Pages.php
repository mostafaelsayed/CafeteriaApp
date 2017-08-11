<?php 

class Pages 
{
	
public $create="CREATE TABLE `Pages` (
  `Id` int(11) NOT NULL,
  `Path` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `pages`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`Id`),
  ADD UNIQUE KEY `Path_UNIQUE` (`Path`);


ALTER TABLE `pages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;SET FOREIGN_KEY_CHECKS=1;";

public $drop = "drop table `mydb`.`Pages`";


}




?>