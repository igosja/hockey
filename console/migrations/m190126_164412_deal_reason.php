<?php

use yii\db\Migration;

/**
 * Class m190126_164412_deal_reason
 */
class m190126_164412_deal_reason extends Migration
{
    const TABLE = '{{%deal_reason}}';
    const TABLE_LOAN = '{{%loan_application}}';
    const TABLE_TRANSFER = '{{%transfer_application}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'deal_reason_id' => $this->primaryKey(2),
            'deal_reason_text' => $this->string()
        ]);

        $this->batchInsert(self::TABLE, ['deal_reason_text'], [
            ['Лимит на одину сделку между менеджерами за сезон'],
            ['Лимит на одину сделку между командами за сезон'],
            ['У команды не хватило денег'],
            ['Не лучшая заявка'],
        ]);

        $this->addColumn(self::TABLE_LOAN, 'loan_application_deal_reason_id', $this->integer(2)->defaultValue(0)->after('loan_application_day'));
        $this->addColumn(self::TABLE_TRANSFER, 'transfer_application_deal_reason_id', $this->integer(2)->defaultValue(0)->after('transfer_application_date'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);

        $this->dropColumn(self::TABLE_LOAN, 'loan_application_deal_reason_id');
        $this->dropColumn(self::TABLE_TRANSFER, 'transfer_application_deal_reason_id');
    }
}