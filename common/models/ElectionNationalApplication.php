<?php

namespace common\models;

use common\components\HockeyHelper;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;

/**
 * Class ElectionNationalApplication
 * @package common\models
 *
 * @property int $election_national_application_id
 * @property int $election_national_application_date
 * @property int $election_national_application_election_id
 * @property string $election_national_application_text
 * @property int $election_national_application_user_id
 *
 * @property ElectionNational $electionNational
 * @property ElectionNationalPlayer[] $electionNationalPlayer
 * @property ElectionNationalVote[] $electionNationalVote
 * @property User $user
 */
class ElectionNationalApplication extends AbstractActiveRecord
{
    /**
     * @var array $player
     */
    public $player;

    /**
     * @var array $playerArray
     */
    public $playerArray;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'election_national_application_id',
                    'election_national_application_date',
                    'election_national_application_election_id',
                    'election_national_application_user_id',
                ],
                'integer'
            ],
            [['election_national_application_text'], 'required'],
            [['player'], 'checkPlayer'],
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
                $this->election_national_application_date = time();
            }
            $this->election_national_application_text = HockeyHelper::clearBbCodeBeforeSave($this->election_national_application_text);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete(): bool
    {
        foreach ($this->electionNationalPlayer as $electionNationalPlayer) {
            $electionNationalPlayer->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @param string $attribute
     */
    public function checkPlayer(string $attribute)
    {
        if (count($this->$attribute) != 6) {
            $this->addError('election_national_application_text', 'Игроки выбраны неправильно');
        }

        $formPlayerArray = [];

        foreach ($this->$attribute as $positionId => $playerArray) {
            $playerArray = array_diff($playerArray, [0]);
            $formPlayerArray = ArrayHelper::merge($formPlayerArray, $playerArray);

            $limit = 6;
            if (Position::GK == $positionId) {
                $limit = 2;
            }

            if (count($playerArray) != $limit) {
                $this->addError('election_national_application_text', 'Игроки выбраны неправильно');
            }

            foreach ($playerArray as $playerId) {
                $player = Player::find()
                    ->where(['!=', 'player_team_id', 0])
                    ->andWhere([
                        'player_id' => $playerId,
                        'player_position_id' => $positionId,
                        'player_country_id' => $this->electionNational->election_national_country_id,
                        'player_national_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $this->electionNational->national->nationalType->getAgeLimit()])
                    ->exists();
                if (!$player) {
                    $this->addError('election_national_application_text', 'Игроки выбраны неправильно');
                }
            }
        }

        $this->playerArray = $formPlayerArray;
    }

    /**
     * @return int
     */
    public function playerPower(): int
    {
        $result = 0;

        foreach ($this->electionNationalPlayer as $electionNationalPlayer) {
            $result = $result + $electionNationalPlayer->player->player_power_nominal_s;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function loadPlayer(): bool
    {
        $this->playerArray = [];
        foreach ($this->electionNationalPlayer as $electionNationalPlayer) {
            $this->playerArray[] = $electionNationalPlayer->election_national_player_player_id;
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function saveApplication(): bool
    {
        $this->loadPlayer();

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $this->save();

        ElectionNationalPlayer::deleteAll(['election_national_player_application_id' => $this->election_national_application_id]);

        foreach ($this->playerArray as $playerId) {
            $model = new ElectionNationalPlayer();
            $model->election_national_player_player_id = $playerId;
            $model->election_national_player_application_id = $this->election_national_application_id;
            $model->save();
        }

        return true;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'election_national_application_text' => 'Программа',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNational(): ActiveQuery
    {
        return $this->hasOne(
            ElectionNational::class,
            ['election_national_id' => 'election_national_application_election_id']
        )->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalPlayer(): ActiveQuery
    {
        return $this->hasMany(
            ElectionNationalPlayer::class,
            ['election_national_player_application_id' => 'election_national_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalVote(): ActiveQuery
    {
        return $this->hasMany(
            ElectionNationalVote::class,
            ['election_national_vote_application_id' => 'election_national_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'election_national_application_user_id'])->cache();
    }
}
