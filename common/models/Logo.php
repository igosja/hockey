<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class Logo
 * @package common\models
 *
 * @property int $logo_id
 * @property int $logo_date
 * @property int $logo_team_id
 * @property int $logo_text
 * @property int $logo_user_id
 *
 * @property Team $team
 */
class Logo extends AbstractActiveRecord
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

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->logo_date = HockeyHelper::unixTimeStamp();
                $this->logo_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'logo_team_id']);
    }
}
