<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Recommendation
 * @package common\models
 *
 * @property int $recommendation_id
 * @property int $recommendation_team_id
 * @property int $recommendation_user_id
 *
 * @property User $user
 */
class Recommendation extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'recommendation_id',
                    'recommendation_team_id',
                    'recommendation_user_id',
                ],
                'integer'
            ],
            [['recommendation_user_id'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'recommendation_user_id' => 'Менеджер',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'recommendation_user_id'])->cache();
    }
}
