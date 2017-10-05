<?php

$q = array();

$q[] = 'CREATE TABLE `teamvisitor`
        (
            `teamvisitor_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `teamvisitor_team_id` INT(11) DEFAULT 0,
            `teamvisitor_visitor` DECIMAL(3,2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `teamvisitor_team_id` ON `teamvisitor` (`teamvisitor_team_id`);';