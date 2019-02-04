<?php

use yii\db\Migration;

/**
 * Class m190202_043456_captain
 */
class m190202_043456_captain extends Migration
{
    const TABLE = '{{%lineup}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'lineup_captain', $this->integer(1)->defaultValue(0)->after('lineup_assist'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'lineup_captain');
    }
}
