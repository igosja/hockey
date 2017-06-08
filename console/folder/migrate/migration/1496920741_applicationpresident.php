<?php

$q = array();

$q[] = 'CREATE TABLE `applicationpresident`
        (
            `applicationpresident_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `applicationpresident_country_id` SMALLINT(3) DEFAULT 0,
            `applicationpresident_date` INT(11) DEFAULT 0,
            `applicationpresident_ready` TINYINT(1) DEFAULT 0,
            `applicationpresident_text` TEXT NOT NULL,
            `applicationpresident_user_id` INT(11) DEFAULT 0
        );';