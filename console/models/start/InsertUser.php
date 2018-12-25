<?php

namespace console\models\start;

use common\components\HockeyHelper;
use common\models\User;
use Yii;

/**
 * Class InsertUser
 * @package console\models\start
 */
class InsertUser
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $data = [
            ['23373e3c14aa77368437c7c972601d70', HockeyHelper::unixTimeStamp(), 'igosja1@ukr.net', 'Игося1', '$2y$13$fAFDQp4vXQ5nDGsrHMeSMuyD68yB2gufdXNvMW1PTEwyvD91qNQzi'],
        ];

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                User::tableName(),
                ['user_code', 'user_date_register', 'user_email', 'user_login', 'user_password'],
                $data
            )
            ->execute();
    }
}
