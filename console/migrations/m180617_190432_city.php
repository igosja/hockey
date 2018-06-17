<?php

use yii\db\Migration;

/**
 * Class m180617_190432_city
 */
class m180617_190432_city extends Migration
{
    const TABLE = '{{%city}}';

    /**
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'city_id' => $this->primaryKey(11),
            'city_country_id' => $this->integer(11)->defaultValue(0),
            'city_name' => $this->string(255),
        ]);

        $this->createIndex('city_country_id', self::TABLE, 'city_country_id');

        $this->insert(self::TABLE, [
            'city_name' => 'League'
        ]);

        $this->update(self::TABLE, ['city_id' => 0], ['city_id' => 1]);

        Yii::$app->db->createCommand('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT=1')->execute();

    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
