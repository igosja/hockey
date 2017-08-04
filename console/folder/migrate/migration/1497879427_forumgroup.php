<?php

$q = array();

$q[] = 'CREATE TABLE `forumgroup`
        (
            `forumgroup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forumgroup_count_message` INT(11) DEFAULT 0,
            `forumgroup_count_theme` INT(11) DEFAULT 0,
            `forumgroup_country_id` INT(3) DEFAULT 0,
            `forumgroup_description` TEXT NOT NULL,
            `forumgroup_forumchapter_id` INT(11) DEFAULT 0,
            `forumgroup_last_date` INT(11) DEFAULT 0,
            `forumgroup_last_forummessage_id` INT(11) DEFAULT 0,
            `forumgroup_last_forumtheme_id` INT(11) DEFAULT 0,
            `forumgroup_last_user_id` INT(11) DEFAULT 0,
            `forumgroup_name` VARCHAR(255) NOT NULL,
            `forumgroup_order` INT(3) DEFAULT 0,
            `forumgroup_user_id` INT(11) DEFAULT 0
        );';
$q[] = "INSERT INTO `forumgroup` (`forumgroup_name`, `forumgroup_description`, `forumgroup_forumchapter_id`, `forumgroup_order`)
        VALUES ('О Лиге', 'вопросы и комментарии о лиге глобального характера, творчество, что нравится/не нравится', 1, 1),
               ('Скорая помощь', 'сверxсрочные проблемы, не терпящие отлагательств, а то будет поздно - остальное в баги или вопросы новичков', 1, 2),
               ('Вопросы новичков', 'для обсуждения с опытными менеджерами возникающих у новичков самых простых вопросов', 1, 3),
               ('Регистрация и команды', '(пере)регистрация, выставление/раздача свободных команд, переходы из клуба в клуб, верните команду и т.д.', 1, 4),
               ('Идеи и предложения', 'высказывание интересных мыслей и конкретных идей по поводу развития лиги', 1, 5),
               ('Правила', 'обсуждение, трактовка, серьезные вопросы по поводу действующих правил', 1, 6),
               ('Трансферы', 'если хотите договориться о купле/продаже игроков', 2, 7),
               ('Товарищеские Матчи', 'поиск соперников на товы', 2, 8),
               ('Аренда', 'если хотите договориться об аренде игроков', 2, 9),
               ('Встречи', 'встречи менеджеров в реале - на стадион сходить, пивка попить', 3, 10),
               ('Реальный хоккей', 'обсуждение реальных событий, хоккейный оффтопик', 3, 11),
               ('Оффтопик', 'обсуждение всего чего угодно за пределами Лиги', 3, 12);";