<?php

namespace backend\models;

use common\models\Complaint;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ComplaintSearch
 * @package backend\models
 */
class ComplaintSearch extends Complaint
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['complaint_id'], 'integer'],
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
        $query = Complaint::find()
            ->where(['complaint_ready' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['complaint_id' => $this->complaint_id]);

        return $dataProvider;
    }
}