<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Achievement;
use common\models\Finance;
use common\models\Game;
use common\models\History;
use common\models\Loan;
use common\models\Logo;
use common\models\Player;
use common\models\Season;
use common\models\Team;
use common\models\TeamAsk;
use common\models\Transfer;
use Exception;
use frontend\models\ChangeMyTeam;
use frontend\models\TeamLogo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class TeamController
 * @package frontend\controllers
 */
class TeamController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['ask', 'change-my-team'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['ask', 'change-my-team'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Team::find()
            ->select(['count_team' => 'COUNT(team_id)', 'team_stadium_id'])
            ->with([
                'stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_city_id', 'stadium_id']);
                },
                'stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_country_id', 'city_id']);
                },
                'stadium.city.country'
            ])
            ->joinWith([
                'stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
            ])
            ->where(['!=', 'team_id', 0])
            ->orderBy(['country_id' => SORT_ASC])
            ->groupBy(['country_id']);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('Команды');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int|null $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id = null)
    {
        if (!$id && $this->myTeam) {
            return $this->redirect(['view', 'id' => $this->myTeam->team_id]);
        }

        if (!$id) {
            return $this->redirect(['ask']);
        }

        $team = $this->getTeam($id);

        $query = Player::find()
            ->joinWith([
                'statisticPlayer' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select([
                        'statistic_player_assist',
                        'statistic_player_game',
                        'statistic_player_plus_minus',
                        'statistic_player_score',
                    ]);
                },
            ])
            ->with([
                'country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
                'name' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['name_id', 'name_name']);
                },
                'physical' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['physical_id', 'physical_name']);
                },
                'playerPosition' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['player_position_player_id', 'player_position_position_id']);
                },
                'playerPosition.position' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['position_id', 'position_name']);
                },
                'playerSpecial' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select([
                        'player_special_level',
                        'player_special_player_id',
                        'player_special_special_id',
                    ]);
                },
                'playerSpecial.special' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['special_id', 'special_name']);
                },
                'style' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['style_id', 'style_name']);
                },
                'surname' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['surname_id', 'surname_name']);
                },
            ])
            ->select([
                'player_age',
                'player_country_id',
                'player_game_row',
                'player_name_id',
                'player_id',
                'player_physical_id',
                'player_power_nominal',
                'player_power_real',
                'player_price',
                'player_style_id',
                'player_surname_id',
                'player_tire',
            ])
            ->where(['player_team_id' => $id])
            ->orWhere(['player_loan_team_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'assist' => [
                        'asc' => ['statistic_player.statistic_player_assist' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_assist' => SORT_DESC],
                    ],
                    'game' => [
                        'asc' => ['statistic_player.statistic_player_game' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_game' => SORT_DESC],
                    ],
                    'score' => [
                        'asc' => ['statistic_player.statistic_player_score' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_score' => SORT_DESC],
                    ],
                    'plus_minus' => [
                        'asc' => ['statistic_player.statistic_player_plus_minus' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_plus_minus' => SORT_DESC],
                    ],
                    'country' => [
                        'asc' => ['player_country_id' => SORT_ASC],
                        'desc' => ['player_country_id' => SORT_DESC],
                    ],
                    'game_row' => [
                        'asc' => ['player_game_row' => SORT_ASC],
                        'desc' => ['player_game_row' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC],
                    ],
                    'physical' => [
                        'asc' => [$team->myTeam() ? 'player_physical_id' : 'player_position_id' => SORT_ASC],
                        'desc' => [$team->myTeam() ? 'player_physical_id' : 'player_position_id' => SORT_DESC],
                    ],
                    'power_nominal' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => [$team->myTeam() ? 'player_power_real' : 'player_power_nominal' => SORT_ASC],
                        'desc' => [$team->myTeam() ? 'player_power_real' : 'player_power_nominal' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['player_price' => SORT_ASC],
                        'desc' => ['player_price' => SORT_DESC],
                    ],
                    'style' => [
                        'asc' => ['player_style_id' => SORT_ASC],
                        'desc' => ['player_style_id' => SORT_DESC],
                    ],
                    'tire' => [
                        'asc' => [$team->myTeam() ? 'player_tire' : 'player_position_id' => SORT_ASC],
                        'desc' => [$team->myTeam() ? 'player_tire' : 'player_position_id' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->setSeoTitle($team->fullName() . '. Профиль команды');

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'team' => $team,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionGame($id): string
    {
        $team = $this->getTeam($id);

        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = Game::find()
            ->joinWith(['schedule'])
            ->with([
                'schedule' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select([
                        'schedule_id',
                        'schedule_date',
                        'schedule_tournament_type_id',
                        'schedule_stage_id'
                    ]);
                },
                'schedule.stage' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stage_id', 'stage_name']);
                },
                'schedule.tournamentType' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['tournament_type_id', 'tournament_type_name']);
                },
                'teamGuest' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['team_id', 'team_name', 'team_power_vs', 'team_stadium_id']);
                },
                'teamGuest.stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_id', 'stadium_city_id']);
                },
                'teamGuest.stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_id', 'city_country_id', 'city_name']);
                },
                'teamGuest.stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
                'teamHome' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['team_id', 'team_name', 'team_power_vs', 'team_stadium_id']);
                },
                'teamHome.stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_id', 'stadium_city_id']);
                },
                'teamHome.stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_id', 'city_country_id', 'city_name']);
                },
                'teamHome.stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
            ])
            ->select([
                'game_id',
                'game_guest_auto',
                'game_guest_plus_minus',
                'game_guest_power',
                'game_guest_score',
                'game_guest_team_id',
                'game_home_auto',
                'game_home_plus_minus',
                'game_home_power',
                'game_home_score',
                'game_home_team_id',
                'game_played',
                'game_schedule_id',
            ])
            ->where(['or', ['game_home_team_id' => $id], ['game_guest_team_id' => $id]])
            ->andWhere(['schedule_season_id' => $seasonId])
            ->orderBy(['schedule_date' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Матчи команды');

        return $this->render('game', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
            'team' => $team,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEvent($id): string
    {
        $team = $this->getTeam($id);

        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $query = History::find()
            ->with([
                'historyText' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['history_text_id', 'history_text_text']);
                },
                'team' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['team_id', 'team_name']);
                },
                'player' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['player_id', 'player_name_id', 'player_surname_id']);
                },
                'player.name' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['name_id', 'name_name']);
                },
                'player.surname' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['surname_id', 'surname_name']);
                },
                'user' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['user_id', 'user_login']);
                },
            ])
            ->select([
                'history_date',
                'history_history_text_id',
                'history_team_id',
                'history_user_id',
                'history_player_id',
            ])
            ->where(['or', ['history_team_id' => $id], ['history_team_2_id' => $id]])
            ->andWhere(['history_season_id' => $seasonId])
            ->orderBy(['history_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('События команды');

        return $this->render('event', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
            'team' => $team,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionFinance($id): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Finance::find()
                ->with([
                    'financeText' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['finance_text_id', 'finance_text_text']);
                    },
                    'player' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['player_id', 'player_name_id', 'player_surname_id']);
                    },
                    'player.name' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['name_id', 'name_name']);
                    },
                    'player.surname' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['surname_id', 'surname_name']);
                    },
                ])
                ->select([
                    'finance_building_id',
                    'finance_capacity',
                    'finance_date',
                    'finance_level',
                    'finance_finance_text_id',
                    'finance_value',
                    'finance_value_after',
                    'finance_value_before',
                ])
                ->where(['finance_team_id' => $id])
                ->andWhere(['finance_season_id' => $seasonId])
                ->orderBy(['finance_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Финансы команды');

        return $this->render('finance', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeal($id): string
    {
        $team = $this->getTeam($id);

        $query = Transfer::find()
            ->where(['transfer_team_seller_id' => $id])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC]);
        $dataProviderTransferFrom = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Transfer::find()
            ->where(['transfer_team_buyer_id' => $id])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC]);
        $dataProviderTransferTo = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Loan::find()
            ->where(['loan_team_seller_id' => $id])
            ->andWhere(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC]);
        $dataProviderLoanFrom = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Loan::find()
            ->with([
            ])
            ->select([
            ])
            ->where(['loan_team_buyer_id' => $id])
            ->andWhere(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC]);
        $dataProviderLoanTo = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Сделки команды');

        return $this->render('deal', [
            'dataProviderTransferFrom' => $dataProviderTransferFrom,
            'dataProviderTransferTo' => $dataProviderTransferTo,
            'dataProviderLoanFrom' => $dataProviderLoanFrom,
            'dataProviderLoanTo' => $dataProviderLoanTo,
            'team' => $team,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAchievement($id): string
    {
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Achievement::find()
                ->with([
                ])
                ->select([
                    'achievement_season_id',
                ])
                ->where(['achievement_team_id' => $id])
                ->orderBy(['achievement_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Достижения команды');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionStatistics($id): string
    {
        $team = $this->getTeam($id);

        $this->setSeoTitle($team->fullName() . '. Статистика команды');

        return $this->render('statistics', [
            'team' => $team,
        ]);
    }

    /**
     * @param null $id
     * @return string|Response
     * @throws \yii\db\Exception
     */
    public function actionAsk($id = null)
    {
        if ($this->myTeam) {
            return $this->redirect(['view']);
        }

        if ($id) {
            if (!Team::find()->where(['team_id' => $id, 'team_user_id' => 0])->count()) {
                Yii::$app->session->setFlash('error', 'The team was chosen incorrectly.');
                return $this->redirect(['ask']);
            }

            if (TeamAsk::find()->where([
                'team_ask_team_id' => $id,
                'team_ask_user_id' => Yii::$app->user->id
            ])->count()) {
                Yii::$app->session->setFlash('error', 'Вы уже подали заявку на эту команду.');
                return $this->redirect(['team/ask']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new TeamAsk();
                $model->team_ask_team_id = $id;
                $model->save();
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Заявка успешно подана.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }

            return $this->redirect(['team/ask']);
        }

        $delete = Yii::$app->request->get('delete');
        if ($delete) {
            TeamAsk::deleteAll(['team_ask_id' => $delete, 'team_ask_user_id' => Yii::$app->user->id]);

            Yii::$app->session->setFlash('success', 'Заявка успешно удалена.');
            return $this->redirect(['team/ask']);
        }

        $teamAskArray = TeamAsk::find()
            ->with([
                'team' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['team_id', 'team_name', 'team_power_vs', 'team_stadium_id']);
                },
                'team.stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_capacity', 'stadium_city_id', 'stadium_id']);
                },
                'team.stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_country_id', 'city_id', 'city_name']);
                },
                'team.stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
            ])
            ->select(['team_ask_id', 'team_ask_team_id'])
            ->where(['team_ask_user_id' => Yii::$app->user->id])
            ->all();

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Team::find()
                ->joinWith([
                    'stadium' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['stadium_capacity', 'stadium_city_id', 'stadium_id']);
                    },
                    'stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['country_id', 'country_name']);
                    },
                ])
                ->with([
                    'base' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['base_id', 'base_level', 'base_slot_max']);
                    },
                    'baseMedical' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['base_medical_id', 'base_medical_level']);
                    },
                    'basePhysical' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['base_physical_id', 'base_physical_level']);
                    },
                    'baseSchool' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['base_school_id', 'base_school_level']);
                    },
                    'baseScout' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['base_scout_id', 'base_scout_level']);
                    },
                    'baseTraining' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['base_training_id', 'base_training_level']);
                    },
                    'stadium.city' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['city_country_id', 'city_id', 'city_name']);
                    },
                    'teamAsk' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['team_ask_team_id']);
                    }
                ])
                ->select([
                    'team_id',
                    'team_name',
                    'team_power_vs',
                    'team_base_id',
                    'team_base_training_id',
                    'team_base_scout_id',
                    'team_base_school_id',
                    'team_base_medical_id',
                    'team_base_physical_id',
                    'team_finance',
                    'team_stadium_id',
                ])
                ->where(['!=', 'team_id', 0])
                ->andWhere(['team_user_id' => 0]),
            'sort' => [
                'attributes' => [
                    'base' => [
                        'asc' => ['team_base_id' => SORT_ASC],
                        'desc' => ['team_base_id' => SORT_DESC],
                    ],
                    'country' => [
                        'asc' => ['country_name' => SORT_ASC],
                        'desc' => ['country_name' => SORT_DESC],
                    ],
                    'finance' => [
                        'asc' => ['team_finance' => SORT_ASC],
                        'desc' => ['team_finance' => SORT_DESC],
                    ],
                    'stadium' => [
                        'asc' => ['stadium_capacity' => SORT_ASC],
                        'desc' => ['stadium_capacity' => SORT_DESC],
                    ],
                    'team' => [
                        'asc' => ['team_name' => SORT_ASC],
                        'desc' => ['team_name' => SORT_DESC],
                    ],
                    'vs' => [
                        'asc' => ['team_power_vs' => SORT_ASC],
                        'desc' => ['team_power_vs' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['vs' => SORT_DESC],
            ],
        ]);

        $this->setSeoTitle('Получение команды');

        return $this->render('ask', [
            'dataProvider' => $dataProvider,
            'model' => new Team(),
            'teamAskArray' => $teamAskArray,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLogo(int $id)
    {
        $team = Team::find()
            ->where(['team_id' => $id])
            ->one();
        $this->notFound($team);

        $model = new TeamLogo($team->team_id);
        if ($model->upload()) {
            $this->setSuccessFlash('Данные успешно сохранены.');
            return $this->refresh();
        }

        $logoArray = Logo::find()->all();

        $this->setSeoTitle('Загрузить эмблему');

        return $this->render('logo', [
            'logoArray' => $logoArray,
            'model' => $model,
            'team' => $team,
        ]);
    }

    /**
     * @return Response
     */
    public function actionChangeMyTeam(): Response
    {
        $model = new ChangeMyTeam();
        if ($model->load(Yii::$app->request->post(), '')) {
            $model->changeMyTeam();
        }

        return $this->redirect(['view']);
    }

    /**
     * @param int $id
     * @return Team
     * @throws \yii\web\NotFoundHttpException
     */
    public function getTeam(int $id): Team
    {
        $team = Team::find()
            ->where(['team_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($team);

        return $team;
    }
}
