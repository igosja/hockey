<?php

namespace common\models;

/**
 * Class TeamVisitor
 * @package common\models
 *
 * @property int $team_visitor_id
 * @property int $team_visitor_team_id
 * @property float $team_visitor_visitor
 */
class TeamVisitor extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['team_visitor_id', 'team_visitor_team_id'], 'integer'],
            [['team_visitor_visitor'], 'number'],
        ];
    }
}
