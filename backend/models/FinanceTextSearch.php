<?php

namespace backend\models;

use common\models\FinanceText;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class FinanceTextSearch
 * @package backend\models
 */
class FinanceTextSearch extends FinanceText
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['finance_text_id'], 'integer'],
            [['finance_text_text'], 'safe'],
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
        $query = FinanceText::find()
            ->select([
                'finance_text_id',
                'finance_text_text',
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['finance_text_id' => $this->finance_text_id])
            ->andFilterWhere(['like', 'finance_text_text', $this->finance_text_text]);

        return $dataProvider;
    }
}