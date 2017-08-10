<?php

$q = array();

$q[] = 'CREATE TABLE `newscomment`
        (
            `newscomment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `newscomment_date` INT(11) DEFAULT 0,
            `newscomment_news_id` INT(11) DEFAULT 0,
            `newscomment_text` TEXT NOT NULL,
            `newscomment_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `newscomment_news_id` ON `newscomment` (`newscomment_news_id`);';