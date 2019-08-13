<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);
$page = Url::toRoute(['/site/activation'], true);

?>
    Вы успешно зарегистрированы на сайте Виртуальной Хоккейной Лиги под логином <?= Html::encode($model->user_login); ?>.
    Чтобы завершить регистрацию подтвердите свой email по ссылке <?= $link; ?> или введите код <?= $model->user_code; ?> на странице <?= $page; ?>