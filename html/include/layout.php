<html>
<head>
    <title>Hockey online manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="main">
    <div class="content">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center error">
            Сайт находится в стадии разработки.<br/>Часть функций ограничена.
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                <!--                <img src="/img/logo.png">-->
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                <form action="login" class="form-inline">
                    <label for="top-form-login">Логин</label>
                    <input class="form-control form-small" type="text" id="top-form-login" name="data[login]"/>
                    <label for="top-form-pass">Пароль</label>
                    <input class="form-control form-small" type="password" id="top-form-pass" name="data[password]"/>
                    <button type="submit" class="btn">Вход</button>
                </form>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs text-center menu">
            <?= $igosja_menu; ?>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center menu">
            <?= $igosja_menu_mobile; ?>
        </div>
        <?php

        if (file_exists(__DIR__ . '/../' . $route_file . '.php')) {
            include(__DIR__ . '/../' . $route_file . '.php');
        } else {
            print $route_file . '.html не найден';
        }

        ?>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
            Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.,
            <?= $count_query; ?> запр.
        </div>
    </div>
</div>
<?php if (file_exists(__DIR__ . '/../../js/' . $route_file . '.js')) { ?>
    <script src="/js/jquery.js"></script>
    <script src="/js/<?= $route_file; ?>.js"></script>
<?php } ?>
</body>
</html>