<?php

use yii\db\Migration;

/**
 * Class m180619_175830_friendly_status
 */
class m180619_175830_friendly_status extends Migration
{
    const TABLE = '{{%friendly_status}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'friendly_status_id' => $this->primaryKey(1),
            'friendly_status_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['friendly_status_name'], [
            ['Я принимаю любое приглашение'],
            ['Я самостоятельно выбираю соперников для моей команды'],
            ['Я не хочу принимать приглашения'],
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
