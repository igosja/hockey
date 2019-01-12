<?php

namespace backend\models;

use common\models\Country;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class PresidentSearch
 * @package backend\models
 */
class PresidentSearch extends User
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['user_login'], 'safe'],
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
        $query = User::find()
            ->select(['user_id', 'user_login'])
            ->andWhere(['!=', 'user_id', 0])
            ->andWhere([
                'or',
                ['user_id' => Country::find()->select(['country_president_id'])],
                ['user_id' => Country::find()->select(['country_president_vice_id'])]
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['user_id' => $this->user_id])
            ->andFilterWhere(['like', 'user_login', $this->user_login]);

        return $dataProvider;
    }
}