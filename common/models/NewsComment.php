<?php

namespace common\models;

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class NewsComment
 * @package common\models
 *
 * @property int $news_comment_id
 * @property int $news_comment_check
 * @property int $news_comment_date
 * @property int $news_comment_news_id
 * @property string $news_comment_text
 * @property int $news_comment_user_id
 *
 * @property News $news
 * @property User $user
 */
class NewsComment extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_comment}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'news_comment_id',
                    'news_comment_check',
                    'news_comment_date',
                    'news_comment_news_id',
                    'news_comment_user_id',
                ],
                'integer'
            ],
            [['news_comment_news_id', 'news_comment_text'], 'required'],
            [['news_comment_text'], 'safe'],
            [['news_comment_text'], 'trim'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'news_comment_text' => 'Комментарий',
        ];
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
            $this->news_comment_date = time();
            $this->news_comment_user_id = Yii::$app->user->id;
        }
        $this->news_comment_text = HockeyHelper::clearBbCodeBeforeSave($this->news_comment_text);
        return true;
    }

    /**
     * @return bool
     */
    public function addComment()
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
        if ($user->user_date_block_comment_news >= time()) {
            return false;
        }
        if ($user->user_date_block_comment >= time()) {
            return false;
        }
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        try {
            if (!$this->save()) {
                return false;
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
            return false;
        }

        return true;
    }

    /**
     * @return ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['news_id' => 'news_comment_news_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'news_comment_user_id'])->cache();
    }
}
