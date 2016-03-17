-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 03 月 17 日 21:48
-- 服务器版本: 5.5.40
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zt`
--

-- --------------------------------------------------------

--
-- 表的结构 `zt_msg`
--

CREATE TABLE IF NOT EXISTS `zt_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `content` varchar(5000) NOT NULL COMMENT '正文',
  `reason` varchar(1000) DEFAULT NULL COMMENT '举报原因',
  `send_date` int(11) NOT NULL COMMENT '发送日期',
  `FCU` varchar(100) NOT NULL COMMENT '创建人',
  `LCU` varchar(100) NOT NULL COMMENT '收件人',
  `delete_tag` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1：未删除 -1：已删除',
  `read_status` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '-1：未读 1：已读',
  `msg_type` int(11) NOT NULL COMMENT '1:举报 2:收藏 3:管理员删除 4:管理员开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站内信' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
