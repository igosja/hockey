<?php

include (__DIR__ . '/include/include.php');

$_SESSION['message']['class']   = 'success';
$_SESSION['message']['text']    = 'Счет успешно пополнен.';

redirect('/shop.php');