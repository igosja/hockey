<?php

namespace common\models;

use common\components\HockeyHelper;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;
use yii\helpers\Html;

/**
 * Class ForumTheme
 * @package common\models
 *
 * @property int $forum_message_id
 * @property int $forum_message_blocked
 * @property int $forum_message_check
 * @property int $forum_message_date
 * @property int $forum_message_date_update
 * @property int $forum_message_forum_theme_id
 * @property string $forum_message_text
 * @property int $forum_message_user_id
 *
 * @property Complaint[] $complaint
 * @property ForumTheme $forumTheme
 * @property User $user
 */
class ForumMessage extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%forum_message}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'forum_message_id',
                    'forum_message_blocked',
                    'forum_message_check',
                    'forum_message_date',
                    'forum_message_date_update',
                    'forum_message_forum_theme_id',
                    'forum_message_user_id',
                ],
                'integer'
            ],
            [['forum_message_text'], 'required'],
            [['forum_message_text'], 'safe'],
            [['forum_message_text'], 'trim'],
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
                $this->forum_message_date = time();
                $this->forum_message_user_id = Yii::$app->user->id;
            }
            if ($this->isAttributeChanged('forum_message_text')) {
                $this->forum_message_check = 0;
            }
            $this->forum_message_text = HockeyHelper::clearBbCodeBeforeSave($this->forum_message_text);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete()
    {
        foreach ($this->complaint as $complaint) {
            $complaint->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function addMessage()
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
        if ($user->user_date_block_forum >= time()) {
            return false;
        }
        if ($user->user_date_block_comment >= time()) {
            return false;
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->forum_message_forum_theme_id = Yii::$app->request->get('id');
        if (!$this->save()) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function links()
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        if (!$user) {
            return '';
        }

        $isUser = (UserRole::USER == $user->user_user_role_id);
        $linkArray = [
            Html::a(
                '<i class="fa fa-quote-right" aria-hidden="true"></i>',
                'javascript:',
                ['class' => 'forum-quote', 'data' => ['text' => $this->forum_message_text], 'title' => 'Цитировать']
            ),
        ];

        if (($user->user_id == $this->forum_message_user_id && !$this->forum_message_blocked) || !$isUser) {
            $linkArray[] = Html::a(
                '<i class="fa fa-pencil" aria-hidden="true"></i>',
                ['forum/message-update', 'id' => $this->forum_message_id],
                ['title' => 'Редактировать']
            );
        }

        if ($user->user_id == $this->forum_message_user_id || !$isUser) {
            $linkArray[] = Html::a(
                '<i class="fa fa-trash-o" aria-hidden="true"></i>',
                ['forum/message-delete', 'id' => $this->forum_message_id],
                ['title' => 'Удалить']
            );
        }

        if (!$this->complaint) {
            $linkArray[] = Html::a(
                '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
                ['forum/message-complaint', 'id' => $this->forum_message_id],
                ['title' => 'Пожаловаться']
            );
        }

        if (!$isUser) {
            $linkArray[] = Html::a(
                '<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>',
                ['forum/message-move', 'id' => $this->forum_message_id],
                ['title' => 'Переместить']
            );

            if (!$this->forum_message_blocked) {
                $text = 'Блокировать';
                $icon = 'lock';
            } else {
                $text = 'Разблокировать';
                $icon = 'unlock';
            }
            $linkArray[] = Html::a(
                '<i class="fa fa-' . $icon . '" aria-hidden="true"></i>',
                ['forum/message-block', 'id' => $this->forum_message_id],
                ['title' => $text]
            );
        }

        $result = implode(' ', $linkArray);

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getComplaint()
    {
        return $this->hasMany(Complaint::class, ['complaint_forum_message_id' => 'forum_message_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getForumTheme()
    {
        return $this->hasOne(ForumTheme::class, ['forum_theme_id' => 'forum_message_forum_theme_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'forum_message_user_id']);
    }
}
