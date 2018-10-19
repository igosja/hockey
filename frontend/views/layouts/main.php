<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 * @var \frontend\controllers\BaseController $this ->context
 */

use common\components\ErrorHelper;
use common\models\Site;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use frontend\widgets\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

//use yii\widgets\Pjax;

AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <?php if (YII_ENV_PROD) : ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90926144-1"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());
                gtag('config', 'UA-90926144-1');
            </script>
            <!-- /Global site tag (gtag.js) - Google Analytics -->
            <!--LiveInternet counter-->
            <script type="text/javascript">
                new Image().src = "//counter.yadro.ru/hit?r" +
                    escape(document.referrer) + ((typeof(screen) === "undefined") ? "" :
                        ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
                        screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
                    ";h" + escape(document.title.substring(0, 150)) +
                    ";" + Math.random();
            </script>
            <!--/LiveInternet-->
        <?php endif; ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <?php //Pjax::begin(); ?>
    <div class="main">
        <div class="content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left xs-text-center">
                    <?= Html::a(
                        Html::img(
                            '/img/logo.png',
                            ['alt' => 'Виртуальная Хоккейная Лига', 'class' => 'img-responsive']
                        ),
                        ['site/index']
                    ); ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
                    <br/>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('Вход', ['site/login'], ['class' => 'btn']); ?>
                    <?php else: ?>
                        <?= Html::beginForm(['team/change-my-team'], 'post', ['class' => 'form-inline']); ?>
                        <?= Html::dropDownList(
                            'teamId',
                            $this->context->myTeam->team_id ?? 0,
                            ArrayHelper::map($this->context->myTeamArray, 'team_id', 'team_name'),
                            ['class' => 'form-control', 'onchange' => 'this.form.submit();']
                        ); ?>
                        <?= Html::a('Выход', ['site/logout'], ['class' => 'btn margin']); ?>
                        <?= Html::endForm(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center menu">
                    <?php

                    try {
                        print Menu::widget();
                    } catch (Exception $e) {
                        ErrorHelper::log($e);
                    }

                    ?>
                </div>
            </div>
            <noscript>
                <div class="row margin-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                        В вашем браузере отключен JavaScript.
                        Для корректной работы сайта рекомендуется включить JavaScript.
                    </div>
                </div>
            </noscript>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
                    Сайт находится в режиме разработки.<br/>Некоторые функции сайта могут быть недоступны.
                </div>
            </div>
            <?php

            try {
                print Alert::widget();
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
            <?= $content; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
                Страница сгенерирована за <?= round(Yii::getLogger()->getElapsedTime(), 5); ?> сек,
                <?= Yii::getLogger()->getDbProfiling()[0]; ?> запр.
                <br/>
                Потребление памяти - <?= Yii::$app->formatter->asInteger(memory_get_peak_usage()); ?> Б
                <br/>
                <?= Site::version(); ?>
            </div>
        </div>
    </div>
    <?php //Pjax::end(); ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>