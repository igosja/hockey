<?php

namespace common\models;

use common\components\FormatHelper;
use DateTime;
use DateTimeZone;
use Exception;
use Throwable;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;
use yii\helpers\Html;

/**
 * Class Transfer
 * @package common\models
 *
 * @property int $transfer_id
 * @property int $transfer_age
 * @property int $transfer_cancel
 * @property int $transfer_checked
 * @property int $transfer_date
 * @property int $transfer_player_id
 * @property int $transfer_player_price
 * @property int $transfer_power
 * @property int $transfer_price_buyer
 * @property int $transfer_price_seller
 * @property int $transfer_ready
 * @property int $transfer_season_id
 * @property int $transfer_team_buyer_id
 * @property int $transfer_team_seller_id
 * @property int $transfer_to_league
 * @property int $transfer_user_buyer_id
 * @property int $transfer_user_seller_id
 *
 * @property Team $buyer
 * @property User $managerBuyer
 * @property User $managerSeller
 * @property Player $player
 * @property Team $seller
 * @property TransferApplication[] $transferApplication
 * @property TransferPosition[] $playerPosition
 * @property TransferSpecial[] $playerSpecial
 * @property TransferVote[] $transferVote
 * @property TransferVote[] $transferVoteMinus
 * @property TransferVote[] $transferVotePlus
 */
