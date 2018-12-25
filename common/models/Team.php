<?php

namespace common\models;

use common\components\HockeyHelper;
use common\components\RosterPhrase;
use Exception;
use frontend\controllers\AbstractController;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;

/**
 * Class Team
 * @package common\models
 *
 * @property int $team_id
 * @property float $team_age
 * @property int $team_attitude_national
 * @property int $team_attitude_president
 * @property int $team_attitude_u19
 * @property int $team_attitude_u21
 * @property int $team_auto
 * @property int $team_base_id
 * @property int $team_base_medical_id
 * @property int $team_base_physical_id
 * @property int $team_base_school_id
 * @property int $team_base_scout_id
 * @property int $team_base_training_id
 * @property int $team_finance
 * @property int $team_friendly_status_id
 * @property int $team_free_base
 * @property int $team_mood_rest
 * @property int $team_mood_super
 * @property string $team_name
 * @property int $team_player
 * @property int $team_power_c_21
 * @property int $team_power_c_26
 * @property int $team_power_c_32
 * @property int $team_power_s_21
 * @property int $team_power_s_26
 * @property int $team_power_s_32
 * @property int $team_power_v
 * @property int $team_power_vs
 * @property int $team_price_base
 * @property int $team_price_player
 * @property int $team_price_stadium
 * @property int $team_price_total
 * @property int $team_salary
 * @property int $team_stadium_id
 * @property int $team_user_id
 * @property int $team_vice_id
 * @property int $team_visitor
 *
 * @property Base $base
 * @property BaseMedical $baseMedical
 * @property BasePhysical $basePhysical
 * @property BaseSchool $baseSchool
 * @property BaseScout $baseScout
 * @property BaseTraining $baseTraining
 * @property BuildingBase $buildingBase
 * @property Championship $championship
 * @property Conference $conference
 * @property FriendlyStatus $friendlyStatus
 * @property User $manager
 * @property RatingTeam $ratingTeam
 * @property Stadium $stadium
 * @property TeamAsk[] $teamAsk
 * @property User $vice
 */
class Team extends AbstractActiveRecord
{
    public $count_team;

