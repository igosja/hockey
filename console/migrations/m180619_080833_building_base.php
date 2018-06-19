<?php

use yii\db\Migration;

/**
 * Class m180619_080833_building_base
 */
class m180619_080833_building_base extends Migration
{
    const TABLE = '{{%building_base}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'building_base_id' => $this->primaryKey(11),
            'building_base_building_id' => $this->integer(11)->defaultValue(0),
            'building_base_construction_type_id' => $this->integer(1)->defaultValue(0),
            'building_base_day' => $this->integer(2)->defaultValue(0),
            'building_base_ready' => $this->integer(11)->defaultValue(0),
            'building_base_team_id' => $this->integer(5)->defaultValue(0),
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
