<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class History
 * @package common\models
 *
 * @property integer $history_id
 * @property integer $history_building_id
 * @property integer $history_country_id
 * @property integer $history_date
 * @property integer $history_game_id
 * @property integer $history_history_text_id
 * @property integer $history_national_id
 * @property integer $history_player_id
 * @property integer $history_position_id
 * @property integer $history_season_id
 * @property integer $history_special_id
 * @property integer $history_team_id
 * @property integer $history_team_2_id
 * @property integer $history_user_id
 * @property integer $history_user_2_id
 * @property integer $history_value
 */
class History extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%history}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['history_building_id'], 'in', 'range' => Building::find()->select('building_id')->column()],
            [['history_country_id'], 'in', 'range' => Country::find()->select('country_id')->column()],
            [['history_game_id'], 'in', 'range' => Game::find()->select('game_id')->column()],
            [['history_history_text_id'], 'in', 'range' => HistoryText::find()->select('history_text_id')->column()],
            [['history_national_id'], 'in', 'range' => National::find()->select('national_id')->column()],
            [['history_player_id'], 'in', 'range' => Player::find()->select('player_id')->column()],
            [['history_position_id'], 'in', 'range' => Position::find()->select('position_id')->column()],
            [['history_season_id'], 'in', 'range' => Season::find()->select('season_id')->column()],
            [['history_special_id'], 'in', 'range' => Special::find()->select('special_id')->column()],
            [['history_team_id', 'history_team_2_id'], 'in', 'range' => Team::find()->select('team_id')->column()],
            [['history_user_id', 'history_user_2_id'], 'in', 'range' => User::find()->select('user_id')->column()],
            [['history_id', 'history_date', 'history_value'], 'integer'],
            [['history_history_text_id'], 'required']
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
                $this->history_season_id = Season::find()->max('season_id');
                $this->history_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     */
    public static function log(array $data)
    {
        $history = new self();
        $history->setAttributes($data);
        $history->save();
    }
}
