

<?php 

class Words 
{
	
public $create="CREATE TABLE `Words` (
  `Id` int(11) NOT NULL,
  `English` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `French` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `German` varchar(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `Words`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id_UNIQUE` (`Id`),
  ADD UNIQUE KEY `Name_UNIQUE` (`English`),
  ADD UNIQUE KEY `French_UNIQUE` (`French`),
  ADD UNIQUE KEY `German_UNIQUE` (`German`);
   

  ALTER TABLE `Words`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
";

public $drop = "drop table `mydb`.`Words`";


}




?>