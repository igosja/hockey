<?php

namespace frontend\models;

use Yii;
use yii\helpers\Json;

/**
 * Class OAuthVk
 * @package frontend\models
 */
class OAuthVk
{
    const ID = '7056692';
    const SERVICE = '802e0f75802e0f75802e0f755c8045a2418802e802e0f75dd055efcbdad26ee66104dc4';
    const SECRET = '4k6HqKFHXRtniCTqYHDG';
    const URL_AUTH = 'http://oauth.vk.com/authorize';
    const URL_TOKEN = 'https://oauth.vk.com/access_token';

    /**
     * @return string
     */
    public static function getConnectUrl(): string
    {
        $params = [
            'client_id' => self::ID,
            'redirect_uri' => 'http://lvh.me/social/connect/vk',
            'response_type' => 'code'
        ];

        return self::URL_AUTH . '?' . urldecode(http_build_query($params));
    }

    public static function getId()
    {
        $code = Yii::$app->request->get('code');

        if (!$code) {
            return '';
        }

        $redirectUri = 'http://lvh.me/social/connect/vk';

        $params = [
            'client_id' => self::ID,
            'client_secret' => self::SECRET,
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ];

        $tokenInfo = Json::decode(file_get_contents(self::URL_TOKEN . '?' . urldecode(http_build_query($params))));
        if (!isset($tokenInfo['user_id'])) {
            return '';
        }

        return $tokenInfo['user_id'];
    }
}
