<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\AchievementPlayer;
use common\models\History;
use common\models\Lineup;
use common\models\Loan;
use common\models\Player;
use common\models\Position;
use common\models\Season;
use common\models\Squad;
use common\models\Transfer;
use frontend\models\LoanApplicationFrom;
use frontend\models\LoanApplicationTo;
use frontend\models\LoanFrom;
use frontend\models\LoanTo;
use frontend\models\PlayerSearch;
use frontend\models\TransferApplicationFrom;
use frontend\models\TransferApplicationTo;
use frontend\models\TransferFrom;
use frontend\models\TransferTo;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class PlayerController
 * @package frontend\controllers
 */
class PlayerController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new PlayerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $countryArray = ArrayHelper::map(
            Player::find()
                ->with([
                    'country' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['country_id', 'country_name']);
                    },
                ])
                ->select(['player_country_id'])
                ->groupBy(['player_country_id'])
                ->orderBy(['player_country_id' => SORT_ASC])
                ->all(),
            'country.country_id',
            'country.country_name'
        );

        $positionArray = ArrayHelper::map(
            Position::find()
                ->select(['position_id', 'position_name'])
                ->orderBy(['position_id' => SORT_ASC])
                ->all(),
            'position_id',
            'position_name'
        );

        $this->setSeoTitle('Список хоккеистов');

        return $this->render('index', [
            'countryArray' => $countryArray,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
            'positionArray' => $positionArray,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $player = $this->getPlayer($id);

        $seasonId = Yii::$app->request->get('season_id', Season::getCurrentSeason());

        $query = Lineup::find()
            ->joinWith(['game.schedule'])
            ->with([
            ])
            ->select([
            ])
            ->where(['lineup_player_id' => $id])
            ->andWhere(['schedule.schedule_season_id' => $seasonId])
            ->andWhere(['!=', 'game.game_played', 0])
            ->orderBy(['schedule_date' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($player->playerName() . '. Профиль игрока');

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'player' => $player,
            'seasonArray' => Season::getSeasonArray(),
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEvent(int $id): string
    {
        $player = $this->getPlayer($id);

        $query = History::find()
            ->select([
                'history_date',
                'history_history_text_id',
                'history_player_id',
                'history_season_id',
                'history_team_id',
            ])
            ->where(['history_player_id' => $id])
            ->orderBy(['history_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($player->playerName() . '. События игрока');

        return $this->render('event', [
            'dataProvider' => $dataProvider,
            'player' => $player,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeal(int $id): string
    {
        $player = $this->getPlayer($id);

        $query = Loan::find()
            ->where(['loan_player_id' => $id])
            ->andWhere(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC]);
        $dataProviderLoan = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Transfer::find()
            ->where(['transfer_player_id' => $id])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC]);
        $dataProviderTransfer = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($player->playerName() . '. Сделки игрока');

        return $this->render('deal', [
            'dataProviderLoan' => $dataProviderLoan,
            'dataProviderTransfer' => $dataProviderTransfer,
            'player' => $player,
        ]);
    }

    /**
     * @param int $id
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionTransfer(int $id)
    {
        $player = Player::find()
            ->select([
                'player_age',
                'player_country_id',
                'player_date_no_action',
                'player_id',
                'player_loan_team_id',
                'player_national_id',
                'player_no_deal',
                'player_position_id',
                'player_price',
                'player_team_id',
            ])
            ->where(['player_id' => $id])
            ->one();
        $this->notFound($player);
        $myPlayer = true;
        if (!$this->myTeam) {
            $myPlayer = false;
        } elseif ($this->myTeam->team_id != $player->player_team_id) {
            $myPlayer = false;
        }
        $onTransfer = $player->transfer ? true : false;

        $formConfig = ['player' => $player, 'team' => $this->myTeam];

        $modelTransferTo = new TransferTo($formConfig);
        $modelTransferFrom = new TransferFrom($formConfig);
        $modelTransferApplicationTo = new TransferApplicationTo($formConfig);
        $modelTransferApplicationFrom = new TransferApplicationFrom($formConfig);
        if ($myPlayer) {
            if ($modelTransferTo->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelTransferTo);
                } else {
                    try {
                        $modelTransferTo->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }

            if ($modelTransferFrom->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelTransferFrom);
                } else {
                    try {
                        $modelTransferFrom->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }
        } else {
            if ($modelTransferApplicationTo->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelTransferApplicationTo);
                } else {
                    try {
                        $modelTransferApplicationTo->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }

            if ($modelTransferApplicationFrom->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelTransferApplicationTo);
                } else {
                    try {
                        $modelTransferApplicationFrom->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }
        }

        $this->setSeoTitle('Трансфер игрока');

        return $this->render('transfer', [
            'modelTransferApplicationFrom' => $modelTransferApplicationFrom,
            'modelTransferApplicationTo' => $modelTransferApplicationTo,
            'modelTransferFrom' => $modelTransferFrom,
            'modelTransferTo' => $modelTransferTo,
            'myPlayer' => $myPlayer,
            'onTransfer' => $onTransfer,
        ]);
    }

    /**
     * @param int $id
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLoan(int $id)
    {
        $player = Player::find()
            ->select([
                'player_age',
                'player_country_id',
                'player_date_no_action',
                'player_id',
                'player_loan_team_id',
                'player_national_id',
                'player_no_deal',
                'player_position_id',
                'player_price',
                'player_team_id',
            ])
            ->where(['player_id' => $id])
            ->one();
        $this->notFound($player);
        $myPlayer = true;
        if (!$this->myTeam) {
            $myPlayer = false;
        } elseif ($this->myTeam->team_id != $player->player_team_id) {
            $myPlayer = false;
        }
        $onLoan = $player->loan ? true : false;

        $formConfig = ['player' => $player, 'team' => $this->myTeam];

        $modelLoanTo = new LoanTo($formConfig);
        $modelLoanFrom = new LoanFrom($formConfig);
        $modelLoanApplicationTo = new LoanApplicationTo($formConfig);
        $modelLoanApplicationFrom = new LoanApplicationFrom($formConfig);
        if ($myPlayer) {
            if ($modelLoanTo->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelLoanTo);
                } else {
                    try {
                        $modelLoanTo->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }

            if ($modelLoanFrom->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelLoanFrom);
                } else {
                    try {
                        $modelLoanFrom->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }
        } else {
            if ($modelLoanApplicationTo->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelLoanApplicationTo);
                } else {
                    try {
                        $modelLoanApplicationTo->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }

            if ($modelLoanApplicationFrom->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($modelLoanApplicationTo);
                } else {
                    try {
                        $modelLoanApplicationFrom->execute();
                    } catch (Throwable $e) {
                        ErrorHelper::log($e);
                    }
                    return $this->refresh();
                }
            }
        }

        $this->setSeoTitle('Аренда игрока');

        return $this->render('loan', [
            'modelLoanApplicationFrom' => $modelLoanApplicationFrom,
            'modelLoanApplicationTo' => $modelLoanApplicationTo,
            'modelLoanFrom' => $modelLoanFrom,
            'modelLoanTo' => $modelLoanTo,
            'myPlayer' => $myPlayer,
            'onLoan' => $onLoan,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionAchievement(int $id): string
    {
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => AchievementPlayer::find()
                ->select([
                    'achievement_player_season_id',
                    'achievement_player_stage_id',
                    'achievement_player_team_id',
                    'achievement_player_tournament_type_id',
                ])
                ->where(['achievement_player_player_id' => $id])
                ->orderBy(['achievement_player_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Достижения игрока');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSquad(int $id): bool
    {
        if (!$this->myTeam) {
            return false;
        }

        $player = Player::find()->where(['player_id' => $id, 'player_team_id' => $this->myTeam->team_id])->one();
        $this->notFound($player);

        $player->player_squad_id = Yii::$app->request->get('squad', Squad::SQUAD_DEFAULT);
        if (!$player->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return Player
     * @throws \yii\web\NotFoundHttpException
     */
    private function getPlayer(int $id): Player
    {
        $player = Player::find()
            ->with([
                'country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
                'loanTeam' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['team_id', 'team_name', 'team_stadium_id']);
                },
                'loanTeam.stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_id', 'stadium_city_id', 'stadium_name']);
                },
                'loanTeam.stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_id', 'city_country_id', 'city_name']);
                },
                'loanTeam.stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
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
                'team' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['team_id', 'team_name', 'team_stadium_id']);
                },
                'team.stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_id', 'stadium_city_id', 'stadium_name']);
                },
                'team.stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_id', 'city_country_id', 'city_name']);
                },
                'team.stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
            ])
            ->select([
                'player_age',
                'player_country_id',
                'player_id',
                'player_injury',
                'player_injury_day',
                'player_loan_day',
                'player_loan_team_id',
                'player_name_id',
                'player_national_id',
                'player_physical_id',
                'player_power_nominal',
                'player_power_real',
                'player_price',
                'player_salary',
                'player_squad_id',
                'player_style_id',
                'player_surname_id',
                'player_team_id',
                'player_tire',
            ])
            ->where(['player_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($player);

        return $player;
    }
}
