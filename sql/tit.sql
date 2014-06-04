/*
Navicat MySQL Data Transfer

Source Server         : kendi
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : tit

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2014-06-04 15:27:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `answer_score`
-- ----------------------------
DROP TABLE IF EXISTS `answer_score`;
CREATE TABLE `answer_score` (
  `nId` int(11) NOT NULL,
  `use_num` int(11) default NULL,
  `no_use_num` int(11) default NULL,
  PRIMARY KEY  (`nId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of answer_score
-- ----------------------------

-- ----------------------------
-- Table structure for `ci_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  `user_id` int(11) default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------
INSERT INTO `ci_sessions` VALUES ('8485556de8e235813a2f63bc229d6421', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/201001', '1401866538', 'a:5:{s:3:\"uId\";s:1:\"1\";s:13:\"location_city\";s:1:\"-\";s:8:\"language\";s:7:\"chinese\";s:8:\"hot_tags\";a:0:{}s:6:\"status\";s:5:\"LOGIN\";}', '1');

-- ----------------------------
-- Table structure for `consult`
-- ----------------------------
DROP TABLE IF EXISTS `consult`;
CREATE TABLE `consult` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) character set utf8 default NULL,
  `question` varchar(255) character set utf8 default NULL,
  `createdate` datetime default NULL,
  `uID` int(11) default NULL,
  `username` varchar(255) character set utf8 default NULL,
  `answer` varchar(255) character set utf8 default NULL,
  `answerdate` datetime default NULL,
  `answeruId` int(11) default NULL,
  `answeruser` varchar(255) character set utf8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of consult
-- ----------------------------
INSERT INTO `consult` VALUES ('1', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');
INSERT INTO `consult` VALUES ('2', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');
INSERT INTO `consult` VALUES ('3', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');
INSERT INTO `consult` VALUES ('4', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');
INSERT INTO `consult` VALUES ('5', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');
INSERT INTO `consult` VALUES ('6', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');
INSERT INTO `consult` VALUES ('7', '国内运动服装和休闲服装买哪个品牌的性价比高？', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:34:57', '1', 'test', '国内运动服装和休闲服装买哪个品牌的性价比高？', '2014-05-24 08:41:34', '76', 'heeh');

-- ----------------------------
-- Table structure for `demand`
-- ----------------------------
DROP TABLE IF EXISTS `demand`;
CREATE TABLE `demand` (
  `id` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `username` varchar(255) character set utf8 default NULL,
  `title` varchar(255) character set utf8 default NULL,
  `type` varchar(50) character set utf8 default NULL,
  `strength` tinyint(4) default NULL,
  `sporttime` tinyint(4) default NULL,
  `weather` varchar(255) character set utf8 default NULL,
  `temperature` tinyint(4) default NULL,
  `humidity` tinyint(4) default NULL,
  `target` varchar(255) character set utf8 default NULL,
  `proficiency` tinyint(4) default NULL,
  `createdate` datetime default NULL,
  `designnum` int(11) default '0',
  `viewnum` int(11) default '0',
  `messnum` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of demand
-- ----------------------------
INSERT INTO `demand` VALUES ('1', '1', null, '跑步热吧 热', '跑步', '5', '2', '晴天', '20', '20', '男人', '10', '2014-05-22 05:13:54', '0', '0', '0');
INSERT INTO `demand` VALUES ('2', '1', null, '跑步热吧 热', '跑步', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 05:16:16', '0', '0', '0');
INSERT INTO `demand` VALUES ('6', '1', null, '阿道夫', '跑步', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 06:37:34', '0', '0', '0');
INSERT INTO `demand` VALUES ('7', '1', null, '的说法', '跑步', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 06:41:59', '0', '0', '0');
INSERT INTO `demand` VALUES ('8', '1', null, '建军节建军节', '跑步', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 06:42:40', '0', '0', '0');
INSERT INTO `demand` VALUES ('9', '1', null, '将啦啦啦', '跑步', '9', '19', '晴天', '20', '20', '男人', '5', '2014-05-22 06:43:17', '0', '0', '0');
INSERT INTO `demand` VALUES ('10', '1', null, '为鹅鹅鹅我', '跑步', '5', '18', '晴天', '20', '20', '男人', '6', '2014-05-22 06:43:51', '0', '0', '0');
INSERT INTO `demand` VALUES ('11', '1', null, '阿萨德', '足球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 15:52:22', '0', '0', '0');
INSERT INTO `demand` VALUES ('12', '1', null, '阿萨德3', '篮球', '5', '15', '晴天', '20', '20', '男人', '5', '2014-05-22 16:03:21', '0', '0', '0');
INSERT INTO `demand` VALUES ('13', '1', null, '阿萨德3', '篮球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 16:04:25', '0', '0', '0');
INSERT INTO `demand` VALUES ('14', '1', null, '阿萨德3', '篮球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 16:05:24', '0', '0', '0');
INSERT INTO `demand` VALUES ('15', '1', null, '阿萨德3', '篮球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 16:06:08', '0', '0', '0');
INSERT INTO `demand` VALUES ('16', '1', null, '阿萨德3', '篮球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 16:07:01', '0', '0', '0');
INSERT INTO `demand` VALUES ('17', '1', null, '阿萨德323', '篮球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 16:07:31', '0', '0', '0');
INSERT INTO `demand` VALUES ('18', '1', null, '阿萨德323恩恩', '篮球', '5', '2', '晴天', '20', '20', '男人', '5', '2014-05-22 16:07:50', '0', '0', '0');
INSERT INTO `demand` VALUES ('19', '1', null, '小孩子i ', '骑车', '5', '13', '多云', '20', '20', '男人', '3', '2014-05-22 16:30:14', '0', '0', '0');
INSERT INTO `demand` VALUES ('20', '1', null, '踢足球锻炼身体', '足球', '10', '12', '多云', '11', '49', '男人', '9', '2014-05-23 12:02:22', '0', '0', '0');
INSERT INTO `demand` VALUES ('21', '1', 'test', '我喜欢打篮球', '篮球', '3', '7', '小雨', '9', '55', '男人', '3', '2014-05-23 13:10:03', '0', '0', '0');
INSERT INTO `demand` VALUES ('22', '1', 'test', '看看天气', '户外山地运动', '5', '2', '下雪', '20', '20', '男人', '5', '2014-05-27 15:36:14', '0', '0', '0');
INSERT INTO `demand` VALUES ('23', '1', 'test', '轮滑轮滑', '轮滑运动', '3', '7', '阴天', '5', '20', '男人', '2', '2014-05-27 15:36:51', '0', '0', '0');

-- ----------------------------
-- Table structure for `design`
-- ----------------------------
DROP TABLE IF EXISTS `design`;
CREATE TABLE `design` (
  `id` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `username` varchar(16) character set utf8 default NULL,
  `title` varchar(255) character set utf8 default NULL,
  `demand_id` int(11) default NULL,
  `parameter` varchar(255) character set utf8 default NULL,
  `simulation` varchar(255) character set utf8 default NULL,
  `createdate` datetime default NULL,
  `viewnum` int(11) default '0',
  `messnum` int(11) default '0',
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of design
-- ----------------------------
INSERT INTO `design` VALUES ('1', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('2', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('3', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('4', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('5', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('6', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('7', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);
INSERT INTO `design` VALUES ('8', '1', 'test', '我的设计我的设计', '1', '阿萨德飞', '对对', '2014-05-24 11:19:38', '1', '1', null);

-- ----------------------------
-- Table structure for `fabrics`
-- ----------------------------
DROP TABLE IF EXISTS `fabrics`;
CREATE TABLE `fabrics` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) default NULL,
  `pic` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fabrics
-- ----------------------------

-- ----------------------------
-- Table structure for `friends_invite`
-- ----------------------------
DROP TABLE IF EXISTS `friends_invite`;
CREATE TABLE `friends_invite` (
  `fiId` int(11) NOT NULL auto_increment,
  `from_uId` int(11) NOT NULL,
  `to_uId` int(11) NOT NULL,
  `time` datetime default NULL,
  PRIMARY KEY  (`fiId`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friends_invite
-- ----------------------------

-- ----------------------------
-- Table structure for `invite_code_data`
-- ----------------------------
DROP TABLE IF EXISTS `invite_code_data`;
CREATE TABLE `invite_code_data` (
  `invite_id` int(11) NOT NULL auto_increment,
  `account` varchar(50) default NULL,
  `invite_code` varchar(500) default NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`invite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of invite_code_data
-- ----------------------------

-- ----------------------------
-- Table structure for `material`
-- ----------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `id` int(11) NOT NULL auto_increment,
  `uId` int(11) NOT NULL,
  `material` varchar(100) default NULL,
  `createdate` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of material
-- ----------------------------
INSERT INTO `material` VALUES ('1', '1', 'index_tpx01.png', '2014-05-11 01:01:09');
INSERT INTO `material` VALUES ('2', '1', 'index_tpx02.png', '2014-05-11 09:05:09');
INSERT INTO `material` VALUES ('3', '1', 'index_l001.png', '2014-05-11 09:05:52');
INSERT INTO `material` VALUES ('4', '1', 'logo.png', '2014-05-11 10:10:36');
INSERT INTO `material` VALUES ('5', '1', 'index_l002.png', '2014-05-11 10:10:47');
INSERT INTO `material` VALUES ('6', '1', 'index_l003.png', '2014-05-11 10:10:52');
INSERT INTO `material` VALUES ('7', '1', 'index_r001.png', '2014-05-11 10:10:56');
INSERT INTO `material` VALUES ('8', '1', 'index_r002.png', '2014-05-11 10:10:59');
INSERT INTO `material` VALUES ('9', '1', 'index_mxtp05.png', '2014-05-11 10:11:04');
INSERT INTO `material` VALUES ('10', '1', 'index_mxtp03.png', '2014-05-11 10:11:09');
INSERT INTO `material` VALUES ('11', '1', 'index_mxtp02.png', '2014-05-11 10:11:12');
INSERT INTO `material` VALUES ('12', '1', 'index_mxtp06.png', '2014-05-11 10:11:15');
INSERT INTO `material` VALUES ('13', '76', 'index_r001.png', '2014-05-11 10:14:20');
INSERT INTO `material` VALUES ('14', '76', 'index_tpx02.png', '2014-05-11 10:14:23');
INSERT INTO `material` VALUES ('15', '76', 'index_xwtp1.png', '2014-05-11 10:14:28');
INSERT INTO `material` VALUES ('16', '76', 'index_tpx01.png', '2014-05-11 10:14:30');
INSERT INTO `material` VALUES ('17', '76', 'head.png', '2014-05-11 10:14:33');
INSERT INTO `material` VALUES ('18', '76', 'index_l001.png', '2014-05-11 10:14:35');
INSERT INTO `material` VALUES ('19', '76', 'index_l003.png', '2014-05-11 10:14:40');
INSERT INTO `material` VALUES ('20', '76', 'index_l002.png', '2014-05-11 10:14:44');
INSERT INTO `material` VALUES ('21', '76', 'index_mxtp01.png', '2014-05-11 10:14:47');
INSERT INTO `material` VALUES ('22', '76', 'index_mxtp02.png', '2014-05-11 10:14:48');
INSERT INTO `material` VALUES ('23', '76', 'index_mxtp04.png', '2014-05-11 10:14:50');
INSERT INTO `material` VALUES ('24', '76', 'index_mxtp05.png', '2014-05-11 10:14:54');
INSERT INTO `material` VALUES ('25', '76', 'index_mxtp03.png', '2014-05-11 10:15:01');
INSERT INTO `material` VALUES ('26', '76', 'index_mxtp07.png', '2014-05-11 10:15:06');
INSERT INTO `material` VALUES ('27', '1', 'dot_03.png', '2014-05-22 14:59:19');
INSERT INTO `material` VALUES ('28', '1', 'index_xwtp1.png', '2014-05-24 19:04:55');

-- ----------------------------
-- Table structure for `message_data`
-- ----------------------------
DROP TABLE IF EXISTS `message_data`;
CREATE TABLE `message_data` (
  `md_Id` int(11) NOT NULL auto_increment,
  `message_id` text NOT NULL,
  `content` text NOT NULL,
  `time` datetime NOT NULL,
  `sendPlace` varchar(50) NOT NULL,
  `stId` int(11) NOT NULL,
  `from_uId` int(11) NOT NULL,
  `to_uId` int(11) NOT NULL,
  `type` tinyint(4) default '0',
  `related_id` int(11) default '0',
  PRIMARY KEY  (`md_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message_data
-- ----------------------------
INSERT INTO `message_data` VALUES ('1', '1400915211_1_76', '新1新1新1新1新1新1新1新1新1新1新1新1新1新1新1新1新1', '2014-05-24 07:06:51', '', '0', '1', '76', '0', '0');
INSERT INTO `message_data` VALUES ('2', '1400915268_1_76', '新2新2新2新2新2新2', '2014-05-24 07:07:48', '', '0', '1', '76', '0', '0');
INSERT INTO `message_data` VALUES ('3', '1400915418_1_76', '新3新3新3新3新3新3新3新3新3新3新3新3新3新3新3新3新3新3', '2014-05-24 07:10:18', '', '0', '1', '76', '0', '0');
INSERT INTO `message_data` VALUES ('4', '1400915481_1_76', '新4新4新4新4新4新4新4新4新4新4新4新4新4', '2014-05-24 07:11:21', '', '0', '1', '76', '0', '0');
INSERT INTO `message_data` VALUES ('5', '1400915546_1_76', '新5新5新5新5新5新5新5新5新5新5新5新5', '2014-05-24 07:12:26', '', '0', '1', '76', '0', '0');
INSERT INTO `message_data` VALUES ('6', '1400915995_76_1', '新6新6新6新6', '2014-05-24 07:19:55', '', '11', '76', '1', '0', '0');
INSERT INTO `message_data` VALUES ('7', '1400917747_76_1', '新7新7新7新7新7新7新7新7新7新7新7新7新7', '2014-05-24 07:49:07', '', '11', '76', '1', '0', '0');
INSERT INTO `message_data` VALUES ('8', '1400918118_76_1', '新8新8新8新8新8新8新8新8新8新8新8新8新8新8', '2014-05-24 07:55:18', '', '11', '76', '1', '0', '0');
INSERT INTO `message_data` VALUES ('9', '1400918208_1_76', '新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9新9', '2014-05-24 07:56:48', '', '11', '1', '76', '1', '17');

-- ----------------------------
-- Table structure for `message_inbox`
-- ----------------------------
DROP TABLE IF EXISTS `message_inbox`;
CREATE TABLE `message_inbox` (
  `message_id` int(11) NOT NULL auto_increment,
  `from_user_id` int(11) default NULL,
  `to_user_id` int(11) default NULL,
  `message_type` int(11) default NULL,
  `subject` text,
  `data_id` int(11) default NULL,
  `last_data_id` int(11) default NULL,
  `is_read` int(11) default NULL,
  `time` datetime default NULL,
  PRIMARY KEY  (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=423 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message_inbox
-- ----------------------------

-- ----------------------------
-- Table structure for `message_manage`
-- ----------------------------
DROP TABLE IF EXISTS `message_manage`;
CREATE TABLE `message_manage` (
  `mm_Id` int(11) NOT NULL auto_increment,
  `message_id` text NOT NULL,
  `from_uId` int(11) NOT NULL,
  `to_uId` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `title` text NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  PRIMARY KEY  (`mm_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message_manage
-- ----------------------------
INSERT INTO `message_manage` VALUES ('1', '1400915211_1_76', '1', '76', '2014-05-24 07:06:51', '新1', '0');
INSERT INTO `message_manage` VALUES ('2', '1400915268_1_76', '1', '76', '2014-05-24 07:07:48', '新2', '0');
INSERT INTO `message_manage` VALUES ('3', '1400915418_1_76', '1', '76', '2014-05-24 07:10:18', '新3', '1');
INSERT INTO `message_manage` VALUES ('4', '1400915481_1_76', '1', '76', '2014-05-24 07:11:21', '新4', '0');
INSERT INTO `message_manage` VALUES ('5', '1400915546_1_76', '1', '76', '2014-05-24 07:12:26', '新5', '1');
INSERT INTO `message_manage` VALUES ('6', '1400915995_76_1', '76', '1', '2014-05-24 07:19:55', '新6', '0');
INSERT INTO `message_manage` VALUES ('7', '1400917747_76_1', '76', '1', '2014-05-24 07:49:07', '新7', '1');
INSERT INTO `message_manage` VALUES ('8', '1400918118_76_1', '76', '1', '2014-05-24 07:55:18', '新8', '0');
INSERT INTO `message_manage` VALUES ('9', '1400918208_1_76', '1', '76', '2014-05-24 07:56:48', '新9', '0');

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `ID` int(11) NOT NULL auto_increment,
  `type` tinyint(4) default NULL,
  `createdate` datetime default NULL,
  `source` varchar(255) default NULL,
  `author` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `content` text,
  `viewnum` int(11) default '0',
  `pic` varchar(255) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', '1', '2014-05-15 14:35:28', '人民网', '小溪', '红蓝黄绿基本色 缤纷春夏男装魅力', '春夏穿衣的关键词，非高彩度的流行单品莫属。此次红，黄，蓝，绿四大重点。夏季运动服装更显时尚魅力。 ', '0', 'index_tpx01.png');

-- ----------------------------
-- Table structure for `node`
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `nId` int(11) NOT NULL auto_increment,
  `text` text,
  `ntId` int(11) NOT NULL,
  `langCode` varchar(10) default NULL,
  `time` datetime default NULL,
  `stId` int(11) NOT NULL,
  `sendPlace` varchar(50) default NULL,
  `uId` int(11) default NULL,
  `modify_time` int(11) NOT NULL,
  PRIMARY KEY  (`nId`),
  KEY `uId` (`uId`),
  FULLTEXT KEY `text` (`text`),
  FULLTEXT KEY `text_2` (`text`)
) ENGINE=MyISAM AUTO_INCREMENT=2853 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of node
-- ----------------------------
INSERT INTO `node` VALUES ('2847', 'what is kwapro?', '1', '', '2013-08-30 11:40:33', '11', '', '1', '0');
INSERT INTO `node` VALUES ('2848', '百度', '1', 'zh', '2014-04-11 11:18:38', '11', '-', '1', '0');
INSERT INTO `node` VALUES ('2849', '施恩啊', '1', 'zh', '2014-04-11 12:15:42', '11', '-', '1', '1397218557');
INSERT INTO `node` VALUES ('2850', '阿萨德飞', '2', '', '2014-04-11 12:16:20', '11', '-', '1', '0');
INSERT INTO `node` VALUES ('2851', '22', '2', 'en', '2014-04-11 12:18:43', '11', '-', '1', '0');
INSERT INTO `node` VALUES ('2852', '的阿德福韦酯', '4', 'zh', '2014-04-11 12:24:05', '11', '-', '1', '0');

-- ----------------------------
-- Table structure for `node_relation`
-- ----------------------------
DROP TABLE IF EXISTS `node_relation`;
CREATE TABLE `node_relation` (
  `nrId` int(11) NOT NULL auto_increment,
  `nFromId` int(11) NOT NULL,
  `nToId` int(11) NOT NULL,
  `ntId` int(11) NOT NULL,
  `vote_num` int(11) NOT NULL,
  PRIMARY KEY  (`nrId`)
) ENGINE=MyISAM AUTO_INCREMENT=1189 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of node_relation
-- ----------------------------
INSERT INTO `node_relation` VALUES ('1186', '2850', '2849', '2', '0');
INSERT INTO `node_relation` VALUES ('1187', '2851', '2848', '2', '0');
INSERT INTO `node_relation` VALUES ('1188', '2852', '2851', '4', '0');

-- ----------------------------
-- Table structure for `question`
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `qId` int(11) NOT NULL auto_increment,
  `nId` int(11) NOT NULL,
  `question_score` int(11) NOT NULL,
  `question_answer_num` int(11) NOT NULL default '0',
  `question_follow_num` int(11) NOT NULL default '0',
  `question_view_num` int(11) NOT NULL,
  `question_participant_num` int(11) NOT NULL default '0',
  `question_expire_time` datetime NOT NULL,
  `question_stat_id` int(11) NOT NULL default '1',
  PRIMARY KEY  (`qId`)
) ENGINE=MyISAM AUTO_INCREMENT=1389 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('1386', '2847', '0', '0', '0', '2', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `question` VALUES ('1387', '2848', '0', '0', '1', '15', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `question` VALUES ('1388', '2849', '0', '0', '0', '1', '0', '0000-00-00 00:00:00', '1');

-- ----------------------------
-- Table structure for `questiontags`
-- ----------------------------
DROP TABLE IF EXISTS `questiontags`;
CREATE TABLE `questiontags` (
  `qtId` int(11) NOT NULL auto_increment,
  `tags` varchar(200) NOT NULL,
  `nId` int(11) NOT NULL,
  PRIMARY KEY  (`qtId`)
) ENGINE=MyISAM AUTO_INCREMENT=1387 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of questiontags
-- ----------------------------
INSERT INTO `questiontags` VALUES ('1384', 'what is kwapro?', '2847');
INSERT INTO `questiontags` VALUES ('1385', '百度', '2848');
INSERT INTO `questiontags` VALUES ('1386', '施恩', '2849');

-- ----------------------------
-- Table structure for `question_collect`
-- ----------------------------
DROP TABLE IF EXISTS `question_collect`;
CREATE TABLE `question_collect` (
  `qcId` int(11) NOT NULL auto_increment,
  `nId` int(11) NOT NULL,
  `uId` int(11) NOT NULL,
  `time` datetime default NULL,
  `qctId` int(11) NOT NULL,
  PRIMARY KEY  (`qcId`)
) ENGINE=MyISAM AUTO_INCREMENT=283 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question_collect
-- ----------------------------
INSERT INTO `question_collect` VALUES ('282', '2848', '1', '2014-04-11 12:24:23', '111');

-- ----------------------------
-- Table structure for `question_quick_answer`
-- ----------------------------
DROP TABLE IF EXISTS `question_quick_answer`;
CREATE TABLE `question_quick_answer` (
  `qaId` int(11) NOT NULL auto_increment,
  `nId` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`qaId`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question_quick_answer
-- ----------------------------

-- ----------------------------
-- Table structure for `question_summary`
-- ----------------------------
DROP TABLE IF EXISTS `question_summary`;
CREATE TABLE `question_summary` (
  `sId` int(11) NOT NULL auto_increment,
  `nId` int(11) NOT NULL,
  `text` text NOT NULL,
  `langCode` varchar(10) NOT NULL,
  `uId` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY  (`sId`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question_summary
-- ----------------------------
INSERT INTO `question_summary` VALUES ('17', '2848', '23', 'en', '1', '2014-04-11 12:21:44', '0');
INSERT INTO `question_summary` VALUES ('18', '2848', '23看', 'zh', '1', '2014-04-11 12:22:10', '0');

-- ----------------------------
-- Table structure for `sendtype`
-- ----------------------------
DROP TABLE IF EXISTS `sendtype`;
CREATE TABLE `sendtype` (
  `stId` int(11) NOT NULL auto_increment,
  `stText` varchar(50) default NULL,
  PRIMARY KEY  (`stId`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sendtype
-- ----------------------------
INSERT INTO `sendtype` VALUES ('11', 'online');
INSERT INTO `sendtype` VALUES ('12', 'email');
INSERT INTO `sendtype` VALUES ('13', 'gtalk');
INSERT INTO `sendtype` VALUES ('14', 'sms');
INSERT INTO `sendtype` VALUES ('15', 'qq');
INSERT INTO `sendtype` VALUES ('16', 'msn');

-- ----------------------------
-- Table structure for `sendtype4user`
-- ----------------------------
DROP TABLE IF EXISTS `sendtype4user`;
CREATE TABLE `sendtype4user` (
  `suId` int(11) NOT NULL auto_increment,
  `uId` int(11) NOT NULL,
  `stId` int(11) NOT NULL,
  PRIMARY KEY  (`suId`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sendtype4user
-- ----------------------------
INSERT INTO `sendtype4user` VALUES ('89', '1', '12');
INSERT INTO `sendtype4user` VALUES ('95', '76', '12');

-- ----------------------------
-- Table structure for `tag`
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL auto_increment,
  `sub_cate_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  `langCode` varchar(20) NOT NULL,
  `count` int(11) NOT NULL default '0',
  `add_flag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`tag_id`),
  KEY `tag_name` (`tag_name`)
) ENGINE=MyISAM AUTO_INCREMENT=340213 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uId` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `langCode` varchar(10) NOT NULL,
  `gender` int(11) NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `permission` int(11) NOT NULL default '0',
  PRIMARY KEY  (`uId`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'test', 'e10adc3949ba59abbe56e057f20f883e', 'test@gmail.com', 'zh', '1', '1980-01-01', '1');
INSERT INTO `user` VALUES ('76', 'heeh', 'e10adc3949ba59abbe56e057f20f883e', 'dawan-252288924@163.com', '', '0', '', '0');

-- ----------------------------
-- Table structure for `useraccount`
-- ----------------------------
DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE `useraccount` (
  `uaId` int(11) NOT NULL auto_increment,
  `uId` int(11) NOT NULL,
  `account` varchar(50) default NULL,
  `stId` int(11) NOT NULL,
  `is_visible` int(11) default NULL,
  PRIMARY KEY  (`uaId`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of useraccount
-- ----------------------------
INSERT INTO `useraccount` VALUES ('87', '1', 'test@gmail.com', '12', null);
INSERT INTO `useraccount` VALUES ('94', '76', 'dawan-252288924@163.com', '12', null);

-- ----------------------------
-- Table structure for `useractivity`
-- ----------------------------
DROP TABLE IF EXISTS `useractivity`;
CREATE TABLE `useractivity` (
  `uatId` int(11) NOT NULL auto_increment,
  `ntId` int(11) default NULL,
  `num` int(11) default NULL,
  `uId` int(11) default NULL,
  PRIMARY KEY  (`uatId`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of useractivity
-- ----------------------------
INSERT INTO `useractivity` VALUES ('131', '1', '1', '1');
INSERT INTO `useractivity` VALUES ('132', '111', '1', '1');

-- ----------------------------
-- Table structure for `user_friends`
-- ----------------------------
DROP TABLE IF EXISTS `user_friends`;
CREATE TABLE `user_friends` (
  `ufId` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `friend_uId` int(11) default NULL,
  PRIMARY KEY  (`ufId`)
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_friends
-- ----------------------------
INSERT INTO `user_friends` VALUES ('145', '76', '0');
INSERT INTO `user_friends` VALUES ('146', '0', '76');

-- ----------------------------
-- Table structure for `user_photo`
-- ----------------------------
DROP TABLE IF EXISTS `user_photo`;
CREATE TABLE `user_photo` (
  `uId` int(11) NOT NULL default '0',
  `photo_name` varchar(100) NOT NULL default '',
  `photo_type` int(11) NOT NULL,
  PRIMARY KEY  (`uId`,`photo_name`,`photo_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_photo
-- ----------------------------

-- ----------------------------
-- Table structure for `user_privacy`
-- ----------------------------
DROP TABLE IF EXISTS `user_privacy`;
CREATE TABLE `user_privacy` (
  `upId` int(11) NOT NULL auto_increment,
  `uId` int(11) NOT NULL,
  `ptId` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`upId`)
) ENGINE=MyISAM AUTO_INCREMENT=313 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_privacy
-- ----------------------------
INSERT INTO `user_privacy` VALUES ('1', '1', '1', '0');
INSERT INTO `user_privacy` VALUES ('2', '1', '2', '1');
INSERT INTO `user_privacy` VALUES ('3', '1', '3', '1');
INSERT INTO `user_privacy` VALUES ('4', '1', '12', '1');
INSERT INTO `user_privacy` VALUES ('5', '1', '13', '1');
INSERT INTO `user_privacy` VALUES ('6', '1', '14', '0');
INSERT INTO `user_privacy` VALUES ('7', '1', '15', '1');
INSERT INTO `user_privacy` VALUES ('8', '1', '16', '0');
INSERT INTO `user_privacy` VALUES ('305', '76', '1', '1');
INSERT INTO `user_privacy` VALUES ('306', '76', '2', '1');
INSERT INTO `user_privacy` VALUES ('307', '76', '3', '1');
INSERT INTO `user_privacy` VALUES ('308', '76', '12', '1');
INSERT INTO `user_privacy` VALUES ('309', '76', '13', '1');
INSERT INTO `user_privacy` VALUES ('310', '76', '14', '1');
INSERT INTO `user_privacy` VALUES ('311', '76', '15', '1');
INSERT INTO `user_privacy` VALUES ('312', '76', '16', '1');

-- ----------------------------
-- Table structure for `user_rss_message`
-- ----------------------------
DROP TABLE IF EXISTS `user_rss_message`;
CREATE TABLE `user_rss_message` (
  `uId` int(11) NOT NULL,
  `rcv_rss` tinyint(1) NOT NULL,
  PRIMARY KEY  (`uId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_rss_message
-- ----------------------------
INSERT INTO `user_rss_message` VALUES ('76', '1');

-- ----------------------------
-- Table structure for `user_rss_message_copy`
-- ----------------------------
DROP TABLE IF EXISTS `user_rss_message_copy`;
CREATE TABLE `user_rss_message_copy` (
  `uId` int(11) NOT NULL,
  `rcv_rss` tinyint(1) NOT NULL,
  PRIMARY KEY  (`uId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_rss_message_copy
-- ----------------------------
INSERT INTO `user_rss_message_copy` VALUES ('70', '1');

-- ----------------------------
-- Table structure for `user_score`
-- ----------------------------
DROP TABLE IF EXISTS `user_score`;
CREATE TABLE `user_score` (
  `usId` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `score` int(11) default NULL,
  PRIMARY KEY  (`usId`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_score
-- ----------------------------
INSERT INTO `user_score` VALUES ('54', '76', '5');

-- ----------------------------
-- Table structure for `user_score_log`
-- ----------------------------
DROP TABLE IF EXISTS `user_score_log`;
CREATE TABLE `user_score_log` (
  `uslId` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `event` int(11) default NULL,
  `score_changed` int(11) default NULL,
  `score_left` int(11) default NULL,
  `time` datetime default NULL,
  PRIMARY KEY  (`uslId`)
) ENGINE=MyISAM AUTO_INCREMENT=2460 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_score_log
-- ----------------------------
INSERT INTO `user_score_log` VALUES ('2455', '1', '5', '2', '0', '2013-08-30 11:40:33');
INSERT INTO `user_score_log` VALUES ('2456', '75', '1', '5', '5', '2014-04-11 02:33:21');
INSERT INTO `user_score_log` VALUES ('2457', '0', '4', '20', '0', '2014-04-11 02:33:21');
INSERT INTO `user_score_log` VALUES ('2458', '76', '1', '5', '5', '2014-04-11 02:34:59');
INSERT INTO `user_score_log` VALUES ('2459', '0', '4', '20', '0', '2014-04-11 02:34:59');
