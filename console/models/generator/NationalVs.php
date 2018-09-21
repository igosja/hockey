<?php

namespace console\models\generator;

use common\models\National;
use common\models\Player;
use common\models\Position;

/**
 * Class NationalVs
 * @package console\models\generator
 */
class NationalVs
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $nationalArray = National::find()
            ->where(['!=', 'national_id', 0])
            ->orderBy(['national_id' => SORT_ASC])
            ->each();

        foreach ($nationalArray as $national) {
            /**
             * @var National $national
             */
            $power = Player::find()
                ->where(['player_national_id' => $national->national_id])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->orderBy(['player_power_nominal_s' => SORT_DESC])
                ->limit(15)
                ->sum('player_power_nominal_s');
            $power_s_16 = $power + Player::find()
                    ->where(['player_national_id' => $national->national_id, 'player_position_id' => Position::GK])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(1)
                    ->sum('player_power_nominal_s');
            $power = Player::find()
                ->where(['player_national_id' => $national->national_id])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->orderBy(['player_power_nominal_s' => SORT_DESC])
                ->limit(20)
                ->sum('player_power_nominal_s');
            $power_s_21 = $power + Player::find()
                    ->where(['player_national_id' => $national->national_id, 'player_position_id' => Position::GK])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(1)
                    ->sum('player_power_nominal_s');
            $power = Player::find()
                ->where(['player_national_id' => $national->national_id])
                ->andWhere(['!=', 'player_position_id', Position::GK])
                ->orderBy(['player_power_nominal_s' => SORT_DESC])
                ->limit(25)
                ->sum('player_power_nominal_s');
            $power_s_27 = $power + Player::find()
                    ->where(['player_national_id' => $national->national_id, 'player_position_id' => Position::GK])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(2)
                    ->sum('player_power_nominal_s');
            $power_vs = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

            $national->national_power_vs = $power_vs;
            $national->save();
        }
    }
}