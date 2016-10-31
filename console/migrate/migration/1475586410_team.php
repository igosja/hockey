<?php

$q = array();

$q[] = 'CREATE TABLE `team`
        (
            `team_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `team_base_id` TINYINT(2) DEFAULT 2,
            `team_basemedical_id` TINYINT(2) DEFAULT 1,
            `team_basephisical_id` TINYINT(2) DEFAULT 1,
            `team_baseschool_id` TINYINT(2) DEFAULT 1,
            `team_basescout_id` TINYINT(2) DEFAULT 1,
            `team_basetraining_id` TINYINT(2) DEFAULT 1,
            `team_finance` INT(11) DEFAULT 1000000,
            `team_name` VARCHAR(255) NOT NULL,
            `team_shop_position` TINYINT(3) DEFAULT 0,
            `team_shop_special` TINYINT(3) DEFAULT 0,
            `team_shop_training` TINYINT(3) DEFAULT 0,
            `team_stadium_id` INT(11) DEFAULT 0,
            `team_user_id` INT(11) DEFAULT 0,
            `team_vice_id` INT(11) DEFAULT 0,
            `team_vote_junior` TINYINT(1) DEFAULT 2,
            `team_vote_national` TINYINT(1) DEFAULT 2,
            `team_vote_president` TINYINT(1) DEFAULT 2,
            `team_vote_youth` TINYINT(1) DEFAULT 2
        );';
$q[] = 'CREATE INDEX `team_base_id` ON `team` (`team_base_id`);';
$q[] = 'CREATE INDEX `team_basemedical_id` ON `team` (`team_basemedical_id`);';
$q[] = 'CREATE INDEX `team_basephisical_id` ON `team` (`team_basephisical_id`);';
$q[] = 'CREATE INDEX `team_baseschool_id` ON `team` (`team_baseschool_id`);';
$q[] = 'CREATE INDEX `team_basescout_id` ON `team` (`team_basescout_id`);';
$q[] = 'CREATE INDEX `team_basetraining_id` ON `team` (`team_basetraining_id`);';
$q[] = 'CREATE INDEX `team_stadium_id` ON `team` (`team_stadium_id`);';
$q[] = 'CREATE INDEX `team_user_id` ON `team` (`team_user_id`);';
$q[] = 'CREATE INDEX `team_vice_id` ON `team` (`team_vice_id`);';
$q[] = "INSERT INTO `team` (`team_id`, `team_base_id`, `team_basemedical_id`, `team_basephisical_id`, `team_baseschool_id`, `team_basescout_id`, `team_basetraining_id`, `team_finance`, `team_name`, `team_shop_position`, `team_shop_special`, `team_shop_training`, `team_stadium_id`, `team_user_id`, `team_vice_id`, `team_vote_junior`, `team_vote_national`, `team_vote_president`, `team_vote_youth`)
        VALUES (1, 2, 1, 1, 1, 1, 1, 1000000, 'Адмирал', 0, 0, 0, 8, 0, 0, 2, 2, 2, 2),
               (2, 2, 1, 1, 1, 1, 1, 1000000, 'Автомобилист', 0, 0, 0, 15, 0, 0, 2, 2, 2, 2),
               (3, 2, 1, 1, 1, 1, 1, 1000000, 'Ак Барс', 0, 0, 0, 16, 0, 0, 2, 2, 2, 2),
               (4, 2, 1, 1, 1, 1, 1, 1000000, 'Металлург', 0, 0, 0, 20, 0, 0, 2, 2, 2, 2),
               (5, 2, 1, 1, 1, 1, 1, 1000000, 'Динамо', 0, 0, 0, 22, 0, 0, 2, 2, 2, 2),
               (6, 2, 1, 1, 1, 1, 1, 1000000, 'Спартак', 0, 0, 0, 24, 0, 0, 2, 2, 2, 2),
               (7, 2, 1, 1, 1, 1, 1, 1000000, 'ЦСКА', 0, 0, 0, 25, 0, 0, 2, 2, 2, 2),
               (8, 2, 1, 1, 1, 1, 1, 1000000, 'Нефтехимик', 0, 0, 0, 28, 0, 0, 2, 2, 2, 2),
               (9, 2, 1, 1, 1, 1, 1, 1000000, 'Торпедо', 0, 0, 0, 29, 0, 0, 2, 2, 2, 2),
               (10, 2, 1, 1, 1, 1, 1, 1000000, 'Сибирь', 0, 0, 0, 31, 0, 0, 2, 2, 2, 2),
               (11, 2, 1, 1, 1, 1, 1, 1000000, 'Авангард', 0, 0, 0, 36, 0, 0, 2, 2, 2, 2),
               (12, 2, 1, 1, 1, 1, 1, 1000000, 'СКА', 0, 0, 0, 43, 0, 0, 2, 2, 2, 2),
               (13, 2, 1, 1, 1, 1, 1, 1000000, 'Сочи', 0, 0, 0, 49, 0, 0, 2, 2, 2, 2),
               (14, 2, 1, 1, 1, 1, 1, 1000000, 'Салават Юлаев', 0, 0, 0, 54, 0, 0, 2, 2, 2, 2),
               (15, 2, 1, 1, 1, 1, 1, 1000000, 'Трактор', 0, 0, 0, 58, 0, 0, 2, 2, 2, 2),
               (16, 2, 1, 1, 1, 1, 1, 1000000, 'Локомотив', 0, 0, 0, 64, 0, 0, 2, 2, 2, 2),
               (17, 2, 1, 1, 1, 1, 1, 1000000, 'Анахайм Дакс', 0, 0, 0, 2, 0, 0, 2, 2, 2, 2),
               (18, 2, 1, 1, 1, 1, 1, 1000000, 'Бостон Брюинз', 0, 0, 0, 5, 0, 0, 2, 2, 2, 2),
               (19, 2, 1, 1, 1, 1, 1, 1000000, 'Вашингтон Кэпиталз', 0, 0, 0, 7, 0, 0, 2, 2, 2, 2),
               (20, 2, 1, 1, 1, 1, 1, 1000000, 'Даллас Старз', 0, 0, 0, 11, 0, 0, 2, 2, 2, 2),
               (21, 2, 1, 1, 1, 1, 1, 1000000, 'Детройт Ред Уингз', 0, 0, 0, 14, 0, 0, 2, 2, 2, 2),
               (22, 2, 1, 1, 1, 1, 1, 1000000, 'Лос-Анджелес Кингз', 0, 0, 0, 19, 0, 0, 2, 2, 2, 2),
               (23, 2, 1, 1, 1, 1, 1, 1000000, 'Нью-Йорк Айлендерс', 0, 0, 0, 32, 0, 0, 2, 2, 2, 2),
               (24, 2, 1, 1, 1, 1, 1, 1000000, 'Нью-Йорк Рейнджерс', 0, 0, 0, 33, 0, 0, 2, 2, 2, 2),
               (25, 2, 1, 1, 1, 1, 1, 1000000, 'Нэшвилл Предаторз', 0, 0, 0, 35, 0, 0, 2, 2, 2, 2),
               (26, 2, 1, 1, 1, 1, 1, 1000000, 'Питтсбург Пингвинз', 0, 0, 0, 38, 0, 0, 2, 2, 2, 2),
               (27, 2, 1, 1, 1, 1, 1, 1000000, 'Сан-Хосе Шаркс', 0, 0, 0, 42, 0, 0, 2, 2, 2, 2),
               (28, 2, 1, 1, 1, 1, 1, 1000000, 'Флорида Пантерз', 0, 0, 0, 44, 0, 0, 2, 2, 2, 2),
               (29, 2, 1, 1, 1, 1, 1, 1000000, 'Сент-Луис Блюз', 0, 0, 0, 47, 0, 0, 2, 2, 2, 2),
               (30, 2, 1, 1, 1, 1, 1, 1000000, 'Тампа-Бэй Лайтнинг', 0, 0, 0, 51, 0, 0, 2, 2, 2, 2),
               (31, 2, 1, 1, 1, 1, 1, 1000000, 'Филадельфия Флайерз', 0, 0, 0, 55, 0, 0, 2, 2, 2, 2),
               (32, 2, 1, 1, 1, 1, 1, 1000000, 'Чикаго Блэкхокс', 0, 0, 0, 61, 0, 0, 2, 2, 2, 2);";