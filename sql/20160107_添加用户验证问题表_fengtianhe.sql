-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 01 月 07 日 12:41
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
-- 表的结构 `zt_answer`
--

CREATE TABLE IF NOT EXISTS `zt_answer` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `atitle` text NOT NULL COMMENT '问题题目',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='注册问题表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `zt_answer`
--

INSERT INTO `zt_answer` (`aid`, `atitle`) VALUES
(1, '你的出生地'),
(2, '你的小学班主任'),
(3, '你的父亲姓名'),
(4, '你的母亲姓名');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
