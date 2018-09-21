<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\LoanApplication;
use common\models\Player;
use common\models\Team;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class LoanApplicationFrom
 * @package frontend\models
 *
 * @property bool $off
 * @property Player $player
 * @property Team $team
 */
class LoanApplicationFrom extends Model
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

        if (!$this->player->loan) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            LoanApplication::deleteAll([
                'loan_application_loan_id' => $this->player->loan->loan_id,
                'loan_application_team_id' => $this->team->team_id,
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
