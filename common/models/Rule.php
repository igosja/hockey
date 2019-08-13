<?php

namespace common\models;

use Yii;

/**
 * Class Rule
 * @package common\models
 *
 * @property int $rule_id
 * @property int $rule_date
 * @property int $rule_order
 * @property string $rule_text
 * @property string $rule_title
 */
class Rule extends AbstractActiveRecord
{
    const SEARCH_SYMBOLS = 200;

    /**
     * @return string
     */
    public static function tableName():string
    {
        return '{{%rule}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['rule_id', 'rule_date', 'rule_order'], 'integer'],
            [['rule_title', 'rule_text'], 'required'],
            [['rule_title'], 'string', 'max' => 255],
            [['rule_title', 'rule_text'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $order = self::find()->max('rule_order');
                if (!$order) {
                    $order = 1;
                }
                $order++;
                $this->rule_order = $order;
            }
            $this->rule_date = time();
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'rule_id' => 'Id',
            'rule_order' => 'Порядок',
            'rule_text' => 'Текст',
            'rule_title' => 'Заголовок',
        ];
    }

    /**
     * @return string
     */
    public function formatSearchText(): string
    {
        $text = strip_tags($this->rule_text);
        $startPosition = mb_stripos($text, Yii::$app->request->get('q')) - self::SEARCH_SYMBOLS;
        if ($startPosition < 0) {
            $startPosition = 0;
        }
        $length = mb_strlen(Yii::$app->request->get('q')) + self::SEARCH_SYMBOLS * 2;
        $text = '...' . mb_substr($text, $startPosition, $length) . '...';
        $text = str_ireplace(
            Yii::$app->request->get('q'),
            '<span class="info">' . Yii::$app->request->get('q') . '</span>',
            $text
        );

        return $text;
    }
}
