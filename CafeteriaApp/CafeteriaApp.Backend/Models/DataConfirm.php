
<?php

class DatacConfirm {

public $create = "
CREATE TABLE `DatacConfirm` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Word` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DatacConfirm`
--
ALTER TABLE `DatacConfirm`
  ADD KEY `UserId` (`UserId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DatacConfirm`
--
ALTER TABLE `DatacConfirm`
  ADD CONSTRAINT `dataconfirm_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);
";

public $drop = "drop table `mydb`.`DatacConfirm`";
}

?>
