<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);
$page = Url::toRoute(['/site/activation'], true);

?>
<?= Yii::t('common-mail', 'signUp-text', [
    'login' => $model->user_login,
    'code' => $model->user_code,
    'link' => $link,
    'page' => $page,
]); ?>