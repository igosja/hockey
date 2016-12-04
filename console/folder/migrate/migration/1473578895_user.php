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
            `user_surname` VARCHAR(255) NOT NULL,
            `user_userrole_id` TINYINT(1) DEFAULT 1
        );';
$q[] = "INSERT INTO `user`
        SET `user_code`='13373e3c14aa77368437c7c972601d70',
            `user_date_confirm`='1473706009',
            `user_date_register`='1473705854',
            `user_email`='igosja@ukr.net',
            `user_login`='igosja',
            `user_password`='8fa914dc4a270abfc2a4561228770426',
            `user_userrole_id`='3'";