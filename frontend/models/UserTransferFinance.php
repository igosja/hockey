<?php

namespace frontend\models;

use common\models\Country;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Team;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class UserTransferFinance
 * @package frontend\models
 *
 * @property string $comment
 * @property int $countryId
 * @property int $sum
 * @property int $teamId
 * @property User $user
 */
class UserTransferFinance extends Model
{
    public $comment;
    public $countryId;
    public $sum;
    public $teamId;
    public $user;

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
    public function rules(): array
    {
        return [
            [['countryId', 'teamId'], 'integer', 'min' => 1],
            [['countryId', 'teamId'], 'checkTeamOrCountry', 'skipOnEmpty' => false],
            [['sum'], 'integer', 'min' => 1, 'max' => $this->user->user_finance],
            [['sum'], 'required'],
            [['comment'], 'safe'],
            [['countryId'], 'exist', 'targetClass' => Country::class, 'targetAttribute' => ['countryId' => 'country_id']],
            [['teamId'], 'exist', 'targetClass' => Team::class, 'targetAttribute' => ['teamId' => 'team_id']],
        ];
    }

    /**
     * @return void
     */
    public function checkTeamOrCountry()
    {
        if (!$this->teamId && !$this->countryId) {
            $this->addError(
                'teamId',
                Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel('teamId')])
            );
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
            'countryId' => 'Федерация',
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

        if ($this->teamId) {
            $this->incomeTeam();
        } else {
            $this->incomeCountry();
        }

        $this->outcomeUser();
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
            'finance_comment' => ($this->comment ? $this->comment . ' ' : '') . $this->user->user_login,
            'finance_finance_text_id' => FinanceText::USER_TRANSFER,
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
     * @return bool
     * @throws Exception
     */
    private function incomeCountry()
    {
        $country = Country::find()
            ->where(['country_id' => $this->countryId])
            ->limit(1)
            ->one();
        if (!$country) {
            return false;
        }

        Finance::log([
            'finance_comment' => ($this->comment ? $this->comment . ', ' : '') . $this->user->user_login,
            'finance_country_id' => $country->country_id,
            'finance_finance_text_id' => FinanceText::USER_TRANSFER,
            'finance_value' => $this->sum,
            'finance_value_after' => $country->country_finance + $this->sum,
            'finance_value_before' => $country->country_finance,
        ]);

        $country->country_finance = $country->country_finance + $this->sum;
        $country->save(true, ['country_finance']);

        return true;
    }

    /**
     * @throws Exception
     */
    private function outcomeUser()
    {
        Finance::log([
            'finance_finance_text_id' => FinanceText::USER_TRANSFER,
            'finance_user_id' => $this->user->user_id,
            'finance_value' => $this->sum,
            'finance_value_after' => $this->user->user_finance - $this->sum,
            'finance_value_before' => $this->user->user_finance,
        ]);

        $this->user->user_finance = $this->user->user_finance - $this->sum;
        $this->user->save(true, ['user_finance']);
    }
}
