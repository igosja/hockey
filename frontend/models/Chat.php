<?php

namespace frontend\models;

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
    public function rules(): array
    {
        return [
            [['text'], 'trim'],
            [['text'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
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

        $file = Yii::getAlias('@webroot') . '/chat.txt';
        $content = file_get_contents($file);

        if ($content) {
            $content = Json::decode($content);
        } else {
            $content = [];
        }

        $chat = fopen($file, "w");

        $content[] = [
            'date' => time(),
            'text' => $this->text,
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
     * @return false|string
     */
    public function chatArray()
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
        return $content;
    }
}
