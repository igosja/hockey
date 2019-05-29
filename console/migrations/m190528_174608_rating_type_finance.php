<?php

use yii\db\Migration;

/**
 * Class m190528_174608_rating_type_finance
 */
class m190528_174608_rating_type_finance extends Migration
{
    const TABLE = '{{%rating_type}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->batchInsert(self::TABLE, ['rating_type_name', 'rating_type_order', 'rating_type_rating_chapter_id'], [
            ['Зарплата игроков', 'rating_team_salary_place', 1],
            ['Денег в кассе', 'rating_team_finance_place', 1],
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->delete(self::TABLE, ['rating_type_order' => ['rating_team_salary_place', 'rating_team_finance_place']]);
    }
}
