<?php

$q = array();

$q[] = 'CREATE TABLE `statisticplayer`
        (
            `statisticplayer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `statisticplayer_assist` SMALLINT(3) DEFAULT 0, #Голевые передачи
            `statisticplayer_assist_power` SMALLINT(3) DEFAULT 0, #Голевые передачи в большинстве
            `statisticplayer_assist_short` SMALLINT(3) DEFAULT 0, #Голевые передачи в меньшинстве
            `statisticplayer_bullet_win` TINYINT(2) DEFAULT 0, #Решающие послематчевые буллиты
            `statisticplayer_championship_playoff` TINYINT(1) DEFAULT 0, #Метка о плей-офф нац чемпионата
            `statisticplayer_country_id` SMALLINT(3) DEFAULT 0,
            `statisticplayer_division_id` TINYINT(2) DEFAULT 0,
            `statisticplayer_face_off` SMALLINT(3) DEFAULT 0, #Всего вбрасываний
            `statisticplayer_face_off_percent` TINYINT(3) DEFAULT 0, #Процент выигранных вбрасываний
            `statisticplayer_face_off_win` SMALLINT(3) DEFAULT 0, #Всего выиграно вбрасываний
            `statisticplayer_game` TINYINT(2) DEFAULT 0,
            `statisticplayer_game_with_bullet` TINYINT(2) DEFAULT 0, #Игр с буллитными сериями (для вратарей)
            `statisticplayer_is_gk` TINYINT(1) DEFAULT 0, #Метка о стратистике вратаря
            `statisticplayer_loose` TINYINT(2) DEFAULT 0,
            `statisticplayer_national_id` SMALLINT(5) DEFAULT 0,
            `statisticplayer_pass` SMALLINT(3) DEFAULT 0, #Всего пропушено
            `statisticplayer_pass_per_game` DECIMAL(2,1) DEFAULT 0, #Коэффициент надёжности — пропущенные шайбы в среднем за игру
            `statisticplayer_penalty` SMALLINT(3) DEFAULT 0, #Штрафное время в минутах
            `statisticplayer_player_id` INT(11) DEFAULT 0,
            `statisticplayer_plus_minus` SMALLINT(3) DEFAULT 0, #Плюс/минус, показатель полезности (для полевых)
            `statisticplayer_point` SMALLINT(3) DEFAULT 0, #Очки — сумма голов и голевых пасов
            `statisticplayer_save` SMALLINT(3) DEFAULT 0, #Отражённые броски
            `statisticplayer_save_percent` TINYINT(3) DEFAULT 0, #Процент отраженных бросков
            `statisticplayer_score` SMALLINT(3) DEFAULT 0, #Голы
            `statisticplayer_score_empty` TINYINT(2) DEFAULT 0, #Голы в пустые ворота
            `statisticplayer_score_draw` SMALLINT(3) DEFAULT 0, #Голы, которые сравняли счет в матче
            `statisticplayer_score_power` SMALLINT(3) DEFAULT 0, #Голы в большинстве
            `statisticplayer_score_short` SMALLINT(3) DEFAULT 0, #Голы в меньшинстве
            `statisticplayer_score_shot_percent` TINYINT(3) DEFAULT 0, #Процент реализованных бросков
            `statisticplayer_score_win` TINYINT(2) DEFAULT 0, #Победные голы
            `statisticplayer_season_id` SMALLINT(5) DEFAULT 0,
            `statisticplayer_shot` SMALLINT(3) DEFAULT 0, #Броски
            `statisticplayer_shot_gk` SMALLINT(3) DEFAULT 0, #Броски (для вратарей)
            `statisticplayer_shot_per_game` DECIMAL(4,1) DEFAULT 0, #Бросков за игру
            `statisticplayer_shutout` SMALLINT(3) DEFAULT 0, #Игр на ноль
            `statisticplayer_team_id` SMALLINT(5) DEFAULT 0,
            `statisticplayer_tournamenttype_id` TINYINT(1) DEFAULT 0,
            `statisticplayer_win` TINYINT(2) DEFAULT 0 #Побед
        );';