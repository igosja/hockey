<?php

namespace backend\models;

use common\models\TeamAsk;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TeamAskSearch
 * @package backend\models
 */
class TeamAskSearch extends TeamAsk
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = TeamAsk::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}