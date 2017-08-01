<?php

$q = array();

$q[] = 'CREATE TABLE `forumgroup`
        (
            `forumgroup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forumgroup_name` VARCHAR(255) NOT NULL,
            `forumgroup_order` INT(3) DEFAULT 0
        );';
$a[] = "INSERT INTO `forumgroup` (`forumgroup_name`, `forumgroup_order`)
        VALUES ('Общие', 1),
               ('Сделки и договоры', 2),
               ('За пределами Лиги', 3),
               ('Национальные форумы', 4);";