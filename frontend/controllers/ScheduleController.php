<?php

namespace frontend\controllers;

use common\components\FormatHelper;
use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class ScheduleController
 * @package frontend\controllers
 */
class ScheduleController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
        $seasonArray = Season::getSeasonArray();

        $query = Schedule::find()
            ->with([
                'tournamentType',
                'stage',
            ])
            ->where(['schedule_season_id' => $seasonId])
            ->orderBy(['schedule_date' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $scheduleId = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->column();

        $this->setSeoTitle('Расписание');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'seasonArray' => $seasonArray,
            'seasonId' => $seasonId,
            'scheduleId' => $scheduleId,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $schedule = Schedule::find()
            ->with([
                'tournamentType',
                'stage',
            ])
            ->where(['schedule_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($schedule);

        $query = Game::find()
            ->with([
                'nationalHome.country',
                'nationalHome.nationalType',
                'nationalGuest.country',
                'nationalGuest.nationalType',
                'teamGuest.stadium.city.country',
                'teamHome.stadium.city.country',
            ])
            ->where(['game_schedule_id' => $id])
            ->orderBy(['game_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeGame'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Список матчей игрового дня ' . FormatHelper::asDate($schedule->schedule_date));

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'schedule' => $schedule,
        ]);
    }
}
