<?php

use yii\db\Migration;

/**
 * Class m180622_142260_special
 */
class m180622_142260_special extends Migration
{
    const TABLE = '{{%special}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'special_id' => $this->primaryKey(2),
            'special_field' => $this->integer(1)->defaultValue(0),
            'special_gk' => $this->integer(1)->defaultValue(0),
            'special_name' => $this->string(2),
            'special_text' => $this->string(255),
        ]);

        $this->batchInsert(self::TABLE, ['special_field', 'special_gk', 'special_name', 'special_text'], [
            [1, 0, 'Ск', 'Скорость'],
            [1, 0, 'Сб', 'Силовая борьба'],
            [1, 0, 'Т', 'Техника'],
            [1, 1, 'Л', 'Лидер'],
            [1, 1, 'Ат', 'Атлетизм'],
            [0, 1, 'Р', 'Реакция'],
            [1, 0, 'От', 'Отбор'],
            [1, 0, 'Бр', 'Бросок'],
            [1, 1, 'К', 'Кумир'],
            [0, 1, 'Кл', 'Игра клюшкой'],
            [0, 1, 'П', 'Выбор позиции'],
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
