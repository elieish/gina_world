CREATE TABLE `config` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `var` varchar(255) NOT NULL DEFAULT '',
  `val` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8