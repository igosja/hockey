<?php

use yii\db\Migration;

/**
 * Class m180620_131800_language
 */
class m180620_131800_language extends Migration
{
    const TABLE = '{{%language}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'language_id' => $this->primaryKey(11),
            'language_code' => $this->string(2),
            'language_name' => $this->string(255),
        ]);

        $this->insert(self::TABLE, [
            'language_code' => 'ru',
            'language_name' => 'Русский',
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
