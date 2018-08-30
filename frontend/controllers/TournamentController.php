<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Division;
use common\models\Schedule;
use common\models\Season;
use common\models\TournamentType;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;

/**
 * Class TournamentController
 * @package frontend\controllers
 */
class TournamentController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
        $season = Season::find()->select(['season_id'])->orderBy(['season_id' => SORT_DESC])->all();

        $countryId = 0;
        $countryName = '';
        $countryArray = [];
        $divisionArray = [];

        $championshipArray = Championship::find()
            ->with([
                'country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
                'division' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['division_id', 'division_name']);
                },
            ])
            ->select(['championship_country_id', 'championship_division_id'])
            ->where(['championship_season_id' => $seasonId])
            ->groupBy(['championship_country_id', 'championship_division_id'])
            ->orderBy(['championship_country_id' => SORT_ASC, 'championship_division_id' => SORT_ASC])
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

        $divisionArray = Division::find()->select(['division_id'])->orderBy(['division_id' => SORT_ASC])->all();

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
                'tournamentType' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['tournament_type_id', 'tournament_type_name']);
                }
            ])
            ->select(['schedule_tournament_type_id'])
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

        $this->view->title = 'Tournaments';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Tournaments - Virtual Hockey Online League'
        ]);

        return $this->render('index', [
            'countryArray' => $countryArray,
            'season' => $season,
            'seasonId' => $seasonId,
            'tournaments' => $tournaments,
        ]);
    }
}
