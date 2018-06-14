<?php

/**
 * Перетворюємо bb коди на html
 * @param $text string текст з bb
 * @return string
 */
function f_igosja_bb_decode($text)
{
    $text = preg_replace('/\[link\=(.*?)\](.*?)\[\/link\]/s', '<a href="$1" target="_blank">$2</a>', $text);
    $text = preg_replace('/\[url\=(.*?)\](.*?)\[\/url\]/s', '<a href="$1" target="_blank">$2</a>', $text);
    $text = preg_replace('/\[img\](.*?)\[\/img\]/i', '<img class="img-responsive" src="$1" />', $text);
    $text = str_replace('class="img-responsive" src="https://vhol.org/img/', 'src="https://vhol.org/img/', $text);
    $text = str_replace('class="img-responsive" src="/img/', 'src="/img/', $text);
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
    $text = str_replace('[list]', '<ul>', $text);
    $text = str_replace('[/list]', '</ul>', $text);
    $text = str_replace('[list=1]', '<ol>', $text);
    $text = str_replace('[/list]', '</ol>', $text);
    $text = str_replace('[*]', '<li>', $text);
    $text = str_replace('[/*]', '</li>', $text);
    $text = str_replace('[b]', '<strong>', $text);
    $text = str_replace('[/b]', '</strong>', $text);
    $text = str_replace('[i]', '<em>', $text);
    $text = str_replace('[/i]', '</em>', $text);
    $text = str_replace('[u]', '<ins>', $text);
    $text = str_replace('[/u]', '</ins>', $text);
    $text = str_replace('[s]', '<del>', $text);
    $text = str_replace('[/s]', '</del>', $text);
    $text = str_replace('[quote]', '<blockquote>', $text);
    $text = str_replace('[/quote]', '</blockquote>', $text);
    $text = str_replace(':)', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm01.png" />', $text);
    $text = str_replace(':(', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm02.png" />', $text);
    $text = str_replace(':D', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm03.png" />', $text);
    $text = str_replace(';)', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm04.png" />', $text);
    $text = str_replace(':boss:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm05.png" />', $text);
    $text = str_replace(':applause:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm06.png" />', $text);
    $text = str_replace(':surprise:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm07.png" />', $text);
    $text = str_replace(':sick:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm08.png" />', $text);
    $text = str_replace(':angry:', '<img alt="smile" src="/js/wysibb/theme/default/img/smiles/sm09.png" />', $text);
    $text = nl2br($text);

    return $text;
}