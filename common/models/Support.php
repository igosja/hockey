<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class Support
 * @package common\models
 *
 * @property int $support_id
 * @property int $support_date
 * @property int $support_read
 * @property string $support_text
 * @property int $support_user_id_from
 * @property int $support_user_id_to
 *
 * @property User $userFrom
 */
class Support extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%support}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'support_id',
                    'support_date',
                    'support_read',
                    'support_user_id_from',
                    'support_user_id_to',
                ],
                'integer'
            ],
            [['support_text'], 'required'],
            [['support_text'], 'safe'],
            [['support_text'], 'trim'],
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function addQuestion()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->support_date = HockeyHelper::unixTimeStamp();
            $this->support_user_id_from = Yii::$app->user->id;
        }
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getUserFrom(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'support_user_id_from']);
    }
}
