<?php

$q = array();

$q[] = 'CREATE TABLE `news`
        (
            `news_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `news_check` INT(1) DEFAULT 0,
            `news_country_id` INT(3) DEFAULT 0,
            `news_date` INT(11) DEFAULT 0,
            `news_text` TEXT,
            `news_title` VARCHAR(255),
            `news_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `news_check` ON `news` (`news_check`);';
$q[] = 'CREATE INDEX `news_country_id` ON `news` (`news_country_id`);';