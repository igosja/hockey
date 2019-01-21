<?php

namespace backend\models;

use common\models\BlockReason;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class BlockReasonSearch
 * @package backend\models
 */
class BlockReasonSearch extends BlockReason
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['block_reason_id'], 'integer'],
            [['block_reason_text'], 'safe'],
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
        $query = BlockReason::find()->select(['block_reason_id', 'block_reason_text']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['block_reason_id' => $this->block_reason_id])
            ->andFilterWhere(['like', 'block_reason_text', $this->block_reason_text]);

        return $dataProvider;
    }
}