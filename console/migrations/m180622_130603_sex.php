<?php

use yii\db\Migration;

/**
 * Class m180622_130603_sex
 */
class m180622_130603_sex extends Migration
{
    const TABLE = '{{%sex}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'sex_id' => $this->primaryKey(1),
            'sex_name' => $this->string(10),
        ]);

        $this->batchInsert(self::TABLE, ['sex_name'], [
            ['мужской'],
            ['женский'],
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
