CREATE TABLE `categories`(
	`uid` 				int(11) 		auto_increment,
	`datetime` 			datetime 		NOT NULL default "0000-00-00 00:00:00",
	`user` 				int(11) 		NOT NULL default 0,
	`name` 				varchar(255) 	NOT NULL default "",
	`active`			int(1)			NOT NULL default 1,
PRIMARY KEY (`uid`));
