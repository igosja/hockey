<?php

/**
 * Записуємо в сесію інформаційне повідомлення
 *
 * @param $class string css-class повідомлення
 * @param $message string текст повідомлення
 */
function f_igosja_session_front_flash_set($class, $message)
{
    $_SESSION['frontend']['message']['class']   = $class;
    $_SESSION['frontend']['message']['text']    = $message;
}