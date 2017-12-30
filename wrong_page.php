<?php

include(__DIR__ . '/include/include.php');

if (isset($_SESSION['wrong_page_referrer']))
{
    error_log('wrong-page - ' . $_SESSION['wrong_page_referrer']);
    unset($_SESSION['wrong_page_referrer']);
}
else
{
    error_log($_SERVER['REQUEST_URI']);
}

$seo_title          = 'Страница выбрана неправильно';
$seo_description    = 'Страница выбрана неправильно на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'страница выбрана неправильно';

include(__DIR__ . '/view/layout/main.php');