<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);
$page = Url::toRoute(['/site/activation'], true);

?>
    You are successfully registered on the Virtual Hockey League website under the <?= $model->user_login; ?> login
    To complete the registration, please confirm your email by clicking <?= $link; ?>
    or enter the <?= $model->user_code; ?> on the page <?= $page; ?>