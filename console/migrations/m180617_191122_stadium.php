<?php

use yii\db\Migration;

/**
 * Class m180617_191122_stadium
 */
class m180617_191122_stadium extends Migration
{
    const TABLE = '{{%stadium}}';

    /**
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'stadium_id' => $this->primaryKey(11),
            'stadium_capacity' => $this->integer(5)->defaultValue(0),
            'stadium_city_id' => $this->integer(11)->defaultValue(0),
            'stadium_date' => $this->integer(11)->defaultValue(0),
            'stadium_maintenance' => $this->integer(11)->defaultValue(0),
            'stadium_name' => $this->string(255),
        ]);

        $this->insert(self::TABLE, [
            'stadium_name' => 'League'
        ]);

        $this->update(self::TABLE, ['stadium_id' => 0], ['stadium_id' => 1]);

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
