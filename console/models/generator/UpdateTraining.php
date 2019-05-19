<?php

namespace console\models\generator;

use common\models\History;
use common\models\HistoryText;
use common\models\Player;
use common\models\PlayerPosition;
use common\models\PlayerSpecial;
use common\models\Training;
use Yii;

/**
 * Class UpdateTraining
 * @package console\models\generator
 *
 * @property Training $training
 */
class UpdateTraining
{
    /**
     * @var Training $training
     */
    private $training;

    /**
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function execute()
    {
        $this->increasePercent();

        $trainingArray = Training::find()
            ->where(['>=', 'training_percent', 100])
            ->andWhere(['training_ready' => 0])
            ->orderBy(['training_id' => SORT_ASC])
            ->each(5);
        foreach ($trainingArray as $training) {
            $this->training = $training;

            if ($this->training->training_power) {
                $this->power();
            } elseif ($this->training->training_position_id) {
                $this->position();
            } elseif ($this->training->training_special_id) {
                $this->special();
            }
        }

        $this->ready();
    }

    /**
     * @throws \yii\db\Exception
     * @return void
     */
    private function increasePercent()
    {
        $sql = "UPDATE `training`
                LEFT JOIN `team`
                ON `training_team_id`=`team_id`
                LEFT JOIN `base_training`
                ON `team_base_training_id`=`base_training_id`
                LEFT JOIN `player`
                ON `training_player_id`=`player_id`
                SET `training_percent`=`training_percent`+`base_training_training_speed_min`+(`base_training_training_speed_max`-`base_training_training_speed_min`)/2*RAND()+`player_training_ability`
                WHERE `training_ready`=0";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @throws \Exception
     */
    private function power()
    {
        Player::updateAllCounters(
            ['player_power_nominal' => 1],
            ['player_id' => $this->training->training_player_id]
        );

        History::log([
            'history_history_text_id' => HistoryText::PLAYER_TRAINING_POINT,
            'history_player_id' => $this->training->training_player_id,
        ]);
    }

    /**
     * @throws \Exception
     */
    private function position()
    {
        $model = new PlayerPosition();
        $model->player_position_player_id = $this->training->training_player_id;
        $model->player_position_position_id = $this->training->training_position_id;
        $model->save();

        History::log([
            'history_history_text_id' => HistoryText::PLAYER_TRAINING_POSITION,
            'history_player_id' => $this->training->training_player_id,
            'history_position_id' => $this->training->training_position_id,
        ]);
    }

    /**
     * @throws \Exception
     */
    private function special()
    {
        $model = PlayerSpecial::find()->where([
            'player_special_player_id' => $this->training->training_player_id,
            'player_special_special_id' => $this->training->training_special_id,
        ])->limit(1)->one();
        if (!$model) {
            $model = new PlayerSpecial();
            $model->player_special_player_id = $this->training->training_player_id;
            $model->player_special_special_id = $this->training->training_special_id;
            $model->player_special_level = 1;
        } else {
            $model->player_special_level = $model->player_special_level + 1;
        }
        $model->save();

        History::log([
            'history_history_text_id' => HistoryText::PLAYER_TRAINING_SPECIAL,
            'history_player_id' => $this->training->training_player_id,
            'history_special_id' => $this->training->training_special_id,
        ]);
    }

    private function ready()
    {
        Training::updateAll(
            ['training_percent' => 100, 'training_ready' => time()],
            ['and', ['>=', 'training_percent', 100], ['training_ready' => 0]]
        );
    }
}