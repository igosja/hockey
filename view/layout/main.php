<?php
/**
 * @var $auth_user_login string
 * @var $igosja_menu_mobile array
 * @var $tpl string
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Виртуальная хоккейная лига</title>
    <meta name="description" content="Виртуальная хоккейная лига - лучший бесплатный хоккейный онлайн менеджер.">
    <meta name="keywords" content="Virtual hockey online manager, VHOL, хоккейный онлайн менеджер, вируальный хоккей">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="efe586f3c07b0a93"/>
    <meta name="google-site-verification" content="RBlpWHwlnGqvB36CLDYF58VqxN0bcz5W5JbxcX-PTeQ" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="main">
    <div class="content">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left xs-text-center">
                <a href="/index.php">
                    <img class="img-responsive" src="/img/logo.png"/>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
                <br/>
                <?php if (isset($auth_user_id)) { ?>
                    <?= $auth_user_login; ?>
                    <a href="/logout.php" class="btn margin">Выйти</a>
                <?php } else { ?>
                    <form action="/login.php" class="form-inline" method="POST">
                        <label for="t-form-login">Логин</label>
                        <input class="form-control form-small" type="text" id="t-form-login" name="data[login]"/>
                        <label for="t-form-pass">Пароль</label>
                        <input class="form-control form-small" type="password" id="t-form-pass" name="data[password]"/>
                        <button type="submit" class="btn">Вход</button>
                    </form>
                <?php } ?>
            </div>
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

        <?php include(__DIR__ . '/../' . $tpl . '.php'); ?>

    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
            Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.,
            <?= f_igosja_get_count_query(); ?> запр.<br/>
            Потребление памяти - <?= number_format(memory_get_usage(), 0, ',', ' '); ?> Б<br/>
            Версия
            <?=
            $site_array[0]['site_version_1']
            . '.'
            . $site_array[0]['site_version_2']
            . '.'
            . $site_array[0]['site_version_3']
            . '.'
            . $site_array[0]['site_version_4'];
            ?>
            от
            <?= f_igosja_ufu_date($site_array[0]['site_version_date']); ?>
        </div>
    </div>
</div>
<?php if (file_exists(__DIR__ . '/../../js/' . $tpl . '.js')) { ?>
    <script src="/js/jquery.js"></script>
    <script src="/js/<?= $tpl; ?>.js"></script>
<?php } ?>
<?php if ('vhol.org' == $_SERVER['HTTP_HOST']) { ?>
    <!--LiveInternet counter-->
    <script type="text/javascript"><!--
        new Image().src = "//counter.yadro.ru/hit?r"+
            escape(document.referrer)+((typeof(screen)=="undefined")?"":
                ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
            ";"+Math.random();//-->
    </script>
    <!--/LiveInternet-->
    <!--Google analitics-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-90926144-1', 'auto');
        ga('send', 'pageview');
    </script>
    <!--/Google analitics-->
<?php } ?>
</body>
</html>