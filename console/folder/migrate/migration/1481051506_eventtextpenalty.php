<?php

$q = array();

$q[] = 'CREATE TABLE `eventtextpenalty`
        (
            `eventtextpenalty_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `eventtextpenalty_text` VARCHAR(255)
        );';
$q[] = "INSERT INTO `eventtextpenalty` (`eventtextpenalty_text`)
        VALUES ('Толчок соперника.'),
               ('Атака игрока, не владеющего шайбой.'),
               ('Подножка.'),
               ('Задержка соперника руками.'),
               ('Зацеп.'),
               ('Атака сзади.'),
               ('Удар соперника.'),
               ('Опасная игра высоко поднятой клюшкой.'),
               ('Удар клюшкой.');";