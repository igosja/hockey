<?php

$igosja_menu = array(
    array('label' => 'VIP-клуб', 'url' => 'javascript:;'),
    array('label' => 'Аренда', 'url' => 'javascript:;'),
    array('label' => 'Главная', 'url' => '/'),
    array('label' => 'Забыли пароль?', 'url' => '/password'),
    array('label' => 'Игроки', 'url' => 'javascript:;'),
    array('label' => 'Команды', 'url' => 'javascript:;'),
    array('label' => 'Магазин', 'url' => 'javascript:;'),
    array('label' => 'Новости', 'url' => 'javascript:;'),
    array('label' => 'Обмены', 'url' => 'javascript:;'),
    array('label' => 'Общение', 'url' => 'javascript:;'),
    array('label' => 'Опросы', 'url' => 'javascript:;'),
    array('label' => 'Правила', 'url' => 'javascript:;'),
    array('label' => 'Профиль', 'url' => 'javascript:;'),
    array('label' => 'Расписание', 'url' => 'javascript:;'),
    array('label' => 'Рейтинги', 'url' => 'javascript:;'),
    array('label' => 'Регистрация', 'url' => '/signup', 'css' => 'red'),
    array('label' => 'Ростер', 'url' => 'javascript:;', 'css' => 'red'),
    array('label' => 'Сборная', 'url' => 'javascript:;'),
    array('label' => 'Сменить клуб', 'url' => 'javascript:;'),
    array('label' => 'Тех.поддержка', 'url' => 'javascript:;'),
    array('label' => 'Трансфер', 'url' => 'javascript:;'),
    array('label' => 'Турниры', 'url' => 'javascript:;'),
    array('label' => 'Федерация', 'url' => 'javascript:;'),
    array('label' => 'Форум', 'url' => 'javascript:;'),
);

$igosja_menu_guest = array(
    array(
        $igosja_menu[2],
        $igosja_menu[7],
        $igosja_menu[11],
        $igosja_menu[10],
        $igosja_menu[15],
        $igosja_menu[3],
    ),
    array(
        $igosja_menu[13],
        $igosja_menu[21],
        $igosja_menu[5],
        $igosja_menu[4],
        $igosja_menu[20],
        $igosja_menu[8],
        $igosja_menu[1],
    ),
    array(
        $igosja_menu[23],
        $igosja_menu[14],
    ),
);

$igosja_menu_guest_mobile = array(
    array(
        $igosja_menu[2],
        $igosja_menu[7],
        $igosja_menu[11],
        $igosja_menu[10],
    ),
    array(
        $igosja_menu[15],
        $igosja_menu[3],
    ),
    array(
        $igosja_menu[21],
        $igosja_menu[5],
        $igosja_menu[4],
    ),
    array(
        $igosja_menu[20],
        $igosja_menu[8],
        $igosja_menu[1],
    ),
    array(
        $igosja_menu[13],
        $igosja_menu[23],
        $igosja_menu[14],
    ),
);

$igosja_menu_login = array(
    array(
        $igosja_menu[2],
        $igosja_menu[7],
        $igosja_menu[11],
        $igosja_menu[0],
        $igosja_menu[10],
        $igosja_menu[18],
    ),
    array(
        $igosja_menu[16],
        $igosja_menu[17],
        $igosja_menu[12],
        $igosja_menu[13],
        $igosja_menu[21],
        $igosja_menu[5],
        $igosja_menu[4],
        $igosja_menu[20],
        $igosja_menu[8],
        $igosja_menu[1],
    ),
    array(
        $igosja_menu[9],
        $igosja_menu[22],
        $igosja_menu[6],
        $igosja_menu[23],
        $igosja_menu[19],
        $igosja_menu[14],
    ),
);

$igosja_menu_login_mobile = array(
    array(
        $igosja_menu[2],
        $igosja_menu[7],
        $igosja_menu[11],
    ),
    array(
        $igosja_menu[0],
        $igosja_menu[10],
        $igosja_menu[18],
    ),
    array(
        $igosja_menu[16],
        $igosja_menu[17],
        $igosja_menu[12],
        $igosja_menu[13],
    ),
    array(
        $igosja_menu[21],
        $igosja_menu[5],
        $igosja_menu[4],
    ),
    array(
        $igosja_menu[20],
        $igosja_menu[8],
        $igosja_menu[1],
    ),
    array(
        $igosja_menu[9],
        $igosja_menu[22],
        $igosja_menu[6],
    ),
    array(
        $igosja_menu[23],
        $igosja_menu[19],
        $igosja_menu[14],
    ),
);

for ($i = 0; $i < 4; $i++) {
    $a_menu = array();

    if (0 == $i) {
        $menu = 'igosja_menu_guest';
    } elseif (1 == $i) {
        $menu = 'igosja_menu_guest_mobile';
    } elseif (2 == $i) {
        $menu = 'igosja_menu_login';
    } else {
        $menu = 'igosja_menu_login_mobile';
    }

    $foreach_menu = $$menu;
    for ($j = 0; $j < count($foreach_menu); $j++) {
        foreach ($foreach_menu[$j] as $item) {
            $a_menu[] = '<a href="' . $item['url'] . '" class="' . (isset($item['css']) ? $item['css'] : '') . '">'
                . $item['label']
                . '</a>';
        }
        $foreach_menu[$j] = $a_menu;
        $a_menu = array();
    }

    foreach ($foreach_menu as $item) {
        $a_menu[] = implode(' | ', $item);
    }

    $$menu = implode('<br>', $a_menu);
}