<?php

namespace backend\controllers;

use common\models\Complaint;
use common\models\Logo;
use common\models\Poll;
use common\models\PollStatus;
use common\models\Support;
use common\models\Team;
use Yii;
use yii\web\Response;

/**
 * Class BellController
 * @package backend\controllers
 */
class BellController extends AbstractController
{
    /**
     * @return array
     */
    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $complaint = Complaint::find()->count();
        $freeTeam = Team::find()->where(['team_user_id' => 0])->andWhere(['!=', 'team_id', 0])->count();
        $logo = Logo::find()->count();
        $poll = Poll::find()->where(['poll_poll_status_id' => PollStatus::NEW])->count();
        $support = Support::find()->where(['support_question' => 1, 'support_read' => 0])->count();

        $bell = $support + $poll + $logo + $complaint;

        if (0 == $bell) {
            $bell = '';
        }

        if (0 == $complaint) {
            $complaint = '';
        }

        if (0 == $logo) {
            $logo = '';
        }

        if (0 == $poll) {
            $poll = '';
        }

        if (0 == $support) {
            $support = '';
        }

        return [
            'bell' => $bell,
            'complaint' => $complaint,
            'freeTeam' => $freeTeam,
            'logo' => $logo,
            'poll' => $poll,
            'support' => $support,
        ];
    }
}
