<?php

$q = array();

$q[] = 'CREATE TABLE `complain`
        (
            `complain_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `complain_date` INT(11) DEFAULT 0,
            `complain_url` VARCHAR(255),
            `complain_user_id` INT(11)
        );';