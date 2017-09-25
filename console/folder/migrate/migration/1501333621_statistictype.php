<?php

$q = array();

$q[] = 'CREATE TABLE `statistictype`
        (
            `statistictype_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `statistictype_name` VARCHAR(255),
            `statistictype_order` INT(2) DEFAULT 0,
            `statistictype_statisticchapter_id` INT(1) DEFAULT 0
        );';
$q[] = "INSERT INTO `statistictype` (`statistictype_name`, `statistictype_statisticchapter_id`)
        VALUES ('Игры без пропущенных шайб', 1),
               ('Игры без заброшенных шайб', 1),
               ('Поражения', 1),
               ('Поражения по буллитам', 1),
               ('Поражения в дополнительное время', 1),
               ('Пропущенные шайбы', 1),
               ('Заброшенные шайбы', 1),
               ('Штрафные минуты', 1),
               ('Штрафные минуты соперника', 1),
               ('Победы', 1),
               ('Победы по буллитам', 1),
               ('Победы в дополнительное время', 1),
               ('Процент побед', 1),
               ('Результативные передачи', 2),
               ('Результативные передачи в большинстве', 2),
               ('Результативные передачи в меньшинстве', 2),
               ('Победные буллиты', 2),
               ('Вбрасывания', 2),
               ('Процент выигранных вбрасываний', 2),
               ('Выигранные вбрасывания', 2),
               ('Игры', 2),
               ('Поражения', 2),
               ('Пропущенные шайбы', 2),
               ('Пропущенные шайбы за игру', 2),
               ('Штрафные минуты', 2),
               ('Плюс/минус', 2),
               ('Очки (шайбы+голевые передачи)', 2),
               ('Сейвы', 2),
               ('Сейвы за игру', 2),
               ('Заброшенные шайбы', 2),
               ('Заброшенные шайбы, которые сравняли счет в матче', 2),
               ('Заброшенные шайбы в большинстве', 2),
               ('Заброшенные шайбы в меньшинстве', 2),
               ('Процент заброшенных шайб к количеству бросков по воротам', 2),
               ('Победные шайбы', 2),
               ('Броски по воротам', 2),
               ('Броски (вратари)', 2),
               ('Броски за игру', 2),
               ('Игры на ноль', 2),
               ('Победы', 2);";