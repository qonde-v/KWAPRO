alter table message_data add COLUMN p_md_Id INT DEFAULT 0;
alter table `user`  add COLUMN subpic INT DEFAULT 0;

CREATE TABLE `information` (
  `id` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `username` varchar(255) default NULL,
  `type` tinyint(4) default '0' COMMENT '1 demand 2 message ',
  `to_uId` int(11) default NULL,
  `title` varchar(255) default NULL,
  `relateid` int(11) default NULL,
  `isread` tinyint(4) default '0',
  `createdate` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

