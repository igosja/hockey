<?php

$q = array();

$q[] = 'CREATE TABLE `ratinguser`
        (
            `ratinguser_rating_place` INT(11) DEFAULT 0,
            `ratinguser_rating_place_country` INT(3) DEFAULT 0,
            `ratinguser_user_id` INT(11) DEFAULT 0
        );';