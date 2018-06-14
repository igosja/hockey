<?php

/**
 * Друкуємо рядок в консолі з інформацією про відсоток виконаних функцій під час генерації ігрового дня
 * @param $current integer номер поточної функції
 * @param $total integer загальна кількість функцій
 * @param $name string назва функції
 */
function f_igosja_console_progress($current, $total, $name)
{
    $percent = round($current / $total * 100, 1);

    print "\r" . $percent . '% - ' . $name . '                                         ';
    flush();
}