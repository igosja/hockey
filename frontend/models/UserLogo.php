<?php

namespace frontend\models;

use common\models\Logo;
use Exception;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UserLogo
 * @package frontend\models
 *
 * @property UploadedFile $file
 * @property int $userId
 */
class UserLogo extends Model
{
    public $file;
    public $userId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['file'],
                'image',
                'extensions' => 'png',
                'maxHeight' => 125,
                'maxWidth' => 100,
                'minHeight' => 125,
                'minWidth' => 100
            ],
            [['file'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Фото',
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function upload()
    {
        if (!$this->load(Yii::$app->request->post())) {
            return false;
        }
        $this->file = UploadedFile::getInstance($this, 'file');
        if (!$this->validate()) {
            return false;
        }

        $model = Logo::find()
            ->where(['logo_team_id' => 0, 'logo_user_id' => $this->userId])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new Logo();
            $model->logo_team_id = 0;
        }
        $model->logo_text = '-';
        $model->save();

        $this->file->saveAs(Yii::getAlias('@webroot') . '/upload/img/user/125/' . Yii::$app->request->get('id') . '.' . $this->file->extension);

        return true;
    }
}
