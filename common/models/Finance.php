<?php

namespace common\models;

use Exception;
use yii\db\ActiveQuery;

/**
 * Class Finance
 * @package common\models
 *
 * @property int $finance_id
 * @property int $finance_building_id
 * @property int $finance_capacity
 * @property string $finance_comment
 * @property int $finance_country_id
 * @property int $finance_date
 * @property int $finance_finance_text_id
 * @property int $finance_level
 * @property int $finance_loan_id
 * @property int $finance_national_id
 * @property int $finance_player_id
 * @property int $finance_season_id
 * @property int $finance_team_id
 * @property int $finance_transfer_id
 * @property int $finance_user_id
 * @property int $finance_value
 * @property int $finance_value_after
 * @property int $finance_value_before
 *
 * @property Building $building
 * @property FinanceText $financeText
 * @property Player $player
 * @property Team $team
 * @property User $user
 */
class Finance extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'finance_id',
                    'finance_building_id',
                    'finance_capacity',
                    'finance_country_id',
                    'finance_finance_text_id',
                    'finance_date',
                    'finance_level',
                    'finance_loan_id',
                    'finance_national_id',
                    'finance_player_id',
                    'finance_season_id',
                    'finance_team_id',
                    'finance_transfer_id',
                    'finance_user_id',
                    'finance_value',
                    'finance_value_after',
                    'finance_value_before'
                ],
                'integer'
            ],
            [['finance_finance_text_id'], 'required'],
            [['finance_comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if (!$this->finance_season_id) {
                    $this->finance_season_id = Season::getCurrentSeason();
                }
                $this->finance_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function log(array $data): bool
    {
        $finance = new self();
        $finance->setAttributes($data);
        return $finance->save();
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        $text = $this->financeText->finance_text_text;
        if (false !== strpos($text, '{player}')) {
            $text = str_replace(
                '{player}',
                $this->player->playerLink(),
                $text
            );
        }
        if (false !== strpos($text, '{team}')) {
            $text = str_replace(
                '{team}',
                $this->team->teamLink(),
                $text
            );
        }
        if (false !== strpos($text, '{user}')) {
            $text = str_replace(
                '{user}',
                $this->user->userLink(),
                $text
            );
        }
        if (false !== strpos($text, '{building}')) {
            $building = '';
            if (Building::BASE == $this->finance_building_id) {
                $building = 'база';
            } elseif (Building::MEDICAL == $this->finance_building_id) {
                $building = 'медцентр';
            } elseif (Building::PHYSICAL == $this->finance_building_id) {
                $building = 'центр физподготовки';
            } elseif (Building::SCHOOL == $this->finance_building_id) {
                $building = 'спортшкола';
            } elseif (Building::SCOUT == $this->finance_building_id) {
                $building = 'скаут-центр';
            } elseif (Building::TRAINING == $this->finance_building_id) {
                $building = 'тренировочный центр';
            }
            $text = str_replace(
                '{building}',
                $building,
                $text
            );
        }
        $text = str_replace(
            '{capacity}',
            $this->finance_capacity,
            $text
        );
        $text = str_replace(
            '{level}',
            $this->finance_level,
            $text
        );

        if ($this->finance_comment) {
            $text = $text . ' (' . $this->finance_comment . ')';
        }

        return $text;
    }

    /**
     * @return ActiveQuery
     */
    public function getFinanceText(): ActiveQuery
    {
        return $this->hasOne(FinanceText::class, ['finance_text_id' => 'finance_finance_text_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getBuilding(): ActiveQuery
    {
        return $this->hasOne(Building::class, ['building_id' => 'finance_building_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'finance_player_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'finance_team_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'finance_user_id'])->cache();
    }
}
