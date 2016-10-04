<?php

$q = array();

$q[] = 'CREATE TABLE `user`
        (
            `user_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `user_birth_day` TINYINT(2) DEFAULT 0,
            `user_birth_month` TINYINT(2) DEFAULT 0,
            `user_birth_year` SMALLINT(4) DEFAULT 0,
            `user_city` VARCHAR(255) NOT NULL,
            `user_code` CHAR(32) NOT NULL,
            `user_country_id` SMALLINT(3) DEFAULT 0,
            `user_date_confirm` INT(11) DEFAULT 0,
            `user_date_holiday` INT(11) DEFAULT 0,
            `user_date_login` INT(11) DEFAULT 0,
            `user_date_register` INT(11) DEFAULT 0,
            `user_date_vip` INT(11) DEFAULT 0,
            `user_email` VARCHAR(255) NOT NULL,
            `user_finance` INT(11) DEFAULT 0,
            `user_login` VARCHAR(255) NOT NULL,
            `user_money` DECIMAL(7,2) DEFAULT 0,
            `user_holiday` TINYINT(1) DEFAULT 0,
            `user_holiday_day` TINYINT(2) DEFAULT 0,
            `user_password` CHAR(32) NOT NULL,
            `user_referrer_id` INT(11) DEFAULT 0,
            `user_sex_id` TINYINT(1) DEFAULT 1,
            `user_social_facebook` VARCHAR(255) NOT NULL,
            `user_social_google` VARCHAR(255) NOT NULL,
            `user_social_vk` VARCHAR(255) NOT NULL,
            `user_userrole_id` TINYINT(1) DEFAULT 1
        );';
$q[] = 'CREATE INDEX `user_code` ON `user` (`user_code`);';
$q[] = 'CREATE INDEX `user_country_id` ON `user` (`user_country_id`);';
$q[] = 'CREATE UNIQUE INDEX `user_email` ON `user` (`user_email`);';
$q[] = 'CREATE UNIQUE INDEX `user_login` ON `user` (`user_login`);';
$q[] = 'CREATE INDEX `user_referrer_id` ON `user` (`user_referrer_id`);';
$q[] = 'CREATE INDEX `user_sex_id` ON `user` (`user_sex_id`);';
$q[] = 'CREATE INDEX `user_social_facebook` ON `user` (`user_social_facebook`);';
$q[] = 'CREATE INDEX `user_social_google` ON `user` (`user_social_google`);';
$q[] = 'CREATE INDEX `user_social_vk` ON `user` (`user_social_vk`);';
$q[] = 'CREATE INDEX `user_userrole_id` ON `user` (`user_userrole_id`);';