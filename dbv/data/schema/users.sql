CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `user_type_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `tel_home` varchar(30) NOT NULL DEFAULT '',
  `tel_work` varchar(30) NOT NULL DEFAULT '',
  `fax` varchar(30) NOT NULL DEFAULT '',
  `job_title` varchar(100) NOT NULL DEFAULT '',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  KEY `user_type_id` (`user_type_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8