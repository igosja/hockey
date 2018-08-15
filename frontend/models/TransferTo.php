<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\Player;
use common\models\Position;
use common\models\Training;
use common\models\Transfer;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class TransferTo
 * @package frontend\models
 *
 * @property integer $maxPrice
 * @property integer $minPrice
 * @property Player $player
 * @property integer $price
 * @property integer $teamId
 * @property boolean $toLeague
 */
class TransferTo extends Model
{
    public $price;
    public $toLeague;
    private $maxPrice = 0;
    private $minPrice = 0;
    private $player;
    private $teamId;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['toLeague'], 'boolean'],
            [['price'], 'integer', 'min' => $this->minPrice, 'max' => $this->maxPrice],
            [['price', 'toLeague'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'price' => 'Starting price',
            'toLeague' => 'Sell the league',
        ];
    }

    /**
     * @return integer
     */
    public function getMinPrice(): int
    {
        return $this->minPrice;
    }

    /**
     * @param integer $maxPrice
     */
    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;
        $this->minPrice = ceil($player->player_price / 2);
        $this->price = $this->minPrice;
    }

    /**
     * @param integer $teamId
     */
    public function setTeamId(int $teamId)
    {
        $this->teamId = $teamId;
    }

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function execute(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->player->player_national_id) {
            Yii::$app->session->setFlash('error', 'You can not sell the player to the national team.');
            return false;
        }

        if ($this->player->player_no_action > time()) {
            Yii::$app->session->setFlash(
                'error',
                'With the player you can not take any action until '
                . Yii::$app->formatter->asDate($this->player->player_no_action)
                . '.'
            );
            return false;
        }

        if ($this->player->player_no_deal) {
            Yii::$app->session->setFlash(
                'error',
                'The player can not be put on the transfer until the end of the season.'
            );
            return false;
        }

        if ($this->player->player_loan_team_id) {
            Yii::$app->session->setFlash('error', 'You can not put on the transfer players currently rented.');
            return false;
        }

        $count = Transfer::find()->where(['transfer_team_seller_id' => $this->teamId, 'transfer_ready' => 0])->count();

        if ($count > 5) {
            Yii::$app->session->setFlash(
                'error',
                'You can not simultaneously put on the transfer market more than five players.'
            );
            return false;
        }

        if (Position::GK == $this->player->player_position_id) {
            $countTeam = Player::find()->where([
                'player_loan_team_id' => 0,
                'player_position_id' => Position::GK,
                'player_team_id' => $this->teamId,
            ])->count();

            $countTransfer = Transfer::find()
                ->joinWith(['player'])
                ->where([
                    'player_position_id' => Position::GK,
                    'transfer_team_seller_id' => $this->teamId,
                    'transfer_ready' => 0,
                ])
                ->count();

            $countLoan = Loan::find()
                ->joinWith(['player'])
                ->where([
                    'loan_team_seller_id' => $this->teamId,
                    'loan_ready' => 0,
                    'player_position_id' => Position::GK,
                ])
                ->count();

            $count = $countTeam - ($countTransfer + $countLoan);

            if ($count < 3) {
                Yii::$app->session->setFlash(
                    'error',
                    'You can not sell the goalkeeper if you have less than three goalkeepers in the team.'
                );
                return false;
            }
        } else {
            $countTeam = Player::find()
                ->where(['player_loan_team_id' => 0, 'player_team_id' => $this->teamId])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->count();

            $countTransfer = Transfer::find()
                ->joinWith(['player'])
                ->where(['transfer_team_seller_id' => $this->teamId, 'transfer_ready' => 0])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->count();

            $countLoan = Loan::find()
                ->joinWith(['player'])
                ->where(['loan_team_seller_id' => $this->teamId, 'loan_ready' => 0])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->count();

            $count = $countTeam - ($countTransfer + $countLoan);

            if ($count < 20) {
                Yii::$app->session->setFlash(
                    'error',
                    'You can not sell a fielder if you have less than twenty field players left in the team.'
                );
                return false;
            }
        }

        if ($this->player->player_age < 19) {
            Yii::$app->session->setFlash('error', 'You can not sell players under 19 years old.');
            return false;
        }

        if ($this->player->player_age > 38) {
            Yii::$app->session->setFlash('error', 'You can not sell players over 38 years old.');
            return false;
        }

        $count = Training::find()
            ->where(['training_player_id' => $this->player->player_id, 'training_ready' => 0])
            ->count();

        if ($count) {
            Yii::$app->session->setFlash('error', 'You can not sell a player who is in training.');
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = new Transfer();
            $model->transfer_player_id = $this->player->player_id;
            $model->transfer_price_seller = $this->price;
            $model->transfer_team_seller_id = $this->teamId;
            $model->transfer_to_league = $this->toLeague;
            $model->transfer_user_seller_id = Yii::$app->user->id;
            if (!$model->save()) {
                throw new Throwable(ErrorHelper::modelErrorsToString($model));
            }

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'The player has successfully put on the transfer.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
