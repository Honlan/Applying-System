/*
 Navicat Premium Data Transfer

 Source Server         : myMac
 Source Server Type    : MySQL
 Source Server Version : 50538
 Source Host           : localhost
 Source Database       : cbi

 Target Server Type    : MySQL
 Target Server Version : 50538
 File Encoding         : utf-8

 Date: 08/04/2015 17:37:47 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `application`
-- ----------------------------
DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `admitted` int(1) NOT NULL DEFAULT '2',
  `timestamp` varchar(255) NOT NULL,
  `dealtime` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `application`
-- ----------------------------
BEGIN;
INSERT INTO `application` VALUES ('32', '疯狂过', '1232324', 'dsfddsf@qq.com', '但是奋斗', '但是奋斗多少', '0', '1438666686', '1438677895', ''), ('33', '父母给你', '2357900', 'asdllgopf@qq.com', '个', '钢管舞', '0', '1438666707', '1438677889', ''), ('34', '美国呢', '1239417', 'fkasfk821@qq.com', '萨法', '奋斗时光', '1', '1438666724', '1438677863', ''), ('35', '张宏伦', '13262669093', '493722771@qq.com', '上海交通大学', '博士生', '1', '1438666750', '1438679789', '14386797895034736825'), ('36', 'dassad', 'dasdsda', '13213@qq.com', 'asdasd', 'asdassd', '0', '1438668707', '1438678216', ''), ('37', '42141441242', 'asdsada', '112331@qq.com', 'dasddsd', 'asddffaf', '0', '1438668826', '1438678251', ''), ('38', '张宏伦', '1234124', 'zhanghonglun@sjtu.edu.cn', 'sjtu', 'sdasda', '1', '1438670471', '1438679788', '14386797874096005554'), ('39', '添加', '123241', '2313@qq.com', 'asdsa', 'dsgsdfsf', '0', '1438677947', '1438678246', '');
COMMIT;

-- ----------------------------
--  Table structure for `email`
-- ----------------------------
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admitTitle` text NOT NULL,
  `admitContent` text NOT NULL,
  `refuseTitle` text NOT NULL,
  `refuseContent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `email`
-- ----------------------------
BEGIN;
INSERT INTO `email` VALUES ('1', '报名审核通过', '您的报名审核已经通过\r\n请下载您的身份信息二维码\r\n并在活动当前签到使用', '报名审核未通过', '不好意思\r\n您的报名审核没有通过');
COMMIT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'admin', '81dc9bdb52d04dc20036dbd8313ed055');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
