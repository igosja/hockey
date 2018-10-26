<?php

namespace frontend\controllers;

use common\models\Conference;
use Yii;
use yii\data\ActiveDataProvider;
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

        $this->setSeoTitle('Конференция любительских клубов');

        return $this->render('index', [
            'count' => $count,
            'seasonArray' => $this->getSeasonArray(),
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @return string
     */
    public function actionTable(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = Conference::find()
            ->where(['conference_season_id' => $seasonId])
            ->orderBy(['conference_place' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Конференция любительских клубов');

        return $this->render('table', [
            'dataProvider' => $dataProvider,
            'seasonArray' => $this->getSeasonArray(),
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
