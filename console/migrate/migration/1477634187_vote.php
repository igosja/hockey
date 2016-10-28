<?php

$q = array();

$q[] = 'CREATE TABLE `vote`
        (
            `vote_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `vote_country_id` SMALLINT(3) DEFAULT 0,
            `vote_date` INT(11) DEFAULT 0,
            `vote_text` TEXT NOT NULL,
            `vote_user_id` INT(11) DEFAULT 0,
            `vote_votestatus_id` TINYINT(1) DEFAULT 1
        );';
$q[] = 'CREATE INDEX `vote_country_id` ON `vote` (`vote_country_id`);';
$q[] = 'CREATE INDEX `vote_user_id` ON `vote` (`vote_user_id`);';
$q[] = 'CREATE INDEX `vote_votestatus_id` ON `vote` (`vote_votestatus_id`);';