<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Swiss
 * @package common\models
 *
 * @property int $swiss_id
 * @property int $swiss_guest
 * @property int $swiss_home
 * @property int $swiss_place
 * @property int $swiss_team_id
 *
 * @property Team $team
 */
class Swiss extends AbstractActiveRecord
{
    public $opponent;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['swiss_id', 'swiss_guest', 'swiss_home', 'swiss_place', 'swiss_team_id'], 'integer'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'swiss_team_id'])->cache();
    }
}
