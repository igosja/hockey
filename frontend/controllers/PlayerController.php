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
    public function actionIndex()
    {
        $searchModel = new PlayerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $countryArray = ArrayHelper::map(
            Player::find()
                ->with([
                    'country',
                ])
                ->groupBy(['player_country_id'])
                ->orderBy(['player_country_id' => SORT_ASC])
                ->all(),
            'country.country_id',
            'country.country_name'
        );

        $positionArray = ArrayHelper::map(
            Position::find()
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
    public function actionView($id)
    {
        $player = $this->getPlayer($id);

        $seasonId = Yii::$app->request->get('season_id', Season::getCurrentSeason());

        $query = Lineup::find()
            ->joinWith(['game.schedule'])
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
    public function actionEvent($id)
    {
        $player = $this->getPlayer($id);

        $query = History::find()
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
    public function actionDeal($id)
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
    public function actionTransfer($id)
    {
        $player = $this->getPlayer($id);
        $onTransfer = $player->transfer ? true : false;

        $formConfig = ['player' => $player, 'team' => $this->myTeam];

        $modelTransferTo = new TransferTo($formConfig);
        $modelTransferFrom = new TransferFrom($formConfig);
        $modelTransferApplicationTo = new TransferApplicationTo($formConfig);
        $modelTransferApplicationFrom = new TransferApplicationFrom($formConfig);
        if ($player->myPlayer()) {
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
            'onTransfer' => $onTransfer,
            'player' => $player,
        ]);
    }

    /**
     * @param int $id
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLoan($id)
    {
        $player = $this->getPlayer($id);
        $onLoan = $player->loan ? true : false;

        $formConfig = ['player' => $player, 'team' => $this->myTeam];

        $modelLoanTo = new LoanTo($formConfig);
        $modelLoanFrom = new LoanFrom($formConfig);
        $modelLoanApplicationTo = new LoanApplicationTo($formConfig);
        $modelLoanApplicationFrom = new LoanApplicationFrom($formConfig);
        if ($player->myPlayer()) {
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
            'onLoan' => $onLoan,
            'player' => $player,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAchievement($id)
    {
        $player = $this->getPlayer($id);

        $query = AchievementPlayer::find()
            ->where(['achievement_player_player_id' => $id])
            ->orderBy(['achievement_player_id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle($player->playerName() . '. Достижения игрока');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
            'player' => $player,
        ]);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSquad($id)
    {
        if (!$this->myTeam) {
            return false;
        }

        $player = Player::find()
            ->where(['player_id' => $id, 'player_team_id' => $this->myTeam->team_id])
            ->limit(1)
            ->one();
        $this->notFound($player);

        $player->player_squad_id = Yii::$app->request->get('squad', Squad::SQUAD_DEFAULT);
        return $player->save(true, ['player_squad_id']);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionNationalSquad($id)
    {
        if (!$this->myNational) {
            return false;
        }

        $player = Player::find()
            ->where(['player_id' => $id, 'player_national_id' => $this->myNational->national_id])
            ->limit(1)
            ->one();
        $this->notFound($player);

        $player->player_national_squad_id = Yii::$app->request->get('squad', Squad::SQUAD_DEFAULT);
        return $player->save(true, ['player_national_squad_id']);
    }

    /**
     * @param int $id
     * @return Player
     * @throws \yii\web\NotFoundHttpException
     */
    private function getPlayer($id)
    {
        $player = Player::find()
            ->with([
                'country',
                'loanTeam.stadium.city.country',
                'name',
                'physical',
                'playerPosition.position',
                'playerSpecial.special',
                'style',
                'surname',
                'team',
                'team.stadium.city.country',
            ])
            ->where(['player_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($player);

        return $player;
    }
}
