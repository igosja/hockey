<?php

namespace frontend\controllers;

use common\components\FormatHelper;
use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

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
                'tournamentType' => function (ActiveQuery $query) {
                    return $query->select(['tournament_type_id', 'tournament_type_name']);
                },
                'stage' => function (ActiveQuery $query) {
                    return $query->select(['stage_id', 'stage_name']);
                },
            ])
            ->select([
                'schedule_id',
                'schedule_date',
                'schedule_stage_id',
                'schedule_tournament_type_id',
            ])
            ->where(['schedule_season_id' => $seasonId])
            ->orderBy(['schedule_id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $scheduleId = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->limit(1)
            ->scalar();

        $this->setSeoTitle('Рассписание');

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
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $schedule = Schedule::find()
            ->with([
                'tournamentType' => function (ActiveQuery $query) {
                    return $query->select(['tournament_type_id', 'tournament_type_name']);
                },
                'stage' => function (ActiveQuery $query) {
                    return $query->select(['stage_id', 'stage_name']);
                },
            ])
            ->select([
                'schedule_date',
                'schedule_season_id',
                'schedule_stage_id',
                'schedule_tournament_type_id',
            ])
            ->where(['schedule_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($schedule);

        $query = Game::find()
            ->with([
                'nationalHome' => function (ActiveQuery $query) {
                    return $query->select(['national_id', 'national_country_id', 'national_national_type_id']);
                },
                'nationalHome.country' => function (ActiveQuery $query) {
                    return $query->select(['country_id', 'country_name']);
                },
                'nationalHome.nationalType' => function (ActiveQuery $query) {
                    return $query->select(['national_type_id', 'national_type_name']);
                },
                'nationalGuest' => function (ActiveQuery $query) {
                    return $query->select(['national_id', 'national_country_id', 'national_national_type_id']);
                },
                'nationalGuest.country' => function (ActiveQuery $query) {
                    return $query->select(['country_id', 'country_name']);
                },
                'nationalGuest.nationalType' => function (ActiveQuery $query) {
                    return $query->select(['national_type_id', 'national_type_name']);
                },
                'teamGuest' => function (ActiveQuery $query) {
                    return $query->select(['team_id', 'team_name', 'team_stadium_id']);
                },
                'teamGuest.stadium' => function (ActiveQuery $query) {
                    return $query->select(['stadium_id', 'stadium_city_id']);
                },
                'teamGuest.stadium.city' => function (ActiveQuery $query) {
                    return $query->select(['city_id', 'city_country_id', 'city_name']);
                },
                'teamGuest.stadium.city.country' => function (ActiveQuery $query) {
                    return $query->select(['country_id', 'country_name']);
                },
                'teamHome' => function (ActiveQuery $query) {
                    return $query->select(['team_id', 'team_name', 'team_stadium_id']);
                },
                'teamHome.stadium' => function (ActiveQuery $query) {
                    return $query->select(['stadium_id', 'stadium_city_id']);
                },
                'teamHome.stadium.city' => function (ActiveQuery $query) {
                    return $query->select(['city_id', 'city_country_id', 'city_name']);
                },
                'teamHome.stadium.city.country' => function (ActiveQuery $query) {
                    return $query->select(['country_id', 'country_name']);
                },
            ])
            ->select([
                'game_id',
                'game_guest_national_id',
                'game_guest_score',
                'game_guest_team_id',
                'game_home_national_id',
                'game_home_score',
                'game_home_team_id',
                'game_played'
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
