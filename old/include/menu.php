<?php

$igosja_menu = array(
    array('label' => 'VIP-клуб',        'url' => '/vip.php'),
    array('label' => 'Аренда',          'url' => '/rent_list.php'),
    array('label' => 'Главная',         'url' => '/'),
    array('label' => 'Забыли пароль?',  'url' => '/password.php'),
    array('label' => 'Игроки',          'url' => '/player_list.php'),
    array('label' => 'Команды',         'url' => '/team_list.php'),
    array('label' => 'Магазин',         'url' => '/shop.php'),
    array('label' => 'Новости',         'url' => '/news.php',           'css' => 'count_news'),
    array('label' => 'Обмены',          'url' => 'javascript:;'),
    array('label' => 'Общение',         'url' => '/dialog_list.php',    'css' => 'count_dialog'),
    array('label' => 'Опросы',          'url' => '/vote_list.php',      'css' => 'count_vote'),
    array('label' => 'Правила',         'url' => '/rule_list.php'),
    array('label' => 'Профиль',         'url' => '/user_view.php'),
    array('label' => 'Расписание',      'url' => '/schedule.php'),
    array('label' => 'Рейтинги',        'url' => '/rating.php'),
    array('label' => 'Регистрация',     'url' => '/signup.php',         'css' => 'red'),
    array('label' => 'Ростер',          'url' => '/team_view.php',      'css' => 'red'),
    array('label' => 'Сборная',         'url' => '/national_view.php',  'css' => 'national_css'),
    array('label' => 'Сменить клуб',    'url' => '/team_change.php'),
    array('label' => 'Тех.поддержка',   'url' => '/support.php',        'css' => 'count_support'),
    array('label' => 'Трансфер',        'url' => '/transfer_list.php'),
    array('label' => 'Турниры',         'url' => '/tournament.php'),
    array('label' => 'Федерация',       'url' => '/country_news.php',   'css' => 'count_countrynews'),
    array('label' => 'Форум',           'url' => '/forum.php',          'target' => '_blank'),
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

for ($i=0; $i<4; $i++)
{
    $a_menu = array();

    if (0 == $i)
    {
        $menu = 'igosja_menu_guest';
    }
    elseif (1 == $i)
    {
        $menu = 'igosja_menu_guest_mobile';
    }
    elseif (2 == $i)
    {
        $menu = 'igosja_menu_login';
    }
    else
    {
        $menu = 'igosja_menu_login_mobile';
    }

    $foreach_menu = $$menu;

    for ($j=0; $j<count($foreach_menu); $j++)
    {
        foreach ($foreach_menu[$j] as $item)
        {
            if (isset($item['css']))
            {
                $css = $item['css'];
            }
            else
            {
                $css = '';
            }

            if (isset($item['target']))
            {
                $target = $item['target'];
            }
            else
            {
                $target = '';
            }

            $a_menu[] = '<a href="' . $item['url'] . '" class="' . $css . '" target="' . $target . '">' . $item['label'] . '</a>';
        }

        $foreach_menu[$j]   = $a_menu;
        $a_menu             = array();
    }

    foreach ($foreach_menu as $item)
    {
        $a_menu[] = implode(' | ', $item);
    }

    $$menu = implode('<br>', $a_menu);
}

unset($igosja_menu, $foreach_menu, $a_menu, $i, $j, $item, $css);