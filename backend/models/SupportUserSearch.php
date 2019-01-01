<?php

namespace backend\models;

use common\models\Support;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SupportUserSearch
 * @package backend\models
 */
class SupportUserSearch extends Support
{
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
        $query = Support::find()
            ->select([
                'support_id' => 'MAX(support_id)',
                'support_date' => 'MAX(support_date)',
                'support_read' => 'IF(MIN(support_read)=0, 0, 1)',
                'support_user_id',
            ])
            ->where(['support_question' => 1])
            ->groupBy(['support_user_id'])
            ->orderBy(['support_read' => SORT_ASC, 'support_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}