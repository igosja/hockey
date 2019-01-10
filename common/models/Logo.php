<?php

namespace common\models;

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
 * @property User $user
 */
class Logo extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%logo}}';
    }

    /**
     * @return array
     */
    public function rules()
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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->logo_date = time();
                $this->logo_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $file = Yii::getAlias('@frontend') . '/web/upload/img/team/125/' . $this->team->team_id . '.png';
        if (file_exists($file)) {
            unlink($file);
        }

        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'logo_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'logo_user_id']);
    }
}
