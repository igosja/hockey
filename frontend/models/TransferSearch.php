<?php

namespace frontend\models;

use common\models\PlayerPosition;
use common\models\Transfer;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TransferSearch
 * @package backend\models
 */
class TransferSearch extends Transfer
{
    /**
     * @var int $ageMax
     */
    public $ageMax;

    /**
     * @var int $ageMin
     */
    public $ageMin;

    /**
     * @var int $country
     */
    public $country;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var int $position
     */
    public $position;

    /**
     * @var int $powerMax
     */
    public $powerMax;

    /**
     * @var int $powerMin
     */
    public $powerMin;

    /**
     * @var int $priceMax
     */
    public $priceMax;

    /**
     * @var int $priceMin
     */
    public $priceMin;

    /**
     * @var string $surname
     */
    public $surname;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['ageMax', 'ageMin', 'country', 'position', 'powerMax', 'powerMin', 'priceMax', 'priceMin'],
                'integer',
                'min' => 0
            ],
            [['name', 'surname'], 'trim'],
        ];
    }

    public function formName()
    {
        return '';
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
        $query = Transfer::find()
            ->joinWith(['player.name', 'player.surname'])
            ->where(['transfer_ready' => 0]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['player_country_id' => $this->country])
            ->andFilterWhere(['<=', 'player_age', $this->ageMax])
            ->andFilterWhere(['>=', 'player_age', $this->ageMin])
            ->andFilterWhere(['<=', 'player_power_nominal', $this->powerMax])
            ->andFilterWhere(['>=', 'player_power_nominal', $this->powerMin])
            ->andFilterWhere(['<=', 'transfer_price_seller', $this->priceMax])
            ->andFilterWhere(['>=', 'transfer_price_seller', $this->priceMin])
            ->andFilterWhere(['like', 'name_name', $this->name])
            ->andFilterWhere(['like', 'surname_name', $this->surname]);

        if ($this->position) {
            $query->andWhere([
                'player_id' => PlayerPosition::find()
                    ->select(['player_position_player_id'])
                    ->where(['player_position_position_id' => $this->position])
            ]);
        }

        return $dataProvider;
    }
}