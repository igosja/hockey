<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AchievementPlayer
 * @package common\models
 *
 * @property int $achievement_player_id
 * @property int $achievement_player_country_id
 * @property int $achievement_player_division_id
 * @property int $achievement_player_is_playoff
 * @property int $achievement_player_national_id
 * @property int $achievement_player_place
 * @property int $achievement_player_player_id
 * @property int $achievement_player_season_id
 * @property int $achievement_player_stage_id
 * @property int $achievement_player_team_id
 * @property int $achievement_player_tournament_type_id
 *
 * @property Stage $stage
 * @property Team $team
 * @property TournamentType $tournamentType
 */
class AchievementPlayer extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%achievement_player}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'achievement_player_id',
                    'achievement_player_country_id',
                    'achievement_player_division_id',
                    'achievement_player_is_playoff',
                    'achievement_player_national_id',
                    'achievement_player_place',
                    'achievement_player_player_id',
                    'achievement_player_season_id',
                    'achievement_player_stage_id',
                    'achievement_player_team_id',
                    'achievement_player_tournament_type_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        if ($this->achievement_player_place) {
            $result = $this->achievement_player_place;
        } elseif ($this->stage) {
            $result = $this->stage->stage_name;
        } else {
            $result = 'Чемпион';
        }

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getStage(): ActiveQuery
    {
        return $this->hasOne(Stage::class, ['stage_id' => 'achievement_player_stage_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'achievement_player_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTournamentType(): ActiveQuery
    {
        return $this->hasOne(TournamentType::class, ['tournament_type_id' => 'achievement_player_tournament_type_id']);
    }
}
