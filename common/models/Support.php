<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class Support
 * @package common\models
 *
 * @property int $support_id
 * @property int $support_date
 * @property int $support_question
 * @property int $support_read
 * @property string $support_text
 * @property int $support_user_id
 * @property int $support_admin_id
 *
 * @property User $admin
 * @property User $user
 */
class Support extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%support}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'support_id',
                    'support_admin_id',
                    'support_date',
                    'support_question',
                    'support_read',
                    'support_user_id',
                ],
                'integer'
            ],
            [['support_text'], 'required'],
            [['support_text'], 'safe'],
            [['support_text'], 'trim'],
        ];
    }

    /**
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public function addAnswer($userId)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->support_admin_id = Yii::$app->user->id;
        $this->support_question = 0;
        $this->support_user_id = $userId;

        if (!$this->save()) {
            return false;
        }

        return true;
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

        $this->support_user_id = Yii::$app->user->id;

        if (!$this->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->support_date = time();
        }
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::class, ['user_id' => 'support_admin_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'support_user_id']);
    }
}
