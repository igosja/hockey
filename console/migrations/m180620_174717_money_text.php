<?php

use yii\db\Migration;

/**
 * Class m180620_174717_money_text
 */
class m180620_174717_money_text extends Migration
{
    const TABLE = '{{%money_text}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'money_text_id' => $this->primaryKey(2),
            'money_text_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['money_text_text'], [
            ['Пополнение счёта'],
            ['Бонус партнёрской программе'],
            ['Покупка балла силы'],
            ['Пополнение счёта своей команды'],
            ['Покупка совмещения'],
            ['Покупка спецвозможности'],
            ['Продление VIP-клуба'],
            ['Перевод средств от другого менеджера'],
            ['Перевод средств другому менеджеру'],
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
