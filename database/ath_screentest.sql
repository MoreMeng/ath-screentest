/*
Navicat MySQL Data Transfer

Source Server         : @LOCALHOST
Source Server Version : 50714
Source Host           : 127.0.0.1:3306
Source Database       : ath_intranet

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-09-14 17:08:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ath_screentest
-- ----------------------------
DROP TABLE IF EXISTS `ath_screentest`;
CREATE TABLE `ath_screentest` (
  `st_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `st_name` varchar(255) DEFAULT NULL,
  `st_section_id` tinyint(3) DEFAULT NULL,
  `st_monitor` varchar(255) DEFAULT NULL,
  `st_ip_address` varchar(15) DEFAULT NULL,
  `st_date` datetime NOT NULL,
  `st_score` int(1) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
