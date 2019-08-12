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
 * @property User $user
 */
class Logo extends AbstractActiveRecord
{
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
                $this->logo_date = time();
                $this->logo_user_id = Yii::$app->user->id;
            }
            $this->logo_text = HockeyHelper::clearBbCodeBeforeSave($this->logo_text);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function beforeDelete(): bool
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
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'logo_team_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'logo_user_id'])->cache();
    }
}
