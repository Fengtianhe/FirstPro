-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 01 月 13 日 14:27
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
-- 表的结构 `zt_province`
--

CREATE TABLE IF NOT EXISTS `zt_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provinceid` int(11) NOT NULL,
  `province` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `zt_province`
--

INSERT INTO `zt_province` (`id`, `provinceid`, `province`) VALUES
(1, 110000, '北京市'),
(2, 120000, '天津市'),
(3, 130000, '河北省'),
(4, 140000, '山西省'),
(5, 150000, '内蒙古自治区'),
(6, 210000, '辽宁省'),
(7, 220000, '吉林省'),
(8, 230000, '黑龙江省'),
(9, 310000, '上海市'),
(10, 320000, '江苏省'),
(11, 330000, '浙江省'),
(12, 340000, '安徽省'),
(13, 350000, '福建省'),
(14, 360000, '江西省'),
(15, 370000, '山东省'),
(16, 410000, '河南省'),
(17, 420000, '湖北省'),
(18, 430000, '湖南省'),
(19, 440000, '广东省'),
(20, 450000, '广西壮族自治区'),
(21, 460000, '海南省'),
(22, 500000, '重庆市'),
(23, 510000, '四川省'),
(24, 520000, '贵州省'),
(25, 530000, '云南省'),
(26, 540000, '西藏自治区'),
(27, 610000, '陕西省'),
(28, 620000, '甘肃省'),
(29, 630000, '青海省'),
(30, 640000, '宁夏回族自治区'),
(31, 650000, '新疆维吾尔自治区'),
(32, 710000, '台湾省'),
(33, 810000, '香港特别行政区'),
(34, 820000, '澳门特别行政区');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
