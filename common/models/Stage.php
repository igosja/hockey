<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Stage
 * @package common\models
 *
 * @property integer $stage_id
 * @property string $stage_name
 * @property integer $stage_visitor
 */
class Stage extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%stage}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['stage_id'], 'integer'],
            [['stage_visitor'], 'integer', 'min' => 0, 'max' => 200],
            [['stage_name', 'stage_visitor'], 'required'],
            [['stage_name'], 'string', 'max' => 10],
            [['stage_name'], 'trim'],
        ];
    }
}
