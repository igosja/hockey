<?php

include(__DIR__ . '/../include/include.php');

$text = file_get_contents(__DIR__ . '/../error.log');

$breadcrumb_array[] = 'Лог ошибок';

include(__DIR__ . '/view/layout/main.php');