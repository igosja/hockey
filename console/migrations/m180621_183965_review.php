<?php

use yii\db\Migration;

/**
 * Class m180621_183965_review
 */
class m180621_183965_review extends Migration
{
    const TABLE = '{{%review}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'review_id' => $this->primaryKey(11),
            'review_check' => $this->integer(11)->defaultValue(0),
            'review_country_id' => $this->integer(3)->defaultValue(0),
            'review_date' => $this->integer(11)->defaultValue(0),
            'review_division_id' => $this->integer(1)->defaultValue(0),
            'review_season_id' => $this->integer(3)->defaultValue(0),
            'review_schedule_id' => $this->integer(11)->defaultValue(0),
            'review_stage_id' => $this->integer(2)->defaultValue(0),
            'review_text' => $this->text(),
            'review_title' => $this->string(255),
            'review_user_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('review_country_id', self::TABLE, 'review_country_id');
        $this->createIndex('review_division_id', self::TABLE, 'review_division_id');
        $this->createIndex('review_season_id', self::TABLE, 'review_season_id');
        $this->createIndex('review_schedule_id', self::TABLE, 'review_schedule_id');
        $this->createIndex('review_stage_id', self::TABLE, 'review_stage_id');
        $this->createIndex('review_stage_id', self::TABLE, 'review_stage_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
