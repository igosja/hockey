<?php

include (__DIR__ . '/include/include.php');

f_igosja_session_front_flash_set('error', 'Счет пополнить не удалось.');

redirect('/shop.php');