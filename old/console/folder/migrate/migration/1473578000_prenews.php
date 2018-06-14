<?php

$q = array();

$q[] = 'CREATE TABLE `prenews`
        (
            `prenews_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `prenews_new` TEXT,
            `prenews_error` TEXT
        );';
$q[] = 'INSERT INTO `prenews`
        SET `prenews_id`=NULL';