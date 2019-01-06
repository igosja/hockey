<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Loan;
use common\models\Player;
use common\models\Position;
use common\models\Training;
use common\models\Transfer;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class UserTransferMoney
 * @package frontend\models
 *
 * @property int $available
 * @property string $comment
 * @property int $countryId
 * @property int $sum
 * @property int $teamId
 * @property User $user
 */
class UserTransferMoney extends Model
{
    public $comment;
    public $countryId;
    public $sum;
    public $teamId;
    public $user;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['countryId', 'teamId'], 'integer'],
            [['sum'], 'integer', 'min' => 1, 'max' => $this->user->user_finance],
            [['sum'], 'required'],
            [['comment'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'comment' => 'Комментарий',
            'countryId' => 'Федерация',
            'sum' => 'Сумма',
            'teamId' => 'Команда',
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

        if ($this->player->player_date_no_action > time()) {
            Yii::$app->session->setFlash(
                'error',
                'С игроком нельзя совершать никаких действий до '
                . FormatHelper::asDate($this->player->player_date_no_action)
                . '.'
            );
            return false;
        }

        if ($this->player->player_no_deal) {
            Yii::$app->session->setFlash(
                'error',
                'Игрока нельзя отдать в аренду до конца сезона.'
            );
            return false;
        }

        if ($this->player->player_loan_team_id) {
            Yii::$app->session->setFlash('error', 'Нельзя отдавать в аренду игроков, которые уже находятся в аренде.');
            return false;
        }

        $count = Loan::find()
            ->where(['loan_team_seller_id' => $this->team->team_id, 'loan_ready' => 0])
            ->count();

        if ($count > 5) {
            Yii::$app->session->setFlash(
                'error',
                'Нельзя отдавать в аренду более пяти игроков из одной команды одновременно.'
            );
            return false;
        }

        if (Position::GK == $this->player->player_position_id) {
            $countTeam = Player::find()->where([
                'player_loan_team_id' => 0,
                'player_position_id' => Position::GK,
                'player_team_id' => $this->team->team_id,
            ])->count();

            $countTransfer = Transfer::find()
                ->joinWith(['player'])
                ->where([
                    'player_position_id' => Position::GK,
                    'transfer_team_seller_id' => $this->team->team_id,
                    'transfer_ready' => 0,
                ])
                ->count();

            $countLoan = Loan::find()
                ->joinWith(['player'])
                ->where([
                    'loan_team_seller_id' => $this->team->team_id,
                    'loan_ready' => 0,
                    'player_position_id' => Position::GK,
                ])
                ->count();

            $count = $countTeam - ($countTransfer + $countLoan);

            if ($count < 3) {
                Yii::$app->session->setFlash(
                    'error',
                    'Нельзя отдать в аренду вратаря, если у вас в команде останется менее двух вратарей.'
                );
                return false;
            }
        } else {
            $countTeam = Player::find()
                ->where(['player_loan_team_id' => 0, 'player_team_id' => $this->team->team_id])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->count();

            $countTransfer = Transfer::find()
                ->joinWith(['player'])
                ->where(['transfer_team_seller_id' => $this->team->team_id, 'transfer_ready' => 0])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->count();

            $countLoan = Loan::find()
                ->joinWith(['player'])
                ->where(['loan_team_seller_id' => $this->team->team_id, 'loan_ready' => 0])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->count();

            $count = $countTeam - ($countTransfer + $countLoan);

            if ($count < 20) {
                Yii::$app->session->setFlash(
                    'error',
                    'Нельзя отдать в аренду полевого игрока, если у вас в команде останется менее двадцати полевых игроков.'
                );
                return false;
            }
        }

        if ($this->player->player_age < 19) {
            Yii::$app->session->setFlash('error', 'Нельзя отдать в аренду игроков младше 19 лет.');
            return false;
        }

        if ($this->player->player_age > 38) {
            Yii::$app->session->setFlash('error', 'Нельзя отдать в аренду игроков старше 38 лет.');
            return false;
        }

        $count = Training::find()
            ->where(['training_player_id' => $this->player->player_id, 'training_ready' => 0])
            ->count();

        if ($count) {
            Yii::$app->session->setFlash('error', 'Нельзя отдать в аренду игрока, который находится на тренировке.');
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = new Loan();
            $model->loan_day_max = $this->maxDay;
            $model->loan_day_min = $this->minDay;
            $model->loan_player_id = $this->player->player_id;
            $model->loan_price_seller = $this->price;
            $model->loan_team_seller_id = $this->team->team_id;
            $model->loan_user_seller_id = Yii::$app->user->id;
            $model->save();

            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Игрок успешно выставлен на арендный рынок.');
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}