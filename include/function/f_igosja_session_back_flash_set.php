<?php

/**
 * Записуємо в сесію інформаційне повідомлення
 *
 * @param $class string css-class повідомлення
 * @param $message string текст повідомлення
 */
function f_igosja_session_back_flash_set($class, $message)
{
    $_SESSION['backend']['message']['class']    = $class;
    $_SESSION['backend']['message']['text']     = $message;
}