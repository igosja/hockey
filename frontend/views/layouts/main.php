<?php

/**
 * @var $content string
 * @var $this \yii\web\View
 */

use common\widgets\Alert;
use common\widgets\Menu;
use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;

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
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <?php Pjax::begin(); ?>
    <div class="main">
        <div class="content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left xs-text-center">
                    <?= Html::a(
                        Html::img('/img/logo.png', ['alt' => 'Virtual hockey league', 'class' => 'img-responsive']),
                        ['site/index']
                    ); ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('Log in', ['/site/login'], ['class' => 'btn']); ?>
                    <?php else: ?>
                        <form action="/team_view.php" class="form-inline" id="auth-team-form" method="post">
                            <label class="hidden" for="auth-team-select"></label>
                            <select class="form-control" id="auth-team-select" name="auth_team_id"
                                    onchange="this.form.submit();">
                                <?php foreach ($auth_team_array as $item) { ?>
                                    <option
                                        <?php if (($item['team_id'] == $auth_team_id && 0 == $auth_team_vice_id) || $item['team_id'] == $auth_team_vice_id) { ?>selected<?php } ?>
                                        value="<?= $item['team_id']; ?>"
                                    >
                                        <?= $item['team_name']; ?> (<?= $item['country_name']; ?>)
                                    </option>
                                <?php } ?>
                                <?php foreach ($auth_team_vice_array as $item) { ?>
                                    <option
                                        <?php if (($item['team_id'] == $auth_team_id && 0 == $auth_team_vice_id) || $item['team_id'] == $auth_team_vice_id) { ?>selected<?php } ?>
                                        value="<?= $item['team_id']; ?>"
                                    >
                                        <?= $item['team_name']; ?> (<?= $item['country_name']; ?>, зам)
                                    </option>
                                <?php } ?>
                            </select>
                            <a href="/logout.php" class="btn margin">Выйти</a>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center menu">
                    <?= Menu::widget(); ?>
                </div>
            </div>
            <noscript>
                <div class="row margin-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                        В вашем браузере отключен javascript. Для корректной работы сайта рекомендуем включить
                        javasript.
                    </div>
                </div>
            </noscript>
            <?php if (isset($_SESSION['frontend']['message'])) { ?>
                <div class="row margin-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert <?= $_SESSION['frontend']['message']['class']; ?>">
                        <?= $_SESSION['frontend']['message']['text']; ?>
                        <?php unset($_SESSION['frontend']['message']); ?>
                    </div>
                </div>
            <?php } ?>
            <?= $content; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
                Страница сгенерирована за <?= round(0.11545465, 5); ?> сек.,
                <?= 10; ?> запр.<br/>
                Потребление памяти - <?= number_format(memory_get_peak_usage(), 0, ',', ' '); ?> Б<br/>
                Версия
                0.0.0.1
                от
                <?= 123; ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>