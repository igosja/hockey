<?php

$q = array();

$q[] = 'CREATE TABLE `surnamecountry`
        (
            `surnamecountry_country_id` SMALLINT(3) DEFAULT 0,
            `surnamecountry_surname_id` INT(11) DEFAULT 0
        );';