    const MAX_AUTO_GAMES = 5;
    const START_MONEY = 10000000;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%team}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'team_id',
                    'team_attitude_national',
                    'team_attitude_president',
                    'team_attitude_u19',
                    'team_attitude_u21',
                    'team_auto',
                    'team_base_id',
                    'team_base_medical_id',
                    'team_base_physical_id',
                    'team_base_school_id',
                    'team_base_scout_id',
                    'team_base_training_id',
                    'team_finance',
                    'team_friendly_status_id',
                    'team_free_base',
                    'team_mood_rest',
                    'team_mood_super',
                    'team_player',
                    'team_power_c_21',
                    'team_power_c_26',
                    'team_power_c_32',
                    'team_power_s_21',
                    'team_power_s_26',
                    'team_power_s_32',
                    'team_power_v',
                    'team_power_vs',
                    'team_price_base',
                    'team_price_player',
                    'team_price_stadium',
                    'team_price_total',
                    'team_salary',
                    'team_stadium_id',
                    'team_user_id',
                    'team_vice_id',
                    'team_visitor',
                ],
                'integer'
            ],
            [['team_age'], 'number'],
            [['team_name'], 'string', 'max' => 255],
            [['team_name'], 'trim'],
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
                $this->team_attitude_national = 2;
                $this->team_attitude_president = 2;
                $this->team_attitude_u19 = 2;
                $this->team_attitude_u21 = 2;
                $this->team_base_id = 2;
                $this->team_base_medical_id = 1;
                $this->team_base_physical_id = 1;
                $this->team_base_school_id = 1;
                $this->team_base_scout_id = 1;
                $this->team_base_training_id = 1;
                $this->team_finance = 10000000;
                $this->team_friendly_status_id = 5;
                $this->team_free_base = 5;
                $this->team_mood_rest = 3;
                $this->team_mood_super = 3;
                $this->team_player = 27;
            }
            return true;
        }
        return false;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            History::log([
                'history_history_text_id' => HistoryText::TEAM_REGISTER,
                'history_team_id' => $this->team_id,
            ]);
            Finance::log([
                'finance_finance_text_id' => FinanceText::TEAM_RE_REGISTER,
                'finance_team_id' => $this->team_id,
                'finance_value' => Team::START_MONEY,
                'finance_value_after' => Team::START_MONEY,
                'finance_value_before' => 0,
            ]);
            $this->createPlayers();
            $this->createLeaguePlayers();
            $this->updatePower();
        }
    }

    /**
     * @throws Exception
     * @return void
     */
    private function createPlayers(): void
    {
        $position = [
            Position::GK,
            Position::GK,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::RW,
            Position::RW,
            Position::RW,
            Position::RW,
            Position::RW,
            Position::RW,
        ];

        shuffle($position);

        for ($i = 0, $countPosition = count($position); $i < $countPosition; $i++) {
            $age = 17 + $i;

            if (39 < $age) {
                $age = $age - 17;
            }

            $player = new Player();
            $player->player_age = $age;
            $player->player_country_id = $this->stadium->city->city_country_id;
            $player->player_position_id = $position[$i];
            $player->player_team_id = $this->team_id;
            $player->save();
        }
    }

    /**
     * @throws Exception
     * @return void
     */
    private function createLeaguePlayers()
    {
        $position = [
            Position::GK,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::LD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::RD,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::LW,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::CF,
            Position::RW,
            Position::RW,
            Position::RW,
            Position::RW,
        ];

        shuffle($position);

        for ($i = 0, $countPosition = count($position); $i < $countPosition; $i++) {
            $age = 17 + $i;

            if (39 < $age) {
                $age = $age - 17;
            }

            $player = new Player();
            $player->player_age = $age;
            $player->player_country_id = $this->stadium->city->country->country_id;
            $player->player_position_id = $position[$i];
            $player->save();
        }
    }

    /**
     * @throws Exception
     * @return void
     */
    public function updatePower(): void
    {
        $playerGk = Player::find()
            ->select(['player_id'])
            ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC]);
        $playerField = Player::find()
            ->select(['player_id'])
            ->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC]);
        $player1 = (clone $playerGk)->limit(1)->column();
        $player2 = (clone $playerGk)->limit(2)->column();
        $player20 = (clone $playerField)->limit(20)->column();
        $player25 = (clone $playerField)->limit(25)->column();
        $player30 = (clone $playerField)->limit(30)->column();
        $power = Player::find()->where(['player_id' => $player20])->sum('player_power_nominal');
        $power_c_21 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal');
        $power = Player::find()->where(['player_id' => $player25])->sum('player_power_nominal');
        $power_c_26 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal');
        $power = Player::find()->where(['player_id' => $player30])->sum('player_power_nominal');
        $power_c_32 = $power + Player::find()->where(['player_id' => $player2])->sum('player_power_nominal');
        $power = Player::find()->where(['player_id' => $player20])->sum('player_power_nominal_s');
        $power_s_21 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_id' => $player25])->sum('player_power_nominal_s');
        $power_s_26 = $power + Player::find()->where(['player_id' => $player1])->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_id' => $player30])->sum('player_power_nominal_s');
        $power_s_32 = $power + Player::find()->where(['player_id' => $player2])->sum('player_power_nominal_s');
        $power_v = round(($power_c_21 + $power_c_26 + $power_c_21) / 79 * 21);
        $power_vs = round(($power_s_21 + $power_s_26 + $power_s_32) / 79 * 21);

        $this->team_power_c_21 = $power_c_21;
        $this->team_power_c_26 = $power_c_26;
        $this->team_power_c_32 = $power_c_32;
        $this->team_power_s_21 = $power_s_21;
        $this->team_power_s_26 = $power_s_26;
        $this->team_power_s_32 = $power_s_32;
        $this->team_power_v = $power_v;
        $this->team_power_vs = $power_vs;
        $this->save();
    }

    /**
     * @param $user_id
     * @throws Exception
     * @return void
     */
    public function managerEmploy($user_id): void
    {
        $this->team_user_id = $user_id;
        $this->save();

        History::log([
            'history_history_text_id' => HistoryText::USER_MANAGER_TEAM_IN,
            'history_team_id' => $this->team_id,
            'history_user_id' => $user_id,
        ]);

        Yii::$app->mailer->compose(
            ['html' => 'default-html', 'text' => 'default-text'],
            ['text' => 'Your application for team management is approved.']
        )
            ->setTo($this->manager->user_email)
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['noReplyName']])
            ->setSubject('Getting the team on the Virtual Hockey League website')
            ->send();
    }

    /**
     * @throws Exception
     */
    public function managerFire()
    {
        $userId = $this->team_user_id;
        $viceId = $this->team_vice_id;

        $this->team_auto = 0;
        $this->team_user_id = 0;
        $this->team_vice_id = 0;
        $this->team_attitude_national = 2;
        $this->team_attitude_president = 2;
        $this->team_attitude_u19 = 2;
        $this->team_attitude_u21 = 2;
        $this->save();

        TransferApplication::deleteAll([
            'transfer_application_team_id' => $this->team_id,
            'transfer_application_transfer_id' => Transfer::find()
                ->select(['transfer_id'])
                ->where(['transfer_ready' => 0])
                ->column()
        ]);

        TransferApplication::deleteAll([
            'transfer_application_transfer_id' => Transfer::find()
                ->select(['transfer_id'])
                ->where(['transfer_ready' => 0, 'transfer_team_seller' => $this->team_id])
                ->column()
        ]);

        Transfer::deleteAll(['transfer_team_seller' => $this->team_id]);

        LoanApplication::deleteAll([
            'loan_application_team_id' => $this->team_id,
            'loan_application_loan_id' => Loan::find()
                ->select(['loan_id'])
                ->where(['loan_ready' => 0])
                ->column()
        ]);

        LoanApplication::deleteAll([
            'loan_application_loan_id' => Loan::find()
                ->select(['loan_id'])
                ->where(['loan_ready' => 0, 'loan_team_seller' => $this->team_id])
                ->column()
        ]);

        Loan::deleteAll(['loan_team_seller' => $this->team_id]);

        History::log([
            'history_history_text_id' => HistoryText::USER_MANAGER_TEAM_OUT,
            'history_team_id' => $this->team_id,
            'history_user_id' => $userId,
        ]);

        if ($viceId) {
            History::log([
                'history_history_text_id' => HistoryText::USER_VICE_TEAM_OUT,
                'history_team_id' => $this->team_id,
                'history_user_id' => $viceId,
            ]);
        }
    }

    /**
     * @return string
     */
    public function logo(): string
    {
        $result = 'Добавить<br/>эмблему';
        if (file_exists(Yii::getAlias('@webroot') . '/img/team/125/' . $this->team_id . '.png')) {
            $result = Html::img(
                '/img/team/125/' . $this->team_id . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/team/125/' . $this->team_id . '.png'),
                [
                    'alt' => $this->team_name,
                    'class' => 'team-logo',
                    'title' => $this->team_name,
                ]
            );
        }
        return $result;
    }

    /**
     * @return string
     */
    public function division(): string
    {
        if ($this->championship) {
            $result = Html::a(
                $this->championship->country->country_name . ', ' .
                $this->championship->division->division_name . ', ' .
                $this->championship->championship_place . ' ' .
                'место',
                [
                    'championship/index',
                    'countryId' => $this->championship->country->country_id,
                    'divisionId' => $this->championship->division->division_id,
                ]
            );
        } else {
            $result = Html::a(
                $result = 'Конференция' . ', ' .
                    $this->conference->conference_place . ' ' .
                    'место',
                ['conference/table']
            );
        }
        return $result;
    }

    /**
     * @return integer
     */
    public function baseMaintenance(): int
    {
        return $this->base->base_maintenance_base + $this->base->base_maintenance_slot * $this->baseUsed();
    }

    /**
     * @return integer
     */
    public function baseUsed(): int
    {
        return $this->baseMedical->base_medical_level
            + $this->basePhysical->base_physical_level
            + $this->baseSchool->base_school_level
            + $this->baseScout->base_scout_level
            + $this->baseTraining->base_training_level;
    }

    public function fullName(): string
    {
        return $this->team_name
            . ' (' . $this->stadium->city->city_name
            . ', ' . $this->stadium->city->country->country_name
            . ')';
    }

    /**
     * @param string $type
     * @param bool $short
     * @return string
     */
    public function teamLink(string $type = 'string', bool $short = false): string
    {
        if ('img' == $type) {
            return $this->stadium->city->country->countryImage()
                . ' '
                . Html::a(
                    $this->team_name
                    . ' <span class="hidden-xs">('
                    . $this->stadium->city->city_name
                    . ')</span>',
                    ['team/view', 'id' => $this->team_id]
                );
        } else {
            if ($short) {
                return Html::a(
                    $this->team_name
                    . ' <span class="hidden-xs">('
                    . $this->stadium->city->city_name
                    . ')</span>',
                    ['team/view', 'id' => $this->team_id]
                );
            } else {
                return Html::a(
                    $this->team_name
                    . ' <span class="hidden-xs">('
                    . $this->stadium->city->city_name
                    . ', '
                    . $this->stadium->city->country->country_name
                    . ')</span>',
                    ['team/view', 'id' => $this->team_id]
                );
            }
        }
    }

    /**
     * @return int
     */
    public function availablePhysical(): int
    {
        return $this->basePhysical->base_physical_change_count - $this->usedPhysical();
    }

    /**
     * @return int
     */
    public function availableSchool(): int
    {
        return $this->baseSchool->base_school_player_count - $this->usedSchool();
    }

    /**
     * @return int
     */
    public function availableSchoolWithSpecial(): int
    {
        return $this->baseSchool->base_school_with_special - $this->usedSchoolWithSpecial();
    }

    /**
     * @return int
     */
    public function availableSchoolWithStyle(): int
    {
        return $this->baseSchool->base_school_with_style - $this->usedSchoolWithStyle();
    }

    /**
     * @return int
     */
    public function availableScout(): int
    {
        return $this->baseScout->base_scout_my_style_count - $this->usedScout();
    }

    /**
     * @return int
     */
    public function availableTrainingPower(): int
    {
        return $this->baseTraining->base_training_power_count - $this->usedTrainingPower();
    }

    /**
     * @return int
     */
    public function availableTrainingSpecial(): int
    {
        return $this->baseTraining->base_training_special_count - $this->usedTrainingSpecial();
    }

    /**
     * @return int
     */
    public function availableTrainingPosition(): int
    {
        return $this->baseTraining->base_training_position_count - $this->usedTrainingPosition();
    }

    /**
     * @return bool
     */
    public function isSchool(): bool
    {
        $onSchool = School::find()
            ->where(['school_team_id' => $this->team_id, 'school_ready' => 0])
            ->count();
        return $onSchool ? true : false;
    }

    /**
     * @return bool
     */
    public function isScout(): bool
    {
        $onScout = Scout::find()
            ->where(['scout_team_id' => $this->team_id, 'scout_ready' => 0])
            ->count();
        return $onScout ? true : false;
    }

    /**
     * @return bool
     */
    public function isTraining(): bool
    {
        $onScout = Training::find()
            ->where(['training_team_id' => $this->team_id, 'training_ready' => 0])
            ->count();
        return $onScout ? true : false;
    }

    /**
     * @return int
     */
    public function usedTrainingPower(): int
    {
        return Training::find()
            ->where(['training_team_id' => $this->team_id, 'training_season_id' => Season::getCurrentSeason()])
            ->andWhere(['!=', 'training_power', 0])
            ->count();
    }

    /**
     * @return int
     */
    public function usedTrainingSpecial(): int
    {
        return Training::find()
            ->where(['training_team_id' => $this->team_id, 'training_season_id' => Season::getCurrentSeason()])
            ->andWhere(['!=', 'training_special_id', 0])
            ->count();
    }

    /**
     * @return int
     */
    public function usedTrainingPosition(): int
    {
        return Training::find()
            ->where(['training_team_id' => $this->team_id, 'training_season_id' => Season::getCurrentSeason()])
            ->andWhere(['!=', 'training_position_id', 0])
            ->count();
    }

    /**
     * @return int
     */
    public function usedSchool(): int
    {
        return School::find()
            ->where(['school_team_id' => $this->team_id, 'school_season_id' => Season::getCurrentSeason()])
            ->count();
    }

    /**
     * @return int
     */
    public function usedSchoolWithSpecial(): int
    {
        return School::find()
            ->where([
                'school_team_id' => $this->team_id,
                'school_season_id' => Season::getCurrentSeason(),
                'school_with_special' => 1,
            ])
            ->count();
    }

    /**
     * @return int
     */
    public function usedSchoolWithStyle(): int
    {
        return School::find()
            ->where([
                'school_team_id' => $this->team_id,
                'school_season_id' => Season::getCurrentSeason(),
                'school_with_style' => 1,
            ])
            ->count();
    }

    /**
     * @return int
     */
    public function usedScout(): int
    {
        return Scout::find()
            ->where(['scout_team_id' => $this->team_id, 'scout_season_id' => Season::getCurrentSeason()])
            ->count();
    }

    /**
     * @return int
     */
    public function usedPhysical(): int
    {
        return PhysicalChange::find()
            ->where([
                'physical_change_team_id' => $this->team_id,
                'physical_change_season_id' => Season::getCurrentSeason()
            ])
            ->count();
    }

    /**
     * @return int
     */
    public function planPhysical(): int
    {
        return PhysicalChange::find()
            ->where([
                'physical_change_team_id' => $this->team_id,
                'physical_change_season_id' => Season::getCurrentSeason()
            ])
            ->andWhere([
                '>',
                'physical_change_schedule_id',
                Schedule::find()
                    ->select(['schedule_id'])
                    ->where(['schedule_season_id' => Season::getCurrentSeason()])
                    ->andWhere(['>', 'schedule_date', HockeyHelper::unixTimeStamp()])
                    ->orderBy(['schedule_date' => SORT_DESC])
                    ->limit(1)
            ])
            ->count();
    }

    /**
     * @return bool
     */
    public function myTeam(): bool
    {
        /**
         * @var AbstractController $controller
         */
        $controller = Yii::$app->controller;

        if (!$controller->myTeam) {
            return false;
        }

        if ($controller->myTeam->team_id != $this->team_id) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function latestGame(): array
    {
        return Game::find()
            ->joinWith(['schedule'])
            ->where(['or', ['game_home_team_id' => $this->team_id], ['game_guest_team_id' => $this->team_id]])
            ->andWhere(['!=', 'game_played', 0])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(3)
            ->all();
    }

    /**
     * @return array
     */
    public function nearestGame(): array
    {
        return Game::find()
            ->joinWith(['schedule'])
            ->where(['or', ['game_home_team_id' => $this->team_id], ['game_guest_team_id' => $this->team_id]])
            ->andWhere(['game_played' => 0])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(2)
            ->all();
    }

    /**
     * @return string
     */
    public function rosterPhrase(): string
    {
        return RosterPhrase::rand();
    }

    /**
     * @return ActiveQuery
     */
    public function getBase(): ActiveQuery
    {
        return $this->hasOne(Base::class, ['base_id' => 'team_base_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseMedical(): ActiveQuery
    {
        return $this->hasOne(BaseMedical::class, ['base_medical_id' => 'team_base_medical_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBasePhysical(): ActiveQuery
    {
        return $this->hasOne(BasePhysical::class, ['base_physical_id' => 'team_base_physical_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseSchool(): ActiveQuery
    {
        return $this->hasOne(BaseSchool::class, ['base_school_id' => 'team_base_school_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseScout(): ActiveQuery
    {
        return $this->hasOne(BaseScout::class, ['base_scout_id' => 'team_base_scout_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseTraining(): ActiveQuery
    {
        return $this->hasOne(BaseTraining::class, ['base_training_id' => 'team_base_training_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBuildingBase(): ActiveQuery
    {
        return $this
            ->hasOne(BuildingBase::class, ['building_base_team_id' => 'team_id'])
            ->andWhere(['building_base_ready' => 0]);
    }

    /**
     * @return ActiveQuery
     */
    public function getChampionship(): ActiveQuery
    {
        return $this
            ->hasOne(Championship::class, ['championship_team_id' => 'team_id'])
            ->andWhere(['championship_season_id' => Season::getCurrentSeason()]);
    }

    /**
     * @return ActiveQuery
     */
    public function getConference(): ActiveQuery
    {
        return $this->hasOne(Conference::class, ['conference_team_id' => 'team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFriendlyStatus(): ActiveQuery
    {
        return $this->hasOne(FriendlyStatus::class, ['friendly_status_id' => 'team_friendly_status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getManager(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'team_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRatingTeam(): ActiveQuery
    {
        return $this->hasOne(RatingTeam::class, ['rating_team_team_id' => 'team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium(): ActiveQuery
    {
        return $this->hasOne(Stadium::class, ['stadium_id' => 'team_stadium_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getTeamAsk(): ActiveQuery
    {
        return $this->hasMany(TeamAsk::class, ['team_ask_team_id' => 'team_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVice(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'team_vice_id']);
    }
}
