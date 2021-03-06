<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ElectionNationalPlayer
 * @package common\models
 *
 * @property int $election_national_player_id
 * @property int $election_national_player_application_id
 * @property int $election_national_player_player_id
 *
 * @property Player $player
 */
class ElectionNationalPlayer extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'election_national_player_id',
                    'election_national_player_application_id',
                    'election_national_player_player_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'election_national_player_player_id'])->cache();
    }
}
