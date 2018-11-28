<?php

namespace frontend\controllers;

use common\models\Achievement;
use common\models\Country;
use common\models\Finance;
use common\models\History;
use common\models\Loan;
use common\models\National;
use common\models\Season;
use common\models\Sex;
use common\models\Team;
use common\models\Transfer;
use common\models\User;
use common\models\UserRating;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class UserController
 * @package frontend\controllers
 */
class UserController extends AbstractController
{
    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionView($id = 0)
    {
        if (!$id) {
            if (!Yii::$app->user->isGuest) {
                $id = Yii::$app->user->id;
            } else {
                $id = User::ADMIN_USER_ID;
            }

            return $this->redirect(['user/view', 'id' => $id]);
        }

        $query = Country::find()
            ->where(['country_president_id' => $id])
            ->orWhere(['country_president_vice_id' => $id])
            ->orderBy(['country_id' => SORT_ASC]);
        $countryDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = Team::find()
            ->where(['or', ['team_user_id' => $id], ['team_vice_id' => $id]]);
        $teamDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = National::find()
            ->where(['or', ['national_user_id' => $id], ['national_vice_id' => $id]]);
        $nationalDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $userRating = UserRating::find()
            ->where(['user_rating_user_id' => $id, 'user_rating_season_id' => 0])
            ->one();
        if (!$userRating) {
            $userRating = new UserRating();
            $userRating->user_rating_user_id = $id;
            $userRating->save();
        }

        $query = UserRating::find()
            ->where(['user_rating_user_id' => $id])
            ->andWhere(['!=', 'user_rating_season_id', 0])
            ->orderBy(['user_rating_season_id' => SORT_DESC]);
        $ratingDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query = History::find()
            ->where(['history_user_id' => $id])
            ->orderBy(['history_id' => SORT_DESC]);
        $historyDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSeoTitle('Профиль менеджера');

        return $this->render('view', [
            'countryDataProvider' => $countryDataProvider,
            'historyDataProvider' => $historyDataProvider,
            'nationalDataProvider' => $nationalDataProvider,
            'ratingDataProvider' => $ratingDataProvider,
            'teamDataProvider' => $teamDataProvider,
            'userRating' => $userRating,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAchievement($id): string
    {
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Achievement::find()
                ->with([
                ])
                ->select([
                    'achievement_season_id',
                ])
                ->where(['achievement_user_id' => $id])
                ->orderBy(['achievement_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Достижения менеджер');

        return $this->render('achievement', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionFinance($id): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Finance::find()
                ->where(['finance_user_id' => $id])
                ->andWhere(['finance_season_id' => $seasonId])
                ->orderBy(['finance_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Финансы менеджера');

        return $this->render('finance', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionDeal($id): string
    {
        $dataProviderTransferFrom = new ActiveDataProvider([
            'pagination' => false,
            'query' => Transfer::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['transfer_user_seller_id' => $id])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->orderBy(['transfer_ready' => SORT_DESC]),
        ]);
        $dataProviderTransferTo = new ActiveDataProvider([
            'pagination' => false,
            'query' => Transfer::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['transfer_user_buyer_id' => $id])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->orderBy(['transfer_ready' => SORT_DESC]),
        ]);
        $dataProviderLoanFrom = new ActiveDataProvider([
            'pagination' => false,
            'query' => Loan::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['loan_user_seller_id' => $id])
                ->andWhere(['!=', 'loan_ready', 0])
                ->orderBy(['loan_ready' => SORT_DESC]),
        ]);
        $dataProviderLoanTo = new ActiveDataProvider([
            'pagination' => false,
            'query' => Loan::find()
                ->with([
                ])
                ->select([
                ])
                ->where(['loan_user_buyer_id' => $id])
                ->andWhere(['!=', 'loan_ready', 0])
                ->orderBy(['loan_ready' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Сделки менеджера');

        return $this->render('deal', [
            'dataProviderTransferFrom' => $dataProviderTransferFrom,
            'dataProviderTransferTo' => $dataProviderTransferTo,
            'dataProviderLoanFrom' => $dataProviderLoanFrom,
            'dataProviderLoanTo' => $dataProviderLoanTo,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionQuestionnaire()
    {
        /**
         * @var User $model
         */
        $model = Yii::$app->user->identity;
        Yii::$app->request->setQueryParams(['id' => $model->user_id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Анкета успешно сохранена.');
            return $this->refresh();
        }

        $dayArray = [];
        for ($i = 1; $i <= 31; $i++) {
            $dayArray[$i] = $i;
        }

        $monthArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthArray[$i] = $i;
        }

        $currentYear = date('Y');
        $firstYear = $currentYear - 100;
        $yearArray = [];
        for ($i = $currentYear; $i >= $firstYear; $i--) {
            $yearArray[$i] = $i;
        }

        $this->setSeoTitle('Анкета менеджера');

        return $this->render('questionnaire', [
            'countryArray' => Country::selectOptions(),
            'dayArray' => $dayArray,
            'model' => $model,
            'monthArray' => $monthArray,
            'sexArray' => Sex::selectOptions(),
            'yearArray' => $yearArray,
        ]);
    }
}
