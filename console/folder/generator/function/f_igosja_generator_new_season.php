<?php

/**
 * Переходимо в новий сезон
 */
function f_igosja_generator_new_season()
{
    $sql = "SELECT COUNT(`schedule_id`) AS `check`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`-86400, '%Y-%m-%d')=CURDATE()";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $check_array[0]['check'])
    {
        $function_array = array(
            'f_igosja_newseason_insert_season',
            'f_igosja_newseason_injury',
            'f_igosja_newseason_building_base',
            'f_igosja_newseason_building_stadium',
            'f_igosja_newseason_older_player',
            'f_igosja_newseason_phisicalchange',
            'f_igosja_newseason_phisical',
            'f_igosja_newseason_fire_national',
            'f_igosja_newseason_tire_base_level',
            'f_igosja_newseason_pension',
        );

        /*
         * + добавить season_id в БД
         * + вылечить все травмы
         * + закончить все строительства баз и стадионов
         * ротация чемпионатов, добавление новых дивизионов из конференции
         * призовые
         * новые календари чемп, конференция, межсезонье, сборные, ЛЧ
         * + увольнение тренеров сборных
         * участники лиги чемпионов
         * + старение игроков
         * + пенсия игроков (с обесцвечиванием линии)
         * рост силы молодых игроков
         * + компенсиция за ветеранов
         * уход игроков из сборных
         * завершение тренировок, изучений, подготовки молодежи
         * + очистка таблицы физцентра phisicalchange
         * достижения команд и менеджеров
         * достижения хоккеистов
         * содержание базы
         * очистка teamwork для пенсионеров и 0
         * зарплата тренерам сборных
         * компенсация клубам за сборников
         * + усталость на уровень баз
         * + случайная физ форма
         * пересчет реальной силы хоккеистов
         */
    }
}