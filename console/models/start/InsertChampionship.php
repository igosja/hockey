<?php

namespace console\models\start;

use common\components\ErrorHelper;
use common\models\Championship;
use common\models\City;
use common\models\Division;
use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use common\models\Team;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertChampionship
 * @package console\models\start
 */
class InsertChampionship
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute(): void
    {
        $seasonId = Season::getCurrentSeason();

        $countryArray = City::find()
            ->select(['city_country_id'])
            ->where(['!=', 'city_id', 0])
            ->groupBy('city_country_id')
            ->orderBy(['city_country_id' => SORT_ASC])
            ->all();

        foreach ($countryArray as $country) {
            $teamArray = Team::find()
                ->joinWith(['stadium.city'])
                ->select(['team_id'])
                ->where(['city_country_id' => $country->city_country_id])
                ->orderBy(['team_id' => SORT_ASC])
                ->limit(16)
                ->all();
            foreach ($teamArray as $team) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new Championship();
                    $model->championship_country_id = $country->city_country_id;
                    $model->championship_division_id = Division::D1;
                    $model->championship_season_id = $seasonId;
                    $model->championship_team_id = $team->team_id;
                    if (!$model->save()) {
                        throw new Exception(ErrorHelper::modelErrorsToString($model));
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }

            $teamArray = Team::find()
                ->joinWith(['stadium.city'])
                ->select(['team_id'])
                ->where(['city_country_id' => $country->city_country_id])
                ->orderBy(['team_id' => SORT_ASC])
                ->offset(16)
                ->limit(16)
                ->all();
            foreach ($teamArray as $team) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new Championship();
                    $model->championship_country_id = $country->city_country_id;
                    $model->championship_division_id = Division::D2;
                    $model->championship_season_id = $seasonId;
                    $model->championship_team_id = $team->team_id;
                    if (!$model->save()) {
                        throw new Exception(ErrorHelper::modelErrorsToString($model));
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }
        }

        $scheduleArray = Schedule::find()
            ->select(['schedule_id'])
            ->where([
                'schedule_season_id' => $seasonId,
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP
            ])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->limit(30)
            ->all();

        $schedule_id_01 = $scheduleArray[0]->schedule_id;
        $schedule_id_02 = $scheduleArray[1]->schedule_id;
        $schedule_id_03 = $scheduleArray[2]->schedule_id;
        $schedule_id_04 = $scheduleArray[3]->schedule_id;
        $schedule_id_05 = $scheduleArray[4]->schedule_id;
        $schedule_id_06 = $scheduleArray[5]->schedule_id;
        $schedule_id_07 = $scheduleArray[6]->schedule_id;
        $schedule_id_08 = $scheduleArray[7]->schedule_id;
        $schedule_id_09 = $scheduleArray[8]->schedule_id;
        $schedule_id_10 = $scheduleArray[9]->schedule_id;
        $schedule_id_11 = $scheduleArray[10]->schedule_id;
        $schedule_id_12 = $scheduleArray[11]->schedule_id;
        $schedule_id_13 = $scheduleArray[12]->schedule_id;
        $schedule_id_14 = $scheduleArray[13]->schedule_id;
        $schedule_id_15 = $scheduleArray[14]->schedule_id;
        $schedule_id_16 = $scheduleArray[15]->schedule_id;
        $schedule_id_17 = $scheduleArray[16]->schedule_id;
        $schedule_id_18 = $scheduleArray[17]->schedule_id;
        $schedule_id_19 = $scheduleArray[18]->schedule_id;
        $schedule_id_20 = $scheduleArray[19]->schedule_id;
        $schedule_id_21 = $scheduleArray[20]->schedule_id;
        $schedule_id_22 = $scheduleArray[21]->schedule_id;
        $schedule_id_23 = $scheduleArray[22]->schedule_id;
        $schedule_id_24 = $scheduleArray[23]->schedule_id;
        $schedule_id_25 = $scheduleArray[24]->schedule_id;
        $schedule_id_26 = $scheduleArray[25]->schedule_id;
        $schedule_id_27 = $scheduleArray[26]->schedule_id;
        $schedule_id_28 = $scheduleArray[27]->schedule_id;
        $schedule_id_29 = $scheduleArray[28]->schedule_id;
        $schedule_id_30 = $scheduleArray[29]->schedule_id;

        foreach ($countryArray as $country) {
            for ($i = Division::D1; $i <= Division::D2; $i++) {
                /** @var Championship[] $teamArray */
                $teamArray = Championship::find()
                    ->select(['championship_team_id'])
                    ->where([
                        'championship_country_id' => $country->city_country_id,
                        'championship_division_id' => $i,
                        'championship_season_id' => $seasonId,
                    ])
                    ->orderBy('RAND()')
                    ->all();
                $team_id_01 = $teamArray[0]->championship_team_id;
                $team_id_02 = $teamArray[1]->championship_team_id;
                $team_id_03 = $teamArray[2]->championship_team_id;
                $team_id_04 = $teamArray[3]->championship_team_id;
                $team_id_05 = $teamArray[4]->championship_team_id;
                $team_id_06 = $teamArray[5]->championship_team_id;
                $team_id_07 = $teamArray[6]->championship_team_id;
                $team_id_08 = $teamArray[7]->championship_team_id;
                $team_id_09 = $teamArray[8]->championship_team_id;
                $team_id_10 = $teamArray[9]->championship_team_id;
                $team_id_11 = $teamArray[10]->championship_team_id;
                $team_id_12 = $teamArray[11]->championship_team_id;
                $team_id_13 = $teamArray[12]->championship_team_id;
                $team_id_14 = $teamArray[13]->championship_team_id;
                $team_id_15 = $teamArray[14]->championship_team_id;
                $team_id_16 = $teamArray[15]->championship_team_id;

                $stadium_id_01 = $teamArray[0]->team->team_stadium_id;
                $stadium_id_02 = $teamArray[1]->team->team_stadium_id;
                $stadium_id_03 = $teamArray[2]->team->team_stadium_id;
                $stadium_id_04 = $teamArray[3]->team->team_stadium_id;
                $stadium_id_05 = $teamArray[4]->team->team_stadium_id;
                $stadium_id_06 = $teamArray[5]->team->team_stadium_id;
                $stadium_id_07 = $teamArray[6]->team->team_stadium_id;
                $stadium_id_08 = $teamArray[7]->team->team_stadium_id;
                $stadium_id_09 = $teamArray[8]->team->team_stadium_id;
                $stadium_id_10 = $teamArray[9]->team->team_stadium_id;
                $stadium_id_11 = $teamArray[10]->team->team_stadium_id;
                $stadium_id_12 = $teamArray[11]->team->team_stadium_id;
                $stadium_id_13 = $teamArray[12]->team->team_stadium_id;
                $stadium_id_14 = $teamArray[13]->team->team_stadium_id;
                $stadium_id_15 = $teamArray[14]->team->team_stadium_id;
                $stadium_id_16 = $teamArray[15]->team->team_stadium_id;

                $data = [
                    [$team_id_02, $team_id_01, $schedule_id_01, $stadium_id_02],
                    [$team_id_03, $team_id_15, $schedule_id_01, $stadium_id_03],
                    [$team_id_04, $team_id_14, $schedule_id_01, $stadium_id_04],
                    [$team_id_05, $team_id_13, $schedule_id_01, $stadium_id_05],
                    [$team_id_06, $team_id_12, $schedule_id_01, $stadium_id_06],
                    [$team_id_07, $team_id_11, $schedule_id_01, $stadium_id_07],
                    [$team_id_08, $team_id_10, $schedule_id_01, $stadium_id_08],
                    [$team_id_16, $team_id_09, $schedule_id_01, $stadium_id_16],
                    [$team_id_01, $team_id_03, $schedule_id_02, $stadium_id_01],
                    [$team_id_02, $team_id_16, $schedule_id_02, $stadium_id_02],
                    [$team_id_10, $team_id_09, $schedule_id_02, $stadium_id_10],
                    [$team_id_11, $team_id_08, $schedule_id_02, $stadium_id_11],
                    [$team_id_12, $team_id_07, $schedule_id_02, $stadium_id_12],
                    [$team_id_13, $team_id_06, $schedule_id_02, $stadium_id_13],
                    [$team_id_14, $team_id_05, $schedule_id_02, $stadium_id_14],
                    [$team_id_15, $team_id_04, $schedule_id_02, $stadium_id_15],
                    [$team_id_03, $team_id_02, $schedule_id_03, $stadium_id_03],
                    [$team_id_04, $team_id_01, $schedule_id_03, $stadium_id_04],
                    [$team_id_05, $team_id_15, $schedule_id_03, $stadium_id_05],
                    [$team_id_06, $team_id_14, $schedule_id_03, $stadium_id_06],
                    [$team_id_07, $team_id_13, $schedule_id_03, $stadium_id_07],
                    [$team_id_08, $team_id_12, $schedule_id_03, $stadium_id_08],
                    [$team_id_09, $team_id_11, $schedule_id_03, $stadium_id_09],
                    [$team_id_16, $team_id_10, $schedule_id_03, $stadium_id_16],
                    [$team_id_01, $team_id_05, $schedule_id_04, $stadium_id_01],
                    [$team_id_02, $team_id_04, $schedule_id_04, $stadium_id_02],
                    [$team_id_03, $team_id_16, $schedule_id_04, $stadium_id_03],
                    [$team_id_11, $team_id_10, $schedule_id_04, $stadium_id_11],
                    [$team_id_12, $team_id_09, $schedule_id_04, $stadium_id_12],
                    [$team_id_13, $team_id_08, $schedule_id_04, $stadium_id_13],
                    [$team_id_14, $team_id_07, $schedule_id_04, $stadium_id_14],
                    [$team_id_15, $team_id_06, $schedule_id_04, $stadium_id_15],
                    [$team_id_04, $team_id_03, $schedule_id_05, $stadium_id_04],
                    [$team_id_05, $team_id_02, $schedule_id_05, $stadium_id_05],
                    [$team_id_06, $team_id_01, $schedule_id_05, $stadium_id_06],
                    [$team_id_07, $team_id_15, $schedule_id_05, $stadium_id_07],
                    [$team_id_08, $team_id_14, $schedule_id_05, $stadium_id_08],
                    [$team_id_09, $team_id_13, $schedule_id_05, $stadium_id_09],
                    [$team_id_10, $team_id_12, $schedule_id_05, $stadium_id_10],
                    [$team_id_16, $team_id_11, $schedule_id_05, $stadium_id_16],
                    [$team_id_01, $team_id_07, $schedule_id_06, $stadium_id_01],
                    [$team_id_02, $team_id_06, $schedule_id_06, $stadium_id_02],
                    [$team_id_03, $team_id_05, $schedule_id_06, $stadium_id_03],
                    [$team_id_04, $team_id_16, $schedule_id_06, $stadium_id_04],
                    [$team_id_12, $team_id_11, $schedule_id_06, $stadium_id_12],
                    [$team_id_13, $team_id_10, $schedule_id_06, $stadium_id_13],
                    [$team_id_14, $team_id_09, $schedule_id_06, $stadium_id_14],
                    [$team_id_15, $team_id_08, $schedule_id_06, $stadium_id_15],
                    [$team_id_05, $team_id_04, $schedule_id_07, $stadium_id_05],
                    [$team_id_06, $team_id_03, $schedule_id_07, $stadium_id_06],
                    [$team_id_07, $team_id_02, $schedule_id_07, $stadium_id_07],
                    [$team_id_08, $team_id_01, $schedule_id_07, $stadium_id_08],
                    [$team_id_09, $team_id_15, $schedule_id_07, $stadium_id_09],
                    [$team_id_10, $team_id_14, $schedule_id_07, $stadium_id_10],
                    [$team_id_11, $team_id_13, $schedule_id_07, $stadium_id_11],
                    [$team_id_16, $team_id_12, $schedule_id_07, $stadium_id_16],
                    [$team_id_01, $team_id_09, $schedule_id_08, $stadium_id_01],
                    [$team_id_02, $team_id_08, $schedule_id_08, $stadium_id_02],
                    [$team_id_03, $team_id_07, $schedule_id_08, $stadium_id_03],
                    [$team_id_04, $team_id_06, $schedule_id_08, $stadium_id_04],
                    [$team_id_05, $team_id_16, $schedule_id_08, $stadium_id_05],
                    [$team_id_13, $team_id_12, $schedule_id_08, $stadium_id_13],
                    [$team_id_14, $team_id_11, $schedule_id_08, $stadium_id_14],
                    [$team_id_15, $team_id_10, $schedule_id_08, $stadium_id_15],
                    [$team_id_06, $team_id_05, $schedule_id_09, $stadium_id_06],
                    [$team_id_07, $team_id_04, $schedule_id_09, $stadium_id_07],
                    [$team_id_08, $team_id_03, $schedule_id_09, $stadium_id_08],
                    [$team_id_09, $team_id_02, $schedule_id_09, $stadium_id_09],
                    [$team_id_10, $team_id_01, $schedule_id_09, $stadium_id_10],
                    [$team_id_11, $team_id_15, $schedule_id_09, $stadium_id_11],
                    [$team_id_12, $team_id_14, $schedule_id_09, $stadium_id_12],
                    [$team_id_16, $team_id_13, $schedule_id_09, $stadium_id_16],
                    [$team_id_01, $team_id_11, $schedule_id_10, $stadium_id_01],
                    [$team_id_02, $team_id_10, $schedule_id_10, $stadium_id_02],
                    [$team_id_03, $team_id_09, $schedule_id_10, $stadium_id_03],
                    [$team_id_04, $team_id_08, $schedule_id_10, $stadium_id_04],
                    [$team_id_05, $team_id_07, $schedule_id_10, $stadium_id_05],
                    [$team_id_06, $team_id_16, $schedule_id_10, $stadium_id_06],
                    [$team_id_14, $team_id_13, $schedule_id_10, $stadium_id_14],
                    [$team_id_15, $team_id_12, $schedule_id_10, $stadium_id_15],
                    [$team_id_07, $team_id_06, $schedule_id_11, $stadium_id_07],
                    [$team_id_08, $team_id_05, $schedule_id_11, $stadium_id_08],
                    [$team_id_09, $team_id_04, $schedule_id_11, $stadium_id_09],
                    [$team_id_10, $team_id_03, $schedule_id_11, $stadium_id_10],
                    [$team_id_11, $team_id_02, $schedule_id_11, $stadium_id_11],
                    [$team_id_12, $team_id_01, $schedule_id_11, $stadium_id_12],
                    [$team_id_13, $team_id_15, $schedule_id_11, $stadium_id_13],
                    [$team_id_16, $team_id_14, $schedule_id_11, $stadium_id_16],
                    [$team_id_01, $team_id_13, $schedule_id_12, $stadium_id_01],
                    [$team_id_02, $team_id_12, $schedule_id_12, $stadium_id_02],
                    [$team_id_03, $team_id_11, $schedule_id_12, $stadium_id_03],
                    [$team_id_04, $team_id_10, $schedule_id_12, $stadium_id_04],
                    [$team_id_05, $team_id_09, $schedule_id_12, $stadium_id_05],
                    [$team_id_06, $team_id_08, $schedule_id_12, $stadium_id_06],
                    [$team_id_07, $team_id_16, $schedule_id_12, $stadium_id_07],
                    [$team_id_15, $team_id_14, $schedule_id_12, $stadium_id_15],
                    [$team_id_08, $team_id_07, $schedule_id_13, $stadium_id_08],
                    [$team_id_09, $team_id_06, $schedule_id_13, $stadium_id_09],
                    [$team_id_10, $team_id_05, $schedule_id_13, $stadium_id_10],
                    [$team_id_11, $team_id_04, $schedule_id_13, $stadium_id_11],
                    [$team_id_12, $team_id_03, $schedule_id_13, $stadium_id_12],
                    [$team_id_13, $team_id_02, $schedule_id_13, $stadium_id_13],
                    [$team_id_14, $team_id_01, $schedule_id_13, $stadium_id_14],
                    [$team_id_16, $team_id_15, $schedule_id_13, $stadium_id_16],
                    [$team_id_01, $team_id_15, $schedule_id_14, $stadium_id_01],
                    [$team_id_02, $team_id_14, $schedule_id_14, $stadium_id_02],
                    [$team_id_03, $team_id_13, $schedule_id_14, $stadium_id_03],
                    [$team_id_04, $team_id_12, $schedule_id_14, $stadium_id_04],
                    [$team_id_05, $team_id_11, $schedule_id_14, $stadium_id_05],
                    [$team_id_06, $team_id_10, $schedule_id_14, $stadium_id_06],
                    [$team_id_07, $team_id_09, $schedule_id_14, $stadium_id_07],
                    [$team_id_16, $team_id_08, $schedule_id_14, $stadium_id_16],
                    [$team_id_09, $team_id_08, $schedule_id_15, $stadium_id_09],
                    [$team_id_10, $team_id_07, $schedule_id_15, $stadium_id_10],
                    [$team_id_11, $team_id_06, $schedule_id_15, $stadium_id_11],
                    [$team_id_12, $team_id_05, $schedule_id_15, $stadium_id_12],
                    [$team_id_13, $team_id_04, $schedule_id_15, $stadium_id_13],
                    [$team_id_14, $team_id_03, $schedule_id_15, $stadium_id_14],
                    [$team_id_15, $team_id_02, $schedule_id_15, $stadium_id_15],
                    [$team_id_16, $team_id_01, $schedule_id_15, $stadium_id_16],
                    [$team_id_01, $team_id_02, $schedule_id_16, $stadium_id_01],
                    [$team_id_15, $team_id_03, $schedule_id_16, $stadium_id_15],
                    [$team_id_14, $team_id_04, $schedule_id_16, $stadium_id_14],
                    [$team_id_13, $team_id_05, $schedule_id_16, $stadium_id_13],
                    [$team_id_12, $team_id_06, $schedule_id_16, $stadium_id_12],
                    [$team_id_11, $team_id_07, $schedule_id_16, $stadium_id_11],
                    [$team_id_10, $team_id_08, $schedule_id_16, $stadium_id_10],
                    [$team_id_09, $team_id_16, $schedule_id_16, $stadium_id_09],
                    [$team_id_03, $team_id_01, $schedule_id_17, $stadium_id_03],
                    [$team_id_16, $team_id_02, $schedule_id_17, $stadium_id_16],
                    [$team_id_09, $team_id_10, $schedule_id_17, $stadium_id_09],
                    [$team_id_08, $team_id_11, $schedule_id_17, $stadium_id_08],
                    [$team_id_07, $team_id_12, $schedule_id_17, $stadium_id_07],
                    [$team_id_06, $team_id_13, $schedule_id_17, $stadium_id_06],
                    [$team_id_05, $team_id_14, $schedule_id_17, $stadium_id_05],
                    [$team_id_04, $team_id_15, $schedule_id_17, $stadium_id_04],
                    [$team_id_02, $team_id_03, $schedule_id_18, $stadium_id_02],
                    [$team_id_01, $team_id_04, $schedule_id_18, $stadium_id_01],
                    [$team_id_15, $team_id_05, $schedule_id_18, $stadium_id_15],
                    [$team_id_14, $team_id_06, $schedule_id_18, $stadium_id_14],
                    [$team_id_13, $team_id_07, $schedule_id_18, $stadium_id_13],
                    [$team_id_12, $team_id_08, $schedule_id_18, $stadium_id_12],
                    [$team_id_11, $team_id_09, $schedule_id_18, $stadium_id_11],
                    [$team_id_10, $team_id_16, $schedule_id_18, $stadium_id_10],
                    [$team_id_05, $team_id_01, $schedule_id_19, $stadium_id_05],
                    [$team_id_04, $team_id_02, $schedule_id_19, $stadium_id_04],
                    [$team_id_16, $team_id_03, $schedule_id_19, $stadium_id_16],
                    [$team_id_10, $team_id_11, $schedule_id_19, $stadium_id_10],
                    [$team_id_09, $team_id_12, $schedule_id_19, $stadium_id_09],
                    [$team_id_08, $team_id_13, $schedule_id_19, $stadium_id_08],
                    [$team_id_07, $team_id_14, $schedule_id_19, $stadium_id_07],
                    [$team_id_06, $team_id_15, $schedule_id_19, $stadium_id_06],
                    [$team_id_03, $team_id_04, $schedule_id_20, $stadium_id_03],
                    [$team_id_02, $team_id_05, $schedule_id_20, $stadium_id_02],
                    [$team_id_01, $team_id_06, $schedule_id_20, $stadium_id_01],
                    [$team_id_15, $team_id_07, $schedule_id_20, $stadium_id_15],
                    [$team_id_14, $team_id_08, $schedule_id_20, $stadium_id_14],
                    [$team_id_13, $team_id_09, $schedule_id_20, $stadium_id_13],
                    [$team_id_12, $team_id_10, $schedule_id_20, $stadium_id_12],
                    [$team_id_11, $team_id_16, $schedule_id_20, $stadium_id_11],
                    [$team_id_07, $team_id_01, $schedule_id_21, $stadium_id_07],
                    [$team_id_06, $team_id_02, $schedule_id_21, $stadium_id_06],
                    [$team_id_05, $team_id_03, $schedule_id_21, $stadium_id_05],
                    [$team_id_16, $team_id_04, $schedule_id_21, $stadium_id_16],
                    [$team_id_11, $team_id_12, $schedule_id_21, $stadium_id_11],
                    [$team_id_10, $team_id_13, $schedule_id_21, $stadium_id_10],
                    [$team_id_09, $team_id_14, $schedule_id_21, $stadium_id_09],
                    [$team_id_08, $team_id_15, $schedule_id_21, $stadium_id_08],
                    [$team_id_04, $team_id_05, $schedule_id_22, $stadium_id_04],
                    [$team_id_03, $team_id_06, $schedule_id_22, $stadium_id_03],
                    [$team_id_02, $team_id_07, $schedule_id_22, $stadium_id_02],
                    [$team_id_01, $team_id_08, $schedule_id_22, $stadium_id_01],
                    [$team_id_15, $team_id_09, $schedule_id_22, $stadium_id_15],
                    [$team_id_14, $team_id_10, $schedule_id_22, $stadium_id_14],
                    [$team_id_13, $team_id_11, $schedule_id_22, $stadium_id_13],
                    [$team_id_12, $team_id_16, $schedule_id_22, $stadium_id_12],
                    [$team_id_09, $team_id_01, $schedule_id_23, $stadium_id_09],
                    [$team_id_08, $team_id_02, $schedule_id_23, $stadium_id_08],
                    [$team_id_07, $team_id_03, $schedule_id_23, $stadium_id_07],
                    [$team_id_06, $team_id_04, $schedule_id_23, $stadium_id_06],
                    [$team_id_16, $team_id_05, $schedule_id_23, $stadium_id_16],
                    [$team_id_12, $team_id_13, $schedule_id_23, $stadium_id_12],
                    [$team_id_11, $team_id_14, $schedule_id_23, $stadium_id_11],
                    [$team_id_10, $team_id_15, $schedule_id_23, $stadium_id_10],
                    [$team_id_05, $team_id_06, $schedule_id_24, $stadium_id_05],
                    [$team_id_04, $team_id_07, $schedule_id_24, $stadium_id_04],
                    [$team_id_03, $team_id_08, $schedule_id_24, $stadium_id_03],
                    [$team_id_02, $team_id_09, $schedule_id_24, $stadium_id_02],
                    [$team_id_01, $team_id_10, $schedule_id_24, $stadium_id_01],
                    [$team_id_15, $team_id_11, $schedule_id_24, $stadium_id_15],
                    [$team_id_14, $team_id_12, $schedule_id_24, $stadium_id_14],
                    [$team_id_13, $team_id_16, $schedule_id_24, $stadium_id_13],
                    [$team_id_11, $team_id_01, $schedule_id_25, $stadium_id_11],
                    [$team_id_10, $team_id_02, $schedule_id_25, $stadium_id_10],
                    [$team_id_09, $team_id_03, $schedule_id_25, $stadium_id_09],
                    [$team_id_08, $team_id_04, $schedule_id_25, $stadium_id_08],
                    [$team_id_07, $team_id_05, $schedule_id_25, $stadium_id_07],
                    [$team_id_16, $team_id_06, $schedule_id_25, $stadium_id_16],
                    [$team_id_13, $team_id_14, $schedule_id_25, $stadium_id_13],
                    [$team_id_12, $team_id_15, $schedule_id_25, $stadium_id_12],
                    [$team_id_06, $team_id_07, $schedule_id_26, $stadium_id_06],
                    [$team_id_05, $team_id_08, $schedule_id_26, $stadium_id_05],
                    [$team_id_04, $team_id_09, $schedule_id_26, $stadium_id_04],
                    [$team_id_03, $team_id_10, $schedule_id_26, $stadium_id_03],
                    [$team_id_02, $team_id_11, $schedule_id_26, $stadium_id_02],
                    [$team_id_01, $team_id_12, $schedule_id_26, $stadium_id_01],
                    [$team_id_15, $team_id_13, $schedule_id_26, $stadium_id_15],
                    [$team_id_14, $team_id_16, $schedule_id_26, $stadium_id_14],
                    [$team_id_13, $team_id_01, $schedule_id_27, $stadium_id_13],
                    [$team_id_12, $team_id_02, $schedule_id_27, $stadium_id_12],
                    [$team_id_11, $team_id_03, $schedule_id_27, $stadium_id_11],
                    [$team_id_10, $team_id_04, $schedule_id_27, $stadium_id_10],
                    [$team_id_09, $team_id_05, $schedule_id_27, $stadium_id_09],
                    [$team_id_08, $team_id_06, $schedule_id_27, $stadium_id_08],
                    [$team_id_16, $team_id_07, $schedule_id_27, $stadium_id_16],
                    [$team_id_14, $team_id_15, $schedule_id_27, $stadium_id_14],
                    [$team_id_07, $team_id_08, $schedule_id_28, $stadium_id_07],
                    [$team_id_06, $team_id_09, $schedule_id_28, $stadium_id_06],
                    [$team_id_05, $team_id_10, $schedule_id_28, $stadium_id_05],
                    [$team_id_04, $team_id_11, $schedule_id_28, $stadium_id_04],
                    [$team_id_03, $team_id_12, $schedule_id_28, $stadium_id_03],
                    [$team_id_02, $team_id_13, $schedule_id_28, $stadium_id_02],
                    [$team_id_01, $team_id_14, $schedule_id_28, $stadium_id_01],
                    [$team_id_15, $team_id_16, $schedule_id_28, $stadium_id_15],
                    [$team_id_15, $team_id_01, $schedule_id_29, $stadium_id_15],
                    [$team_id_14, $team_id_02, $schedule_id_29, $stadium_id_14],
                    [$team_id_13, $team_id_03, $schedule_id_29, $stadium_id_13],
                    [$team_id_12, $team_id_04, $schedule_id_29, $stadium_id_12],
                    [$team_id_11, $team_id_05, $schedule_id_29, $stadium_id_11],
                    [$team_id_10, $team_id_06, $schedule_id_29, $stadium_id_10],
                    [$team_id_09, $team_id_07, $schedule_id_29, $stadium_id_09],
                    [$team_id_08, $team_id_16, $schedule_id_29, $stadium_id_08],
                    [$team_id_08, $team_id_09, $schedule_id_30, $stadium_id_08],
                    [$team_id_07, $team_id_10, $schedule_id_30, $stadium_id_07],
                    [$team_id_06, $team_id_11, $schedule_id_30, $stadium_id_06],
                    [$team_id_05, $team_id_12, $schedule_id_30, $stadium_id_05],
                    [$team_id_04, $team_id_13, $schedule_id_30, $stadium_id_04],
                    [$team_id_03, $team_id_14, $schedule_id_30, $stadium_id_03],
                    [$team_id_02, $team_id_15, $schedule_id_30, $stadium_id_02],
                    [$team_id_01, $team_id_16, $schedule_id_30, $stadium_id_01],
                ];

                Yii::$app->db
                    ->createCommand()
                    ->batchInsert(
                        Game::tableName(),
                        ['game_home_team_id', 'game_guest_team_id', 'game_schedule_id', 'game_stadium_id'],
                        $data
                    )
                    ->execute();
            }
        }
    }
}
