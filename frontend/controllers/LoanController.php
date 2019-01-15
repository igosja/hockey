<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Country;
use common\models\Loan;
use common\models\LoanApplication;
use common\models\LoanComment;
use common\models\Transfer;
use common\models\User;
use common\models\UserRole;
use frontend\models\LoanVote;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\web\Response;

/**
 * Class LoanController
 * @package frontend\controllers
 */
class LoanController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Loan::find()
            ->where(['loan_ready' => 0]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Аренда хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     */
    public function actionHistory()
    {
        $query = Loan::find()
            ->where(['!=', 'loan_ready', 0])
            ->orderBy(['loan_ready' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Аренда хоккеистов');

        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $loan = Loan::find()
            ->where(['loan_id' => $id])
            ->andWhere(['!=', 'loan_ready', 0])
            ->limit(1)
            ->one();
        $this->notFound($loan);

        $model = new LoanVote(['loanId' => $id]);
        if ($model->saveVote()) {
            $this->setSuccessFlash('Ваш голос успешно сохранён');

            $presidentCountryArray = Country::find()
                ->where([
                    'or',
                    ['country_president_id' => $this->user->user_id],
                    ['country_president_vice_id' => $this->user->user_id],
                ])
                ->all();

            if ($presidentCountryArray) {
                $transfer = Transfer::find()
                    ->where([
                        'not',
                        [
                            'transfer_id' => \common\models\TransferVote::find()
                                ->select(['transfer_vote_transfer_id'])
                                ->where(['transfer_vote_user_id' => $this->user->user_id])
                        ]
                    ])
                    ->andWhere(['transfer_checked' => 0])
                    ->andWhere(['!=', 'transfer_ready', 0])
                    ->limit(1)
                    ->one();
                if ($transfer) {
                    return $this->redirect(['transfer/view', 'id' => $transfer->transfer_id]);
                } else {
                    $loan = Loan::find()
                        ->where([
                            'not',
                            [
                                'loan_id' => \common\models\LoanVote::find()
                                    ->select(['loan_vote_loan_id'])
                                    ->where(['loan_vote_user_id' => $this->user->user_id])
                            ]
                        ])
                        ->andWhere(['loan_checked' => 0])
                        ->andWhere(['!=', 'loan_ready', 0])
                        ->limit(1)
                        ->one();
                    if ($loan) {
                        return $this->redirect(['loan/view', 'id' => $transfer->transfer_id]);
                    }
                }
            }
            return $this->refresh();
        }

        $query = LoanApplication::find()
            ->where(['loan_application_loan_id' => $id])
            ->orderBy(['loan_application_price' => SORT_DESC, 'loan_application_date' => SORT_DESC]);
        $applicationDataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $query = LoanComment::find()
            ->with([
                'user' => function (ActiveQuery $query) {
                    return $query->select(['user_id', 'user_login']);
                }
            ])
            ->select([
                'loan_comment_id',
                'loan_comment_date',
                'loan_comment_loan_id',
                'loan_comment_text',
                'loan_comment_user_id',
            ])
            ->where(['loan_comment_loan_id' => $id])
            ->orderBy(['loan_comment_id' => SORT_ASC]);
        $commentDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNewsComment'],
            ],
        ]);

        $this->setSeoTitle('Арендная сделка');

        return $this->render('view', [
            'applicationDataProvider' => $applicationDataProvider,
            'commentDataProvider' => $commentDataProvider,
            'model' => $model,
            'loan' => $loan,
        ]);
    }

    /**
     * @param int $id
     * @param int $loanId
     * @return Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteComment($id, $loanId)
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        if (UserRole::ADMIN != $user->user_user_role_id) {
            $this->forbiddenRole();
        }

        $model = LoanComment::find()
            ->where(['loan_comment_id' => $id, 'loan_comment_loan_id' => $loanId])
            ->limit(1)
            ->one();
        $this->notFound($model);

        try {
            $model->delete();
            $this->setSuccessFlash('Комментарий успешно удалён.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['loan/view', 'id' => $loanId]);
    }
}
