<?php

namespace backend\controllers;

use common\models\Complaint;
use common\models\ForumMessage;
use common\models\GameComment;
use common\models\LoanComment;
use common\models\LoginForm;
use common\models\Logo;
use common\models\Message;
use common\models\News;
use common\models\NewsComment;
use common\models\Payment;
use common\models\Review;
use common\models\Team;
use common\models\TransferComment;
use common\models\Vote;
use common\models\VoteStatus;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends BaseController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'error'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $complaint = Complaint::find()->count();
        $forumMessage = ForumMessage::find()->where(['forum_message_check' => 0])->count();
        $freeTeam = Team::find()->where(['team_user_id' => 0])->andWhere(['!=', 'team_id', 0])->count();
        $gameComment = GameComment::find()->where(['game_comment_check' => 0])->count();
        $loanComment = LoanComment::find()->where(['loan_comment_check' => 0])->count();
        $logo = Logo::find()->count();
        $news = News::find()->where(['news_check' => 0])->count();
        $newsComment = NewsComment::find()->where(['news_comment_check' => 0])->count();
        $review = Review::find()->where(['review_check' => 0])->count();
        $support = Message::find()->where(['message_support' => 1, 'message_read' => 0])->count();
        $transferComment = TransferComment::find()->where(['transfer_comment_check' => 0])->count();
        $vote = Vote::find()->where(['vote_vote_status_id' => VoteStatus::NEW])->count();

        $countModeration = 0;
        $countModeration = $countModeration + $forumMessage;
        $countModeration = $countModeration + $gameComment;
        $countModeration = $countModeration + $loanComment;
        $countModeration = $countModeration + $news;
        $countModeration = $countModeration + $newsComment;
        $countModeration = $countModeration + $transferComment;
        $countModeration = $countModeration + $review;

        list($paymentCategories, $paymentData) = Payment::getPaymentHighChartsData();

        $paymentArray = Payment::find()
            ->with([
                'user' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['user_id', 'user_login']);
                }
            ])
            ->select(['payment_date', 'payment_sum', 'payment_user_id'])
            ->where(['payment_status' => Payment::PAID])
            ->limit(10)
            ->orderBy(['payment_id' => SORT_DESC])
            ->all();

        $this->view->title = 'Admin';

        return $this->render('index', [
            'complaint' => $complaint,
            'countModeration' => $countModeration,
            'forumMessage' => $forumMessage,
            'freeTeam' => $freeTeam,
            'gameComment' => $gameComment,
            'loanComment' => $loanComment,
            'logo' => $logo,
            'news' => $news,
            'newsComment' => $newsComment,
            'paymentArray' => $paymentArray,
            'paymentCategories' => $paymentCategories,
            'paymentData' => $paymentData,
            'review' => $review,
            'support' => $support,
            'transferComment' => $transferComment,
            'vote' => $vote,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            $this->layout = 'login';
            $this->view->title = 'Login';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}