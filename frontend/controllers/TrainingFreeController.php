<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Building;
use common\models\History;
use common\models\HistoryText;
use common\models\Loan;
use common\models\Player;
use common\models\PlayerPosition;
use common\models\PlayerSpecial;
use common\models\Position;
use common\models\Special;
use common\models\Training;
use common\models\Transfer;
use common\models\User;
use Exception;
use frontend\models\TrainingFree;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class TrainingFreeController
 * @package frontend\controllers
 */
class TrainingFreeController extends AbstractController
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
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $model = new TrainingFree();
        if ($model->load(Yii::$app->request->post(), '')) {
            return $this->redirect($model->redirectUrl());
        }

        $team = $this->myTeam;

        $trainingArray = Training::find()
            ->where(['training_team_id' => $team->team_id, 'training_ready' => 0])
            ->orderBy(['training_id' => SORT_ASC])
            ->all();

        $query = Player::find()
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->orderBy(['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'onBuilding' => $this->isOnBuilding(),
            'team' => $team,
            'trainingArray' => $trainingArray,
            'user' => Yii::$app->user->identity,
        ]);
    }

    /**
     * @return bool
     */
    private function isOnBuilding()
    {
        if (!$this->myTeam->buildingBase) {
            return false;
        }

        if (!in_array($this->myTeam->buildingBase->building_base_building_id, [Building::BASE, Building::TRAINING])) {
            return false;
        }

        return true;
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionTrain()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        $team = $this->myTeam;

        $data = Yii::$app->request->get();

        $confirmData = [
            'position' => [],
            'power' => [],
            'special' => [],
        ];

        $playerIdArray = [];

        if (isset($data['power'])) {
            foreach ($data['power'] as $playerId => $power) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->andWhere(['<', 'player_date_no_action', time()])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Игрок выбран неправильно.');
                    return $this->redirect(['training-free/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if ($transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['training-free/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if ($loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['training-free/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['training-free/index']);
                }

                $confirmData['power'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                ];

                $playerIdArray[] = $playerId;
            }
        }

        if (isset($data['position'])) {
            foreach ($data['position'] as $playerId => $position) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->andWhere(['<', 'player_date_no_action', time()])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Игрок выбран неправильно.');
                    return $this->redirect(['training-free/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if ($transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['training-free/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if ($loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['training-free/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['training-free/index']);
                }

                $position = Position::find()
                    ->where(['position_id' => $position])
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
                if (!$position) {
                    $this->setErrorFlash('Совмещение выбрано не правильно.');
                    return $this->redirect(['training-free/index']);
                }

                $confirmData['position'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                    'position' => [
                        'id' => $position->position_id,
                        'name' => $position->position_text,
                    ],
                ];

                $playerIdArray[] = $playerId;
            }
        }

        if (isset($data['special'])) {
            foreach ($data['special'] as $playerId => $special) {
                $player = Player::find()
                    ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                    ->andWhere(['<', 'player_date_no_action', time()])
                    ->limit(1)
                    ->one();
                if (!$player) {
                    $this->setErrorFlash('Игрок выбран неправильно.');
                    return $this->redirect(['training-free/index']);
                }

                $transfer = Transfer::find()
                    ->where(['transfer_player_id' => $playerId, 'transfer_ready' => 0])
                    ->count();
                if ($transfer) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на трансфер.');
                    return $this->redirect(['training-free/index']);
                }

                $loan = Loan::find()
                    ->where(['loan_player_id' => $playerId, 'loan_ready' => 0])
                    ->count();
                if ($loan) {
                    $this->setErrorFlash('Нельзя тренировать игрока, который выставлен на арендный рынок.');
                    return $this->redirect(['training-free/index']);
                }

                $training = Training::find()
                    ->where(['training_player_id' => $playerId, 'training_ready' => 0])
                    ->count();
                if ($training) {
                    $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
                    return $this->redirect(['training-free/index']);
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
                if (!$special) {
                    $this->setErrorFlash('Спецвозможность выбрано не правильно.');
                    return $this->redirect(['training-free/index']);
                }

                $confirmData['special'][] = [
                    'id' => $playerId,
                    'name' => $player->playerName(),
                    'special' => [
                        'id' => $special->special_id,
                        'name' => $special->special_text,
                    ],
                ];

                $playerIdArray[] = $playerId;
            }
        }

        if (count($confirmData['power']) > $user->user_shop_point) {
            $this->setErrorFlash('У вас недостаточно баллов для тренировки.');
            return $this->redirect(['training-free/index']);
        } elseif (count($confirmData['position']) > $user->user_shop_position) {
            $this->setErrorFlash('У вас недостаточно совмещений для тренировки.');
            return $this->redirect(['training-free/index']);
        } elseif (count($confirmData['special']) > $user->user_shop_special) {
            $this->setErrorFlash('У вас недостаточно спецвозможностей для тренировки.');
            return $this->redirect(['training-free/index']);
        } elseif (count($playerIdArray) != count(array_unique($playerIdArray))) {
            $this->setErrorFlash('Одному игроку нельзя назначить несколько тренировок одновременно.');
            return $this->redirect(['training-free/index']);
        }

        if (Yii::$app->request->get('ok')) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($confirmData['power'] as $power) {
                    $player = Player::find()
                        ->where(['player_id' => $power['id']])
                        ->limit(1)
                        ->one();

                    $player->player_power_nominal = $player->player_power_nominal + 1;
                    $player->save(true, ['player_power_nominal']);

                    $user->user_shop_point = $user->user_shop_point - 1;
                    $user->save(true, ['user_shop_point']);

                    History::log([
                        'history_history_text_id' => HistoryText::PLAYER_BONUS_POINT,
                        'history_player_id' => $power['id'],
                    ]);

                    $sql = "UPDATE `player`
                            LEFT JOIN `physical`
                            ON `player_physical_id`=`physical_id`
                            SET `player_power_real`=`player_power_nominal`*(100-`player_tire`)/100*`physical_value`/100
                            WHERE `player_id`=" . $power['id'];
                    Yii::$app->db->createCommand($sql)->execute();
                }

                foreach ($confirmData['position'] as $playerId => $position) {
                    $playerPosition = new PlayerPosition();
                    $playerPosition->player_position_player_id = $position['id'];
                    $playerPosition->player_position_position_id = $position['position']['id'];
                    $playerPosition->save();

                    $user->user_shop_position = $user->user_shop_position - 1;
                    $user->save(true, ['user_shop_position']);

                    History::log([
                        'history_history_text_id' => HistoryText::PLAYER_BONUS_POSITION,
                        'history_player_id' => $position['id'],
                        'history_position_id' => $position['position']['id'],
                    ]);
                }

                foreach ($confirmData['special'] as $playerId => $special) {
                    $playerSpecial = PlayerSpecial::find()
                        ->where([
                            'player_special_player_id' => $special['id'],
                            'player_special_special_id' => $special['special']['id'],
                        ])
                        ->limit(1)
                        ->one();
                    if (!$playerSpecial) {
                        $playerSpecial = new PlayerSpecial();
                        $playerSpecial->player_special_player_id = $special['id'];
                        $playerSpecial->player_special_special_id = $special['special']['id'];
                        $playerSpecial->player_special_level = 0;
                    }
                    $playerSpecial->player_special_level = $playerSpecial->player_special_level + 1;
                    $playerSpecial->save();

                    $user->user_shop_special = $user->user_shop_special - 1;
                    $user->save(true, ['user_shop_special']);

                    History::log([
                        'history_history_text_id' => HistoryText::PLAYER_BONUS_SPECIAL,
                        'history_player_id' => $special['id'],
                        'history_special_id' => $special['special']['id'],
                    ]);
                }

                $transaction->commit();

                $this->setSuccessFlash('Тренировка прошла успешно.');
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
                $this->setErrorFlash();
            }
            return $this->redirect(['training-free/index']);
        }

        $this->setSeoTitle($team->fullName() . '. Тренировка хоккеистов');

        return $this->render('train', [
            'confirmData' => $confirmData,
            'team' => $team,
            'user' => $user,
        ]);
    }
}
