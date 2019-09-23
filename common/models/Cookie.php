<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Cookie
 * @package common\models
 *
 * @property int $cookie_id
 * @property int $cookie_count
 * @property int $cookie_date
 * @property int $cookie_user_1_id
 * @property int $cookie_user_2_id
 *
 * @property User $userOne
 * @property User $userTwo
 */
class Cookie extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'cookie_id',
                    'cookie_count',
                    'cookie_date',
                    'cookie_user_1_id',
                    'cookie_user_2_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @param int $id
     * @param array $userArray
     * @return array
     */
    public static function getDuplicatedUsers(int $id, array $userArray = [])
    {
        $cookieArray = self::find()
            ->where(['cookie_user_1_id' => $id])
            ->orWhere(['cookie_user_2_id' => $id])
            ->all();
        foreach ($cookieArray as $cookie) {
            if (!in_array($cookie->cookie_user_1_id, $userArray)) {
                $userArray[] = $cookie->cookie_user_1_id;
                $userArray = self::getDuplicatedUsers($cookie->cookie_user_1_id, $userArray);
            }
            if (!in_array($cookie->cookie_user_2_id, $userArray)) {
                $userArray[] = $cookie->cookie_user_2_id;
                $userArray = self::getDuplicatedUsers($cookie->cookie_user_2_id, $userArray);
            }
        }
        return $userArray;
    }

    /**
     * @return ActiveQuery
     */
    public function getUserOne(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'cookie_user_1_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUserTwo(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'cookie_user_2_id'])->cache();
    }
}
