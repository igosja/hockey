<?php

/**
 * Перетворюємо bb коди на html
 * @param $text string текст з bb
 * @return string
 */
function f_igosja_bb_decode($text)
{
    $text = str_replace('[p]', '<p>', $text);
    $text = str_replace('[/p]', '</p>', $text);
    $text = str_replace('[table]', '<table class="table table-bordered table-hover">', $text);
    $text = str_replace('[/table]', '</table>', $text);
    $text = str_replace('[tr]', '<tr>', $text);
    $text = str_replace('[/tr]', '</tr>', $text);
    $text = str_replace('[th]', '<th>', $text);
    $text = str_replace('[/th]', '</th>', $text);
    $text = str_replace('[td]', '<td>', $text);
    $text = str_replace('[/td]', '</td>', $text);
    $text = str_replace('[ul]', '<ul>', $text);
    $text = str_replace('[/ul]', '</ul>', $text);
    $text = str_replace('[li]', '<li>', $text);
    $text = str_replace('[/li]', '</li>', $text);
    $text = str_replace('[b]', '<strong>', $text);
    $text = str_replace('[/b]', '</strong>', $text);
    $text = str_replace('[i]', '<em>', $text);
    $text = str_replace('[/i]', '</em>', $text);
    $text = str_replace('[u]', '<ins>', $text);
    $text = str_replace('[/u]', '</ins>', $text);
    $text = str_replace('[s]', '<del>', $text);
    $text = str_replace('[/s]', '</del>', $text);
    $text = preg_replace("/\[link(?:\=(?:[\"|'])?(.*)(?:[^[]+)?)?\](.*)\[\/link\]/i", '<a href="$1">$2</a>', $text);
    $text = nl2br($text);

    return $text;
}