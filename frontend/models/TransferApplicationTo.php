<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\Player;
use common\models\Team;
use common\models\Transfer;
use common\models\TransferApplication;
use frontend\controllers\BaseController;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class TransferApplicationTo
 * @package frontend\models
 *
 * @property int $maxPrice
 * @property int $minPrice
 * @property boolean $onlyOne
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

        $this->minPrice = ceil($this->player->player_price / 2);
        $this->maxPrice = $this->team->team_finance;
        $this->transferApplication = TransferApplication::find()
            ->select(['transfer_application_id', 'transfer_application_price', 'transfer_application_only_one'])
            ->where([
                'transfer_application_team_id' => $this->team->team_id,
                'transfer_application_transfer_id' => $this->player->transfer->transfer_id ?? 0,
            ])
            ->limit(1)
            ->one();
        if ($this->transferApplication) {
            $this->minPrice = $this->transferApplication->transfer_application_price;
            $this->onlyOne = $this->transferApplication->transfer_application_only_one;
            $this->price = $this->transferApplication->transfer_application_price;
        }
    }

    /**
     * @return array
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'price' => 'Your price',
            'onlyOne' => 'In case of victory, delete all my other applications',
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function execute(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $transfer = Transfer::find()
            ->select(['transfer_id', 'transfer_team_seller_id', 'transfer_user_seller_id'])
            ->where(['transfer_player_id' => $this->player->player_id, 'transfer_ready' => 0])
            ->one();
        if (!$transfer) {
            return false;
        }

        if ($transfer->transfer_team_seller_id == $this->team->team_id) {
            Yii::$app->session->setFlash('error', 'You can not buy a player from your team.');
            return false;
        }

        if ($transfer->transfer_user_seller_id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'You can not buy a player from your team.');
            return false;
        }

        /** @var BaseController $controller */
        $controller = Yii::$app->controller;

        $teamArray = [0];

        $transferArray = Transfer::find()
            ->select(['transfer_team_buyer_id', 'transfer_team_seller_id'])
            ->where(['transfer_ready' => 1, 'transfer_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'transfer_team_buyer_id', 0])
            ->andWhere(['!=', 'transfer_team_seller_id', 0])
            ->andWhere([
                'or',
                ['transfer_team_buyer_id' => $this->team->team_id],
                ['transfer_team_seller_id' => $this->team->team_id]
            ])
            ->all();

        foreach ($transferArray as $item) {
            if (!in_array($item->transfer_team_buyer_id, array(0, $transfer->transfer_team_seller_id))) {
                $teamArray[] = $item->transfer_team_buyer_id;
            }

            if (!in_array($item->transfer_team_seller_id, array(0, $transfer->transfer_team_seller_id))) {
                $teamArray[] = $item->transfer_team_seller_id;
            }
        }

        $loanArray = Loan::find()
            ->select(['loan_team_buyer_id', 'loan_team_seller_id'])
            ->where(['loan_ready' => 1, 'loan_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'loan_team_buyer_id', 0])
            ->andWhere(['!=', 'loan_team_seller_id', 0])
            ->andWhere([
                'or',
                ['loan_team_buyer_id' => $this->team->team_id],
                ['loan_team_seller_id' => $this->team->team_id]
            ])
            ->all();

        foreach ($loanArray as $item) {
            if (!in_array($item->loan_team_buyer_id, array(0, $transfer->transfer_team_seller_id))) {
                $teamArray[] = $item->loan_team_buyer_id;
            }

            if (!in_array($item->loan_team_seller_id, array(0, $transfer->transfer_team_seller_id))) {
                $teamArray[] = $item->loan_team_seller_id;
            }
        }

        if (in_array($this->team->team_id, $teamArray)) {
            Yii::$app->session->setFlash('error', 'Your teams have already made a deal this season.');
            return false;
        }

        $userArray = [0];

        $transferArray = Transfer::find()
            ->select(['transfer_user_buyer_id', 'transfer_user_seller_id'])
            ->where(['transfer_ready' => 1, 'transfer_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'transfer_user_buyer_id', 0])
            ->andWhere(['!=', 'transfer_user_seller_id', 0])
            ->andWhere([
                'or',
                ['transfer_user_buyer_id' => Yii::$app->user->id],
                ['transfer_user_seller_id' => Yii::$app->user->id]
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
            ->select(['loan_user_buyer_id', 'loan_user_seller_id'])
            ->where(['loan_ready' => 1, 'loan_season_id' => $controller->seasonId])
            ->andWhere(['!=', 'loan_user_buyer_id', 0])
            ->andWhere(['!=', 'loan_user_seller_id', 0])
            ->andWhere([
                'or',
                ['loan_user_buyer_id' => Yii::$app->user->id],
                ['loan_user_seller_id' => Yii::$app->user->id]
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
                'You have already made a deal with this manager in the current season.'
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
            if (!$model->save()) {
                throw new Throwable(ErrorHelper::modelErrorsToString($model));
            }

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Order successfully saved.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
