<?php

namespace common\models;

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use Exception;
use Yii;
use yii\db\ActiveQuery;

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
 * @property PollAnswer[] $pollAnswer
 */
class Poll extends AbstractActiveRecord
{
    /**
     * @var array $answer
     */
    public $answer;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%poll}}';
    }

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

    public function attributeLabels()
    {
        return [
            'answer' => 'Ответ',
            'poll_id' => 'Id',
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
                $this->poll_date = HockeyHelper::unixTimeStamp();
                $this->poll_poll_status_id = PollStatus::NEW;
                $this->poll_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->pollAnswer as $item) {
                $item->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function savePoll()
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
                $model = new PollAnswer();
                $model->poll_answer_text = $answer;
                $model->poll_answer_poll_id = $this->poll_id;
                $model->save();
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    public function prepareForm(): void
    {
        for ($i = 0, $countAnswer = count($this->pollAnswer); $i < $countAnswer; $i++) {
            $this->answer[$i] = $this->pollAnswer[$i]->poll_answer_text;
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getPollAnswer(): ActiveQuery
    {
        return $this->hasMany(PollAnswer::class, ['poll_answer_poll_id' => 'poll_id']);
    }
}
