<?php

$q = array();

$q[] = 'CREATE TABLE `worldcup`
        (
            `worldcup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `worldcup_division_id` TINYINT(1) DEFAULT 0,
            `worldcup_game` TINYINT(2) DEFAULT 0,
            `worldcup_loose` TINYINT(2) DEFAULT 0,
            `worldcup_loose_over` TINYINT(2) DEFAULT 0,
            `worldcup_national_id` SMALLINT(3) DEFAULT 0,
            `worldcup_pass` SMALLINT(3) DEFAULT 0,
            `worldcup_place` SMALLINT(5) DEFAULT 0,
            `worldcup_point` TINYINT(2) DEFAULT 0,
            `worldcup_score` SMALLINT(3) DEFAULT 0,
            `worldcup_season_id` SMALLINT(5) DEFAULT 0,
            `worldcup_win` TINYINT(2) DEFAULT 0,
            `worldcup_win_over` TINYINT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `worldcup_division_id` ON `worldcup` (`worldcup_division_id`);';
$q[] = 'CREATE INDEX `worldcup_national_id` ON `worldcup` (`worldcup_national_id`);';
$q[] = 'CREATE INDEX `worldcup_season_id` ON `worldcup` (`worldcup_season_id`);';