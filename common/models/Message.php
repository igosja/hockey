<?php

namespace common\models;

use common\components\HockeyHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class Message
 * @package common\models
 *
 * @property int $message_id
 * @property int $message_date
 * @property int $message_read
 * @property string $message_text
 * @property int $message_user_id_from
 * @property int $message_user_id_to
 *
 * @property User $userFrom
 * @property User $userTo
 */
class Message extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'message_id',
                    'message_date',
                    'message_read',
                    'message_user_id_from',
                    'message_user_id_to',
                ],
                'integer'
            ],
            [['message_text', 'message_user_id_to'], 'required'],
            [['message_text'], 'safe'],
            [['message_text'], 'trim'],
        ];
    }

    /**
     * @param int $userId
     * @return bool
     * @throws Exception
     */
    public function addMessage(int $userId): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        if (!$user->user_date_confirm) {
            return false;
        }

        $inBlacklistOwner = Blacklist::find()
            ->where(['blacklist_owner_user_id' => $user->user_id, 'blacklist_interlocutor_user_id' => $userId])
            ->count();
        if ($inBlacklistOwner) {
            return false;
        }

        $inBlacklistInterlocutor = Blacklist::find()
            ->where(['blacklist_owner_user_id' => $userId, 'blacklist_interlocutor_user_id' => $user->user_id])
            ->count();
        if ($inBlacklistInterlocutor) {
            return false;
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->message_user_id_from = Yii::$app->user->id;
        $this->message_user_id_to = $userId;

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
            $this->message_date = time();
        }
        $this->message_text = HockeyHelper::clearBbCodeBeforeSave($this->message_text);
        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getUserFrom(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'message_user_id_from']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserTo(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'message_user_id_to']);
    }
}
