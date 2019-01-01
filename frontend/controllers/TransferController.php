<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Transfer;
use common\models\TransferApplication;
use common\models\TransferComment;
use common\models\User;
use common\models\UserRole;
use frontend\models\TransferVote;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
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
    public function actionIndex(): string
    {
        $query = Transfer::find()
            ->where(['transfer_ready' => 0]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Трансфер хоккеистов');

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     */
    public function actionHistory(): string
    {
        $query = Transfer::find()
            ->where(['!=', 'transfer_ready', 0])
            ->orderBy(['transfer_ready' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
        ]);

        $this->setSeoTitle('Трансфер хоккеистов');

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
    public function actionView(int $id)
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
                'user' => function (ActiveQuery $query): ActiveQuery {
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
    public function actionDeleteComment(int $id, int $transferId): Response
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

    /**
     * @throws \yii\db\Exception
     */
    public function actionFix()
    {
        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                Transfer::tableName(),
                [
                    'transfer_id',
                    'transfer_age',
                    'transfer_cancel',
                    'transfer_checked',
                    'transfer_date',
                    'transfer_player_id',
                    'transfer_player_price',
                    'transfer_power',
                    'transfer_price_buyer',
                    'transfer_price_seller',
                    'transfer_ready',
                    'transfer_season_id',
                    'transfer_team_buyer_id',
                    'transfer_team_seller_id',
                    'transfer_to_league',
                    'transfer_user_buyer_id',
                    'transfer_user_seller_id'
                ],
                [
                    [1, 24, 0, 0, 1546121233, 2022, 1023168, 48, 925000, 923000, 1546862927, 1, 17, 39, 0, 35, 14],
                    [2, 24, 0, 0, 1546121233, 2781, 1023168, 48, 900001, 900000, 1546862927, 1, 26, 53, 0, 3, 14],
                    [3, 19, 0, 0, 1546121233, 3713, 755478, 38, 760000, 760000, 1546862927, 1, 146, 71, 0, 27, 14],
                    [4, 20, 0, 0, 1546160151, 3715, 858858, 42, 530001, 530000, 1546938395, 1, 39, 71, 0, 14, 29],
                    [5, 21, 0, 0, 1546165081, 3714, 806560, 40, 1000001, 810000, 1546938395, 1, 39, 71, 0, 14, 29]
                ]
            )
            ->execute();
    }
}
