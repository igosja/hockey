<?php

namespace common\models;

use common\components\HockeyHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class Support
 * @package common\models
 *
 * @property int $support_id
 * @property int $support_admin_id
 * @property int $support_country_id
 * @property int $support_date
 * @property int $support_inside
 * @property int $support_president_id
 * @property int $support_question
 * @property int $support_read
 * @property string $support_text
 * @property int $support_user_id
 *
 * @property User $admin
 * @property User $president
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
                    'support_country_id',
                    'support_date',
                    'support_inside',
                    'support_president_id',
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
     * @param Support $support
     * @return bool
     * @throws Exception
     */
    public function addAnswer($support)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->support_admin_id = Yii::$app->user->id;
        $this->support_country_id = $support->support_country_id;
        $this->support_president_id = $support->support_president_id;
        $this->support_question = 0;
        $this->support_user_id = $support->support_user_id;
        $this->support_inside = 0;

        if (!$this->save()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     * @throws Exception
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
        $this->support_inside = 0;

        if (!$this->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param Country $country
     * @return bool
     * @throws Exception
     */
    public function addPresidentQuestion(Country $country)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (!in_array(Yii::$app->user->id, [$country->country_president_id, $country->country_president_vice_id])) {
            return false;
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->support_country_id = $country->country_id;
        $this->support_president_id = Yii::$app->user->id;
        $this->support_inside = 0;

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
        $this->support_text = HockeyHelper::clearBbCodeBeforeSave($this->support_text);
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
    public function getPresident()
    {
        return $this->hasOne(User::class, ['user_id' => 'support_president_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'support_user_id']);
    }
}
