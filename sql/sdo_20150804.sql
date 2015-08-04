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

 Date: 08/04/2015 15:43:51 PM
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `application`
-- ----------------------------
BEGIN;
INSERT INTO `application` VALUES ('32', '疯狂过', '1232324', 'dsfddsf@qq.com', '但是奋斗', '但是奋斗多少', '0', '1438666686', '1438666782'), ('33', '父母给你', '2357900', 'asdllgopf@qq.com', '个', '钢管舞', '1', '1438666707', '1438666789'), ('34', '美国呢', '1239417', 'fkasfk821@qq.com', '萨法', '奋斗时光', '1', '1438666724', '1438666759'), ('35', '张宏伦', '13262669093', '493722771@qq.com', '上海交通大学', '博士生', '2', '1438666750', ''), ('36', 'dassad', 'dasdsda', '13213@qq.com', 'asdasd', 'asdassd', '1', '1438668707', '1438668707'), ('37', '42141441242', 'asdsada', '112331@qq.com', 'dasddsd', 'asddffaf', '1', '1438668826', '1438668826'), ('38', '张宏伦', '1234124', 'zhanghonglun@sjtu.edu.cn', 'sjtu', 'sdasda', '1', '1438670471', '1438671158');
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
