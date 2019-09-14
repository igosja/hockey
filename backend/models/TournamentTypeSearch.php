<?php

namespace backend\models;

use common\models\TournamentType;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TournamentTypeSearch
 * @package backend\models
 */
class TournamentTypeSearch extends TournamentType
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['tournament_type_id'], 'integer'],
            [['tournament_type_name'], 'safe'],
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
        $query = TournamentType::find()
            ->select([
                'tournament_type_id',
                'tournament_type_day_type_id',
                'tournament_type_name',
                'tournament_type_visitor',
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['tournament_type_id' => $this->tournament_type_id])
            ->andFilterWhere(['like', 'tournament_type_name', $this->tournament_type_name]);

        return $dataProvider;
    }
}