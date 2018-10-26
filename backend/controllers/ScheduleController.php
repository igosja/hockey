<?php

namespace backend\controllers;

use common\models\Schedule;

/**
 * Class ScheduleController
 * @package backend\controllers
 */
class ScheduleController extends BaseController
{
    /**
     * @param int|null $id
     * @return string|\yii\web\Response
     */
    public function actionIndex(int $id = null)
    {
        if ($id) {
            Schedule::updateAllCounters(['schedule_date' => 86400 * $id]);
            return $this->redirect(['schedule/index']);
        }

        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->limit(1)
            ->one();

        $this->view->title = 'Перевести время';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'schedule' => $schedule,
        ]);
    }
}
