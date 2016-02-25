ALTER TABLE `zt_contact` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT; 
ALTER TABLE `zt_contact` CHANGE `status` `status` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '0:正常 1：已回复 2：标记异常'; 