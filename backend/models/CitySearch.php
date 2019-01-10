<?php

namespace backend\models;

use common\models\City;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class CitySearch
 * @package backend\models
 */
class CitySearch extends City
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['city_name'], 'safe'],
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
        $query = City::find()
            ->where(['!=', 'city_id', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['city_id' => $this->city_id])
            ->andFilterWhere(['like', 'city_name', $this->city_name]);

        return $dataProvider;
    }
}