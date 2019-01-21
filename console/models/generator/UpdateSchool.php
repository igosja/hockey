<?php

namespace console\models\generator;

use common\models\History;
use common\models\HistoryText;
use common\models\NameCountry;
use common\models\Player;
use common\models\PlayerSpecial;
use common\models\School;
use common\models\Scout;
use common\models\Season;
use common\models\Style;
use common\models\SurnameCountry;
use yii\db\Expression;

/**
 * Class UpdateSchool
 * @package console\models\generator
 */
class UpdateSchool
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        School::updateAllCounters(['school_day' => -1], ['and', ['>', 'school_day', 0], ['school_ready' => 0]]);

        $seasonId = Season::getCurrentSeason();

        $schoolArray = School::find()
            ->with(['team', 'team.baseSchool', 'team.baseScout', 'team.baseMedical', 'team.stadium.city'])
            ->where(['<=', 'school_day', 0])
            ->andWhere(['school_ready' => 0])
            ->orderBy(['school_id' => SORT_ASC])
            ->each();
        foreach ($schoolArray as $school) {
            /**
             * @var School $school
             */
            $specialId = $school->school_special_id;
            $styleId = $school->school_style_id;
            $withSpecial = $school->school_with_special;
            $withSpecialDb = $school->team->baseSchool->base_school_with_special;
            $withStyle = $school->school_with_style;
            $withStyleDb = $school->team->baseSchool->base_school_with_style;

            if ($withSpecial || $withSpecialDb) {
                if (0 != $school->team->baseSchool->base_school_with_special) {
                    $check = School::find()->where([
                        'school_team_id' => $school->school_team_id,
                        'school_with_special' => 1,
                        'school_season_id' => $seasonId,
                    ])->andWhere(['!=', 'school_ready', 0])->count();

                    if ($check >= $withSpecial) {
                        $specialId = 0;
                        $withSpecialDb = 0;
                    }
                }

                if (0 != $withStyleDb) {
                    $check = School::find()->where([
                        'school_team_id' => $school->school_team_id,
                        'school_with_style' => 1,
                        'school_season_id' => $seasonId,
                    ])->andWhere(['!=', 'school_ready', 0])->count();

                    if ($check >= $withStyle) {
                        $styleId = Style::getRandStyleId();
                        $withStyleDb = 0;
                    }
                }
            } else {
                $specialId = 0;
                $styleId = Style::getRandStyleId();
            }

            $player = new Player();
            $player->player_country_id = $school->team->stadium->city->city_country_id;
            $player->player_name_id = NameCountry::getRandNameId($school->team->stadium->city->city_country_id);
            $player->player_position_id = $school->school_position_id;
            $player->player_power_nominal = $school->team->baseSchool->base_school_power;
            $player->player_style_id = $styleId;
            $player->player_surname_id = SurnameCountry::getRandFreeSurnameId(
                $school->school_team_id,
                $school->team->stadium->city->city_country_id
            );
            $player->player_team_id = $school->school_team_id;
            $player->player_tire = $school->team->baseMedical->base_medical_tire;
            $player->player_training_ability = rand(1, 5);
            $player->save();

            if ($specialId) {
                $playerSpecial = new PlayerSpecial();
                $playerSpecial->player_special_level = 1;
                $playerSpecial->player_special_player_id = $player->player_id;
                $playerSpecial->player_special_special_id = $specialId;
                $playerSpecial->save();
            }

            if ($school->team->baseScout->base_scout_base_level >= 5) {
                for ($i = 0; $i < 2; $i++) {
                    $scout = new Scout();
                    $scout->scout_percent = 100;
                    $scout->scout_player_id = $player->player_id;
                    $scout->scout_ready = new Expression('UNIX_TIMESTAMP()');
                    $scout->scout_style = 1;
                    $scout->scout_team_id = $school->school_team_id;
                    $scout->save();
                }
            }

            History::log([
                'history_history_text_id' => HistoryText::PLAYER_FROM_SCHOOL,
                'history_player_id' => $player->player_id,
                'history_team_id' => $school->school_team_id,
            ]);

            $school->school_ready = new Expression('UNIX_TIMESTAMP()');
            $school->school_season_id = $seasonId;
            $school->school_with_special_request = $school->school_with_special;
            $school->school_with_special = $withSpecialDb;
            $school->school_with_style_request = $school->school_with_style;
            $school->school_with_style = $withStyleDb;
            $school->save();
        }
    }
}