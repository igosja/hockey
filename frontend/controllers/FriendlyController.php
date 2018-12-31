<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\FriendlyInvite;
use common\models\FriendlyInviteStatus;
use common\models\FriendlyStatus;
use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use common\models\Team;
use common\models\TournamentType;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class FriendlyController
 * @package frontend\controllers
 */
class FriendlyController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $query = Schedule::find()
            ->where(['schedule_tournament_type_id' => TournamentType::FRIENDLY])
            ->andWhere(['>', 'schedule_date', time()])
            ->andWhere(['<', 'schedule_date', time() + 1209600])
            ->orderBy(['schedule_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $scheduleStatusArray = [];
        foreach ($query->all() as $schedule) {
            $game = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->andWhere([
                    'or',
                    ['game_home_team_id' => $this->myTeam->team_id],
                    ['game_guest_team_id' => $this->myTeam->team_id]
                ])
                ->limit(1)
                ->one();
            if ($game) {
                if ($game->game_home_team_id == $this->myTeam->team_id) {
                    $scheduleStatusArray[$schedule->schedule_id] = 'Играем с ' . $game->teamGuest->teamLink('img');
                } else {
                    $scheduleStatusArray[$schedule->schedule_id] = 'Играем с ' . $game->teamHome->teamLink('img');
                }
                continue;
            }

            $invite = FriendlyInvite::find()
                ->where([
                    'friendly_invite_schedule_id' => $schedule->schedule_id,
                    'friendly_invite_guest_team_id' => $this->myTeam->team_id,
                    'friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::NEW,
                ])
                ->count();
            if ($invite) {
                $scheduleStatusArray[$schedule->schedule_id] = 'У вас есть неотвеченные приглашения.';
                continue;
            }

            $scheduleStatusArray[$schedule->schedule_id] = 'Нет приглашений';
        }

        $this->setSeoTitle('Организация товарищеских матчей');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'scheduleStatusArray' => $scheduleStatusArray,
            'team' => $team,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        $schedule = Schedule::find()
            ->where(['schedule_tournament_type_id' => TournamentType::FRIENDLY, 'schedule_id' => $id])
            ->andWhere(['>', 'schedule_date', time()])
            ->andWhere(['<', 'schedule_date', time() + 1209600])
            ->limit(1)
            ->one();
        $this->notFound($schedule);

        $query = Schedule::find()
            ->where(['schedule_tournament_type_id' => TournamentType::FRIENDLY])
            ->andWhere(['>', 'schedule_date', time()])
            ->andWhere(['<', 'schedule_date', time() + 1209600])
            ->orderBy(['schedule_id' => SORT_ASC]);
        $scheduleDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $scheduleStatusArray = [];
        foreach ($query->all() as $schedule) {
            $game = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->andWhere([
                    'or',
                    ['game_home_team_id' => $this->myTeam->team_id],
                    ['game_guest_team_id' => $this->myTeam->team_id]
                ])
                ->limit(1)
                ->one();
            if ($game) {
                if ($game->game_home_team_id == $this->myTeam->team_id) {
                    $scheduleStatusArray[$schedule->schedule_id] = 'Играем с ' . $game->teamGuest->teamLink('img');
                } else {
                    $scheduleStatusArray[$schedule->schedule_id] = 'Играем с ' . $game->teamHome->teamLink('img');
                }
                continue;
            }

            $invite = FriendlyInvite::find()
                ->where([
                    'friendly_invite_schedule_id' => $schedule->schedule_id,
                    'friendly_invite_guest_team_id' => $this->myTeam->team_id,
                    'friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::NEW,
                ])
                ->count();
            if ($invite) {
                $scheduleStatusArray[$schedule->schedule_id] = 'У вас есть неотвеченные приглашения.';
                continue;
            }

            $scheduleStatusArray[$schedule->schedule_id] = 'Нет приглашений';
        }

        $query = FriendlyInvite::find()
            ->where(['friendly_invite_schedule_id' => $id, 'friendly_invite_guest_team_id' => $team->team_id])
            ->orderBy(['friendly_invite_id' => SORT_ASC]);
        $receivedDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = FriendlyInvite::find()
            ->where(['friendly_invite_schedule_id' => $id, 'friendly_invite_home_team_id' => $team->team_id])
            ->orderBy(['friendly_invite_id' => SORT_ASC]);
        $sentDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Team::find()
            ->where(['!=', 'team_user_id', 0])
            ->andWhere(['!=', 'team_id', $team->team_id])
            ->andWhere(['!=', 'team_user_id', Yii::$app->user->id])
            ->andWhere(['!=', 'team_friendly_status_id', FriendlyStatus::NONE])
            ->orderBy(['team_power_vs' => SORT_DESC]);
        $teamDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSeoTitle('Организация товарищеских матчей');

        return $this->render('view', [
            'receivedDataProvider' => $receivedDataProvider,
            'sentDataProvider' => $sentDataProvider,
            'scheduleStatusArray' => $scheduleStatusArray,
            'scheduleDataProvider' => $scheduleDataProvider,
            'team' => $team,
            'teamDataProvider' => $teamDataProvider,
        ]);
    }

    /**
     * @param int $id
     * @param int $teamId
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionSend(int $id, int $teamId): Response
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $schedule = Schedule::find()
            ->where(['schedule_tournament_type_id' => TournamentType::FRIENDLY, 'schedule_id' => $id])
            ->andWhere(['>', 'schedule_date', time()])
            ->andWhere(['<', 'schedule_date', time() + 1209600])
            ->count();
        if (!$schedule) {
            $this->setErrorFlash('Игровой день выбран неправильно.');
            return $this->redirect(['friendly/index']);
        }

        $game = Game::find()
            ->where(['game_schedule_id' => $id])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $this->myTeam->team_id]
            ])
            ->count();
        if ($game) {
            $this->setErrorFlash('Ваща команда уже играет матч в этот игровой день.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $team = Team::find()
            ->where(['team_id' => $teamId])
            ->andWhere(['!=', 'team_user_id', 0])
            ->andWhere(['!=', 'team_user_id', Yii::$app->user->id])
            ->andWhere(['!=', 'team_id', $this->myTeam->team_id])
            ->andWhere(['!=', 'team_friendly_status_id', FriendlyStatus::NONE])
            ->limit(1)
            ->one();
        if (!$team) {
            $this->setErrorFlash('Команда выбрана неправильно.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $invite = FriendlyInvite::find()
            ->where([
                'friendly_invite_guest_team_id' => $teamId,
                'friendly_invite_home_team_id' => $this->myTeam->team_id,
                'friendly_invite_schedule_id' => $id,
            ])
            ->count();
        if ($invite) {
            $this->setErrorFlash('Вы уже отправили этой команде приглашение на этот игровой день.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $game = Game::find()
            ->where(['game_schedule_id' => $id])
            ->andWhere(['or', ['game_guest_team_id' => $teamId], ['game_home_team_id' => $teamId]])
            ->count();
        if ($game) {
            $this->setErrorFlash('Эта команда уже организовала товарищеский матч.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $game = Game::find()
            ->joinWith(['schedule'])
            ->where([
                'or',
                ['game_guest_team_id' => $teamId, 'game_home_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $teamId, 'game_guest_team_id' => $this->myTeam->team_id]
            ])
            ->andWhere([
                'schedule_season_id' => Season::getCurrentSeason(),
                'schedule_tournament_type_id' => TournamentType::FRIENDLY,
            ])
            ->count();
        if ($game) {
            $this->setErrorFlash('Ваши команды уже играли в этом сезоне.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        if (FriendlyStatus::ALL == $team->team_friendly_status_id) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model = new FriendlyInvite();
                $model->friendly_invite_friendly_invite_status_id = FriendlyInviteStatus::ACCEPTED;
                $model->friendly_invite_guest_team_id = $teamId;
                $model->friendly_invite_guest_user_id = $team->team_user_id;
                $model->friendly_invite_home_team_id = $this->myTeam->team_id;
                $model->friendly_invite_home_user_id = $this->myTeam->team_user_id;
                $model->friendly_invite_schedule_id = $id;
                $model->save();

                $model = new Game();
                $model->game_bonus_home = 0;
                $model->game_guest_team_id = $teamId;
                $model->game_home_team_id = $this->myTeam->team_id;
                $model->game_schedule_id = $id;
                $model->game_stadium_id = $this->myTeam->team_stadium_id;
                $model->save();

                FriendlyInvite::updateAll(
                    ['friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::CANCELED],
                    [
                        'and',
                        ['!=', 'friendly_invite_friendly_invite_status_id', FriendlyInviteStatus::ACCEPTED],
                        ['friendly_invite_schedule_id' => $id],
                        [
                            'or',
                            ['friendly_invite_guest_team_id' => $this->myTeam->team_id],
                            ['friendly_invite_home_team_id' => $this->myTeam->team_id],
                        ],
                    ]
                );

                FriendlyInvite::updateAll(
                    ['friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::CANCELED],
                    [
                        'and',
                        ['!=', 'friendly_invite_friendly_invite_status_id', FriendlyInviteStatus::ACCEPTED],
                        ['friendly_invite_schedule_id' => $id],
                        [
                            'or',
                            ['friendly_invite_guest_team_id' => $teamId],
                            ['friendly_invite_home_team_id' => $teamId],
                        ],
                    ]
                );
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);

                $this->setErrorFlash('Не удалось организовать матч.');
                return $this->redirect(['friendly/view', 'id' => $id]);
            }

            $transaction->commit();

            $this->setSuccessFlash('Игра успешно организована.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $invite = FriendlyInvite::find()
            ->where([
                'friendly_invite_home_team_id' => $this->myTeam->team_id,
                'friendly_invite_schedule_id' => $id,
                'friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::NEW,
            ])
            ->count();
        if ($invite >= 5) {
            $this->setErrorFlash('На один игровой день можно отправить не более 5 приглашений.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = new FriendlyInvite();
            $model->friendly_invite_friendly_invite_status_id = FriendlyInviteStatus::NEW;
            $model->friendly_invite_guest_team_id = $teamId;
            $model->friendly_invite_guest_user_id = $team->team_user_id;
            $model->friendly_invite_home_team_id = $this->myTeam->team_id;
            $model->friendly_invite_home_user_id = $this->myTeam->team_user_id;
            $model->friendly_invite_schedule_id = $id;
            $model->save();
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);

            $this->setErrorFlash('Не удалось отправить приглашение.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $transaction->commit();

        $this->setSuccessFlash('Приглашение успешно отправлено.');
        return $this->redirect(['friendly/view', 'id' => $id]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function actionAccept(int $id): Response
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $invite = FriendlyInvite::find()
            ->where(['friendly_invite_id' => $id, 'friendly_invite_guest_team_id' => $this->myTeam->team_id])
            ->limit(1)
            ->one();
        if (!$invite) {
            $this->setErrorFlash('Приглашение выбрано неправильно.');
            return $this->redirect(['friendly/index']);
        }

        if (FriendlyInviteStatus::ACCEPTED == $invite->friendly_invite_friendly_invite_status_id) {
            $this->setErrorFlash('Приглашение уже одобрено.');
            return $this->redirect(['friendly/view', 'id' => $invite->friendly_invite_schedule_id]);
        }

        if (FriendlyInviteStatus::CANCELED == $invite->friendly_invite_friendly_invite_status_id) {
            $this->setErrorFlash('Приглашение уже отклонено.');
            return $this->redirect(['friendly/view', 'id' => $invite->friendly_invite_schedule_id]);
        }

        $game = Game::find()
            ->where(['game_schedule_id' => $invite->friendly_invite_schedule_id])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $this->myTeam->team_id],
                ['game_home_team_id' => $this->myTeam->team_id]
            ])
            ->count();
        if ($game) {
            $this->setErrorFlash('Ваща команда уже играет матч в этот игровой день.');
            return $this->redirect(['friendly/view', 'id' => $invite->friendly_invite_schedule_id]);
        }

        $game = Game::find()
            ->where(['game_schedule_id' => $invite->friendly_invite_schedule_id])
            ->andWhere([
                'or',
                ['game_guest_team_id' => $invite->friendly_invite_home_team_id],
                ['game_home_team_id' => $invite->friendly_invite_home_team_id]
            ])
            ->count();
        if ($game) {
            $invite->friendly_invite_friendly_invite_status_id = FriendlyInviteStatus::CANCELED;
            $invite->save();

            $this->setErrorFlash('Эта команда уже организовала товарищеский матч.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $invite->friendly_invite_friendly_invite_status_id = FriendlyInviteStatus::ACCEPTED;
            $invite->save();

            $model = new Game();
            $model->game_bonus_home = 0;
            $model->game_guest_team_id = $invite->friendly_invite_guest_team_id;
            $model->game_home_team_id = $invite->friendly_invite_home_team_id;
            $model->game_schedule_id = $invite->friendly_invite_schedule_id;
            $model->game_stadium_id = $invite->homeTeam->team_stadium_id;
            $model->save();

            FriendlyInvite::updateAll(
                ['friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::CANCELED],
                [
                    'and',
                    ['!=', 'friendly_invite_friendly_invite_status_id', FriendlyInviteStatus::ACCEPTED],
                    ['friendly_invite_schedule_id' => $invite->friendly_invite_schedule_id],
                    [
                        'or',
                        ['friendly_invite_guest_team_id' => $invite->friendly_invite_guest_team_id],
                        ['friendly_invite_home_team_id' => $invite->friendly_invite_guest_team_id],
                    ],
                ]
            );

            FriendlyInvite::updateAll(
                ['friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::CANCELED],
                [
                    'and',
                    ['!=', 'friendly_invite_friendly_invite_status_id', FriendlyInviteStatus::ACCEPTED],
                    ['friendly_invite_schedule_id' => $invite->friendly_invite_schedule_id],
                    [
                        'or',
                        ['friendly_invite_guest_team_id' => $invite->friendly_invite_home_team_id],
                        ['friendly_invite_home_team_id' => $invite->friendly_invite_home_team_id],
                    ],
                ]
            );
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);

            $this->setErrorFlash('Не удалось организовать матч.');
            return $this->redirect(['friendly/view', 'id' => $invite->friendly_invite_schedule_id]);
        }

        $transaction->commit();

        $this->setSuccessFlash('Игра успешно организована.');
        return $this->redirect(['friendly/view', 'id' => $invite->friendly_invite_schedule_id]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function actionCancel(int $id): Response
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $model = FriendlyInvite::find()
            ->where(['friendly_invite_id' => $id])
            ->andWhere([
                'or',
                ['friendly_invite_home_team_id' => $this->myTeam->team_id],
                ['friendly_invite_guest_team_id' => $this->myTeam->team_id],
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            $this->setErrorFlash('Приглашение выбрано неправильно.');
            return $this->redirect(['friendly/index']);
        }

        if (FriendlyInviteStatus::ACCEPTED == $model->friendly_invite_friendly_invite_status_id) {
            $this->setErrorFlash('Приглашение уже одобрено.');
            return $this->redirect(['friendly/view', 'id' => $model->friendly_invite_schedule_id]);
        }

        if (FriendlyInviteStatus::CANCELED == $model->friendly_invite_friendly_invite_status_id) {
            $this->setErrorFlash('Приглашение уже отклонено.');
            return $this->redirect(['friendly/view', 'id' => $model->friendly_invite_schedule_id]);
        }

        $model->friendly_invite_friendly_invite_status_id = FriendlyInviteStatus::CANCELED;
        $model->save();

        $this->setSuccessFlash('Приглашение успешно отклонено.');
        return $this->redirect(['friendly/view', 'id' => $model->friendly_invite_schedule_id]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionStatus()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $model = $this->myTeam;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash();
            return $this->refresh();
        }

        $friendlyStatusArray = ArrayHelper::map(
            FriendlyStatus::find()
                ->orderBy(['friendly_status_id' => SORT_ASC])
                ->all(),
            'friendly_status_id',
            'friendly_status_name'
        );

        $this->setSeoTitle('Изменения статуса в товарищеских матчах');

        return $this->render('status', [
            'friendlyStatusArray' => $friendlyStatusArray,
            'team' => $this->myTeam,
        ]);
    }
}
