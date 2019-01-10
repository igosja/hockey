<?php

namespace common\components;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller as BaseController;
use yii\web\NotFoundHttpException;

/**
 * Class Controller
 * @package common\components
 */
class Controller extends BaseController
{
    /**
     * @param ActiveRecord|null $model
     * @throws NotFoundHttpException
     */
    protected function notFound(ActiveRecord $model = null)
    {
        if (!$model) {
            throw new NotFoundHttpException('Страница не найдена');
        }
    }

    /**
     * @param string $text
     * @return void
     */
    protected function setSuccessFlash($text = 'Изменения успешно сохранены')
    {
        Yii::$app->session->setFlash('success', $text);
    }

    /**
     * @param string $text
     * @return void
     */
    protected function setErrorFlash($text = 'Не удалось сохранить данные')
    {
        Yii::$app->session->setFlash('error', $text);
    }
}
