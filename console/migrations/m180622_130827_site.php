<?php

use yii\db\Migration;

/**
 * Class m180622_130827_site
 */
class m180622_130827_site extends Migration
{
    const TABLE = '{{%site}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'site_id' => $this->primaryKey(1),
            'site_date_cron' => $this->integer(11)->defaultValue(0),
            'site_status' => $this->integer(1)->defaultValue(1),
            'site_version_1' => $this->integer(3)->defaultValue(0),
            'site_version_2' => $this->integer(3)->defaultValue(0),
            'site_version_3' => $this->integer(3)->defaultValue(0),
            'site_version_date' => $this->integer(11)->defaultValue(0),
        ]);

        $this->insert(self::TABLE, [
            'site_version_1' => 3,
            'site_version_2' => 0,
            'site_version_date' => time(),
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
