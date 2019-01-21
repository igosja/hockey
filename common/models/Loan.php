<?php

namespace common\models;

use common\components\FormatHelper;
use Exception;
use yii\db\ActiveQuery;

/**
 * Class Loan
 * @package common\models
 *
 * @property int $loan_id
 * @property int $loan_age
 * @property int $loan_cancel
 * @property int $loan_checked
 * @property int $loan_date
 * @property int $loan_day
 * @property int $loan_day_max
 * @property int $loan_day_min
 * @property int $loan_player_id
 * @property int $loan_player_price
 * @property int $loan_power
 * @property int $loan_price_buyer
 * @property int $loan_price_seller
 * @property int $loan_ready
 * @property int $loan_season_id
 * @property int $loan_team_buyer_id
 * @property int $loan_team_seller_id
 * @property int $loan_user_buyer_id
 * @property int $loan_user_seller_id
 *
 * @property LoanApplication[] $loanApplication
 * @property Team $buyer
 * @property LoanVote[] $loanVote
 * @property LoanVote[] $loanVoteMinus
 * @property LoanVote[] $loanVotePlus
 * @property User $managerBuyer
 * @property User $managerSeller
 * @property Player $player
 * @property LoanPosition[] $playerPosition
 * @property LoanSpecial[] $playerSpecial
 * @property Team $seller
 */
