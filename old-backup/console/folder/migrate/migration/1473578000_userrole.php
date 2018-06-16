<?php

$q = array();

$q[] = 'CREATE TABLE `userrole`
        (
            `userrole_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `userrole_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `userrole` (`userrole_name`)
        VALUES ('Пользователь'),
               ('Модератор'),
               ('Администратор')";