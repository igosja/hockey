<?php

namespace frontend\models;

use common\models\National;
use common\models\Player;
use common\models\Position;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class NationalPlayer
 * @package common\models
 *
 * @property National $national
 * @property array $player
 * @property array $playerArray
 */
class NationalPlayer extends Model
{
    /**
     * @var National $national
     */
    public $national;

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
    public function rules()
    {
        return [
            [['player'], 'checkPlayer'],
        ];
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
                $this->addError('player', 'Игроки выбраны неправильно');
            }

            foreach ($playerArray as $playerId) {
                $player = Player::find()
                    ->where(['!=', 'player_team_id', 0])
                    ->andWhere([
                        'player_id' => $playerId,
                        'player_position_id' => $positionId,
                        'player_country_id' => $this->national->national_country_id,
                    ])
                    ->exists();
                if (!$player) {
                    $this->addError('player', 'Игроки выбраны неправильно');
                }
            }
        }

        $this->playerArray = $formPlayerArray;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function savePlayer()
    {
        $this->loadPlayer();

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        Player::updateAll(['player_national_id' => 0], ['player_national_id' => $this->national->national_id]);
        foreach ($this->playerArray as $playerId) {
            $model = Player::find()
                ->where(['player_id' => $playerId])
                ->limit(1)
                ->one();
            if ($model) {
                $model->player_national_id = $this->national->national_id;
                $model->save(true, ['player_national_id']);
            }
        }

        return true;
    }

    /**
     * @return void
     */
    public function loadPlayer()
    {
        $this->playerArray = Player::find()
            ->select(['player_id'])
            ->where(['player_national_id' => $this->national->national_id])
            ->column();
    }
}
