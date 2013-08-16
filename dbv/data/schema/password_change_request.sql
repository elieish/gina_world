CREATE TABLE `password_change_request` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` int(11) NOT NULL,
  `r_string` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  KEY `userid` (`userid`),
  CONSTRAINT `password_change_request_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8