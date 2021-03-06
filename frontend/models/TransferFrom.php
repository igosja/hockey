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
 * @property bool $off
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
            ->where(['transfer_application_transfer_id' => (isset($this->player->transfer->transfer_id) ? $this->player->transfer->transfer_id : 0)])
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
    public function execute()
    {
        if (!$this->validate()) {
            return false;
        }

        $transfer = Transfer::find()
            ->where(['transfer_player_id' => $this->player->player_id, 'transfer_ready' => 0])
            ->one();
        if (!$transfer) {
            return false;
        }

        if ($this->team->team_finance < 0) {
            Yii::$app->session->setFlash(
                'error',
                'Нельзя снимать игроков с трансферного рынка, если в команде отрицательный баланс.'
            );
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $transfer->delete();
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Игрок успешно снят с трансфера.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
