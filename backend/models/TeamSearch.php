<?php

namespace backend\models;

use common\models\Team;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TeamSearch
 * @package backend\models
 */
class TeamSearch extends Team
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['team_id'], 'integer'],
            [['team_name'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Team::find()
            ->where(['!=', 'team_id', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['team_id' => $this->team_id])
            ->andFilterWhere(['like', 'team_name', $this->team_name]);

        return $dataProvider;
    }
}