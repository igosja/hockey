<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use common\models\Transfer;
use common\models\TransferApplication;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class TransferFrom
 * @package frontend\models
 *
 * @property boolean $off
 * @property Player $player
 * @property Team $team
 * @property TransferApplication[] $transferApplicationArray
 */
class TransferFrom extends Model
{
    public $off;
    public $player;
    public $team;
    public $transferApplicationArray;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->transferApplicationArray = TransferApplication::find()
            ->select(['transfer_application_date', 'transfer_application_price', 'transfer_application_team_id'])
            ->where(['transfer_application_transfer_id' => $this->player->transfer->transfer_id])
            ->orderBy(['transfer_application_price' => SORT_DESC, 'transfer_application_date' => SORT_ASC])
            ->all();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['off'], 'boolean'],
            [['off'], 'required'],
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
            ->select(['transfer_id'])
            ->where(['transfer_player_id' => $this->player->player_id, 'transfer_ready' => 0])
            ->one();
        if (!$transfer) {
            return false;
        }

        if ($this->team->team_finance < 0) {
            Yii::$app->session->setFlash(
                'error',
                'You can not remove players from the transfer market, if the team has a negative balance.'
            );
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            TransferApplication::deleteAll(['transfer_application_transfer_id' => $transfer->transfer_id]);
            $transfer->delete();
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Player successfully removed from the transfer.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
