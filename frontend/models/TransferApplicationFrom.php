<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use common\models\TransferApplication;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class TransferApplicationFrom
 * @package frontend\models
 *
 * @property boolean $off
 * @property Player $player
 * @property Team $team
 */
class TransferApplicationFrom extends Model
{
    public $off;
    public $player;
    public $team;

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

        if (!$this->player->transfer) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            TransferApplication::deleteAll([
                'transfer_application_transfer_id' => $this->player->transfer->transfer_id,
                'transfer_application_team_id' => $this->team->team_id,
            ]);
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Order successfully successfully removed.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
