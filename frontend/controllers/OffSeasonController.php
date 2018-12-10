<?php

namespace frontend\controllers;

use common\models\OffSeason;
use common\models\StatisticChapter;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use common\models\StatisticType;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class OffSeasonController
 * @package frontend\controllers
 */
class OffSeasonController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $count = OffSeason::find()->where(['off_season_season_id' => $seasonId])->count();

        $this->setSeoTitle('Кубок межсезонья');

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
        $countryId = Yii::$app->request->get('countryId');

        $query = OffSeason::find()
            ->joinWith(['team.stadium.city'])
            ->where(['off_season_season_id' => $seasonId])
            ->andFilterWhere(['city_country_id' => $countryId])
            ->orderBy(['off_season_place' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
            'sort' => false,
        ]);

        $countryArray = OffSeason::find()
            ->joinWith(['team.stadium.city.country'])
            ->where(['off_season_season_id' => $seasonId])
            ->groupBy(['country_id'])
            ->orderBy(['country_id' => SORT_ASC])
            ->all();
        $countryArray = ArrayHelper::map(
            $countryArray,
            'team.stadium.city.country.country_id',
            'team.stadium.city.country.country_name'
        );

        $this->setSeoTitle('Турнирная таблица кубка межсезонья');

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
            ->limit(1)
            ->one();
        if (!$statisticType) {
            $statisticType = StatisticType::find()
                ->where(['statistic_type_id' => StatisticType::TEAM_NO_PASS])
                ->limit(1)
                ->one();
        }

        if ($statisticType->isTeamChapter()) {
            $query = StatisticTeam::find()
                ->where([
                    'statistic_team_tournament_type_id' => TournamentType::OFF_SEASON,
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
                    'statistic_player_tournament_type_id' => TournamentType::OFF_SEASON,
                    'statistic_player_season_id' => $seasonId,
                ])
                ->andFilterWhere(['statistic_player_is_gk' => $isGk])
                ->orderBy([$statisticType->statistic_type_select => $statisticType->statistic_type_sort]);
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Статистика кубка межсезонья');

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
        $season = OffSeason::find()
            ->select(['off_season_season_id'])
            ->groupBy(['off_season_season_id'])
            ->orderBy(['off_season_season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($season, 'off_season_season_id', 'off_season_season_id');
    }
}
