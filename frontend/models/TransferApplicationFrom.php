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
 * @property bool $off
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
    public function rules()
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

        if (!$this->player->transfer) {
            return false;
        }

        $transferApplication = TransferApplication::find()
            ->where([
                'transfer_application_transfer_id' => $this->player->transfer->transfer_id,
                'transfer_application_team_id' => $this->team->team_id,
            ])
            ->limit(1)
            ->one();
        if (!$transferApplication) {
            Yii::$app->session->setFlash('error', 'Заявка выбрана неправильно.');
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $transferApplication->delete();
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Заявка успешно удалена.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
