<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\TransferComment;
use common\models\TransferVote as VoteModel;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class TransferVote
 * @package frontend\models
 *
 * @property string $comment
 * @property int $transferId
 * @property int $vote
 */
class TransferVote extends Model
{
    public $comment;
    public $transferId;
    public $vote;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $model = VoteModel::find()
            ->where(['transfer_vote_transfer_id' => $this->transferId, 'transfer_vote_user_id' => Yii::$app->user->id])
            ->limit(1)
            ->one();
        if ($model) {
            $this->vote = $model->transfer_vote_rating;
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
            ->where(['transfer_vote_transfer_id' => $this->transferId, 'transfer_vote_user_id' => $user->user_id])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new VoteModel();
            $model->transfer_vote_transfer_id = $this->transferId;
            $model->transfer_vote_user_id = $user->user_id;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->transfer_vote_rating = $this->vote;
            $model->save();

            if ($user->user_date_block_comment_deal < time() && $user->user_date_block_comment < time() && $this->comment) {
                $model = new TransferComment();
                $model->transfer_comment_text = $this->comment;
                $model->transfer_comment_transfer_id = $this->transferId;
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
