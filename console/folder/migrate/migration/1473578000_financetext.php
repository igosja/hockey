<?php

$q = array();

$q[] = 'CREATE TABLE `financetext`
        (
            `financetext_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `financetext_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `financetext` (`financetext_name`)
        VALUES ('VIP-призовые'),
               ('Призовые за чемпионат мира'),
               ('Призовые за Лигу чемпионов'),
               ('Призовые за чемпионат страны'),
               ('Призовые за конференцию любительских клубов'),
               ('Призовые за кубок межсезонья'),
               ('Доход от продажи билетов'),
               ('Расходы на организацию матча'),
               ('Зарплата игроков'),
               ('Оплата тренировки совмещения игрока {player}'),
               ('Оплата тренировки спецвозможности игрока {player}'),
               ('Оплата тренировки балла силы игрока {player}'),
               ('Оплата изучения стиля игрока {player}'),
               ('Оплата расширения стадиона до {capacity} мест'),
               ('Компенсация за уменьшения стадиона до {capacity} мест'),
               ('Оплата увеличения уровня строения {building} до {level} уровня'),
               ('Компенсация за уменьшение строения {building} до {level} уровня'),
               ('Продажа игрока {player}'),
               ('Покупка игрока {player}'),
               ('Первой команде за трансфер игрока {player}'),
               ('Игрок {player} взят в аренду'),
               ('Игрок {player} отдан в аренду'),
               ('Содержание базы за сезон'),
               ('Перерегистрация команды'),
               ('Уход на пенсию игрока'),
               ('Компенсиция за участие в матчах сборной игрока {player}'),
               ('Перевод с личного счета менеджера'),
               ('Бонус партнёрской программе');";