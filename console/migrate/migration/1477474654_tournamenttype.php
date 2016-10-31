<?php

$q = array();

$q[] = 'CREATE TABLE `tournamenttype`
        (
            `tournamenttype_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `tournamenttype_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `tournamenttype` (`tournamenttype_name`)
        VALUES ('Матчи сборных'),
               ('Лига чемпионов'),
               ('Чемпионат'),
               ('Кубок межсезонья'),
               ('Товарищеский матч')";