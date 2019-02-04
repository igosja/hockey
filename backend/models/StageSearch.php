<?php

namespace backend\models;

use common\models\Stage;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class StageSearch
 * @package backend\models
 */
class StageSearch extends Stage
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['stage_id'], 'integer'],
            [['stage_name'], 'safe'],
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
        $query = Stage::find()->select(['stage_id', 'stage_name']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['stage_id' => $this->stage_id])
            ->andFilterWhere(['like', 'stage_name', $this->stage_name]);

        return $dataProvider;
    }
}