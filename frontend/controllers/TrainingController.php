<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Building;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Loan;
use common\models\Player;
use common\models\PlayerPosition;
use common\models\PlayerSpecial;
use common\models\Position;
use common\models\Special;
use common\models\Training;
use common\models\Transfer;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class TrainingController
 * @package frontend\controllers
 */
class TrainingController extends AbstractController
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

        $model = new \frontend\models\Training();
        if ($model->load(Yii::$app->request->post(), '')) {
            return $this->redirect($model->redirectUrl());
        }

        $team = $this->myTeam;

        $query = Player::find()
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->orderBy(['player_position_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'team' => $team,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionTrain()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $team = $this->myTeam;

        if ($team->buildingBase) {
            $this->setErrorFlash('На базе сейчас идет строительство.');
            return $this->redirect(['transfer/index']);
        }

        $data = Yii::$app->request->get();

        $confirmData = [
            'position' => [],
            'power' => [],
            'special' => [],
            'price' => 0,
        ];

        $playerIdArray = [];

        if (isset($data['power'])) {
            foreach ($data['power'] as $playerId => $power) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который находиться в аренде.');
                    return $this->redirect(['transfer/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if (!$transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['transfer/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if (!$loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['transfer/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['transfer/index']);
                }

                $confirmData['power'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                ];

                $confirmData['price'] = $confirmData['price'] + $team->baseTraining->base_training_power_price;

                $playerIdArray[] = $playerId;
            }
        }

        if (isset($data['position'])) {
            foreach ($data['position'] as $playerId => $special) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который находиться в аренде.');
                    return $this->redirect(['transfer/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if (!$transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['transfer/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if (!$loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['transfer/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['transfer/index']);
                }

                $special = Position::find()
                    ->where(['position_id' => $special])
                    ->andWhere([
                        'not',
                        [
                            'position_id' => PlayerPosition::find()
                                ->select(['player_position_position_id'])
                                ->where(['player_position_player_id' => $playerId])
                        ]
                    ])
                    ->limit(1)
                    ->one();
                if ($special) {
                    $this->setErrorFlash('Совмещение выбрано не правильно.');
                    return $this->redirect(['transfer/index']);
                }

                $confirmData['power'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                    'position' => [
                        'id' => $special->position_id,
                        'name' => $special->position_name,
                    ],
                ];

                $confirmData['price'] = $confirmData['price'] + $team->baseTraining->base_training_position_price;

                $playerIdArray[] = $playerId;
            }
        }

        if (isset($data['special'])) {
            foreach ($data['special'] as $playerId => $special) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который находиться в аренде.');
                    return $this->redirect(['transfer/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if (!$transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['transfer/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if (!$loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['transfer/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['transfer/index']);
                }

                $isGk = Position::GK == $player->player_position_id ? 1 : null;
                $isField = Position::GK == $player->player_position_id ? null : 1;

                $special = Special::find()
                    ->where(['special_id' => $special])
                    ->andFilterWhere(['special_gk' => $isGk, 'special_field' => $isField])
                    ->andWhere([
                        'not',
                        [
                            'special_id' => PlayerSpecial::find()
                                ->select(['player_special_special_id'])
                                ->where([
                                    'player_special_player_id' => $playerId,
                                    'player_special_level' => Special::MAX_LEVEL,
                                ])
                        ]
                    ])
                    ->limit(1)
                    ->one();
                if ($special) {
                    $this->setErrorFlash('Спецвозможность выбрано не правильно.');
                    return $this->redirect(['transfer/index']);
                }

                $confirmData['power'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                    'special' => [
                        'id' => $special->special_id,
                        'name' => $special->special_name,
                    ],
                ];

                $confirmData['price'] = $confirmData['price'] + $team->baseTraining->base_training_special_price;

                $playerIdArray[] = $playerId;
            }
        }

        if (count($confirmData['power']) > $team->availableTrainingPower()) {
            $this->setErrorFlash('У вас недостаточно баллов для тренировки.');
            return $this->redirect(['transfer/index']);
        } elseif (count($confirmData['position']) > $team->availableTrainingPosition()) {
            $this->setErrorFlash('У вас недостаточно совмещений для тренировки.');
            return $this->redirect(['transfer/index']);
        } elseif (count($confirmData['special']) > $team->availableTrainingSpecial()) {
            $this->setErrorFlash('У вас недостаточно спецвозможностей для тренировки.');
            return $this->redirect(['transfer/index']);
        } elseif (count($playerIdArray) != count(array_unique($playerIdArray))) {
            $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
            return $this->redirect(['transfer/index']);
        } elseif ($confirmData['price'] > $team->team_finance) {
            $this->setErrorFlash('У вас недостаточно денег для тренировки.');
            return $this->redirect(['transfer/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($confirmData['power'] as $playerId => $power) {
                    $model = new Training();
                    $model->training_player_id = $playerId;
                    $model->training_power = 1;
                    $model->training_season_id = $this->seasonId;
                    $model->training_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::OUTCOME_TRAINING_POWER,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$team->baseTraining->base_training_power_price,
                        'finance_value_after' => $team->team_finance - $team->baseTraining->base_training_power_price,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $team->baseTraining->base_training_power_price;
                    $team->save(true, ['team_finance']);
                }

                foreach ($confirmData['position'] as $playerId => $position) {
                    $model = new Training();
                    $model->training_player_id = $playerId;
                    $model->training_position_id = $position['id'];
                    $model->training_season_id = $this->seasonId;
                    $model->training_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::OUTCOME_TRAINING_POSITION,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$team->baseTraining->base_training_position_price,
                        'finance_value_after' => $team->team_finance - $team->baseTraining->base_training_position_price,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $team->baseTraining->base_training_position_price;
                    $team->save(true, ['team_finance']);
                }

                foreach ($confirmData['special'] as $playerId => $special) {
                    $model = new Training();
                    $model->training_player_id = $playerId;
                    $model->training_season_id = $this->seasonId;
                    $model->training_special_id = $special['id'];
                    $model->training_team_id = $team->team_id;
                    $model->save();

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::OUTCOME_TRAINING_SPECIAL,
                        'finance_team_id' => $team->team_id,
                        'finance_value' => -$team->baseTraining->base_training_special_price,
                        'finance_value_after' => $team->team_finance - $team->baseTraining->base_training_special_price,
                        'finance_value_before' => $team->team_finance,
                    ]);

                    $team->team_finance = $team->team_finance - $team->baseTraining->base_training_special_price;
                    $team->save(true, ['team_finance']);
                }

                $transaction->commit();

                $this->setSuccessFlash('Тренировка успешно началась.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['training/index']);
        }

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('train', [
            'confirmData' => $confirmData,
            'team' => $team,
        ]);
    }

    /**
     * @return bool
     */
    private function isOnBuilding(): bool
    {
        if (!$this->myTeam->buildingBase) {
            return false;
        }

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::TRAINING])) {
            return false;
        }

        return true;
    }
}
