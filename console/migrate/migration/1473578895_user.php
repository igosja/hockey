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
            `user_holiday` TINYINT(1) DEFAULT 0,
            `user_holiday_day` TINYINT(2) DEFAULT 0,
            `user_login` VARCHAR(255) NOT NULL,
            `user_money` DECIMAL(7,2) DEFAULT 0,
            `user_name` VARCHAR(255) NOT NULL,
            `user_password` CHAR(32) NOT NULL,
            `user_referrer_id` INT(11) DEFAULT 0,
            `user_sex_id` TINYINT(1) DEFAULT 1,
            `user_social_facebook` VARCHAR(255) NOT NULL,
            `user_social_google` VARCHAR(255) NOT NULL,
            `user_social_vk` VARCHAR(255) NOT NULL,
            `user_surname` VARCHAR(255) NOT NULL,
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
$q[] = "INSERT INTO `user`
        SET `user_code`='13373e3c14aa77368437c7c972601d70',
            `user_date_confirm`='1473706009',
            `user_date_register`='1473705854',
            `user_email`='igosja@ukr.net',
            `user_login`='igosja',
            `user_password`='8fa914dc4a270abfc2a4561228770426',
            `user_userrole_id`='10'";
$q[] = "INSERT INTO `user`
        SET `user_code`='f296a47aebb6b66620d44652a59db37a',
            `user_date_confirm`='0',
            `user_date_login`='1475246417',
            `user_date_register`='1475246304',
            `user_email`='fanat16rus@yandex.ru',
            `user_login`='Fanat16Rus',
            `user_password`='42f807e146b7db018c9560ea179535b6'";
$q[] = "INSERT INTO `user`
        SET `user_code`='883a889016dafef5c1c17d4227988ae1',
            `user_date_confirm`='0',
            `user_date_login`='1476722772',
            `user_date_register`='1475945760',
            `user_email`='pavel87desant38@gmail.com',
            `user_login`='Fanfar',
            `user_password`='6cee822c8723d6ff4c6470fbf66ed096'";