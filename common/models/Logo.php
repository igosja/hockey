<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Logo
 * @package common\models
 *
 * @property integer $logo_id
 * @property integer $logo_date
 * @property integer $logo_team_id
 * @property integer $logo_text
 * @property integer $logo_user_id
 */
class Logo extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%logo}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['logo_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [['logo_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['logo_id', 'logo_date'], 'integer'],
            [['logo_text'], 'required'],
            [['logo_text'], 'string', 'max' => 255],
            [['logo_text'], 'trim'],
        ];
    }
}
