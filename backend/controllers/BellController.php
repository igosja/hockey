<?php

namespace backend\controllers;

use common\models\Complaint;
use common\models\Logo;
use common\models\Support;
use common\models\Team;
use common\models\Vote;
use common\models\VoteStatus;
use Yii;
use yii\web\Response;

/**
 * Class BellController
 * @package backend\controllers
 */
class BellController extends BaseController
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
        $support = Support::find()->where(['support_user_id_to' => 0, 'support_read' => 0])->count();
        $vote = Vote::find()->where(['vote_vote_status_id' => VoteStatus::NEW])->count();

        $bell = $support + $vote + $logo + $complaint;


        if (0 == $bell) {
            $bell = '';
        }

        if (0 == $complaint) {
            $complaint = '';
        }

        if (0 == $logo) {
            $logo = '';
        }

        if (0 == $support) {
            $support = '';
        }

        if (0 == $vote) {
            $vote = '';
        }

        return [
            'bell' => $bell,
            'complaint' => $complaint,
            'freeTeam' => $freeTeam,
            'logo' => $logo,
            'support' => $support,
            'vote' => $vote,
        ];
    }
}
