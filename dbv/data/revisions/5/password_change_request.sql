CREATE TABLE `password_change_request` (
	`uid`				int(11)			auto_increment,
	`creation_date`		datetime		NOT NULL default '0000-00-00 00:00:00',
	`userid`			int(11)			NOT NULL,
	`r_string`			varchar(255)	NOT NULL, 
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY			(`uid`),
	FOREIGN KEY			(`userid`) 		REFERENCES users(uid)
) ENGINE=InnoDB;