class Loan extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%loan}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'loan_id',
                    'loan_age',
                    'loan_cancel',
                    'loan_checked',
                    'loan_date',
                    'loan_day',
                    'loan_day_max',
                    'loan_day_min',
                    'loan_player_id',
                    'loan_player_price',
                    'loan_power',
                    'loan_price_buyer',
                    'loan_price_seller',
                    'loan_ready',
                    'loan_season_id',
                    'loan_team_buyer_id',
                    'loan_team_seller_id',
                    'loan_user_buyer_id',
                    'loan_user_seller_id',
                ],
                'integer'
            ]
        ];
    }

    /**
     * @return string
     */
    public function dealDate()
    {
        $today = strtotime(date('Y-m-d 09:00:00'));

        if ($today < $this->loan_date + 86400 || $today < time()) {
            $today = $today + 86400;
        }

        $result = FormatHelper::asDate($today);
        return $result;
    }

    /**
     * @return string
     */
    public function position()
    {
        $result = [];
        foreach ($this->playerPosition as $position) {
            $result[] = $position->position->position_name;
        }
        return implode('/', $result);
    }

    /**
     * @return string
     */
    public function special()
    {
        $result = [];
        foreach ($this->playerSpecial as $special) {
            $result[] = $special->special->special_name . $special->loan_special_level;
        }
        return implode('', $result);
    }

    /**
     * @return string
     */
    public function rating()
    {
        $returnArray = [
            '<span class="font-green">' . count($this->loanVotePlus) . '</span>',
            '<span class="font-red">' . count($this->loanVoteMinus) . '</span>',
        ];

        $return = implode(' | ', $returnArray);

        return $return;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        foreach ($this->loanApplication as $item) {
            $item->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return array
     */
    public function alerts()
    {
        $result = [
            'success' => [],
            'warning' => [],
            'error' => [],
        ];

        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $teamId = $this->loan_team_buyer_id;
                $userId = $this->loan_user_buyer_id;
            } else {
                $teamId = $this->loan_team_seller_id;
                $userId = $this->loan_user_seller_id;
            }

            if ($userId && $teamId) {
                $history = History::find()
                    ->where([
                        'history_history_text_id' => [
                            HistoryText::USER_MANAGER_TEAM_IN,
                            HistoryText::USER_MANAGER_TEAM_OUT,
                        ],
                        'history_team_id' => $teamId,
                        'history_user_id' => $userId,
                    ])
                    ->orderBy(['history_id' => SORT_DESC])
                    ->limit(1)
                    ->one();
                if ($history) {
                    if (HistoryText::USER_MANAGER_TEAM_OUT == $history->history_history_text_id) {
                        $result['error'][] = 'Менеджер <span class="strong">' . $history->user->user_login . '</span> покинул команду <span class="strong">' . $history->team->team_name . '</span>.';
                    } elseif ($history->history_date > time() - 2592000) {
                        $result['error'][] = 'Менеджер <span class="strong">' . $history->user->user_login . '</span> менее 1 месяца в команде.';
                    } elseif ($history->history_date > time() - 5184000) {
                        $result['warning'][] = 'Менеджер <span class="strong">' . $history->user->user_login . '</span> менее 2 месяцев в команде.';
                    }
                }

                $user = User::find()
                    ->where(['user_id' => $userId])
                    ->limit(1)
                    ->one();
                if ($user->user_date_login < time() - 604800) {
                    $result['error'][] = 'Менеджер <span class="strong">' . $user->user_login . '</span> больше недели не заходил на сайт.';
                }

                if ($user->user_date_register > time() - 2592000) {
                    $result['error'][] = 'Менеджер <span class="strong">' . $user->user_login . '</span> менее 1 месяца в Лиге.';
                } elseif ($user->user_date_register > time() - 5184000) {
                    $result['warning'][] = 'Менеджер <span class="strong">' . $user->user_login . '</span> менее 2 месяцев в Лиге.';
                }

                $team = Team::find()
                    ->where(['team_id' => $teamId])
                    ->limit(1)
                    ->one();

                if ($team->team_auto) {
                    $result['warning'][] = 'Команда <span class="strong">' . $team->team_name . '</span> сыграла ' . $team->team_auto . ' последних матчей автосоставом.';
                }

                $transfer = Transfer::find()
                    ->where([
                        'or',
                        ['transfer_user_buyer_id' => $userId],
                        ['transfer_user_seller_id' => $userId],
                    ])
                    ->andWhere(['!=', 'transfer_cancel', 0])
                    ->andWhere(['transfer_season_id' => Season::getCurrentSeason()])
                    ->count();

                $loan = Loan::find()
                    ->where([
                        'or',
                        ['loan_user_buyer_id' => $userId],
                        ['loan_user_seller_id' => $userId],
                    ])
                    ->andWhere(['!=', 'loan_cancel', 0])
                    ->andWhere(['loan_season_id' => Season::getCurrentSeason()])
                    ->count();

                if ($transfer + $loan) {
                    $result['warning'][] = 'У менеджера <span class="strong">' . $user->user_login . '</span> в этом сезоне уже отменяли <span class="strong">' . ($transfer + $loan) . ' сделок</span>.';
                }
            }
        }

        if ($this->loan_team_buyer_id && $this->loan_user_buyer_id && $this->loan_team_seller_id && $this->loan_user_seller_id) {
            $transfer = Transfer::find()
                ->where([
                    'or',
                    [
                        'transfer_user_buyer_id' => $this->loan_user_buyer_id,
                        'transfer_user_seller_id' => $this->loan_user_seller_id,
                    ],
                    [
                        'transfer_user_buyer_id' => $this->loan_user_seller_id,
                        'transfer_user_seller_id' => $this->loan_user_buyer_id,
                    ],
                ])
                ->andWhere(['transfer_cancel' => 0])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->count();
            $loan = Loan::find()
                ->where([
                    'or',
                    [
                        'loan_user_buyer_id' => $this->loan_user_buyer_id,
                        'loan_user_seller_id' => $this->loan_user_seller_id,
                    ],
                    [
                        'loan_user_buyer_id' => $this->loan_user_seller_id,
                        'loan_user_seller_id' => $this->loan_user_buyer_id,
                    ],
                ])
                ->andWhere(['loan_cancel' => 0])
                ->andWhere(['!=', 'loan_ready', 0])
                ->andWhere(['!=', 'loan_id', $this->loan_id])
                ->count();

            if ($transfer + $loan) {
                $result['warning'][] = 'Менеджеры уже заключали <span class="strong">' . ($transfer + $loan) . ' сделок</span> между собой.';
            }

            $user = User::find()
                ->where(['<', 'user_date_register', time() - 5184000])
                ->andWhere(['user_id' => [$this->loan_user_buyer_id, $this->loan_user_seller_id]])
                ->count();

            if (2 == $user) {
                $result['success'][] = 'Оба менеджера достаточно давно играют в Лиге.';
            }
        }

        if (0 == count($result['success'])) {
            unset($result['success']);
        }

        if (0 == count($result['warning'])) {
            unset($result['warning']);
        }

        if (0 == count($result['error'])) {
            unset($result['error']);
        }

        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(Team::class, ['team_id' => 'loan_team_buyer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanApplication()
    {
        return $this->hasMany(LoanApplication::class, ['loan_application_loan_id' => 'loan_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanVote()
    {
        return $this->hasMany(LoanVote::class, ['loan_vote_loan_id' => 'loan_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanVoteMinus()
    {
        return $this->getLoanVote()->andWhere(['<', 'loan_vote_rating', 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getLoanVotePlus()
    {
        return $this->getLoanVote()->andWhere(['>', 'loan_vote_rating', 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getManagerBuyer()
    {
        return $this->hasOne(User::class, ['user_id' => 'loan_user_buyer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManagerSeller()
    {
        return $this->hasOne(User::class, ['user_id' => 'loan_user_seller_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::class, ['player_id' => 'loan_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerPosition()
    {
        return $this->hasMany(LoanPosition::class, ['loan_position_loan_id' => 'loan_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerSpecial()
    {
        return $this->hasMany(LoanSpecial::class, ['loan_special_loan_id' => 'loan_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Team::class, ['team_id' => 'loan_team_seller_id']);
    }
}
