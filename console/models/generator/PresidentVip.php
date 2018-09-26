<?php

namespace console\models\generator;

use Yii;

/**
 * Class PresidentVip
 * @package console\models\generator
 */
class PresidentVip
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $sql = "UPDATE `user`
                SET `user_date_vip`=UNIX_TIMESTAMP()+2592000
                WHERE `user_id` IN
                (
                    SELECT `user_id`
                    FROM (
                        SELECT `user_id`
                        FROM `country`
                        LEFT JOIN `user`
                        ON `country_president_id`=`user_id`
                        WHERE `user_date_vip`<UNIX_TIMESTAMP()+604800
                        AND `user_id`!=0
                    ) AS `t1`
                )
                OR `user_id` IN
                (
                    SELECT `user_id`
                    FROM (
                        SELECT `user_id`
                        FROM `country`
                        LEFT JOIN `user`
                        ON `country_president_vice_id`=`user_id`
                        WHERE `user_date_vip`<UNIX_TIMESTAMP()+604800
                        AND `user_id`!=0
                    ) AS `t2`
                )";
        Yii::$app->db->createCommand($sql)->execute();
    }
}
