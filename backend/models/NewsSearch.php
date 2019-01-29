<?php

namespace backend\models;

use common\models\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class NewsSearch
 * @package backend\models
 */
class NewsSearch extends News
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['news_title'], 'safe'],
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
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['news_id' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['news_id' => $this->news_id])
            ->andFilterWhere(['like', 'news_title', $this->news_title]);

        return $dataProvider;
    }
}