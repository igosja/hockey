<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::toRoute(['/site/password-restore', 'code' => $model->user_code], true);

?>
    Вы запросили восстановление пароля на сайте Виртуальной Хоккейной Лиги.
    <br>
    Чтобы восстановить пароль перейдите по ссылке <?= Html::a($link, $link); ?>