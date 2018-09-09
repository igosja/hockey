<?php

namespace console\models\generator;

use common\models\Season;
use common\models\Team;
use common\models\UserRating;

/**
 * Class UserToRating
 * @package console\models\generator
 */
class UserToRating
{
    /**
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason();

        $teamArray = Team::find()
            ->where(['!=', 'team_user_id', 0])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $check = UserRating::find()->where([
                'user_rating_user_id' => $team->team_user_id,
                'user_rating_season_id' => 0,
            ])->count();

            if (!$check) {
                $model = new UserRating();
                $model->user_rating_user_id = $team->team_user_id;
                $model->save();
            }

            $check = UserRating::find()->where([
                'user_rating_user_id' => $team->team_user_id,
                'user_rating_season_id' => $seasonId,
            ])->count();

            if (!$check) {
                $model = new UserRating();
                $model->user_rating_user_id = $team->team_user_id;
                $model->user_rating_season_id = $seasonId;
                $model->save();
            }
        }
    }
}