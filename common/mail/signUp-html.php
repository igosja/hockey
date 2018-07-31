<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);
$page = Url::toRoute(['/site/activation'], true);

?>
    You are successfully registered on the Virtual Hockey League website
    under the <strong><?= $model->user_login; ?></strong> login
    To complete the registration, please confirm your email by clicking <?= Html::a($link, $link); ?>
    or enter the <strong><?= $model->user_code; ?></strong> on the page <?= Html::a($page, $page); ?>