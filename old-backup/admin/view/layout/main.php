<?php
/**
 * @var $tpl string
 * @var $site_array array
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Административный раздел</title>
    <link href="/css/bootstrap.css?v=<?= filemtime(__DIR__ . '/../../../css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="/css/metisMenu.css?v=<?= filemtime(__DIR__ . '/../../../css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="/css/sb-admin-2.css?v=<?= filemtime(__DIR__ . '/../../../css/sb-admin-2.css'); ?>" rel="stylesheet">
    <link href="/css/morris.css?v=<?= filemtime(__DIR__ . '/../../../css/morris.css'); ?>" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css?v=<?= filemtime(__DIR__ . '/../../../font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin/">Админ</a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell-o fa-fw"></i>
                    <span class="badge" id="admin-bell"></span>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="/admin/teamask_list.php">
                            <i class="fa fa-user fa-fw"></i> Заявки на команды
                            <span class="badge admin-teamask"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/logo_list.php">
                            <i class="fa fa-shield fa-fw"></i> Логотипы
                            <span class="badge admin-logo"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/support_list.php">
                            <i class="fa fa-comments fa-fw"></i> Тех. поддержка
                            <span class="badge admin-support"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/complain_list.php">
                            <i class="fa fa-exclamation-circle fa-fw"></i> Жалобы
                            <span class="badge admin-complain"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/vote_list.php">
                            <i class="fa fa-bar-chart  fa-fw"></i> Опросы
                            <span class="badge admin-vote"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="/admin/site_status.php">
                            <i class="fa fa-power-off fa-fw"></i>
                            <?php if ($site_array[0]['site_status']) { ?>
                                Выключить
                            <?php } else { ?>
                                Включить
                            <?php } ?>
                            сайт
                        </a>
                    </li>
                    <li>
                        <a href="/admin/site_version.php">
                            <i class="fa fa-signal fa-fw"></i> Версия сайта
                        </a>
                    </li>
                    <li>
                        <a href="/admin/debug_list.php">
                            <i class="fa fa-bug fa-fw"></i> MySQL
                        </a>
                    </li>
                    <li>
                        <a href="/admin/error_log.php">
                            <i class="fa fa-file-text-o fa-fw"></i> Error log
                        </a>
                    </li>
                    <li>
                        <a href="/admin/code_review.php">
                            <i class="fa fa-file-code-o fa-fw"></i> Code review
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="navbar-default sidebar">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="javascript:">
                            Пользователи <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/user_list.php">Пользователи</a>
                            </li>
                            <li>
                                <a href="/admin/president_list.php">Президенты федераций</a>
                            </li>
                            <li>
                                <a href="/admin/coach_list.php">Теренера сборных</a>
                            </li>
                            <li>
                                <a href="/admin/blockreason_list.php">Причины блокировки</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Команды <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/team_list.php">Команды</a>
                            </li>
                            <li>
                                <a href="/admin/stadium_list.php">Стадионы</a>
                            </li>
                            <li>
                                <a href="/admin/city_list.php">Города</a>
                            </li>
                            <li>
                                <a href="/admin/country_list.php">Страны</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Хоккеисты <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/name_list.php">Имена</a>
                            </li>
                            <li>
                                <a href="/admin/surname_list.php">Фамилии</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Новости <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/news_list.php">Новости</a>
                            </li>
                            <li>
                                <a href="/admin/prenews_view.php">Предварительные новости</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Правила <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/rule_list.php">Правила</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Турниры <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/tournamenttype_list.php">Типы турниров</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Опросы <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/vote_list.php">Опросы</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Расписание <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/schedule_change.php">Перевести дату</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Форум <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/forumchapter_list.php">Разделы</a>
                            </li>
                            <li>
                                <a href="/admin/forumgroup_list.php">Группы</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:">
                            Показатели сайта <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/siteinfo_game.php">Игровая статистика</a>
                            </li>
                        </ul>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/admin/snapshot.php">Статистические данные</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <?php include(__DIR__ . '/../include/breadcrumb.php'); ?>
        <?php if (isset($_SESSION['backend']['message'])) { ?>
            <div class="alert alert-<?= $_SESSION['backend']['message']['class']; ?> margin-top">
                <?= $_SESSION['backend']['message']['text']; ?>
                <?php unset($_SESSION['backend']['message']); ?>
            </div>
        <?php } ?>
        <?php include(__DIR__ . '/../' . $tpl . '.php'); ?>
    </div>
</div>
<script src="/js/jquery.js?v=<?= filemtime(__DIR__ . '/../../../js/jquery.js'); ?>"></script>
<script src="/js/bootstrap.js?v=<?= filemtime(__DIR__ . '/../../../js/bootstrap.js'); ?>"></script>
<script src="/js/metisMenu.js?v=<?= filemtime(__DIR__ . '/../../../js/metisMenu.js'); ?>"></script>
<script src="/js/sb-admin-2.js?v=<?= filemtime(__DIR__ . '/../../../js/sb-admin-2.js'); ?>"></script>
<script src="/js/admin.js?v=<?= filemtime(__DIR__ . '/../../../js/admin.js'); ?>"></script>
</body>
</html>
<?php f_igosja_get_count_query(); ?>