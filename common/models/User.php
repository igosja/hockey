<?php

namespace common\models;

use common\components\ErrorHelper;
use common\components\FormatHelper;
use Exception;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
 * @property int $user_ip
 * @property int $user_language_id
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
 * @property string $user_timezone
 * @property int $user_user_role_id
 *
 * @property Country $country
 * @property Country $president
 * @property Country $presidentVice
 * @property BlockReason $reasonBlock
 * @property BlockReason $reasonBlockComment
 * @property BlockReason $reasonBlockCommentDeal
 * @property BlockReason $reasonBlockCommentGame
 * @property BlockReason $reasonBlockCommentNews
 * @property BlockReason $reasonBlockForum
 * @property User $referrer
 * @property Sex $sex
 * @property Team[] $team
 */
class User extends AbstractActiveRecord implements IdentityInterface
{
    const ADMIN_USER_ID = 1;
    const MAX_HOLIDAY = 30;
    const MAX_VIP_HOLIDAY = 60;

    public $time;

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
            [['user_email'], 'email'],
            [
                [
                    'time',
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
                    'user_finance',
                    'user_holiday',
                    'user_holiday_day',
                    'user_language_id',
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
            [['user_money', 'user_rating'], 'number'],
            [['user_email'], 'required'],
            [
                [
                    'user_city',
                    'user_email',
                    'user_ip',
                    'user_login',
                    'user_name',
                    'user_password',
                    'user_surname',
                    'user_timezone',
                ],
                'string',
                'max' => 255
            ],
            [['user_code'], 'string', 'length' => 32],
            [['user_email'], 'unique'],
            [
                [
                    'user_birth_day',
                    'user_birth_month',
                    'user_birth_year',
                    'user_country_id',
                    'user_sex_id',
                ],
                'filter',
                'filter' => function ($value) {
                    if (!$value) {
                        $value = 0;
                    }
                    return $value;
                }
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_city' => 'Город',
            'user_country_id' => 'Страна',
            'user_email' => 'Email',
            'user_id' => 'Id',
            'user_login' => 'Логин',
            'user_name' => 'Имя',
            'user_surname' => 'Фамилия',
            'user_sex_id' => 'Пол',
            'user_timezone' => 'Часовой пояс',
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
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->user_code;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->user_password);
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword($password)
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
    public function generateUserCode()
    {
        $code = md5(uniqid(rand(), 1));
        if (!self::find()->where(['user_code' => $code])->exists()) {
            $this->user_code = $code;
        } else {
            $this->generateUserCode();
        }
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
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
    public function iconVip()
    {
        $result = '';
        if ($this->isVip()) {
            $result = ' <i aria-hidden="true" class="fa fa-star font-yellow" title="VIP"></i>';
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isVip()
    {
        return $this->user_date_vip > time();
    }

    /**
     * @return string
     */
    public function fullName()
    {
        $result = 'Новый менеджер';
        if ($this->user_name || $this->user_surname) {
            $result = $this->user_name . ' ' . $this->user_surname;
        }
        return $result;
    }

    /**
     * @return string
     */
    public function lastVisit()
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
            $date = $difference . ' минут назад';
        } elseif (0 == $date) {
            $date = '-';
        } else {
            $date = FormatHelper::asDateTime($date);
        }

        return $date;
    }

    /**
     * @return string
     */
    public function birthDay()
    {
        if ($this->user_birth_day && $this->user_birth_day && $this->user_birth_year) {
            $result = $this->user_birth_day . '.' . $this->user_birth_month . '.' . $this->user_birth_year;
        } else {
            $result = 'Не указан';
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function canDialog()
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

    /**
     * @return bool
     * @throws Exception
     */
    public function updateQuestionnaire()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }
        if (!$this->save(true, [
            'user_birth_day',
            'user_birth_month',
            'user_birth_year',
            'user_city',
            'user_country_id',
            'user_name',
            'user_sex_id',
            'user_surname',
            'user_timezone',
        ])) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function updateHoliday()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }
        if (!$this->save(true, ['user_holiday'])) {
            return false;
        }
        return true;
    }

    /**
     * @param array $options
     * @return string
     */
    public function userLink(array $options = [])
    {
        if (isset($options['color']) && UserRole::ADMIN == $this->user_user_role_id && $options['color']) {
            unset($options['color']);
            $options = ArrayHelper::merge($options, ['class' => 'red']);
        }

        return Html::a(
            $this->user_login,
            ['user/view', 'id' => $this->user_id],
            $options
        );
    }

    /**
     * @return string
     */
    public function userFrom()
    {
        if (!$this->country) {
            $countryName = '';
        } else {
            $countryName = $this->country->country_name;
        }

        if ($this->user_city && $countryName) {
            $result = $this->user_city . ', ' . $countryName;
        } elseif ($this->user_city) {
            $result = $this->user_city;
        } elseif ($countryName) {
            $result = $countryName;
        } else {
            $result = 'Не указано';
        }

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'user_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPresident()
    {
        return $this->hasOne(Country::class, ['country_president_id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPresidentVice()
    {
        return $this->hasOne(Country::class, ['country_president_vice_id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReasonBlock()
    {
        return $this->hasOne(BlockReason::class, ['block_reason_id' => 'user_block_block_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReasonBlockComment()
    {
        return $this->hasOne(BlockReason::class, ['block_reason_id' => 'user_block_comment_block_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReasonBlockCommentDeal()
    {
        return $this->hasOne(BlockReason::class, ['block_reason_id' => 'user_block_comment_deal_block_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReasonBlockCommentGame()
    {
        return $this->hasOne(BlockReason::class, ['block_reason_id' => 'user_block_comment_game_block_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReasonBlockCommentNews()
    {
        return $this->hasOne(BlockReason::class, ['block_reason_id' => 'user_block_comment_news_block_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReasonBlockForum()
    {
        return $this->hasOne(BlockReason::class, ['block_reason_id' => 'user_block_forum_block_reason_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReferrer()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_referrer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSex()
    {
        return $this->hasOne(Sex::class, ['sex_id' => 'user_sex_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasMany(Team::class, ['team_user_id' => 'user_id']);
    }
}
