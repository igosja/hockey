<?php

$q = array();

$q[] = 'CREATE TABLE `tournamenttype`
        (
            `tournamenttype_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `tournamenttype_daytype_id` INT(1) DEFAULT 0,
            `tournamenttype_name` VARCHAR(255),
            `tournamenttype_visitor` VARCHAR(255)
        );';
$q[] = "INSERT INTO `tournamenttype` (`tournamenttype_name`, `tournamenttype_daytype_id`, `tournamenttype_visitor`)
        VALUES ('Матчи сборных', 3, 200),
               ('Лига чемпионов', 3, 150),
               ('Чемпионат', 2, 100),
               ('Конференция', 2, 90),
               ('Кубок межсезонья', 2, 90),
               ('Товарищеский матч', 1, 80)";