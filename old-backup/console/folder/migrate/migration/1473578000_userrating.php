<?php

$q = array();

$q[] = 'CREATE TABLE `userrating`
        (
            `userrating_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `userrating_auto` INT(11) DEFAULT 0,
            `userrating_collision_loose` INT(11) DEFAULT 0,
            `userrating_collision_win` INT(11) DEFAULT 0,
            `userrating_game` INT(11) DEFAULT 0,
            `userrating_loose` INT(11) DEFAULT 0,
            `userrating_loose_equal` INT(11) DEFAULT 0,
            `userrating_loose_strong` INT(11) DEFAULT 0,
            `userrating_loose_super` INT(11) DEFAULT 0,
            `userrating_loose_weak` INT(11) DEFAULT 0,
            `userrating_looseover` INT(11) DEFAULT 0,
            `userrating_looseover_equal` INT(11) DEFAULT 0,
            `userrating_looseover_strong` INT(11) DEFAULT 0,
            `userrating_looseover_weak` INT(11) DEFAULT 0,
            `userrating_rating` DECIMAL(6,2) DEFAULT 0,
            `userrating_season_id` INT(5) DEFAULT 0,
            `userrating_user_id` INT(11) DEFAULT 0,
            `userrating_vs_super` INT(11) DEFAULT 0,
            `userrating_vs_rest` INT(11) DEFAULT 0,
            `userrating_win` INT(11) DEFAULT 0,
            `userrating_win_equal` INT(11) DEFAULT 0,
            `userrating_win_strong` INT(11) DEFAULT 0,
            `userrating_win_super` INT(11) DEFAULT 0,
            `userrating_win_weak` INT(11) DEFAULT 0,
            `userrating_winover` INT(11) DEFAULT 0,
            `userrating_winover_equal` INT(11) DEFAULT 0,
            `userrating_winover_strong` INT(11) DEFAULT 0,
            `userrating_winover_weak` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `userrating_season_id` ON `userrating` (`userrating_season_id`);';
$q[] = 'CREATE INDEX `userrating_user_id` ON `userrating` (`userrating_user_id`);';