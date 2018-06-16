<?php

$q = array();

$q[] = 'CREATE TABLE `forumchapter`
        (
            `forumchapter_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forumchapter_name` VARCHAR(255),
            `forumchapter_order` INT(3) DEFAULT 0
        );';
$q[] = "INSERT INTO `forumchapter` (`forumchapter_name`, `forumchapter_order`)
        VALUES ('Общие', 1),
               ('Сделки и договоры', 2),
               ('За пределами Лиги', 3),
               ('Национальные форумы', 4);";