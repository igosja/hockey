<?php

namespace frontend\models;

use common\models\Loan;
use common\models\LoanPosition;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class LoanHistorySearch
 * @package backend\models
 */
class LoanHistorySearch extends Loan
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
        $query = Loan::find()
            ->joinWith(['player.name', 'player.surname'])
            ->where(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC]);

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
            ->andFilterWhere(['<=', 'loan_age', $this->ageMax])
            ->andFilterWhere(['>=', 'loan_age', $this->ageMin])
            ->andFilterWhere(['<=', 'loan_power', $this->powerMax])
            ->andFilterWhere(['>=', 'loan_power', $this->powerMin])
            ->andFilterWhere(['<=', 'loan_price_buyer', $this->priceMax])
            ->andFilterWhere(['>=', 'loan_price_buyer', $this->priceMin])
            ->andFilterWhere(['like', 'name_name', $this->name])
            ->andFilterWhere(['like', 'surname_name', $this->surname]);

        if ($this->position) {
            $query->andWhere([
                'loan_id' => LoanPosition::find()
                    ->select(['loan_position_loan_id'])
                    ->where(['loan_position_position_id' => $this->position])
            ]);
        }

        return $dataProvider;
    }
}