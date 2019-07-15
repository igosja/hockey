<?php

use yii\db\Migration;

/**
 * Class m190714_135924_social
 */
class m190714_135924_social extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_social_facebook_id', $this->string(255)->after('user_shop_special'));
        $this->addColumn(self::TABLE, 'user_social_google_id', $this->string(255)->after('user_social_facebook_id'));
        $this->addColumn(self::TABLE, 'user_social_vk_id', $this->string(255)->after('user_social_google_id'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_social_facebook_id');
        $this->dropColumn(self::TABLE, 'user_social_google_id');
        $this->dropColumn(self::TABLE, 'user_social_vk_id');
    }
}
