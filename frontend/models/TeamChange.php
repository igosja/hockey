<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Class TeamChange
 * @package frontend\models
 *
 * @property integer $leaveId
 */
class TeamChange extends Model
{
    public $leaveId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['leaveId'], 'integer'],
        ];
    }
}
