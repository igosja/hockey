<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\LoanComment;
use common\models\LoanVote as VoteModel;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class LoanVote
 * @package frontend\models
 *
 * @property string $comment
 * @property int $loanId
 * @property int $vote
 */
class LoanVote extends Model
{
    public $comment;
    public $loanId;
    public $vote;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $model = VoteModel::find()
            ->where(['loan_vote_loan_id' => $this->loanId, 'loan_vote_user_id' => Yii::$app->user->id])
            ->limit(1)
            ->one();
        if ($model) {
            $this->vote = $model->loan_vote_rating;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['vote'], 'in', 'range' => [-1, 1]],
            [['vote'], 'required'],
            [['comment'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'vote' => 'Оценка',
            'comment' => 'Комментарий',
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveVote()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $model = VoteModel::find()
            ->where(['loan_vote_loan_id' => $this->loanId, 'loan_vote_user_id' => $user->user_id])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new VoteModel();
            $model->loan_vote_loan_id = $this->loanId;
            $model->loan_vote_user_id = $user->user_id;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->loan_vote_rating = $this->vote;
            $model->save();

            if ($user->user_date_block_comment_deal < time() && $user->user_date_block_comment < time() && $user->user_date_confirm && $this->comment) {
                $model = new LoanComment();
                $model->loan_comment_text = $this->comment;
                $model->loan_comment_loan_id = $this->loanId;
                $model->save();
            }
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }
}
