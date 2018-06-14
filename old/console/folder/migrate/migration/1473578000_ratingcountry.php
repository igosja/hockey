<?php

$q = array();

$q[] = 'CREATE TABLE `ratingcountry`
        (
            `ratingcountry_auto_place` INT(3) DEFAULT 0,
            `ratingcountry_country_id` INT(3) DEFAULT 0,
            `ratingcountry_league_place` INT(3) DEFAULT 0,
            `ratingcountry_stadium_place` INT(3) DEFAULT 0
        );';