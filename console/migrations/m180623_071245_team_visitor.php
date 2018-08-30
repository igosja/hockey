<?php

use yii\db\Migration;

/**
 * Class m180623_071245_team_visitor
 */
class m180623_071245_team_visitor extends Migration
{
    const TABLE = '{{%team_visitor}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'team_visitor_id' => $this->primaryKey(1),
            'team_visitor_team_id' => $this->integer(11)->defaultValue(0),
            'team_visitor_visitor' => $this->decimal(3, 2)->defaultValue(0),
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
