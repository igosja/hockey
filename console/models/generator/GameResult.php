<?php

namespace console\models\generator;

use common\models\Event;
use common\models\EventTextGoal;
use common\models\EventTextPenalty;
use common\models\EventTextShootout;
use common\models\EventType;
use common\models\Game;
use common\models\Lineup;
use common\models\National;
use common\models\PlayerPosition;
use common\models\PlayerSpecial;
use common\models\Position;
use common\models\Special;
use common\models\Stage;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use common\models\Style;
use common\models\Tactic;
use common\models\Team;
use common\models\Teamwork;
use common\models\TournamentType;

/**
 * Class GameResult
 * @package console\models\generator
 *
 * @property Game $game
 * @property array $result
 */
class GameResult
{
    const AUTO_PENALTY = 25;
    const COEFFICIENT_DEFENCE = 1;
    const COEFFICIENT_DEFENCE_GK = 6;
    const COEFFICIENT_FORWARD = 6;
    const COEFFICIENT_GK = 5;
    const COEFFICIENT_RUDENESS = 2;
    const COEFFICIENT_SHOT_1 = 5;
    const COEFFICIENT_SHOT_2 = 2;
    const LIMIT_RUDENESS = 38;
    const MAX_RUDENESS = 40;

    /**
     * @var Game $game
     */
    private $game;

    /**
     * @var array $result
     */
    private $result;

