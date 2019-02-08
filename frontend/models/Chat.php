<?php

namespace frontend\models;

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\User;
use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\Json;

/**
 * Class Chat
 * @package frontend\models
 *
 * @property string $text
 */
class Chat extends Model
{
    const MAX_LENGTH = 100;

    /**
     * @var string $text
     */
    public $text;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['text'], 'trim'],
            [['text'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Сообщение',
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        /**
         * @var User $user
         */
        $user = Yii::$app->user->identity;

        if (!$user->user_date_confirm) {
            return false;
        }
        if ($user->user_date_block_comment > time()) {
            return false;
        }

        $file = Yii::getAlias('@webroot') . '/chat.txt';

        try {
            $content = file_get_contents($file);
        } catch (Exception $e) {
            $content = false;
        }

        if ($content) {
            $content = Json::decode($content);
        } else {
            $content = [];
        }

        $chat = fopen($file, "w");

        $content[] = [
            'date' => time(),
            'text' => HockeyHelper::clearBbCodeBeforeSave($this->text),
            'userId' => $user->user_id,
            'userLink' => $user->userLink(['data-pjax' => 0, 'target' => '_blank']),
        ];

        if (count($content) > self::MAX_LENGTH) {
            $content = array_slice($content, -self::MAX_LENGTH, self::MAX_LENGTH);
        }

        $text = Json::encode($content);
        fwrite($chat, $text);
        fclose($chat);

        return true;
    }

    /**
     * @param int $lastDate
     * @return array|bool
     */
    public function chatArray($lastDate = 0)
    {
        $file = Yii::getAlias('@webroot') . '/chat.txt';
        try {
            $content = file_get_contents($file);
        } catch (Exception $e) {
            $content = false;
        }
        if (!$content) {
            return false;
        }
        $content = Json::decode($content);
        $result = [
            'date' => 0,
            'message' => [],
        ];
        foreach ($content as $value) {
            if ($value['date'] > $lastDate) {
                $result['message'][] = [
                    'class' => $value['userId'] == Yii::$app->user->id ? 'message-from-me' : 'message-to-me',
                    'date' => FormatHelper::asDateTime($value['date']),
                    'text' => HockeyHelper::bbDecode($value['text']),
                    'userId' => $value['userId'],
                    'userLink' => $value['userLink'],
                ];
            }
        }
        if (isset($value)) {
            $result['date'] = $value['date'];
        }
        return $result;
    }
}
