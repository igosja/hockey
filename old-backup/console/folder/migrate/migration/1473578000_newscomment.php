<?php

$q = array();

$q[] = 'CREATE TABLE `newscomment`
        (
            `newscomment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `newscomment_check` INT(1) DEFAULT 0,
            `newscomment_date` INT(11) DEFAULT 0,
            `newscomment_news_id` INT(11) DEFAULT 0,
            `newscomment_text` TEXT,
            `newscomment_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `newscomment_check` ON `newscomment` (`newscomment_check`);';
$q[] = 'CREATE INDEX `newscomment_news_id` ON `newscomment` (`newscomment_news_id`);';