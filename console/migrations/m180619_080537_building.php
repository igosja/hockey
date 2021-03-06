<?php

use yii\db\Migration;

/**
 * Class m180619_080537_building
 */
class m180619_080537_building extends Migration
{
    const TABLE = '{{%building}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'building_id' => $this->primaryKey(),
            'building_name' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['building_name'], [
            ['base'],
            ['base_medical'],
            ['base_physical'],
            ['base_school'],
            ['base_scout'],
            ['base_training'],
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
