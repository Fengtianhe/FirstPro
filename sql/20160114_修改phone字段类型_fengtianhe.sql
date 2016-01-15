ALTER TABLE `zt_user` CHANGE `phone` `phone` VARCHAR( 11 ) NOT NULL DEFAULT '0' COMMENT '电话';

/*不重 zt_news 表 phone字段 也同时修改 */
ALTER TABLE `zt_news` CHANGE `phone` `phone` VARCHAR(11) DEFAULT '' NOT NULL COMMENT '联系人电话'; 