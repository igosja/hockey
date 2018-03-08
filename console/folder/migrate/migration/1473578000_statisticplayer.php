<?php

$q = array();

$q[] = 'CREATE TABLE `statisticplayer`
        (
            `statisticplayer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `statisticplayer_assist` INT(3) DEFAULT 0, #Голевые передачи
            `statisticplayer_assist_power` INT(3) DEFAULT 0, #Голевые передачи в большинстве
            `statisticplayer_assist_short` INT(3) DEFAULT 0, #Голевые передачи в меньшинстве
            `statisticplayer_bullet_win` INT(2) DEFAULT 0, #Решающие послематчевые буллиты
            `statisticplayer_championship_playoff` INT(1) DEFAULT 0, #Метка о плей-офф нац чемпионата
            `statisticplayer_country_id` INT(3) DEFAULT 0,
            `statisticplayer_division_id` INT(2) DEFAULT 0,
            `statisticplayer_face_off` INT(3) DEFAULT 0, #Всего вбрасываний
            `statisticplayer_face_off_percent` DECIMAL(5,2) DEFAULT 0, #Процент выигранных вбрасываний
            `statisticplayer_face_off_win` INT(3) DEFAULT 0, #Всего выиграно вбрасываний
            `statisticplayer_game` INT(2) DEFAULT 0,
            `statisticplayer_game_with_bullet` INT(2) DEFAULT 0, #Игр с буллитными сериями (для вратарей)
            `statisticplayer_is_gk` INT(1) DEFAULT 0, #Метка о стратистике вратаря
            `statisticplayer_loose` INT(2) DEFAULT 0,
            `statisticplayer_national_id` INT(5) DEFAULT 0,
            `statisticplayer_pass` INT(3) DEFAULT 0, #Всего пропушено
            `statisticplayer_pass_per_game` DECIMAL(4,2) DEFAULT 0, #Коэффициент надёжности — пропущенные шайбы в среднем за игру
            `statisticplayer_penalty` INT(3) DEFAULT 0, #Штрафное время в минутах
            `statisticplayer_player_id` INT(11) DEFAULT 0,
            `statisticplayer_plus_minus` INT(3) DEFAULT 0, #Плюс/минус, показатель полезности (для полевых)
            `statisticplayer_point` INT(3) DEFAULT 0, #Очки — сумма голов и голевых пасов
            `statisticplayer_save` INT(3) DEFAULT 0, #Отражённые броски
            `statisticplayer_save_percent` DECIMAL(5,2) DEFAULT 0, #Процент отраженных бросков
            `statisticplayer_score` INT(3) DEFAULT 0, #Голы
            `statisticplayer_score_draw` INT(3) DEFAULT 0, #Голы, которые сравняли счет в матче
            `statisticplayer_score_power` INT(3) DEFAULT 0, #Голы в большинстве
            `statisticplayer_score_short` INT(3) DEFAULT 0, #Голы в меньшинстве
            `statisticplayer_score_shot_percent` DECIMAL(5,2) DEFAULT 0, #Процент реализованных бросков
            `statisticplayer_score_win` INT(2) DEFAULT 0, #Победные голы
            `statisticplayer_season_id` INT(5) DEFAULT 0,
            `statisticplayer_shot` INT(3) DEFAULT 0, #Броски
            `statisticplayer_shot_gk` INT(3) DEFAULT 0, #Броски (для вратарей)
            `statisticplayer_shot_per_game` DECIMAL(4,2) DEFAULT 0, #Бросков за игру
            `statisticplayer_shutout` INT(3) DEFAULT 0, #Игр на ноль
            `statisticplayer_team_id` INT(11) DEFAULT 0,
            `statisticplayer_tournamenttype_id` INT(1) DEFAULT 0,
            `statisticplayer_win` INT(2) DEFAULT 0 #Побед
        );';
$q[] = 'CREATE INDEX `statisticplayer_championship_playoff` ON `statisticplayer` (`statisticplayer_championship_playoff`);';
$q[] = 'CREATE INDEX `statisticplayer_country_id` ON `statisticplayer` (`statisticplayer_country_id`);';
$q[] = 'CREATE INDEX `statisticplayer_division_id` ON `statisticplayer` (`statisticplayer_division_id`);';
$q[] = 'CREATE INDEX `statisticplayer_is_gk` ON `statisticplayer` (`statisticplayer_is_gk`);';
$q[] = 'CREATE INDEX `statisticplayer_national_id` ON `statisticplayer` (`statisticplayer_national_id`);';
$q[] = 'CREATE INDEX `statisticplayer_player_id` ON `statisticplayer` (`statisticplayer_player_id`);';
$q[] = 'CREATE INDEX `statisticplayer_season_id` ON `statisticplayer` (`statisticplayer_season_id`);';
$q[] = 'CREATE INDEX `statisticplayer_tournamenttype_id` ON `statisticplayer` (`statisticplayer_tournamenttype_id`);';