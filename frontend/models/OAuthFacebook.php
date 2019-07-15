<?php

namespace frontend\models;

use Yii;
use yii\helpers\Json;

/**
 * Class OAuthFacebook
 * @package frontend\models
 */
class OAuthFacebook
{
    const ID = '2534206653296281';
    const SECRET = '896771d7bda40410d95c63a63c55a4dc';
    const URL_AUTH = 'https://www.facebook.com/dialog/oauth';
    const URL_TOKEN = 'https://graph.facebook.com/oauth/access_token';
    const URL_USER_INFO = 'https://graph.facebook.com/me';

    /**
     * @return string
     */
    public static function getConnectUrl(): string
    {
        $redirectUri = 'http://lvh.me/social/connect/fb';

        $params = [
            'client_id' => self::ID,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
        ];

        return self::URL_AUTH . '?' . urldecode(http_build_query($params));
    }

    public static function getId()
    {
        $code = Yii::$app->request->get('code');

        if (!$code) {
            return '';
        }

        $redirectUri = 'http://lvh.me/social/connect/fb';

        $params = [
            'client_id' => self::ID,
            'redirect_uri' => $redirectUri,
            'client_secret' => self::SECRET,
            'code' => $code,
        ];

        $tokenInfo = Json::decode(file_get_contents(self::URL_TOKEN . '?' . urldecode(http_build_query($params))));
        if (!isset($tokenInfo['access_token'])) {
            return '';
        }

        $params = [
            'access_token' => $tokenInfo['access_token'],
        ];

        $userInfo = Json::decode(file_get_contents(self::URL_USER_INFO . '?' . urldecode(http_build_query($params))));
        if (!isset($userInfo['id'])) {
            return '';
        }

        return $userInfo['id'];
    }
}
