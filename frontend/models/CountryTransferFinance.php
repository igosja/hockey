<?php

namespace frontend\models;

use common\models\Country;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Team;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class CountryTransferFinance
 * @package frontend\models
 *
 * @property string $comment
 * @property Country $country
 * @property int $sum
 * @property int $teamId
 */
class CountryTransferFinance extends Model
{
    public $comment;
    public $country;
    public $sum;
    public $teamId;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['teamId'], 'integer', 'min' => 1],
            [['teamId'], 'required'],
            [['sum'], 'integer', 'min' => 1, 'max' => $this->country->country_finance],
            [['sum'], 'required'],
            [['comment'], 'safe'],
            [['teamId'], 'exist', 'targetClass' => Team::class, 'targetAttribute' => ['teamId' => 'team_id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
            'sum' => 'Сумма',
            'teamId' => 'Команда',
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function execute()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $this->incomeTeam();
        $this->outcomeCountry();
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function incomeTeam()
    {
        $team = Team::find()
            ->where(['team_id' => $this->teamId])
            ->limit(1)
            ->one();
        if (!$team) {
            return false;
        }

        Finance::log([
            'finance_comment' => ($this->comment ? $this->comment . ' ' : '') . $this->country->country_name,
            'finance_finance_text_id' => FinanceText::COUNTRY_TRANSFER,
            'finance_team_id' => $team->team_id,
            'finance_value' => $this->sum,
            'finance_value_after' => $team->team_finance + $this->sum,
            'finance_value_before' => $team->team_finance,
        ]);

        $team->team_finance = $team->team_finance + $this->sum;
        $team->save(true, ['team_finance']);

        return true;
    }

    /**
     * @throws Exception
     */
    private function outcomeCountry()
    {
        $team = Team::find()
            ->where(['team_id' => $this->teamId])
            ->limit(1)
            ->one();

        Finance::log([
            'finance_comment' => ($this->comment ? $this->comment . ' ' : '') . $team->team_name,
            'finance_country_id' => $this->country->country_id,
            'finance_finance_text_id' => FinanceText::COUNTRY_TRANSFER,
            'finance_value' => $this->sum,
            'finance_value_after' => $this->country->country_finance - $this->sum,
            'finance_value_before' => $this->country->country_finance,
        ]);

        $this->country->country_finance = $this->country->country_finance - $this->sum;
        $this->country->save(true, ['country_finance']);
    }
}
