<?php

use yii\db\Migration;

/**
 * Class m180623_070222_tactic
 */
class m180623_070222_tactic extends Migration
{
    const TABLE = '{{%tactic}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'tactic_id' => $this->primaryKey(1),
            'tactic_name' => $this->string(10),
        ]);

        $this->batchInsert(self::TABLE, ['tactic_name'], [
            ['all in defense'],
            ['defensive'],
            ['normal'],
            ['attacking'],
            ['all in an attack'],
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
