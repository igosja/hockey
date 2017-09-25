<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalviceapplication`
        (
            `electionnationalviceapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionnationalviceapplication_electionnationalvice_id` INT(11) DEFAULT 0,
            `electionnationalviceapplication_date` INT(11) DEFAULT 0,
            `electionnationalviceapplication_text` TEXT,
            `electionnationalviceapplication_user_id` INT(11) DEFAULT 0
        );';