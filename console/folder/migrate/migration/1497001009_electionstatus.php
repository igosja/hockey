<?php

$q = array();

$q[] = 'CREATE TABLE `electionstatus`
        (
            `electionstatus_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `electionstatus_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `electionstatus` (`electionstatus_name`)
        VALUES ('Сбор кандидатур'),
               ('Идет голосование'),
               ('Закрыто');";