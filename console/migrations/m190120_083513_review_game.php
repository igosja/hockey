<?php

use yii\db\Migration;

/**
 * Class m190120_083513_review_game
 */
class m190120_083513_review_game extends Migration
{
    const TABLE = '{{%review_game}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'review_game_id' => $this->primaryKey(),
            'review_game_game_id' => $this->integer(11)->defaultValue(0),
            'review_game_review_id' => $this->integer(11)->defaultValue(0),
            'review_game_text' => $this->text(),
        ]);

        $this->createIndex('review_game_review_id', self::TABLE, 'review_game_review_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
