<?php

$q = array();

$q[] = 'CREATE TABLE `news`
        (
            `news_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `news_country_id` SMALLINT(3) DEFAULT 0,
            `news_date` INT(11) DEFAULT 0,
            `news_text` TEXT NOT NULL,
            `news_title` VARCHAR(255) NOT NULL,
            `news_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `news_country_id` ON `news` (`news_country_id`);';
$q[] = 'CREATE INDEX `news_user_id` ON `news` (`news_user_id`);';