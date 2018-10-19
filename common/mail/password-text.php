<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);

?>
    Вы запросили восстановление пароля на сайте Виртуальной Хоккейной Лиги.
    Чтобы восстановить пароль перейдите по ссылке <?= $link; ?>