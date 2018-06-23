<?php

use yii\db\Migration;

/**
 * Class m180623_184402_money_text
 */
class m180623_184402_money_text extends Migration
{
    const TABLE = '{{%money_text}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'money_text_id' => $this->primaryKey(2),
            'money_text_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['money_text_name'], [
            ['Пополнение счёта'],
            ['Бонус партнёрской программе'],
            ['Покупка балла силы'],
            ['Пополнение счёта своей команды'],
            ['Покупка совмещения'],
            ['Покупка спецвозможности'],
            ['Продление VIP-клуба'],
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
