-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 12 月 10 日 10:42
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
-- 表的结构 `zt_university_all`
--

CREATE TABLE IF NOT EXISTS `zt_university_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `s_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='学校列表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `zt_university_all`
--

INSERT INTO `zt_university_all` (`id`, `province`, `city`, `s_name`) VALUES
(1, '吉林省', '吉林市', '北华大学'),
(2, '吉林省', '吉林市', '东北电力大学'),
(3, '吉林省', '长春市', '吉林大学'),
(4, '辽宁省', '沈阳市', '东北大学');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
