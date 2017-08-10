<?php

$q = array();

$q[] = 'CREATE TABLE `namecountry`
        (
            `namecountry_country_id` INT(3) DEFAULT 0,
            `namecountry_name_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `namecountry_name_id` ON `namecountry` (`namecountry_name_id`);';