<?php

$q = array();

$q[] = 'CREATE TABLE `eventtype`
        (
            `eventtype_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `eventtype_text` VARCHAR(255)
        );';
$q[] = "INSERT INTO `eventtype` (`eventtype_text`)
        VALUES ('Гол'),
               ('Нарушение'),
               ('Буллит');";