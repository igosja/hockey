<?php

namespace console\models\generator;

use common\models\User;

/**
 * Class UserHolidayEnd
 * @package console\models\generator
 */
class UserHolidayEnd
{
    /**
     * @return void
     */
    public function execute(): void
    {
        User::updateAllCounters(['user_holiday_day' => 1], ['user_holiday' => 1]);
        User::updateAll(
            ['user_holiday' => 0],
            [
                'and',
                ['user_holiday' => 1],
                ['>=', 'user_holiday_day', User::MAX_HOLIDAY],
                ['<', 'user_date_vip', time()],
            ]
        );
        User::updateAll(
            ['user_holiday' => 0],
            [
                'and',
                ['user_holiday' => 1],
                ['>=', 'user_holiday_day', User::MAX_VIP_HOLIDAY],
                ['>=', 'user_date_vip', time()],
            ]
        );
        User::updateAll(['user_holiday_day' => 0], ['user_holiday' => 0]);
    }
}