    /**
     * @return void
     */
    public function execute(): void
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['schedule', 'teamHome', 'teamHome.championship', 'nationalHome', 'nationalHome.worldCup'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            $this->game = $game;

            $this->prepareResult();
            $this->countHomeBonus();
            $this->getPlayerInfo();
            $this->countPlayerBonus();
            $this->getTeamwork();
            $this->setTeamwork();
            $this->collision();
            $this->playerOptimalPower();
            $this->playerRealPower();
            $this->teamPower();
            $this->teamPowerForecast();
            $this->optimality();
            $this->shouldWin();

            for ($this->result['minute'] = 0; $this->result['minute'] < 60; $this->result['minute']++) {
                $this->generateMinute();
            }

            $continue = $this->getContinue();

            if ($continue) {
                for ($this->result['minute'] = 60; $this->result['minute'] < 65; $this->result['minute']++) {
                    $this->generateMinute(true);
                }
            }

            $continue = $this->getContinue();

            if ($continue) {
                $this->gameWithBullet();
                $this->generateShootout();
            }

            $this->calculateStatistic();
            $this->toDataBase();
        }
    }

    /**
     * @return void
     */
    private function prepareResult(): void
    {
        $teamArray = $this->prepareTeamArray();

        $this->result = [
            'event' => [],
            'face_off_guest' => 0,
            'face_off_home' => 0,
            'game_info' => [
                'game_id' => $this->game->game_id,
                'guest_national_id' => $this->game->game_guest_national_id,
                'guest_team_id' => $this->game->game_guest_team_id,
                'home_bonus' => 1,
                'home_national_id' => $this->game->game_home_national_id,
                'home_team_id' => $this->game->game_guest_team_id,
                'tournament_type_id' => $this->game->schedule->schedule_tournament_type_id,
            ],
            'guest' => $teamArray,
            'home' => $teamArray,
            'minute' => 0,
            'player' => 0,
            'assist_1' => 0,
            'assist_2' => 0,
            'should_win' => 0,
        ];

        $this->result['guest']['team']['auto'] = $this->game->game_guest_auto;
        $this->result['guest']['team']['mood'] = $this->game->game_guest_mood_id;
        $this->result['guest']['team']['rudeness'][1] = $this->game->game_guest_rudeness_id_1;
        $this->result['guest']['team']['rudeness'][2] = $this->game->game_guest_rudeness_id_2;
        $this->result['guest']['team']['rudeness'][3] = $this->game->game_guest_rudeness_id_3;
        $this->result['guest']['team']['rudeness'][4] = $this->game->game_guest_rudeness_id_4;
        $this->result['guest']['team']['style'][1] = $this->game->game_guest_style_id_1;
        $this->result['guest']['team']['style'][2] = $this->game->game_guest_style_id_2;
        $this->result['guest']['team']['style'][3] = $this->game->game_guest_style_id_3;
        $this->result['guest']['team']['style'][4] = $this->game->game_guest_style_id_4;
        $this->result['guest']['team']['tactic'][1] = $this->game->game_guest_tactic_id_1;
        $this->result['guest']['team']['tactic'][2] = $this->game->game_guest_tactic_id_2;
        $this->result['guest']['team']['tactic'][3] = $this->game->game_guest_tactic_id_3;
        $this->result['guest']['team']['tactic'][4] = $this->game->game_guest_tactic_id_4;
        $this->result['home']['team']['auto'] = $this->game->game_home_auto;
        $this->result['home']['team']['mood'] = $this->game->game_home_mood_id;
        $this->result['home']['team']['rudeness'][1] = $this->game->game_home_rudeness_id_1;
        $this->result['home']['team']['rudeness'][2] = $this->game->game_home_rudeness_id_2;
        $this->result['home']['team']['rudeness'][3] = $this->game->game_home_rudeness_id_3;
        $this->result['home']['team']['rudeness'][4] = $this->game->game_home_rudeness_id_4;
        $this->result['home']['team']['style'][1] = $this->game->game_home_style_id_1;
        $this->result['home']['team']['style'][2] = $this->game->game_home_style_id_2;
        $this->result['home']['team']['style'][3] = $this->game->game_home_style_id_3;
        $this->result['home']['team']['style'][4] = $this->game->game_home_style_id_4;
        $this->result['home']['team']['tactic'][1] = $this->game->game_home_tactic_id_1;
        $this->result['home']['team']['tactic'][2] = $this->game->game_home_tactic_id_2;
        $this->result['home']['team']['tactic'][3] = $this->game->game_home_tactic_id_3;
        $this->result['home']['team']['tactic'][4] = $this->game->game_home_tactic_id_4;
    }

    /**
     * @return array
     */
    private function prepareTeamArray(): array
    {
        $result = [
            'player' => [
                'gk' => [
                    'age' => 0,
                    'assist' => 0,
                    'assist_power' => 0,
                    'assist_short' => 0,
                    'bonus' => 0,
                    'game' => 1,
                    'game_with_shootout' => 0,
                    'lineup_id' => 0,
                    'loose' => 0,
                    'pass' => 0,
                    'player_id' => 0,
                    'point' => 0,
                    'power_nominal' => 0,
                    'power_optimal' => 0,
                    'power_real' => 0,
                    'save' => 0,
                    'shot' => 0,
                    'shootout' => 0,
                    'win' => 0,
                ],
                'field' => $this->prepareFieldPlayerArray(),
            ],
            'team' => [
                'auto' => 0,
                'collision' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                ],
                'game' => 1,
                'leader' => 0,
                'loose' => 0,
                'loose_shootout' => 0,
                'loose_overtime' => 0,
                'mood' => 0,
                'no_pass' => 0,
                'no_score' => 0,
                'optimality_1' => 0,
                'optimality_2' => 0,
                'pass' => 0,
                'penalty' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'current' => [],
                    'opponent' => 0,
                    'overtime' => 0,
                    'total' => 0,
                ],
                'power' => [
                    'defence' => [
                        1 => 0,
                        2 => 0,
                        3 => 0,
                        4 => 0,
                        'current' => 0,
                    ],
                    'face_off' => 0,
                    'forecast' => 0,
                    'forward' => [
                        1 => 0,
                        2 => 0,
                        3 => 0,
                        4 => 0,
                        'current' => 0,
                    ],
                    'gk' => 0,
                    'optimal' => 0,
                    'percent' => 0,
                    'shot' => 0,
                    'total' => 0,
                ],
                'rudeness' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                ],
                'score' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'shootout' => 0,
                    'last' => [
                        'shootout' => '',
                        'score' => '',
                    ],
                    'overtime' => 0,
                    'total' => 0,
                ],
                'shot' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    'overtime' => 0,
                    'total' => 0,
                ],
                'style' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                ],
                'tactic' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    'current' => 0,
                ],
                'teamwork' => [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                ],
                'win' => 0,
                'win_shootout' => 0,
                'win_overtime' => 0,
            ],
        ];

        return $result;
    }

    /**
     * @return array
     */
    private function prepareFieldPlayerArray(): array
    {
        $result = [];

        for ($j = 1; $j <= 4; $j++) {
            for ($k = Position::LD; $k <= Position::RW; $k++) {
                if (Position::LD == $k) {
                    $key = 'ld';
                } elseif (Position::RD == $k) {
                    $key = 'rd';
                } elseif (Position::LW == $k) {
                    $key = 'lw';
                } elseif (Position::CF == $k) {
                    $key = 'cf';
                } else {
                    $key = 'rw';
                }

                $key = $key . '_' . $j;

                $result[$key] = [
                    'age' => 0,
                    'assist' => 0,
                    'assist_power' => 0,
                    'assist_short' => 0,
                    'bonus' => 0,
                    'bullet_win' => 0,
                    'face_off' => 0,
                    'face_off_win' => 0,
                    'game' => 1,
                    'lineup_id' => 0,
                    'loose' => 0,
                    'penalty' => 0,
                    'player_id' => 0,
                    'plus_minus' => 0,
                    'point' => 0,
                    'power_nominal' => 0,
                    'power_optimal' => 0,
                    'power_real' => 0,
                    'score' => 0,
                    'score_draw' => 0,
                    'score_power' => 0,
                    'score_short' => 0,
                    'score_win' => 0,
                    'shot' => 0,
                    'style' => 0,
                    'win' => 0,
                ];
            }
        }

        return $result;
    }

    /**
     * @return void
     */
    private function countHomeBonus(): void
    {
        if ($this->game->game_bonus_home) {
            $this->result['game_info']['home_bonus'] = 1 + $this->game->game_visitor / $this->game->game_stadium_capacity / 10;
        }
    }

    /**
     * @return void
     */
    private function getPlayerInfo(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $lineupArray = Lineup::find()
                ->with(['player'])
                ->where([
                    'lineup_game_id' => $this->result['game_info']['game_id'],
                    'lineup_national_id' => $this->result['game_info'][$team . '_national_id'],
                    'lineup_team_id' => $this->result['game_info'][$team . '_team_id'],
                ])
                ->orderBy(['lineup_line_id' => SORT_ASC, 'lineup_position_id' => SORT_ASC])
                ->all();

            $this->result[$team]['player']['gk']['age'] = $lineupArray[0]->player->player_age;
            $this->result[$team]['player']['gk']['lineup_id'] = $lineupArray[0]->lineup_id;
            $this->result[$team]['player']['gk']['player_id'] = $lineupArray[0]->lineup_player_id;
            $this->result[$team]['player']['gk']['power_nominal'] = $lineupArray[0]->player->player_power_nominal;

            if (TournamentType::FRIENDLY == $this->result['game_info']['tournament_type_id']) {
                $this->result[$team]['player']['gk']['power_optimal'] = round($lineupArray[0]->player->player_power_nominal * 0.75);
            } else {
                $this->result[$team]['player']['gk']['power_optimal'] = $lineupArray[0]->player->player_power_real;
            }

            for ($j = 1; $j <= 21; $j++) {
                if (1 == $j) {
                    $key = 'ld_1';
                } elseif (2 == $j) {
                    $key = 'rd_1';
                } elseif (3 == $j) {
                    $key = 'lw_1';
                } elseif (4 == $j) {
                    $key = 'cf_1';
                } elseif (5 == $j) {
                    $key = 'rw_1';
                } elseif (6 == $j) {
                    continue;
                } elseif (7 == $j) {
                    $key = 'ld_2';
                } elseif (8 == $j) {
                    $key = 'rd_2';
                } elseif (9 == $j) {
                    $key = 'lw_2';
                } elseif (10 == $j) {
                    $key = 'cf_2';
                } elseif (11 == $j) {
                    $key = 'rw_2';
                } elseif (12 == $j) {
                    $key = 'ld_3';
                } elseif (13 == $j) {
                    $key = 'rd_3';
                } elseif (14 == $j) {
                    $key = 'lw_3';
                } elseif (15 == $j) {
                    $key = 'cf_3';
                } elseif (16 == $j) {
                    $key = 'rw_3';
                } elseif (17 == $j) {
                    $key = 'ld_4';
                } elseif (18 == $j) {
                    $key = 'rd_4';
                } elseif (19 == $j) {
                    $key = 'lw_4';
                } elseif (20 == $j) {
                    $key = 'cf_4';
                } else {
                    $key = 'rw_4';
                }

                $this->result[$team]['player']['field'][$key]['age'] = $lineupArray[$j]->player->player_age;
                $this->result[$team]['player']['field'][$key]['lineup_id'] = $lineupArray[$j]->lineup_id;
                $this->result[$team]['player']['field'][$key]['player_id'] = $lineupArray[$j]->lineup_player_id;
                $this->result[$team]['player']['field'][$key]['power_nominal'] = $lineupArray[$j]->player->player_power_nominal;
                $this->result[$team]['player']['field'][$key]['style'] = $lineupArray[$j]->player->player_style_id;

                if (TournamentType::FRIENDLY == $this->result['game_info']['tournament_type_id']) {
                    $this->result[$team]['player']['field'][$key]['power_optimal'] = round($lineupArray[$j]->player->player_power_nominal * 0.75);
                } else {
                    $this->result[$team]['player']['field'][$key]['power_optimal'] = $lineupArray[$j]->player->player_power_real;
                }
            }
        }
    }

    /**
     * @return void
     */
    private function countPlayerBonus(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $playerId = $this->result[$team]['player']['gk']['player_id'];

            $specialArray = PlayerSpecial::find()
                ->where(['player_special_player_id' => $playerId])
                ->all();

            foreach ($specialArray as $special) {
                if (Special::SPEED == $special->player_special_special_id) {
                    if (in_array(Style::SPEED, [
                        $this->result[$team]['team']['style'][1],
                        $this->result[$team]['team']['style'][2],
                        $this->result[$team]['team']['style'][3],
                        $this->result[$team]['team']['style'][4],
                    ])) {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 10 * $special->player_special_level;
                    } elseif (in_array(Style::TECHNIQUE, array(
                        $this->result[$team]['team']['style'][1],
                        $this->result[$team]['team']['style'][2],
                        $this->result[$team]['team']['style'][3],
                        $this->result[$team]['team']['style'][4],
                    ))) {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 4 * $special->player_special_level;
                    } else {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                    }
                } elseif (Special::POWER == $special->player_special_special_id) {
                    if (in_array(Style::POWER, array(
                        $this->result[$team]['team']['style'][1],
                        $this->result[$team]['team']['style'][2],
                        $this->result[$team]['team']['style'][3],
                        $this->result[$team]['team']['style'][4],
                    ))) {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 10 * $special->player_special_level;
                    } elseif (in_array(Style::SPEED, array(
                        $this->result[$team]['team']['style'][1],
                        $this->result[$team]['team']['style'][2],
                        $this->result[$team]['team']['style'][3],
                        $this->result[$team]['team']['style'][4],
                    ))) {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 4 * $special->player_special_level;
                    } else {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                    }
                } elseif (Special::COMBINE == $special->player_special_special_id) {
                    if (in_array(Style::TECHNIQUE, array(
                        $this->result[$team]['team']['style'][1],
                        $this->result[$team]['team']['style'][2],
                        $this->result[$team]['team']['style'][3],
                        $this->result[$team]['team']['style'][4],
                    ))) {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 10 * $special->player_special_level;
                    } elseif (in_array(Style::POWER, array(
                        $this->result[$team]['team']['style'][1],
                        $this->result[$team]['team']['style'][2],
                        $this->result[$team]['team']['style'][3],
                        $this->result[$team]['team']['style'][4],
                    ))) {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 4 * $special->player_special_level;
                    } else {
                        $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                    }
                } elseif (Special::TACKLE == $special->player_special_special_id) {
                    $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                } elseif (Special::REACTION == $special->player_special_special_id) {
                    $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                } elseif (Special::SHOT == $special->player_special_special_id) {
                    $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                } elseif (Special::STICK == $special->player_special_special_id) {
                    $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 4 * $special->player_special_level;
                } elseif (Special::POSITION == $special->player_special_special_id) {
                    $this->result[$team]['player']['gk']['bonus'] = $this->result[$team]['player']['gk']['bonus'] + 5 * $special->player_special_level;
                } elseif (Special::LEADER == $special->player_special_special_id) {
                    $this->result[$team]['team']['leader'] = $this->result[$team]['team']['leader'] + $special->player_special_level;
                }
            }

            for ($line = 1; $line <= 4; $line++) {
                for ($k = Position::LD; $k <= Position::RW; $k++) {
                    if (Position::LD == $k) {
                        $key = 'ld';
                    } elseif (Position::RD == $k) {
                        $key = 'rd';
                    } elseif (Position::LW == $k) {
                        $key = 'lw';
                    } elseif (Position::CF == $k) {
                        $key = 'cf';
                    } else {
                        $key = 'rw';
                    }

                    $key = $key . '_' . $line;

                    if ($this->result[$team]['team']['style'][$line] == $this->result[$team]['player']['field'][$key]['style']) {
                        $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5;
                    }

                    $playerId = $this->result[$team]['player']['field'][$key]['player_id'];

                    $specialArray = PlayerSpecial::find()
                        ->where(['player_special_player_id' => $playerId])
                        ->all();

                    foreach ($specialArray as $special) {
                        if (Special::SPEED == $special->player_special_special_id) {
                            if (Style::SPEED == $this->result[$team]['team']['style'][$line]) {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 10 * $special->player_special_level;
                            } elseif (Style::TECHNIQUE == $this->result[$team]['team']['style'][$line]) {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 4 * $special->player_special_level;
                            } else {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5 * $special->player_special_level;
                            }
                        } elseif (Special::POWER == $special->player_special_special_id) {
                            if (Style::POWER == $this->result[$team]['team']['style'][$line]) {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 10 * $special->player_special_level;
                            } elseif (Style::SPEED == $this->result[$team]['team']['style'][$line]) {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 4 * $special->player_special_level;
                            } else {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5 * $special->player_special_level;
                            }
                        } elseif (Special::COMBINE == $special->player_special_special_id) {
                            if (Style::TECHNIQUE == $this->result[$team]['team']['style'][$line]) {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 10 * $special->player_special_level;
                            } elseif (Style::POWER == $this->result[$team]['team']['style'][$line]) {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 4 * $special->player_special_level;
                            } else {
                                $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5 * $special->player_special_level;
                            }
                        } elseif (Special::TACKLE == $special->player_special_special_id) {
                            $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5 * $special->player_special_level;
                        } elseif (Special::REACTION == $special->player_special_special_id) {
                            $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5 * $special->player_special_level;
                        } elseif (Special::SHOT == $special->player_special_special_id) {
                            $this->result[$team]['player']['field'][$key]['bonus'] = $this->result[$team]['player']['field'][$key]['bonus'] + 5 * $special->player_special_level;
                        } elseif (Special::LEADER == $special->player_special_special_id) {
                            $this->result[$team]['team']['leader'] = $this->result[$team]['team']['leader'] + $special->player_special_level;
                        }
                    }
                }
            }
        }
    }

    /**
     * @return void
     */
    private function getTeamwork(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            for ($j = 1; $j <= 4; $j++) {
                $teamwork = 0;

                $playerIdArray = [
                    $this->result[$team]['player']['field']['ld_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['rd_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['lw_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['cf_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['rw_' . $j]['player_id'],
                ];

                for ($step = 1; $step <= 10; $step++) {
                    list($player1, $player2) = $this->getTeamworkPlayerIds($step, $playerIdArray);

                    $teamworkOne = Teamwork::find()
                        ->select(['teamwork_value'])
                        ->where(['teamwork_player_id_1' => $player1, 'teamwork_player_id_2' => $player2])
                        ->orWhere(['teamwork_player_id_1' => $player2, 'teamwork_player_id_2' => $player1])
                        ->limit(1)
                        ->scalar();
                    $teamwork = $teamwork + $teamworkOne ?? 0;
                }

                $this->result[$team]['team']['teamwork'][$j] = round($teamwork / 10);
            }
        }
    }

    /**
     * @param int $step
     * @param array $playerArray
     * @return array
     */
    private function getTeamworkPlayerIds(int $step, array $playerArray): array
    {
        if (1 == $step) {
            $result = [$playerArray[0], $playerArray[1]];
        } elseif (2 == $step) {
            $result = [$playerArray[0], $playerArray[2]];
        } elseif (3 == $step) {
            $result = [$playerArray[0], $playerArray[3]];
        } elseif (4 == $step) {
            $result = [$playerArray[0], $playerArray[4]];
        } elseif (5 == $step) {
            $result = [$playerArray[1], $playerArray[2]];
        } elseif (6 == $step) {
            $result = [$playerArray[1], $playerArray[3]];
        } elseif (7 == $step) {
            $result = [$playerArray[1], $playerArray[4]];
        } elseif (8 == $step) {
            $result = [$playerArray[2], $playerArray[3]];
        } elseif (9 == $step) {
            $result = [$playerArray[2], $playerArray[4]];
        } else {
            $result = [$playerArray[3], $playerArray[4]];
        }

        return $result;
    }

    /**
     * @return void
     */
    private function setTeamwork(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            for ($j = 1; $j <= 4; $j++) {
                $playerIdArray = [
                    $this->result[$team]['player']['field']['ld_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['rd_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['lw_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['cf_' . $j]['player_id'],
                    $this->result[$team]['player']['field']['rw_' . $j]['player_id'],
                ];

                for ($step = 1; $step <= 10; $step++) {
                    list($player1, $player2) = $this->getTeamworkPlayerIds($step, $playerIdArray);

                    $teamwork = Teamwork::find()
                        ->where(['teamwork_player_id_1' => $player1, 'teamwork_player_id_2' => $player2])
                        ->orWhere(['teamwork_player_id_1' => $player2, 'teamwork_player_id_2' => $player1])
                        ->limit(1)
                        ->one();
                    if (!$teamwork) {
                        $teamwork = new Teamwork();
                        $teamwork->teamwork_player_id_1 = $player1;
                        $teamwork->teamwork_player_id_2 = $player2;
                        $teamwork->teamwork_value = 0;
                    }
                    $teamwork->teamwork_value = $teamwork->teamwork_value + 5;
                    $teamwork->save();
                }
            }
        }
    }

    /**
     * @return void
     */
    private function collision(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
                $opponent = 'guest';
            } else {
                $team = 'guest';
                $opponent = 'home';
            }

            for ($j = 1; $j <= 4; $j++) {
                if ((Style::POWER == $this->result[$team]['team']['style'][$j] && Style::SPEED == $this->result[$opponent]['team']['style'][$j]) ||
                    (Style::SPEED == $this->result[$team]['team']['style'][$j] && Style::TECHNIQUE == $this->result[$opponent]['team']['style'][$j]) ||
                    (Style::TECHNIQUE == $this->result[$team]['team']['style'][$j] && Style::POWER == $this->result[$opponent]['team']['style'][$j])) {
                    $this->result[$team]['team']['collision'][$j] = 1;
                    $this->result[$team]['opponent']['collision'][$j] = -1;
                } elseif ((Style::SPEED == $this->result[$team]['team']['style'][$j] && Style::POWER == $this->result[$opponent]['team']['style'][$j]) ||
                    (Style::TECHNIQUE == $this->result[$team]['team']['style'][$j] && Style::SPEED == $this->result[$opponent]['team']['style'][$j]) ||
                    (Style::POWER == $this->result[$team]['team']['style'][$j] && Style::TECHNIQUE == $this->result[$opponent]['team']['style'][$j])) {
                    $this->result[$team]['team']['collision'][$j] = -1;
                    $this->result[$team]['opponent']['collision'][$j] = 1;
                }
            }
        }
    }

    /**
     * @return void
     */
    private function playerOptimalPower(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $this->result[$team]['player']['gk']['power_optimal'] = round(
                $this->result[$team]['player']['gk']['power_optimal']
                * (100 + $this->result[$team]['player']['gk']['bonus'] + $this->result[$team]['team']['leader']) / 100
                * (100 + ($this->result[$team]['team']['teamwork'][1] + $this->result[$team]['team']['teamwork'][2] + $this->result[$team]['team']['teamwork'][3]) / 3) / 100
                * (10 - $this->result[$team]['team']['mood'] + 2) / 10
                * (100 - self::AUTO_PENALTY * $this->result[$team]['team']['auto']) / 100
            );

            if ('home' == $team) {
                $this->result[$team]['player']['gk']['power_optimal'] = round(
                    $this->result[$team]['player']['gk']['power_optimal'] * $this->result['game_info']['home_bonus']
                );
            }

            for ($line = 1; $line <= 4; $line++) {
                for ($k = Position::LD; $k <= Position::RW; $k++) {
                    if (Position::LD == $k) {
                        $key = 'ld';
                    } elseif (Position::RD == $k) {
                        $key = 'rd';
                    } elseif (Position::LW == $k) {
                        $key = 'lw';
                    } elseif (Position::CF == $k) {
                        $key = 'cf';
                    } else {
                        $key = 'rw';
                    }

                    $key = $key . '_' . $line;

                    if (in_array($k, array(Position::LD, Position::RD))) {
                        if (Tactic::ALL_ATTACK == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = -10 / 2;
                        } elseif (Tactic::ATTACK == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = -5 / 2;
                        } elseif (Tactic::DEFENCE == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = 5 / 2;
                        } elseif (Tactic::ALL_DEFENCE == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = 10 / 2;
                        } else {
                            $tactic = 0;
                        }
                    } else {
                        if (Tactic::ALL_ATTACK == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = 10 / 3;
                        } elseif (Tactic::ATTACK == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = 5 / 3;
                        } elseif (Tactic::DEFENCE == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = -5 / 3;
                        } elseif (Tactic::ALL_DEFENCE == $this->result[$team]['team']['tactic'][$line]) {
                            $tactic = -10 / 3;
                        } else {
                            $tactic = 0;
                        }
                    }

                    if (-1 == $this->result[$team]['team']['collision'][$line]) {
                        $collision = 0;
                    } else {
                        $collision = $this->result[$team]['team']['collision'][$line];
                    }

                    $this->result[$team]['player']['field'][$key]['power_optimal'] = round(
                        $this->result[$team]['player']['field'][$key]['power_optimal']
                        * (100 + $this->result[$team]['player']['field'][$key]['bonus'] + $this->result[$team]['team']['leader']) / 100
                        * (100 + $this->result[$team]['team']['teamwork'][$line]) / 100
                        * (10 - $this->result[$team]['team']['mood'] + 2) / 10
                        * (100 + $this->result[$team]['team']['rudeness'][$line] - 1) / 100
                        * (10 + $collision) / 10
                        * (100 + $tactic) / 100
                        * (100 - self::AUTO_PENALTY * $this->result[$team]['team']['auto']) / 100
                    );

                    if ('home' == $team) {
                        $this->result[$team]['player']['field'][$key]['power_optimal'] = round(
                            $this->result[$team]['player']['field'][$key]['power_optimal'] * $this->result['game_info']['home_bonus']
                        );
                    }
                }
            }
        }
    }

    /**
     * @return void
     */
    private function playerRealPower(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $this->result[$team]['player']['gk']['power_real'] = $this->result[$team]['player']['gk']['power_optimal'];

            for ($line = 1; $line <= 4; $line++) {
                for ($k = Position::LD; $k <= Position::RW; $k++) {
                    if (Position::LD == $k) {
                        $key = 'ld';
                    } elseif (Position::RD == $k) {
                        $key = 'rd';
                    } elseif (Position::LW == $k) {
                        $key = 'lw';
                    } elseif (Position::CF == $k) {
                        $key = 'cf';
                    } else {
                        $key = 'rw';
                    }

                    $key = $key . '_' . $line;

                    $playerId = $this->result[$team]['player']['field'][$key]['player_id'];
                    $playerPower = $this->result[$team]['player']['field'][$key]['power_optimal'];

                    $positionArray = PlayerPosition::find()
                        ->select(['player_position_position_id'])
                        ->where(['player_position_player_id' => $playerId])
                        ->column();

                    $positionId = $k;

                    if (Position::LD == $positionId) {
                        $positionCoefficient = [Position::LD, [Position::RD, Position::LW]];
                    } elseif (Position::RD == $positionId) {
                        $positionCoefficient = [Position::RD, [Position::LD, Position::RW]];
                    } elseif (Position::LW == $positionId) {
                        $positionCoefficient = [Position::LW, [Position::LD, Position::CF]];
                    } elseif (Position::CF == $positionId) {
                        $positionCoefficient = [Position::CF, [Position::LW, Position::RW]];
                    } elseif (Position::RW == $positionId) {
                        $positionCoefficient = [Position::RW, [Position::RD, Position::CF]];
                    } else {
                        $positionCoefficient = [0, [0, 0]];
                    }

                    if (in_array($positionCoefficient[0], $positionArray)) {
                        $power = $playerPower;
                    } elseif (in_array(
                            $positionCoefficient[1][0],
                            $positionArray
                        ) || in_array(
                            $positionCoefficient[1][1],
                            $positionArray
                        )) {
                        $power = round($playerPower * 0.9);
                    } else {
                        $power = round($playerPower * 0.8);
                    }

                    $this->result[$team]['player']['field'][$key]['power_real'] = $power;
                }
            }
        }
    }

    /**
     * @return void
     */
    private function teamPower(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $this->result[$team]['team']['power']['gk'] = $this->result[$team]['player']['gk']['power_real'];
            $this->result[$team]['team']['power']['defence'][1]
                = $this->result[$team]['player']['field']['ld_1']['power_real']
                + $this->result[$team]['player']['field']['rd_1']['power_real'];
            $this->result[$team]['team']['power']['defence'][2]
                = $this->result[$team]['player']['field']['ld_2']['power_real']
                + $this->result[$team]['player']['field']['rd_2']['power_real'];
            $this->result[$team]['team']['power']['defence'][3]
                = $this->result[$team]['player']['field']['ld_3']['power_real']
                + $this->result[$team]['player']['field']['rd_3']['power_real'];
            $this->result[$team]['team']['power']['defence'][4]
                = $this->result[$team]['player']['field']['ld_4']['power_real']
                + $this->result[$team]['player']['field']['rd_4']['power_real'];
            $this->result[$team]['team']['power']['forward'][1]
                = $this->result[$team]['player']['field']['lw_1']['power_real']
                + $this->result[$team]['player']['field']['cf_1']['power_real']
                + $this->result[$team]['player']['field']['rw_1']['power_real'];
            $this->result[$team]['team']['power']['forward'][2]
                = $this->result[$team]['player']['field']['lw_2']['power_real']
                + $this->result[$team]['player']['field']['cf_2']['power_real']
                + $this->result[$team]['player']['field']['rw_2']['power_real'];
            $this->result[$team]['team']['power']['forward'][3]
                = $this->result[$team]['player']['field']['lw_3']['power_real']
                + $this->result[$team]['player']['field']['cf_3']['power_real']
                + $this->result[$team]['player']['field']['rw_3']['power_real'];
            $this->result[$team]['team']['power']['forward'][4]
                = $this->result[$team]['player']['field']['lw_4']['power_real']
                + $this->result[$team]['player']['field']['cf_4']['power_real']
                + $this->result[$team]['player']['field']['rw_4']['power_real'];
            $this->result[$team]['team']['power']['total']
                = $this->result[$team]['team']['power']['gk']
                + $this->result[$team]['team']['power']['defence'][1]
                + $this->result[$team]['team']['power']['defence'][2]
                + $this->result[$team]['team']['power']['defence'][3]
                + $this->result[$team]['team']['power']['defence'][4]
                + $this->result[$team]['team']['power']['forward'][1]
                + $this->result[$team]['team']['power']['forward'][2]
                + $this->result[$team]['team']['power']['forward'][3]
                + $this->result[$team]['team']['power']['forward'][4];
            $this->result[$team]['team']['power']['optimal']
                = $this->result[$team]['player']['gk']['power_optimal']
                + $this->result[$team]['player']['field']['ld_1']['power_optimal']
                + $this->result[$team]['player']['field']['rd_1']['power_optimal']
                + $this->result[$team]['player']['field']['lw_1']['power_optimal']
                + $this->result[$team]['player']['field']['cf_1']['power_optimal']
                + $this->result[$team]['player']['field']['rw_1']['power_optimal']
                + $this->result[$team]['player']['field']['ld_2']['power_optimal']
                + $this->result[$team]['player']['field']['rd_2']['power_optimal']
                + $this->result[$team]['player']['field']['lw_2']['power_optimal']
                + $this->result[$team]['player']['field']['cf_2']['power_optimal']
                + $this->result[$team]['player']['field']['rw_2']['power_optimal']
                + $this->result[$team]['player']['field']['ld_3']['power_optimal']
                + $this->result[$team]['player']['field']['rd_3']['power_optimal']
                + $this->result[$team]['player']['field']['lw_3']['power_optimal']
                + $this->result[$team]['player']['field']['cf_3']['power_optimal']
                + $this->result[$team]['player']['field']['rw_3']['power_optimal']
                + $this->result[$team]['player']['field']['ld_4']['power_optimal']
                + $this->result[$team]['player']['field']['rd_4']['power_optimal']
                + $this->result[$team]['player']['field']['lw_4']['power_optimal']
                + $this->result[$team]['player']['field']['cf_4']['power_optimal']
                + $this->result[$team]['player']['field']['rw_4']['power_optimal'];
        }
    }

    /**
     * @return void
     */
    private function teamPowerForecast(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $teamId = $this->result['game_info'][$team . '_team_id'];
            $nationalId = $this->result['game_info'][$team . '_national_id'];

            if (0 != $teamId) {
                $power = Team::find()
                    ->select(['team_power_vs'])
                    ->where(['team_id' => $teamId])
                    ->limit(1)
                    ->scalar();
            } else {
                $power = National::find()
                    ->select(['national_power_vs'])
                    ->where(['national_id' => $nationalId])
                    ->limit(1)
                    ->scalar();
            }

            $this->result[$team]['team']['power']['forecast'] = $power;

            if (!$this->result[$team]['team']['power']['forecast']) {
                $this->result[$team]['team']['power']['forecast'] = $this->result[$team]['team']['power']['optimal'];
            }
        }
    }

    /**
     * @return void
     */
    private function optimality(): void
    {

        $homePowerReal = $this->result['home']['team']['power']['total'];
        $homePowerOptimal = $this->result['home']['team']['power']['optimal'];

        if (0 == $homePowerOptimal) {
            $homePowerOptimal = 1;
        }

        $homeOptimal1 = round($homePowerReal / $homePowerOptimal * 100);

        $guestPowerReal = $this->result['guest']['team']['power']['total'];
        $guestPowerOptimal = $this->result['guest']['team']['power']['optimal'];

        if (!$guestPowerOptimal) {
            $guestPowerOptimal = 1;
        }

        $guestOptimal1 = round($guestPowerReal / $guestPowerOptimal * 100);

        $homeForecast = $this->result['home']['team']['power']['forecast'];

        if (!$homeForecast) {
            $homeForecast = 1;
        }

        $homeOptimal2 = round($homePowerReal / $this->result['game_info']['home_bonus'] / $homeForecast * 100);

        $guestForecast = $this->result['guest']['team']['power']['forecast'];

        if (!$guestForecast) {
            $guestForecast = 1;
        }

        $guestOptimal2 = round($guestPowerReal / $guestForecast * 100);

        if (!$homePowerReal) {
            $homePowerReal = 1;
        }

        if (!$guestPowerReal) {
            $guestPowerReal = 1;
        }

        $teamPowerTotal = $homePowerReal + $guestPowerReal;
        $homePowerPercent = round($homePowerReal / $teamPowerTotal * 100);
        $guestPowerPercent = 100 - $homePowerPercent;

        $this->result['home']['team']['optimality_1'] = $homeOptimal1;
        $this->result['home']['team']['optimality_2'] = $homeOptimal2;
        $this->result['home']['team']['power']['percent'] = $homePowerPercent;
        $this->result['guest']['team']['optimality_1'] = $guestOptimal1;
        $this->result['guest']['team']['optimality_2'] = $guestOptimal2;
        $this->result['guest']['team']['power']['percent'] = $guestPowerPercent;
    }

    /**
     * @return void
     */
    private function shouldWin(): void
    {
        $result = 0;
        if ($this->result['home']['team']['power']['percent'] > 52) {
            $result = ($this->result['home']['team']['power']['percent'] - 52) / 3;
        } elseif ($this->result['guest']['team']['power']['percent'] > 52) {
            $result = -($this->result['guest']['team']['power']['percent'] - 52) / 3;
        }

        $this->result['should_win'] = $result;
    }

    /**
     * @param bool $endIfScore
     * @return void
     */
    private function generateMinute(bool $endIfScore = false): void
    {
        if (!$endIfScore || $this->result['minute'] < 65) {
            $this->defence();
            $this->forward();
            $this->tactic();
            $this->generatePenalty();
            $this->currentPenaltyDecrease();
            $this->faceOff();
            $this->generateAttack($endIfScore);
        }
    }

    /**
     * @return void
     */
    private function defence(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $defence = $this->result[$team]['team']['power']['defence'][$this->getLineByMinute()];
            $this->result[$team]['team']['power']['defence']['current'] = $defence;
        }
    }

    /**
     * @return int
     */
    private function getLineByMinute(): int
    {
        if (0 == $this->result['minute'] % 4) {
            $line = 1;
        } elseif (1 == $this->result['minute'] % 4) {
            $line = 2;
        } elseif (2 == $this->result['minute'] % 4) {
            $line = 3;
        } else {
            $line = 4;
        }

        return $line;
    }

    /**
     * @return void
     */
    private function forward(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $forward = $this->result[$team]['team']['power']['forward'][$this->getLineByMinute()];
            $this->result[$team]['team']['power']['forward']['current'] = $forward;
        }
    }

    /**
     * @return void
     */
    private function tactic(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $tactic = $this->result[$team]['team']['tactic'][$this->getLineByMinute()];
            $this->result[$team]['team']['tactic']['current'] = $tactic;
        }
    }

    /**
     * @return void
     */
    private function generatePenalty(): void
    {
        $rudenessHome = $this->result['home']['team']['rudeness'][$this->result['minute'] % 4 + 1];
        $rudenessGuest = $this->result['guest']['team']['rudeness'][$this->result['minute'] % 4 + 1];

        $ifRudenessRand = rand(0, self::MAX_RUDENESS);
        $ifRudenessHome = self::LIMIT_RUDENESS - $rudenessHome * self::COEFFICIENT_RUDENESS;
        if ($ifRudenessRand >= $ifRudenessHome && 1 == rand(0, 1)) {
            $this->processPenalty('home');
        }

        $ifRudenessRand = rand(0, self::MAX_RUDENESS);
        $ifRudenessGuest = self::LIMIT_RUDENESS - $rudenessGuest * self::COEFFICIENT_RUDENESS;
        if ($ifRudenessRand >= $ifRudenessGuest && 1 == rand(0, 1)) {
            $this->result['player'] = rand(Position::LD, Position::RW);
            $this->processPenalty('home');
        }

    }

    /**
     * @param string $team
     * @return void
     */
    private function processPenalty(string $team): void
    {
        $this->result['player'] = rand(Position::LD, Position::RW);
        $this->eventPenalty($team);
        $this->playerPenaltyIncrease($team);
        $this->currentPenaltyIncrease($team);
        $this->teamPenaltyIncrease($team);
    }

    /**
     * @param string $team
     * @return void
     */
    private function eventPenalty(string $team): void
    {
        if ('home' == $team) {
            $second = rand(0, 14);
        } else {
            $second = rand(15, 29);
        }

        $this->result['event'][] = array(
            'event_event_text_goal_id' => 0,
            'event_event_text_penalty_id' => EventTextPenalty::getRandTextId(),
            'event_event_text_shootout_id' => 0,
            'event_event_type_id' => EventType::PENALTY,
            'event_game_id' => $this->result['game_info']['game_id'],
            'event_guest_score' => $this->result['guest']['team']['score']['total'],
            'event_home_score' => $this->result['home']['team']['score']['total'],
            'event_minute' => $this->result['minute'],
            'event_national_id' => $this->result['game_info'][$team . '_national_id'],
            'event_player_assist_1_id' => 0,
            'event_player_assist_2_id' => 0,
            'event_player_score_id' => 0,
            'event_player_penalty_id' => 0,
            'event_second' => $second,
            'event_team_id' => $this->result['game_info'][$team . '_team_id'],
        );
    }

    /**
     * @param string $team
     * @return void
     */
    private function playerPenaltyIncrease(string $team): void
    {
        $countEvent = count($this->result['event']);
        $key = $this->getFieldKeyByPosition($this->result['player']);
        $this->result[$team]['player']['field'][$key]['penalty']++;
        $eventPlayerId = $this->result[$team]['player']['field'][$key]['player_id'];
        $this->result['event'][$countEvent - 1]['event_player_penalty_id'] = $eventPlayerId;
    }

    /**
     * @param int $position
     * @return string
     */
    private function getFieldKeyByPosition(int $position): string
    {
        if (Position::LD == $position) {
            $key = 'ld';
        } elseif (Position::RD == $position) {
            $key = 'rd';
        } elseif (Position::LW == $position) {
            $key = 'lw';
        } elseif (Position::CF == $position) {
            $key = 'cf';
        } else {
            $key = 'rw';
        }

        $key = $key . '_' . $this->getLineByMinute();

        return $key;
    }

    /**
     * @param string $team
     * @return void
     */
    private function currentPenaltyIncrease(string $team): void
    {
        $this->result[$team]['team']['penalty']['current'][] = [
            'minute' => $this->result['minute'],
            'position' => $this->result['player'],
        ];
    }

    /**
     * @param string $team
     * @return void
     */
    private function teamPenaltyIncrease(string $team): void
    {
        $this->result[$team]['team']['penalty']['total']++;
        $this->result[$team]['team']['penalty'][$this->getPeriodByMinute()]++;
    }

    /**
     * @return int|string
     */
    private function getPeriodByMinute()
    {
        if (20 > $this->result['minute']) {
            $result = 1;
        } elseif (40 > $this->result['minute']) {
            $result = 2;
        } elseif (60 > $this->result['minute']) {
            $result = 3;
        } else {
            $result = 'overtime';
        }

        return $result;
    }

    /**
     * @return void
     */
    private function currentPenaltyDecrease(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            $penaltyArrayOld = $this->result[$team]['team']['penalty']['current'];
            $penaltyArrayNew = array();

            $countPenalty = count($penaltyArrayOld);

            for ($j = 0; $j < $countPenalty; $j++) {
                if (0 == $j) {
                    if ($this->result['minute'] < $penaltyArrayOld[$j]['minute'] + 2) {
                        $penaltyArrayNew[] = $penaltyArrayOld[$j];
                    }
                } elseif ($j > 1) {
                    $penaltyArrayNew[] = array(
                        'minute' => $this->result['minute'],
                        'position' => $penaltyArrayOld[$j]['position'],
                    );
                } else {
                    $penaltyArrayNew[] = $penaltyArrayOld[$j];
                }
            }

            $this->result[$team]['team']['penalty']['current'] = $penaltyArrayNew;
        }
    }

    /**
     * @return void
     */
    private function faceOff(): void
    {
        $this->selectFaceOff('home');
        $this->selectFaceOff('guest');
        $this->playerFaceOffIncrease('home');
        $this->playerFaceOffIncrease('guest');
        $this->playerFaceOffPower('home');
        $this->playerFaceOffPower('guest');

        $ifFaceOffHome = rand(0, $this->result['home']['team']['power']['face_off']);
        $ifFaceOffGuest = rand(0, $this->result['guest']['team']['power']['face_off']);

        if ($ifFaceOffHome >= $ifFaceOffGuest) {
            $this->playerFaceOffWinIncrease('home');
        } else {
            $this->playerFaceOffWinIncrease('guest');
        }
    }

    /**
     * @param string $team
     * @return void
     */
    private function selectFaceOff(string $team): void
    {
        $penaltyPosition = $this->penaltyPositionArray($team);

        if (!in_array(Position::CF, $penaltyPosition)) {
            $this->result['face_off_' . $team] = Position::CF;
        } else {
            $this->result['face_off_' . $team] = rand(Position::LD, Position::RW);
        }

        if (in_array($this->result['face_off_' . $team], $penaltyPosition)) {
            $this->selectFaceOff($team);
        }
    }

    /**
     * @param string $team
     * @return array
     */
    private function penaltyPositionArray(string $team): array
    {
        $penaltyPositionArray = [];

        $countPenalty = count($this->result[$team]['team']['penalty']['current']);

        if ($countPenalty > 2) {
            $countPenalty = 2;
        }

        for ($i = 0; $i < $countPenalty; $i++) {
            $penaltyPositionArray[] = $this->result[$team]['team']['penalty']['current'][$i]['position'];
        }

        return $penaltyPositionArray;
    }

    /**
     * @param string $team
     * @return void
     */
    private function playerFaceOffIncrease(string $team): void
    {
        $key = $this->getFieldKeyByPosition($this->result['face_off_' . $team]);
        $this->result[$team]['player']['field'][$key]['face_off']++;
    }

    /**
     * @param string $team
     * @return void
     */
    private function playerFaceOffPower(string $team): void
    {
        $key = $this->getFieldKeyByPosition($this->result['face_off_' . $team]);
        $power = $this->result[$team]['player']['field'][$key]['power_real'];
        $this->result[$team]['team']['power']['face_off'] = $power;
    }

    /**
     * @param string $team
     * @return void
     */
    private function playerFaceOffWinIncrease(string $team): void
    {
        $key = $this->getFieldKeyByPosition($this->result['face_off_' . $team]);
        $this->result[$team]['player']['field'][$key]['face_off_win']++;
    }

    /**
     * @param bool $endIfScore
     * @return void
     */
    private function generateAttack(bool $endIfScore): void
    {
        $this->processAttack('home', 'guest');
        if (!$endIfScore || $this->result['minute'] < 65) {
            $this->processAttack('guest', 'home', $endIfScore);
        }
    }

    /**
     * @param string $team
     * @param string $opponent
     * @param bool $endIfScore
     * @return void
     */
    private function processAttack(string $team, string $opponent, bool $endIfScore = false)
    {
        $teamPenaltyCurrent = count($this->result[$team]['team']['penalty']['current']);

        if ($teamPenaltyCurrent > 2) {
            $teamPenaltyCurrent = 2;
        }

        $opponentPenaltyCurrent = count($this->result[$opponent]['team']['penalty']['current']);

        if ($opponentPenaltyCurrent > 2) {
            $opponentPenaltyCurrent = 2;
        }

        $forward = $this->result[$team]['team']['power']['forward']['current'] / (self::COEFFICIENT_FORWARD + $teamPenaltyCurrent);
        $defence = $this->result[$opponent]['team']['power']['defence']['current'] / (self::COEFFICIENT_DEFENCE + $opponentPenaltyCurrent);

        if (rand(0, $forward * $this->result[$team]['team']['tactic']['current']) > rand(0, $defence)) {
            $this->selectPlayerShot($team);
            $this->teamShotIncrease($team, $opponent);
            $this->playerShotIncrease($team);
            $this->playerShotPower($team);

            $shotPower = $this->result[$team]['team']['power']['shot'];
            $gkPower = $this->result[$opponent]['team']['power']['gk'];

            $ifShot = rand($shotPower / self::COEFFICIENT_SHOT_1, $shotPower * self::COEFFICIENT_SHOT_2);
            $ifGk = rand(
                $gkPower / self::COEFFICIENT_GK,
                $gkPower + $defence * (self::COEFFICIENT_DEFENCE_GK - $this->result[$opponent]['team']['tactic']['current'])
            );

            if ($ifShot > $ifGk && $this->canScore($team, $opponent)) {
                $this->assist1($team);
                $this->assist2($team);
                $this->teamScoreIncrease($team, $opponent);
                $this->eventScore($team);
                $this->plusMinusIncrease($team, $opponent);
                $this->playerScoreIncrease($team, $opponent);
                $this->playerAssist1Increase($team, $opponent);
                $this->playerAssist2Increase($team, $opponent);
                $this->currentPenaltyDecreaseAfterGoal($team, $opponent);

                if ($endIfScore) {
                    $this->result['minute'] = 65;
                }
            }
        }
    }

    /**
     * @param string $team
     * @return void
     */
    private function selectPlayerShot(string $team): void
    {
        $line = $this->getLineByMinute();

        $ldPower = $this->result[$team]['player']['field']['ld_' . $line]['power_real'];
        $rdPower = $this->result[$team]['player']['field']['rd_' . $line]['power_real'];
        $lwPower = $this->result[$team]['player']['field']['lw_' . $line]['power_real'];
        $cfPower = $this->result[$team]['player']['field']['cf_' . $line]['power_real'];
        $rwPower = $this->result[$team]['player']['field']['rw_' . $line]['power_real'];

        $ldPower = $ldPower * 100;
        $rdPower = $rdPower * 100;
        $lwPower = $lwPower * 105;
        $cfPower = $cfPower * 110;
        $rwPower = $rwPower * 105;

        $totalPower = $ldPower + $rdPower + $lwPower + $cfPower + $rwPower;

        $rand = rand(0, $totalPower);

        if ($rand < $ldPower) {
            $this->result['player'] = Position::LD;
        } elseif ($rand < $ldPower + $rdPower) {
            $this->result['player'] = Position::RD;
        } elseif ($rand < $ldPower + $rdPower + $lwPower) {
            $this->result['player'] = Position::LW;
        } elseif ($rand < $ldPower + $rdPower + $lwPower + $cfPower) {
            $this->result['player'] = Position::CF;
        } else {
            $this->result['player'] = Position::RW;
        }

        $penaltyPosition = $this->penaltyPositionArray($team);

        if (in_array($this->result['player'], $penaltyPosition)) {
            $this->selectPlayerShot($team);
        }
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function teamShotIncrease(string $team, string $opponent): void
    {
        $this->result[$opponent]['player']['gk']['shot']++;
        $this->result[$team]['team']['shot']['total']++;
        $this->result[$team]['team']['shot'][$this->getPeriodByMinute()]++;
    }

    /**
     * @param string $team
     * @return void
     */
    private function playerShotIncrease(string $team): void
    {
        $key = $this->getFieldKeyByPosition($this->result['player']);
        $this->result[$team]['player']['field'][$key]['shot']++;
    }

    /**
     * @param string $team
     * @return void
     */
    private function playerShotPower(string $team): void
    {
        $key = $this->getFieldKeyByPosition($this->result['player']);
        $shot = $this->result[$team]['player']['field'][$key]['power_real'];
        $this->result[$team]['team']['power']['shot'] = $shot;
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return bool
     */
    private function canScore(string $team, string $opponent): bool
    {
        $result = false;

        $scoreDifference = $this->result[$team]['team']['score']['total'] - $this->result[$opponent]['team']['score']['total'];

        if ('home' == $team) {
            if ($scoreDifference < $this->result['should_win'] + 1) {
                $result = true;
            }
        } else {
            if ($scoreDifference < -$this->result['should_win'] + 1) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * @param string $team
     * @return void
     */
    private function assist1($team): void
    {
        if (rand(0, 5)) {
            $this->selectAssist1($team);
        } else {
            $this->result['assist_1'] = 0;
        }
    }

    /**
     * @param string $team
     * @return void
     */
    private function selectAssist1($team): void
    {
        if (1 == rand(1, 3)) {
            $this->result['assist_1'] = rand(Position::LD, Position::RD);
        } else {
            $this->result['assist_1'] = rand(Position::LW, Position::RW);
        }

        $penaltyPosition = $this->penaltyPositionArray($team);
        $penaltyPosition[] = $this->result['player'];

        if (in_array($this->result['assist_1'], $penaltyPosition)) {
            $this->selectAssist1($team);
        }
    }

    /**
     * @param string $team
     * @return void
     */
    private function assist2($team): void
    {
        if (rand(0, 5)) {
            $this->selectAssist2($team);
        } else {
            $this->result['assist_2'] = 0;
        }
    }

    /**
     * @param string $team
     * @return void
     */
    private function selectAssist2($team): void
    {
        if (1 == rand(1, 1000)) {
            $this->result['assist_2'] = Position::GK;
        } elseif (1 == rand(1, 3)) {
            $this->result['assist_2'] = rand(Position::LD, Position::RD);
        } else {
            $this->result['assist_2'] = rand(Position::LW, Position::RW);
        }

        $penaltyPosition = $this->penaltyPositionArray($team);
        $penaltyPosition[] = $this->result['player'];

        $ifInArray = in_array($this->result['assist_1'], $penaltyPosition);
        if ($ifInArray || $this->result['assist_2'] == $this->result['assist_1']) {
            $this->selectAssist2($team);
        }
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function teamScoreIncrease($team, $opponent): void
    {
        $this->result[$team]['team']['score']['total']++;
        $this->result[$opponent]['player']['gk']['pass']++;
        $this->result[$team]['team']['score'][$this->getPeriodByMinute()]++;
    }

    /**
     * @param string $team
     * @return void
     */
    private function eventScore($team): void
    {

        if ('home' == $team) {
            $second = rand(30, 44);
        } else {
            $second = rand(45, 59);
        }

        $this->result['event'][] = array(
            'event_event_text_goal_id' => EventTextGoal::getRandTextId(),
            'event_event_text_penalty_id' => 0,
            'event_event_text_shootout_id' => 0,
            'event_event_type_id' => EventType::GOAL,
            'event_game_id' => $this->result['game_info']['game_id'],
            'event_guest_score' => $this->result['guest']['team']['score']['total'],
            'event_home_score' => $this->result['home']['team']['score']['total'],
            'event_minute' => $this->result['minute'],
            'event_national_id' => $this->result['game_info'][$team . '_national_id'],
            'event_player_assist_1_id' => 0,
            'event_player_assist_2_id' => 0,
            'event_player_score_id' => 0,
            'event_player_penalty_id' => 0,
            'event_second' => $second,
            'event_team_id' => $this->result['game_info'][$team . '_team_id'],
        );
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function plusMinusIncrease($team, $opponent): void
    {
        $penaltyPositionTeam = $this->penaltyPositionArray($team);
        $penaltyPositionOpponent = $this->penaltyPositionArray($opponent);

        for ($position = Position::LD; $position <= Position::RW; $position++) {
            $key = $this->getFieldKeyByPosition($position);
            if (!in_array($position, $penaltyPositionTeam)) {
                $this->result[$team]['player']['field'][$key]['plus_minus']++;
            }

            if (!in_array($position, $penaltyPositionOpponent)) {
                $this->result[$opponent]['player']['field'][$key]['plus_minus']--;
            }
        }
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function playerScoreIncrease($team, $opponent): void
    {
        $countTeamPenalty = count($this->result[$team]['team']['penalty']['current']);
        $countOpponentPenalty = count($this->result[$opponent]['team']['penalty']['current']);
        $draw = '';
        $powerShort = '';

        if ($countTeamPenalty < $countOpponentPenalty && 2 > $countTeamPenalty) {
            $powerShort = 'score_power';
        } elseif ($countTeamPenalty > $countOpponentPenalty && 2 > $countOpponentPenalty) {
            $powerShort = 'score_short';
        }

        if ($this->result[$team]['team']['score']['total'] == $this->result[$opponent]['team']['score']['total']) {
            $draw = 'score_draw';
        }

        $countEvent = count($this->result['event']);
        $player = $this->getFieldKeyByPosition($this->result['player']);

        if ($powerShort) {
            $this->result[$team]['player']['field'][$player][$powerShort]++;
        }

        if ($draw) {
            $this->result[$team]['player']['field'][$player][$draw]++;
        }

        $this->result[$team]['player']['field'][$player]['score']++;
        $eventPlayerId = $this->result[$team]['player']['field'][$player]['player_id'];
        $this->result['event'][$countEvent - 1]['event_player_score_id'] = $eventPlayerId;
        $this->result[$team]['team']['score']['last']['score'] = $player;
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function playerAssist1Increase($team, $opponent): void
    {
        $powerShort = '';
        $countTeamPenalty = count($this->result[$team]['team']['penalty']['current']);
        $countOpponentPenalty = count($this->result[$opponent]['team']['penalty']['current']);

        if ($countTeamPenalty < $countOpponentPenalty && 2 > $countTeamPenalty) {
            $powerShort = 'assist_power';
        } elseif ($countTeamPenalty > $countOpponentPenalty && 2 > $countOpponentPenalty) {
            $powerShort = 'assist_short';
        }

        $countEvent = count($this->result['event']);
        $player = $this->getFieldKeyByPosition($this->result['assist_1']);

        if ($powerShort) {
            $this->result[$team]['player']['field'][$player][$powerShort]++;
        }

        $this->result[$team]['player']['field'][$player]['assist']++;
        $eventPlayerId = $this->result[$team]['player']['field'][$player]['player_id'];
        $this->result['event'][$countEvent - 1]['event_player_assist_1_id'] = $eventPlayerId;
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function playerAssist2Increase($team, $opponent): void
    {
        $powerShort = '';
        $countTeamPenalty = count($this->result[$team]['team']['penalty']['current']);
        $countOpponentPenalty = count($this->result[$opponent]['team']['penalty']['current']);

        if ($countTeamPenalty < $countOpponentPenalty && 2 > $countTeamPenalty) {
            $powerShort = 'assist_power';
        } elseif ($countTeamPenalty > $countOpponentPenalty && 2 > $countOpponentPenalty) {
            $powerShort = 'assist_short';
        }

        $countEvent = count($this->result['event']);
        if (Position::GK == $this->result['assist_2']) {
            if ($powerShort) {
                $this->result[$team]['player']['gk'][$powerShort]++;
            }

            $this->result[$team]['player']['gk']['assist']++;
            $eventPlayerId = $this->result[$team]['player']['gk']['player_id'];
            $this->result['event'][$countEvent - 1]['event_player_assist_2_id'] = $eventPlayerId;
        } else {
            $player = $this->getFieldKeyByPosition($this->result['assist_2']);

            if ($powerShort) {
                $this->result[$team]['player']['field'][$player][$powerShort]++;
            }

            $this->result[$team]['player']['field'][$player]['assist']++;
            $eventPlayerId = $this->result[$team]['player']['field'][$player]['player_id'];
            $this->result['event'][$countEvent - 1]['event_player_assist_2_id'] = $eventPlayerId;
        }
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return void
     */
    private function currentPenaltyDecreaseAfterGoal(string $team, string $opponent): void
    {
        $countTeamPenalty = count($this->result[$team]['team']['penalty']['current']);
        $countOpponentPenalty = count($this->result[$opponent]['team']['penalty']['current']);

        if ($countTeamPenalty <= $countOpponentPenalty || 2 <= $countTeamPenalty) {
            return;
        }

        $penaltyArrayOld = $this->result[$opponent]['team']['penalty']['current'];
        $penaltyArrayNew = [];

        $countPenalty = count($penaltyArrayOld);

        for ($i = 0; $i < $countPenalty; $i++) {
            if ($i > 1) {
                $penaltyArrayNew[] = [
                    'minute' => $this->result['minute'],
                    'position' => $penaltyArrayOld[$i]['position'],
                ];
            } elseif (0 != $i) {
                $penaltyArrayNew[] = $penaltyArrayOld[$i];
            }
        }

        $this->result[$opponent]['team']['penalty']['current'] = $penaltyArrayNew;
    }

    /**
     * @return bool
     */
    private function getContinue(): bool
    {
        $result = false;

        $ifScoreEquals = ($this->result['home']['team']['score']['total'] == $this->result['guest']['team']['score']['total']);
        $ifIsLeague = (TournamentType::LEAGUE == $this->game->schedule->schedule_tournament_type_id);
        $ifGroup = in_array($this->game->schedule->schedule_stage_id, [
            Stage::TOUR_LEAGUE_1,
            Stage::TOUR_LEAGUE_2,
            Stage::TOUR_LEAGUE_3,
            Stage::TOUR_LEAGUE_4,
            Stage::TOUR_LEAGUE_5,
            Stage::TOUR_LEAGUE_6,
        ]);
        $ifKnockOut = in_array($this->game->schedule->schedule_stage_id, [
            Stage::QUALIFY_1,
            Stage::QUALIFY_2,
            Stage::QUALIFY_3,
            Stage::ROUND_OF_16,
            Stage::QUARTER,
            Stage::SEMI,
            Stage::FINAL,
        ]);

        if ($ifScoreEquals && !$ifIsLeague) {
            $result = true;
        } elseif ($ifScoreEquals && $ifIsLeague && $ifGroup) {
            $result = true;
        } elseif ($ifGroup && $ifKnockOut) {
            $prev = Game::find()
                ->joinWith(['schedule'])
                ->where([
                    'or',
                    [
                        'game_guest_team_id' => $this->game->game_guest_team_id,
                        'game_home_team_id' => $this->game->game_home_team_id
                    ],
                    [
                        'game_home_team_id' => $this->game->game_guest_team_id,
                        'game_guest_team_id' => $this->game->game_home_team_id
                    ],
                ])
                ->andWhere([
                    'schedule_season_id' => $this->game->schedule->schedule_season_id,
                    'schedule_tournament_type_id' => $this->game->schedule->schedule_tournament_type_id,
                    'schedule_stage_id' => $this->game->schedule->schedule_stage_id,
                    'game_played' => 1,
                ])
                ->limit(1)
                ->one();

            if ($prev) {
                if ($this->game->game_home_team_id == $prev->game_home_team_id) {
                    $homeScoreWithPrev = $this->result['home']['team']['score']['total'] + $prev->game_home_score + $prev->game_home_score_shootout;
                    $guestScoreWithPrev = $this->result['guest']['team']['score']['total'] + $prev->game_guest_score + $prev->game_guest_score_shootout;
                } else {
                    $homeScoreWithPrev = $this->result['home']['team']['score']['total'] + $prev->game_guest_score + $prev->game_guest_score_shootout;
                    $guestScoreWithPrev = $this->result['guest']['team']['score']['total'] + $prev->game_home_score + $prev->game_home_score_shootout;
                }

                if ($homeScoreWithPrev == $guestScoreWithPrev) {
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * @return void
     */
    private function gameWithBullet(): void
    {
        $this->result['home']['player']['gk']['game_with_shootout'] = 1;
        $this->result['guest']['player']['gk']['game_with_shootout'] = 1;
    }

    /**
     * @return void
     */
    private function generateShootout(): void
    {
        $guestPowerArray = [];
        $homePowerArray = [];

        for ($j = 1; $j <= 20; $j++) {
            if (1 == $j) {
                $key = 'ld_1';
            } elseif (2 == $j) {
                $key = 'rd_1';
            } elseif (3 == $j) {
                $key = 'lw_1';
            } elseif (4 == $j) {
                $key = 'cf_1';
            } elseif (5 == $j) {
                $key = 'rw_1';
            } elseif (6 == $j) {
                $key = 'ld_2';
            } elseif (7 == $j) {
                $key = 'rd_2';
            } elseif (8 == $j) {
                $key = 'lw_2';
            } elseif (9 == $j) {
                $key = 'cf_2';
            } elseif (10 == $j) {
                $key = 'rw_2';
            } elseif (11 == $j) {
                $key = 'ld_3';
            } elseif (12 == $j) {
                $key = 'rd_3';
            } elseif (13 == $j) {
                $key = 'lw_3';
            } elseif (14 == $j) {
                $key = 'cf_3';
            } elseif (15 == $j) {
                $key = 'rw_3';
            } elseif (16 == $j) {
                $key = 'ld_4';
            } elseif (17 == $j) {
                $key = 'rd_4';
            } elseif (18 == $j) {
                $key = 'lw_4';
            } elseif (19 == $j) {
                $key = 'cf_4';
            } else {
                $key = 'rw_4';
            }

            $guestPowerArray[] = array($key, $this->result['guest']['player']['field'][$key]['power_real']);
            $homePowerArray[] = array($key, $this->result['home']['player']['field'][$key]['power_real']);
        }

        usort($guestPowerArray, function ($a, $b) {
            return $a[1] > $b[1] ? -1 : 1;
        });

        usort($homePowerArray, function ($a, $b) {
            return $a[1] > $b[1] ? -1 : 1;
        });

        $continue = true;

        while ($continue) {
            $this->result['minute']++;

            $key = ($this->result['minute'] - 5) % 20;

            $shotPower = $homePowerArray[$key][1];
            $gkPower = $this->result['guest']['team']['power']['gk'];

            if (rand(0, $shotPower) > rand(0, $gkPower)) {
                $this->teamScoreShootoutIncrease('home');
                $this->eventShootout('home', EventTextShootout::SCORE, $homePowerArray[$key][0]);
                $this->result['home']['team']['score']['last']['shootout'] = $homePowerArray[$key][0];
            } else {
                $this->eventShootout('home', EventTextShootout::NO_SCORE, $homePowerArray[$key][0]);
            }

            $shotPower = $guestPowerArray[$key][1];
            $gkPower = $this->result['home']['team']['power']['gk'];

            if (rand(0, $shotPower) > rand(0, $gkPower)) {
                $this->teamScoreShootoutIncrease('guest');
                $this->eventShootout('guest', EventTextShootout::SCORE, $guestPowerArray[$key][0]);
                $this->result['guest']['team']['score']['last']['shootout'] = $guestPowerArray[$key][0];
            } else {
                $this->eventShootout('guest', EventTextShootout::NO_SCORE, $guestPowerArray[$key][0]);
            }

            if ($this->result['home']['team']['score']['shootout'] != $this->result['guest']['team']['score']['shootout']) {
                $continue = false;
            }
        }
    }

    /**
     * @param string $team
     * @return void
     */
    private function teamScoreShootoutIncrease(string $team): void
    {
        $this->result[$team]['team']['score']['shootout']++;
    }

    /**
     * @param string $team
     * @param int $eventTextBulletId
     * @param string $playerKey
     * @return void
     */
    private function eventShootout(string $team, int $eventTextBulletId, string $playerKey): void
    {
        $this->result['event'][] = [
            'event_event_text_goal_id' => 0,
            'event_event_text_penalty_id' => 0,
            'event_event_text_shootout_id' => $eventTextBulletId,
            'event_event_type_id' => EventType::SHOOTOUT,
            'event_game_id' => $this->result['game_info']['game_id'],
            'event_guest_score' => $this->result['guest']['team']['score']['total'] + $this->result['guest']['team']['score']['shootout'],
            'event_home_score' => $this->result['home']['team']['score']['total'] + $this->result['home']['team']['score']['shootout'],
            'event_minute' => $this->result['minute'],
            'event_national_id' => $this->result['game_info'][$team . '_national_id'],
            'event_player_assist_1_id' => 0,
            'event_player_assist_2_id' => 0,
            'event_player_score_id' => $this->result[$team]['player']['field'][$playerKey]['player_id'],
            'event_player_penalty_id' => 0,
            'event_second' => 0,
            'event_team_id' => $this->result['game_info'][$team . '_team_id'],
        ];
    }

    /**
     * @return void
     */
    private function calculateStatistic(): void
    {
        if ($this->result['home']['team']['score']['total'] == $this->result['guest']['team']['score']['total']) {
            if ($this->result['home']['team']['score']['shootout'] > $this->result['guest']['team']['score']['shootout']) {
                $this->result['home']['team']['win_shootout'] = 1;
                $this->result['guest']['team']['loose_shootout'] = 1;
                $this->result['home']['player']['field'][$this->result['home']['team']['score']['last']['shootout']]['bullet_win'] = 1;
                $win = 'home';
                $loose = 'guest';
            } else {
                $this->result['guest']['team']['win_shootout'] = 1;
                $this->result['home']['team']['loose_shootout'] = 1;
                $this->result['guest']['player']['field'][$this->result['guest']['team']['score']['last']['shootout']]['bullet_win'] = 1;
                $win = 'guest';
                $loose = 'home';
            }
        } elseif ($this->result['home']['team']['score']['total'] > $this->result['guest']['team']['score']['total']) {
            if (0 != $this->result['home']['team']['score']['overtime']) {
                $this->result['home']['team']['win_overtime'] = 1;
                $this->result['guest']['team']['loose_overtime'] = 1;
                $this->result['home']['player']['field'][$this->result['home']['team']['score']['last']['score']]['score_win'] = 1;
            } else {
                $this->result['home']['team']['win'] = 1;
                $this->result['guest']['team']['loose'] = 1;
                $this->result['home']['player']['field'][$this->result['home']['team']['score']['last']['score']]['score_win'] = 1;
            }

            $win = 'home';
            $loose = 'guest';
        } else {
            if (0 != $this->result['guest']['team']['score']['overtime']) {
                $this->result['guest']['team']['win_overtime'] = 1;
                $this->result['home']['team']['loose_overtime'] = 1;
                $this->result['guest']['player']['field'][$this->result['guest']['team']['score']['last']['score']]['score_win'] = 1;
            } else {
                $this->result['guest']['team']['win'] = 1;
                $this->result['home']['team']['loose'] = 1;
                $this->result['guest']['player']['field'][$this->result['guest']['team']['score']['last']['score']]['score_win'] = 1;
            }

            $loose = 'home';
            $win = 'guest';
        }

        $this->result[$win]['player']['gk']['win'] = 1;

        for ($j = 1; $j <= 4; $j++) {
            for ($k = Position::LD; $k <= Position::RW; $k++) {
                if (Position::LD == $k) {
                    $key = 'ld';
                } elseif (Position::RD == $k) {
                    $key = 'rd';
                } elseif (Position::LW == $k) {
                    $key = 'lw';
                } elseif (Position::CF == $k) {
                    $key = 'cf';
                } else {
                    $key = 'rw';
                }

                $key = $key . '_' . $j;

                $this->result[$win]['player']['field'][$key]['win'] = 1;
            }
        }

        $this->result[$loose]['player']['gk']['loose'] = 1;

        for ($j = 1; $j <= 4; $j++) {
            for ($k = Position::LD; $k <= Position::RW; $k++) {
                if (Position::LD == $k) {
                    $key = 'ld';
                } elseif (Position::RD == $k) {
                    $key = 'rd';
                } elseif (Position::LW == $k) {
                    $key = 'lw';
                } elseif (Position::CF == $k) {
                    $key = 'cf';
                } else {
                    $key = 'rw';
                }

                $key = $key . '_' . $j;

                $this->result[$loose]['player']['field'][$key]['loose'] = 1;
            }
        }

        $this->result['home']['player']['gk']['point'] = $this->result['home']['player']['gk']['assist'];
        $this->result['guest']['player']['gk']['point'] = $this->result['guest']['player']['gk']['assist'];

        for ($j = 1; $j <= 4; $j++) {
            for ($k = Position::LD; $k <= Position::RW; $k++) {
                if (Position::LD == $k) {
                    $key = 'ld';
                } elseif (Position::RD == $k) {
                    $key = 'rd';
                } elseif (Position::LW == $k) {
                    $key = 'lw';
                } elseif (Position::CF == $k) {
                    $key = 'cf';
                } else {
                    $key = 'rw';
                }

                $key = $key . '_' . $j;

                $this->result['home']['player']['field'][$key]['point'] =
                    $this->result['home']['player']['field'][$key]['assist'] +
                    $this->result['home']['player']['field'][$key]['score'];

                $this->result['guest']['player']['field'][$key]['point'] =
                    $this->result['guest']['player']['field'][$key]['assist'] +
                    $this->result['guest']['player']['field'][$key]['score'];
            }
        }

        $this->result['home']['player']['gk']['save'] =
            $this->result['home']['player']['gk']['shot'] -
            $this->result['home']['player']['gk']['pass'];

        $this->result['guest']['player']['gk']['save'] =
            $this->result['guest']['player']['gk']['shot'] -
            $this->result['guest']['player']['gk']['pass'];

        if (0 == $this->result['home']['team']['score']['total']) {
            $this->result['guest']['player']['gk']['shootout'] = 1;
            $this->result['guest']['team']['no_pass'] = 1;
            $this->result['home']['team']['no_score'] = 1;
        }

        if (0 == $this->result['guest']['team']['score']['total']) {
            $this->result['home']['player']['gk']['shootout'] = 1;
            $this->result['home']['team']['no_pass'] = 1;
            $this->result['guest']['team']['no_score'] = 1;
        }

        $this->result['guest']['team']['penalty']['opponent'] = $this->result['home']['team']['penalty']['total'];
        $this->result['home']['team']['penalty']['opponent'] = $this->result['guest']['team']['penalty']['total'];
        $this->result['guest']['team']['pass'] = $this->result['home']['team']['score']['total'];
        $this->result['home']['team']['pass'] = $this->result['guest']['team']['score']['total'];
    }

    /**
     * @return void
     */
    private function toDataBase(): void
    {
        $this->gameToDataBase();
        $this->eventToDataBase();
        $this->lineupToDataBase();
        $this->statisticToDataBase();
    }

    /**
     * @return void
     */
    public function gameToDataBase(): void
    {
        $this->game->game_guest_collision_1 = $this->result['guest']['team']['collision'][1];
        $this->game->game_guest_collision_2 = $this->result['guest']['team']['collision'][2];
        $this->game->game_guest_collision_3 = $this->result['guest']['team']['collision'][3];
        $this->game->game_guest_collision_4 = $this->result['guest']['team']['collision'][4];
        $this->game->game_guest_forecast = $this->result['guest']['team']['power']['forecast'];
        $this->game->game_guest_optimality_1 = $this->result['guest']['team']['optimality_1'];
        $this->game->game_guest_optimality_2 = $this->result['guest']['team']['optimality_2'];
        $this->game->game_guest_penalty = $this->result['guest']['team']['penalty']['total'] * 2;
        $this->game->game_guest_penalty_1 = $this->result['guest']['team']['penalty'][1] * 2;
        $this->game->game_guest_penalty_2 = $this->result['guest']['team']['penalty'][2] * 2;
        $this->game->game_guest_penalty_3 = $this->result['guest']['team']['penalty'][3] * 2;
        $this->game->game_guest_penalty_overtime = $this->result['guest']['team']['penalty']['overtime'] * 2;
        $this->game->game_guest_power = $this->result['guest']['team']['power']['total'];
        $this->game->game_guest_power_percent = $this->result['guest']['team']['power']['percent'];
        $this->game->game_guest_score = $this->result['guest']['team']['score']['total'];
        $this->game->game_guest_score_1 = $this->result['guest']['team']['score'][1];
        $this->game->game_guest_score_2 = $this->result['guest']['team']['score'][2];
        $this->game->game_guest_score_3 = $this->result['guest']['team']['score'][3];
        $this->game->game_guest_score_shootout = $this->result['guest']['team']['score']['shootout'];
        $this->game->game_guest_score_overtime = $this->result['guest']['team']['score']['overtime'];
        $this->game->game_guest_shot = $this->result['guest']['team']['shot']['total'];
        $this->game->game_guest_shot_1 = $this->result['guest']['team']['shot'][1];
        $this->game->game_guest_shot_2 = $this->result['guest']['team']['shot'][2];
        $this->game->game_guest_shot_3 = $this->result['guest']['team']['shot'][3];
        $this->game->game_guest_shot_overtime = $this->result['guest']['team']['shot']['overtime'];
        $this->game->game_guest_teamwork_1 = $this->result['guest']['team']['teamwork'][1];
        $this->game->game_guest_teamwork_2 = $this->result['guest']['team']['teamwork'][2];
        $this->game->game_guest_teamwork_3 = $this->result['guest']['team']['teamwork'][3];
        $this->game->game_guest_teamwork_4 = $this->result['guest']['team']['teamwork'][4];
        $this->game->game_home_collision_1 = $this->result['home']['team']['collision'][1];
        $this->game->game_home_collision_2 = $this->result['home']['team']['collision'][2];
        $this->game->game_home_collision_3 = $this->result['home']['team']['collision'][3];
        $this->game->game_home_collision_4 = $this->result['home']['team']['collision'][4];
        $this->game->game_home_forecast = $this->result['home']['team']['power']['forecast'];
        $this->game->game_home_optimality_1 = $this->result['home']['team']['optimality_1'];
        $this->game->game_home_optimality_2 = $this->result['home']['team']['optimality_2'];
        $this->game->game_home_penalty = $this->result['home']['team']['penalty']['total'] * 2;
        $this->game->game_home_penalty_1 = $this->result['home']['team']['penalty'][1] * 2;
        $this->game->game_home_penalty_2 = $this->result['home']['team']['penalty'][2] * 2;
        $this->game->game_home_penalty_3 = $this->result['home']['team']['penalty'][3] * 2;
        $this->game->game_home_penalty_overtime = $this->result['home']['team']['penalty']['overtime'] * 2;
        $this->game->game_home_power = $this->result['home']['team']['power']['total'];
        $this->game->game_home_power_percent = $this->result['home']['team']['power']['percent'];
        $this->game->game_home_score = $this->result['home']['team']['score']['total'];
        $this->game->game_home_score_1 = $this->result['home']['team']['score'][1];
        $this->game->game_home_score_2 = $this->result['home']['team']['score'][2];
        $this->game->game_home_score_3 = $this->result['home']['team']['score'][3];
        $this->game->game_home_score_shootout = $this->result['home']['team']['score']['shootout'];
        $this->game->game_home_score_overtime = $this->result['home']['team']['score']['overtime'];
        $this->game->game_home_shot = $this->result['home']['team']['shot']['total'];
        $this->game->game_home_shot_1 = $this->result['home']['team']['shot'][1];
        $this->game->game_home_shot_2 = $this->result['home']['team']['shot'][2];
        $this->game->game_home_shot_3 = $this->result['home']['team']['shot'][3];
        $this->game->game_home_shot_overtime = $this->result['home']['team']['shot']['overtime'];
        $this->game->game_home_teamwork_1 = $this->result['home']['team']['teamwork'][1];
        $this->game->game_home_teamwork_2 = $this->result['home']['team']['teamwork'][2];
        $this->game->game_home_teamwork_3 = $this->result['home']['team']['teamwork'][3];
        $this->game->game_home_teamwork_4 = $this->result['home']['team']['teamwork'][4];
        $this->game->save();
    }

    /**
     * @return void
     */
    private function eventToDataBase(): void
    {
        foreach ($this->result['event'] as $event) {
            Event::log($event);
        }
    }

    /**
     * @return void
     */
    private function lineupToDataBase(): void
    {
        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            if ($this->result[$team]['player']['gk']['lineup_id']) {
                $model = Lineup::find()
                    ->where(['lineup_id' => $this->result[$team]['player']['gk']['lineup_id']])
                    ->limit(1)
                    ->one();
                if ($model) {
                    $model->lineup_age = $this->result[$team]['player']['gk']['age'];
                    $model->lineup_assist = $this->result[$team]['player']['gk']['assist'];
                    $model->lineup_pass = $this->result[$team]['player']['gk']['pass'];
                    $model->lineup_power_nominal = $this->result[$team]['player']['gk']['power_nominal'];
                    $model->lineup_power_real = $this->result[$team]['player']['gk']['power_real'];
                    $model->lineup_shot = $this->result[$team]['player']['gk']['shot'];
                    $model->save();
                }
            }

            foreach ($this->result[$team]['player']['field'] as $player) {
                if ($player['lineup_id']) {
                    $model = Lineup::find()->where(['lineup_id' => $player['lineup_id']])->limit(1)->one();
                    if ($model) {
                        $model->lineup_age = $player['age'];
                        $model->lineup_assist = $player['assist'];
                        $model->lineup_penalty = $player['penalty'] * 2;
                        $model->lineup_plus_minus = $player['plus_minus'];
                        $model->lineup_power_nominal = $player['power_nominal'];
                        $model->lineup_power_real = $player['power_real'];
                        $model->lineup_score = $player['score'];
                        $model->lineup_shot = $player['shot'];
                        $model->save();
                    }
                }
            }
        }
    }

    /**
     * @return void
     */
    private function statisticToDataBase(): void
    {
        $countryId = $this->game->teamHome->championship->championship_country_id ?? 0;
        $divisionId = $this->game->teamHome->championship->championship_division_id ?? 0;

        if (in_array($this->game->schedule->schedule_tournament_type_id, [
            TournamentType::FRIENDLY,
            TournamentType::CONFERENCE,
            TournamentType::LEAGUE,
            TournamentType::OFF_SEASON,
        ])) {
            $countryId = 0;
            $divisionId = 0;
        }

        if (TournamentType::NATIONAL == $this->game->schedule->schedule_tournament_type_id) {
            $divisionId = $this->game->nationalHome->worldCup->world_cup_division_id ?? 0;
        }

        if (TournamentType::CHAMPIONSHIP == $this->game->schedule->schedule_tournament_type_id && $this->game->schedule->schedule_stage_id >= Stage::ROUND_OF_16) {
            $is_playoff = 1;
        } else {
            $is_playoff = 0;
        }

        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $team = 'home';
            } else {
                $team = 'guest';
            }

            if ($this->result[$team]['player']['gk']['player_id']) {
                $model = StatisticPlayer::find()->where([
                    'statistic_player_championship_playoff' => $is_playoff,
                    'statistic_player_country_id' => $countryId,
                    'statistic_player_division_id' => $divisionId,
                    'statistic_player_is_gk' => 1,
                    'statistic_player_national_id' => $this->result['game_info'][$team . '_national_id'],
                    'statistic_player_player_id' => $this->result[$team]['player']['gk']['player_id'],
                    'statistic_player_season_id' => $this->game->schedule->schedule_season_id,
                    'statistic_player_team_id' => $this->result['game_info'][$team . '_team_id'],
                    'statistic_player_tournament_type_id' => $this->game->schedule->schedule_tournament_type_id,
                ])->limit(1)->one();
                if ($model) {
                    $model->statistic_player_assist = $model->statistic_player_assist + $this->result[$team]['player']['gk']['assist'];
                    $model->statistic_player_assist_power = $model->statistic_player_assist_power + $this->result[$team]['player']['gk']['assist_power'];
                    $model->statistic_player_assist_short = $model->statistic_player_assist_short + $this->result[$team]['player']['gk']['assist_short'];
                    $model->statistic_player_game = $model->statistic_player_game + $this->result[$team]['player']['gk']['game'];
                    $model->statistic_player_game_with_bullet = $model->statistic_player_game_with_bullet + $this->result[$team]['player']['gk']['game_with_shootout'];
                    $model->statistic_player_loose = $model->statistic_player_loose + $this->result[$team]['player']['gk']['loose'];
                    $model->statistic_player_pass = $model->statistic_player_pass + $this->result[$team]['player']['gk']['pass'];
                    $model->statistic_player_point = $model->statistic_player_point + $this->result[$team]['player']['gk']['point'];
                    $model->statistic_player_save = $model->statistic_player_save + $this->result[$team]['player']['gk']['save'];
                    $model->statistic_player_shot_gk = $model->statistic_player_shot_gk + $this->result[$team]['player']['gk']['shot'];
                    $model->statistic_player_shutout = $model->statistic_player_shutout + $this->result[$team]['player']['gk']['shootout'];
                    $model->statistic_player_win = $model->statistic_player_win + $this->result[$team]['player']['gk']['win'];
                    $model->save();
                }
            }

            foreach ($this->result[$team]['player']['field'] as $player) {
                if ($player['player_id']) {
                    $model = StatisticPlayer::find()->where([
                        'statistic_player_championship_playoff' => $is_playoff,
                        'statistic_player_country_id' => $countryId,
                        'statistic_player_division_id' => $divisionId,
                        'statistic_player_is_gk' => 0,
                        'statistic_player_national_id' => $this->result['game_info'][$team . '_national_id'],
                        'statistic_player_player_id' => $player['player_id'],
                        'statistic_player_season_id' => $this->game->schedule->schedule_season_id,
                        'statistic_player_team_id' => $this->result['game_info'][$team . '_team_id'],
                        'statistic_player_tournament_type_id' => $this->game->schedule->schedule_tournament_type_id,
                    ])->limit(1)->one();
                    if ($model) {
                        $model->statistic_player_assist = $model->statistic_player_assist + $player['assist'];
                        $model->statistic_player_assist_power = $model->statistic_player_assist_power + $player['assist_power'];
                        $model->statistic_player_assist_short = $model->statistic_player_assist_short + $player['assist_short'];
                        $model->statistic_player_bullet_win = $model->statistic_player_bullet_win + $player['bullet_win'];
                        $model->statistic_player_face_off = $model->statistic_player_face_off + $player['face_off'];
                        $model->statistic_player_face_off_win = $model->statistic_player_face_off_win + $player['face_off_win'];
                        $model->statistic_player_game = $model->statistic_player_game + $player['game'];
                        $model->statistic_player_loose = $model->statistic_player_loose + $player['loose'];
                        $model->statistic_player_penalty = $model->statistic_player_penalty + $player['penalty'] * 2;
                        $model->statistic_player_plus_minus = $model->statistic_player_plus_minus + $player['plus_minus'];
                        $model->statistic_player_point = $model->statistic_player_point + $player['point'];
                        $model->statistic_player_score = $model->statistic_player_score + $player['score'];
                        $model->statistic_player_score_draw = $model->statistic_player_score_draw + $player['score_draw'];
                        $model->statistic_player_score_power = $model->statistic_player_score_power + $player['score_power'];
                        $model->statistic_player_score_short = $model->statistic_player_score_short + $player['score_short'];
                        $model->statistic_player_score_win = $model->statistic_player_score_win + $player['score_win'];
                        $model->statistic_player_shot = $model->statistic_player_shot + $player['shot'];
                        $model->statistic_player_win = $model->statistic_player_win + $player['win'];
                        $model->save();
                    }
                }
            }

            $model = StatisticTeam::find()->where([
                'statistic_team_championship_playoff' => $is_playoff,
                'statistic_team_country_id' => $countryId,
                'statistic_team_division_id' => $divisionId,
                'statistic_team_national_id' => $this->result['game_info'][$team . '_national_id'],
                'statistic_team_season_id' => $this->game->schedule->schedule_season_id,
                'statistic_team_team_id' => $this->result['game_info'][$team . '_team_id'],
                'statistic_team_tournament_type_id' => $this->game->schedule->schedule_tournament_type_id,
            ])->limit(1)->one();
            if ($model) {
                $model->statistic_team_game = $model->statistic_team_game + $this->result[$team]['team']['game'];
                $model->statistic_team_game_no_pass = $model->statistic_team_game_no_pass + $this->result[$team]['team']['no_pass'];
                $model->statistic_team_game_no_score = $model->statistic_team_game_no_score + $this->result[$team]['team']['no_score'];
                $model->statistic_team_loose = $model->statistic_team_loose + $this->result[$team]['team']['loose'];
                $model->statistic_team_loose_over = $model->statistic_team_loose_over + $this->result[$team]['team']['loose_overtime'];
                $model->statistic_team_loose_shootout = $model->statistic_team_loose_shootout + $this->result[$team]['team']['loose_shootout'];
                $model->statistic_team_pass = $model->statistic_team_pass + $this->result[$team]['team']['pass'];
                $model->statistic_team_penalty_minute = $model->statistic_team_penalty_minute + $this->result[$team]['team']['penalty']['total'] * 2;
                $model->statistic_team_penalty_minute_opponent = $model->statistic_team_penalty_minute_opponent + $this->result[$team]['team']['penalty']['total'] * 2;
                $model->statistic_team_score = $model->statistic_team_score + $this->result[$team]['team']['score']['total'];
                $model->statistic_team_win = $model->statistic_team_win + $this->result[$team]['team']['win'];
                $model->statistic_team_win_over = $model->statistic_team_win_over + $this->result[$team]['team']['win_overtime'];
                $model->statistic_team_win_shootout = $model->statistic_team_win_shootout + $this->result[$team]['team']['win_shootout'];
                $model->save();
            }
        }
    }
}
