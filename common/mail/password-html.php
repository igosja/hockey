<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Html;
use yii\helpers\Url;

$link = Url::toRoute(['/site/password-restore', 'code' => $model->user_code], true);

?>
<?= Yii::t('common-mail', 'password-html', [
    'link' => Html::a($link, $link),
]); ?>