<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Logo
 * @package common\models
 *
 * @property int $logo_id
 * @property int $logo_date
 * @property int $logo_team_id
 * @property int $logo_text
 * @property int $logo_user_id
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
            [['logo_id', 'logo_date', 'logo_team_id', 'logo_user_id'], 'integer'],
            [['logo_text'], 'required'],
            [['logo_text'], 'string', 'max' => 255],
            [['logo_text'], 'trim'],
        ];
    }
}
