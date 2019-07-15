<?php

namespace frontend\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;

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
     * @param string $redirectUrl
     * @return string
     */
    public static function getConnectUrl(string $redirectUrl): string
    {
        $params = [
            'client_id' => self::ID,
            'redirect_uri' => Url::to(['social/' . $redirectUrl, 'id' => 'vk'], true),
            'response_type' => 'code'
        ];

        return self::URL_AUTH . '?' . urldecode(http_build_query($params));
    }

    /**
     * @param string $redirectUrl
     * @return string
     */
    public static function getId(string $redirectUrl)
    {
        $code = Yii::$app->request->get('code');

        if (!$code) {
            return '';
        }

        $params = [
            'client_id' => self::ID,
            'client_secret' => self::SECRET,
            'code' => $code,
            'redirect_uri' => Url::to(['social/' . $redirectUrl, 'id' => 'vk'], true),
        ];

        $tokenInfo = Json::decode(file_get_contents(self::URL_TOKEN . '?' . urldecode(http_build_query($params))));
        if (!isset($tokenInfo['user_id'])) {
            return '';
        }

        return $tokenInfo['user_id'];
    }
}
