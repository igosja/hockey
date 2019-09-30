<?php

namespace backend\models;

use common\models\Support;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SupportUserSearch
 * @package backend\models
 */
class SupportSearch extends Support
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['support_country_id', 'support_user_id'], 'integer'],
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
        $query = Support::find()
            ->where(['support_inside' => 0])
            ->orderBy(['support_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere(['support_user_id' => $this->support_user_id, 'support_country_id' => $this->support_country_id]);

        return $dataProvider;
    }
}