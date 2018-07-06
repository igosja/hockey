<?php

use yii\db\Migration;

/**
 * Class m180623_071658_tournament_type
 */
class m180623_071658_tournament_type extends Migration
{
    const TABLE = '{{%tournament_type}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'tournament_type_id' => $this->primaryKey(1),
            'tournament_type_day_type_id' => $this->integer(1)->defaultValue(0),
            'tournament_type_name' => $this->string(20),
            'tournament_type_visitor' => $this->integer(3)->defaultValue(0),
        ]);

        $this->batchInsert(
            self::TABLE,
            ['tournament_type_day_type_id', 'tournament_type_name', 'tournament_type_visitor'],
            [
                [3, 'World Championship', 200],
                [3, 'Champions League', 150],
                [2, 'Championship', 100],
                [2, 'Conference', 90],
                [2, 'Off-season Cup', 90],
                [1, 'Friendly match', 80],
            ]
        );
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
