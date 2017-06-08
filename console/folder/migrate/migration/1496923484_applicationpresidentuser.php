<?php

$q = array();

$q[] = 'CREATE TABLE `applicationpresidentuser`
        (
            `applicationpresidentuser_applicationpresident_id` INT(11) DEFAULT 0,
            `applicationpresidentuser_date` INT(11) DEFAULT 0,
            `applicationpresidentuser_user_id` INT(11) DEFAULT 0
        );';