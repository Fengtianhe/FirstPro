/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.6.11 : Database - zt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zt` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `zt`;

/*Table structure for table `zt_category` */

DROP TABLE IF EXISTS `zt_category`;

CREATE TABLE `zt_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL COMMENT '父亲',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分类';

/*Data for the table `zt_category` */

insert  into `zt_category`(`id`,`name`,`pid`) values (1,'生活用品',0),(2,'电子数码',0),(3,'辅助教材',0);

/*Table structure for table `zt_content` */

DROP TABLE IF EXISTS `zt_content`;

CREATE TABLE `zt_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL COMMENT '所属条目id',
  `content` text CHARACTER SET utf8mb4 NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='内容';

/*Data for the table `zt_content` */

insert  into `zt_content`(`id`,`news_id`,`content`) values (5,5,'&lt;p&gt;阿什顿飞大&lt;span style=&quot;text-decoration: underline;&quot;&gt;水法的说法&lt;/span&gt;&lt;br/&gt;&lt;/p&gt;');

/*Table structure for table `zt_news` */

DROP TABLE IF EXISTS `zt_news`;

CREATE TABLE `zt_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `keyword` varchar(50) NOT NULL COMMENT '关键字',
  `description` varchar(200) NOT NULL COMMENT '描述',
  `price` int(11) NOT NULL COMMENT '价格（单位：分）',
  `img` varchar(100) NOT NULL COMMENT '主图',
  `category_id` int(11) NOT NULL COMMENT '分类id',
  `neworold` int(1) NOT NULL DEFAULT '0' COMMENT '新旧程度 0:少于五成新',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `show_count` int(11) NOT NULL COMMENT '浏览次数',
  `is_top` int(1) NOT NULL COMMENT '置顶',
  `is_del` int(1) NOT NULL COMMENT '删除',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updated` int(11) NOT NULL COMMENT '更改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='发布内容';

/*Data for the table `zt_news` */

insert  into `zt_news`(`id`,`title`,`keyword`,`description`,`price`,`img`,`category_id`,`neworold`,`user_id`,`show_count`,`is_top`,`is_del`,`created`,`updated`) values (5,'123','桌子,木头','温柔啊地方',13,'',1,9,1,0,0,0,1444225890,0);

/*Table structure for table `zt_user` */

DROP TABLE IF EXISTS `zt_user`;

CREATE TABLE `zt_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '0' COMMENT '邮件地址',
  `password` varchar(100) NOT NULL DEFAULT '0' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '0' COMMENT '昵称',
  `phone` int(11) NOT NULL DEFAULT '0' COMMENT '电话',
  `class` varchar(50) NOT NULL DEFAULT '0' COMMENT '班级',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `lastlogintime` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户表';

/*Data for the table `zt_user` */

insert  into `zt_user`(`id`,`email`,`password`,`nickname`,`phone`,`class`,`status`,`lastlogintime`,`created`,`updated`) values (4,'1977905246@qq.com','62c8ad0a15d9d1ca38d5dee762a16e01','0',0,'0',0,0,1444227754,0),(3,'1977905246@qq.com','46f94c8de14fb36680850768ff1b7f2a','0',0,'0',0,0,0,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
