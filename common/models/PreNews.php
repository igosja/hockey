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

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'pre_news_new' => 'Новое на сайте',
            'pre_news_error' => 'Работа над ошибками',
        ];
    }
}
