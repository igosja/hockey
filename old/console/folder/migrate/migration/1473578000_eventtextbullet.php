<?php

$q = array();

$q[] = 'CREATE TABLE `eventtextbullet`
        (
            `eventtextbullet_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `eventtextbullet_text` VARCHAR(255)
        );';
$q[] = "INSERT INTO `eventtextbullet` (`eventtextbullet_text`)
        VALUES ('Реализованный буллит.'),
               ('Нереализованный буллит.');";