<?php

include (__DIR__ . '/include/include.php');

$_SESSION['message']['class']   = 'error';
$_SESSION['message']['text']    = 'Счет пополнить не удалось.';

redirect('/shop.php');