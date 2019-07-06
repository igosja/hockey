<?php

use yii\db\Migration;

/**
 * Class m190706_074120_bot
 */
class m190706_074120_bot extends Migration
{
    const TABLE = '{{%bot}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->dropTable(self::TABLE);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->createTable(self::TABLE, [
            'bot_id' => $this->primaryKey(),
            'bot_date' => $this->integer()->defaultValue(0),
            'bot_user_id' => $this->integer()->defaultValue(0),
        ]);
    }
}
