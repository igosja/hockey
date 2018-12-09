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
 * @property User $user
 */
class NewsComment extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%news_comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
    public function attributeLabels(): array
    {
        return [
            'news_comment_text' => 'Комментарий',
        ];
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
            $this->news_comment_date = HockeyHelper::unixTimeStamp();
            $this->news_comment_user_id = Yii::$app->user->id;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function addComment(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        if ($user->user_date_block_comment_news >= time()) {
            return false;
        }
        if ($user->user_date_block_comment >= time()) {
            return false;
        }
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $this->news_comment_news_id = Yii::$app->request->get('id');
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
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'news_comment_user_id'])->cache();
    }
}
