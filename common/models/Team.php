<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
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
 * @property int $team_power_c_16
 * @property int $team_power_c_21
 * @property int $team_power_c_27
 * @property int $team_power_s_16
 * @property int $team_power_s_21
 * @property int $team_power_s_27
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
 * @property Championship $championship
 * @property Conference $conference
 * @property User $manager
 * @property Stadium $stadium
 * @property TeamAsk[] $teamAsk
 * @property User $vice
 */
class Team extends ActiveRecord
{
    public $count_team;

    const MAX_AUTO_GAMES = 5;

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
                    'team_power_c_16',
                    'team_power_c_21',
                    'team_power_c_27',
                    'team_power_s_16',
                    'team_power_s_21',
                    'team_power_s_27',
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
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'base' => Yii::t('common-models-team', 'label-base'),
            'country' => Yii::t('common-models-team', 'label-country'),
            'count_team' => Yii::t('common-models-team', 'label-count-team'),
            'finance' => Yii::t('common-models-team', 'label-finance'),
            'number_of_application' => Yii::t('common-models-team', 'label-number-of-application'),
            'stadium' => Yii::t('common-models-team', 'label-stadium'),
            'team' => Yii::t('common-models-team', 'label-team'),
            'vs' => Yii::t('common-models-team', 'label-vs'),
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
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->createPlayers();
            $this->createLeaguePlayers();
            $this->updatePower();
            History::log([
                'history_history_text_id' => HistoryText::TEAM_REGISTER,
                'history_team_id' => $this->team_id
            ]);
        }
    }

    private function createPlayers()
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
            $player->player_country_id = $this->stadium->city->country->country_id;
            $player->player_position_id = $position[$i];
            $player->player_team_id = $this->team_id;
            $player->save();
        }
    }

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
     * @return void
     */
    public function updatePower(): void
    {
        $power = Player::find()
            ->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(15)
            ->sum('player_power_nominal');
        $power_c_16 = $power + Player::find()
                ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
                ->orderBy(['player_power_nominal' => SORT_DESC])
                ->limit(1)
                ->sum('player_power_nominal');
        $power = Player::find()
            ->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(20)
            ->sum('player_power_nominal');
        $power_c_21 = $power + Player::find()
                ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
                ->orderBy(['player_power_nominal' => SORT_DESC])
                ->limit(1)
                ->sum('player_power_nominal');
        $power = Player::find()
            ->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal' => SORT_DESC])
            ->limit(25)
            ->sum('player_power_nominal');
        $power_c_27 = $power + Player::find()
                ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
                ->orderBy(['player_power_nominal' => SORT_DESC])
                ->limit(2)
                ->sum('player_power_nominal');
        $power = Player::find()
            ->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(15)
            ->sum('player_power_nominal_s');
        $power_s_16 = $power + Player::find()
                ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
                ->orderBy(['player_power_nominal_s' => SORT_DESC])
                ->limit(1)
                ->sum('player_power_nominal_s');
        $power = Player::find()
            ->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(20)
            ->sum('player_power_nominal_s');
        $power_s_21 = $power + Player::find()
                ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
                ->orderBy(['player_power_nominal_s' => SORT_DESC])
                ->limit(1)
                ->sum('player_power_nominal_s');
        $power = Player::find()->where(['player_team_id' => $this->team_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(25)
            ->sum('player_power_nominal_s');
        $power_s_27 = $power + Player::find()
                ->where(['player_team_id' => $this->team_id, 'player_position_id' => Position::GK])
                ->orderBy(['player_power_nominal_s' => SORT_DESC])
                ->limit(2)
                ->sum('player_power_nominal_s');
        $power_v = round(($power_c_16 + $power_c_21 + $power_c_27) / 64 * 16);
        $power_vs = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

        $this->team_power_c_16 = $power_c_16;
        $this->team_power_c_21 = $power_c_21;
        $this->team_power_c_27 = $power_c_27;
        $this->team_power_s_16 = $power_s_16;
        $this->team_power_s_21 = $power_s_21;
        $this->team_power_s_27 = $power_s_27;
        $this->team_power_v = $power_v;
        $this->team_power_vs = $power_vs;
        $this->save();
    }

    /**
     * @param $user_id
     * @throws Exception
     */
    public function managerEmploy($user_id)
    {
        $this->team_user_id = $user_id;
        if (!$this->save()) {
            throw new Exception(ErrorHelper::modelErrorsToString($this));
        }

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
        if (!$this->save()) {
            throw new Exception(ErrorHelper::modelErrorsToString($this));
        }

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
        $result = 'Add logo';
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
                $this->championship->championship_place . ' place',
                [
                    'championship',
                    'country_id' => $this->championship->country->country_id,
                    'division_id' => $this->championship->division->division_id,
                ]
            );
        } else {
            $result = Html::a(
                $result = 'Conference, ' . $this->conference->conference_place . ' place',
                ['conference/table']
            );
        }
        return $result;
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

    /**
     * @return array
     */
    public static function getTopData():array
    {
        $teamId = Yii::$app->request->get('id', 1);

        $team = Team::find()
            ->where(['team_id' => $teamId])
            ->limit(1)
            ->one();

        $latest = Game::find()
            ->joinWith(['schedule'])
            ->where(['or', ['game_home_team_id' => $teamId], ['game_guest_team_id' => $teamId]])
            ->andWhere(['game_played' => 1])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(3)
            ->all();

        $nearest = Game::find()
            ->joinWith(['schedule'])
            ->where(['or', ['game_home_team_id' => $teamId], ['game_guest_team_id' => $teamId]])
            ->andWhere(['game_played' => 0])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(2)
            ->all();

        return [$teamId, $team, $latest, $nearest];
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
    public function getManager(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'team_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium(): ActiveQuery
    {
        return $this->hasOne(Stadium::class, ['stadium_id' => 'team_stadium_id']);
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
