set names utf8;
ALTER TABLE zt_news ADD phone INT NOT NULL DEFAULT 0 COMMENT '联系人电话' AFTER show_count;
ALTER TABLE zt_news ADD relation_name INT NOT NULL DEFAULT 0 COMMENT '联系人姓名' AFTER phone;