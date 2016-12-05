<?php

$q = array();

$q[] = 'CREATE TABLE `statisticplayer`
        (
            `statisticteam_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `statisticteam_assist` SMALLINT(3) DEFAULT 0, #Голевые передачи
            `statisticteam_assist_power` SMALLINT(3) DEFAULT 0, #Голевые передачи в большинстве
            `statisticteam_assist_short` SMALLINT(3) DEFAULT 0, #Голевые передачи в меньшинстве
            `statisticteam_bullet_win` TINYINT(2) DEFAULT 0, #Решающие послематчевые буллиты
            `statisticteam_championship_playoff` TINYINT(1) DEFAULT 0, #Метка о плей-офф нац чемпионата
            `statisticteam_country_id` SMALLINT(3) DEFAULT 0,
            `statisticteam_division_id` TINYINT(2) DEFAULT 0,
            `statisticteam_face_off` SMALLINT(3) DEFAULT 0, #Всего вбрасываний
            `statisticteam_face_off_percent` TINYINT(3) DEFAULT 0, #Процент выигранных вбрасываний
            `statisticteam_face_off_win` SMALLINT(3) DEFAULT 0, #Всего выиграно вбрасываний
            `statisticteam_game` TINYINT(2) DEFAULT 0,
            `statisticteam_game_with_bullet` TINYINT(2) DEFAULT 0, #Игр с буллитными сериями (для вратарей)
            `statisticteam_is_gk` TINYINT(1) DEFAULT 0, #Метка о стратистике вратаря
            `statisticteam_loose` TINYINT(2) DEFAULT 0,
            `statisticteam_national_id` SMALLINT(5) DEFAULT 0,
            `statisticteam_pass` SMALLINT(3) DEFAULT 0, #Всего пропушено
            `statisticteam_pass_per_game` DECIMAL(2,1) DEFAULT 0, #Коэффициент надёжности — пропущенные шайбы в среднем за игру
            `statisticteam_penalty` SMALLINT(3) DEFAULT 0, #Штрафное время в минутах
            `statisticteam_plus_minus` SMALLINT(3) DEFAULT 0, #Плюс/минус, показатель полезности (для полевых)
            `statisticteam_point` SMALLINT(3) DEFAULT 0, #Очки — сумма голов и голевых пасов
            `statisticteam_save` SMALLINT(3) DEFAULT 0, #Отражённые броски
            `statisticteam_save_percent` TINYINT(3) DEFAULT 0, #Процент отраженных бросков
            `statisticteam_score` SMALLINT(3) DEFAULT 0, #Голы
            `statisticteam_score_empty` TINYINT(2) DEFAULT 0, #Голы в пустые ворота
            `statisticteam_score_draw` SMALLINT(3) DEFAULT 0, #Голы, которые сравняли счет в матче
            `statisticteam_score_power` SMALLINT(3) DEFAULT 0, #Голы в большинстве
            `statisticteam_score_short` SMALLINT(3) DEFAULT 0, #Голы в меньшинстве
            `statisticteam_score_shot_percent` TINYINT(3) DEFAULT 0, #Процент реализованных бросков
            `statisticteam_score_win` TINYINT(2) DEFAULT 0, #Победные голы
            `statisticteam_season_id` SMALLINT(5) DEFAULT 0,
            `statisticteam_shot` SMALLINT(3) DEFAULT 0, #Броски
            `statisticteam_shot_gk` SMALLINT(3) DEFAULT 0, #Броски (для вратарей)
            `statisticteam_shot_per_game` DECIMAL(4,1) DEFAULT 0, #Бросков за игру
            `statisticteam_shutout` SMALLINT(3) DEFAULT 0, #Игр на ноль
            `statisticteam_team_id` SMALLINT(5) DEFAULT 0,
            `statisticteam_tournamenttype_id` TINYINT(1) DEFAULT 0,
            `statisticteam_win` TINYINT(2) DEFAULT 0 #Побед
        );';