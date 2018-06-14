<?php

$q = array();

$q[] = 'CREATE TABLE `worldcup`
        (
            `worldcup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `worldcup_difference` INT(3) DEFAULT 0,
            `worldcup_division_id` INT(1) DEFAULT 0,
            `worldcup_game` INT(2) DEFAULT 0,
            `worldcup_loose` INT(2) DEFAULT 0,
            `worldcup_loose_bullet` INT(2) DEFAULT 0,
            `worldcup_loose_over` INT(2) DEFAULT 0,
            `worldcup_national_id` INT(3) DEFAULT 0,
            `worldcup_nationaltype_id` INT(1) DEFAULT 0,
            `worldcup_pass` INT(3) DEFAULT 0,
            `worldcup_place` INT(2) DEFAULT 0,
            `worldcup_point` INT(2) DEFAULT 0,
            `worldcup_score` INT(3) DEFAULT 0,
            `worldcup_season_id` INT(5) DEFAULT 0,
            `worldcup_win` INT(2) DEFAULT 0,
            `worldcup_win_bullet` INT(2) DEFAULT 0,
            `worldcup_win_over` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `worldcup_division_id` ON `worldcup` (`worldcup_division_id`);';
$q[] = 'CREATE INDEX `worldcup_national_id` ON `worldcup` (`worldcup_national_id`);';
$q[] = 'CREATE INDEX `worldcup_nationaltype_id` ON `worldcup` (`worldcup_nationaltype_id`);';
$q[] = 'CREATE INDEX `worldcup_season_id` ON `worldcup` (`worldcup_season_id`);';