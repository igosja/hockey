<?php

namespace backend\models;

use common\models\Stadium;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class StadiumSearch
 * @package backend\models
 */
class StadiumSearch extends Stadium
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['stadium_id', 'stadium_city_id'], 'integer'],
            [['stadium_name'], 'safe'],
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
        $query = Stadium::find()
            ->where(['!=', 'stadium_id', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['stadium_id' => $this->stadium_id, 'stadium_city_id' => $this->stadium_city_id])
            ->andFilterWhere(['like', 'stadium_name', $this->stadium_name]);

        return $dataProvider;
    }
}