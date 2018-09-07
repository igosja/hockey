<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\LoanApplication;
use common\models\Player;
use common\models\Team;
use Throwable;
use Yii;
use yii\base\Model;

/**
 * Class LoanFrom
 * @package frontend\models
 *
 * @property boolean $off
 * @property Player $player
 * @property Team $team
 * @property LoanApplication[] $loanApplicationArray
 */
class LoanFrom extends Model
{
    public $off;
    public $player;
    public $team;
    public $loanApplicationArray;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->loanApplicationArray = LoanApplication::find()
            ->select([
                'loan_application_date',
                'loan_application_day',
                'loan_application_price',
                'loan_application_team_id',
            ])
            ->where(['loan_application_loan_id' => $this->player->loan->loan_id ?? 0])
            ->orderBy(['loan_application_price' => SORT_DESC, 'loan_application_date' => SORT_ASC])
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

        $loan = Loan::find()
            ->select(['loan_id'])
            ->where(['loan_player_id' => $this->player->player_id, 'loan_ready' => 0])
            ->one();
        if (!$loan) {
            return false;
        }

        if ($this->team->team_finance < 0) {
            Yii::$app->session->setFlash(
                'error',
                'You can not remove players from the loan market, if the team has a negative balance.'
            );
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            LoanApplication::deleteAll(['loan_application_loan_id' => $loan->loan_id]);
            $loan->delete();
            $transaction->commit();

            Yii::$app->session->setFlash('success', 'Player successfully removed from the loan.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}