<?php

/**
 * Запаковуємо ДБ в архів
 */
function f_igosja_generator_dump_database()
{
    exec('mysqldump -u igosja_hockey -p\'zuI2QbJJ\' igosja_hockey | gzip > `date +/home/i/igosja/vhol.org/dump.\%Y\%m\%d.sql.gz`');
}