<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\Achievement;
use common\models\Finance;
use common\models\Game;
use common\models\History;
use common\models\Mood;
use common\models\National;
use common\models\Player;
use common\models\Position;
use common\models\Schedule;
use common\models\Season;
use common\models\TournamentType;
use Exception;
use frontend\models\NationalPlayer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class NationalController
 * @package frontend\controllers
 */
class NationalController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'attitude-national',
                    'fire',
                    'player',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'attitude-national',
                            'fire',
                            'player',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function actionAttitudeNational($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['national/view', 'id' => $id]);
        }

        if (!$this->myTeam->load(Yii::$app->request->post())) {
            return $this->redirect(['national/view', 'id' => $id]);
        }

        $this->myTeam->save(true, ['team_attitude_national', 'team_attitude_u21', 'team_attitude_u19']);
        return $this->redirect(['national/view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return string
     * @throws Exception
     */
    public function actionView($id)
    {
        $national = $this->getNational($id);

        $notificationArray = [];
        if ($this->myNationalOrVice && $id == $this->myNationalOrVice->national_id) {
            $notificationArray = $this->getNotificationArray();
        }

        $query = Player::find()
            ->with([
                'country',
                'name',
                'physical',
                'playerPosition.position',
                'playerSpecial.special',
                'squadNational',
                'statisticPlayer',
                'style',
                'surname',
                'team.stadium.city.country',
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
                    'tire' => [
                        'asc' => [$national->myTeam() ? 'player_tire' : 'player_position_id' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_tire' : 'player_position_id' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->setSeoTitle($national->fullName() . '. ?????????????? ??????????????');

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'notificationArray' => $notificationArray,
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
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

        $this->setSeoTitle($national->fullName() . '. ?????????? ??????????????');

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
     * @throws NotFoundHttpException
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

        $this->setSeoTitle($national->fullName() . '. ?????????????? ??????????????');

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
     * @throws NotFoundHttpException
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

        $this->setSeoTitle($national->fullName() . '. ?????????????? ??????????????');

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
     * @throws NotFoundHttpException
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

        $this->setSeoTitle($national->fullName() . '. ???????????????????? ??????????????');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionTrophy($id)
    {
        $national = $this->getNational($id);

        $query = Achievement::find()
            ->where(['achievement_national_id' => $id, 'achievement_place' => [0, 1], 'achievement_stage_id' => 0])
            ->orderBy(['achievement_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($national->fullName() . '. ???????????? ??????????????');

        return $this->render('trophy', [
            'dataProvider' => $dataProvider,
            'national' => $national,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws Exception
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
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

        $schedule = Schedule::find()
            ->where(['schedule_tournament_type_id' => TournamentType::NATIONAL])
            ->andWhere(['>', 'schedule_date', time()])
            ->limit(1)
            ->one();
        if ($schedule && $schedule->schedule_date < time() + 86400) {
            $this->setErrorFlash('???????????? ???????????? ???????????? ?????????????? ?????????? ?????? ???? ?????????? ???? ??????????');
            return $this->redirect(['national/view', 'id' => $id]);
        }

        $model = new NationalPlayer(['national' => $national]);
        if ($model->savePlayer()) {
            $this->setSuccessFlash();
            return $this->refresh();
        }

        $gkArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where([
                'player_country_id' => $national->country->country_id,
                'player_position_id' => Position::GK,
                'player_national_id' => [0, $national->national_id]
            ])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
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
            ->where([
                'player_country_id' => $national->country->country_id,
                'player_position_id' => Position::LD,
                'player_national_id' => [0, $national->national_id]
            ])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
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
            ->where([
                'player_country_id' => $national->country->country_id,
                'player_position_id' => Position::RD,
                'player_national_id' => [0, $national->national_id]
            ])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
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
            ->where([
                'player_country_id' => $national->country->country_id,
                'player_position_id' => Position::LW,
                'player_national_id' => [0, $national->national_id]
            ])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
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
            ->where([
                'player_country_id' => $national->country->country_id,
                'player_position_id' => Position::CF,
                'player_national_id' => [0, $national->national_id]
            ])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
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
            ->where([
                'player_country_id' => $national->country->country_id,
                'player_position_id' => Position::RW,
                'player_national_id' => [0, $national->national_id]
            ])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->andWhere(['!=', 'player_team_id', 0])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        $playerArray = Player::find()
            ->where(['player_national_id' => $national->national_id])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->all();
        foreach ($playerArray as $player) {
            if (Position::GK == $player->player_position_id) {
                $positionArray = $gkArray;
            } elseif (Position::LD == $player->player_position_id) {
                $positionArray = $ldArray;
            } elseif (Position::RD == $player->player_position_id) {
                $positionArray = $rdArray;
            } elseif (Position::LW == $player->player_position_id) {
                $positionArray = $lwArray;
            } elseif (Position::CF == $player->player_position_id) {
                $positionArray = $cfArray;
            } else {
                $positionArray = $rwArray;
            }

            $present = false;
            foreach ($positionArray as $position) {
                if ($position->player_id == $player->player_id) {
                    $present = true;
                }
            }

            if ($present) {
                continue;
            }

            $positionArray[] = $player;
            if (Position::GK == $player->player_position_id) {
                $gkArray = $positionArray;
            } elseif (Position::LD == $player->player_position_id) {
                $ldArray = $positionArray;
            } elseif (Position::RD == $player->player_position_id) {
                $rdArray = $positionArray;
            } elseif (Position::LW == $player->player_position_id) {
                $lwArray = $positionArray;
            } elseif (Position::CF == $player->player_position_id) {
                $cfArray = $positionArray;
            } else {
                $rwArray = $positionArray;
            }
        }

        $this->setSeoTitle('?????????????????? ?????????????? ??????????????');
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
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionFire($id)
    {
        $national = $this->getNational($id);
        if (!in_array($this->user->user_id, [$national->national_user_id, $national->national_vice_id])) {
            $this->setErrorFlash('???? ???? ?????????????????? ?????????????????????? ?????????????????? ?? ???????? ??????????????');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (!$national->national_vice_id) {
            $this->setErrorFlash('???????????? ???????????????????? ???? ?????????????????? ???????? ?? ?????????????? ?????? ??????????????????????');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (Yii::$app->request->get('ok')) {
            if ($this->user->user_id == $national->national_user_id) {
                $national->fireUser();
            } elseif ($this->user->user_id == $national->national_vice_id) {
                $national->fireVice();
            }

            $this->setSuccessFlash('???? ?????????????? ???????????????????? ???? ??????????????????');
            return $this->redirect(['national/view', 'id' => $id]);
        }

        $this->setSeoTitle('?????????? ???? ??????????????????');

        return $this->render('fire', [
            'id' => $id,
            'national' => $national,
        ]);
    }

    /**
     * @param int $id
     * @return National
     * @throws NotFoundHttpException
     */
    public function getNational($id)
    {
        $national = National::find()
            ->with(['country.city.stadium.team'])
            ->where(['national_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($national);

        return $national;
    }

    /**
     * @return array|Response
     * @throws Exception
     */
    public function getNotificationArray()
    {
        if (!$this->myNationalOrVice) {
            return [];
        }

        $result = [];

        $closestGame = Game::find()
            ->joinWith(['schedule'])
            ->where([
                'or',
                ['game_home_national_id' => $this->myNationalOrVice->national_id],
                ['game_guest_national_id' => $this->myNationalOrVice->national_id],
            ])
            ->andWhere(['game_played' => 0])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(1)
            ->one();
        if ($closestGame) {
            if (($closestGame->game_home_national_id == $this->myNationalOrVice->national_id && !$closestGame->game_home_mood_id) ||
                ($closestGame->game_guest_national_id == $this->myNationalOrVice->national_id && !$closestGame->game_guest_mood_id)) {
                $result[] = '<span class="font-red">???? ???? ?????????????????? ???????????? ???? ?????????????????? ???????? ?????????? ??????????????.</span> ' . Html::a(
                        '<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
                        ['lineup-national/view', 'id' => $closestGame->game_id]
                    );
            }

            if (($closestGame->game_home_national_id == $this->myNationalOrVice->national_id && Mood::SUPER == $closestGame->game_home_mood_id) ||
                ($closestGame->game_guest_national_id == $this->myNationalOrVice->national_id && Mood::SUPER == $closestGame->game_guest_mood_id)) {
                $result[] = '?? ?????????????????? ?????????? ???????? ?????????????? ?????????? ???????????????????????? <span class="strong font-green">??????????</span>. ' . Html::a(
                        '<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
                        ['lineup/view', 'id' => $closestGame->game_id]
                    );
            }

            if (($closestGame->game_home_national_id == $this->myNationalOrVice->national_id && Mood::REST == $closestGame->game_home_mood_id) ||
                ($closestGame->game_guest_national_id == $this->myNationalOrVice->national_id && Mood::REST == $closestGame->game_guest_mood_id)) {
                $result[] = '?? ?????????????????? ?????????? ???????? ?????????????? ?????????? ???????????????????????? <span class="strong font-red">??????????</span>. ' . Html::a(
                        '<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>',
                        ['lineup/view', 'id' => $closestGame->game_id]
                    );
            }
        }

        return $result;
    }
}
