<?php

use yii\db\Migration;

/**
 * Class m190414_084352_bot
 */
class m190414_084352_bot extends Migration
{
    const TABLE = '{{%bot}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'bot_id' => $this->primaryKey(),
            'bot_date' => $this->integer()->defaultValue(0),
            'bot_user_id' => $this->integer()->defaultValue(0),
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
