<?php

include(__DIR__ . '/../include/include.php');

$exception_array = array(
    'folder' => array(
        '.git',
    ),
    'file' => array(
        '.gitignore',
        '.htaccess',
        'activation.php',
        'activation_repeat.php',
        'admin/city_create.php',
        'admin/city_delete.php',
        'admin/city_list.php',
        'admin/city_update.php',
        'admin/city_view.php',
        'admin/code_review.php',
        'admin/country_create.php',
        'admin/country_delete.php',
        'admin/country_list.php',
        'admin/country_update.php',
        'admin/country_view.php',
        'admin/debug_delete.php',
        'admin/debug_list.php',
        'admin/debug_truncate.php',
        'admin/index.php',
        'admin/name_create.php',
        'admin/name_delete.php',
        'admin/name_list.php',
        'admin/name_update.php',
        'admin/name_view.php',
        'admin/news_create.php',
        'admin/news_delete.php',
        'admin/news_list.php',
        'admin/news_update.php',
        'admin/news_view.php',
        'admin/rule_create.php',
        'admin/rule_delete.php',
        'admin/rule_list.php',
        'admin/rule_update.php',
        'admin/rule_view.php',
        'admin/shedule_change.php',
        'admin/site_version.php',
        'admin/stadium_create.php',
        'admin/stadium_delete.php',
        'admin/stadium_list.php',
        'admin/stadium_update.php',
        'admin/stadium_view.php',
        'admin/support_list.php',
        'admin/support_view.php',
        'admin/surname_create.php',
        'admin/surname_delete.php',
        'admin/surname_list.php',
        'admin/surname_update.php',
        'admin/surname_view.php',
        'include/breadcrumb.php',
        'include/constant.php',
        'include/database.php',
        'include/filter.php',
        'include/function.php',
        'include/generator.php',
        'include/include.php',
        'include/Mail.php',
        'include/menu.php',
        'include/pagination_count.php',
        'include/pagination_offset.php',
        'include/routing.php',
        'include/season.php',
        'include/seo.php',
        'include/session.php',
        'include/site.php',
        'include/start.php',
        'include/table_link.php',
        'team_view.php',
        'view/activation.php',
        'view/activation_repeat.php',
        'view/team_view.php',
    ),
);

$file_array = array();

$file_array = f_igosja_read_dir_to_array($file_array, __DIR__ . '/../', $exception_array);

$breadcrumb_array[] = 'Code review';

$summary_from   = 1;
$summary_to     = count($file_array);
$count_item     = $summary_to;

include(__DIR__ . '/view/layout/main.php');