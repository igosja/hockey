<?php

namespace common\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package common\models
 *
 * @property integer $user_id
 * @property integer $user_birth_day
 * @property integer $user_birth_month
 * @property integer $user_birth_year
 * @property integer $user_block_block_reason_id
 * @property integer $user_block_comment_block_reason_id
 * @property integer $user_block_comment_deal_block_reason_id
 * @property integer $user_block_comment_game_block_reason_id
 * @property integer $user_block_comment_news_block_reason_id
 * @property integer $user_block_forum_block_reason_id
 * @property string $user_city
 * @property string $user_code
 * @property integer $user_country_id
 * @property integer $user_country_news_id
 * @property integer $user_date_block
 * @property integer $user_date_block_comment
 * @property integer $user_date_block_comment_deal
 * @property integer $user_date_block_comment_game
 * @property integer $user_date_block_comment_news
 * @property integer $user_date_block_forum
 * @property integer $user_date_confirm
 * @property integer $user_date_login
 * @property integer $user_date_register
 * @property integer $user_date_vip
 * @property string $user_email
 * @property integer $user_finance
 * @property integer $user_holiday
 * @property integer $user_holiday_day
 * @property string $user_login
 * @property float $user_money
 * @property string $user_name
 * @property integer $user_news_id
 * @property string $user_password
 * @property float $user_rating
 * @property integer $user_referrer_done
 * @property integer $user_referrer_id
 * @property integer $user_sex_id
 * @property integer $user_shop_point
 * @property integer $user_shop_position
 * @property integer $user_shop_special
 * @property string $user_surname
 * @property integer $user_user_role_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    const PASSWORD_SALT = 'hockey';

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [['user_email'], 'email'],
                [
                    'user_id',
                    'user_birth_day',
                    'user_birth_month',
                    'user_birth_year',
                    'user_block_block_reason_id',
                    'user_block_comment_block_reason_id',
                    'user_block_comment_deal_block_reason_id',
                    'user_block_comment_game_block_reason_id',
                    'user_block_comment_news_block_reason_id',
                    'user_block_forum_block_reason_id',
                    'user_country_id',
                    'user_country_news_id',
                    'user_date_block',
                    'user_date_block_comment',
                    'user_date_block_comment_deal',
                    'user_date_block_comment_game',
                    'user_date_block_comment_news',
                    'user_date_block_forum',
                    'user_date_confirm',
                    'user_date_login',
                    'user_date_register',
                    'user_date_vip',
                    'user_email',
                    'user_finance',
                    'user_holiday',
                    'user_holiday_day',
                    'user_login',
                    'user_money',
                    'user_name',
                    'user_news_id',
                    'user_referrer_done',
                    'user_referrer_id',
                    'user_sex_id',
                    'user_shop_point',
                    'user_shop_position',
                    'user_shop_special',
                    'user_user_role_id',
                ],
                'integer'
            ],
            [['user_rating'], 'number'],
            [['user_email'], 'required'],
            [['user_city', 'user_name', 'user_surname'], 'string', 'max' => 255],
            [['user_code', 'user_password'], 'string'],
            [['user_email'], 'unique'],
        ];
    }

    /**
     * @param int|string $id
     * @return User|null|IdentityInterface
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->user_code;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return $this->hashPassword($password) === $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $this->hashPassword($password);
    }

    /**
     * @param $password
     * @return string
     */
    public function hashPassword($password): string
    {
        return md5($password . md5(self::PASSWORD_SALT));
    }

    public function generateUserCode()
    {
        $code = md5(uniqid(rand(), 1));
        if (!self::find()->where(['user_code' => $code])->exists()) {
            $this->user_code = $code;
        }
        $this->generateUserCode();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateUserCode();
                $this->user_date_register = time();
            }
            return true;
        }
        return false;
    }
}
