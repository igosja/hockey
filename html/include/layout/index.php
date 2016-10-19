<html>
<head>
    <title>Hockey online manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="efe586f3c07b0a93"/>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="main">
    <div class="content">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center error">
            Сайт находится в стадии разработки.<br/>Часть функций ограничена.
        </div>
        <div class="row">
            <?php if (isset($auth_user_id)) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <?= $auth_user_login; ?>
                    <a href="/login/logout" class="btn margin">Выйти</a>
                </div>
            <?php } else { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <form action="/login" class="form-inline" method="POST">
                        <label for="t-form-login">Логин</label>
                        <input class="form-control form-small" type="text" id="t-form-login" name="data[login]"/>
                        <label for="t-form-pass">Пароль</label>
                        <input class="form-control form-small" type="password" id="t-form-pass" name="data[password]"/>
                        <button type="submit" class="btn">Вход</button>
                    </form>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs text-center menu">
                <?= $igosja_menu; ?>
            </div>
            <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center menu">
                <?= $igosja_menu_mobile; ?>
            </div>
        </div>
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs text-center <?= $_SESSION['message']['class']; ?>">
                    <?= $_SESSION['message']['text']; ?>
                </div>
            </div>
        <?php } ?>
        <?php

        if (file_exists(__DIR__ . '/../../' . $route_path . '/' . $route_file . '.php')) {
            include(__DIR__ . '/../../' . $route_path . '/' . $route_file . '.php');
        } else {
            print $route_file . '.html не найден';
        }

        ?>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
            Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.,
            <?= $count_query; ?> запр.<br/>
            <?= number_format(memory_get_usage(), 0, ',', ' '); ?> Б памяти
        </div>
    </div>
</div>
<?php if (file_exists(__DIR__ . '/../../js/' . $route_path . '.js')) { ?>
    <script src="/js/jquery.js"></script>
    <script src="/js/<?= $route_path; ?>.js"></script>
<?php } ?>
</body>
</html>