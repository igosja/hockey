<?php

$q = array();

$q[] = 'CREATE TABLE `user`
        (
            `user_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `user_birth_day` INT(2) DEFAULT 0,
            `user_birth_month` INT(2) DEFAULT 0,
            `user_birth_year` INT(4) DEFAULT 0,
            `user_block_blockreason_id` VARCHAR(2),
            `user_block_comment_blockreason_id` INT(2) DEFAULT 0,
            `user_block_dealcomment_blockreason_id` INT(2) DEFAULT 0,
            `user_block_forum_blockreason_id` INT(2) DEFAULT 0,
            `user_block_gamecomment_blockreason_id` INT(2) DEFAULT 0,
            `user_block_newscomment_blockreason_id` INT(2) DEFAULT 0,
            `user_city` VARCHAR(255),
            `user_code` CHAR(32),
            `user_country_id` INT(3) DEFAULT 0,
            `user_countrynews_id` INT(11) DEFAULT 0,
            `user_date_block` INT(11) DEFAULT 0,
            `user_date_block_comment` INT(11) DEFAULT 0,
            `user_date_block_dealcomment` INT(11) DEFAULT 0,
            `user_date_block_forum` INT(11) DEFAULT 0,
            `user_date_block_gamecomment` INT(11) DEFAULT 0,
            `user_date_block_newscomment` INT(11) DEFAULT 0,
            `user_date_confirm` INT(11) DEFAULT 0,
            `user_date_holiday` INT(11) DEFAULT 0,
            `user_date_login` INT(11) DEFAULT 0,
            `user_date_register` INT(11) DEFAULT 0,
            `user_date_vip` INT(11) DEFAULT 0,
            `user_email` VARCHAR(255),
            `user_finance` INT(11) DEFAULT 0,
            `user_friendlystatus_id` INT(11) DEFAULT 2,
            `user_ip` CHAR(15),
            `user_holiday` INT(1) DEFAULT 0,
            `user_holiday_day` INT(2) DEFAULT 0,
            `user_login` VARCHAR(255),
            `user_money` DECIMAL(7,2) DEFAULT 0,
            `user_name` VARCHAR(255),
            `user_news_id` INT(11) DEFAULT 0,
            `user_password` CHAR(32),
            `user_rating` DECIMAL(6,2) DEFAULT 500,
            `user_referrer_done` INT(1) DEFAULT 0,
            `user_referrer_id` INT(11) DEFAULT 0,
            `user_sex_id` INT(1) DEFAULT 1,
            `user_shop_position` INT(3) DEFAULT 0,
            `user_shop_special` INT(3) DEFAULT 0,
            `user_shop_training` INT(3) DEFAULT 0,
            `user_surname` VARCHAR(255),
            `user_use_bb` INT(1) DEFAULT 1,
            `user_userrole_id` INT(1) DEFAULT 1
        );';
$q[] = "INSERT INTO `user`
        SET `user_code`='00000000000000000000000000000000',
            `user_date_confirm`=0,
            `user_date_register`=1473700000,
            `user_email`='info@vhol.org',
            `user_login`='Free team',
            `user_name`='Free',
            `user_password`='00000000000000000000000000000000',
            `user_surname`='team',
            `user_userrole_id`=1";
$q[] = "UPDATE `user`
        SET `user_id`=0
        WHERE `user_id`=1
        LIMIT 1";
$q[] = "ALTER TABLE `user` AUTO_INCREMENT=1";
$q[] = "INSERT INTO `user`
        SET `user_code`='13373e3c14aa77368437c7c972601d70',
            `user_date_confirm`=1473706009,
            `user_date_register`=1473705854,
            `user_email`='igosja@ukr.net',
            `user_login`='igosja',
            `user_password`='8fa914dc4a270abfc2a4561228770426',
            `user_userrole_id`=3";
$q[] = 'CREATE INDEX `user_code` ON `user` (`user_code`);';
$q[] = 'CREATE UNIQUE INDEX `user_email` ON `user` (`user_email`);';
$q[] = 'CREATE INDEX `user_holiday` ON `user` (`user_holiday`);';
$q[] = 'CREATE INDEX `user_referrer_id` ON `user` (`user_referrer_id`);';