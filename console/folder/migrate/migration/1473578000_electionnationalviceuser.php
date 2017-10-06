<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalviceuser`
        (
            `electionnationalviceuser_date` INT(11) DEFAULT 0,
            `electionnationalviceuser_electionnationalvice_id` INT(11) DEFAULT 0,
            `electionnationalviceuser_electionnationalviceapplication_id` INT(11) DEFAULT 0,
            `electionnationalviceuser_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionnationalviceuser_electionnationalviceapplication_id` ON `electionnationalviceuser` (`electionnationalviceuser_electionnationalviceapplication_id`);';