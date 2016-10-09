<?php

$q = array();

$q[] = 'CREATE TABLE `country`
        (
            `country_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `country_finance` INT(11) DEFAULT 0,
            `country_name` VARCHAR(255) NOT NULL,
            `country_president_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `country_president_id` ON `country` (`country_president_id`);';
$q[] = "INSERT INTO `country` (`country_name`)
        VALUES ('Австралия'),
               ('Австрия'),
               ('Азербайджан'),
               ('Албания'),
               ('Алжир'),
               ('Англия'),
               ('Ангола'),
               ('Андорра'),
               ('Антигуа и Барбуда'),
               ('Аргентина'),
               ('Армения'),
               ('Афганистан'),
               ('Багамы'),
               ('Бангладеш'),
               ('Барбадос'),
               ('Бахрейн'),
               ('Белиз'),
               ('Белоруссия'),
               ('Бельгия'),
               ('Бенин'),
               ('Болгария'),
               ('Боливия'),
               ('Босния и Герцеговина'),
               ('Ботсвана'),
               ('Бразилия'),
               ('Бруней'),
               ('Буркина-Фасо'),
               ('Бурунди'),
               ('Бутан'),
               ('Вануату'),
               ('Венгрия'),
               ('Венесуэла'),
               ('Восточный Тимор'),
               ('Вьетнам'),
               ('Габон'),
               ('Гаити'),
               ('Гайана'),
               ('Гамбия'),
               ('Гана'),
               ('Гватемала'),
               ('Гвинея'),
               ('Гвинея-Бисау'),
               ('Германия'),
               ('Гондурас'),
               ('Гренада'),
               ('Греция'),
               ('Грузия'),
               ('Дания'),
               ('Джибути'),
               ('Доминика'),
               ('Доминиканская Республика'),
               ('ДР Конго'),
               ('Египет'),
               ('Замбия'),
               ('Зимбабве'),
               ('Израиль'),
               ('Индия'),
               ('Индонезия'),
               ('Иордания'),
               ('Ирак'),
               ('Иран'),
               ('Ирландия'),
               ('Исландия'),
               ('Испания'),
               ('Италия'),
               ('Йемен'),
               ('Кабо-Верде'),
               ('Казахстан'),
               ('Камбоджа'),
               ('Камерун'),
               ('Канада'),
               ('Катар'),
               ('Кения'),
               ('Кипр'),
               ('Киргизия'),
               ('Кирибати'),
               ('Китай'),
               ('КНДР'),
               ('Колумбия'),
               ('Коморы'),
               ('Конго'),
               ('Корея'),
               ('Коста-Рика'),
               ('Кот-д’Ивуар'),
               ('Куба'),
               ('Кувейт'),
               ('Лаос'),
               ('Латвия'),
               ('Лесото'),
               ('Либерия'),
               ('Ливан'),
               ('Ливия'),
               ('Литва'),
               ('Лихтенштейн'),
               ('Люксембург'),
               ('Маврикий'),
               ('Мавритания'),
               ('Мадагаскар'),
               ('Македония'),
               ('Малави'),
               ('Малайзия'),
               ('Мали'),
               ('Мальдивы'),
               ('Мальта'),
               ('Марокко'),
               ('Маршалловы Острова'),
               ('Мексика'),
               ('Микронезия'),
               ('Мозамбик'),
               ('Молдавия'),
               ('Монако'),
               ('Монголия'),
               ('Мьянма'),
               ('Намибия'),
               ('Науру'),
               ('Непал'),
               ('Нигер'),
               ('Нигерия'),
               ('Нидерланды'),
               ('Никарагуа'),
               ('Новая Зеландия'),
               ('Норвегия'),
               ('ОАЭ'),
               ('Оман'),
               ('Пакистан'),
               ('Палау'),
               ('Панама'),
               ('Папуа Новая Гвинея'),
               ('Парагвай'),
               ('Перу'),
               ('Польша'),
               ('Португалия'),
               ('Россия'),
               ('Руанда'),
               ('Румыния'),
               ('Сальвадор'),
               ('Самоа'),
               ('Сан-Марино'),
               ('Сан-Томе и Принсипи'),
               ('Саудовская Аравия'),
               ('Свазиленд'),
               ('Северная Ирландия'),
               ('Сейшельские Острова'),
               ('Сенегал'),
               ('Сент-Винсент и Гренадины'),
               ('Сент-Китс и Невис'),
               ('Сент-Люсия'),
               ('Сербия'),
               ('Сингапур'),
               ('Сирия'),
               ('Словакия'),
               ('Словения'),
               ('Соломоновы Острова'),
               ('Сомали'),
               ('Судан'),
               ('Суринам'),
               ('США'),
               ('Сьерра-Леоне'),
               ('Таджикистан'),
               ('Таиланд'),
               ('Танзания'),
               ('Того'),
               ('Тонга'),
               ('Тринидад и Тобаго'),
               ('Тувалу'),
               ('Тунис'),
               ('Туркмения'),
               ('Турция'),
               ('Уганда'),
               ('Узбекистан'),
               ('Украина'),
               ('Уругвай'),
               ('Уэльс'),
               ('Фиджи'),
               ('Филиппины'),
               ('Финляндия'),
               ('Франция'),
               ('Хорватия'),
               ('ЦАР'),
               ('Чад'),
               ('Черногория'),
               ('Чехия'),
               ('Чили'),
               ('Швейцария'),
               ('Швеция'),
               ('Шотландия'),
               ('Шри-Ланка'),
               ('Эквадор'),
               ('Экваториальная Гвинея'),
               ('Эритрея'),
               ('Эстония'),
               ('Эфиопия'),
               ('ЮАР'),
               ('Южный Судан'),
               ('Ямайка'),
               ('Япония');";