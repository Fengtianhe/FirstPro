set names utf8;
CREATE TABLE `zt_contact` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `subject` varchar(100) NOT NULL DEFAULT '' COMMENT '主题',
  `message` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户意见反馈';
