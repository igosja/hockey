<?php

namespace common\models;

/**
 * Class PreNews
 * @package common\models
 *
 * @property int $pre_news_id
 * @property string $pre_news_new
 * @property string $pre_news_error
 */
class PreNews extends AbstractActiveRecord
{
    const PAGE_LIMIT = 10;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%pre_news}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['pre_news_id'], 'integer'],
            [['pre_news_new', 'pre_news_error'], 'trim'],
        ];
    }
}
