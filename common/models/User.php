<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package common\models
 *
 * @property int $user_id
 * @property int $user_birth_day
 * @property int $user_birth_month
 * @property int $user_birth_year
 * @property int $user_block_block_reason_id
 * @property int $user_block_comment_block_reason_id
 * @property int $user_block_comment_deal_block_reason_id
 * @property int $user_block_comment_game_block_reason_id
 * @property int $user_block_comment_news_block_reason_id
 * @property int $user_block_forum_block_reason_id
 * @property string $user_city
 * @property string $user_code
 * @property int $user_country_id
 * @property int $user_country_news_id
 * @property int $user_date_block
 * @property int $user_date_block_comment
 * @property int $user_date_block_comment_deal
 * @property int $user_date_block_comment_game
 * @property int $user_date_block_comment_news
 * @property int $user_date_block_forum
 * @property int $user_date_confirm
 * @property int $user_date_login
 * @property int $user_date_register
 * @property int $user_date_vip
 * @property string $user_email
 * @property int $user_finance
 * @property int $user_holiday
 * @property int $user_holiday_day
 * @property string $user_login
 * @property float $user_money
 * @property string $user_name
 * @property int $user_news_id
 * @property string $user_password
 * @property float $user_rating
 * @property int $user_referrer_done
 * @property int $user_referrer_id
 * @property int $user_sex_id
 * @property int $user_shop_point
 * @property int $user_shop_position
 * @property int $user_shop_special
 * @property string $user_surname
 * @property int $user_user_role_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    const PASSWORD_SALT = 'hockey';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
            [['user_city', 'user_name', 'user_password', 'user_surname'], 'string', 'max' => 255],
            [['user_code'], 'string', 'length' => 32],
            [['user_email'], 'unique'],
        ];
    }

    /**
     * @param int|string $id
     * @return null|IdentityInterface|static
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
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($this->user_password, $password);
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        try {
            $this->user_password = Yii::$app->getSecurity()->generatePasswordHash($password);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }

    /**
     * @return void
     */
    public function generateUserCode(): void
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

    /**
     * @return string
     */
    public function iconVip(): string
    {
        $result = '';
        if ($this->user_date_vip > time()) {
            $result = ' <i aria-hidden="true" class="fa fa-star" title="VIP"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        $result = 'New Manager';
        if ($this->user_name || $this->user_surname) {
            $result = $this->user_name . ' ' . $this->user_surname;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function lastVisit(): string
    {
        $date = $this->user_date_login;
        $min_5 = $date + 5 * 60;
        $min_60 = $date + 60 * 60;
        $now = time();

        if ($min_5 >= $now) {
            $date = '<span class="red">online</span>';
        } elseif ($min_60 >= $now) {
            $difference = $now - $date;
            $difference = $difference / 60;
            $difference = round($difference, 0);
            $date = $difference . ' min ago';
        } elseif (0 == $date) {
            $date = '-';
        } else {
            try {
                $date = Yii::$app->formatter->asDatetime($date);
            } catch (Exception $e) {
                ErrorHelper::log($e);
                $date = '-';
            }
        }

        return $date;
    }

    /**
     * @return bool
     */
    public function canDialog(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (!$this->user_id) {
            return false;
        }
        if ($this->user_id == Yii::$app->user->id) {
            return false;
        }
        return true;
    }
}
