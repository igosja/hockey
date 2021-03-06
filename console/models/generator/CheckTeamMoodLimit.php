<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Mood;
use common\models\TournamentType;

/**
 * Class CheckTeamMoodLimit
 * @package console\models\generator
 *
 * @property Game $game
 */
class CheckTeamMoodLimit
{
    /**
     * @var Game $game
     */
    private $game;

    /**
     * @throws \Exception
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['schedule', 'teamHome', 'teamGuest', 'nationalHome', 'nationalGuest'])
            ->where(['game_played' => 0])
            ->andWhere(['or', ['!=', 'game_home_mood_id', Mood::NORMAL], ['!=', 'game_guest_mood_id', Mood::NORMAL]])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each(5);
        foreach ($gameArray as $game) {
            $this->game = $game;

            if ($this->isFriendly()) {
                $this->checkFriendly();
                continue;
            }

            if ($this->game->game_home_team_id) {
                $this->checkTeam();
            } else {
                $this->checkNational();
            }
        }
    }

    /**
     * @return bool
     */
    private function isFriendly()
    {
        if (TournamentType::FRIENDLY == $this->game->schedule->schedule_tournament_type_id) {
            return true;
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    private function checkFriendly()
    {
        $this->game->game_home_mood_id = Mood::NORMAL;
        $this->game->game_guest_mood_id = Mood::NORMAL;
        $this->game->save();
    }

    /**
     * @throws \Exception
     */
    private function checkTeam()
    {
        if (Mood::SUPER == $this->game->game_home_mood_id) {
            if ($this->game->teamHome->team_mood_super <= 0) {
                $this->game->game_home_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->teamHome->team_mood_super = $this->game->teamHome->team_mood_super - 1;
                $this->game->teamHome->save();
            }
        } elseif (Mood::REST == $this->game->game_home_mood_id) {
            if ($this->game->teamHome->team_mood_rest <= 0) {
                $this->game->game_home_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->teamHome->team_mood_rest = $this->game->teamHome->team_mood_rest - 1;
                $this->game->teamHome->save();
            }
        }

        if (Mood::SUPER == $this->game->game_guest_mood_id) {
            if ($this->game->teamGuest->team_mood_super <= 0) {
                $this->game->game_guest_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->teamGuest->team_mood_super = $this->game->teamGuest->team_mood_super - 1;
                $this->game->teamGuest->save();
            }
        } elseif (Mood::REST == $this->game->game_guest_mood_id) {
            if ($this->game->teamGuest->team_mood_rest <= 0) {
                $this->game->game_guest_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->teamGuest->team_mood_rest = $this->game->teamGuest->team_mood_rest - 1;
                $this->game->teamGuest->save();
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function checkNational()
    {
        if (Mood::SUPER == $this->game->game_home_mood_id) {
            if ($this->game->nationalHome->national_mood_super <= 0) {
                $this->game->game_home_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->nationalHome->national_mood_super = $this->game->nationalHome->national_mood_super - 1;
                $this->game->nationalHome->save();
            }
        } elseif (Mood::REST == $this->game->game_home_mood_id) {
            if ($this->game->nationalHome->national_mood_rest <= 0) {
                $this->game->game_home_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->nationalHome->national_mood_rest = $this->game->nationalHome->national_mood_rest - 1;
                $this->game->nationalHome->save();
            }
        }

        if (Mood::SUPER == $this->game->game_guest_mood_id) {
            if ($this->game->nationalGuest->national_mood_super <= 0) {
                $this->game->game_guest_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->nationalGuest->national_mood_super = $this->game->nationalGuest->national_mood_super - 1;
                $this->game->nationalGuest->save();
            }
        } elseif (Mood::REST == $this->game->game_guest_mood_id) {
            if ($this->game->nationalGuest->national_mood_rest <= 0) {
                $this->game->game_guest_mood_id = Mood::NORMAL;
                $this->game->save();
            } else {
                $this->game->nationalGuest->national_mood_rest = $this->game->nationalGuest->national_mood_rest - 1;
                $this->game->nationalGuest->save();
            }
        }
    }
}
