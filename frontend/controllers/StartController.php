<?php

namespace frontend\controllers;

use common\models\User;
use Yii;

/**
 * Class StartController
 * @package frontend\controllers
 */
class StartController extends AbstractController
{
    /**
     * @return void
     */
    public function actionIndex()
    {
        $userArray = User::find()
            ->where(['!=', 'user_id', 0])
            ->all();
        foreach ($userArray as $user) {
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'signUp-html', 'text' => 'signUp-text'],
                    ['model' => $user]
                )
                ->setTo($user->user_email)
                ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['noReplyName']])
                ->setSubject('Регистрация на сайте Виртуальной Хоккейной Лиги')
                ->send();

            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'default-html', 'text' => 'default-text'],
                    ['text' => '
                        <p>Рады сообщить Вам, что с этого момента наш сайт virtual-hockey.org начинает свою работу!</p>
                        <p>Вы можете подать заявку на любую свободную команду, дождаться ее одобрения и приступить к игре.</p>
                        <p>надеемся на плодотворное сотрудничество.</p>'
                    ]
                )
                ->setTo($user->user_email)
                ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->params['noReplyName']])
                ->setSubject('Начало работы сайта Виртуальной Хоккейной Лиги')
                ->send();
        }
    }
}
