<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\Player;
use common\models\Team;
use common\models\Transfer;
use common\models\TransferApplication;
use frontend\controllers\AbstractController;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class TransferApplicationTo
 * @package frontend\models
 *
 * @property int $maxPrice
 * @property int $minPrice
 * @property bool $onlyOne
 * @property Player $player
 * @property int $price
 * @property Team $team
 * @property TransferApplication $transferApplication
 */
class TransferApplicationTo extends Model
{
    public $onlyOne = false;
    public $price = 0;
    public $maxPrice = 0;
    public $minPrice = 0;
    public $player;
    public $team;
    public $transferApplication;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->minPrice = isset($this->player->transfer->transfer_price_seller) ? $this->player->transfer->transfer_price_seller : ceil($this->player->player_price / 2);
        $this->maxPrice = $this->team->team_finance;
        $this->transferApplication = TransferApplication::find()
            ->where([
                'transfer_application_team_id' => $this->team->team_id,
                'transfer_application_transfer_id' => (isset($this->player->transfer->transfer_id) ? $this->player->transfer->transfer_id : 0),
            ])
            ->limit(1)
            ->one();
        if ($this->transferApplication) {
            $this->onlyOne = $this->transferApplication->transfer_application_only_one;
            $this->price = $this->transferApplication->transfer_application_price;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['onlyOne'], 'boolean'],
            [['price'], 'integer', 'min' => $this->minPrice, 'max' => $this->maxPrice],
            [['onlyOne', 'price'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'price' => 'Ваше предложение',
            'onlyOne' => 'В случае победы удалить все остальные мои заявки',
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function execute()
    {
        if (!$this->validate()) {
            return false;
        }

        $transfer = Transfer::find()
            ->where(['transfer_player_id' => $this->player->player_id, 'transfer_ready' => 0])
            ->limit(1)
            ->one();
        if (!$transfer) {
            return false;
        }

        if ($transfer->transfer_team_seller_id == $this->team->team_id) {
            Yii::$app->session->setFlash('error', 'Нельзя покупать игрока у своей команды.');
            return false;
        }

        if ($transfer->transfer_user_seller_id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Нельзя покупать игрока у своей команды.');
            return false;
        }

        $check = TransferApplication::find()
            ->where(['transfer_application_transfer_id' => $transfer->transfer_id, 'transfer_application_user_id' => Yii::$app->user->id])
            ->andFilterWhere(['!=', 'transfer_application_id', ($this->transferApplication ? $this->transferApplication->transfer_application_id : null)])
            ->count();
        if ($check) {
            Yii::$app->session->setFlash('error', 'Вы уже подали заявку на этого игрока от имени другой своей команды.');
            return false;
        }

        /** @var AbstractController $controller */
        $controller = Yii::$app->controller;

        $teamArray = [0];

        $transferArray = Transfer::find()
            ->where(['transfer_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->andWhere(['!=', 'transfer_team_buyer_id', 0])
            ->andWhere(['!=', 'transfer_team_seller_id', 0])
            ->andWhere([
                'or',
                ['transfer_team_buyer_id' => $transfer->transfer_team_seller_id],
                ['transfer_team_seller_id' => $transfer->transfer_team_seller_id]
            ])
            ->all();

        foreach ($transferArray as $item) {
            if (!in_array($item->transfer_team_buyer_id, [0, $transfer->transfer_team_seller_id])) {
                $teamArray[] = $item->transfer_team_buyer_id;
            }

            if (!in_array($item->transfer_team_seller_id, [0, $transfer->transfer_team_seller_id])) {
                $teamArray[] = $item->transfer_team_seller_id;
            }
        }

        $loanArray = Loan::find()
            ->where(['loan_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'loan_ready', 0])
            ->andWhere(['!=', 'loan_team_buyer_id', 0])
            ->andWhere(['!=', 'loan_team_seller_id', 0])
            ->andWhere([
                'or',
                ['loan_team_buyer_id' => $transfer->transfer_team_seller_id],
                ['loan_team_seller_id' => $transfer->transfer_team_seller_id]
            ])
            ->all();

        foreach ($loanArray as $item) {
            if (!in_array($item->loan_team_buyer_id, [0, $transfer->transfer_team_seller_id])) {
                $teamArray[] = $item->loan_team_buyer_id;
            }

            if (!in_array($item->loan_team_seller_id, [0, $transfer->transfer_team_seller_id])) {
                $teamArray[] = $item->loan_team_seller_id;
            }
        }

        if (in_array($this->team->team_id, $teamArray)) {
            Yii::$app->session->setFlash('error', 'Ваши команды уже заключали сделку в текущем сезоне.');
            return false;
        }

        $userArray = [0];

        $transferArray = Transfer::find()
            ->where(['transfer_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->andWhere(['!=', 'transfer_user_buyer_id', 0])
            ->andWhere(['!=', 'transfer_user_seller_id', 0])
            ->andWhere([
                'or',
                ['transfer_user_buyer_id' => $transfer->transfer_user_seller_id],
                ['transfer_user_seller_id' => $transfer->transfer_user_seller_id]
            ])
            ->all();

        foreach ($transferArray as $item) {
            if (!in_array($item->transfer_user_buyer_id, array(0, $transfer->transfer_user_seller_id))) {
                $userArray[] = $item->transfer_user_buyer_id;
            }

            if (!in_array($item->transfer_user_seller_id, array(0, $transfer->transfer_user_seller_id))) {
                $userArray[] = $item->transfer_user_seller_id;
            }
        }

        $loanArray = Loan::find()
            ->where(['loan_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'loan_ready', 0])
            ->andWhere(['!=', 'loan_user_buyer_id', 0])
            ->andWhere(['!=', 'loan_user_seller_id', 0])
            ->andWhere([
                'or',
                ['loan_user_buyer_id' => $transfer->transfer_user_seller_id],
                ['loan_user_seller_id' => $transfer->transfer_user_seller_id]
            ])
            ->all();

        foreach ($loanArray as $item) {
            if (!in_array($item->loan_user_buyer_id, array(0, $transfer->transfer_user_seller_id))) {
                $userArray[] = $item->loan_user_buyer_id;
            }

            if (!in_array($item->loan_user_seller_id, array(0, $transfer->transfer_user_seller_id))) {
                $userArray[] = $item->loan_user_seller_id;
            }
        }

        if (in_array(Yii::$app->user->id, $userArray)) {
            Yii::$app->session->setFlash(
                'error',
                'Вы уже заключали сделку с этим менеджером в текущем сезоне.'
            );
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = $this->transferApplication;
            if (!$model) {
                $model = new TransferApplication();
                $model->transfer_application_team_id = $this->team->team_id;
                $model->transfer_application_transfer_id = $transfer->transfer_id;
                $model->transfer_application_user_id = Yii::$app->user->id;
            }
            $model->transfer_application_only_one = $this->onlyOne;
            $model->transfer_application_price = $this->price;
            $model->save();

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Заявка успешно сохранена.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
