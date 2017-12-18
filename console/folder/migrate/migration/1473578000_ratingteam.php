<?php

$q = array();

$q[] = 'CREATE TABLE `ratingteam`
        (
            `ratingteam_age_place` INT(11) DEFAULT 0,
            `ratingteam_age_place_country` INT(3) DEFAULT 0,
            `ratingteam_base_place` INT(11) DEFAULT 0,
            `ratingteam_base_place_country` INT(3) DEFAULT 0,
            `ratingteam_player_place` INT(11) DEFAULT 0,
            `ratingteam_player_place_country` INT(3) DEFAULT 0,
            `ratingteam_power_vs_place` INT(11) DEFAULT 0,
            `ratingteam_power_vs_place_country` INT(3) DEFAULT 0,
            `ratingteam_price_base_place` INT(11) DEFAULT 0,
            `ratingteam_price_base_place_country` INT(3) DEFAULT 0,
            `ratingteam_price_stadium_place` INT(11) DEFAULT 0,
            `ratingteam_price_stadium_place_country` INT(3) DEFAULT 0,
            `ratingteam_price_total_place` INT(11) DEFAULT 0,
            `ratingteam_price_total_place_country` INT(3) DEFAULT 0,
            `ratingteam_stadium_place` INT(11) DEFAULT 0,
            `ratingteam_stadium_place_country` INT(3) DEFAULT 0,
            `ratingteam_team_id` INT(11) DEFAULT 0,
            `ratingteam_visitor_place` INT(11) DEFAULT 0,
            `ratingteam_visitor_place_country` INT(3) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `ratingteam_team_id` ON `ratingteam` (`ratingteam_team_id`);';