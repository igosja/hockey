<?php

use yii\db\Migration;

/**
 * Class m180622_142742_stage
 */
class m180622_142742_stage extends Migration
{
    const TABLE = '{{%stage}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'stage_id' => $this->primaryKey(2),
            'stage_name' => $this->string(20),
            'stage_visitor' => $this->integer(3),
        ]);

        $this->batchInsert(self::TABLE, ['stage_name', 'stage_visitor'], [
            ['-', 90],
            ['1st round', 100],
            ['2nd round', 100],
            ['3rd round', 100],
            ['4th round', 100],
            ['5th round', 100],
            ['6th round', 100],
            ['7th round', 100],
            ['8th round', 100],
            ['9th round', 100],
            ['10th round', 100],
            ['11th round', 100],
            ['12th round', 100],
            ['13th round', 100],
            ['14th round', 100],
            ['15th round', 100],
            ['16th round', 100],
            ['17th round', 100],
            ['18th round', 100],
            ['19th round', 100],
            ['20th round', 100],
            ['21th round', 100],
            ['22th round', 100],
            ['23th round', 100],
            ['24th round', 100],
            ['25th round', 100],
            ['26th round', 100],
            ['27th round', 100],
            ['28th round', 100],
            ['29th round', 100],
            ['30th round', 100],
            ['31th round', 100],
            ['32th round', 100],
            ['33th round', 100],
            ['34th round', 100],
            ['35th round', 100],
            ['36th round', 100],
            ['37th round', 100],
            ['38th round', 100],
            ['39th round', 100],
            ['40th round', 100],
            ['41th round', 100],
            ['1st qualifying round', 105],
            ['2nd qualifying round', 105],
            ['3rd qualifying round', 105],
            ['1st round', 120],
            ['2nd round', 120],
            ['3rd round', 120],
            ['4th round', 120],
            ['5th round', 120],
            ['6th round', 120],
            ['Round of 16', 170],
            ['Quarter-finals', 180],
            ['Semi-finals', 190],
            ['Final', 200],
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
