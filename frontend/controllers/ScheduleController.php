<?php

namespace frontend\controllers;

use common\models\Schedule;
use common\models\Season;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class ScheduleController
 * @package frontend\controllers
 */
class ScheduleController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
        $season = Season::find()->orderBy(['season_id' => SORT_DESC])->all();

        $query = Schedule::find()
            ->with(['tournamentType', 'stage'])
            ->where(['schedule_season_id' => $seasonId])
            ->orderBy(['schedule_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->view->title = 'Schedule';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Schedule - Virtual Hockey Online League'
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'season' => $season,
            'seasonId' => $seasonId,
        ]);
    }
}
