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
            'rating_type_rating_chapter_id' => $this->integer(1)->defaultValue(0),
        ]);

        $this->batchInsert(self::TABLE, ['rating_type_name', 'rating_type_rating_chapter_id'], [
            ['Сила состава', 1],
            ['Средний возраст', 1],
            ['Стадионы', 1],
            ['Посещаемость', 1],
            ['Базы и строения', 1],
            ['Стоимость баз', 1],
            ['Стоимость стадионов', 1],
            ['Игроки', 1],
            ['Общая стоимость', 1],
            ['Рейтинг', 2],
            ['Стадионы', 3],
            ['Автосоставы', 3],
            ['Лига Чемпионов', 3],
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
