<?php

use yii\db\Migration;

/**
 * Class m180621_180700_rating_type
 */
class m180621_180700_rating_type extends Migration
{
    const TABLE = '{{%rating_type}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'rating_type_id' => $this->primaryKey(2),
            'rating_type_name' => $this->string(255),
            'rating_type_order' => $this->string(255),
            'rating_type_rating_chapter_id' => $this->integer(1)->defaultValue(0),
        ]);

        $this->createIndex('rating_type_rating_chapter_id', self::TABLE, 'rating_type_rating_chapter_id');

        $this->batchInsert(self::TABLE, ['rating_type_name', 'rating_type_order', 'rating_type_rating_chapter_id'], [
            ['Сила состава', 'rating_team_power_vs_place', 1],
            ['Средний возраст', 'rating_team_age_place', 1],
            ['Стадионы', 'rating_team_stadium_place', 1],
            ['Посещаемость', 'rating_team_visitor_place', 1],
            ['Базы и строения', 'rating_team_base_place', 1],
            ['Стоимость баз', 'rating_team_price_base_place', 1],
            ['Стоимость стадионов', 'rating_team_price_stadium_place', 1],
            ['Игроки', 'rating_team_player_place', 1],
            ['Общая стоимость', 'rating_team_price_total_place', 1],
            ['Рейтинг', 'rating_user_rating_place', 2],
            ['Стадионы', 'rating_country_stadium_place', 3],
            ['Автосоставы', 'rating_country_auto_place', 3],
            ['Лига Чемпионов', 'rating_country_league_place', 3],
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
