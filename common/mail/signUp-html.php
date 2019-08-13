<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);
$page = Url::toRoute(['/site/activation'], true);

?>
    Вы успешно зарегистрированы на сайте Виртуальной Хоккейной Лиги под логином
    <strong><?= Html::encode($model->user_login); ?></strong>.
    <br/>
    Чтобы завершить регистрацию подтвердите свой email по ссылке <?= Html::a($link, $link); ?>
    или введите код <strong><?= $model->user_code; ?></strong> на странице <?= Html::a($page, $page); ?>