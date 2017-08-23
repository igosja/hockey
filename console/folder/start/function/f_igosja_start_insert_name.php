<?php

/**
 * Додаємо імена хокеїстів
 */
function f_igosja_start_insert_name()
{
    global $mysqli;

    $che_name = array(
        'Адам',
        'Давид',
        'Даниель',
        'Доминик',
        'Зденек',
        'Иаков',
        'Иржи',
        'Йозеф',
        'Карел',
        'Карл',
        'Ладислав',
        'Лукаш',
        'Майкл',
        'Марек',
        'Мартин',
        'Матей',
        'Милан',
        'Мирослав',
        'Михал',
        'Ондржей',
        'Павел',
        'Петр',
        'Питер',
        'Пол',
        'Томас',
        'Филипп',
        'Франтишек',
        'Шимон',
        'Штепан',
        'Якуб',
        'Ян',
        'Ярослав',
    );
    $eng_name = array(
        'Адам',
        'Алекс',
        'Альберт',
        'Артур',
        'Арчи',
        'Бенджамин',
        'Блейк',
        'Бобби',
        'Гарри',
        'Генри',
        'Даниэль',
        'Декстер',
        'Джейден',
        'Джейк',
        'Джейкоб',
        'Джейми',
        'Джеймс',
        'Джек',
        'Дженсон',
        'Джозеф',
        'Джордж',
        'Джошуа',
        'Джуд',
        'Дилан',
        'Дэвид',
        'Итан',
        'Кай',
        'Каллум',
        'Коннор',
        'Кэмерон',
        'Лео',
        'Леон',
        'Логан',
        'Луис',
        'Лукас',
        'Льюис',
        'Люк',
        'Майкл',
        'Макс',
        'Мейсон',
        'Мэтью',
        'Натан',
        'Оливер',
        'Олли',
        'Оскар',
        'Остин',
        'Оуэн',
        'Райан',
        'Райли',
        'Роберт',
        'Ронни',
        'Рубен',
        'Себастьян',
        'Сонни',
        'Стэнли',
        'Тайлер',
        'Тедди',
        'Тео',
        'Теодор',
        'Тоби',
        'Томас',
        'Томми',
        'Уильям',
        'Феликс',
        'Финли',
        'Фредди',
        'Фредерик',
        'Фрэнки',
        'Харви',
        'Харли',
        'Харрисон',
        'Хьюго',
        'Чарльз',
        'Эван',
        'Эдвард',
        'Эйден',
        'Элайджа',
        'Эллиот',
    );
    $fin_name = array(
        'Антеро',
        'Антти',
        'Ильмари',
        'Йоханнес',
        'Калеви',
        'Кари',
        'Матиас',
        'Матти',
        'Микаэль',
        'Олави',
        'Оливер',
        'Онни',
        'Пекка',
        'Пентти',
        'Тапани',
        'Тапио',
        'Тимо',
        'Хейкки',
        'Элиас',
        'Эркки',
        'Ээмели',
        'Юхани',
    );
    $ger_name = array(
        'Александр',
        'Андреас',
        'Берд',
        'Вальтер',
        'Вацлав',
        'Вернер',
        'Владимир',
        'Вольфганг',
        'Ганс',
        'Гельмут',
        'Герхард',
        'Горст',
        'Гюнтер',
        'Джон',
        'Дитер',
        'Йенс',
        'Йорг',
        'Клаус',
        'Кристиан',
        'Манфред',
        'Мартин',
        'Матиас',
        'Михаель',
        'Питер',
        'Рольф',
        'Свен',
        'Стефан',
        'Томас',
        'Торстен',
        'Уве',
        'Франк',
        'Хайнс',
        'Юрген',
    );
    $nor_name = array(
        'Александр',
        'Арне',
        'Бйорн',
        'Йонас',
        'Кнут',
        'Кристиан',
        'Кьелл',
        'Ларс',
        'Лукас',
        'Магнус',
        'Маркус',
        'Матиас',
        'Оле',
        'Оливер',
        'Свейн',
        'Тобиас',
        'Томас',
        'Уильям',
        'Филип',
        'Эмиль',
        'Ян',
    );
    $rus_name = array(
        'Александр',
        'Алексей',
        'Анатолий',
        'Андрей',
        'Антон',
        'Арсений',
        'Артём',
        'Артур',
        'Богдан',
        'Вадим',
        'Валерий',
        'Василий',
        'Виктор',
        'Виталий',
        'Владимир',
        'Владислав',
        'Вячеслав',
        'Георгий',
        'Глеб',
        'Григорий',
        'Даниил',
        'Денис',
        'Дмитрий',
        'Евгений',
        'Егор',
        'Иван',
        'Игорь',
        'Илья',
        'Кирилл',
        'Константин',
        'Максим',
        'Матвей',
        'Михаил',
        'Никита',
        'Николай',
        'Олег',
        'Павел',
        'Пётр',
        'Роман',
        'Руслан',
        'Святослав',
        'Семён',
        'Сергей',
        'Станислав',
        'Степан',
        'Тимофей',
        'Тимур',
        'Фёдор',
        'Юрий',
        'Ярослав',
    );
    $swe_name = array(
        'Александр',
        'Андерс',
        'Андреас',
        'Бенгт',
        'Бу',
        'Гуннар',
        'Густав',
        'Даниель',
        'Йоран',
        'Карл',
        'Кристер',
        'Ларс',
        'Леннарт',
        'Магнус',
        'Мартин',
        'Микаель',
        'Нильс',
        'Оке',
        'Оскар',
        'Пер',
        'Петер',
        'Свен',
        'Стефан',
        'Томас',
        'Улоф',
        'Фредрик',
        'Ханс',
        'Эрик',
        'Юхан',
        'Ян',
    );

    $name_array = array(
        array(
            'country' => 'Канада',
            'list' => $eng_name,
        ),
        array(
            'country' => 'Россия',
            'list' => $rus_name,
        ),
        array(
            'country' => 'США',
            'list' => $eng_name,
        ),
        array(
            'country' => 'Финляндия',
            'list' => $fin_name,
        ),
        array(
            'country' => 'Швеция',
            'list' => $swe_name,
        ),
        array(
            'country' => 'Чехия',
            'list' => $che_name,
        ),
        array(
            'country' => 'Швейцария',
            'list' => $ger_name,
        ),
        array(
            'country' => 'Словакия',
            'list' => $che_name,
        ),
        array(
            'country' => 'Белоруссия',
            'list' => $rus_name,
        ),
        array(
            'country' => 'Германия',
            'list' => $ger_name,
        ),
        array(
            'country' => 'Норвегия',
            'list' => $nor_name,
        ),
        array(
            'country' => 'Украина',
            'list' => $rus_name,
        ),
    );

    $name_id_array = array();

    foreach ($name_array as $country)
    {
        $country_name = $country['country'];

        $sql = "SELECT `country_id`
                FROM `country`
                WHERE `country_name`='$country_name'
                LIMIT 1";
        $country_sql = f_igosja_mysqli_query($sql, false);

        $country_array = $country_sql->fetch_all(1);

        $country_id = $country_array[0]['country_id'];

        foreach ($country['list'] as $item)
        {
            $sql = "SELECT `name_id`
                    FROM `name`
                    WHERE `name_name`='$item'
                    LIMIT 1";
            $name_sql = f_igosja_mysqli_query($sql, false);

            if (0 == $name_sql->num_rows)
            {
                $sql = "INSERT INTO `name`
                        SET `name_name`='$item'";
                f_igosja_mysqli_query($sql, false);

                $name_id = $mysqli->insert_id;
            }
            else
            {
                $nam_array = $name_sql->fetch_all(1);

                $name_id = $nam_array[0]['name_id'];
            }

            $name_id_array[] = '(' . $country_id . ', ' . $name_id . ')';
        }
    }

    $sql = "INSERT INTO `namecountry` (`namecountry_country_id`, `namecountry_name_id`)
            VALUES " . implode(', ', $name_id_array) . ";";
    f_igosja_mysqli_query($sql, false);
}