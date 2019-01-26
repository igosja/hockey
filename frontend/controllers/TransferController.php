<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Country;
use common\models\Loan;
use common\models\Player;
use common\models\Position;
use common\models\Transfer;
use common\models\TransferApplication;
use common\models\TransferComment;
use common\models\User;
use common\models\UserRole;
use frontend\models\TransferHistorySearch;
use frontend\models\TransferSearch;
use frontend\models\TransferVote;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class TransferController
 * @package frontend\controllers
 */
class TransferController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $countryArray = ArrayHelper::map(
            Player::find()
                ->with([
                    'country' => function (ActiveQuery $query) {
                        return $query->select(['country_id', 'country_name']);
                    },
                ])
                ->select(['player_country_id'])
                ->groupBy(['player_country_id'])
                ->orderBy(['player_country_id' => SORT_ASC])
                ->all(),
            'country.country_id',
            'country.country_name'
        );

        $positionArray = ArrayHelper::map(
            Position::find()
                ->select(['position_id', 'position_name'])
                ->orderBy(['position_id' => SORT_ASC])
                ->all(),
            'position_id',
            'position_name'
        );

        $this->setSeoTitle('Трансфер хоккеистов');

        return $this->render('index', [
            'countryArray' => $countryArray,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
            'positionArray' => $positionArray,
        ]);
    }

    /**
     * @return string
     */
    public function actionHistory()
    {
        $searchModel = new TransferHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $countryArray = ArrayHelper::map(
            Player::find()
                ->with([
                    'country' => function (ActiveQuery $query) {
                        return $query->select(['country_id', 'country_name']);
                    },
                ])
                ->select(['player_country_id'])
                ->groupBy(['player_country_id'])
                ->orderBy(['player_country_id' => SORT_ASC])
                ->all(),
            'country.country_id',
            'country.country_name'
        );

        $positionArray = ArrayHelper::map(
            Position::find()
                ->select(['position_id', 'position_name'])
                ->orderBy(['position_id' => SORT_ASC])
                ->all(),
            'position_id',
            'position_name'
        );

        $this->setSeoTitle('Трансфер хоккеистов');

        return $this->render('history', [
            'countryArray' => $countryArray,
            'dataProvider' => $dataProvider,
            'model' => $searchModel,
            'positionArray' => $positionArray,
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
        $transfer = Transfer::find()
            ->where(['transfer_id' => $id])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->limit(1)
            ->one();
        $this->notFound($transfer);

        $model = new TransferVote(['transferId' => $id]);
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
                        return $this->redirect(['loan/view', 'id' => $loan->loan_id]);
                    }
                }
            }
            return $this->refresh();
        }

        $query = TransferApplication::find()
            ->where(['transfer_application_transfer_id' => $id])
            ->orderBy(['transfer_application_price' => SORT_DESC, 'transfer_application_date' => SORT_DESC]);
        $applicationDataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $query = TransferComment::find()
            ->with([
                'user' => function (ActiveQuery $query) {
                    return $query->select(['user_id', 'user_login']);
                }
            ])
            ->select([
                'transfer_comment_id',
                'transfer_comment_date',
                'transfer_comment_transfer_id',
                'transfer_comment_text',
                'transfer_comment_user_id',
            ])
            ->where(['transfer_comment_transfer_id' => $id])
            ->orderBy(['transfer_comment_id' => SORT_ASC]);
        $commentDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNewsComment'],
            ],
        ]);

        $this->setSeoTitle('Трансферная сделка');

        return $this->render('view', [
            'applicationDataProvider' => $applicationDataProvider,
            'commentDataProvider' => $commentDataProvider,
            'model' => $model,
            'transfer' => $transfer,
        ]);
    }

    /**
     * @param int $id
     * @param int $transferId
     * @return Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteComment($id, $transferId)
    {
        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;
        if (UserRole::ADMIN != $user->user_user_role_id) {
            $this->forbiddenRole();
        }

        $model = TransferComment::find()
            ->where(['transfer_comment_id' => $id, 'transfer_comment_transfer_id' => $transferId])
            ->limit(1)
            ->one();
        $this->notFound($model);

        try {
            $model->delete();
            $this->setSuccessFlash('Комментарий успешно удалён.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['transfer/view', 'id' => $transferId]);
    }
}
