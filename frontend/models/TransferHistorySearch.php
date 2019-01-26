<?php

namespace frontend\models;

use common\models\Transfer;
use common\models\TransferPosition;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class TransferHistorySearch
 * @package backend\models
 */
class TransferHistorySearch extends Transfer
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
            ->where(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['player_country_id' => $this->country])
            ->andFilterWhere(['<=', 'transfer_age', $this->ageMax])
            ->andFilterWhere(['>=', 'transfer_age', $this->ageMin])
            ->andFilterWhere(['<=', 'transfer_power', $this->powerMax])
            ->andFilterWhere(['>=', 'transfer_power', $this->powerMin])
            ->andFilterWhere(['<=', 'transfer_price_buyer', $this->priceMax])
            ->andFilterWhere(['>=', 'transfer_price_buyer', $this->priceMin])
            ->andFilterWhere(['like', 'name_name', $this->name])
            ->andFilterWhere(['like', 'surname_name', $this->surname]);

        if ($this->position) {
            $query->andWhere([
                'transfer_id' => TransferPosition::find()
                    ->select(['transfer_position_transfer_id'])
                    ->where(['transfer_position_position_id' => $this->position])
            ]);
        }

        return $dataProvider;
    }
}