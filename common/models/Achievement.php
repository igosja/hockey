<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Achievement
 * @package common\models
 *
 * @property int $achievement_id
 * @property int $achievement_country_id
 * @property int $achievement_division_id
 * @property int $achievement_is_playoff
 * @property int $achievement_national_id
 * @property int $achievement_place
 * @property int $achievement_season_id
 * @property int $achievement_stage_id
 * @property int $achievement_team_id
 * @property int $achievement_tournament_type_id
 * @property int $achievement_user_id
 *
 * @property Country $country
 * @property Division $division
 * @property National $national
 * @property Stage $stage
 * @property Team $team
 * @property TournamentType $tournamentType
 */
class Achievement extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%achievement}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'achievement_id',
                    'achievement_country_id',
                    'achievement_division_id',
                    'achievement_is_playoff',
                    'achievement_national_id',
                    'achievement_place',
                    'achievement_season_id',
                    'achievement_stage_id',
                    'achievement_team_id',
                    'achievement_tournament_type_id',
                    'achievement_user_id',
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
        if ($this->achievement_place) {
            $result = $this->achievement_place;
        } elseif ($this->stage) {
            $result = $this->stage->stage_name;
        } else {
            $result = 'Чемпион';
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTournament(): string
    {
        $result = $this->tournamentType->tournament_type_name;

        if (TournamentType::CHAMPIONSHIP == $this->achievement_tournament_type_id) {
            if (0 != $this->achievement_place) {
                $result = $result . ', регулярный сезон';
            } else {
                $result = $result . ', плейофф';
            }
        }

        if ($this->achievement_country_id || $this->achievement_division_id) {
            $additional = [];

            if ($this->achievement_country_id) {
                $additional[] = $this->country->country_name;
            }

            if ($this->achievement_division_id) {
                $additional[] = $this->division->division_name;
            }

            $result = $result . ' (' . implode(', ', $additional) . ')';
        }

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'achievement_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDivision(): ActiveQuery
    {
        return $this->hasOne(Division::class, ['division_id' => 'achievement_division_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'achievement_national_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStage(): ActiveQuery
    {
        return $this->hasOne(Stage::class, ['stage_id' => 'achievement_stage_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'achievement_team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTournamentType(): ActiveQuery
    {
        return $this->hasOne(TournamentType::class, ['tournament_type_id' => 'achievement_tournament_type_id']);
    }
}
