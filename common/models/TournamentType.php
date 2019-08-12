<?php

namespace common\models;

/**
 * Class TournamentType
 * @package common\models
 *
 * @property int $tournament_type_id
 * @property int $tournament_type_day_type_id
 * @property string $tournament_type_name
 * @property int $tournament_type_visitor
 */
class TournamentType extends AbstractActiveRecord
{
    const NATIONAL = 1;
    const LEAGUE = 2;
    const CHAMPIONSHIP = 3;
    const CONFERENCE = 4;
    const OFF_SEASON = 5;
    const FRIENDLY = 6;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['tournament_type_id', 'tournament_type_day_type_id'], 'integer'],
            [['tournament_type_visitor'], 'integer', 'min' => 0, 'max' => 200],
            [['tournament_type_day_type_id', 'tournament_type_name', 'tournament_type_visitor'], 'required'],
            [['tournament_type_name'], 'string', 'max' => 20],
            [['tournament_type_name'], 'trim'],
        ];
    }
}
