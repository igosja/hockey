<?php

use yii\db\Migration;

/**
 * Class m180617_191409_team
 */
class m180617_191409_team extends Migration
{
    const TABLE = '{{%team}}';

    /**
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'team_id' => $this->primaryKey(11),
            'team_age' => $this->decimal(5, 3),
            'team_auto' => $this->integer(1)->defaultValue(0),
            'team_base_id' => $this->integer(2)->defaultValue(0),
            'team_base_medical_id' => $this->integer(2)->defaultValue(0),
            'team_base_physical_id' => $this->integer(2)->defaultValue(0),
            'team_base_school_id' => $this->integer(2)->defaultValue(0),
            'team_base_scout_id' => $this->integer(2)->defaultValue(0),
            'team_base_training_id' => $this->integer(2)->defaultValue(0),
            'team_finance' => $this->integer(2)->defaultValue(0),
            'team_friendly_status_id' => $this->integer(1)->defaultValue(0),
            'team_free_base' => $this->integer(1)->defaultValue(0),
            'team_mood_rest' => $this->integer(1)->defaultValue(0),
            'team_mood_super' => $this->integer(1)->defaultValue(0),
            'team_name' => $this->string(255),
            'team_player' => $this->integer(3)->defaultValue(0),
            'team_power_c_16' => $this->integer(5)->defaultValue(0),
            'team_power_c_21' => $this->integer(5)->defaultValue(0),
            'team_power_c_27' => $this->integer(5)->defaultValue(0),
            'team_power_s_16' => $this->integer(5)->defaultValue(0),
            'team_power_s_21' => $this->integer(5)->defaultValue(0),
            'team_power_s_27' => $this->integer(5)->defaultValue(0),
            'team_power_v' => $this->integer(5)->defaultValue(0),
            'team_power_vs' => $this->integer(5)->defaultValue(0),
            'team_price_base' => $this->integer(11)->defaultValue(0),
            'team_price_player' => $this->integer(11)->defaultValue(0),
            'team_price_stadium' => $this->integer(11)->defaultValue(0),
            'team_price_total' => $this->integer(11)->defaultValue(0),
            'team_salary' => $this->integer(7)->defaultValue(0),
            'team_stadium_id' => $this->integer(11)->defaultValue(0),
            'team_user_id' => $this->integer(11)->defaultValue(0),
            'team_vice_id' => $this->integer(11)->defaultValue(0),
            'team_visitor' => $this->integer(3)->defaultValue(0),
            'team_vote_national' => $this->integer(1)->defaultValue(0),
            'team_vote_president' => $this->integer(1)->defaultValue(0),
            'team_vote_u19' => $this->integer(1)->defaultValue(0),
            'team_vote_u21' => $this->integer(1)->defaultValue(0),
        ]);

        $this->insert(self::TABLE, [
            'team_name' => 'Free team',
        ]);

        $this->update(self::TABLE, ['team_id' => 0], ['team_id' => 1]);

        Yii::$app->db->createCommand('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT=1')->execute();
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
