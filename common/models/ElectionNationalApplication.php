<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;
use yii\db\ActiveQuery;
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
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_national_application}}';
    }

    /**
     * @return array
     */
    public function rules()
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
            [['election_national_application_text'], 'safe'],
            [['player'], 'checkPlayer'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
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

    public function checkPlayer($attribute)
    {
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
                    ])
                    ->exists();
                if (!$player) {
                    $this->addError('election_national_application_text', 'Игроки выбраны неправильно');
                }
            }
        }

        $this->playerArray = $formPlayerArray;
    }

    /**
     * @return void
     */
    public function loadPlayer()
    {
        $this->playerArray = [];
        foreach ($this->electionNationalPlayer as $electionNationalPlayer) {
            $this->playerArray[] = $electionNationalPlayer->election_national_player_player_id;
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function saveApplication()
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
    public function attributeLabels()
    {
        return [
            'election_national_application_text' => 'Программа',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNational()
    {
        return $this->hasOne(
            ElectionNational::class,
            ['election_national_id' => 'election_national_application_election_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalPlayer()
    {
        return $this->hasMany(
            ElectionNationalPlayer::class,
            ['election_national_player_application_id' => 'election_national_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalVote()
    {
        return $this->hasMany(
            ElectionNationalVote::class,
            ['election_national_vote_application_id' => 'election_national_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'election_national_application_user_id']);
    }
}
