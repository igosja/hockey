<?php

$q = array();

$q[] = 'CREATE TABLE `gamecomment`
        (
            `gamecomment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `gamecomment_check` INT(1) DEFAULT 0,
            `gamecomment_date` INT(11) DEFAULT 0,
            `gamecomment_game_id` INT(11) DEFAULT 0,
            `gamecomment_text` TEXT,
            `gamecomment_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `gamecomment_check` ON `gamecomment` (`gamecomment_check`);';
$q[] = 'CREATE INDEX `gamecomment_game_id` ON `gamecomment` (`gamecomment_game_id`);';