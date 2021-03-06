<?php

namespace frontend\models;

use common\models\Logo;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class TeamLogo
 * @package frontend\models
 *
 * @property UploadedFile $file
 * @property int $teamId
 * @property string $text
 */
class TeamLogo extends Model
{
    public $file;
    public $teamId;
    public $text;

    /**
     * TeamLogo constructor.
     * @param int $teamId
     * @param array $config
     */
    public function __construct($teamId, array $config = [])
    {
        parent::__construct($config);
        $this->teamId = $teamId;
    }

    /**
     * @return array
     */
    public function rules(): array
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
            [['text', 'file'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Эмблема',
            'text' => 'Чем новая эмблема лучше старой',
        ];
    }

    /**
     * @return bool
     * @throws \Exception
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
            ->where(['logo_team_id' => $this->teamId])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new Logo();
            $model->logo_team_id = $this->teamId;
        }
        $model->logo_text = $this->text;
        $model->save();

        $this->file->saveAs(Yii::getAlias('@webroot') . '/upload/img/team/125/' . Yii::$app->request->get('id') . '.' . $this->file->extension);

        return true;
    }
}
