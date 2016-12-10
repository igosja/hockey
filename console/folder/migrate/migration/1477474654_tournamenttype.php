<?php

$q = array();

$q[] = 'CREATE TABLE `tournamenttype`
        (
            `tournamenttype_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `tournamenttype_name` VARCHAR(255) NOT NULL,
            `tournamenttype_visitor` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `tournamenttype` (`tournamenttype_name`, `tournamenttype_visitor`)
        VALUES ('Матчи сборных', '200'),
               ('Лига чемпионов', '150'),
               ('Чемпионат', '100'),
               ('Конференция', '90'),
               ('Кубок межсезонья', '90'),
               ('Товарищеский матч', '80')";