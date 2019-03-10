<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\Achievement;
use common\models\Finance;
use common\models\Game;
use common\models\History;
use common\models\National;
use common\models\Player;
use common\models\Position;
use common\models\Season;
use frontend\models\NationalPlayer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Class NationalController
 * @package frontend\controllers
 */
class NationalController extends AbstractController
{
    /**
     * @param $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $national = $this->getNational($id);

        $query = Player::find()
            ->with([
                'country',
                'name',
                'physical',
                'playerPosition.position',
                'playerSpecial.special',
                'statisticPlayer',
                'style',
                'surname',
            ])
            ->where(['player_national_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'game_row' => [
                        'asc' => ['player_game_row' => SORT_ASC],
                        'desc' => ['player_game_row' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC, 'player_id' => SORT_DESC],
                    ],
                    'physical' => [
                        'asc' => [$national->myTeam() ? 'player_physical_id' : 'player_position_id' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_physical_id' : 'player_position_id' => SORT_DESC],
                    ],
                    'power_nominal' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => [$national->myTeam() ? 'player_power_real' : 'player_power_nominal' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_power_real' : 'player_power_nominal' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['player_price' => SORT_ASC],
                        'desc' => ['player_price' => SORT_DESC],
                    ],
                    'squad' => [
                        'asc' => ['player_squad_id' => SORT_ASC, 'player_position_id' => SORT_ASC],
                        'desc' => ['player_squad_id' => SORT_DESC, 'player_position_id' => SORT_ASC],
                    ],
                    'style' => [
                        'asc' => ['player_style_id' => SORT_ASC],
                        'desc' => ['player_style_id' => SORT_DESC],
                    ],
                    'tire' => [
                        'asc' => [$national->myTeam() ? 'player_tire' : 'player_position_id' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_tire' : 'player_position_id' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->setSeoTitle($national->fullName() . '. Профиль сборной');

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionGame($id)
    {
        $national = $this->getNational($id);

        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = Game::find()
            ->joinWith(['schedule'])
            ->with([
                'schedule',
                'schedule.stage',
                'schedule.tournamentType',
            ])
            ->where(['or', ['game_home_national_id' => $id], ['game_guest_national_id' => $id]])
            ->andWhere(['schedule_season_id' => $seasonId])
            ->orderBy(['schedule_date' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $totalPoint = 0;
        foreach ($dataProvider->models as $game) {
            $totalPoint = $totalPoint + (int)HockeyHelper::gamePlusMinus($game, $id);
        }

        $this->setSeoTitle($national->fullName() . '. Матчи сборной');

        return $this->render('game', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
            'national' => $national,
            'totalPoint' => $totalPoint,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEvent($id)
    {
        $national = $this->getNational($id);

        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = History::find()
            ->with([
                'historyText',
                'national',
                'player',
                'player.name',
                'player.surname',
                'user',
            ])
            ->where(['history_national_id' => $id, 'history_season_id' => $seasonId])
            ->orderBy(['history_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle($national->fullName() . '. События сборной');

        return $this->render('event', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFinance($id)
    {
        $national = $this->getNational($id);

        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = Finance::find()
            ->with([
                'financeText',
                'player',
                'player.name',
                'player.surname',
            ])
            ->where(['finance_national_id' => $id])
            ->andWhere(['finance_season_id' => $seasonId])
            ->orderBy(['finance_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($national->fullName() . '. Финансы сборной');

        return $this->render('finance', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAchievement($id)
    {
        $national = $this->getNational($id);

        $query = Achievement::find()
            ->where(['achievement_national_id' => $id])
            ->orderBy(['achievement_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($national->fullName() . '. Достижения сборной');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPlayer($id)
    {
        if (!$this->myNational) {
            $this->forbiddenRole();
        }

        $national = $this->getNational($id);
        if ($this->myNational->national_id != $national->national_id) {
            $this->forbiddenRole();
        }

        $model = new NationalPlayer(['national' => $national]);
        if ($model->savePlayer()) {
            $this->setSuccessFlash();
            $this->refresh();
        }

        $gkArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $national->country->country_id, 'player_position_id' => Position::GK])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(15)
            ->all();

        $ldArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $national->country->country_id, 'player_position_id' => Position::LD])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        $rdArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $national->country->country_id, 'player_position_id' => Position::RD])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        $lwArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $national->country->country_id, 'player_position_id' => Position::LW])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        $cfArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $national->country->country_id, 'player_position_id' => Position::CF])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        $rwArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $national->country->country_id, 'player_position_id' => Position::RW])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        $this->setSeoTitle('Изменение состава сборной');
        return $this->render('player', [
            'cfArray' => $cfArray,
            'gkArray' => $gkArray,
            'ldArray' => $ldArray,
            'lwArray' => $lwArray,
            'model' => $model,
            'national' => $national,
            'rdArray' => $rdArray,
            'rwArray' => $rwArray,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFire($id)
    {
        $national = $this->getNational($id);
        if (!in_array($this->user->user_id, [$national->national_user_id, $national->national_vice_id])) {
            $this->setErrorFlash('Вы не занимаете руководящей должности в этой сборной');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (!$national->national_vice_id) {
            $this->setErrorFlash('Нельзя отказаться от должности если в сборной нет заместителя');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (Yii::$app->request->get('ok')) {
            if ($this->user->user_id == $national->national_user_id) {
                $national->fireUser();
            } elseif ($this->user->user_id == $national->national_vice_id) {
                $national->fireVice();
            }

            $this->setSuccessFlash('Вы успешно отказались от должности');
            return $this->redirect(['national/view', 'id' => $id]);
        }

        $this->setSeoTitle('Отказ от должности');

        return $this->render('fire', [
            'id' => $id,
            'national' => $national,
        ]);
    }

    /**
     * @param int $id
     * @return National
     * @throws \yii\web\NotFoundHttpException
     */
    public function getNational($id)
    {
        $national = National::find()
            ->where(['national_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($national);

        return $national;
    }
}
