<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;

/**
 * Class ForumController
 * @package backend\controllers
 */
class ForumController extends AbstractController
{
    /**
     * @param $id
     * @return Response
     */
    public function actionMessageUpdate($id)
    {
        Yii::$app->request->setBaseUrl('');
        return $this->redirect(['forum/message-update', 'id' => $id]);
    }
}
