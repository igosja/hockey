<?php

$q = array();

$q[] = 'CREATE TABLE `friendlyinvitestatus`
        (
            `friendlyinvitestatus_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `friendlyinvitestatus_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `friendlyinvitestatus` (`friendlyinvitestatus_name`)
        VALUES ('Новое приглашение'),
               ('Приглашение принято'),
               ('Приглашение отклонено');";