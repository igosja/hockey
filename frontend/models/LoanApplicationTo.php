<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\LoanApplication;
use common\models\Player;
use common\models\Team;
use common\models\Transfer;
use Exception;
use frontend\controllers\AbstractController;
use Yii;
use yii\base\Model;

/**
 * Class LoanApplicationTo
 * @package frontend\models
 *
 * @property int $day
 * @property int $maxDay
 * @property int $maxPrice
 * @property int $minDay
 * @property int $minPrice
 * @property bool $onlyOne
 * @property Player $player
 * @property int $price
 * @property Team $team
 * @property LoanApplication $loanApplication
 */
class LoanApplicationTo extends Model
{
    public $day = 0;
    public $onlyOne = false;
    public $price = 0;
    public $maxDay = 0;
    public $maxPrice = 0;
    public $minDay = 0;
    public $minPrice = 0;
    public $player;
    public $team;
    public $loanApplication;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->minPrice = isset($this->player->loan->loan_price_seller) ? $this->player->loan->loan_price_seller : ceil($this->player->player_price / 1000);
        $this->maxPrice = $this->team->team_finance;
        $this->minDay = isset($this->player->loan->loan_day_min) ? $this->player->loan->loan_day_min : 1;
        $this->maxDay = isset($this->player->loan->loan_day_max) ? $this->player->loan->loan_day_max : 7;
        $this->loanApplication = LoanApplication::find()
            ->where([
                'loan_application_team_id' => $this->team->team_id,
                'loan_application_loan_id' => isset($this->player->loan->loan_id) ? $this->player->loan->loan_id : 0,
            ])
            ->limit(1)
            ->one();
        if ($this->loanApplication) {
            $this->day = $this->loanApplication->loan_application_day;
            $this->onlyOne = $this->loanApplication->loan_application_only_one;
            $this->price = $this->loanApplication->loan_application_price;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['day'], 'integer', 'min' => $this->minDay, 'max' => $this->maxDay],
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
            'day' => 'Дней аренды',
            'onlyOne' => 'В случае победы удалить все остальные мои заявки',
            'price' => 'Ваше предложение',
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

        $loan = Loan::find()
            ->where(['loan_player_id' => $this->player->player_id, 'loan_ready' => 0])
            ->one();
        if (!$loan) {
            return false;
        }

        if ($loan->loan_team_seller_id == $this->team->team_id) {
            Yii::$app->session->setFlash('error', 'Нельзя брать в аренду игрока у своей команды.');
            return false;
        }

        if ($loan->loan_user_seller_id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Нельзя брать в аренду игрока у своей команды.');
            return false;
        }

        $check = LoanApplication::find()
            ->where(['loan_application_loan_id' => $loan->loan_id, 'loan_application_user_id' => Yii::$app->user->id])
            ->andFilterWhere(['!=', 'loan_application_id', $this->loanApplication ? $this->loanApplication->loan_application_id : null])
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
                ['transfer_team_buyer_id' => $loan->loan_team_seller_id],
                ['transfer_team_seller_id' => $loan->loan_team_seller_id]
            ])
            ->all();

        foreach ($transferArray as $item) {
            if (!in_array($item->transfer_team_buyer_id, array(0, $loan->loan_team_seller_id))) {
                $teamArray[] = $item->transfer_team_buyer_id;
            }

            if (!in_array($item->transfer_team_seller_id, array(0, $loan->loan_team_seller_id))) {
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
                ['loan_team_buyer_id' => $loan->loan_team_seller_id],
                ['loan_team_seller_id' => $loan->loan_team_seller_id]
            ])
            ->all();

        foreach ($loanArray as $item) {
            if (!in_array($item->loan_team_buyer_id, array(0, $loan->loan_team_seller_id))) {
                $teamArray[] = $item->loan_team_buyer_id;
            }

            if (!in_array($item->loan_team_seller_id, array(0, $loan->loan_team_seller_id))) {
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
                ['transfer_user_buyer_id' => $loan->loan_user_seller_id],
                ['transfer_user_seller_id' => $loan->loan_user_seller_id]
            ])
            ->all();

        foreach ($transferArray as $item) {
            if (!in_array($item->transfer_user_buyer_id, array(0, $loan->loan_user_seller_id))) {
                $userArray[] = $item->transfer_user_buyer_id;
            }

            if (!in_array($item->transfer_user_seller_id, array(0, $loan->loan_user_seller_id))) {
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
                ['loan_user_buyer_id' => $loan->loan_user_seller_id],
                ['loan_user_seller_id' => $loan->loan_user_seller_id]
            ])
            ->all();

        foreach ($loanArray as $item) {
            if (!in_array($item->loan_user_buyer_id, array(0, $loan->loan_user_seller_id))) {
                $userArray[] = $item->loan_user_buyer_id;
            }

            if (!in_array($item->loan_user_seller_id, array(0, $loan->loan_user_seller_id))) {
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
            $model = $this->loanApplication;
            if (!$model) {
                $model = new LoanApplication();
                $model->loan_application_team_id = $this->team->team_id;
                $model->loan_application_loan_id = $loan->loan_id;
                $model->loan_application_user_id = Yii::$app->user->id;
            }
            $model->loan_application_day = $this->day;
            $model->loan_application_only_one = $this->onlyOne;
            $model->loan_application_price = $this->price;
            $model->save();

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Заявка успешно сохранена.');
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
