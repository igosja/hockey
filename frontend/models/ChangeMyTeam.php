<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Class ChangeMyTeam
 * @package frontend\models
 */
class ChangeMyTeam extends Model
{
    public $teamId;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['teamId'], 'integer'],
            [['teamId'], 'required'],
        ];
    }

    /**
     * @return bool
     */
    public function changeMyTeam()
    {
        if (!$this->validate()) {
            return false;
        }

        Yii::$app->session->set('myTeamId', $this->teamId);

        return true;
    }
}
