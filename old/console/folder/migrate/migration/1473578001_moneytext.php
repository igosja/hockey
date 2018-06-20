<?php

$q = array();

$q[] = 'CREATE TABLE `moneytext`
        (
            `moneytext_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `moneytext_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `moneytext` (`moneytext_name`)
        VALUES ('Пополнение счёта'),
               ('Бонус партнёрской программе'),
               ('Покупка балла силы'),
               ('Пополнение счёта своей команды'),
               ('Покупка совмещения'),
               ('Покупка спецвозможности'),
               ('Покупка VIP-клуба');";