<?php

use yii\db\Migration;

/**
 * Class m180619_093612_construction_type
 */
class m180619_093612_construction_type extends Migration
{
    const TABLE = '{{%construction_type}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'construction_type_id' => $this->primaryKey(),
            'construction_type_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['construction_type_name'], [
            ['construction'],
            ['destruction'],
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
