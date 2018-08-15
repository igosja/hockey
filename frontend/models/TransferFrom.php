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
 * @property integer $teamId
 */
class TransferFrom extends Model
{
    public $off;
    private $player;
    private $teamId;

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
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return TransferApplication[]
     */
    public function getApplication(): array
    {
        $result = TransferApplication::find()
            ->select(['transfer_application_date', 'transfer_application_price', 'transfer_application_team_id'])
            ->where(['transfer_application_transfer_id' => $this->player->transfer->transfer_id])
            ->orderBy(['transfer_application_price' => SORT_DESC, 'transfer_application_date' => SORT_ASC])
            ->all();

        return $result;
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

        $finance = Team::find()->select(['team_finance'])->where(['team_id' => $this->teamId])->limit(1)->scalar();
        if ($finance < 0) {
            Yii::$app->session->setFlash('error',
                'You can not remove players from the transfer market, if the team has a negative balance.');
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
