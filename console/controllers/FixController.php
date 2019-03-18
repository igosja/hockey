<?php

namespace console\controllers;

use common\components\ErrorHelper;
use common\models\City;
use common\models\Conference;
use common\models\Country;
use common\models\Event;
use common\models\EventType;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Game;
use common\models\Lineup;
use common\models\Name;
use common\models\NameCountry;
use common\models\OffSeason;
use common\models\Position;
use common\models\Schedule;
use common\models\Season;
use common\models\Stadium;
use common\models\Stage;
use common\models\StatisticPlayer;
use common\models\Surname;
use common\models\SurnameCountry;
use common\models\Team;
use common\models\TournamentType;
use console\models\generator\InsertSwiss;
use Exception;
use Yii;
use yii\db\Expression;

/**
 * Class FixController
 * @package console\controllers
 */
class FixController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function actionFinance()
    {
        $teamArray = Team::find()
            ->select(['team_id', 'team_finance'])
            ->where(['!=', 'team_id', 0])
            ->each();
        foreach ($teamArray as $team) {
            $value = 0;
            /**
             * @var Team $team
             */
            $financeArray = Finance::find()
                ->where(['finance_team_id' => $team->team_id])
                ->orderBy(['finance_id' => SORT_ASC])
                ->all();
            foreach ($financeArray as $finance) {
                $finance->finance_value_before = $value;
                $finance->finance_value_after = $value + $finance->finance_value;

                if (FinanceText::TEAM_RE_REGISTER == $finance->finance_finance_text_id) {
                    $finance->finance_value = Team::START_MONEY - $value;
                    $finance->finance_value_after = Team::START_MONEY;
                }

                $finance->save(true, ['finance_value_before', 'finance_value_after', 'finance_value']);
                $value = $finance->finance_value_after;
            }
            $team->team_finance = $value;
            $team->save(true, ['team_finance']);
        }
    }

    /**
     * @throws \Exception
     */
    public function actionStat()
    {
        \Yii::$app->db->createCommand()->truncateTable(StatisticPlayer::tableName())->execute();
        $gameArray = Game::find()
            ->where(['!=', 'game_played', 0])
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $this->stdout('Начинаем игру ' . $game->game_id . '...' . PHP_EOL);
            $lineupArray = [];
            foreach ($game->lineup as $lineup) {
                if ($lineup->lineup_position_id == Position::GK && $lineup->lineup_line_id) {
                    continue;
                }
                $lineupArray[$lineup->lineup_player_id] = [
                    'lineup_id' => $lineup->lineup_id,
                    'lineup_team_id' => $lineup->lineup_team_id,
                    'lineup_position_id' => $lineup->lineup_position_id,
                    'lineup_player_id' => $lineup->lineup_player_id,
                    'lineup_line_id' => $lineup->lineup_line_id,
                    'assist' => 0,
                    'assist_power' => 0,
                    'assist_short' => 0,
                    'face_off' => 0,
                    'face_off_win' => 0,
                    'game_with_shootout' => 0,
                    'loose' => 0,
                    'pass' => 0,
                    'penalty' => $lineup->lineup_penalty,
                    'plus_minus' => $lineup->lineup_plus_minus,
                    'point' => 0,
                    'save' => 0,
                    'score' => 0,
                    'score_draw' => 0,
                    'score_power' => 0,
                    'score_short' => 0,
                    'score_win' => 0,
                    'shot' => $lineup->lineup_shot,
                    'shot_gk' => 0,
                    'shutout' => 0,
                    'shootout_win' => 0,
                    'win' => 0,
                ];
            }

            $eventArray = Event::find()
                ->where(['event_game_id' => $game->game_id])
                ->orderBy(['event_id' => SORT_ASC])
                ->all();
            foreach ($eventArray as $event) {
                if (EventType::GOAL == $event->event_event_type_id) {
                    if ($event->event_player_assist_1_id == $event->event_player_score_id) {
                        $event->event_player_assist_1_id = 0;
                        $event->event_player_assist_2_id = 0;
                        $event->save(true, ['event_player_assist_1_id', 'event_player_assist_2_id']);
                    } elseif (in_array($event->event_player_assist_2_id,
                        [$event->event_player_score_id, $event->event_player_assist_1_id])) {
                        $event->event_player_assist_2_id = 0;
                        $event->save(true, ['event_player_assist_2_id']);
                    }
                }
            }

            $eventArray = Event::find()
                ->where(['event_game_id' => $game->game_id])
                ->orderBy(['event_id' => SORT_ASC])
                ->all();
            $result = [
                'penalty' => [
                    'home' => [
                        'total' => 0,
                        'minute' => [],
                    ],
                    'guest' => [
                        'total' => 0,
                        'minute' => [],
                    ],
                ]
            ];
            $scoreWinId = 0;
            $shootOutWinId = 0;
            for ($i = 0; $i < 100; $i++) {
                if (isset($result['penalty']['home']['minute'][0]) && $result['penalty']['home']['minute'][0] + 2 == $i) {
                    unset($result['penalty']['home']['minute'][0]);
                    $result['penalty']['home']['total']--;
                }
                if (isset($result['penalty']['guest']['minute'][0]) && $result['penalty']['guest']['minute'][0] + 2 == $i) {
                    unset($result['penalty']['guest']['minute'][0]);
                    $result['penalty']['guest']['total']--;
                }
                $result['penalty']['home']['minute'] = array_values($result['penalty']['home']['minute']);
                $result['penalty']['guest']['minute'] = array_values($result['penalty']['guest']['minute']);
                foreach ($eventArray as $event) {
                    if ($event->event_minute != $i) {
                        continue;
                    }
                    if (EventType::PENALTY == $event->event_event_type_id) {
                        if ($event->event_team_id == $game->game_home_team_id) {
                            $team = 'home';
                        } else {
                            $team = 'guest';
                        }
                        $result['penalty'][$team]['total']++;
                        $result['penalty'][$team]['minute'][] = $event->event_minute;
                    }
                    if (EventType::GOAL == $event->event_event_type_id) {
                        $lineupArray[$event->event_player_score_id]['score']++;
                        if ($event->event_team_id == $game->game_home_team_id) {
                            $team = 'home';
                            $opponent = 'guest';
                        } else {
                            $team = 'guest';
                            $opponent = 'home';
                        }

                        if ($result['penalty'][$team]['total'] > $result['penalty'][$opponent]['total'] && $result['penalty'][$opponent]['total'] < 2) {
                            $lineupArray[$event->event_player_score_id]['score_short']++;
                        }
                        if ($result['penalty'][$team]['total'] < $result['penalty'][$opponent]['total'] && $result['penalty'][$team]['total'] < 2) {
                            $lineupArray[$event->event_player_score_id]['score_power']++;
                        }

                        if ($event->event_home_score == $event->event_guest_score) {
                            $lineupArray[$event->event_player_score_id]['score_draw']++;
                        }
                        if ($event->event_player_assist_1_id) {
                            $lineupArray[$event->event_player_assist_1_id]['assist']++;

                            if ($result['penalty'][$team]['total'] > $result['penalty'][$opponent]['total'] && $result['penalty'][$opponent]['total'] < 2) {
                                $lineupArray[$event->event_player_assist_1_id]['assist_short']++;
                            }
                            if ($result['penalty'][$team]['total'] < $result['penalty'][$opponent]['total'] && $result['penalty'][$team]['total'] < 2) {
                                $lineupArray[$event->event_player_assist_1_id]['assist_power']++;
                            }
                        }
                        if ($event->event_player_assist_2_id) {
                            $lineupArray[$event->event_player_assist_2_id]['assist']++;

                            if ($result['penalty'][$team]['total'] > $result['penalty'][$opponent]['total'] && $result['penalty'][$opponent]['total'] < 2) {
                                $lineupArray[$event->event_player_assist_2_id]['assist_short']++;
                            }
                            if ($result['penalty'][$team]['total'] < $result['penalty'][$opponent]['total'] && $result['penalty'][$team]['total'] < 2) {
                                $lineupArray[$event->event_player_assist_2_id]['assist_power']++;
                            }
                        }

                        if ($result['penalty'][$team]['total'] < $result['penalty'][$opponent]['total'] && $result['penalty'][$team]['total'] < 2) {
                            $result['penalty'][$opponent]['total']--;
                            unset($result['penalty'][$opponent]['minute'][0]);
                        }
                        if (($game->game_home_score > $game->game_guest_score && $event->event_team_id == $game->game_home_team_id) || ($game->game_home_score < $game->game_guest_score && $event->event_team_id == $game->game_guest_team_id)) {
                            $scoreWinId = $event->event_player_score_id;
                        }
                    }
                    if (EventType::SHOOTOUT == $event->event_event_type_id) {
                        if (($game->game_home_score_shootout > $game->game_guest_score_shootout && $event->event_team_id == $game->game_home_team_id) || ($game->game_home_score_shootout < $game->game_guest_score_shootout && $event->event_team_id == $game->game_guest_team_id)) {
                            $shootOutWinId = $event->event_player_score_id;
                        }
                    }

                    $result['penalty']['home']['minute'] = array_values($result['penalty']['home']['minute']);
                    $result['penalty']['guest']['minute'] = array_values($result['penalty']['guest']['minute']);
                }
            }

            foreach ($lineupArray as $playerId => $lineup) {
                if ($lineup['lineup_position_id'] == Position::GK && $lineup['lineup_line_id'] == 0) {
                    if ($lineup['lineup_team_id'] == $game->game_guest_team_id) {
                        $lineup['pass'] = $game->game_home_score;
                        $lineup['shot_gk'] = $game->game_home_shot;
                        $lineup['save'] = $game->game_home_shot - $game->game_home_score;
                        if (!$game->game_home_score) {
                            $lineup['shutout']++;
                        }
                    } else {
                        $lineup['pass'] = $game->game_guest_score;
                        $lineup['shot_gk'] = $game->game_guest_shot;
                        $lineup['save'] = $game->game_guest_shot - $game->game_guest_score;
                        if (!$game->game_guest_score) {
                            $lineup['shutout']++;
                        }
                    }
                }
                $lineup['point'] = $lineup['score'] + $lineup['assist'];
                if ($lineup['lineup_team_id'] == $game->game_guest_team_id) {
                    if ($game->game_guest_score > $game->game_home_score) {
                        $lineup['win']++;
                    } elseif ($game->game_guest_score < $game->game_home_score) {
                        $lineup['loose']++;
                    }
                } else {
                    if ($game->game_guest_score > $game->game_home_score) {
                        $lineup['loose']++;
                    } elseif ($game->game_guest_score < $game->game_home_score) {
                        $lineup['win']++;
                    }
                }
                if ($game->game_home_score_shootout + $game->game_home_score_shootout) {
                    $lineup['game_with_shootout']++;
                }
                if ($playerId == $scoreWinId) {
                    $lineup['score_win']++;
                }
                if ($playerId == $shootOutWinId) {
                    $lineup['shootout_win']++;
                }
                if ($lineup['lineup_position_id'] == Position::CF) {
                    $lineup['face_off'] = 16;
                    $lineup['face_off_win'] = 8;
                }
                $lineupArray[$playerId] = $lineup;
            }

            $countryId = isset($game->teamHome->championship->championship_country_id) ? $game->teamHome->championship->championship_country_id : 0;
            $divisionId = isset($game->teamHome->championship->championship_division_id) ? $game->teamHome->championship->championship_division_id : 0;

            if (in_array($game->schedule->schedule_tournament_type_id, [
                TournamentType::FRIENDLY,
                TournamentType::CONFERENCE,
                TournamentType::LEAGUE,
                TournamentType::OFF_SEASON,
            ])) {
                $countryId = 0;
                $divisionId = 0;
            }

            if (TournamentType::NATIONAL == $game->schedule->schedule_tournament_type_id) {
                $divisionId = isset($game->nationalHome->worldCup->world_cup_division_id) ? $game->nationalHome->worldCup->world_cup_division_id : 0;
            }

            if (TournamentType::CHAMPIONSHIP == $game->schedule->schedule_tournament_type_id && $game->schedule->schedule_stage_id >= Stage::ROUND_OF_16) {
                $is_playoff = 1;
            } else {
                $is_playoff = 0;
            }

            foreach ($lineupArray as $lineup) {
                if ($lineup['lineup_position_id'] == Position::GK && $lineup['lineup_line_id']) {
                    continue;
                }
                $model = Lineup::find()
                    ->where(['lineup_id' => $lineup['lineup_id']])
                    ->one();
                $model->lineup_assist = $lineup['assist'];
                $model->save(true, ['lineup_assist']);

                if ($lineup['lineup_position_id'] == Position::GK) {
                    $model = StatisticPlayer::find()->where([
                        'statistic_player_championship_playoff' => $is_playoff,
                        'statistic_player_country_id' => $countryId,
                        'statistic_player_division_id' => $divisionId,
                        'statistic_player_is_gk' => 1,
                        'statistic_player_player_id' => $lineup['lineup_player_id'],
                        'statistic_player_season_id' => $game->schedule->schedule_season_id,
                        'statistic_player_team_id' => $lineup['lineup_team_id'],
                        'statistic_player_tournament_type_id' => $game->schedule->schedule_tournament_type_id,
                    ])->limit(1)->one();
                    if (!$model) {
                        $model = new StatisticPlayer();
                        $model->statistic_player_championship_playoff = $is_playoff;
                        $model->statistic_player_country_id = $countryId;
                        $model->statistic_player_division_id = $divisionId;
                        $model->statistic_player_is_gk = 1;
                        $model->statistic_player_player_id = $lineup['lineup_player_id'];
                        $model->statistic_player_season_id = $game->schedule->schedule_season_id;
                        $model->statistic_player_team_id = $lineup['lineup_team_id'];
                        $model->statistic_player_tournament_type_id = $game->schedule->schedule_tournament_type_id;
                    }
                    $model->statistic_player_assist = $model->statistic_player_assist + $lineup['assist'];
                    $model->statistic_player_assist_power = $model->statistic_player_assist_power + $lineup['assist_power'];
                    $model->statistic_player_assist_short = $model->statistic_player_assist_short + $lineup['assist_short'];
                    $model->statistic_player_game = $model->statistic_player_game + 1;
                    $model->statistic_player_game_with_shootout = $model->statistic_player_game_with_shootout + $lineup['game_with_shootout'];
                    $model->statistic_player_loose = $model->statistic_player_loose + $lineup['loose'];
                    $model->statistic_player_pass = $model->statistic_player_pass + $lineup['pass'];
                    $model->statistic_player_point = $model->statistic_player_point + $lineup['point'];
                    $model->statistic_player_save = $model->statistic_player_save + $lineup['save'];
                    $model->statistic_player_shot_gk = $model->statistic_player_shot_gk + $lineup['shot_gk'];
                    $model->statistic_player_shutout = $model->statistic_player_shutout + $lineup['shutout'];
                    $model->statistic_player_win = $model->statistic_player_win + $lineup['win'];
                    $model->save();
                } else {
                    $model = StatisticPlayer::find()->where([
                        'statistic_player_championship_playoff' => $is_playoff,
                        'statistic_player_country_id' => $countryId,
                        'statistic_player_division_id' => $divisionId,
                        'statistic_player_is_gk' => 0,
                        'statistic_player_player_id' => $lineup['lineup_player_id'],
                        'statistic_player_season_id' => $game->schedule->schedule_season_id,
                        'statistic_player_team_id' => $lineup['lineup_team_id'],
                        'statistic_player_tournament_type_id' => $game->schedule->schedule_tournament_type_id,
                    ])->limit(1)->one();
                    if (!$model) {
                        $model = new StatisticPlayer();
                        $model->statistic_player_championship_playoff = $is_playoff;
                        $model->statistic_player_country_id = $countryId;
                        $model->statistic_player_division_id = $divisionId;
                        $model->statistic_player_is_gk = 0;
                        $model->statistic_player_player_id = $lineup['lineup_player_id'];
                        $model->statistic_player_season_id = $game->schedule->schedule_season_id;
                        $model->statistic_player_team_id = $lineup['lineup_team_id'];
                        $model->statistic_player_tournament_type_id = $game->schedule->schedule_tournament_type_id;
                    }
                    $model->statistic_player_assist = $model->statistic_player_assist + $lineup['assist'];
                    $model->statistic_player_assist_power = $model->statistic_player_assist_power + $lineup['assist_power'];
                    $model->statistic_player_assist_short = $model->statistic_player_assist_short + $lineup['assist_short'];
                    $model->statistic_player_shootout_win = $model->statistic_player_shootout_win + $lineup['shootout_win'];
                    $model->statistic_player_face_off = $model->statistic_player_face_off + $lineup['face_off'];
                    $model->statistic_player_face_off_win = $model->statistic_player_face_off_win + $lineup['face_off_win'];
                    $model->statistic_player_game = $model->statistic_player_game + 1;
                    $model->statistic_player_loose = $model->statistic_player_loose + $lineup['loose'];
                    $model->statistic_player_penalty = $model->statistic_player_penalty + $lineup['penalty'];
                    $model->statistic_player_plus_minus = $model->statistic_player_plus_minus + $lineup['plus_minus'];
                    $model->statistic_player_point = $model->statistic_player_point + $lineup['point'];
                    $model->statistic_player_score = $model->statistic_player_score + $lineup['score'];
                    $model->statistic_player_score_draw = $model->statistic_player_score_draw + $lineup['score_draw'];
                    $model->statistic_player_score_power = $model->statistic_player_score_power + $lineup['score_power'];
                    $model->statistic_player_score_short = $model->statistic_player_score_short + $lineup['score_short'];
                    $model->statistic_player_score_win = $model->statistic_player_score_win + $lineup['score_win'];
                    $model->statistic_player_shot = $model->statistic_player_shot + $lineup['shot'];
                    $model->statistic_player_win = $model->statistic_player_win + $lineup['win'];
                    $model->save();
                }
            }
        }

        StatisticPlayer::updateAll(
            [
                'statistic_player_pass_per_game' => new Expression('statistic_player_pass/IF(statistic_player_game=0,1,statistic_player_game)'),
                'statistic_player_save_percent' => new Expression('statistic_player_save/IF(statistic_player_shot_gk=0,1,statistic_player_shot_gk)*100'),
            ],
            ['statistic_player_season_id' => Season::getCurrentSeason(), 'statistic_player_is_gk' => 1]
        );

        StatisticPlayer::updateAll(
            [
                'statistic_player_face_off_percent' => new Expression('statistic_player_face_off_win/IF(statistic_player_face_off=0,1,statistic_player_face_off)*100'),
                'statistic_player_score_shot_percent' => new Expression('statistic_player_score/IF(statistic_player_shot=0,1,statistic_player_shot)*100'),
                'statistic_player_shot_per_game' => new Expression('statistic_player_shot/IF(statistic_player_game=0,1,statistic_player_game)'),
            ],
            ['statistic_player_season_id' => Season::getCurrentSeason(), 'statistic_player_is_gk' => 0]
        );
    }

    /**
     * @throws Exception
     */
    public function actionNewFed()
    {
        $latName = [
            'Адриан',
            'Айварс',
            'Алвис',
            'Александр',
            'Анатолиус',
            'Андрейc',
            'Анри',
            'Вадим',
            'Валдис',
            'Вальдемас',
            'Вольдемарс',
            'Гунарс',
            'Густавc',
            'Дайнис',
            'Даниэлс',
            'Денис',
            'Дмитрий',
            'Дзинтарс',
            'Емест',
            'Игорь',
            'Интарс',
            'Каспарс',
            'Кристапс',
            'Макар',
            'Максимилианс',
            'Максимс',
            'Мантас',
            'Марис',
            'Маркс',
            'Маркус',
            'Матиас',
            'Матисс',
            'Олег',
            'Раймондc',
            'Робертс',
            'Роман',
            'Сандис',
            'Симеонс',
            'Таливалдис',
            'Талис',
            'Тимофей',
            'Томс',
            'Улдис',
            'Эгилс',
            'Эдвин',
            'Элвис',
            'Юргис',
            'Юрий',
            'Юрис',
            'Язепс',
            'Янис',
        ];

        $nameArray = [
            [
                'country' => 'Латвия',
                'list' => $latName,
            ],
        ];

        $data = [];
        foreach ($nameArray as $country) {
            $countryId = Country::find()
                ->select(['country_id'])
                ->where(['country_name' => $country['country']])
                ->limit(1)
                ->scalar();

            $nameCountryList = Name::find()
                ->where(['name_name' => $country['list']])
                ->indexBy(['name_name'])
                ->all();
            foreach ($country['list'] as $item) {
                if (isset($nameCountryList[$item])) {
                    $data[] = [$countryId, $nameCountryList[$item]->name_id];
                    continue;
                }

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $name = new Name();
                    $name->name_name = $item;
                    $name->save();
                    $transaction->commit();
                    $data[] = [$countryId, $name->name_id];
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                NameCountry::tableName(),
                ['name_country_country_id', 'name_country_name_id'],
                $data
            )
            ->execute();

        $latSurname = [
            'Авдеев',
            'Агулс',
            'Ануфриев',
            'Атрахимович',
            'Белов',
            'Бернхард',
            'Блигзна',
            'Блиников',
            'Богданов',
            'Буткас',
            'Ваванейс',
            'Валтерс',
            'Варславанс',
            'Витковский',
            'Воронов',
            'Гаджиев',
            'Готт',
            'Гребис',
            'Дементьев',
            'Емелин',
            'Ермак',
            'Жаткин',
            'Жигаев',
            'Жижманов',
            'Звейниекс',
            'Исаченко',
            'Казачок',
            'Калниньш',
            'Кальва',
            'Карашаускс',
            'Каретин',
            'Кирилин',
            'Козлов',
            'Кокоревич',
            'Колинко',
            'Кондратьев',
            'Кривошей',
            'Кучеренко',
            'Ландманис',
            'Лигерис',
            'Линардс',
            'Лабановскис',
            'Матвеев',
            'Мезулис',
            'Метис',
            'Мордатенко',
            'Неверовский',
            'Нейланд',
            'Никалюк',
            'Никольский',
            'Новгордоский',
            'Новиков',
            'Оливский',
            'Оствальд',
            'Павулиньш',
            'Паеглис',
            'Панов',
            'Петунов',
            'Петуховс',
            'Переплоткин',
            'Пилсудсский',
            'Пойканский',
            'Ракель',
            'Раминьш',
            'Ратниекс',
            'Рафальский',
            'Редькин',
            'Резяпкин',
            'Рецицкис',
            'Родик',
            'Ругинс',
            'Рудзитис',
            'Рутиньш',
            'Рыбоченок',
            'Рэй',
            'Саусайс',
            'Саядов',
            'Сван',
            'Сварупс',
            'Синельников',
            'Скурьят',
            'Степанюк',
            'Сычов',
            'Тауберис',
            'Терень',
            'Тиденберг',
            'Филатов',
            'Харкин',
            'Худик',
            'Цайц',
            'Цейцанс',
            'Цуркан',
            'Черкашин',
            'Шалаев',
            'Щоголс',
            'Юкш',
            'Юхневич',
            'Ясвинс',
        ];

        $surnameArray = [
            [
                'country' => 'Латвия',
                'list' => $latSurname,
            ],
        ];

        $data = [];
        foreach ($surnameArray as $country) {
            $countryId = Country::find()
                ->select(['country_id'])
                ->where(['country_name' => $country['country']])
                ->limit(1)
                ->scalar();

            $surnameCountryList = Surname::find()
                ->where(['surname_name' => $country['list']])
                ->indexBy(['surname_name'])
                ->all();
            foreach ($country['list'] as $item) {
                if (isset($surnameCountryList[$item])) {
                    $data[] = [$countryId, $surnameCountryList[$item]->surname_id];
                    continue;
                }

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $surname = new Surname();
                    $surname->surname_name = $item;
                    $surname->save();
                    $transaction->commit();
                    $data[] = [$countryId, $surname->surname_id];
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                SurnameCountry::tableName(),
                ['surname_country_country_id', 'surname_country_surname_id'],
                $data
            )
            ->execute();


        $teamArray = [
            [
                'country' => 'Латвия',
                'list' => [
                    ['team' => 'Айзкраукле', 'stadium' => 'Айзкраукле', 'city' => 'Айзкраукле'],
                    ['team' => 'Алуксне', 'stadium' => 'Алуксне', 'city' => 'Алуксне'],
                    ['team' => 'Балвы', 'stadium' => 'Балвы', 'city' => 'Балвы'],
                    ['team' => 'Бауска', 'stadium' => 'Бауска', 'city' => 'Бауска'],
                    ['team' => 'Валмиера', 'stadium' => 'Валмиера', 'city' => 'Валмиера'],
                    ['team' => 'Вентспилс', 'stadium' => 'Вентспилс', 'city' => 'Вентспилс'],
                    ['team' => 'Гулбене', 'stadium' => 'Гулбене', 'city' => 'Гулбене'],
                    ['team' => 'Даугавпилс', 'stadium' => 'Даугавпилс', 'city' => 'Даугавпилс'],
                    ['team' => 'Динамо', 'stadium' => 'Инбокс', 'city' => 'Рига'],
                    ['team' => 'Динамо-Юниорс', 'stadium' => 'Инбокс', 'city' => 'Рига'],
                    ['team' => 'Добеле', 'stadium' => 'Добеле', 'city' => 'Добеле'],
                    ['team' => 'Екабпилс', 'stadium' => 'Екабпилс', 'city' => 'Екабпилс'],
                    ['team' => 'Земгале', 'stadium' => 'Елгава', 'city' => 'Елгава'],
                    ['team' => 'Краслава', 'stadium' => 'Краслава', 'city' => 'Краслава'],
                    ['team' => 'Кулдига', 'stadium' => 'Кулдига', 'city' => 'Кулдига'],
                    ['team' => 'Курбадс', 'stadium' => 'Курбадс', 'city' => 'Огре'],
                    ['team' => 'Ливаны', 'stadium' => 'Ливаны', 'city' => 'Ливаны'],
                    ['team' => 'Лиепая', 'stadium' => 'Лиепая', 'city' => 'Лиепая'],
                    ['team' => 'Лимбажи', 'stadium' => 'Лимбажи', 'city' => 'Лимбажи'],
                    ['team' => 'Лудза', 'stadium' => 'Лудза', 'city' => 'Лудза'],
                    ['team' => 'Мадона', 'stadium' => 'Мадона', 'city' => 'Мадона'],
                    ['team' => 'Мого', 'stadium' => 'Мого', 'city' => 'Пиньки'],
                    ['team' => 'Олайне', 'stadium' => 'Олайне', 'city' => 'Олайне'],
                    ['team' => 'Прейли', 'stadium' => 'Прейли', 'city' => 'Прейли'],
                    ['team' => 'Призма', 'stadium' => 'Вольво', 'city' => 'Рига'],
                    ['team' => 'Резекне', 'stadium' => 'Резекне', 'city' => 'Резекне'],
                    ['team' => 'Рига', 'stadium' => 'Инбокс', 'city' => 'Рига'],
                    ['team' => 'Саласпилс', 'stadium' => 'Саласпилс', 'city' => 'Саласпилс'],
                    ['team' => 'Салдус', 'stadium' => 'Салдус', 'city' => 'Салдус'],
                    ['team' => 'Сигулда', 'stadium' => 'Сигулда', 'city' => 'Сигулда'],
                    ['team' => 'Талси', 'stadium' => 'Талси', 'city' => 'Талси'],
                    ['team' => 'Тукумс', 'stadium' => 'Тукумс', 'city' => 'Тукумс'],
                    ['team' => 'Цесис', 'stadium' => 'Цесис', 'city' => 'Цесис'],
                    ['team' => 'Юрмала', 'stadium' => 'Юрмала', 'city' => 'Юрмала'],
                ],
            ],
        ];

        foreach ($teamArray as $country) {
            $countryId = Country::find()
                ->select(['country_id'])
                ->where(['country_name' => $country['country']])
                ->limit(1)
                ->scalar();

            shuffle($country['list']);

            foreach ($country['list'] as $item) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $city = City::find()
                        ->where(['city_name' => $item['city']])
                        ->limit(1)
                        ->one();
                    if (!$city) {
                        $city = new City();
                        $city->city_country_id = $countryId;
                        $city->city_name = $item['city'];
                        $city->save();
                    }

                    $stadium = new Stadium();
                    $stadium->stadium_city_id = $city->city_id;
                    $stadium->stadium_name = $item['stadium'];
                    $stadium->save();

                    $team = new Team();
                    $team->team_stadium_id = $stadium->stadium_id;
                    $team->team_name = $item['team'];
                    $team->save();

                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }
        }

        $seasonId = Season::getCurrentSeason();

        $teamArray = Team::find()
            ->where(['!=', 'team_id', 0])
            ->andWhere([
                'not',
                [
                    'team_id' => OffSeason::find()
                        ->select(['off_season_team_id'])
                        ->where(['off_season_season_id' => $seasonId])
                ]
            ])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();

        $data = [];
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $data[] = [$seasonId, $team->team_id];
        }

//        Yii::$app->db
//            ->createCommand()
//            ->batchInsert(
//                OffSeason::tableName(),
//                ['off_season_season_id', 'off_season_team_id'],
//                $data
//            )
//            ->execute();

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                Conference::tableName(),
                ['conference_season_id', 'conference_team_id'],
                $data
            )
            ->execute();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionConference()
    {
        (new InsertSwiss())->execute();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionSchedule()
    {
        $data = [];

        $scheduleArray = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::CONFERENCE,
                'schedule_stage_id' => [
                    Stage::TOUR_31,
                    Stage::TOUR_32,
                    Stage::TOUR_33,
                    Stage::TOUR_34,
                    Stage::TOUR_35,
                    Stage::TOUR_36,
                    Stage::TOUR_37,
                    Stage::TOUR_38,
                    Stage::TOUR_39,
                    Stage::TOUR_40,
                    Stage::TOUR_41,
                ],
                'schedule_season_id' => Season::getCurrentSeason(),
            ])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        foreach ($scheduleArray as $schedule) {
            $data[] = [$schedule->schedule_date, $schedule->schedule_season_id, Stage::FRIENDLY, TournamentType::FRIENDLY];
        }
        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                Schedule::tableName(),
                ['schedule_date', 'schedule_season_id', 'schedule_stage_id', 'schedule_tournament_type_id'],
                $data
            )
            ->execute();
    }
}
