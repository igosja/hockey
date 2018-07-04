<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class TournamentType
 * @package common\models
 *
 * @property integer $tournament_type_id
 * @property integer $tournament_type_day_type_id
 * @property string $tournament_type_name
 * @property integer $tournament_type_visitor
 */
class TournamentType extends ActiveRecord
{
    const NATIONAL = 1;
    const LEAGUE = 2;
    const CHAMPIONSHIP = 3;
    const CONFERENCE = 4;
    const OFF_SEASON = 5;
    const FRIENDLY = 6;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%tournament_type}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['tournament_type_day_type_id'], 'in', 'range' => DayType::find()->select(['day_type_id'])->column()],
            [['tournament_type_id', 'tournament_type_day_type_id'], 'integer'],
            [['tournament_type_visitor'], 'integer', 'min' => 0, 'max' => 200],
            [['tournament_type_day_type_id', 'tournament_type_name', 'tournament_type_visitor'], 'required'],
            [['tournament_type_name'], 'string', 'max' => 20],
            [['tournament_type_name'], 'trim'],
        ];
    }
}
