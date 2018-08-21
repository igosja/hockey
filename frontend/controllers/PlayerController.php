<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\AchievementPlayer;
use common\models\History;
use common\models\Lineup;
use common\models\Loan;
use common\models\Player;
use common\models\Squad;
use common\models\Transfer;
use frontend\models\LoanApplicationFrom;
use frontend\models\LoanApplicationTo;
use frontend\models\LoanFrom;
use frontend\models\LoanTo;
use frontend\models\TransferApplicationFrom;
use frontend\models\TransferApplicationTo;
use frontend\models\TransferFrom;
use frontend\models\TransferTo;
use Throwable;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class PlayerController
 * @package frontend\controllers
 */
class PlayerController extends BaseController
{
    /**
     * @param integer $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $gameArray = Lineup::find()
            ->joinWith(['game.schedule'])
            ->where(['lineup_player_id' => $id])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->all();

        $this->view->title = 'Player profile';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Player profile - Virtual Hockey Online League'
        ]);

        return $this->render('view', [
            'gameArray' => $gameArray,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionEvent(int $id): string
    {
        $eventArray = History::find()
            ->select([
                'history_date',
                'history_history_text_id',
                'history_player_id',
                'history_season_id',
                'history_team_id',
            ])
            ->where(['history_player_id' => $id])
            ->orderBy(['history_id' => SORT_DESC])
            ->all();

        return $this->render('event', [
            'eventArray' => $eventArray,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionDeal(int $id): string
    {
        $loanArray = Loan::find()
            ->select([
            ])
            ->where(['loan_player_id' => $id])
            ->andWhere(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC])
            ->all();

        $transferArray = Transfer::find()
            ->select([
            ])
            ->where(['transfer_player_id' => $id])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC])
            ->all();

        return $this->render('deal', [
            'loanArray' => $loanArray,
            'transferArray' => $transferArray,
        ]);
    }

    /**
     * @param integer $id
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionTransfer(int $id)
    {
        $player = Player::find()
            ->select([
                'player_age',
                'player_country_id',
                'player_id',
                'player_loan_team_id',
                'player_national_id',
                'player_no_action',
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
     * @param integer $id
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLoan(int $id)
    {
        $player = Player::find()
            ->select([
                'player_age',
                'player_country_id',
                'player_id',
                'player_loan_team_id',
                'player_national_id',
                'player_no_action',
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
        $achievementArray = AchievementPlayer::find()
            ->select([
                'achievement_player_season_id',
                'achievement_player_stage_id',
                'achievement_player_team_id',
                'achievement_player_tournament_type_id',
            ])
            ->where(['achievement_player_player_id' => $id])
            ->orderBy(['achievement_player_id' => SORT_DESC])
            ->all();

        return $this->render('achievement', [
            'achievementArray' => $achievementArray,
        ]);
    }

    /**
     * @param integer $id
     * @return bool
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
}
