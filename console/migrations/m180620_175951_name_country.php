<?php

use yii\db\Migration;

/**
 * Class m180620_175951_name_country
 */
class m180620_175951_name_country extends Migration
{
    const TABLE = '{{%name_country}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'name_country_id' => $this->primaryKey(11),
            'name_country_country_id' => $this->integer(3)->defaultValue(0),
            'name_country_name_id' => $this->integer(11)->defaultValue(0),
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
