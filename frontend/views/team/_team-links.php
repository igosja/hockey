<?php

use common\components\ErrorHelper;
use frontend\widgets\LinkBar;

try {
    print LinkBar::widget([
        'items' => [
            [
                'text' => Yii::t('frontend-views-team-team-links', 'player'),
                'url' => ['team/view', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => Yii::t('frontend-views-team-team-links', 'game'),
                'url' => ['team/game', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => Yii::t('frontend-views-team-team-links', 'statistics'),
                'url' => ['team/statistics', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => Yii::t('frontend-views-team-team-links', 'deal'),
                'url' => ['team/deal', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => Yii::t('frontend-views-team-team-links', 'event'),
                'url' => ['team/event', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => Yii::t('frontend-views-team-team-links', 'finance'),
                'url' => ['team/finance', 'id' => Yii::$app->request->get('id', 1)],
            ],
            [
                'text' => Yii::t('frontend-views-team-team-links', 'achievement'),
                'url' => ['team/achievement', 'id' => Yii::$app->request->get('id', 1)],
            ],
        ]
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}
