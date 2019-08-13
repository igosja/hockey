<?php

namespace frontend\models;

use common\components\FormatHelper;
use common\models\Game;
use common\models\Lineup;
use common\models\LineupTemplate;
use common\models\Mood;
use common\models\National;
use common\models\Player;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;
use common\models\TournamentType;
use frontend\controllers\AbstractController;
use Yii;
use yii\base\Model;

/**
 * Class GameNationalSend
 * @package frontend\models
 *
 * @property int $captain
 * @property Game $game
 * @property bool $home
 * @property array $line
 * @property int $mood
 * @property string $name
 * @property National $national
 * @property int $rudeness_1
 * @property int $rudeness_2
 * @property int $rudeness_3
 * @property int $rudeness_4
 * @property int $style_1
 * @property int $style_2
 * @property int $style_3
 * @property int $style_4
 * @property int $tactic_1
 * @property int $tactic_2
 * @property int $tactic_3
 * @property int $tactic_4
 * @property int $ticket
 */
class GameNationalSend extends Model
{
    public $captain;
    public $game;
    public $home;
    public $line;
    public $mood = Mood::NORMAL;
    public $name;
    public $rudeness_1 = Rudeness::NORMAL;
    public $rudeness_2 = Rudeness::NORMAL;
    public $rudeness_3 = Rudeness::NORMAL;
    public $rudeness_4 = Rudeness::NORMAL;
    public $style_1 = Style::NORMAL;
    public $style_2 = Style::NORMAL;
    public $style_3 = Style::NORMAL;
    public $style_4 = Style::NORMAL;
    public $tactic_1 = Tactic::NORMAL;
    public $tactic_2 = Tactic::NORMAL;
    public $tactic_3 = Tactic::NORMAL;
    public $tactic_4 = Tactic::NORMAL;
    public $ticket = 20;
    public $national;

