<?php

namespace common\models;

use common\components\ErrorHelper;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\db\StaleObjectException;

/**
 * Class Poll
 * @package common\models
 *
 * @property int $poll_id
 * @property int $poll_country_id
 * @property int $poll_date
 * @property string $poll_text
 * @property int $poll_user_id
 * @property int $poll_poll_status_id
 *
 * @property Country $country
 * @property PollAnswer[] $pollAnswer
 * @property PollStatus $pollStatus
 * @property User $user
 */
class Poll extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName():string
    {
        return '{{%poll}}';
    }

    /**
     * @var array $answer
     */
    public $answer;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['poll_id', 'poll_country_id', 'poll_date', 'poll_user_id', 'poll_poll_status_id'], 'integer'],
            [['poll_text'], 'required'],
            [['poll_text'], 'safe'],
            [['poll_text'], 'trim'],
            [['answer'], 'each', 'rule' => ['trim']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'answer' => 'Ответ',
            'poll_id' => 'Id',
            'poll_country_id' => 'Страна опроса',
            'poll_date' => 'Дата',
            'poll_text' => 'Вопрос',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->poll_date = time();
                $this->poll_poll_status_id = PollStatus::NEW_ONE;
                $this->poll_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete(): bool
    {
        foreach ($this->pollAnswer as $item) {
            $item->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function savePoll(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->save();

            foreach ($this->pollAnswer as $item) {
                $item->delete();
            }

            foreach ($this->answer as $answer) {
                if (!$answer) {
                    continue;
                }

                $model = new PollAnswer();
                $model->poll_answer_text = $answer;
                $model->poll_answer_poll_id = $this->poll_id;
                $model->save();
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function prepareForm(): bool
    {
        for ($i = 0, $countAnswer = count($this->pollAnswer); $i < $countAnswer; $i++) {
            $this->answer[$i] = $this->pollAnswer[$i]->poll_answer_text;
        }

        return true;
    }

    /**
     * @return array
     */
    public function answers(): array
    {
        $result = [];
        $total = 0;
        foreach ($this->pollAnswer as $answer) {
            $count = count($answer->pollUser);
            $result[] = [
                'answer' => $answer->poll_answer_text,
                'count' => $count,
            ];
            $total = $total + $count;
        }
        foreach ($result as $key => $value) {
            $result[$key]['percent'] = $total ? round($result[$key]['count'] / $total * 100) : 0;
        }
        usort($result, function ($a, $b) {
            return $b['count'] > $a['count'] ? 1 : 0;
        });
        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'poll_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPollAnswer(): ActiveQuery
    {
        return $this->hasMany(PollAnswer::class, ['poll_answer_poll_id' => 'poll_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPollStatus(): ActiveQuery
    {
        return $this->hasOne(PollStatus::class, ['poll_status_id' => 'poll_poll_status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'poll_user_id'])->cache();
    }
}
