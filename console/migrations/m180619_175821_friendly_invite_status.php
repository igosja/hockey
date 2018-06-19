<?php

use yii\db\Migration;

/**
 * Class m180619_175821_friendly_invite_status
 */
class m180619_175821_friendly_invite_status extends Migration
{
    const TABLE = '{{%friendly_invite_status}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'friendly_invite_status_id' => $this->primaryKey(1),
            'friendly_invite_status_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['friendly_invite_status_name'], [
            ['New invitation'],
            ['Invitation accepted'],
            ['Invitation declined'],
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
