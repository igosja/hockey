<?php

namespace frontend\controllers;

use common\models\Conference;
use common\models\StatisticChapter;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use common\models\StatisticType;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class ConferenceController
 * @package frontend\controllers
 */
class ConferenceController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $count = Conference::find()
            ->where(['conference_season_id' => $seasonId])
            ->count();

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
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
        $countryId = Yii::$app->request->get('countryId');

        $query = Conference::find()
            ->joinWith(['team.stadium.city'])
            ->where(['conference_season_id' => $seasonId])
            ->andFilterWhere(['city_country_id' => $countryId])
            ->orderBy(['conference_place' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $countryArray = Conference::find()
            ->joinWith(['team.stadium.city.country'])
            ->where(['conference_season_id' => $seasonId])
            ->groupBy(['country_id'])
            ->orderBy(['country_id' => SORT_ASC])
            ->all();
        $countryArray = ArrayHelper::map(
            $countryArray,
            'team.stadium.city.country.country_id',
            'team.stadium.city.country.country_name'
        );

        $this->setSeoTitle('Конференция любительских клубов');

        return $this->render('table', [
            'countryArray' => $countryArray,
            'countryId' => $countryId,
            'dataProvider' => $dataProvider,
            'seasonArray' => $this->getSeasonArray(),
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionStatistics(int $id = StatisticType::TEAM_NO_PASS): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $statisticType = StatisticType::find()
            ->where(['statistic_type_id' => $id])
            ->one();
        if (!$statisticType) {
            $statisticType = StatisticType::find()
                ->where(['statistic_type_id' => StatisticType::TEAM_NO_PASS])
                ->one();
        }

        if ($statisticType->isTeamChapter()) {
            $query = StatisticTeam::find()
                ->where([
                    'statistic_team_tournament_type_id' => TournamentType::CONFERENCE,
                    'statistic_team_season_id' => $seasonId,
                ])
                ->orderBy([$statisticType->statistic_type_select => $statisticType->statistic_type_sort]);
        } else {
            $isGk = null;
            if ($statisticType->isGkType()) {
                $isGk = 1;
            }

            $query = StatisticPlayer::find()
                ->where([
                    'statistic_player_tournament_type_id' => TournamentType::CONFERENCE,
                    'statistic_player_season_id' => $seasonId,
                ])
                ->andFilterWhere(['statistic_player_is_gk' => $isGk])
                ->orderBy([$statisticType->statistic_type_select => $statisticType->statistic_type_sort]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Конференция любительских клубов');

        return $this->render('statistics', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'statisticType' => $statisticType,
            'statisticTypeArray' => StatisticChapter::selectOptions(),
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
