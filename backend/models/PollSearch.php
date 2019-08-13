<?php

namespace backend\models;

use common\models\Poll;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class PollSearch
 * @package backend\models
 */
class PollSearch extends Poll
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['poll_id'], 'integer'],
            [['poll_text'], 'safe'],
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
        $query = Poll::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['poll_id' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['poll_id' => $this->poll_id])
            ->andFilterWhere(['like', 'poll_text', $this->poll_text]);

        return $dataProvider;
    }
}