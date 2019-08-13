<?php

namespace frontend\models;

use common\components\ErrorHelper;
use common\models\ForumMessage;
use common\models\ForumTheme;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Class ForumThemeForm
 * @package frontend\models
 *
 * @property string $name
 * @property string $text
 * @property int $themeId
 */
class ForumThemeForm extends Model
{
    public $name;
    public $text;
    private $themeId;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'text'], 'trim'],
            [['name', 'text'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param int $id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function create($id)
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $theme = new ForumTheme();
            $theme->forum_theme_forum_group_id = $id;
            $theme->forum_theme_name = $this->name;
            $theme->forum_theme_user_id = Yii::$app->user->id;
            $theme->save();

            $message = new ForumMessage();
            $message->forum_message_forum_theme_id = $theme->forum_theme_id;
            $message->forum_message_text = $this->text;
            $message->forum_message_user_id = Yii::$app->user->id;
            $message->save();

            $transaction->commit();

            $this->themeId = $theme->forum_theme_id;
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'text' => 'Текст',
        ];
    }

    /**
     * @return int
     */
    public function getThemeId()
    {
        return $this->themeId;
    }
}
