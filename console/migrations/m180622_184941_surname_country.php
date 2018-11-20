<?php

use yii\db\Migration;

/**
 * Class m180622_184941_surname_country
 */
class m180622_184941_surname_country extends Migration
{
    const TABLE = '{{%surname_country}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'surname_country_country_id' => $this->integer(3)->defaultValue(0),
            'surname_country_surname_id' => $this->integer(11)->defaultValue(0),
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
