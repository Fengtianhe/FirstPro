set names utf8;
CREATE TABLE `zt_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `mark_result` varchar(200) NOT NULL DEFAULT '' COMMENT '详细原因',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '举报人id 匿名举报值为0',
  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT '0：未处理 1：已删除：2已封号',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `handle_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
