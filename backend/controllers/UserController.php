<?php

namespace backend\controllers;

use backend\models\UserSearch;
use common\models\User;
use Yii;

/**
 * Class UserController
 * @package backend\controllers
 */
class UserController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $userArray = User::find()
            ->where(['>', 'user_id', 1])
            ->all();
        print '<pre>';
        foreach ($userArray as $user) {
            print '[\''
                . $user->user_code
                . '\', HockeyHelper::unixTimeStamp(), \''
                . $user->user_email
                . '\', \''
                . $user->user_login
                . '\', \''
                . $user->user_password
                . '\'],<br/>';
        }
        exit;
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $this->view->title = 'Пользователи';
        $this->view->params['breadcrumbs'][] = $this->view->title;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
