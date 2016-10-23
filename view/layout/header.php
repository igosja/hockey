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
        <div class="row">
            <?php if (isset($auth_user_id)) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <?= $auth_user_login; ?>
                    <a href="/logout.php" class="btn margin">Выйти</a>
                </div>
            <?php } else { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <form action="/login.php" class="form-inline" method="POST">
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
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Сайт находится в стадии разработки.<br/>Часть функций ограничена.
            </div>
        </div>
        <noscript>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    В вашем браузере отключен javasript. Для корректной работы сайта рекомендуем включить javasript.
                </div>
            </div>
        </noscript>
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert <?= $_SESSION['message']['class']; ?>">
                    <?= $_SESSION['message']['text']; ?>
                    <?php unset($_SESSION['message']); ?>
                </div>
            </div>
        <?php } ?>