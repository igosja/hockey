<?php

use yii\helpers\Html;

/**
 * @var \frontend\controllers\BaseController $context
 * @var \yii\web\View $this
 */

$links = [
    'Games' => 'view',
    'Events' => 'event',
    'Deals' => 'deal',
    'Transfer' => 'transfer',
    'Loan' => 'loan',
    'Achievements' => 'achievement',
];
$playerId = Yii::$app->request->get('id');

$result = [];
foreach ($links as $label => $url) {
    if (strpos(Yii::$app->controller->getRoute(), $url)) {
        $result[] = Html::tag('span', $label, ['class' => 'strong']);
    } else {
        $result[] = Html::a($label, [$url, 'id' => $playerId]);
    }
}

print implode(' | ', $result);