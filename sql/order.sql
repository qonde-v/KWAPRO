/*
Navicat MySQL Data Transfer

Source Server         : kendi
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : tit

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2014-10-16 23:10:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `factory`
-- ----------------------------
DROP TABLE IF EXISTS `factory`;
CREATE TABLE `factory` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) default NULL,
  `address` varchar(255) default NULL,
  `contacts` varchar(50) default NULL,
  `tel` varchar(50) default NULL,
  `business` varchar(255) default NULL,
  `createTime` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of factory
-- ----------------------------
INSERT INTO `factory` VALUES ('2', '厂家名称', '地址', '凉席人', '123456', '  主要业务 主要业务 主要业务 主要业务', '2014-10-15 17:02:35');
INSERT INTO `factory` VALUES ('3', '宝宝', '宝宝', '宝宝', '123123', ' 1233333333333122', '2014-10-16 16:03:14');
INSERT INTO `factory` VALUES ('4', '测试', '测试', '测试', '43444344', ' 测试', '2014-10-16 17:13:31');

-- ----------------------------
-- Table structure for `order_status`
-- ----------------------------
DROP TABLE IF EXISTS `order_status`;
CREATE TABLE `order_status` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_status
-- ----------------------------
INSERT INTO `order_status` VALUES ('0', '订单已提交');
INSERT INTO `order_status` VALUES ('1', '订单已确认');
INSERT INTO `order_status` VALUES ('2', '制作中');
INSERT INTO `order_status` VALUES ('3', '制作完成');
INSERT INTO `order_status` VALUES ('4', '已寄出');
INSERT INTO `order_status` VALUES ('5', '订单完成');

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL auto_increment,
  `uId` int(11) default NULL,
  `username` varchar(255) default NULL,
  `realname` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `tel` varchar(255) default NULL,
  `design_id` int(11) default NULL,
  `createtime` datetime default NULL,
  `status` tinyint(4) default '0',
  `operator` varchar(255) default NULL,
  `confirmtime` datetime default NULL,
  `factory_id` int(11) default '0',
  `completetime` datetime default NULL,
  `posttime` datetime default NULL,
  `committime` datetime default NULL,
  `remark` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
