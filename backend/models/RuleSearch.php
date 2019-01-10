<?php

namespace backend\models;

use common\models\Rule;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class RuleSearch
 * @package backend\models
 */
class RuleSearch extends Rule
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['rule_id', 'rule_order'], 'integer'],
            [['rule_title'], 'safe'],
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
        $query = Rule::find()->select(['rule_id', 'rule_title', 'rule_order']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['rule_order' => SORT_ASC]],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['rule_id' => $this->rule_id])
            ->andFilterWhere(['rule_order' => $this->rule_date])
            ->andFilterWhere(['like', 'rule_title', $this->rule_title]);

        return $dataProvider;
    }
}