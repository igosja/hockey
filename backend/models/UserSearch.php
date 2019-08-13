<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class UserSearch
 * @package backend\models
 */
class UserSearch extends User
{
    /**
     * @return array
     */
    public function rules(): array
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
        $query = User::find()->andWhere(['!=', 'user_id', 0]);

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