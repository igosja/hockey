<?php

use yii\db\Migration;

/**
 * Class m180618_144500_attitude
 */
class m180618_144500_attitude extends Migration
{
    const TABLE = '{{%attitude}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'attitude_id' => $this->primaryKey(1),
            'attitude_name' => $this->string(255),
            'attitude_order' => $this->integer(1)->defaultValue(0),
        ]);

        $this->batchInsert(self::TABLE, ['attitude_name', 'attitude_order'], [
            ['Отрицательное', 3],
            ['Нейтральное', 2],
            ['Положительное', 1],
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
