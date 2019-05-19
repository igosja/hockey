<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Championship;
use common\models\Conference;
use common\models\FriendlyInvite;
use common\models\FriendlyInviteStatus;
use common\models\FriendlyStatus;
use common\models\Game;
use common\models\ParticipantChampionship;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\Team;
use common\models\TournamentType;
use common\models\User;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
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
    public function behaviors()
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
     * @return string|Response
     */
    public function actionIndex()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
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
                    'friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::NEW_ONE,
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
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $team = $this->myTeam;

        $scheduleMain = Schedule::find()
            ->where(['schedule_tournament_type_id' => TournamentType::FRIENDLY, 'schedule_id' => $id])
            ->andWhere(['>', 'schedule_date', time()])
            ->andWhere(['<', 'schedule_date', time() + 1209600])
            ->limit(1)
            ->one();
        $this->notFound($scheduleMain);

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
                    'friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::NEW_ONE,
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
            ->andWhere([
                'not',
                [
                    'team_id' => Game::find()
                        ->select(['game_home_team_id'])
                        ->where(['game_schedule_id' => $id])
                ]
            ])
            ->andWhere([
                'not',
                [
                    'team_id' => Game::find()
                        ->select(['game_guest_team_id'])
                        ->where(['game_schedule_id' => $id])
                ]
            ])
            ->andWhere([
                'not',
                [
                    'team_id' => Game::find()
                        ->joinWith(['schedule'])
                        ->select(['game_guest_team_id'])
                        ->where([
                            'game_home_team_id' => $this->myTeam->team_id,
                            'schedule_season_id' => Season::getCurrentSeason(),
                            'schedule_tournament_type_id' => TournamentType::FRIENDLY,
                        ])
                ]
            ])
            ->andWhere([
                'not',
                [
                    'team_id' => Game::find()
                        ->joinWith(['schedule'])
                        ->select(['game_home_team_id'])
                        ->where([
                            'game_guest_team_id' => $this->myTeam->team_id,
                            'schedule_season_id' => Season::getCurrentSeason(),
                            'schedule_tournament_type_id' => TournamentType::FRIENDLY,
                        ])
                ]
            ])
            ->andWhere([
                'not',
                [
                    'team_id' => Team::find()
                        ->select(['team_id'])
                        ->where([
                            'team_user_id' => User::find()
                                ->select(['user_id'])
                                ->where(['user_referrer_id' => $this->user->user_id])
                        ])
                ]
            ])
            ->andWhere([
                'not',
                [
                    'team_id' => Team::find()
                        ->select(['team_id'])
                        ->where(['team_user_id' => $this->user->user_referrer_id])
                ]
            ])
            ->orderBy(['team_power_vs' => SORT_DESC]);

        $championshipSchedule = Schedule::find()
            ->where([
                'schedule_date' => $scheduleMain->schedule_date,
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_stage_id' => [Stage::FINAL_GAME, Stage::SEMI, Stage::QUARTER]
            ])
            ->count();
        if ($championshipSchedule) {
            $check = Conference::find()
                ->where([
                    'conference_season_id' => Season::getCurrentSeason(),
                    'conference_team_id' => $this->myTeam->team_id
                ])
                ->count();
            if ($check) {
                $this->setErrorFlash('Ваша команда играет в конференции любительских клубов');
                return $this->redirect(['friendly/index']);
            }

            $query->andWhere([
                'not',
                [
                    'team_id' => Conference::find()
                        ->select(['conference_team_id'])
                        ->where(['conference_season_id' => Season::getCurrentSeason()])
                ]
            ]);
            $countParticipant = ParticipantChampionship::find()
                ->where(['participant_championship_season_id' => Season::getCurrentSeason()])
                ->count();
            if ($countParticipant) {
                $check = ParticipantChampionship::find()
                    ->where([
                        'participant_championship_stage_id' => 0,
                        'participant_championship_season_id' => Season::getCurrentSeason(),
                        'participant_championship_team_id' => $this->myTeam->team_id
                    ])
                    ->count();
                if ($check) {
                    $this->setErrorFlash('Ваша команда участвует в плейофф национального чемпионата');
                    return $this->redirect(['friendly/index']);
                }

                $query
                    ->andWhere([
                        'not',
                        [
                            'team_id' => ParticipantChampionship::find()
                                ->select(['participant_championship_team_id'])
                                ->where([
                                    'participant_championship_stage_id' => 0,
                                    'participant_championship_season_id' => Season::getCurrentSeason(),
                                ])
                        ]
                    ]);
            } else {
                $check = Championship::find()
                    ->where([
                        'championship_season_id' => Season::getCurrentSeason(),
                        'championship_team_id' => $this->myTeam->team_id
                    ])
                    ->count();
                if ($check) {
                    $this->setErrorFlash('В этот день можно назначить матч только после формирования пар плей-офф');
                    return $this->redirect(['friendly/index']);
                }

                $query
                    ->andWhere([
                        'not',
                        [
                            'team_id' => Championship::find()
                                ->select(['championship_team_id'])
                                ->where(['championship_season_id' => Season::getCurrentSeason()])
                        ]
                    ]);
            }
        }
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
    public function actionSend($id, $teamId)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
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
                'friendly_invite_friendly_invite_status_id' => FriendlyInviteStatus::NEW_ONE,
            ])
            ->count();
        if ($invite >= 5) {
            $this->setErrorFlash('На один игровой день можно отправить не более 5 приглашений.');
            return $this->redirect(['friendly/view', 'id' => $id]);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = new FriendlyInvite();
            $model->friendly_invite_friendly_invite_status_id = FriendlyInviteStatus::NEW_ONE;
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
    public function actionAccept($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
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
    public function actionCancel($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
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
            return $this->redirect(['team/view']);
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
