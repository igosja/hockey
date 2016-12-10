<?php

$q = array();

$q[] = 'CREATE TABLE `eventtextgoal`
        (
            `eventtextgoal_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `eventtextgoal_text` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `eventtextgoal` (`eventtextgoal_text`)
        VALUES ('Выход 1 на 1'),
               ('Щелчок'),
               ('Мощный кистевой бросок'),
               ('Быстрый кистевой бросок'),
               ('Гол в пустые ворота');";