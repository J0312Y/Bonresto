CREATE TABLE IF NOT EXISTS `tbl_habittrack` (
  `htid` int(11) NOT NULL AUTO_INCREMENT,
  `cusid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `varient` int(11) NOT NULL,
  `habit` varchar(200) NOT NULL,
  PRIMARY KEY (`htid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
