<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class School
 * @package frontend\models
 *
 * @property array $position_id
 * @property array $special_id
 * @property array $style_id
 */
class School extends Model
{
    public $position_id;
    public $special_id;
    public $style_id;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['position_id', 'special_id', 'style_id'], 'integer'],
        ];
    }

    public function redirectUrl()
    {
        return [
            'school/start',
            'position_id' => $this->position_id,
            'special_id' => $this->special_id,
            'style_id' => $this->style_id,
        ];
    }
}
