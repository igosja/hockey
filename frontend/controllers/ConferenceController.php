<?php

namespace frontend\controllers;

use common\models\Conference;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class ConferenceController
 * @package frontend\controllers
 */
class ConferenceController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $count = Conference::find()->where(['conference_season_id' => $seasonId])->count();

        $seasonArray = $this->getSeasonArray();

        $this->setSeoTitle('Конференция любительских клубов');

        return $this->render('index', [
            'count' => $count,
            'seasonArray' => $seasonArray,
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @return array
     */
    private function getSeasonArray(): array
    {
        $season = Conference::find()
            ->select(['conference_season_id'])
            ->groupBy(['conference_season_id'])
            ->orderBy(['conference_season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($season, 'conference_season_id', 'conference_season_id');
    }
}