class Transfer extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName():string
    {
        return '{{%transfer}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'transfer_id',
                    'transfer_age',
                    'transfer_cancel',
                    'transfer_checked',
                    'transfer_date',
                    'transfer_player_id',
                    'transfer_player_price',
                    'transfer_power',
                    'transfer_price_buyer',
                    'transfer_price_seller',
                    'transfer_ready',
                    'transfer_season_id',
                    'transfer_team_buyer_id',
                    'transfer_team_seller_id',
                    'transfer_to_league',
                    'transfer_user_buyer_id',
                    'transfer_user_seller_id',
                ],
                'integer'
            ]
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
                $this->transfer_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function alerts(): array
    {
        $result = [
            'success' => [],
            'warning' => [],
            'error' => [],
        ];

        for ($i = 0; $i < 2; $i++) {
            if (0 == $i) {
                $teamId = $this->transfer_team_buyer_id;
                $userId = $this->transfer_user_buyer_id;
            } else {
                $teamId = $this->transfer_team_seller_id;
                $userId = $this->transfer_user_seller_id;
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
                        $result['error'][] = 'Менеджер <span class="strong">' . Html::encode($history->user->user_login) . '</span> покинул команду <span class="strong">' . $history->team->team_name . '</span>.';
                    } elseif ($history->history_date > time() - 2592000) {
                        $result['error'][] = 'Менеджер <span class="strong">' . Html::encode($history->user->user_login) . '</span> менее 1 месяца в команде.';
                    } elseif ($history->history_date > time() - 5184000) {
                        $result['warning'][] = 'Менеджер <span class="strong">' . Html::encode($history->user->user_login) . '</span> менее 2 месяцев в команде.';
                    }
                }

                $user = User::find()
                    ->where(['user_id' => $userId])
                    ->limit(1)
                    ->one();
                if ($user->user_date_login < time() - 604800) {
                    $result['error'][] = 'Менеджер <span class="strong">' . Html::encode($user->user_login) . '</span> больше недели не заходил на сайт.';
                }

                if ($user->user_date_register > time() - 2592000) {
                    $result['error'][] = 'Менеджер <span class="strong">' . Html::encode($user->user_login) . '</span> менее 1 месяца в Лиге.';
                } elseif ($user->user_date_register > time() - 5184000) {
                    $result['warning'][] = 'Менеджер <span class="strong">' . Html::encode($user->user_login) . '</span> менее 2 месяцев в Лиге.';
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
                    $result['warning'][] = 'У менеджера <span class="strong">' . Html::encode($user->user_login) . '</span> в этом сезоне уже отменяли <span class="strong">' . ($transfer + $loan) . ' сделок</span>.';
                }
            }
        }

        if ($this->transfer_team_buyer_id && $this->transfer_user_buyer_id && $this->transfer_team_seller_id && $this->transfer_user_seller_id) {
            $transfer = Transfer::find()
                ->where([
                    'or',
                    [
                        'transfer_user_buyer_id' => $this->transfer_user_buyer_id,
                        'transfer_user_seller_id' => $this->transfer_user_seller_id,
                    ],
                    [
                        'transfer_user_buyer_id' => $this->transfer_user_seller_id,
                        'transfer_user_seller_id' => $this->transfer_user_buyer_id,
                    ],
                ])
                ->andWhere(['transfer_cancel' => 0])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->andWhere(['<', 'transfer_ready', $this->transfer_ready])
                ->andWhere(['!=', 'transfer_id', $this->transfer_id])
                ->count();
            $loan = Loan::find()
                ->where([
                    'or',
                    [
                        'loan_user_buyer_id' => $this->transfer_user_buyer_id,
                        'loan_user_seller_id' => $this->transfer_user_seller_id,
                    ],
                    [
                        'loan_user_buyer_id' => $this->transfer_user_seller_id,
                        'loan_user_seller_id' => $this->transfer_user_buyer_id,
                    ],
                ])
                ->andWhere(['loan_cancel' => 0])
                ->andWhere(['!=', 'loan_ready', 0])
                ->andWhere(['<', 'loan_ready', $this->transfer_ready])
                ->count();


            if ($transfer + $loan) {
                $result['warning'][] = 'Менеджеры уже заключали <span class="strong">' . ($transfer + $loan) . ' сделок</span> между собой.';
            }

            $user = User::find()
                ->where(['<', 'user_date_register', time() - 5184000])
                ->andWhere(['user_id' => [$this->transfer_user_buyer_id, $this->transfer_user_seller_id]])
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
     * @return string
     * @throws Exception
     */
    public function dealDate(): string
    {
        $today = (new DateTime())
            ->setTimezone(new DateTimeZone('UTC'))
            ->setTime(9, 0, 0)
            ->getTimestamp();

        if ($today < $this->transfer_date + 86400 || $today < time()) {
            $today = $today + 86400;
        }

        $result = FormatHelper::asDate($today);
        return $result;
    }

    /**
     * @return string
     */
    public function position(): string
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
    public function special(): string
    {
        $result = [];
        foreach ($this->playerSpecial as $special) {
            $result[] = $special->special->special_name . $special->transfer_special_level;
        }
        return implode(' ', $result);
    }

    /**
     * @return string
     */
    public function rating(): string
    {
        $returnArray = [
            '<span class="font-green">' . count($this->transferVotePlus) . '</span>',
            '<span class="font-red">' . count($this->transferVoteMinus) . '</span>',
        ];

        $return = implode(' | ', $returnArray);

        return $return;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete(): bool
    {
        foreach ($this->transferApplication as $item) {
            $item->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return ActiveQuery
     */
    public function getBuyer(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'transfer_team_buyer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManagerBuyer(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'transfer_user_buyer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManagerSeller(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'transfer_user_seller_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'transfer_player_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerPosition(): ActiveQuery
    {
        return $this->hasMany(TransferPosition::class, ['transfer_position_transfer_id' => 'transfer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerSpecial(): ActiveQuery
    {
        return $this->hasMany(TransferSpecial::class, ['transfer_special_transfer_id' => 'transfer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSeller(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'transfer_team_seller_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferApplication(): ActiveQuery
    {
        return $this->hasMany(TransferApplication::class, ['transfer_application_transfer_id' => 'transfer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferVote(): ActiveQuery
    {
        return $this->hasMany(TransferVote::class, ['transfer_vote_transfer_id' => 'transfer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferVoteMinus(): ActiveQuery
    {
        return $this->getTransferVote()->andWhere(['<', 'transfer_vote_rating', 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferVotePlus(): ActiveQuery
    {
        return $this->getTransferVote()->andWhere(['>', 'transfer_vote_rating', 0]);
    }
}
