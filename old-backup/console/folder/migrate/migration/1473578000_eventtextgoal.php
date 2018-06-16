<?php

$q = array();

$q[] = 'CREATE TABLE `eventtextgoal`
        (
            `eventtextgoal_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `eventtextgoal_text` VARCHAR(255)
        );';
$q[] = "INSERT INTO `eventtextgoal` (`eventtextgoal_text`)
        VALUES ('Щелчок.'),
               ('Мощный кистевой бросок.'),
               ('Быстрый кистевой бросок.'),
               ('Добивание.');";