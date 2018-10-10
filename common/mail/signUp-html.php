<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);
$page = Url::toRoute(['/site/activation'], true);

?>
<?= Yii::t('common-mail', 'signUp-html', [
    'login' => $model->user_login,
    'code' => $model->user_code,
    'link' => Html::a($link, $link),
    'page' => Html::a($page, $page),
]); ?>