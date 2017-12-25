<?php

$q = array();

$q[] = 'CREATE TABLE `ratingchangeplayer`
        (
            `ratingchangeplayer_player_id` INT(11) DEFAULT 0,
            `ratingchangeplayer_power` INT(3) DEFAULT 0,
            `ratingchangeplayer_schedule_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `ratingchangeplayer_player_id` ON `ratingchangeplayer` (`ratingchangeplayer_player_id`)';
$q[] = 'CREATE INDEX `ratingchangeplayer_schedule_id` ON `ratingchangeplayer` (`ratingchangeplayer_schedule_id`)';