<?php

namespace console\models;

use common\components\ErrorHelper;
use common\models\BaseSchool;
use common\models\Building;
use common\models\BuildingBase;
use common\models\ConstructionType;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Game;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;
use common\models\School;
use common\models\Season;
use common\models\Site;
use common\models\Style;
use common\models\Team;
use Exception;
use Yii;

/**
 * Class BotService
 * @package console\models\generator
 */
class BotService
{
    const COUNT_LINEUP = 22;
    const SCHOOL_LEVEL = 1;

    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!Site::status()) {
            return;
        }
        $this->lineup();
        $this->buildSchool();
        $this->startSchool();
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function lineup(): bool
    {
        $team = Team::find()
            ->where(['team_user_id' => 0])
            ->andWhere(['!=', 'team_id', 0])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$team) {
            return true;
        }

        $game = Game::find()
            ->joinWith(['schedule'], false)
            ->where([
                'or',
                ['game_guest_team_id' => $team->team_id],
                ['game_home_team_id' => $team->team_id],
            ])
            ->andWhere(['game_played' => 0])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(1)
            ->one();
        if (!$game) {
            return true;
        }

        $countLineup = Lineup::find()
            ->where([
                'lineup_team_id' => $team->team_id,
                'lineup_game_id' => $game->game_id,
            ])
            ->count();

        if ($game->game_home_team_id == $team->team_id && self::COUNT_LINEUP == $countLineup) {
            return true;
        }

        if ($game->game_guest_team_id == $team->team_id && self::COUNT_LINEUP == $countLineup) {
            return true;
        }

        Lineup::deleteAll(['lineup_game_id' => $game->game_id, 'lineup_team_id' => $team->team_id]);

        $playerArray = Player::find()
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->orderBy(['player_tire' => SORT_ASC])
            ->all();

        for ($j = 0; $j < Lineup::GAME_QUANTITY; $j++) {
            if (in_array($j, [0])) {
                $lineId = 0;
            } elseif (in_array($j, [1, 2, 3, 4, 5, 6])) {
                $lineId = 1;
            } elseif (in_array($j, [7, 8, 9, 10, 11])) {
                $lineId = 2;
            } elseif (in_array($j, [12, 13, 14, 15, 16])) {
                $lineId = 3;
            } else {
                $lineId = 4;
            }

            if (in_array($j, [0, 1])) {
                $positionId = Position::GK;
            } elseif (in_array($j, [2, 7, 12, 17])) {
                $positionId = Position::LD;
            } elseif (in_array($j, [3, 8, 13, 18])) {
                $positionId = Position::RD;
            } elseif (in_array($j, [4, 9, 14, 19])) {
                $positionId = Position::LW;
            } elseif (in_array($j, [5, 10, 15, 20])) {
                $positionId = Position::CF;
            } else {
                $positionId = Position::RW;
            }

            $player = null;
            foreach ($playerArray as $key => $playerItem) {
                if (!$player && $playerItem->player_position_id == $positionId) {
                    $player = $playerItem;
                    unset($playerArray[$key]);
                }
            }

            if (!$player) {
                continue;
            }

            $lineup = new Lineup();
            $lineup->lineup_line_id = $lineId;
            $lineup->lineup_position_id = $positionId;
            $lineup->lineup_team_id = $team->team_id;
            $lineup->lineup_game_id = $game->game_id;
            $lineup->lineup_player_id = $player->player_id;
            $lineup->save(false, [
                'lineup_line_id',
                'lineup_position_id',
                'lineup_team_id',
                'lineup_game_id',
                'lineup_player_id',
            ]);
        }

        return true;
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    private function buildSchool(): bool
    {
        $team = Team::find()
            ->where(['team_user_id' => 0, 'team_base_school_id' => 0])
            ->andWhere(['!=', 'team_id', 0])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$team) {
            return true;
        }

        if ($team->buildingBase) {
            return true;
        }

        if ($team->isSchool()) {
            return true;
        }

        if ($team->base->base_slot_max <= $team->baseUsed()) {
            return true;
        }

        $baseSchool = BaseSchool::find()
            ->where(['base_school_level' => self::SCHOOL_LEVEL])
            ->limit(1)
            ->one();

        if (!$baseSchool) {
            return true;
        }

        if ($baseSchool->base_school_base_level > $team->base->base_level) {
            return true;
        }

        if ($baseSchool->base_school_price_buy > $team->team_finance) {
            return true;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new BuildingBase();
            $model->building_base_building_id = Building::SCHOOL;
            $model->building_base_construction_type_id = ConstructionType::BUILD;
            $model->building_base_day = $baseSchool->base_school_build_speed;
            $model->building_base_team_id = $team->team_id;
            $model->save();

            Finance::log([
                'finance_building_id' => Building::SCHOOL,
                'finance_finance_text_id' => FinanceText::OUTCOME_BUILDING_BASE,
                'finance_level' => self::SCHOOL_LEVEL,
                'finance_team_id' => $team->team_id,
                'finance_value' => -$baseSchool->base_school_price_buy,
                'finance_value_after' => $team->team_finance - $baseSchool->base_school_price_buy,
                'finance_value_before' => $team->team_finance,
            ]);

            $team->team_finance = $team->team_finance - $baseSchool->base_school_price_buy;
            $team->save(true, ['team_finance']);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);
        }

        return true;
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function startSchool(): bool
    {
        $team = Team::find()
            ->where(['team_user_id' => 0])
            ->andWhere(['!=', 'team_id', 0])
            ->andWhere(['!=', 'team_base_school_id', 0])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        if (!$team) {
            return true;
        }

        if ($team->buildingBase) {
            return true;
        }

        if (!$team->availableSchool()) {
            return true;
        }

        $school = School::find()
            ->where(['school_ready' => 0, 'school_team_id' => $team->team_id])
            ->count();
        if ($school) {
            return true;
        }

        for ($position= Position::GK; $position<=Position::RW; $position++) {
            $minCount = 5;
            if (Position::GK == $position) {
                $minCount = 2;
            }

            $countPlayer = Player::find()
                ->where(['player_team_id' => $team->team_id, 'player_position_id' => $position])
                ->count();
            if ($minCount > $countPlayer) {
                $style = Style::find()
                    ->andWhere(['!=', 'style_id', Style::NORMAL])
                    ->orderBy('RAND()')
                    ->limit(1)
                    ->one();

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new School();
                    $model->school_day = $team->baseSchool->base_school_school_speed;
                    $model->school_position_id = $position;
                    $model->school_season_id = Season::getCurrentSeason();
                    $model->school_special_id = null;
                    $model->school_style_id = $style->style_id;
                    $model->school_team_id = $team->team_id;
                    $model->school_with_special = 0;
                    $model->school_with_special_request = 0;
                    $model->school_with_style = 0;
                    $model->school_with_style_request = 0;
                    $model->save();

                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }

                return true;
            }
        }

        return true;
    }
}