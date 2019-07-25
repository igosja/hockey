<?php

use yii\db\Migration;

/**
 * Class m190725_171057_scout_is_school
 */
class m190725_171057_scout_is_school extends Migration
{
    const TABLE = '{{%scout}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'scout_is_school', $this->integer(1)->defaultValue(0)->after('scout_id'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'scout_is_school');
    }
}
