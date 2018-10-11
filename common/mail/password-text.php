<?php

/**
 * @var common\models\User $model
 */

use yii\helpers\Url;

$link = Url::toRoute(['/site/activation', 'code' => $model->user_code], true);

?>
<?= Yii::t('common-mail', 'password-text', [
    'link' => $link,
]); ?>