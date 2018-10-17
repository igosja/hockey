<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use common\models\TeamAsk;
use Exception;
use frontend\models\ChangeMyTeam;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class TeamController
 * @package frontend\controllers
 */
class TeamController extends BaseController
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
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Team::find()
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
                ->groupBy(['country_id'])
        ]);

        $this->view->title = Yii::t('frontend-controllers-team-index', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-team-index', 'seo-description')
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => new Team(),
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     */
    public function actionView(int $id = null)
    {
        if (!$id && $this->myTeam) {
            return $this->redirect(['view', 'id' => $this->myTeam->team_id]);
        }

        if (!$id) {
            return $this->redirect(['ask']);
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Player::find()
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
                ->orWhere(['player_loan_team_id' => $id]),
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
                        'asc' => ['player_physical_id' => SORT_ASC],
                        'desc' => ['player_physical_id' => SORT_DESC],
                    ],
                    'power' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => ['player_power_real' => SORT_ASC],
                        'desc' => ['player_power_real' => SORT_DESC],
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
                        'asc' => ['player_tire' => SORT_ASC],
                        'desc' => ['player_tire' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->view->title = Yii::t('frontend-controllers-team-view', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-team-view', 'seo-description')
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => new Player(),
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
                Yii::$app->session->setFlash('error', Yii::t('frontend-controllers-team-ask', 'error-already-apply'));
                return $this->redirect(['ask']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new TeamAsk();
                $model->team_ask_team_id = $id;
                if (!$model->save()) {
                    throw new Exception(ErrorHelper::modelErrorsToString($model));
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', Yii::t('frontend-controllers-team-ask', 'success-apply'));
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }

            return $this->redirect(['team/ask']);
        }

        $delete = Yii::$app->request->get('delete');
        if ($delete) {
            TeamAsk::deleteAll(['team_ask_id' => $delete, 'team_ask_user_id' => Yii::$app->user->id]);

            Yii::$app->session->setFlash('success', Yii::t('frontend-controllers-team-ask', 'success-delete'));
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

        $this->view->title = Yii::t('frontend-controllers-team-ask', 'seo-title');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('frontend-controllers-team-ask', 'seo-description')
        ]);

        return $this->render('ask', [
            'dataProvider' => $dataProvider,
            'model' => new Team(),
            'teamAskArray' => $teamAskArray,
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
}
