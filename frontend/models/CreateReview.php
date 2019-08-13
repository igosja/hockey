<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\Finance;
use common\models\FinanceText;
use common\models\Review;
use common\models\ReviewGame;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class CreateReview
 * @package frontend\models
 *
 * @property int $countryId;
 * @property int $divisionId;
 * @property array $gameText;
 * @property int $scheduleId;
 * @property int $seasonId;
 * @property int $stageId;
 * @property string $title;
 * @property string $text;
 */
class CreateReview extends Model
{
    public $countryId;
    public $divisionId;
    public $gameText;
    public $scheduleId;
    public $seasonId;
    public $stageId;
    public $title;
    public $text;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'text'], 'required'],
            [['gameText'], 'each', 'rule' => ['required']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'gameText' => 'Обзор игры',
            'text' => 'Вступление',
            'title' => 'Заголовок',
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function saveReview()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }
        if (!$this->validate()) {
            return false;
        }
        $review = Review::find()
            ->where([
                'review_country_id' => $this->countryId,
                'review_division_id' => $this->divisionId,
                'review_season_id' => $this->seasonId,
                'review_schedule_id' => $this->scheduleId,
                'review_stage_id' => $this->stageId,
                'review_user_id' => Yii::$app->user->id,
            ])
            ->count();
        if ($review) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $review = new Review();
            $review->review_country_id = $this->countryId;
            $review->review_division_id = $this->divisionId;
            $review->review_season_id = $this->seasonId;
            $review->review_schedule_id = $this->scheduleId;
            $review->review_stage_id = $this->stageId;
            $review->review_text = $this->text;
            $review->review_title = $this->title;
            $review->save();

            foreach ($this->gameText as $gameId => $text) {
                $reviewGame = new ReviewGame();
                $reviewGame->review_game_game_id = $gameId;
                $reviewGame->review_game_review_id = $review->review_id;
                $reviewGame->review_game_text = $text;
                $reviewGame->save();
            }

            /**
             * @var User $user
             */
            $user = Yii::$app->user->identity;
            $prize = 25000;

            Finance::log([
                'finance_finance_text_id' => FinanceText::INCOME_REVIEW,
                'finance_user_id' => $user->user_id,
                'finance_value' => $prize,
                'finance_value_after' => $user->user_finance + $prize,
                'finance_value_before' => $user->user_finance,
            ]);

            $user->user_finance = $user->user_finance + $prize;
            $user->save(true, ['user_finance']);
        } catch (Exception $e) {
            ErrorHelper::log($e);
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();

        return true;
    }
}
