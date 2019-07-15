<?php

namespace frontend\controllers;

use common\models\User;
use Exception;
use frontend\models\OAuthFacebook;
use frontend\models\OAuthGoogle;
use frontend\models\OAuthVk;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class SocialController
 * @package frontend\controllers
 */
class SocialController extends AbstractController
{
    const FACEBOOK = 'fb';
    const GOOGLE = 'gl';
    const TWITTER = 'tw';
    const VK = 'vk';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $id
     * @return Response
     * @throws Exception
     */
    public function actionConnect(string $id): Response
    {
        $oauthId = '';
        $field = '';

        if (self::GOOGLE == $id) {
            $oauthId = OAuthGoogle::getId('connect');
            $field = 'user_social_google_id';
        } elseif (self::FACEBOOK == $id) {
            $oauthId = OAuthFacebook::getId('connect');
            $field = 'user_social_facebook_id';
        } elseif (self::VK == $id) {
            $oauthId = OAuthVk::getId('connect');
            $field = 'user_social_vk_id';
        }

        if (!$oauthId) {
            $this->setErrorFlash();
            return $this->redirect(['user/social']);
        }

        $user = User::find()
            ->select(['user_id'])
            ->where([$field => $oauthId])
            ->andWhere(['!=', 'user_id', $this->user->user_id])
            ->one();
        if ($user) {
            $this->setErrorFlash('Этот профиль уже используется другим пользователем');
            return $this->redirect(['user/social']);
        }

        $this->user->$field = $oauthId;
        $this->user->save(true, [
            $field,
        ]);

        $this->setSuccessFlash();
        return $this->redirect(['user/social']);
    }

    /**
     * @param string $id
     * @return Response
     * @throws Exception
     */
    public function actionDisconnect(string $id): Response
    {
        $field = '';

        if (self::GOOGLE == $id) {
            $field = 'user_social_google_id';
        } elseif (self::FACEBOOK == $id) {
            $field = 'user_social_facebook_id';
        } elseif (self::VK == $id) {
            $field = 'user_social_vk_id';
        }

        $this->user->$field = '';
        $this->user->save(true, [
            $field,
        ]);

        $this->setSuccessFlash();
        return $this->redirect(['user/social']);
    }

    /**
     * @param string $id
     * @return Response
     */
    public function actionLogin(string $id)
    {
        $oauthId = '';
        $field = '';

        if (self::GOOGLE == $id) {
            $oauthId = OAuthGoogle::getId('login');
            $field = 'user_social_google_id';
        } elseif (self::FACEBOOK == $id) {
            $oauthId = OAuthFacebook::getId('login');
            $field = 'user_social_facebook_id';
        } elseif (self::VK == $id) {
            $oauthId = OAuthVk::getId('login');
            $field = 'user_social_vk_id';
        }

        if (!$oauthId) {
            $this->setErrorFlash('Пользователь с такой учётной записью не найден');
            return $this->redirect(['site/login']);
        }

        $user = User::find()
            ->where([$field => $oauthId])
            ->one();
        if (!$user) {
            $this->setErrorFlash('Пользователь с такой учётной записью не найден');
            return $this->redirect(['site/login']);
        }

        Yii::$app->user->login($user, 2592000);
        return $this->redirect(['team/view']);
    }
}
