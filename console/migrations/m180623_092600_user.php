<?php

use yii\db\Migration;

/**
 * Class m180623_092600_user
 */
class m180623_092600_user extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'user_id' => $this->primaryKey(11),
            'user_birth_day' => $this->integer(2)->defaultValue(0),
            'user_birth_month' => $this->integer(2)->defaultValue(0),
            'user_birth_year' => $this->integer(4)->defaultValue(0),
            'user_block_block_reason_id' => $this->integer(2)->defaultValue(0),
            'user_block_comment_block_reason_id' => $this->integer(2)->defaultValue(0),
            'user_block_comment_deal_block_reason_id' => $this->integer(2)->defaultValue(0),
            'user_block_comment_game_block_reason_id' => $this->integer(2)->defaultValue(0),
            'user_block_comment_news_block_reason_id' => $this->integer(2)->defaultValue(0),
            'user_block_forum_block_reason_id' => $this->integer(2)->defaultValue(0),
            'user_city' => $this->string(255),
            'user_code' => $this->char(32)->unique(),
            'user_country_id' => $this->integer(3)->defaultValue(0),
            'user_country_news_id' => $this->integer(11)->defaultValue(0),
            'user_date_block' => $this->integer(11)->defaultValue(0),
            'user_date_block_comment' => $this->integer(11)->defaultValue(0),
            'user_date_block_comment_deal' => $this->integer(11)->defaultValue(0),
            'user_date_block_comment_game' => $this->integer(11)->defaultValue(0),
            'user_date_block_comment_news' => $this->integer(11)->defaultValue(0),
            'user_date_block_forum' => $this->integer(11)->defaultValue(0),
            'user_date_confirm' => $this->integer(11)->defaultValue(0),
            'user_date_login' => $this->integer(11)->defaultValue(0),
            'user_date_register' => $this->integer(11)->defaultValue(0),
            'user_date_vip' => $this->integer(11)->defaultValue(0),
            'user_email' => $this->string(255)->unique(),
            'user_finance' => $this->integer(11)->defaultValue(0),
            'user_holiday' => $this->integer(1)->defaultValue(0),
            'user_holiday_day' => $this->integer(2)->defaultValue(0),
            'user_language_id' => $this->integer(3)->defaultValue(1),
            'user_login' => $this->string(255)->unique(),
            'user_money' => $this->decimal(11, 2)->defaultValue(0),
            'user_name' => $this->string(255),
            'user_news_id' => $this->integer(11)->defaultValue(0),
            'user_password' => $this->string(255),
            'user_rating' => $this->decimal(6, 2)->defaultValue(500),
            'user_referrer_done' => $this->integer(1)->defaultValue(0),
            'user_referrer_id' => $this->integer(11)->defaultValue(0),
            'user_sex_id' => $this->integer(1)->defaultValue(1),
            'user_shop_point' => $this->integer(5)->defaultValue(0),
            'user_shop_position' => $this->integer(5)->defaultValue(0),
            'user_shop_special' => $this->integer(5)->defaultValue(0),
            'user_surname' => $this->string(255),
            'user_timezone' => $this->string(255)->defaultValue('UTC'),
            'user_user_role_id' => $this->integer(5)->defaultValue(1),
        ]);

        $this->insert(self::TABLE, [
            'user_code' => '00000000000000000000000000000000',
            'user_date_confirm' => 0,
            'user_date_register' => 1473700000,
            'user_email' => 'info@virtual-hockey.org',
            'user_login' => '?????????????????? ??????????????',
            'user_name' => '??????????????????',
            'user_password' => '0',
            'user_surname' => '??????????????',
            'user_user_role_id' => 1
        ]);

        $this->update(self::TABLE, ['user_id' => 0], ['user_id' => 1]);

        Yii::$app->db->createCommand('ALTER TABLE ' . self::TABLE . ' AUTO_INCREMENT=1')->execute();

        $this->insert(self::TABLE, [
            'user_code' => '13373e3c14aa77368437c7c972601d70',
            'user_date_confirm' => 0,
            'user_date_register' => 1473705854,
            'user_email' => 'igosja@ukr.net',
            'user_login' => 'Igosja',
            'user_password' => '$2y$13$KI4fvLJvQ.OGMXEtnj0T.ugY.1ssWb1QV/3ucbKqegh/gRQxnbMRO',
            'user_user_role_id' => 5,
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
