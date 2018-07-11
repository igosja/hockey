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
    public function rules(): array
    {
        return [
            [['news_id'], 'integer'],
            [['news_date', 'news_title'], 'safe'],
        ];
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
        $query = News::find()->select(['news_id', 'news_date', 'news_title']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['id' => $this->news_id])
            ->andFilterWhere(['like', 'title', $this->news_title])
            ->andFilterWhere(['like', 'creation_date', $this->news_date]);

        return $dataProvider;
    }
}