    /**
     * GameSend constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if (!$this->game || !$this->national) {
            return;
        }
        $lineupArray = Lineup::find()
            ->where(['lineup_game_id' => $this->game->game_id, 'lineup_national_id' => $this->national->national_id])
            ->all();
        foreach ($lineupArray as $item) {
            $this->line[$item->lineup_line_id][$item->lineup_position_id - 1] = $item->lineup_player_id;
            if ($item->lineup_captain) {
                $this->captain = $item->lineup_player_id;
            }
        }

        $this->ticket = $this->game->game_ticket ? $this->game->game_ticket : $this->ticket;

        if ($this->game->game_guest_national_id == $this->national->national_id) {
            $this->home = false;
            $this->mood = $this->game->game_guest_mood_id ? $this->game->game_guest_mood_id : $this->mood;
            $this->rudeness_1 = $this->game->game_guest_rudeness_id_1 ? $this->game->game_guest_rudeness_id_1 : $this->rudeness_1;
            $this->rudeness_2 = $this->game->game_guest_rudeness_id_2 ? $this->game->game_guest_rudeness_id_2 : $this->rudeness_2;
            $this->rudeness_3 = $this->game->game_guest_rudeness_id_3 ? $this->game->game_guest_rudeness_id_3 : $this->rudeness_3;
            $this->rudeness_4 = $this->game->game_guest_rudeness_id_4 ? $this->game->game_guest_rudeness_id_4 : $this->rudeness_4;
            $this->style_1 = $this->game->game_guest_style_id_1 ? $this->game->game_guest_style_id_1 : $this->style_1;
            $this->style_2 = $this->game->game_guest_style_id_2 ? $this->game->game_guest_style_id_2 : $this->style_2;
            $this->style_3 = $this->game->game_guest_style_id_3 ? $this->game->game_guest_style_id_3 : $this->style_3;
            $this->style_4 = $this->game->game_guest_style_id_4 ? $this->game->game_guest_style_id_4 : $this->style_4;
            $this->tactic_1 = $this->game->game_guest_tactic_id_1 ? $this->game->game_guest_tactic_id_1 : $this->tactic_1;
            $this->tactic_2 = $this->game->game_guest_tactic_id_2 ? $this->game->game_guest_tactic_id_2 : $this->tactic_2;
            $this->tactic_3 = $this->game->game_guest_tactic_id_3 ? $this->game->game_guest_tactic_id_3 : $this->tactic_3;
            $this->tactic_4 = $this->game->game_guest_tactic_id_4 ? $this->game->game_guest_tactic_id_4 : $this->tactic_4;
        } else {
            $this->home = true;
            $this->mood = $this->game->game_home_mood_id ? $this->game->game_home_mood_id : $this->mood;
            $this->rudeness_1 = $this->game->game_home_rudeness_id_1 ? $this->game->game_home_rudeness_id_1 : $this->rudeness_1;
            $this->rudeness_2 = $this->game->game_home_rudeness_id_2 ? $this->game->game_home_rudeness_id_2 : $this->rudeness_2;
            $this->rudeness_3 = $this->game->game_home_rudeness_id_3 ? $this->game->game_home_rudeness_id_3 : $this->rudeness_3;
            $this->rudeness_4 = $this->game->game_home_rudeness_id_4 ? $this->game->game_home_rudeness_id_4 : $this->rudeness_4;
            $this->style_1 = $this->game->game_home_style_id_1 ? $this->game->game_home_style_id_1 : $this->style_1;
            $this->style_2 = $this->game->game_home_style_id_2 ? $this->game->game_home_style_id_2 : $this->style_2;
            $this->style_3 = $this->game->game_home_style_id_3 ? $this->game->game_home_style_id_3 : $this->style_3;
            $this->style_4 = $this->game->game_home_style_id_4 ? $this->game->game_home_style_id_4 : $this->style_4;
            $this->tactic_1 = $this->game->game_home_tactic_id_1 ? $this->game->game_home_tactic_id_1 : $this->tactic_1;
            $this->tactic_2 = $this->game->game_home_tactic_id_2 ? $this->game->game_home_tactic_id_2 : $this->tactic_2;
            $this->tactic_3 = $this->game->game_home_tactic_id_3 ? $this->game->game_home_tactic_id_3 : $this->tactic_3;
            $this->tactic_4 = $this->game->game_home_tactic_id_4 ? $this->game->game_home_tactic_id_4 : $this->tactic_4;
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['line'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [
                [
                    'captain',
                    'mood',
                    'rudeness_1',
                    'rudeness_2',
                    'rudeness_3',
                    'rudeness_4',
                    'style_1',
                    'style_2',
                    'style_3',
                    'style_4',
                    'tactic_1',
                    'tactic_2',
                    'tactic_3',
                    'tactic_4',
                ],
                'integer'
            ],
            [['ticket'], 'integer', 'min' => Game::TICKET_PRICE_MIN, 'max' => Game::TICKET_PRICE_MAX],
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function saveLineup()
    {
        if ($this->home) {
            if ($this->game->game_home_user_id == $this->national->national_user_id && $this->national->national_vice_id == Yii::$app->user->id) {
                return false;
            }
        } else {
            if ($this->game->game_guest_user_id == $this->national->national_user_id && $this->national->national_vice_id == Yii::$app->user->id) {
                return false;
            }
        }

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $gk_1_id = $this->line[0][0];
        $gk_2_id = $this->line[1][0];
        $ld_1_id = $this->line[1][1];
        $rd_1_id = $this->line[1][2];
        $lw_1_id = $this->line[1][3];
        $cf_1_id = $this->line[1][4];
        $rw_1_id = $this->line[1][5];
        $ld_2_id = $this->line[2][1];
        $rd_2_id = $this->line[2][2];
        $lw_2_id = $this->line[2][3];
        $cf_2_id = $this->line[2][4];
        $rw_2_id = $this->line[2][5];
        $ld_3_id = $this->line[3][1];
        $rd_3_id = $this->line[3][2];
        $lw_3_id = $this->line[3][3];
        $cf_3_id = $this->line[3][4];
        $rw_3_id = $this->line[3][5];
        $ld_4_id = $this->line[4][1];
        $rd_4_id = $this->line[4][2];
        $lw_4_id = $this->line[4][3];
        $cf_4_id = $this->line[4][4];
        $rw_4_id = $this->line[4][5];

        if (!in_array($this->mood, [Mood::SUPER, Mood::NORMAL, Mood::REST])) {
            $this->mood = Mood::NORMAL;
        }

        if ((Mood::SUPER == $this->mood && $this->national->national_mood_super <= 0) || (Mood::REST == $this->mood && $this->national->national_mood_rest <= 0) || (Mood::NORMAL != $this->mood && TournamentType::FRIENDLY == $this->game->schedule->schedule_tournament_type_id)) {
            $this->mood = Mood::NORMAL;
        }

        for ($i = 1; $i <= 4; $i++) {
            $tactic = 'tactic_' . $i;
            if (!in_array($this->$tactic, [Tactic::ALL_DEFENCE, Tactic::DEFENCE, Tactic::NORMAL, Tactic::ATTACK, Tactic::ALL_ATTACK])) {
                $this->$tactic = Tactic::NORMAL;
            }

            $rudeness = 'rudeness_' . $i;
            if (!in_array($this->$rudeness, [Rudeness::NORMAL, Rudeness::ROUGH])) {
                $this->$rudeness = Rudeness::NORMAL;
            }

            $style = 'style_' . $i;
            if (!in_array($this->$style, [Style::NORMAL, Style::POWER, Style::SPEED, Style::TECHNIQUE])) {
                $this->$style = Style::NORMAL;
            }
        }

        if ($this->home) {
            $this->game->game_home_mood_id = $this->mood;
            $this->game->game_home_rudeness_id_1 = $this->rudeness_1;
            $this->game->game_home_rudeness_id_2 = $this->rudeness_2;
            $this->game->game_home_rudeness_id_3 = $this->rudeness_3;
            $this->game->game_home_rudeness_id_4 = $this->rudeness_4;
            $this->game->game_home_style_id_1 = $this->style_1;
            $this->game->game_home_style_id_2 = $this->style_2;
            $this->game->game_home_style_id_3 = $this->style_3;
            $this->game->game_home_style_id_4 = $this->style_4;
            $this->game->game_home_tactic_id_1 = $this->tactic_1;
            $this->game->game_home_tactic_id_2 = $this->tactic_2;
            $this->game->game_home_tactic_id_3 = $this->tactic_3;
            $this->game->game_home_tactic_id_4 = $this->tactic_4;
            $this->game->game_ticket = $this->ticket;
            $this->game->game_home_user_id = Yii::$app->user->id;
        } else {
            $this->game->game_guest_mood_id = $this->mood;
            $this->game->game_guest_rudeness_id_1 = $this->rudeness_1;
            $this->game->game_guest_rudeness_id_2 = $this->rudeness_2;
            $this->game->game_guest_rudeness_id_3 = $this->rudeness_3;
            $this->game->game_guest_rudeness_id_4 = $this->rudeness_4;
            $this->game->game_guest_style_id_1 = $this->style_1;
            $this->game->game_guest_style_id_2 = $this->style_2;
            $this->game->game_guest_style_id_3 = $this->style_3;
            $this->game->game_guest_style_id_4 = $this->style_4;
            $this->game->game_guest_tactic_id_1 = $this->tactic_1;
            $this->game->game_guest_tactic_id_2 = $this->tactic_2;
            $this->game->game_guest_tactic_id_3 = $this->tactic_3;
            $this->game->game_guest_tactic_id_4 = $this->tactic_4;
            $this->game->game_guest_user_id = Yii::$app->user->id;
        }
        $this->game->save();

        for ($i = 0; $i < 22; $i++) {
            if (0 == $i) {
                $lineId = 0;
                $positionId = 1;
                $playerId = $gk_1_id;
            } elseif (1 == $i) {
                $lineId = 1;
                $positionId = 1;
                $playerId = $gk_2_id;
            } elseif (2 == $i) {
                $lineId = 1;
                $positionId = 2;
                $playerId = $ld_1_id;
            } elseif (3 == $i) {
                $lineId = 1;
                $positionId = 3;
                $playerId = $rd_1_id;
            } elseif (4 == $i) {
                $lineId = 1;
                $positionId = 4;
                $playerId = $lw_1_id;
            } elseif (5 == $i) {
                $lineId = 1;
                $positionId = 5;
                $playerId = $cf_1_id;
            } elseif (6 == $i) {
                $lineId = 1;
                $positionId = 6;
                $playerId = $rw_1_id;
            } elseif (7 == $i) {
                $lineId = 2;
                $positionId = 2;
                $playerId = $ld_2_id;
            } elseif (8 == $i) {
                $lineId = 2;
                $positionId = 3;
                $playerId = $rd_2_id;
            } elseif (9 == $i) {
                $lineId = 2;
                $positionId = 4;
                $playerId = $lw_2_id;
            } elseif (10 == $i) {
                $lineId = 2;
                $positionId = 5;
                $playerId = $cf_2_id;
            } elseif (11 == $i) {
                $lineId = 2;
                $positionId = 6;
                $playerId = $rw_2_id;
            } elseif (12 == $i) {
                $lineId = 3;
                $positionId = 2;
                $playerId = $ld_3_id;
            } elseif (13 == $i) {
                $lineId = 3;
                $positionId = 3;
                $playerId = $rd_3_id;
            } elseif (14 == $i) {
                $lineId = 3;
                $positionId = 4;
                $playerId = $lw_3_id;
            } elseif (15 == $i) {
                $lineId = 3;
                $positionId = 5;
                $playerId = $cf_3_id;
            } elseif (16 == $i) {
                $lineId = 3;
                $positionId = 6;
                $playerId = $rw_3_id;
            } elseif (17 == $i) {
                $lineId = 4;
                $positionId = 2;
                $playerId = $ld_4_id;
            } elseif (18 == $i) {
                $lineId = 4;
                $positionId = 3;
                $playerId = $rd_4_id;
            } elseif (19 == $i) {
                $lineId = 4;
                $positionId = 4;
                $playerId = $lw_4_id;
            } elseif (20 == $i) {
                $lineId = 4;
                $positionId = 5;
                $playerId = $cf_4_id;
            } else {
                $lineId = 4;
                $positionId = 6;
                $playerId = $rw_4_id;
            }

            $player = Player::find()
                ->where(['player_id' => $playerId])
                ->andWhere(['player_national_id' => $this->national->national_id])
                ->limit(1)
                ->one();
            if (!$player) {
                $playerId = 0;
            }

            $lineup = Lineup::find()
                ->where([
                    'lineup_game_id' => $this->game->game_id,
                    'lineup_line_id' => $lineId,
                    'lineup_position_id' => $positionId,
                    'lineup_national_id' => $this->national->national_id,
                ])
                ->limit(1)
                ->one();
            if (!$lineup) {
                $lineup = new Lineup();
                $lineup->lineup_game_id = $this->game->game_id;
                $lineup->lineup_line_id = $lineId;
                $lineup->lineup_position_id = $positionId;
                $lineup->lineup_national_id = $this->national->national_id;
            }
            if ($this->captain == $playerId) {
                $lineup->lineup_captain = 1;
            } else {
                $lineup->lineup_captain = 0;
            }
            $lineup->lineup_player_id = $playerId;
            $lineup->save();
        }

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function saveLineupTemplate()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;
        $gk_1_id = $this->line[0][0];
        $gk_2_id = $this->line[1][0];
        $ld_1_id = $this->line[1][1];
        $rd_1_id = $this->line[1][2];
        $lw_1_id = $this->line[1][3];
        $cf_1_id = $this->line[1][4];
        $rw_1_id = $this->line[1][5];
        $ld_2_id = $this->line[2][1];
        $rd_2_id = $this->line[2][2];
        $lw_2_id = $this->line[2][3];
        $cf_2_id = $this->line[2][4];
        $rw_2_id = $this->line[2][5];
        $ld_3_id = $this->line[3][1];
        $rd_3_id = $this->line[3][2];
        $lw_3_id = $this->line[3][3];
        $cf_3_id = $this->line[3][4];
        $rw_3_id = $this->line[3][5];
        $ld_4_id = $this->line[4][1];
        $rd_4_id = $this->line[4][2];
        $lw_4_id = $this->line[4][3];
        $cf_4_id = $this->line[4][4];
        $rw_4_id = $this->line[4][5];

        $model = LineupTemplate::find()
            ->where(['lineup_template_national_id' => $controller->myNationalOrVice->national_id, 'lineup_template_name' => $this->name])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new LineupTemplate();
            $model->lineup_template_name = $this->name ?: FormatHelper::asDateTime(time());
            $model->lineup_template_national_id = $controller->myNationalOrVice->national_id;
        }
        $model->lineup_template_captain = $this->captain;
        $model->lineup_template_player_cf_1 = $cf_1_id;
        $model->lineup_template_player_cf_2 = $cf_2_id;
        $model->lineup_template_player_cf_3 = $cf_3_id;
        $model->lineup_template_player_cf_4 = $cf_4_id;
        $model->lineup_template_player_gk_1 = $gk_1_id;
        $model->lineup_template_player_gk_2 = $gk_2_id;
        $model->lineup_template_player_ld_1 = $ld_1_id;
        $model->lineup_template_player_ld_2 = $ld_2_id;
        $model->lineup_template_player_ld_3 = $ld_3_id;
        $model->lineup_template_player_ld_4 = $ld_4_id;
        $model->lineup_template_player_lw_1 = $lw_1_id;
        $model->lineup_template_player_lw_2 = $lw_2_id;
        $model->lineup_template_player_lw_3 = $lw_3_id;
        $model->lineup_template_player_lw_4 = $lw_4_id;
        $model->lineup_template_player_rd_1 = $rd_1_id;
        $model->lineup_template_player_rd_2 = $rd_2_id;
        $model->lineup_template_player_rd_3 = $rd_3_id;
        $model->lineup_template_player_rd_4 = $rd_4_id;
        $model->lineup_template_player_rw_1 = $rw_1_id;
        $model->lineup_template_player_rw_2 = $rw_2_id;
        $model->lineup_template_player_rw_3 = $rw_3_id;
        $model->lineup_template_player_rw_4 = $rw_4_id;
        $model->lineup_template_rudeness_id_1 = $this->rudeness_1;
        $model->lineup_template_rudeness_id_2 = $this->rudeness_2;
        $model->lineup_template_rudeness_id_3 = $this->rudeness_3;
        $model->lineup_template_rudeness_id_4 = $this->rudeness_4;
        $model->lineup_template_style_id_1 = $this->style_1;
        $model->lineup_template_style_id_2 = $this->style_2;
        $model->lineup_template_style_id_3 = $this->style_3;
        $model->lineup_template_style_id_4 = $this->style_4;
        $model->lineup_template_tactic_id_1 = $this->tactic_1;
        $model->lineup_template_tactic_id_2 = $this->tactic_2;
        $model->lineup_template_tactic_id_3 = $this->tactic_3;
        $model->lineup_template_tactic_id_4 = $this->tactic_4;
        $model->lineup_template_team_id = 0;
        return $model->save();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
        ];
    }
}
