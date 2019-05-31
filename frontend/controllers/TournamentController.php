<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Division;
use common\models\Schedule;
use common\models\Season;
use common\models\TournamentType;
use Yii;
use yii\helpers\Html;

/**
 * Class TournamentController
 * @package frontend\controllers
 */
class TournamentController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
        $seasonArray = Season::getSeasonArray();

        $countryId = 0;
        $countryName = '';
        $countryArray = [];
        $divisionArray = [];

        $championshipArray = Championship::find()
            ->joinWith(['country'])
            ->with([
                'division',
            ])
            ->where(['championship_season_id' => $seasonId])
            ->groupBy(['championship_country_id', 'championship_division_id'])
            ->orderBy(['country_name' => SORT_ASC, 'championship_division_id' => SORT_ASC])
            ->all();

        foreach ($championshipArray as $item) {
            if ($countryId != $item->championship_country_id) {
                if ($countryId) {
                    $countryArray[] = [
                        'countryId' => $countryId,
                        'countryName' => $countryName,
                        'division' => $divisionArray,
                    ];
                }

                $countryId = $item->championship_country_id;
                $countryName = $item->country->country_name;
                $divisionArray = [];
            }

            $divisionArray[$item->championship_division_id] = $item->division->division_name;
        }

        if ($countryId) {
            $countryArray[] = array(
                'countryId' => $countryId,
                'countryName' => $countryName,
                'division' => $divisionArray,
            );
        }

        $divisionArray = Division::find()->orderBy(['division_id' => SORT_ASC])->all();

        for ($i = 0, $countCountry = count($countryArray); $i < $countCountry; $i++) {
            foreach ($divisionArray as $division) {
                if (!isset($countryArray[$i]['division'][$division->division_id])) {
                    $countryArray[$i]['division'][$division->division_id] = '-';
                }
            }
        }

        $tournamentArray = [];

        $scheduleArray = Schedule::find()
            ->with([
                'tournamentType',
            ])
            ->where(['schedule_season_id' => $seasonId])
            ->groupBy(['schedule_tournament_type_id'])
            ->orderBy(['schedule_tournament_type_id' => SORT_ASC])
            ->all();
        foreach ($scheduleArray as $schedule) {
            if (!in_array($schedule->schedule_tournament_type_id, [
                TournamentType::NATIONAL,
                TournamentType::LEAGUE,
                TournamentType::CONFERENCE,
                TournamentType::OFF_SEASON,
            ])) {
                continue;
            }

            if (TournamentType::NATIONAL == $schedule->schedule_tournament_type_id) {
                $route = 'world-championship/index';
            } elseif (TournamentType::LEAGUE == $schedule->schedule_tournament_type_id) {
                $route = 'champions-league/index';
            } elseif (TournamentType::CONFERENCE == $schedule->schedule_tournament_type_id) {
                $route = 'conference/index';
            } else {
                $route = 'off-season/index';
            }

            $tournamentArray[] = Html::a(
                $schedule->tournamentType->tournament_type_name,
                [$route, 'seasonId' => $seasonId]
            );
        }

        $tournaments = implode(' | ', $tournamentArray);

        $this->setSeoTitle('Турниры');

        return $this->render('index', [
            'countryArray' => $countryArray,
            'seasonArray' => $seasonArray,
            'seasonId' => $seasonId,
            'tournaments' => $tournaments,
        ]);
    }
}
