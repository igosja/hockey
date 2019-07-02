<?php

use common\models\FinanceText;
use yii\db\Migration;

/**
 * Class m190701_173645_finance_deal_check
 */
class m190701_173645_finance_deal_check extends Migration
{
    const TABLE = '{{%finance}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'finance_loan_id', $this->integer(11)->defaultValue(0)->after('finance_level'));
        $this->addColumn(self::TABLE, 'finance_transfer_id', $this->integer(11)->defaultValue(0)->after('finance_team_id'));
        $this->update('{{%finance_text}}', ['finance_text_text' => 'Вознаграждение за проверку сделки'], ['finance_text_id' => FinanceText::INCOME_DEAL_CHECK]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'finance_loan_id');
        $this->dropColumn(self::TABLE, 'finance_transfer_id');
    }
}
