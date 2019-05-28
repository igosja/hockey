<?php

use yii\db\Migration;

/**
 * Class m190528_172617_team_rating_finance
 */
class m190528_172617_team_rating_finance extends Migration
{
    const TABLE = '{{%rating_team}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'rating_team_finance_place', $this->integer(11)->defaultValue(0)->after('rating_team_base_place_country'));
        $this->addColumn(self::TABLE, 'rating_team_finance_place_country', $this->integer(11)->defaultValue(0)->after('rating_team_finance_place'));
        $this->addColumn(self::TABLE, 'rating_team_salary_place', $this->integer(11)->defaultValue(0)->after('rating_team_price_total_place_country'));
        $this->addColumn(self::TABLE, 'rating_team_salary_place_country', $this->integer(11)->defaultValue(0)->after('rating_team_salary_place'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'rating_team_finance_place');
        $this->dropColumn(self::TABLE, 'rating_team_finance_place_country');
        $this->dropColumn(self::TABLE, 'rating_team_salary_place');
        $this->dropColumn(self::TABLE, 'rating_team_salary_place_country');
    }
}
