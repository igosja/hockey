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
class OffSeasonController extends BaseController
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

    /**
     * @return string
     */
    public function actionTable(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = OffSeason::find()
            ->where(['off_season_season_id' => $seasonId])
            ->orderBy(['off_season_place' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Кубок межсезонья');

        return $this->render('table', [
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

        $select = 'team_id';

        if (StatisticType::TEAM_NO_PASS == $id) {
            $select = 'statistic_team_game_no_pass';
        } elseif (StatisticType::TEAM_NO_SCORE == $id) {
            $select = 'statistic_team_game_no_score';
        } elseif (StatisticType::TEAM_LOOSE == $id) {
            $select = 'statistic_team_loose';
        } elseif (StatisticType::TEAM_LOOSE_BULLET == $id) {
            $select = 'statistic_team_loose_bullet';
        } elseif (StatisticType::TEAM_LOOSE_OVER == $id) {
            $select = 'statistic_team_loose_over';
        } elseif (StatisticType::TEAM_PASS == $id) {
            $select = 'statistic_team_pass';
        } elseif (StatisticType::TEAM_SCORE == $id) {
            $select = 'statistic_team_score';
        } elseif (StatisticType::TEAM_PENALTY == $id) {
            $select = 'statistic_team_penalty';
        } elseif (StatisticType::TEAM_PENALTY_OPPONENT == $id) {
            $select = 'statistic_team_penalty_opponent';
        } elseif (StatisticType::TEAM_WIN == $id) {
            $select = 'statistic_team_win';
        } elseif (StatisticType::TEAM_WIN_BULLET == $id) {
            $select = 'statistic_team_win_bullet';
        } elseif (StatisticType::TEAM_WIN_OVER == $id) {
            $select = 'statistic_team_win_over';
        } elseif (StatisticType::TEAM_WIN_PERCENT == $id) {
            $select = 'statistic_team_win_percent';
        } elseif (StatisticType::PLAYER_ASSIST == $id) {
            $select = 'statistic_player_assist';
        } elseif (StatisticType::PLAYER_ASSIST_POWER == $id) {
            $select = 'statistic_player_assist_power';
        } elseif (StatisticType::PLAYER_ASSIST_SHORT == $id) {
            $select = 'statistic_player_assist_short';
        } elseif (StatisticType::PLAYER_BULLET_WIN == $id) {
            $select = 'statistic_player_bullet_win';
        } elseif (StatisticType::PLAYER_FACE_OFF == $id) {
            $select = 'statistic_player_face_off';
        } elseif (StatisticType::PLAYER_FACE_OFF_PERCENT == $id) {
            $select = 'statistic_player_face_off_percent';
        } elseif (StatisticType::PLAYER_FACE_OFF_WIN == $id) {
            $select = 'statistic_player_face_off_win';
        } elseif (StatisticType::PLAYER_GAME == $id) {
            $select = 'statistic_player_game';
        } elseif (StatisticType::PLAYER_LOOSE == $id) {
            $select = 'statistic_player_loose';
        } elseif (StatisticType::PLAYER_PASS == $id) {
            $select = 'statistic_player_pass';
        } elseif (StatisticType::PLAYER_PASS_PER_GAME == $id) {
            $select = 'statistic_player_pass_per_game';
        } elseif (StatisticType::PLAYER_PENALTY == $id) {
            $select = 'statistic_player_penalty';
        } elseif (StatisticType::PLAYER_PLUS_MINUS == $id) {
            $select = 'statistic_player_plus_minus';
        } elseif (StatisticType::PLAYER_POINT == $id) {
            $select = 'statistic_player_point';
        } elseif (StatisticType::PLAYER_SAVE == $id) {
            $select = 'statistic_player_save';
        } elseif (StatisticType::PLAYER_SAVE_PERCENT == $id) {
            $select = 'statistic_player_save_percent';
        } elseif (StatisticType::PLAYER_SCORE == $id) {
            $select = 'statistic_player_score';
        } elseif (StatisticType::PLAYER_SCORE_DRAW == $id) {
            $select = 'statistic_player_score_draw';
        } elseif (StatisticType::PLAYER_SCORE_POWER == $id) {
            $select = 'statistic_player_score_power';
        } elseif (StatisticType::PLAYER_SCORE_SHORT == $id) {
            $select = 'statistic_player_score_short';
        } elseif (StatisticType::PLAYER_SCORE_SHOT_PERCENT == $id) {
            $select = 'statistic_player_score_shot_percent';
        } elseif (StatisticType::PLAYER_SCORE_WIN == $id) {
            $select = 'statistic_player_score_win';
        } elseif (StatisticType::PLAYER_SHOT == $id) {
            $select = 'statistic_player_shot';
        } elseif (StatisticType::PLAYER_SHOT_GK == $id) {
            $select = 'statistic_player_shot_gk';
        } elseif (StatisticType::PLAYER_SHOT_PER_GAME == $id) {
            $select = 'statistic_player_shot_per_game';
        } elseif (StatisticType::PLAYER_SHUTOUT == $id) {
            $select = 'statistic_player_shutout';
        } elseif (StatisticType::PLAYER_WIN == $id) {
            $select = 'statistic_player_win';
        }

        if (in_array($id, array(
            StatisticType::PLAYER_LOOSE,
            StatisticType::PLAYER_PASS,
            StatisticType::PLAYER_PASS_PER_GAME,
            StatisticType::PLAYER_PENALTY,
            StatisticType::TEAM_LOOSE,
            StatisticType::TEAM_LOOSE_BULLET,
            StatisticType::TEAM_LOOSE_OVER,
            StatisticType::TEAM_NO_SCORE,
            StatisticType::TEAM_PASS,
            StatisticType::TEAM_PENALTY,
        ))) {
            $sort = SORT_ASC;
        } else {
            $sort = SORT_DESC;
        }

        $query = StatisticTeam::find()
            ->where([
                'statistic_team_tournament_type_id' => TournamentType::OFF_SEASON,
                'statistic_team_season_id' => $seasonId,
            ])
            ->orderBy([$select => $sort])
            ->limit(100);

        if (in_array($id, array(
            StatisticType::TEAM_NO_PASS,
            StatisticType::TEAM_NO_SCORE,
            StatisticType::TEAM_LOOSE,
            StatisticType::TEAM_LOOSE_BULLET,
            StatisticType::TEAM_LOOSE_OVER,
            StatisticType::TEAM_PASS,
            StatisticType::TEAM_SCORE,
            StatisticType::TEAM_PENALTY,
            StatisticType::TEAM_PENALTY_OPPONENT,
            StatisticType::TEAM_WIN,
            StatisticType::TEAM_WIN_BULLET,
            StatisticType::TEAM_WIN_OVER,
            StatisticType::TEAM_WIN_PERCENT,
        ))) {
            $query = StatisticTeam::find()
                ->where([
                    'statistic_team_tournament_type_id' => TournamentType::OFF_SEASON,
                    'statistic_team_season_id' => $seasonId,
                ])
                ->orderBy([$select => $sort])
                ->limit(100);
        } elseif (in_array($id, array(
            StatisticType::PLAYER_ASSIST,
            StatisticType::PLAYER_ASSIST_POWER,
            StatisticType::PLAYER_ASSIST_SHORT,
            StatisticType::PLAYER_BULLET_WIN,
            StatisticType::PLAYER_FACE_OFF,
            StatisticType::PLAYER_FACE_OFF_PERCENT,
            StatisticType::PLAYER_FACE_OFF_WIN,
            StatisticType::PLAYER_GAME,
            StatisticType::PLAYER_LOOSE,
            StatisticType::PLAYER_PASS,
            StatisticType::PLAYER_PASS_PER_GAME,
            StatisticType::PLAYER_PENALTY,
            StatisticType::PLAYER_PLUS_MINUS,
            StatisticType::PLAYER_POINT,
            StatisticType::PLAYER_SAVE,
            StatisticType::PLAYER_SAVE_PERCENT,
            StatisticType::PLAYER_SCORE,
            StatisticType::PLAYER_SCORE_DRAW,
            StatisticType::PLAYER_SCORE_POWER,
            StatisticType::PLAYER_SCORE_SHORT,
            StatisticType::PLAYER_SCORE_SHOT_PERCENT,
            StatisticType::PLAYER_SCORE_WIN,
            StatisticType::PLAYER_SHOT,
            StatisticType::PLAYER_SHOT_GK,
            StatisticType::PLAYER_SHOT_PER_GAME,
            StatisticType::PLAYER_SHUTOUT,
            StatisticType::PLAYER_WIN,
        ))) {
            $isGk = null;
            if (in_array($id, array(
                StatisticType::PLAYER_PASS,
                StatisticType::PLAYER_PASS_PER_GAME,
                StatisticType::PLAYER_SAVE,
                StatisticType::PLAYER_SAVE_PERCENT,
                StatisticType::PLAYER_SHOT_GK,
            ))) {
                $isGk = 1;
            }

            $query = StatisticPlayer::find()
                ->where([
                    'statistic_player_tournament_type_id' => TournamentType::OFF_SEASON,
                    'statistic_player_season_id' => $seasonId,
                ])
                ->andFilterWhere(['statistic_player_is_gk' => $isGk])
                ->orderBy([$select => $sort])
                ->limit(100);
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => false,
        ]);

        $this->setSeoTitle('Кубок межсезонья');

        return $this->render('statistics', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'select' => $select,
            'statisticTypeArray' => StatisticChapter::selectOptions(),
        ]);
    }
}
