CREATE TABLE `users` (
	`uid`				int(11)			auto_increment,
	`creation_date`		datetime		NOT NULL default '0000-00-00 00:00:00',
	`created_by`		int(11)			NOT NULL default 0,
	`user_type_id`		int(11)			NOT NULL default 0,
	`username`			varchar(30)		NOT NULL default '',
	`password`			varchar(40)		NOT NULL default '',
	`first_name`		varchar(50)		NOT NULL default '',
	`last_name`			varchar(50)		NOT NULL default '',
	`email`				varchar(255)	NOT NULL default '',
	`mobile`			varchar(30)		NOT NULL default '',
	`tel_home`			varchar(30)		NOT NULL default '',
	`tel_work`			varchar(30)		NOT NULL default '',
	`fax`				varchar(30)		NOT NULL default '',
	`job_title`			varchar(100)	NOT NULL default '',
	`active`			int(1)			NOT NULL default 1,
	PRIMARY KEY			(`uid`),
	FOREIGN KEY			(`user_type_id`) REFERENCES user_types(uid)
) ENGINE=InnoDB;