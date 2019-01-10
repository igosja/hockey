<?php

namespace backend\models;

use common\models\Squad;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SquadSearch
 * @package backend\models
 */
class SquadSearch extends Squad
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['squad_id'], 'integer'],
            [['squad_color'], 'safe'],
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
        $query = Squad::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['squad_id' => $this->squad_id])
            ->andFilterWhere(['like', 'squad_color', $this->squad_color]);

        return $dataProvider;
    }
}